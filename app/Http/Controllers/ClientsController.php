<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddresses;
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
use SoapClient;

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
        $edra = ClientAddresses::query()->where('client_hash', '=', $hashID)->where('address_type', '=', 0)->first();
        //dd($edra);

        return view('clients.view', ['client' => $client, 'invoices' => $invoices, 'sale_invoices' => $saleInvoices, 'services' => $services, 'servicesNew' => $servicesNew, 'edra' => $edra]);
    }

    public function new()
    {
        return view('clients.add');
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

        //dd($request);
        $client->update([
            "name" => $request->name,
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
            foreach ($request->addresses as $address) {
                //dd($address);
                if (isset($address->address_id)) {
                    $oldAddress = ClientAddresses::query()->where('id', '=', $address->address_id)->first();
                    $oldAddress->update([
                        "address_name" => $address['type'],
                        "address" => $address['address'],
                        "number" => $address['number'],
                        "city" => $address['city'],
                        "postal_code" => $address['postal_code'],
                        "updated_at" => date('Y-m-d H:i:s')
                    ]);
                } else {
                    //dd($address['address']);
                    ClientAddresses::create([
                        "client_hash" => $client->hashID,
                        "address_type" => $lastAddress->address_type + 1,
                        "address_name" => $address['address_type'],
                        "address" => $address['address'],
                        "number" => $address['number'],
                        "city" => $address['city'],
                        "postal_code" => $address['postal_code'],
                        "created_at" => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        Session::flash('message', 'Η καρτέλα πελάτη καταχωρήθηκε με επιτυχία');

        return redirect()->back();
    }

    public function edit($vat)
    {
        $client = Client::query()->where('vat', '=', $vat)->first();
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
        $xmlBodyContent = '<env:Envelope xmlns:env="http://www.w3.org/2003/05/soap-envelope"
        xmlns:ns1="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
        xmlns:ns2="http://rgwspublic2/RgWsPublic2Service" xmlns:ns3="http://rgwspublic2/RgWsPublic2">
   <env:Header>
      <ns1:Security>
         <ns1:UsernameToken>
            <ns1:Username>WW1471871U379</ns1:Username>
            <ns1:Password>WW1471871U379</ns1:Password>
         </ns1:UsernameToken>
      </ns1:Security>
   </env:Header>
   <env:Body>
      <ns2:rgWsPublic2AfmMethod>
         <ns2:INPUT_REC>
            <ns3:afm_called_by/>
            <ns3:afm_called_for>'.$request->vat.'</ns3:afm_called_for>
         </ns2:INPUT_REC>
      </ns2:rgWsPublic2AfmMethod>
   </env:Body>
</env:Envelope>';
        $http = Http::withHeaders([
            'Content-Type'=>'application/xml'
        ])->post('https://www1.gsis.gr/wsaade/RgWsPublic2/RgWsPublic2?WSDL', [$xmlBodyContent]);



        return response($http->body())
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ]);
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

}
