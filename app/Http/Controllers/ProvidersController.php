<?php

namespace App\Http\Controllers;

use App\Models\Outcomes;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProvidersController extends Controller
{
    public function index()
    {
        $providers = Provider::all()->sortBy('provider_id');

        return view('providers.index', ['providers' => $providers]);
    }

    public function new()
    {
        $last = Provider::all()->last();
        if ($last) {
            $lastProvider = $last->provider_id + 1;
        } else {
            $lastProvider = 10501;
        }

        return view('providers.add', ['number' => $lastProvider]);
    }

    public function store(Request $request)
    {
        DB::table('providers')->insert(
            array(
                'provider_id' => $request->provider_id,
                'provider_name' => $request->provider_name,
                'address' => $request->address,
                'address_number' => $request->address_number,
                'address_tk' => $request->address_tk,
                'city' => $request->city,
                'provider_vat' => $request->provider_vat,
                'provider_doy' => $request->provider_doy,
                'email' => $request->email,
                'phone' => $request->phone,
                'created_at' => Carbon::now()
            )
        );

        Session::flash('message', 'Ο προμηθευτής καταχωρήθηκε με επιτυχία');
        return Redirect::to('providers');
    }

    public function view($vat)
    {
        $provider = Provider::query()->where('provider_vat', '=', $vat)->get()->first();
        //dd($provider);

        return view('providers.view', ['provider' => $provider]);
    }

    public function edit($vat)
    {
        $provider = Provider::query()->where('provider_vat', '=', $vat)->get()->first();
        //dd($provider);

        return view('providers.add', ['provider' => $provider]);
    }

    public function update(Request $request, Provider $provider)
    {
        $provider->update([
            'provider_name' => $request->provider_name,
            'address' => $request->address,
            'address_number' => $request->address_number,
            'address_tk' => $request->address_tk,
            'city' => $request->city,
            'provider_vat' => $request->provider_vat,
            'provider_doy' => $request->provider_doy,
            'email' => $request->email,
            'phone' => $request->phone,
            'updated_at' => Carbon::now()
        ]);

        Session::flash('notify', 'Η καρτέλα προμηθευτή ενημερώθηκε');

        return redirect()->back();
    }

    public function softDelete($vat)
    {

        $provider = Provider::query()->where('provider_vat', '=', $vat)->first();
        $providerOutcomes = Outcomes::query()->where('shop', '=', $vat)->get();

        if (count($providerOutcomes) > 0) {
            $provider->update(['disabled' => 1]);
            Session::flash('notify', "Ο προμηθευτής δεν ήταν δυνατό να διαγραφεί καθώς υπάρχουν καταχωρημένα παραστατικά εξόδων που τον αφορούν. Παρ' όλ' αυτά, η εγγραφή απενεργοποιήθηκε.");
        } else {
            $provider->forceDelete();
            Session::flash('notify', "Ο προμηθευτής διαγράφηκε με επιτυχία.");
        }

        return redirect('providers');
    }

    public function search(Request $request)
    {
        $providers = Provider::query()
            ->where('provider_name', 'LIKE', '%'.$request->ask.'%')
            ->orWhere('provider_vat', 'LIKE', '%'.$request->ask.'%')
            ->orWhere('provider_id', '=', $request->ask)
            ->get();

        return $providers;
    }

    public function checkVat(Request $request) {

        $client = checkVatVies($request->vat);

        return($client);
    }

}
