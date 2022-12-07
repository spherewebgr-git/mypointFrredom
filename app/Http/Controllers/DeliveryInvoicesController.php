<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DeliveryInvoices;
use App\Models\Seires;
use Illuminate\Http\Request;

class DeliveryInvoicesController extends Controller
{
    public function index()
    {
        $finalIncome = [];
        $deliveryInvoices = DeliveryInvoices::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('delivery_invoice_id');

        foreach($deliveryInvoices as $invoice) {
            $finalIncome[] = $invoice->final;
        }
        $final = array_sum($finalIncome);

        return view('delivery_invoices.index', ['invoices' => $deliveryInvoices, 'finals' => $final]);
    }

    public function new() {
        $invoice = DeliveryInvoices::query()->where('seira', '=', 'ANEY')->latest()->first();
        //dd($invoice);
        $seires = Seires::query()->where('type', '=', 'delivery_invoices')->get();
        $clients = Client::all()->sortBy('company');
        if($invoice) {
            $lastInvoice = $invoice->delivery_invoice_id;
        } else {
            $lastInvoice = '';
        }

        return view('delivery_invoices.new', ['last' => $lastInvoice, 'seires' => $seires, 'clients' => $clients]);
    }
}
