<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payments;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{
    public function index(){
        $payments = Payments::all()->sortByDesc('payment_date');

        return view('payments.index', ['payments' => $payments]);
    }

    public function new() {
        $clients = Client::all();

        return view('payments.new', ['clients' => $clients]);
    }
    public function store(Request $request) {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }
        $date = $requestDate->format('Y-m-d');
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        if($request->invoice) {
            $invoice = Invoice::query()->where('hashID', '=', $request->invoice)->first();
            $client = Client::query()->where('hashID', '=', $request->client)->first();
            $parakratisi = $invoice->has_parakratisi == 1 ? (getParakratisiValue($invoice->parakratisi_id) / 100) * getFinalPrices($invoice->hashID, 'invoice') : 0;
            $price = getFinalPrices($invoice->hashID, 'invoice');
            $vat = getInvoiceFinalTax($invoice->hashID);
           // dd($price);
            $client->update([
                'price_balance' => $client->price_balance + $price,
                'vat_balance' => $client->vat_balance + $vat,
                'parakratisi_balance' => $client->parakratisi_balance + $parakratisi,
            ]);
            $invoice->update(['paid' => 1]);
        }
        if ($request->file('bank_file')) {
            $name = str_replace([' ', '/', '\\'], '_', $request->file('bank_file')->getClientOriginalName());
            $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'public' . DIRECTORY_SEPARATOR . 'payments' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month);
            File::ensureDirectoryExists(storage_path('app') . DIRECTORY_SEPARATOR . $path);
            $request->file('bank_file')->storeAs($path, $name);
        } else {
            $name = '';
        }

        Payments::create([
            'paymentHash' => Str::substr(Str::slug(Hash::make( $request->bank_code.$request->payment_price)), 0, 32),
            'clientHash' => $request->client,
            'payment_price' => $request->payment_price,
            'payment_date' => $date,
            'bank' => $request->bank,
            'bank_code' => $request->bank_code,
            'description' => $request->description,
            'bank_file' => $name
        ]);
        return redirect('/payments')->with('notify', 'Η πληρωμή καταχωρήθηκε με επιτυχία');

    }

    public function download(Payments $payment) {
        $year = date('Y', strtotime($payment->payment_date));
        $month = date('m', strtotime($payment->payment_date));

        return response()->download(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'payments' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $payment->bank_file);
    }
}
