<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Subscriptions;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $subscriptions = Subscriptions::all();

        return view('subscriptions.index', ['services' => $subscriptions]);
    }

    public function new()
    {
        $clients = Client::all();
        $last = Subscriptions::all()->last();
        $lastNum = 999;
        if($last) {
            $lastNum = $last->subscription_number;
        }

        return view('subscriptions.new', ['clients' => $clients, 'num' => $lastNum+1]);
    }

    public function store(Request $request)
    {
        DB::table('subscriptions')->insert(
            [
                'subscription_number' => $request->subscription_number,
                'hashID' => Str::substr(Str::slug(Hash::make( $request->client.date('Y-m-d'))), 0, 32),
                'client_hash' => $request->client,
                'service_title' => $request->service_title,
                'service_type' => $request->service_type,
                'service_domain' => $request->service_domain,
                'service_duration' => $request->service_duration,
                'active_subscription' => $request->active_subscription,
                'first_payment' => $request->first_payment,
                'duration_price' => $request->duration_price,
                'created_at' => date('Y-m-d')
            ]
        );

        Session::flash('notify', 'Η συνδρομή καταχωρήθηκε με επιτυχία');
        return redirect()->route('subscriptions.view');
    }

    public function edit(Subscriptions $service)
    {
        //dd($service);
        $clients = Client::all();
        return view('subscriptions.new', ['clients' => $clients, 'service' => $service]);
    }

    public function update(Request $request, Subscriptions $service)
    {
        //dd($request);
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->first_payment);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->first_payment);
        }

        $date = $requestDate->format('Y-m-d');

        $service->update([
            'client_hash' => $request->client,
            'service_title' => $request->service_title,
            'service_type' => $request->service_type,
            'service_domain' => $request->service_domain,
            'first_payment' => $date,
            'service_duration' => $request->service_duration,
            'active_subscription' => $request->active_subscription,
            'duration_price' => $request->duration_price
        ]);
        $service->save();

        Session::flash('notify', 'Η συνδρομή ενημερώθηκε με επιτυχία');
        return redirect()->route('subscriptions.view');
    }
}
