<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddresses;
use App\Models\DeliveryInvoices;
use App\Models\Invoice;
use App\Models\SaleInvoices;
use App\Models\Services;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use nusoap_client;
use SoapClient;
use SoapHeader;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all()->sortBy('code_number');

        return view('clients.index', ['clients' => $clients]);
    }

    public function view($hashID)
    {

        $client = Client::query()->where('hashID', '=', $hashID)->first();
        $invoices = Invoice::query()->where('client_id', '=', $client->id)->get()->sortByDesc('date')->take(10);
        $services = Services::query()->where('client_id', '=', $client->id)->where('invoice_number', '!=', '')->get()->sortByDesc('date');
        $servicesNew = Services::query()->where('client_id', '=', $client->id)->where('invoice_number', '=', NULL)->get();
        $saleInvoices = SaleInvoices::query()->where('client_id', '=', $client->id)->get()->sortByDesc('date');
        $deliveryInvoices = DeliveryInvoices::query()->where('client_id', '=', $client->id)->get()->sortByDesc('date');
        $edra = ClientAddresses::query()->where('client_hash', '=', $hashID)->where('address_type', '=', 0)->first();
        //dd($deliveryInvoices);

        return view('clients.view', ['client' => $client, 'invoices' => $invoices, 'sale_invoices' => $saleInvoices, 'delievry_invoices' => $deliveryInvoices, 'services' => $services, 'servicesNew' => $servicesNew, 'edra' => $edra]);
    }

    public function new()
    {
        $lastClient = Client::latest('code_number')->first();

        if($lastClient) {
            $last = $lastClient->code_number + 1;
        } else {
            $last = '';
        }
        return view('clients.add', ['last' => $last]);
    }

    public function store(Request $request)
    {
        $hash = Str::substr(Str::slug(Hash::make($request->company . $request->vat)), 0, 32);
        DB::table('clients')->insert(
            array(
                'name' => $request->name,
                'hashID' => $hash,
                'code_number' => $request->code_number,
                'company' => $request->company,
                'work_title' => $request->work_title,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'phone' => $request->phone,
                'vat' => $request->vat,
                'doy' => $request->doy,
                'mail_account' => $request->mail_account,
                'phone_account' => $request->phone_account,
                'created_at' => date('Y-m-d')
            )
        );

        DB::table('client_addresses')->insert(
            array(
                'client_hash' => $hash,
                'address_type' => 0,
                'address_name' => 'Έδρα',
                'address' => $request->address,
                'number' => $request->number,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
                'created_at' => date('Y-m-d')
            )
        );

        Session::flash('message', 'Ο πελάτης καταχωρήθηκε με επιτυχία');

        return Redirect::to('clients');
    }

    public function update(Request $request, Client $client)
    {
        $client->update([
            "name" => $request->name,
            "code_number" => $request->code_number,
            "company" => $request->company,
            "work_title" => $request->work_title,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "phone" => $request->phone,
            "vat" => $request->vat,
            "doy" => $request->doy,
            "mail_account" => $request->mail_account,
            "phone_account" => $request->phone_account
        ]);
        $lastAddress = ClientAddresses::query()->where('client_hash', '=', $client->hashID)->latest('address_type')->first();
        //dd($lastAddress->address_type);
        if ($request->addresses) {
            //dd($request->addresses);
            foreach ($request->addresses as $add) {
                if($add['address']) {
                    if (isset($add->address_id)) {
                        $oldAddress = ClientAddresses::query()->where('id', '=', $add->address_id)->first();
                        $oldAddress->update([
                            "address_name" => $add['type'],
                            "address" => $add['address'],
                            "number" => $add['number'],
                            "city" => $add['city'],
                            "postal_code" => $add['postal_code'],
                            "updated_at" => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        //dd($address['address']);
                        ClientAddresses::create([
                            "client_hash" => $client->hashID,
                            "address_type" => $lastAddress->address_type + 1,
                            "address_name" => $add['address_type'],
                            "address" => $add['address'],
                            "number" => $add['number'],
                            "city" => $add['city'],
                            "postal_code" => $add['postal_code'],
                            "created_at" => date('Y-m-d H:i:s')
                        ]);
                    }
                }

            }
        }

        Session::flash('message', 'Η καρτέλα πελάτη καταχωρήθηκε με επιτυχία');

        return redirect()->back();
    }

    public function edit($clientHash)
    {
        $client = Client::query()->where('hashID', '=', $clientHash)->first();
        $edra = ClientAddresses::query()->where('client_hash', '=', $client->hashID)->where('address_type', '=', 0)->first();

        return view('clients.add', ['client' => $client, 'edra' => $edra]);
    }

    public function softDelete($hashID)
    {

        $client = Client::query()->where('hashID', '=', $hashID)->first();
        $clientInvoices = Invoice::query()->where('client_id', '=', $client->id)->get();

        if (count($clientInvoices) > 0) {
            $client->update(['disabled' => 1]);
            Session::flash('notify', "Ο πελάτης δεν ήταν δυνατό να διαγραφεί καθώς υπάρχουν καταχωρημένα παραστατικά που τον αφορούν. Παρ' όλ' αυτά, η εγγραφή απενεργοποιήθηκε.");
        } else {
            $client->forceDelete();
            Session::flash('notify', "Ο πελάτης διαγράφηκε με επιτυχία.");
        }

        return redirect('clients');
    }

    public function deleteAddress(Request $request)
    {

        $add = ClientAddresses::query()->where('id','=', $request->id)->first();

        $add->delete();

        return 'Η διεύθυνση διαγράφηκε με επιτυχία';
    }

    public function enable($vat)
    {
        $client = Client::query()->where('vat', '=', $vat)->first();
        $client->update(['disabled' => 0]);

        Session::flash('notify', "Ο πελάτης ενεργοποιήθηκε με επιτυχία.");
        return redirect('clients');
    }

    public function getAddress(Request $request) {

        $adds = getClientAddresses($request->client);

            return $adds;
    }

    public function vatCheck(Request $request)
    {
        return checkVatVies($request->vat);
    }

    public function search(Request $request)
    {
        $clients = Client::query()
        ->where('company', 'LIKE', '%'.$request->ask.'%')
        ->orWhere('vat', 'LIKE', '%'.$request->ask.'%')
        ->orWhere('code_number', '=', $request->ask)
            ->get();

        return $clients;
    }

    public function invoices(Request $request)
    {
        $client = Client::query()->where('hashID', '=', $request->client)->first();

        return $client->invoices()->where('date', '>=', date('Y').'-01-01')->orderBy('date', 'desc')->get();
    }

}
