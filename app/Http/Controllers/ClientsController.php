<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::all()->sortBy('company');

        return view('clients.index', ['clients' => $clients]);
    }

    public function view($hashID) {
        $client = Client::query()->where('hashID', '=', $hashID)->first();
        $invoices = Invoice::query()->where('client_id', '=', $client->id)->get()->sortByDesc('date')->take(10);
        $services = Services::query()->where('client_id', '=', $client->id)->where('invoice_number', '!=', '')->get()->sortByDesc('date');
        $servicesNew = Services::query()->where('client_id', '=', $client->id)->where('invoice_number', '=', NULL)->get();

        return view('clients.view', ['client' => $client, 'invoices' => $invoices, 'services' => $services, 'servicesNew' => $servicesNew]);
    }

    public function new()
    {
        return view('clients.add');
    }

    public function store(Request $request)
    {
        DB::table('clients')->insert(
            array(
                'name' => $request->name,
                'hashID' => Str::substr(Str::slug(Hash::make( $request->company.$request->vat)), 0, 32),
                'company' => $request->company,
                'work_title' => $request->work_title,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'phone' => $request->phone,
                'address' => $request->address,
                'number' => $request->number,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
                'vat' => $request->vat,
                'doy' => $request->doy,
                'mail_account' => $request->mail_account,
                'phone_account' => $request->phone_account
            )
        );

        Session::flash('message', 'Ο πελάτης καταχωρήθηκε με επιτυχία');
        return Redirect::to('clients');
    }

    public function update(Request $request, Client $client) {
        $client->update([
            "name" => $request->name,
            "company" => $request->company,
            "work_title" => $request->work_title,
            "email" => $request->email,
            "mobile" => $request->mobile,
            "phone" => $request->phone,
            "address" => $request->address,
            "city" => $request->city,
            "vat" => $request->vat,
            "doy" => $request->doy,
            "mail_account" => $request->mail_account,
            "phone_account" => $request->phone_account
        ]);

        Session::flash('message', 'Η καρτέλα πελάτη καταχωρήθηκε με επιτυχία');

        return redirect()->back();
    }

    public function edit($vat)
    {
        $client = Client::query()->where('vat', '=',  $vat)->first();

        return view('clients.add', ['client' => $client]);
    }

    public function softDelete($hashID) {

        $client = Client::query()->where('hashID', '=', $hashID)->first();
        $clientInvoices = Invoice::query()->where('client_id', '=', $client->id)->get();

        if(count($clientInvoices) > 0) {
            $client->update(['disabled' => 1]);
            Session::flash('notify', "Ο πελάτης δεν ήταν δυνατό να διαγραφεί καθώς υπάρχουν καταχωρημένα παραστατικά που τον αφορούν. Παρ' όλ' αυτά, η εγγραφή απενεργοποιήθηκε.");
        } else {
            $client->forceDelete();
            Session::flash('notify', "Ο πελάτης διαγράφηκε με επιτυχία.");
        }

        return redirect('clients');
    }

    public function enable($vat)
    {
        $client = Client::query()->where('vat', '=', $vat)->first();
        $client->update(['disabled' => 0]);

        Session::flash('notify', "Ο πελάτης ενεργοποιήθηκε με επιτυχία.");
        return redirect('clients');
    }
}
