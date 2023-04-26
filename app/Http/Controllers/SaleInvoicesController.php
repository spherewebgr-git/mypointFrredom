<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DeliveredGoods;
use App\Models\Goods;
use App\Models\SaleInvoices;
use App\Models\Seires;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SaleInvoicesController extends Controller
{
    public function index()
    {
        $finalIncome = [];
        $finalVats = [];
        $saleInvoices = SaleInvoices::all()->sortBy('sale_invoiceID');

        if(count($saleInvoices) > 0) {
            foreach($saleInvoices as $invoice) {
                $finalIncome[] = getSaleInvoicePrices($invoice->hashID);
                $finalVats[] = getSaleInvoiceVat($invoice->hashID);
            }
        }

        $final = array_sum($finalIncome);
        $vats = array_sum($finalVats);
        //dd($vats);

        return view('sale_invoices.index', ['invoices' => $saleInvoices, 'finals' => $final, 'vats' => $vats]);
    }

    public function new()
    {
        $invoice = SaleInvoices::query()->where('seira', '=', 'ANEY')->latest()->first();
        //dd($invoice);
        $products = Goods::all();
        $seires = Seires::query()->where('type', '=', 'sale_invoices')->get();
        $clients = Client::all()->sortBy('company');
        if($invoice) {
            $lastInvoice = $invoice->sale_invoiceID;
        } else {
            $lastInvoice = '';
        }

        return view('sale_invoices.new', ['last' => $lastInvoice, 'seires' => $seires, 'clients' => $clients, 'products' => $products]);
    }

    public function store(Request $request)
    {
        //dd($request);
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $services = $request->services;

        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }

        DB::table('sale_invoices')->insert(
            array(
                'seira' => $request->seira,
                'sale_invoiceID' => $request->invoiceID,
                'hashID' => Str::substr(Str::slug(Hash::make( $request->client.$request->invoiceID)), 0, 32),
                'client_id' => $request->client,
                'date' => $date,
                'paid' => $paid,
                'payment_method' => $request->paymentMethod,
                'created_at' => date('Y-m-d')
            )
        );

        if(isset($request->services)) {
            foreach($services as $serv) {
                if(array_key_exists('id', $serv)) {
                    $service = Goods::query()->where('id', '=', $serv['id'])->first();
                }
                    $service->update(['sale_invoice_id' =>  $request->invoiceID]);

            }
        } elseif(isset($request->products)) {
            foreach ($request->products as $product) {
                DB::table('delivered_goods')->insert(
                    array(
                        'invoice_hash' => getSaleInvoiceHash($request->seira, $request->invoiceID),
                        'delivery_type' => 'saleInvoice',
                        'delivered_good_id' => $product['product'],
                        'product_price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'vat_id' => $product['vat_id'],
                        'line_vat' => $product['vat'],
                        'line_final_price' => ($product['quantity'] * $product['price']) + $product['vat'],
                        'created_at' => date('Y-m-d')
                    )
                );
                HoldFromStorage($product['quantity'], $product['product'], getSaleInvoiceHash($request->seira, $request->invoiceID));
                removeFromStorage($product['quantity'], $product['product']);
            }
        }


        if(isset($request->sendClient)) {
            $invoice = SaleInvoices::query()->where('hashID', '=', getSaleInvoiceHash($request->seira, $request->invoiceID))->first();
            $data = array(
                'invoice'=> $invoice->seira.' '.$invoice->sale_invoiceID,
                'services' => $services,
                'title' => settings()->company.' - '. settings()->title
            );
            $year = date('Y', strtotime($invoice->date));
            $month = date('m', strtotime($invoice->date));
            createInvoiceFile($invoice->sale_invoiceID);
            $file = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.'sale_invoice-'.$request->seira.'-'.$request->sale_invoiceID.'.pdf';
            try {
                $client = Client::query()->where('id', '=', $request->client)->first();

                Mail::send('emails.notification', $data, function($message) use ($file, $request, $client) {
                    $message->to($client->email, $client->company);
                    $message->subject('Νέο Τιμολόγιο Πώλησης');
                    $message->attach($file);
                    $message->from(settings()->email, settings()->company.' - '. settings()->title);
                });

            } catch (\Exception $e) {
                return Redirect::back()->with('notify', $e->getMessage());
            }
            return Redirect::back()->with('notify', 'Το τιμολόγιο πώλησης καταχωρήθηκε και εστάλη στον πελάτη με επιτυχία.');
        } else {
            return redirect()->route('sale_invoice.list')->with('notify', 'Τιμολόγιο Πώλησης Καταχωρήθηκε!');
        }
    }

    public function edit($hashID) {
        $invoice = SaleInvoices::query()->where('hashID', '=', $hashID)->first();
        $clients = Client::all()->sortBy('company');
        $seires = Seires::query()->where('type', '=', 'sale_invoices')->get();
        $products = Goods::all();


        return view('sale_invoices.new', ['last' => '', 'clients' => $clients, 'invoice' => $invoice, 'seires' => $seires, 'products' => $products]);
    }

    public function update(Request $request, SaleInvoices $invoice) {
        //dd($request);
        if(isset($request->date)) {
            $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
            $date = $requestDate->format('Y-m-d');
        } else {
            $date = $invoice->date;
        }


        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }
        $invoice->update([
            'date' => $date,
            'client_id' => $request->client ?? $invoice->client->id,
            'paid' => $paid,
            'payment_method' => $request->paymentMethod ?? $invoice->payment_method
        ]);


        if(isset($request->products)) {
            DeliveredGoods::query()->where('invoice_hash', '=', $invoice->hashID)->delete();
            foreach ($request->products as $prod) {
                DB::table('delivered_goods')->insert(
                    array(
                        'invoice_hash' => $invoice->hashID,
                        'delivery_type' => 'saleInvoice',
                        'delivered_good_id' => $prod['product'],
                        'quantity' => $prod['quantity'],
                        'product_price' => $prod['price'],
                        'line_vat' => getProductVat($prod['product']),
                        'line_final_price' => $prod['quantity'] * $prod['price'],
                        'created_at' => date('Y-m-d')
                    )
                );
            }
        }

        Session::flash('notify', 'Το τιμολόγιο ενημερώθηκε με επιτυχία');

        return Redirect::to('sale-invoices');

    }

    public function view( SaleInvoices $invoice) {
        //dd($invoice);
        switch ($invoice->payment_method) {
            case 1:
                $payment = 'ΚΑΤΑΘΕΣΗ ΣΕ ΤΡΑΠΕΖΑ ΕΣΩΤΕΡΙΚΟΥ';
                break;
            case 2:
                $payment = 'ΚΑΤΑΘΕΣΗ ΣΕ ΤΡΑΠΕΖΑ ΕΞΩΤΕΡΙΚΟΥ';
                break;
            case 3:
                $payment = 'ΜΕΤΡΗΤΑ';
                break;
            case 4:
                $payment = 'ΕΠΙΤΑΓΗ';
                break;
            case 5:
                $payment = 'ΜΕ ΠΙΣΤΩΣΗ';
                break;
        }

        return view('sale_invoices.view', ['invoice' => $invoice, 'payment' => $payment]);
    }

    public function sendInvoice($invoice)
    {
        // $invoices = $request->invoices;
        $theInvoice = SaleInvoices::query()->where('hashID', '=', $invoice)->first();
        //dd($theInvoice);

        $an = myDataSendInvoices('sale_invoice', $invoice);
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

    public function filter(Request $request)
    {
        // dd($request);
        $fromDate = DateTime::createFromFormat('d/m/Y', $request['date-start']);
        $from = $fromDate->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y', $request['date-end']);
        $to = $toDate->format('Y-m-d');

        $finalIncome = [];
        $invoices = SaleInvoices::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortByDesc('date');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID);
        }
        $final = array_sum($finalIncome);
        return view('sale_invoices.index', ['invoices' => $invoices, 'dateStart' => $from, 'dateEnd' => $to, 'finals' => $final]);
    }

    public function lastInvoiceAjax(Request $request)
    {
        $letter = $request->seira;

        $last = SaleInvoices::query()->where('seira', '=', $letter)->orderByDesc('sale_invoiceID')->first();
        if($last == null) {
            return '00';
        }
        return $last->sale_invoiceID + 1;
    }

    public function delete($hashID)
    {
        $products = DeliveredGoods::query()->where('invoice_hash', '=', $hashID)->get();
        foreach($products as $product) {
            addToStorage($product->quantity, $product->delivered_good_id);
            unHoldFromStorage($product->quantity, $product->delivered_good_id, $hashID);
            $product->delete();
        }

        $invoice = SaleInvoices::query()->where('hashID', '=', $hashID)->first();
        $invoice->delete();

        return Redirect::back()->with('notify', 'Το τιμολόγιο τοποθετήθηκε στον κάδο ανακύκλωσης!');
    }
}
