<?php

namespace App\Http\Controllers;

use App\Models\SaleInvoices;
use Illuminate\Http\Request;

class SaleInvoicesController extends Controller
{
    public function index()
    {
        $finalIncome = [];
        $saleInvoices = SaleInvoices::query()->where('date', '>=', date('Y').'-01-01')->get()->sortBy('sale_invoiceID');
        foreach($saleInvoices as $invoice) {
            $finalIncome[] = getFinalPrices($invoice->hashID);
        }
        $final = array_sum($finalIncome);

        return view('sale_invoices.index', ['invoices' => $saleInvoices, 'finals' => $final]);
    }
}
