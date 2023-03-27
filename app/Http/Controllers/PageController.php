<?php

namespace App\Http\Controllers;



use App\Models\Invoice;
use App\Models\SaleInvoices;
use Carbon\Carbon;
use SimpleXMLElement;

class PageController extends Controller
{

    public function index() {
        return view('auth.login');
    }

    public function dashboard()
    {
        $date = Carbon::now()->locale('el_GR')->timezone('Europe/Athens');
        $today = $date->isoFormat('LL');
        $todayTime = $date->isoFormat('LLL');
        $unpaid = Invoice::query()->where('paid', '=', 0)->get();
        $monthIncomes = [];
        $monthInvoices = Invoice::query()->where('date', '>=', date('Y-m').'-01')->where('date', '<=', date('Y-m').'-31')->get()->sortByDesc('date');
        $monthSaleInvoices = SaleInvoices::query()->where('date', '>=', date('Y-m').'-01')->where('date', '<=', date('Y-m').'-31')->get()->sortByDesc('date');
        //$monthDeliveryInvoices = De::query()->where('date', '>=', '2022-01-01')->where('date', '<=', '2022-01-31')->get()->sortByDesc('date');
        if(count($monthInvoices) > 0) {
            foreach($monthInvoices as $monthInvoice) {
                $monthIncomes[] = getFinalPrices($monthInvoice->hashID, 'invoice');
            }
        }
        if(count($monthSaleInvoices) > 0) {
            foreach($monthSaleInvoices as $monthSaleInvoice) {
                $monthIncomes[] = getFinalPrices($monthSaleInvoice->hashID, 'saleInvoice');
            }
        }
        $monthIn = collect($monthIncomes)->sum();
        //$rssLink = file_get_contents('https://www.taxheaven.gr/bibliothiki/soft/xml/soft_dat.xml');
        //$feed = new SimpleXMLElement($rssLink);

        $pageConfigs = ['pageHeader' => true];

        return view('pages.dashboard', ['pageConfigs' => $pageConfigs, 'today' => $today, 'todayTime' => $todayTime, 'unpaid' => $unpaid, 'feed' => '', 'mothIncomes' => $monthIn] );
    }

    public function collapsePage()
    {
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Pages"], ['name' => "Page Collapse"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'bodyCustomClass' => 'menu-collapse'];

        return view('pages.page-collapse', ['pageConfigs' => $pageConfigs], ['breadcrumbs' => $breadcrumbs]);
    }
}
