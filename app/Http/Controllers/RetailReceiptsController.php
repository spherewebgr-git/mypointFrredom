<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\RetailReceiptsItems;
use App\Models\Retails;
use App\Models\Seires;
use App\Models\Settings;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RetailReceiptsController extends Controller
{
    public function index()
    {
        $finalRetails = [];
        $finalVat = [];
        //$retail_receipts = Retails::all()->sortByDesc('date');
        $retail_receipts = Retails::query()->where('date', '>=', date('Y').'-01-01')->orderBy('date', 'ASC')->orderBy('retailID', 'ASC')->get();
        foreach($retail_receipts as $retail) {
            $items = RetailReceiptsItems::query()->where('retailHash', '=', $retail->hashID)->get();
            foreach($items as $item) {
                $finalRetails[] = $item->price;
                $finalVat[] = $item->vat;
            }
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
            $items = RetailReceiptsItems::query()->where('retailHash', '=', $retail->hashID)->get();
            foreach($items as $item) {
                $finalRetails[] = $item->price;
                $finalVat[] = $item->vat;
            }
        }
        $final = array_sum($finalRetails);
        $vats = array_sum($finalVat);


        return view('retail_receipts.index', ['retails' => $retail_receipts, 'finals' => $final, 'vats' => $vats]);
    }

    public function new()
    {
        $lastInvoice = Retails::all()->sortBy('invoiceID')->last();
        $seires = Seires::query()->where('type', '=', 'retails')->get();
        $products = Goods::all();

        if($lastInvoice) {
            $last = $lastInvoice->retailID;
        } else {
            $last = null;
        }
        return view('retail_receipts.new', ['last' => $last, 'seires' => $seires, 'products' => $products]);
    }

    public function store(Request $request)
    {
        //dd($request);
        $items = $request->services;
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');
        $hash = Str::substr(Str::slug(Hash::make( $request->seira.$request->retailID)), 0, 32);

        DB::table('retails')->insert(
            array(
                'retailID' => $request->retailID,
                'hashID' => $hash,
                'invoiceType' => $request->retail_type,
                'seira' => $request->seira,
                'client_description' => $request->client_description,
                'date' => $date,
                'created_at' => Carbon::now()
            )
        );

        foreach($items as $item) {
            DB::table('retail_receipts_items')->insert([
                'retailHash' => $hash,
                'payment_method' => $item['payment_method'],
                'product_service' => $item['product_service'] ?? $item['product'],
                'quantity' => $item['quantity'],
                'vat_id' => $item['vat_id'],
                'price' => $item['price'] + $item['vat'],
                'vat' => $item['vat'],
                'created_at' => date('Y-m-d')
            ]);
            if(isset($item['product'])) {

                HoldFromStorage($item['quantity'], $item['product'], $hash);
                removeFromStorage($item['quantity'], $item['product']);
            }
        }

        if(isset($request->printNow) && $request->printNow == 'on') {
            return redirect('/print-retail-receipt/'.$hash);
        }
        return redirect('/retail-receipts');
    }

    public function print($retail) {
        $retailReceipt = Retails::query()->where('hashID', '=', $retail)->first();

        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }


        return view('retail_receipts.print80', ['retail' => $retailReceipt, 'settings' => $settings]);
    }

    public function edit($retail) {
        $retailReceipt = Retails::query()->where('hashID', '=', $retail)->first();
        $seires = Seires::query()->where('type', '=', 'retails')->get();
        $products = Goods::all();
        //dd($retailReceipt);

        return view('retail_receipts.new', ['retail' => $retailReceipt, 'seires' => $seires, 'products' => $products] );
    }

    public function update(Request $request, $retail) {

        $items = $request->services;
        //dd($request);
        $retailReceipt = Retails::query()->where('hashID', '=', $retail)->first();

        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $retailReceipt->update([
            'retailID' => $retailReceipt->retailID,
            'seira' => $request->seira,
            'client_description' => $request->client_description,
            'date' => $date,
            'updated_at' => Carbon::now()
        ]);

        foreach($items as $item) {
            if(isset($item['item'])) {
                $itemRow = RetailReceiptsItems::query()->where('id', '=', $item['item'])->first();
                $itemRow->update([
                    'payment_method' => $item['payment_method'],
                    'product_service' => $item['product_service'] ?? $item['product'],
                    'vat_id' => $item['vat_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'] + $item['vat'],
                    'vat' => $item['vat']
                ]);
            } else {
                DB::table('retail_receipts_items')->insert([
                    'retailHash' => $retail,
                    'payment_method' => $item['payment_method'],
                    'product_service' => $item['product_service'] ?? $item['product'],
                    'vat_id' => $item['vat_id'],
                    'price' => $item['price'],
                    'vat' => $item['vat'],
                    'created_at' => date('Y-m-d')
                ]);
            }

        }

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
            return Redirect::back()->with('notify', $aadeResponse[0]['statusCode']);
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
            unHoldSaled($theRetail->hashID);
            eshopUpdateProductStorage($theRetail->hashID);
            return $theRetail->hashID;
        }

        return $aadeResponse[0]['statusCode'];

    }

    public function lastRetailAjax(Request $request) {
        $letter = $request->seira;
        $last = Retails::query()->where('seira', '=', $letter)->where(DB::raw('YEAR(date)'), '=', '2023' )->orderByDesc('retailID')->first();
        if($last == null) {
            return '00';
        }
        return $last->retailID + 1;
    }

    public function view($retailHash) {
        $retail = Retails::query()->where('hashID', '=', $retailHash)->first();
        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }

        return view('retail_receipts.view', ['retail' => $retail, 'settings' => $settings]);
    }

    public function qrView($retailHash)
    {
        $retail = Retails::query()->where('hashID', '=', $retailHash)->first();

        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }

        return view('retail_receipts.qrcode-view', ['retail' => $retail, 'settings' => $settings]);
    }

    public function delete($retailHash) {
        $retail = Retails::query()->where('hashID', '=', $retailHash)->first();
        //dd($retail->items);
        foreach($retail->items as $item) {
            if(is_numeric($item->product_service)) {
                addToStorage($item->quantity, $item->product_service);
                unHoldFromStorage($item->quantity, $item->product_service, $retailHash);
            }
            $item->delete();
        }
        $retail->delete();

        return Redirect::back()->with('notify', 'Η απόδειξη διεγράφη!');
    }
}
