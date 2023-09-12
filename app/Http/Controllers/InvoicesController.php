<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Retails;
use App\Models\Seires;
use App\Models\Services;
use App\Models\Settings;
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
        $finalVat = [];
        $finalWithVats = [];
        $invoices = Invoice::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('invoiceID');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID, 'invoice');
            $finalVat[] = getFinalInvoiceVat($invoice->hashID, 'invoice');
        }
        $final = array_sum($finalIncome);
        $vats = array_sum($finalVat);

        return view('invoices.index', ['invoices' => $invoices, 'finals' => $final, 'vats' => $vats]);
    }

    public function filter(Request $request)
    {
        // dd($request);
        $fromDate = DateTime::createFromFormat('d/m/Y', $request['date-start']);
        $from = $fromDate->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y', $request['date-end']);
        $to = $toDate->format('Y-m-d');

        $finalIncome = [];
        $finalVat = [];
        $invoices = Invoice::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortByDesc('date');
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID, 'invoice');
            $finalVat[] = getFinalInvoiceVat($invoice->hashID, 'invoice');
        }
        $final = array_sum($finalIncome);
        $vats = array_sum($finalVat);

        return view('invoices.index', ['invoices' => $invoices, 'dateStart' => $from, 'dateEnd' => $to, 'finals' => $final, 'vats' => $vats]);
    }

    public function selectYear($year) {
        $invoices = Invoice::query()->where( DB::raw('YEAR(date)'), '=', $year)->whereNotNull('invoiceID')->get()->sortBy('date');

        $finalIncome = [];
        $finalFpa = [];
        $finalVat = [];
        foreach($invoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID, 'invoice');
            $finalVat[] = getFinalInvoiceVat($invoice->hashID, 'invoice');
        }
        $final = array_sum($finalIncome);
        $vats = array_sum($finalVat);

        return view('invoices.index', ['invoices' => $invoices, 'finals' => $final, 'year' => $year, 'vats' => $vats]);
    }

    public function view($invoiceID) {
        $invoice = Invoice::query()->where('hashID', $invoiceID)->first();
        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }

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

        return view('invoices.view', ['invoice' => $invoice, 'payment' => $payment, 'settings' => $settings]);
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
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');

        $services = $request->services;

        if(isset($request->paid)) { $paid = 1; } else { $paid = 0; }
        if(isset($request->hasParakratisi)) { $parakratisi = 1; } else { $parakratisi = 0; }

        DB::table('invoices')->insert(
            array(
                'invoiceID' => $request->invoiceID,
                'hashID' => Str::substr(Str::slug(Hash::make( $request->client.$request->invoiceID)), 0, 32),
                'client_id' => $request->client,
                'date' => $date,
                'paid' => $paid,
                'seira' => $request->seira,
                'has_parakratisi' => $parakratisi,
                'parakratisi_id' => $request->parakratisi_id,
                'payment_method' => $request->paymentMethod
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
                        'invoice_number' => getInvoiceHash($request->seira, $request->invoiceID),
                        'client_id' => $request->client,
                        'price' => $serv['price'],
                        'quantity' => $serv['quantity'],
                        'vat_amount' => (getVatPercantageByCategory($serv['vat_category']) / 100) * ($serv['quantity'] * $serv['price']),
                        'vat_category' => $serv['vat_category'],
                        'vat_cause' => $serv['vat_cause'] ?? NULL,
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
            'parakratisi_id' => $request->parakratisi_id,
            'payment_method' => $request->paymentMethod
        ]);
        foreach($services as $service) {
            if(isset($service['id'])) {

                DB::table('services')->where('id', $service['id'])->update([
                    'price' => $service['price'],
                    'quantity' => $service['quantity'],
                    'vat_amount' => (getVatPercantageByCategory($service['vat_category']) / 100) * ($service['quantity'] * $service['price']),
                    'vat_category' => $service['vat_category'],
                    'vat_cause' => $service['vat_cause'] ?? NULL,
                    'description' => $service['description'],
                    'updated_at' => date('Y-m-d')
                ]);
            } else {
                DB::table('services')->insert(
                    [
                        'invoice_number' => $invoice->hashID,
                        'client_id' => $invoice->client->id,
                        'price' => $service['price'],
                        'vat_amount' => (getVatPercantageByCategory($service['vat_category']) / 100) * ($service['quantity'] * $service['price']),
                        'vat_category' => $service['vat_category'],
                        'vat_cause' => $service['vat_cause'] ?? NULL,
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

        foreach ($invoice->services as $service) {
            $service->delete();
        }
        $invoice->delete();

        return Redirect::back()->with('notify', 'Το τιμολόγιο τοποθετήθηκε στον κάδο ανακύκλωσης!');
    }

    public function sendMail(Invoice $invoice) {
        //dd($invoice->services);
        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }
        $data = array(
            'invoice'=> $invoice,
            'services' => $invoice->services,
            'title' => $settings['company'].' - '. $settings['title'],
            'settings' => $settings
        );
        $year = (string)date('Y', strtotime($invoice->date));
        $month = (string)date('m', strtotime($invoice->date));
        $fileName = $invoice->file_invoice;
        createInvoiceFile($invoice->hashID);
        $file = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.$year.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.$fileName;
        try {

            $client = $invoice->client;
            //dd($settings);
            Mail::send('emails.notification', $data, function($message) use ($file, $invoice, $client, $settings) {
                $message->to($client->email, $client->company);
                $message->subject('Τιμολόγιο Παροχής Υπηρεσιών '.$settings['title'].' - '.$invoice->seira.'/'.$invoice->invoiceID);
                $message->attach($file);
                $message->from($settings['email'], $settings['company'].' - '. $settings['title']);
            });

        } catch (\Exception $e) {

            return Redirect::back()->with('notify', $e->getMessage());
        }
        return Redirect::back()->with('notify', 'Το τιμολόγιο εστάλη στον πελάτη με επιτυχία');
    }

    public function sendInvoice($invoiceHash)
    {
       // $invoices = $request->invoices;
        $theInvoice = Invoice::query()->where('hashID', '=', $invoiceHash)->first();
        //dd($theInvoice);

        $an = myDataSendInvoices('invoice', $invoiceHash);
        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
                "index" => $aade->index,
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
            //dd($aadeResponse);
            if($aadeResponse[0]['statusCode'] == 'Success') {
                $theInvoice->mark = $aadeResponse[0]['invoiceMark'];
                $theInvoice->save();
            }
        }
        return 'ok';
    }

    public function getDocs() {
        $getLast = Invoice::all()->sortBy('mark')->last();
        $last = $getLast ? $getLast->mark : 0;
        //$lastID = $getLast->id;
       //$lastProvider = Provider::all()->last();

        $docs = myDataRequestTransmittedDocs($last);
       // dd($docs);
        if ($docs) {

            foreach($docs->invoicesDoc->invoice as $invoice) {
                if ($invoice->invoiceHeader->invoiceType == '1.1') { // Τιμολόγια Πώλησης
                    addSaleInvoice($invoice);
                } elseif($invoice->invoiceHeader->invoiceType == '2.1') { // Τιμολόγια Παροχής
                    if(!$invoice->cancelledByMark) {
                        addInvoice($invoice);
                    }
                } elseif($invoice->invoiceHeader->invoiceType == '11.1' ||  $invoice->invoiceHeader->invoiceType == '11.2') { // Αποδείξεις Λιανικής Πώλησης και παροχής
                    addRetailReceipt($invoice, $invoice->invoiceHeader->invoiceType);
                } else {
                   continue;
                }
            }
        }

        return Redirect::back()->with('notify', 'Το τιμολόγιο εστάλη!');
    }

    public function cancelInvoice(Invoice $invoice)
    {
        //dd($invoice);
        myDataCancelInvoice($invoice->mark, 'invoice');
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
