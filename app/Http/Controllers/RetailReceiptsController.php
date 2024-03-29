<?php

namespace App\Http\Controllers;

use App\Models\Retails;
use App\Models\Seires;
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
        //$retail_receipts = Retails::all()->sortByDesc('date');
        $retail_receipts = Retails::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('date');
        foreach($retail_receipts as $retail) {
            $finalRetails[] = $retail->price;
            $finalVat[] = $retail->vat;
        }
        $final = array_sum($finalRetails);
        $vats = array_sum($finalVat);

        return view('retail_receipts.index', ['retails' => $retail_receipts, 'finals' => $final, 'vats' => $vats]);
    }

    public function filter(Request $request)
    {
        // dd($request);
        $fromDate = DateTime::createFromFormat('d/m/Y', $request['date-start']);
        $from = $fromDate->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y', $request['date-end']);
        $to = $toDate->format('Y-m-d');

        $finalRetails = [];
        $finalVat = [];

        $retail_receipts = Retails::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortBy('date');
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
        $seires = Seires::query()->where('type', '=', 'retails')->get();

        if($lastInvoice) {
            $last = $lastInvoice->retailID;
        } else {
            $last = null;
        }
        return view('retail_receipts.new', ['last' => $last, 'seires' => $seires]);
    }

    public function store(Request $request)
    {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $vat = $request->price - ($request->price / 1.24);

        DB::table('retails')->insert(
            array(
                'retailID' => $request->retailID,
                'hashID' => Str::substr(Str::slug(Hash::make( $date.$request->retailID)), 0, 32),
                'seira' => $request->seira,
                'date' => $date,
                'price' => $request->price,
                'payment_method' => $request->paymentMethod,
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
        return redirect('/retail-receipts');
    }

    public function edit($retail) {
        $retailReceipt = Retails::query()->where('hashID', '=', $retail)->first();
        $seires = Seires::query()->where('type', '=', 'retails')->get();
        //dd($retailReceipt);

        return view('retail_receipts.new', ['retail' => $retailReceipt, 'seires' => $seires] );
    }

    public function update(Request $request, $retail) {
        $retailReceipt = Retails::query()->where('hashID', '=', $retail)->first();

        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $vat = $request->price - ($request->price / 1.24);

        $retailReceipt->update([
            'retailID' => $retailReceipt->retailID,
            'hashID' => $retail,
            'seira' => $request->seira,
            'date' => $date,
            'price' => $request->price,
            'payment_method' => $request->paymentMethod,
            'vat' => $vat,
            'service' => $request->description,
            'description' => $request->mainDescription,
            'updated_at' => Carbon::now()
        ]);

        return redirect('/retail-receipts');
    }

    public function sendInvoice($retailHash){
        $an = myDataSendRetailReceipt($retailHash);

        $theRetail = Retails::query()->where('hashID', '=', $retailHash)->first();
        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
                "index" => 1,
                "invoiceUid" => $aade->invoiceUid,
                "invoiceMark" => $aade->invoiceMark,
                "statusCode" => $aade->statusCode,
            );
            array_push($aadeResponse, $aadeObject);
        }
        if($aadeResponse[0]['statusCode'] == 'Success') {
            $theRetail->mark = $aadeResponse[0]['invoiceMark'];
            $theRetail->save();
        } else {
            dd($aadeResponse[0]['statusCode']);
        }
        return Redirect::back()->with('notify', 'Η απόδειξη εστάλη!');
    }

    public function sendInvoiceAjax(Request $request){
        //return $request;
        $an = myDataSendRetailReceipt($request->retail);

        $theRetail = Retails::query()->where('hashID', '=', $request->retail)->first();
        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
                "index" => 1,
                "invoiceUid" => $aade->invoiceUid,
                "invoiceMark" => $aade->invoiceMark,
                "statusCode" => $aade->statusCode,
            );
            array_push($aadeResponse, $aadeObject);
        }

        if($aadeResponse[0]['statusCode'] == 'Success') {
            $theRetail->mark = $aadeResponse[0]['invoiceMark'];
            $theRetail->save();
            return $theRetail->hashID;
        }

        return $aadeResponse[0]['statusCode'];

    }

    public function lastRetailAjax(Request $request) {
        $letter = $request->seira;
        $last = Retails::query()->where('seira', '=', $letter)->orderByDesc('retailID')->first();
        if($last == null) {
            return '00';
        }
        return $last->retailID + 1;
    }
}
