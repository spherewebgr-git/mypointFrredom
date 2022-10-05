<?php

namespace App\Http\Controllers;

use App\Models\Retails;
use App\Models\Settings;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RetailReceiptsController extends Controller
{
    public function index()
    {
        $finalRetails = [];
        $finalVat = [];
        $retail_receipts = Retails::all();
        foreach($retail_receipts as $retail) {
            $finalRetails[] = $retail->price;
            $finalVat[] = $retail->vat;
        }
        $final = array_sum($finalRetails);
        $vats = array_sum($finalVat);

        return view('retail_receipts.index', ['retails' => $retail_receipts, 'finals' => $final, 'vats' => $vats]);
    }

    public function new()
    {
        $lastInvoice = Retails::all()->sortBy('invoiceID')->last();
        if($lastInvoice) {
            $last = $lastInvoice->retailID;
        } else {
            $last = null;
        }
        return view('retail_receipts.new', ['last' => $last]);
    }

    public function store(Request $request)
    {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $vat = (24 / 100) * $request->price;

        DB::table('retails')->insert(
            array(
                'retailID' => $request->retailID,
                'hashID' => Str::substr(Str::slug(Hash::make( $date.$request->retailID)), 0, 32),
                'seira' => $request->seira,
                'date' => $date,
                'price' => $request->price,
                'vat' => $vat,
                'service' => $request->description,
                'description' => $request->mainDescription,
                'created_at' => Carbon::now()
            )
        );
        if(isset($request->printNow) && $request->printNow == 'on') {
            $retail_receipt = Retails::query()->where('retailID', '=' , $request->retailID )->first();
            $settings = Settings::all()->first();

            return view('retail_receipts.print', ['retail' => $retail_receipt, 'settings' => $settings]);
        }
        return view('retail_receipts.index');
    }

    public function edit(Retails $retail) {
        $retailReceipt = $retail->first();

        return view('retail_receipts.new', ['retail' => $retailReceipt] );
    }
}
