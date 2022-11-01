<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Goods;
use App\Models\SaleInvoices;
use App\Models\Seires;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SaleInvoicesController extends Controller
{
    public function index()
    {
        $finalIncome = [];
        $saleInvoices = SaleInvoices::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('sale_invoiceID');

        foreach($saleInvoices as $invoice) {
            $finalIncome[] = getSaleInvoicePrices($invoice->hashID);
        }
        $final = array_sum($finalIncome);

        return view('sale_invoices.index', ['invoices' => $saleInvoices, 'finals' => $final]);
    }

    public function new()
    {
        $invoice = SaleInvoices::query()->where('seira', '=', 'ΑΝΕΥ')->latest()->first();
        //dd($invoice);
        $seires = Seires::query()->where('type', '=', 'sale_invoices')->get();
        $clients = Client::all()->sortBy('company');
        if($invoice) {
            $lastInvoice = $invoice->sale_invoiceID;
        } else {
            $lastInvoice = '';
        }

        return view('sale_invoices.new', ['last' => $lastInvoice, 'seires' => $seires, 'clients' => $clients]);
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
                'payment_method' => $request->paymentMethod
            )
        );

        foreach($services as $serv) {
            if(array_key_exists('id', $serv)) {
                $service = Goods::query()->where('id', '=', $serv['id'])->first();
            }
            if(isset($service)) {
                $service->update(['sale_invoice_id' =>  $request->invoiceID]);
            } else {
                DB::table('goods')->insert(
                    array(
                        'sale_invoice_id' => getSaleInvoiceHash($request->seira, $request->invoiceID),
                        'client_id' => $request->client,
                        'price' => $serv['price'],
                        'quantity' => $serv['quantity'],
                        'description' => $serv['description']
                    )
                );
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
}
