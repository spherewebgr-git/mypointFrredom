<?php

namespace App\Http\Controllers;



use App\Models\Invoice;
use Carbon\Carbon;

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

        $pageConfigs = ['pageHeader' => true];

        return view('pages.dashboard', ['pageConfigs' => $pageConfigs, 'today' => $today, 'todayTime' => $todayTime, 'unpaid' => $unpaid]);
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
