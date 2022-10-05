<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ServicesController extends Controller
{
    public function storeService(Request $request, Client $client)
    {
        // dd($client);
        DB::table('services')->insert(
            array(
                'client_id' => $client->id,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'description' => $request->description
            )
        );

        return back();
    }

    public function addToInvoice(Request $request, Client $client)
    {

        foreach($request->services as $key => $value) {
            $servicesIds[] = $key;
        }
        $lastInvoice = Invoice::all()->sortBy('invoiceID')->last()->invoiceID;
        $clients = Client::all()->sortBy('company');
        $services = Services::whereIn('id', $servicesIds)->get();

        return view('invoices.new-with-services', ['last' => $lastInvoice, 'clients' => $clients, 'cli' => $client, 'services' => $services]);
    }
}
