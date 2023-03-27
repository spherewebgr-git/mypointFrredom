<?php

namespace App\Http\Controllers;

use App\Models\ForeignProviders;
use App\Models\Outcomes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ForeignProvidersController extends Controller
{
    public function index()
    {
        $providers = ForeignProviders::all()->sortBy('provider_id');

        return view('foreign-providers.index', ['providers' => $providers]);
    }

    public function new()
    {
        $last = ForeignProviders::all()->last();
        if($last) {
            $lastProvider = $last->provider_id + 1;
        } else {
            $lastProvider = 10501;
        }

        return view('foreign-providers.add', ['number' => $lastProvider]);
    }

    public function store(Request $request)
    {
        DB::table('foreign_providers')->insert(
            array(
                'provider_id' => $request->provider_id,
                'provider_name' => $request->provider_name,
                'address' => $request->address,
                'address_number' => $request->address_number,
                'address_tk' => $request->address_tk,
                'city' => $request->city,
                'country' => $request->country,
                'country_code' => $request->country_code,
                'provider_vat' => $request->provider_vat,
                'email' => $request->email,
                'created_at' => Carbon::now()
            )
        );

        Session::flash('message', 'Ο προμηθευτής καταχωρήθηκε με επιτυχία');
        return Redirect::to('foreign-providers');
    }

    public function view($vat)
    {
        $provider = ForeignProviders::query()->where('provider_vat', '=', $vat)->get()->first();
        //dd($provider);

        return view('foreign-providers.view', ['provider' => $provider]);
    }

    public function edit($vat)
    {
        $provider = ForeignProviders::query()->where('provider_vat', '=', $vat)->get()->first();
        //dd($provider);

        return view('foreign-providers.add', ['provider' => $provider]);
    }

    public function update(Request $request, ForeignProviders $provider) {
        $provider->update([
            'provider_id' => $request->provider_id,
            'provider_name' => $request->provider_name,
            'address' => $request->address,
            'address_number' => $request->address_number,
            'address_tk' => $request->address_tk,
            'city' => $request->city,
            'country' => $request->country,
            'country_code' => $request->country_code,
            'provider_vat' => $request->provider_vat,
            'email' => $request->email,
            'updated_at' => Carbon::now()
        ]);

        Session::flash('notify', 'Η καρτέλα προμηθευτή ενημερώθηκε');

        return redirect()->back();
    }

    public function softDelete($vat) {

        $provider = ForeignProviders::query()->where('provider_vat', '=', $vat)->first();
        $providerOutcomes = Outcomes::query()->where('shop', '=', $vat)->get();

        if(count($providerOutcomes) > 0) {
            $provider->update(['disabled' => 1]);
            Session::flash('notify', "Ο προμηθευτής δεν ήταν δυνατό να διαγραφεί καθώς υπάρχουν καταχωρημένα παραστατικά εξόδων που τον αφορούν. Παρ' όλ' αυτά, η εγγραφή απενεργοποιήθηκε.");
        } else {
            $provider->forceDelete();
            Session::flash('notify', "Ο προμηθευτής διαγράφηκε με επιτυχία.");
        }

        return redirect('foreign-providers');
    }

    public function search(Request $request)
    {
        $providers = ForeignProviders::query()
            ->where('provider_name', 'LIKE', '%'.$request->ask.'%')
            ->orWhere('provider_vat', 'LIKE', '%'.$request->ask.'%')
            ->orWhere('provider_id', '=', $request->ask)
            ->get();

        return $providers;
    }
}
