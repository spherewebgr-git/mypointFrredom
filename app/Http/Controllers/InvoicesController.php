<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Services;
use DateTime;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InvoicesController extends Controller
{
    public function index()
    {
        $finalIncome = [];
        $invoices = Invoice::query()->where('date', '>=', date('Y').'-01-01')->get()->sortByDesc('invoiceID');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->invoiceID);
        }
        $final = array_sum($finalIncome);

        return view('invoices.index', ['invoices' => $invoices, 'finals' => $final]);
    }

    public function filter(Request $request)
    {
        // dd($request);
        $fromDate = DateTime::createFromFormat('d/m/Y', $request['date-start']);
        $from = $fromDate->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y', $request['date-end']);
        $to = $toDate->format('Y-m-d');

        $finalIncome = [];
        $invoices = Invoice::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortByDesc('invoiceID');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->invoiceID);
        }
        $final = array_sum($finalIncome);
        return view('invoices.index', ['invoices' => $invoices, 'dateStart' => $from, 'dateEnd' => $to, 'finals' => $final]);
    }

    public function view($invoiceID) {
        $invoice = Invoice::query()->where('invoiceID', $invoiceID)->first();

        return view('invoices.view', ['invoice' => $invoice]);
    }

    public function save($hashID)
    {
        createInvoiceFile($hashID);
        //downloadInvoiceFile($hashID);
        $invoice = Invoice::query()->where('hashID', $hashID)->first();

        $year = (string)date('Y', strtotime($invoice->date));
        $month = (string)date('m', strtotime($invoice->date));
        $fileName = $invoice->file_invoice;

        return response()->download(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR. $fileName );

        //return redirect('invoices');
    }

    public function new()
    {
        $lastInvoice = Invoice::all()->sortBy('invoiceID')->last()->invoiceID;
        $clients = Client::all()->sortBy('company');


        return view('invoices.new', ['last' => $lastInvoice, 'clients' => $clients]);
    }

    public function download($hashID) {
        $invoice = Invoice::query()->where('hashID', $hashID)->first();

        $year = (string)date('Y', strtotime($invoice->date));
        $month = (string)date('m', strtotime($invoice->date));
        $fileName = $invoice->file_invoice;

        return response()->download(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR. $fileName );
    }

    public function store(Request $request)
    {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $services = $request->services;

        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }

        DB::table('invoices')->insert(
            array(
                'invoiceID' => $request->invoiceID,
                'hashID' => Str::substr(Str::slug(Hash::make( $request->client.$request->invoiceID)), 0, 32),
                'client_id' => $request->client,
                'date' => $date,
                'paid' => $paid
            )
        );

        foreach($services as $serv) {
            if(array_key_exists('id', $serv)) {
                $service = Services::query()->where('id', '=', $serv['id'])->first();
            }
            if(isset($service)) {
                $service->update(['invoice_number' =>  $request->invoiceID]);
            } else {
                DB::table('services')->insert(
                    array(
                        'invoice_number' => $request->invoiceID,
                        'price' => $serv['price'],
                        'quantity' => $serv['quantity'],
                        'description' => $serv['description']
                    )
                );
            }
        }
        if(isset($request->sendClient)) {
            $invoice = Invoice::query()->where('invoiceID', $request->invoiceID)->first();
            $data = array(
                'invoice'=> 'm'.$invoice->invoiceID,
                'services' => $services,
                'title' => settings()->company.' - '. settings()->title
            );
            $year = date('Y', strtotime($invoice->date));
            $month = date('m', strtotime($invoice->date));
            createInvoiceFile($invoice->invoiceID);
            $file = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.'invoice-m'.$request->invoiceID.'.pdf';
            try {
                $client = Client::query()->where('id', '=', $request->client)->first();

                Mail::send('emails.notification', $data, function($message) use ($file, $request, $client) {
                    $message->to($client->email, $client->company);
                    $message->subject('Νέο Τιμολόγιο');
                    $message->attach($file);
                    $message->from(settings()->email, settings()->company.' - '. settings()->title);
                });

            } catch (\Exception $e) {
                return Redirect::back()->with('notify', $e->getMessage());
            }
            return Redirect::back()->with('notify', 'Το τιμολόγιο καταχωρήθηκε και εστάλη στον πελάτη με επιτυχία.');
        } else {
            return redirect()->route('invoice.list')->with('notify', 'Τιμολόγιο Καταχωρήθηκε!');
        }
    }

    public function edit(Invoice $invoice)
    {

        $clients = Client::all()->sortBy('company');


        return view('invoices.new', ['last' => '', 'clients' => $clients, 'invoice' => $invoice]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        $date = $requestDate->format('Y-m-d');
        $services = $request->services;

        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }
        $invoice->update([
            'date' => $date,
            'client_id' => $request->client,
            'paid' => $paid
        ]);
        foreach($services as $service) {
            DB::table('services')->where('id', $service['id'])->update([
                'price' => $service['price'],
                'quantity' => $service['quantity'],
                'description' => $service['description']
            ]);
        }

        if(isset($request->sendInvoice)) {
            myDataSendInvoices($invoice->invoiceID);

        }

        Session::flash('notify', 'Το τιμολόγιο ενημερώθηκε με επιτυχία');

        return Redirect::to('invoices');
    }

    public function delete($hashID)
    {
        $invoice = Invoice::query()->where('hashID', '=', $hashID)->first();
        $invoice->delete();

        return Redirect::back()->with('notify', 'Το τιμολόγιο τοποθετήθηκε στον κάδο ανακύκλωσης!');
    }

    public function sendInvoice($invoice)
    {
       // $invoices = $request->invoices;
        $theInvoice = Invoice::query()->where('invoiceID', '=', $invoice)->first();
        //dd($theInvoice);

        $an = myDataSendInvoices($invoice);
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
    public function sendMyDataInvoices(Request $request)
    {
        foreach($request->ids as $invoice) {
            $theInvoice = Invoice::query()->where('invoiceID', '=', $invoice)->first();

            $an = myDataSendInvoices($invoice);
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
            }
        }
        return 'ok';
    }
}
