<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Settings;
use App\Models\Subscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class NotificationsController extends Controller
{
    public function send($type, $hash)
    {
        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }
        switch ($type) {
            case 'subscription':
                $object = Subscriptions::query()->where('hashID', '=', $hash)->first();
                $data = [
                    'service' => $object->service_title,
                    'cost' => $object->duration_price,
                    'vat' =>  (24 / 100) * $object->duration_price,
                    'domain' => $object->service_domain,
                    'date' =>  Carbon::createFromFormat('Y-m-d', $object->first_payment)->format('d/m/Y'),
                    'duration' => $object->service_duration,
                    'settings' => $settings
                ];
                break;
            default :
                $data = [
                    'settings' => $settings
                ];
        }
        try {
            $client = $object->client;
            $subdomain = explode('.', request()->getHost());
            $email =  $subdomain[0].'@mypointapp.gr';

            Mail::send('emails.remind_notification', $data, function($message) use ($settings, $client, $email) {
                $message->to($client->email, $client->company);
                $message->subject('Ειδοποίηση για ανανέωση υπηρεσίας');
                $message->from($email, $settings['company'].' - '. $settings['title']);
            });

        } catch (\Exception $e) {
            return Redirect::back()->with('notify', $e->getMessage());
        }
        DB::table('notifications')->insert([
            'notification_type' => 'subscription_notification',
            'notification_action' => 'send_notification_to_client',
            'client_hash' => $client->hashID,
            'client_email' => $client->email,
            'last_notified_at' => date('Y-m-d H:i:s'),
            'status' => 'sent'
        ]);
        return redirect()->route('subscriptions.view')->with('notify', 'Ο πελάτης ενημερώθηκε με email στο '.$client->email);
    }
}
