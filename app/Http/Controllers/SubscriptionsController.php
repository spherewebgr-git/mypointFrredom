<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Subscriptions;
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
        $last = Subscriptions::all()->last()->subscription_number;

        return view('subscriptions.new', ['clients' => $clients, 'num' => $last+1]);
    }

    public function store(Request $request)
    {
        //dd($request);

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
}
