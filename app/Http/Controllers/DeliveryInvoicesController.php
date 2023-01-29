<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddresses;
use App\Models\DeliveredGoods;
use App\Models\DeliveryInvoices;
use App\Models\Goods;
use App\Models\Seires;
use App\Models\Settings;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class DeliveryInvoicesController extends Controller
{
    public function index()
    {
        $finalIncome = [];
        $deliveryInvoices = DeliveryInvoices::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('delivery_invoice_id');


        foreach($deliveryInvoices as $invoice) {
            $finalIncome[] = getDeliveryInvoicePrices($invoice->hashID);
        }
        //dd($deliveryInvoices);
        $final = array_sum($finalIncome);

        return view('delivery_invoices.index', ['invoices' => $deliveryInvoices, 'finals' => $final]);
    }

    public function new() {

        $selectableProducts = [];
        $invoice = DeliveryInvoices::query()->where('seira', '=', 'ANEY')->latest()->first();
        $seires = Seires::query()->where('type', '=', 'delivery_invoices')->get();
        $addresses = Settings::query()->where('type' , 'LIKE', 'address_%')->get();
        $clients = Client::all()->sortBy('company');
        $products = Goods::query()->where('active', '=', 1)->get();
        foreach($products as $product) {
            if($product->storage->quantity > 0) {
                $selectableProducts[] = $product;
            }
        }
        if($invoice) {
            $lastInvoice = $invoice->delivery_invoice_id;
        } else {
            $lastInvoice = '';
        }

        return view('delivery_invoices.new', ['last' => $lastInvoice, 'seires' => $seires, 'clients' => $clients, 'addresses' => $addresses, 'products' => $selectableProducts]);
    }

    public function store(Request $request) {
       //dd($request);
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $hash = Str::substr(Str::slug(Hash::make( $request->client.$request->delivery_invoice_id)), 0, 32);

        DB::table('delivery_invoices')->insert([
            'hashID' => $hash,
            'seira' => $request->seira,
            'delivery_invoice_id' => $request->delivery_invoice_id,
            'client_id' => $request->client,
            'date' => $date,
            'time' => date('H:i'),
            'paid' => 1,
            'sendFrom' => $request->sendFrom,
            'sendTo' => $request->clientAddress,
            'payment_method' => $request->paymentMethod,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if(isset($request->products)) {
            foreach ($request->products as $prod) {
                $vat = getProductVat($prod['product']);
                //dd($vat);
                DB::table('delivered_goods')->insert([
                    'invoice_hash' => $hash,
                    'delivery_type' => 'delivery_invoice',
                    'delivered_good_id' => $prod['product'],
                    'quantity' => $prod['quantity'],
                    'product_price' => $prod['price'],
                    'line_vat' => $vat,
                    'line_final_price' => $prod['quantity'] * $prod['price'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        return redirect('/delivery-invoices');
    }

    public function edit(Request $request, DeliveryInvoices $invoice) {

        $selectableProducts = [];
        $seires = Seires::query()->where('type', '=', 'delivery_invoices')->get();
        $addresses = Settings::query()->where('type' , 'LIKE', 'address_%')->get();
        $clients = Client::all()->sortBy('company');
        $products = Goods::query()->where('active', '=', 1)->get();
        $selectedAddress = ClientAddresses::query()->where('id', '=', $invoice->sendTo)->first();
        $clientAddresses = Client::query()->where('id', '=', $invoice->client_id)->first()->addresses;
        $settings = Settings::all();

        foreach($products as $product) {
            if($product->storage->quantity > 0) {
                $selectableProducts[] = $product;
            }
        }
        return view('delivery_invoices.new', [
            'invoice' => $invoice,
            'seires' => $seires,
            'clients' => $clients,
            'addresses' => $addresses,
            'products' => $selectableProducts,
            'selectedAddress' => $selectedAddress,
            'clientAddresses' => $clientAddresses,
            'settings' => $settings
        ]);
    }

    public function update(Request $request, DeliveryInvoices $invoice)
    {

        //dd($request);
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }
        $date = $requestDate->format('Y-m-d');

        $invoice->update([
            'seira' => $request->seira,
            'invoice_hash' => $invoice->hashID,
            'client_id' => $request->client,
            'date' => $date,
            'time' => date('H:i'),
            'paid' => ($request->paid == 'on') ? 1 : 0,
            'sendFrom' => $request->sendFrom,
            'sendTo' => $request->clientAddress,
            'payment_method' => $request->paymentMethod,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

//        if(isset($request->products) && $request->products > 0) {
//            foreach ($request->products as $prod) {
//                $theProduct = DeliveredGoods::query()->where('id', '=', $prod['id'])->first();
//                //dd($theProduct);
//                $vat = getProductVat($prod['product']);
//                $theProduct->update([
//                    'delivered_good_id' => $prod['product'],
//                    'quantity' => $prod['quantity'],
//                    'product_price' => $prod['price'],
//                    'line_vat' => $vat,
//                    'line_final_price' => $prod['quantity'] * $prod['price'],
//                    'updated_at' => date('Y-m-d H:i:s')
//                ]);
//            }
//        }

        return redirect('/delivery-invoices');
    }

    public function filter(Request $request) {
        //dd($request);
        $fromDate = DateTime::createFromFormat('d/m/Y', $request['date-start']);
        $from = $fromDate->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y', $request['date-end']);
        $to = $toDate->format('Y-m-d');
        $finalIncome = [];
        $deliveryInvoices = DeliveryInvoices::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortBy('date');

        foreach($deliveryInvoices as $invoice) {
            $finalIncome[] = getDeliveryInvoicePrices($invoice->hashID);
        }
        //dd($deliveryInvoices);
        $final = array_sum($finalIncome);

        return view('delivery_invoices.index', ['invoices' => $deliveryInvoices, 'finals' => $final]);

    }

    public function sendInvoice($invoice)
    {
        $theInvoice = DeliveryInvoices::query()->where('hashID', '=', $invoice)->first();
        //dd($theInvoice);
        $an = myDataSendInvoices('delivery_invoice', $invoice);

        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
                "index" => $aade->firstname,
                "invoiceUid" => $aade->invoiceUid,
                "invoiceMark" => $aade->invoiceMark,
                "statusCode" => $aade->statusCode,
            );
            array_push($aadeResponse, $aadeObject);
        }
        if($aadeResponse[0]['statusCode'] == 'Success') {
            $theInvoice->mark = $aadeResponse[0]['invoiceMark'];
            $theInvoice->save();
        } else {
            dd($aadeResponse[0]['statusCode']);
        }

        return Redirect::back()->with('notify', 'Το τιμολόγιο εστάλη!');
    }

    public function cancelInvoice($mark) {
        myDataCancelInvoice($mark);
    }
}
