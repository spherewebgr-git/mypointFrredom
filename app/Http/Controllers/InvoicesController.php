<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Seires;
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
        $invoices = Invoice::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('invoiceID');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID);
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
        $invoices = Invoice::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortByDesc('date');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID);
        }
        $final = array_sum($finalIncome);
        return view('invoices.index', ['invoices' => $invoices, 'dateStart' => $from, 'dateEnd' => $to, 'finals' => $final]);
    }

    public function view($invoiceID) {
        $invoice = Invoice::query()->where('hashID', $invoiceID)->first();

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

        return view('invoices.view', ['invoice' => $invoice, 'payment' => $payment]);
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
        $invoice = Invoice::query()->where('seira', '=', 'ANEY')->orWhere('seira', '=', 'ΑΝΕΥ')->latest('invoiceID')->first();

        //dd($invoice);
        $clients = Client::all()->sortBy('company');
        $seires = Seires::query()->where('type', '=', 'invoices')->get();
        if($invoice) {
            $lastInvoice = $invoice->invoiceID;
        } else {
            $lastInvoice = '';
        }

        return view('invoices.new', ['last' => $lastInvoice, 'clients' => $clients, 'seires' => $seires]);
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
//dd($request);
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $services = $request->services;

        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }
        if(isset($request->has_parakratisi)) { $parakratisi = 1; } else { $parakratisi = 0; }

        DB::table('invoices')->insert(
            array(
                'invoiceID' => $request->invoiceID,
                'hashID' => Str::substr(Str::slug(Hash::make( $request->client.$request->invoiceID)), 0, 32),
                'client_id' => $request->client,
                'date' => $date,
                'paid' => $paid,
                'seira' => $request->seira,
                'has_parakratisi' => $parakratisi,
                'payment_method' => $request->paymentMethod
            )
        );
//dd($services);
        foreach($services as $serv) {
            if(array_key_exists('id', $serv)) {
                $service = Services::query()->where('id', '=', $serv['id'])->first();
            }
            if(isset($service)) {
                $service->update(['invoice_number' =>  $request->invoiceID]);
            } else {
                DB::table('services')->insert(
                    array(
                        'invoice_number' => getInvoiceHash($request->seira, $request->invoiceID),
                        'client_id' => $request->client,
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

    public function edit($hashID)
    {
        $invoice = Invoice::query()->where('hashID', '=', $hashID)->first();
        $clients = Client::all()->sortBy('company');
        $seires = Seires::query()->where('type', '=', 'invoices')->get();


        return view('invoices.new', ['last' => '', 'clients' => $clients, 'invoice' => $invoice, 'seires' => $seires]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        //dd($invoice);
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        $date = $requestDate->format('Y-m-d');
        $services = $request->services;


        if(isset($request->hasParakratisi)) {
            $parakratisi = 1;
        } else {
            $parakratisi = 0;
        }

        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }
        $invoice->update([
            'date' => $date,
            'client_id' => $request->client,
            'paid' => $paid,
            'has_parakratisi' => $parakratisi,
            'payment_method' => $request->paymentMethod
        ]);
        foreach($services as $service) {
            if(isset($service['id'])) {

                DB::table('services')->where('id', $service['id'])->update([
                    'price' => $service['price'],
                    'quantity' => $service['quantity'],
                    'description' => $service['description'],
                    'updated_at' => date('Y-m-d')
                ]);
            } else {
                DB::table('services')->insert(
                    [
                        'invoice_number' => $invoice->hashID,
                        'client_id' => $invoice->client->id,
                        'price' => $service['price'],
                        'quantity' => $service['quantity'],
                        'description' => $service['description'],
                        'created_at' => date('Y-m-d')
                    ]
                );
            }

        }

        if(isset($request->sendInvoice)) {
            myDataSendInvoices('invoice', $invoice->hashID);

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

        $an = myDataSendInvoices('invoice', $invoice);
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

    public function lastInvoiceAjax(Request $request) {
        //return $request->seira;
        $letter = $request->seira;
        $last = Invoice::query()->where('seira', '=', $letter)->orderByDesc('invoiceID')->first();
        if($last == null) {
            return '00';
        }
        return $last->invoiceID + 1;
    }
}
