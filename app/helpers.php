<?php

use App\Models\Client;
use App\Models\ClientAddresses;
use App\Models\DeliveredGoods;
use App\Models\DeliveryInvoices;
use App\Models\ForeignProviders;
use App\Models\Goods;
use App\Models\GoodsStorage;
use App\Models\HoldedProduct;
use App\Models\Invoice;
use App\Models\Outcomes;
use App\Models\Provider;
use App\Models\RetailClassification;
use App\Models\RetailReceiptsItems;
use App\Models\Retails;
use App\Models\SaleInvoices;
use App\Models\Settings;
use App\Models\Tasks;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


if(!function_exists('settings'))
{
    function settings()
    {
        $settings = [];
        $allSettings = Settings::all();
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }

        return $settings;
    }
}

if(!function_exists('getVatCategoriesList')) {
    function getVatCategoriesList() {
        $vats = array(
            1 => array(
                'code' => 1,
                'display' => '24%',
                'description' => 'ΦΠΑ συντελεστής 24%',
                'sum' => 24
            ),
            2 => array(
                'code' => 2,
                'display' => '13%',
                'description' => 'ΦΠΑ συντελεστής 13%',
                'sum' => 13
            ),
            3 => array(
                'code' => 3,
                'display' => '6%',
                'description' => 'ΦΠΑ συντελεστής 6%',
                'sum' => 6
            ),
            4 => array(
                'code' => 4,
                'display' => '17%',
                'description' => 'ΦΠΑ συντελεστής 17%',
                'sum' => 17
            ),
            5 => array(
                'code' => 5,
                'display' => '9%',
                'description' => 'ΦΠΑ συντελεστής 9%',
                'sum' => 9
            ),
            6 => array(
                'code' => 6,
                'display' => '4%',
                'description' => 'ΦΠΑ συντελεστής 4%',
                'sum' => 4
            ),
            7 => array(
                'code' => 7,
                'display' => '0%',
                'description' => 'Άνευ ΦΠΑ',
                'sum' => 0
            )
        );
        return $vats;
    }
}

if(!function_exists('getVatCauseCategoriesList')) {
    function getVatCauseCategoriesList() {
        $causes = array(
            1 => array(
                'code' => 1,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 2 και 3 του Κώδικα ΦΠΑ'
            ),
            2 => array(
                'code' => 2,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 5 του Κώδικα ΦΠΑ'
            ),
            3 => array(
                'code' => 3,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 13 του Κώδικα ΦΠΑ'
            ),
            4 => array(
                'code' => 4,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 14 του Κώδικα ΦΠΑ'
            ),
            5 => array(
                'code' => 5,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 16 του Κώδικα ΦΠΑ'
            ),
            6 => array(
                'code' => 6,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 19 του Κώδικα ΦΠΑ'
            ),
            7 => array(
                'code' => 7,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 22 του Κώδικα ΦΠΑ'
            ),
            8 => array(
                'code' => 8,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 24 του Κώδικα ΦΠΑ'
            ),
            9 => array(
                'code' => 9,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 25 του Κώδικα ΦΠΑ'
            ),
            10 => array(
                'code' => 10,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 26 του Κώδικα ΦΠΑ'
            ),
            11 => array(
                'code' => 11,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 27 του Κώδικα ΦΠΑ'
            ),
            12 => array(
                'code' => 12,
                'description' => 'Χωρίς ΦΠΑ - άρθρο 27 - Πλοία Ανοικτής Θαλάσσης του Κώδικα ΦΠΑ'
            ),
            13 => array(
                'code' => 13,
                'description' => 'Χωρίς ΦΠΑ - άρθρο 27.1.γ - Πλοία Ανοικτής Θαλάσσης του Κώδικα ΦΠΑ'
            ),
            14 => array(
                'code' => 14,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 28 του Κώδικα ΦΠΑ'
            ),
            15 => array(
                'code' => 15,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 39 του Κώδικα ΦΠΑ'
            ),
            16 => array(
                'code' => 16,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 39α του Κώδικα ΦΠΑ'
            ),
            17 => array(
                'code' => 17,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 40 του Κώδικα ΦΠΑ'
            ),
            18 => array(
                'code' => 18,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 41 του Κώδικα ΦΠΑ'
            ),
            19 => array(
                'code' => 19,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 47 του Κώδικα ΦΠΑ'
            ),
            20 => array(
                'code' => 20,
                'description' => 'ΦΠΑ εμπεριεχόμενος – άρθρο 43 του Κώδικα ΦΠΑ'
            ),
            21 => array(
                'code' => 21,
                'description' => 'ΦΠΑ εμπεριεχόμενος – άρθρο 44 του Κώδικα ΦΠΑ'
            ),
            22 => array(
                'code' => 22,
                'description' => 'ΦΠΑ εμπεριεχόμενος – άρθρο 45 του Κώδικα ΦΠΑ'
            ),
            23 => array(
                'code' => 23,
                'description' => 'ΦΠΑ εμπεριεχόμενος – άρθρο 46 του Κώδικα ΦΠΑ'
            ),
            24 => array(
                'code' => 24,
                'description' => 'ΦΠΑ εμπεριεχόμενος – άρθρο 6 του Κώδικα ΦΠΑ'
            ),
            25 => array(
                'code' => 25,
                'description' => 'Χωρίς ΦΠΑ - ΠΟΛ.1029/1995'
            ),
            26 => array(
                'code' => 26,
                'description' => 'Χωρίς ΦΠΑ - ΠΟΛ.1167/2015'
            ),
            27 => array(
                'code' => 27,
                'description' => 'Λοιπές Εξαιρέσεις ΦΠΑ'
            ),
            28 => array(
                'code' => 28,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 24 περ. β παρ.1 του Κώδικα ΦΠΑ, (Tax Free)'
            ),
            29 => array(
                'code' => 29,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 47β, του Κώδικα ΦΠΑ (OSS μη ενωσιακό καθεστώς)'
            ),
            30 => array(
                'code' => 30,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 47γ, του Κώδικα ΦΠΑ (OSS ενωσιακό καθεστώς)'
            ),
            31 => array(
                'code' => 31,
                'description' => 'Χωρίς ΦΠΑ – άρθρο 47δ του Κώδικα ΦΠΑ (IOSS)'
            )
        );
        return $causes;
    }
}

if(!function_exists('getVatPercantageByCategory')) {
    function getVatPercantageByCategory($category) {
        switch ($category) {
            case 1:
                return 24;
            case 2:
                return 13;
            case 3:
                return 6;
            case 4:
                return 17;
            case 5:
                return 9;
            case 6:
                return 4;
        }
        return 0;
    }
}

if(!function_exists('countClients'))
{
    function countClients()
    {
        $clients = Client::all()->count();

        return $clients;
    }
}

if(!function_exists('clientsNames'))
{

    function clientsNames(): \Illuminate\Support\Collection
    {
        $clientsNames = Client::all()->pluck('company', 'id');

        return $clientsNames;
    }
}

if(!function_exists('getFinalPrices'))
{
    /**
     * @param $invoiceHashID
     * @param $invoiceType
     * @return mixed
     */
    function getFinalPrices($invoiceHashID, $invoiceType)
    {
        $total = [];

        if($invoiceType == 'invoice') {
            $invoice = Invoice::query()->where('hashID', '=', $invoiceHashID)->first();
            $services = $invoice->services()->get();

            foreach ($services as $service)
            {
                $total[] = $service->price * $service->quantity;
            }
        } elseif ($invoiceType == 'saleInvoice') {
            $deliveredGoods = DeliveredGoods::query()->where('invoice_hash', '=', $invoiceHashID)->get();
            $total = [];
            foreach ($deliveredGoods as $product)
            {
                $total[] = $product->product_price * $product->quantity;
            }
        }

        $invoicePrice = collect($total)->sum();

        return $invoicePrice;
    }
}

if(!function_exists('getFinalInvoiceVat'))
{
    /**
     * @param $invoiceHashID
     * @param $invoiceType
     * @return mixed
     */
    function getFinalInvoiceVat($invoiceHashID, $invoiceType) {
       $totalVat = [];
        $invoice = Invoice::query()->where('hashID', '=', $invoiceHashID)->first();
        $services = $invoice->services()->get();

        foreach ($services as $service)
        {
            $totalVat[] = $service->vat_amount;
        }
       $total = collect($totalVat)->sum();
       return $total;
    }
}

if(!function_exists('getFinalPricesWithVat'))
{
    /**
     * @param $invoiceHashID
     * @param $invoiceType
     * @return mixed
     */
    function getFinalPricesWithVat($invoiceHashID, $invoiceType)
    {
        $total = [];

        if($invoiceType == 'invoice') {
            $invoice = Invoice::query()->where('hashID', '=', $invoiceHashID)->first();
            $services = $invoice->services()->get();

            foreach ($services as $service)
            {
                $total[] =  ($service->price * $service->quantity) + $service->vat_amount;
            }
        } elseif ($invoiceType == 'saleInvoice') {
            $deliveredGoods = DeliveredGoods::query()->where('invoice_hash', '=', $invoiceHashID)->get();
            $total = [];
            foreach ($deliveredGoods as $product)
            {
                $total[] = $product->product_price * $product->quantity;
            }
        }

        $invoicePrice = collect($total)->sum();

        return $invoicePrice;
    }
}

if(!function_exists('getClassificationsFinalPrice'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getClassificationsFinalPrice($model, $invoiceHashID )
    {
        // TODO
//        $invoice = Invoice::query()->where('hashID', '=', $invoiceHashID)->first();
//
//        $total = [];
//        $services = $invoice->services()->get();
//        //dd($services);
//        foreach ($services as $service)
//        {
//            $total[] = $service->price * $service->quantity;
//        }
//        $invoicePrice = collect($total)->sum();
//        return $invoicePrice;
    }
}

if(!function_exists('getSaleInvoicePrices'))
{
    /**
     * @param $invoiceHashID
     * @return float
     */
    function getSaleInvoicePrices( $invoiceHashID )
    {
        $deliveredGoods = DeliveredGoods::query()->where('invoice_hash', '=', $invoiceHashID)->get();
        $total = [];
        foreach ($deliveredGoods as $product)
        {
            $total[] = $product->product_price * $product->quantity;
        }

        $invoicePrice = collect($total)->sum();

        return $invoicePrice;
    }
}

if(!function_exists('getSaleInvoiceVat'))
{
    /**
     * @param $invoiceHashID
     * @return float
     */
    function getSaleInvoiceVat( $invoiceHashID )
    {
        $deliveredGoods = DeliveredGoods::query()->where('invoice_hash', '=', $invoiceHashID)->get();
        $vats = [];
        foreach ($deliveredGoods as $product)
        {
            $vats[] = $product->line_vat * $product->quantity;
        }

        $invoiceVat = collect($vats)->sum();

        return $invoiceVat;
    }
}

if(!function_exists('getDeliveryInvoicePrices'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getDeliveryInvoicePrices( $invoiceHashID )
    {
        $invoice = DeliveryInvoices::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $products = $invoice->deliveredGoods()->get();
       // dd($products);
        foreach ($products as $product)
        {
            $total[] = $product->product_price * $product->quantity;
        }
        $invoicePrice = collect($total)->sum();

        return $invoicePrice;
    }
}

if(!function_exists('getDeliveryInvoiceVat'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getDeliveryInvoiceVat( $invoiceHashID )
    {
        $invoice = DeliveryInvoices::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $products = $invoice->deliveredGoods()->get();
//         dd($products);
        foreach ($products as $product)
        {
            $total[] = $product->line_vat;
        }
        $invoiceVat = collect($total)->sum();

        return $invoiceVat;
    }
}

if(!function_exists('getDeliveryInvoiceFinal'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getDeliveryInvoiceFinal($invoiceHashID )
    {
        $invoice = DeliveryInvoices::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $products = $invoice->deliveredGoods()->get();
        // dd($products);
        foreach ($products as $product)
        {
            $total[] = $product->line_final_price;
        }
        $invoiceFinal = collect($total)->sum();

        return $invoiceFinal;
    }
}

if(!function_exists('getSaleInvoiceLineVat'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getSaleInvoiceLineVat( $invoiceHashID )
    {
        $invoice = SaleInvoices::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $products = $invoice->deliveredGoods()->get();
//         dd($products);
        foreach ($products as $product)
        {
            $total[] = $product->line_vat;
        }
        $invoiceVat = collect($total)->sum();
//dd($invoiceVat);
        return $invoiceVat;
    }
}

if(!function_exists('getInvoiceFinalTax'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getInvoiceFinalTax( $invoiceHashID )
    {
        $invoice = Invoice::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $services = $invoice->services()->get();
//         dd($products);
        foreach ($services as $service)
        {
            $total[] = $service->vat_amount;
        }
        $invoiceVat = collect($total)->sum();

        return $invoiceVat;
    }
}

if(!function_exists('getInvoiceTaxByCategory'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getInvoiceTaxByCategory($invoiceHashID)
    {
        $invoice = Invoice::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $services = $invoice->services()->get();
//         dd($products);
        foreach ($services as $service)
        {
            $total[getVatPercantageByCategory($service->vat_category)] = $service->vat_amount;
        }
        //$invoiceVat = collect($total)->sum();

        return $total;
    }
}

if(!function_exists('getSaleInvoiceFinal'))
{
    /**
     * @param $invoiceHashID
     * @return mixed
     */
    function getSaleInvoiceFinal($invoiceHashID )
    {
        $invoice = SaleInvoices::query()->where('hashID', '=', $invoiceHashID)->first();
        $total = [];
        $products = $invoice->deliveredGoods()->get();
        // dd($products);
        foreach ($products as $product)
        {
            $total[] = $product->line_final_price;
        }
        $invoiceFinal = collect($total)->sum();

        return $invoiceFinal;
    }
}

if(!function_exists('getRetailPrices'))
{
    /**
     * Returns the full prise of a single retail receipt
     * @param $retail
     * @return array
     */
    function getRetailPrices(Retails  $retail)
    {
        $netValue = [];
        $vats = [];
        $items = RetailReceiptsItems::query()->where('retailHash', '=', $retail->hashID)->get();

        foreach($items as $item) {
            $netValue[] = $item->quantity * $item->price;
            $vats[] = $item->quantity * $item->vat;
        }
//dd($items);
        $retailPrice = array_sum($netValue);
        $retailVats = array_sum($vats);

        $rPrices = [
            'price' => $retailPrice,
            'vat' => $retailVats,
            'full' => number_format(($retailPrice + $retailVats), 2)
        ];

        return $rPrices;
    }
}

if(!function_exists('formatToGreekMonth')) {
    function formatToGreekMonth($month){
        //Expected date format m
        $greekMonths = array('Ιανουάριο','Φεβρουάριο','Μάρτιο','Απρίλιο','Μάιο','Ιούνιο','Ιούλιο','Αύγουστο','Σεπτέμβριο','Οκτώβριο','Νοέμβριο','Δεκέμβριο');
        $time = strtotime(date('Y-'.$month.'-d'));
        $newformat = date('Y-m-d',$time);

        return  $greekMonths[date('m', strtotime($newformat))-1]; // . ' '. $date;
    }
}

if(!function_exists('getRetailServices'))
{
    /**
     * Returns the full prise of a single retail receipt
     * @param $retail
     * @return string
     */
    function getRetailServices(Retails  $retail)
    {
        $prices = [];
        $methodsPrices = json_decode($retail->method_price, true);
        foreach($methodsPrices as $methodPrice) {
            $prices[] = $methodPrice['price'];
        }

        $retailPrice = array_sum($prices);

        return $retailPrice;
    }
}

if(!function_exists('getIncomes'))
{
    /**
     * Returns all the incomes for the active year and summarize them
     * @return string
     */
    function getIncomes()
    {
        $incomes = Invoice::all()->where('date', '>=', date('Y').'-01-01');
        $saleInvoices = SaleInvoices::all()->where('date', '>=', date('Y').'-01-01');

        $incomesTotals = [];
        foreach ($incomes as $invoice)
        {
            $incomesTotals[] = getFinalPrices($invoice->hashID, 'invoice');
        }
        foreach($saleInvoices as $saleInvoice) {
            $incomesTotals[] = getFinalPrices($saleInvoice->hashID, 'sale_invoice');
        }
        $finalIncomes = collect($incomesTotals)->sum();
//dd($finalIncomes);
        return number_format($finalIncomes, 2, ',', '.');
    }
}

if(!function_exists('getIncomesRetails'))
{
    /**
     * Returns all the incomes for the active year and summarize them
     * @return string
     */
    function getIncomesRetails()
    {
        $retails = Retails::all()->where('date', '>=', date('Y').'-01-01');

        $retailsTotals = [];
        foreach ($retails as $retail)
        {
            $retailsTotals[] = $retail->price;
        }

        $finalRetailIncomes = collect($retailsTotals)->sum();

        return number_format($finalRetailIncomes, 2, ',', '.');
    }
}

if(!function_exists('getAllIncomes'))
{
    /**
     * Returns all the incomes for the active year and summarize them
     * @return string
     */
    function getAllIncomes()
    {
        $retails = Retails::all()->where('date', '>=', date('Y').'-01-01');
        $incomes = Invoice::all()->where('date', '>=', date('Y').'-01-01');
        $saleInvoices = SaleInvoices::all()->where('date', '>=', date('Y').'-01-01');

        $retailsTotals = [];
        foreach ($retails as $retail)
        {
            $retailsTotals[] = getRetailPrices($retail)['price'];
        }

        $saleInvoicesTotal = [];

        foreach($saleInvoices as $saleInvoice) {
            $saleInvoicesTotal[] = getFinalPrices($saleInvoice->hashID, 'sale_invoice');
        }
//dd($saleInvoicesTotal);
        $incomesTotals = [];
        foreach ($incomes as $invoice)
        {
            $incomesTotals[] = getFinalPrices($invoice->hashID, 'invoice');
        }
        $finalIncomes = collect($incomesTotals)->sum();

        $finalRetailIncomes = collect($retailsTotals)->sum();

        $finalAll = $finalIncomes + $finalRetailIncomes;

        return number_format($finalAll, 2, ',', '.');
    }
}

if(!function_exists('getOutcomes'))
{
    /**
     * Returns all the outcomes for the active year and summarize them
     * @return string
     */
    function getOutcomes()
    {
        $outcomes = Outcomes::all()->where('date', '>=', date('Y').'-01-01')->sortBy('date')->sum('price');

        return number_format($outcomes, 2, ',', '.');
    }
}

if(!function_exists('getClient'))
{
    /**
     * Returns client object by id
     * @param $client_id
     * @return string
     */
    function getClient($client_id)
    {
        $client = Client::all()->where('id', '=', $client_id)->first();

        return $client;
    }
}

if(!function_exists('getProductByID')) {
    function getProductByID($id) {

        $product = Goods::query()->where('id', '=', $id)->first();

        return $product;
    }
}

if(!function_exists('getProviderName'))
{
    /**
     * Returns provider object by vat number
     * @param $vat
     * @return string
     */
    function getProviderName($vat)
    {
        $provider = Provider::query()->where('provider_vat', '=', $vat)->first();
        $foreign = ForeignProviders::query()->where('provider_vat', '=', $vat)->first();

        if(isset($provider->provider_name)) {
            $name = $provider->provider_name;
        } elseif(isset($foreign->provider_name)) {
            $name = $foreign->provider_name;
        } else {
            $name = 'Μη καταχωρημένος προμηθευτής';
        }

        return $name;
    }
}

if(!function_exists('getFpa'))
{
    /**
     * Returns the ΦΠΑ for the three last months
     * @return array
     */
    function getFpa()
    {

        $month = date('m');
        switch ($month)
        {
            case ($month >= 1 && $month <= 3):
                $from = date('Y').'-01-01';
                $to = date('Y').'-03-31';
                $trimino = 1;
                break;
            case ($month >= 4 && $month <= 6):
                $from = date('Y').'-04-01';
                $to = date('Y').'-06-30';
                $trimino = 2;
                break;
            case ($month >= 7 && $month <= 9):
                $from = date('Y').'-07-01';
                $to = date('Y').'-09-30';
                $trimino = 3;
                break;
            case ($month >= 10 && $month <= 12):
                $from = date('Y').'-10-01';
                $to = date('Y').'-12-31';
                $trimino = 4;
                break;
        }
        $outcomes = Outcomes::all()->whereBetween('date',[$from, $to]);
        $invoices = Invoice::all()->whereBetween('date',[$from, $to]);

        $outFpa = [];
        $fpaTotals = [];
        foreach ($invoices as $invoice)
        {
            $fpaTotals[] = getFinalPrices($invoice->hashID, 'invoice');

        }
        foreach($outcomes as $outcome)
        {
            $outFpa[] = $outcome->vat;
        }


        $finalOuts = collect($outFpa)->sum();
        $finalPrice = collect($fpaTotals)->sum();

        $finalFpa = (24 / 100) * $finalPrice - $finalOuts;

        return array('trimino' => $trimino,'fpa'=> number_format($finalFpa, 2, ',', '.'));

    }
}

if(!function_exists('getWeather'))
{
    /**
     * Returns Athens weather array('icon', 'temperature', 'feels_like', 'temp_min', 'temp_max', 'description', 'image')
     * @return array
     */
    function getWeather()
    {
        $response = Http::post('https://api.openweathermap.org/data/2.5/weather?q=Athens&appid=0ab8ca754be40c23a1b3394fed99c4f2&lang=el&units=metric');
        $athens = $response->object();

        return array(
            'icon' => $athens->weather[0]->icon,
            'temperature' => $athens->main->temp,
            'feels_like' => $athens->main->feels_like,
            'temp_min' => $athens->main->temp_min,
            'temp_max' => $athens->main->temp_max,
            'description' => $athens->weather[0]->description,
            'image' => $athens->weather[0]->main,
        );
    }
}

if(!function_exists('createInvoiceFile'))
{
    function createInvoiceFile($invoiceHash)
    {
        $invoice = Invoice::query()->where('hashID', $invoiceHash)->first();
        $year = date('Y', strtotime($invoice->date));
        $month = date('m', strtotime($invoice->date));
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
            case 6:
                $payment = 'WEB BANKING';
                break;
            case 7:
                $payment = 'POS/ePOS';
                break;
        }
        $pdf = PDF::loadView('invoices.raw-view', ['invoice' => $invoice, 'payment' => $payment, 'settings' => $settings], [], 'ASCII,JIS,UTF-8,EUC-JP,SJIS');
        $pdf->setPaper('A4', 'portrait');
        Storage::put('public/pdf/'.$year.'/'.$month.'/invoice-m'.str_pad($invoice->invoiceID, 4, '0', STR_PAD_LEFT).'.pdf', $pdf->output());

        $invoice->update(['file_invoice' => 'invoice-m'.str_pad($invoice->invoiceID, 4, '0', STR_PAD_LEFT).'.pdf']);
    }
}

if(!function_exists('createSaleInvoiceFile'))
{
    function createSaleInvoiceFile($invoiceHash)
    {
        $invoice = SaleInvoices::query()->where('hashID', $invoiceHash)->first();
        $year = date('Y', strtotime($invoice->date));
        $month = date('m', strtotime($invoice->date));
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
            case 6:
                $payment = 'WEB BANKING';
                break;
            case 7:
                $payment = 'POS/ePOS';
                break;
        }
        $pdf = PDF::loadView('sale_invoices.raw-view', ['invoice' => $invoice, 'payment' => $payment, 'settings' => $settings], [], 'ASCII,JIS,UTF-8,EUC-JP,SJIS');
        $pdf->setPaper('A4', 'portrait');
        Storage::put('public/pdf/sale_invoices/'.$year.'/'.$month.'/invoice-'.$invoice->seira.$invoice->sale_invoiceID.'.pdf', $pdf->output());

        $invoice->update(['file_invoice' => 'invoice-'.$invoice->seira.$invoice->sale_invoiceID.'.pdf']);
    }
}

if(!function_exists('getPaymentMethodName')) {
    function getPaymentMethodName($paymentID) {
        switch ($paymentID) {
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
            case 6:
                $payment = 'Web Banking';
                break;
            case 7:
                $payment = 'POS \ ePOS';
                break;
        }

        return $payment;
    }
}

if(!function_exists('getRetailPaymentMethods')) {
    function getRetailPaymentMethods($retailHash) {
        $retailItems = RetailReceiptsItems::query()->where('retailHash', '=', $retailHash)->get();
        $payments = [];
        foreach($retailItems as $retailItem) {
            $methodName = getPaymentMethodName($retailItem->payment_method);
            if (!in_array($methodName, $payments))
            {
                $payments[] = $methodName;
            }

        }
        //dd($payments);
        return $payments;
    }
}

if(!function_exists('downloadInvoiceFile'))
{
    function downloadInvoiceFile($hashID)
    {
        $invoice = Invoice::query()->where('hashID', $hashID)->first();
        $year = (string)date('Y', strtotime($invoice->date));
        $month = (string)date('m', strtotime($invoice->date));
        $fileName = $invoice->file_invoice;

        return response()->download(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR . '2022' . DIRECTORY_SEPARATOR . '09' . DIRECTORY_SEPARATOR. 'invoice-m0171.pdf' );
    }
}

if(!function_exists('getTrashed')) {
    function getTrashed()
    {
        $trashed = [];

        $invoices = Invoice::onlyTrashed()->get();
        $outcomes = Outcomes::onlyTrashed()->get();

        foreach($invoices as $invoice) {
            $trashed[] = $invoice;
        }
        foreach($outcomes as $outcome) {
            $trashed[] = $outcome;
        }
        return $trashed;
    }
}

if(!function_exists('getTTasks')) {
    function getTasks()
    {
        $tasks= Tasks::all();

        return $tasks;
    }
}

if(!function_exists('getParakratisiValue')) {
    /**
     * Returns the withHeld Value by Parakratisi id
     * @param $id
     * @return integer
     */
    function getParakratisiValue($id) {
        switch ($id) {
            case 1:
            case 10:
            case 12:
                return 15;
            case 2:
            case 3:
                return 20;
            case 4:
                return 3;
        }
        return 0;
    }
}

if(!function_exists('checkVat')) {
    function checkVat($vat) {

    }
}

if(!function_exists('getInvoiceTypeName'))
{
    function getInvoiceTypeName($id)
    {
        switch (true) {
            case $id === '1.1':
                return "Τιμολόγιο Πώλησης";
            case $id === '1.2':
                return "Τιμολόγιο Πώλησης / Ενδοκοινοτικές Παραδόσεις";
            case $id === '1.3':
                return "Τιμολόγιο Πώλησης / Παραδόσεις Τρίτων Χωρών";
            case $id === '1.4':
                return "Τιμολόγιο Πώλησης / Για Λογαριασμό Τρίτων";
            case $id === '2.1':
                return "Τιμολόγιο Παροχής";
            case $id === '2.2':
                return "Τιμολόγιο Παροχής / Ενδοκοινοτική Παροχή Υπηρεσιών";
            case $id === '2.3':
                return "Τιμολόγιο Παροχής / Παροχή Υπηρεσιών Τρίτων Χωρών";
            case $id === '2.4':
                return "Τιμολόγιο Παροχής / Συμπληρωματικό Παραστατικό";
            case $id === '3.1':
                return "Τίτλος Κτήσης (μη υπόχρεος Εκδότης)";
            case $id === '3.2':
                return "Τίτλος Κτήσης (άρνηση έκδοσης από υπόχρεο Εκδότη)";
            case $id === '5.1':
                return "Πιστωτικό Τιμολόγιο / Συσχετιζόμενο";
            case $id === '5.2':
                return "Πιστωτικό Τιμολόγιο / Μη Συσχετιζόμενο";
            case $id === '6.1':
                return "Στοιχείο Αυτοπαράδοσης";
            case $id === '6.2':
                return "Στοιχείο Ιδιοχρησιμοποίησης";
            case $id === '8.1':
                return "Συμβόλαιο - Έσοδο Απόδειξη Είσπραξης";
            case $id === '8.2':
                return "Απόδειξη Είσπραξης Φόρου Διαμονής";
            case $id === '11.1' :
                return "Απόδειξη Λιανικής Πώλησης";
            case $id === '11.2' :
                return "Απόδειξη Λιανικής Παροχής Υπηρεσιών";
            case $id === '13.3':
                return "Κοινόχρηστα";
            case $id === '13.4':
                return "Συνδρομές";
            case $id === '14.3':
                return "Τιμολόγιο / Ενδοκοινοτική Λήψη Υπηρεσιών";
            case $id === '14.4':
                return "Τιμολόγιο / Λήψη Υπηρεσιών Τρίτων Χωρών";
            case $id === '14.30':
                return "Παραστατικά Ενέργειας - Τηλεφωνίας - ΔΕΚΟ";
            case $id === '14.5':
                return "ΕΦΚΑ & Λοιποί Ασφ. Οργ.";
            case $id === '17.1':
                return "Μισθοδοσία";
            case $id === '17.2':
                return "Αποσβέσεις";
        }
        return 'Λάθος Κωδικός Τύπου';
    }
}

if(!function_exists('getVatPercentage'))
{
    function getVatPercentage($id)
    {
        switch ($id) {
            case 1:
                return "24";
            case 2:
                return "13";
            case 3:
                return "6";
            case 4:
                return "17";
            case 5:
                return "9";
            case 6:
                return "4";
            case 7:
            case 8:
                return "0";
        }
        return 'Λάθος Κωδικός Τύπου';
    }
}

if(!function_exists('getOutcomeStatus')) {
    function getOutcomesStatus($outcomeHash) {
        $outcome = Outcomes::query()->where('hashID', '=', $outcomeHash)->first();
        $classifications = RetailClassification::query()->where('outcome_hash', '=', $outcomeHash)->get();
        $classificationsPrice = [];
        $marks = [];
        foreach ($classifications as $classification) {
            $classificationsPrice[] = $classification->price;
            if($classification->mark) {
                $marks[] = $classification->mark;
            }
        }
        //dd($classifications[0]->mark);
        $sumClass = array_sum($classificationsPrice);
        if($outcome->minMark != null && $outcome->outcome_number != null && $outcome->price = $sumClass || $outcome->minMark == null && $outcome->outcome_number != null && $outcome->invType == '14.5') {
            return 'crosschecked';
        } elseif($outcome->minMark == null && $outcome->outcome_number != null && $outcome->price = $sumClass){
            return 'notOnMydata';
        } elseif($outcome->classified == 1) {
            return 'marked';
        }
        return '';
    }
}

if(!function_exists('getOutcomeStatuses')) {
    function getOutcomesStatuses($outcomeHash) {
        $outcome = Outcomes::query()->where('hashID', '=', $outcomeHash)->first();
        $classifications = RetailClassification::query()->where('outcome_hash', '=', $outcomeHash)->get();
        $classificationsPrice = [];
        $marks = [];
        $statuses = [];
        foreach ($classifications as $classification) {
            $classificationsPrice[] = $classification->price;
            $marks[] = $classification->mark;
        }
       // dd($classificationsPrice);
        $sumClass = array_sum($classificationsPrice);
//
//        if($outcome->minMark != null && $outcome->outcome_number != null && $outcome->price == $sumClass || $outcome->minMark == null && $outcome->outcome_number != null && $outcome->invType == '14.5') {
//            $status = 'crosschecked';
//        } elseif($outcome->minMark == null && $outcome->outcome_number != null && $outcome->price == $sumClass){
//            $status = 'notOnMydata';
//        } elseif(count($marks) > 0) {
//            $status = 'marked';
//        } else {
//            $status= '';
//        }
        if($outcome->price = $sumClass) {
            $statuses[] = 'xaraktirismeno';
        }


        return $statuses;
    }
}

if(!function_exists('getSaleInvoiceHash')) {
    function getSaleInvoiceHash($seira, $saleInvoiceID) {
        $invoiceHash = SaleInvoices::query()->where('seira', '=', $seira)->where('sale_invoiceID', $saleInvoiceID)->first()->hashID;

        return $invoiceHash;
    }
}

if(!function_exists('getInvoiceHash')) {
    function getInvoiceHash($seira, $saleInvoiceID) {
        $invoiceHash = Invoice::query()->where('seira', '=', $seira)->where('invoiceID', $saleInvoiceID)->first()->hashID;

        return $invoiceHash;
    }
}

if(!function_exists('getClientAddresses')) {
    function getClientAddresses($clientHash) {
        $client = Client::query()->where('hashID', '=', $clientHash)->first();

        $clientAddresses = $client->addresses;

        return $clientAddresses;
    }
}

if(!function_exists('addRetailReceipt')) {
    function addRetailReceipt($invoice, $type) {

        $hash = Str::substr(Str::slug(Hash::make( $invoice->invoiceHeader->issueDate.$invoice->invoiceHeader->series.$invoice->invoiceHeader->aa)), 0, 32);

        DB::table('retails')->insert(
            array(
                'retailID' => $invoice->invoiceHeader->aa,
                'hashID' => $hash,
                'invoiceType' => $type,
                'seira' => $invoice->invoiceHeader->series,
                'client_description' => '',
                'date' => $invoice->invoiceHeader->issueDate,
                'mark' => $invoice->mark
            )
        );

        DB::table('retail_receipts_items')->insert([
            'retailHash' => $hash,
            'payment_method' => $invoice->paymentMethods[0]->paymentMethodDetails->type,
            'product_service' => 'Πώληση Προϊόντων',
            'vat_id' => $invoice->invoiceDetails->vatCategory,
            'price' => $invoice->invoiceDetails->netValue,
            'vat' => $invoice->invoiceDetails->vatAmount
        ]);

    }
}

if(!function_exists('checkIssuerVatVies')) {
    function checkIssuerVatVies($vat) {
        $chechClient = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
        $newClient = $chechClient->checkVat(array(
            'countryCode' => 'EL',
            'vatNumber' => $vat
        ));
        return $newClient;
//        if(is_array($newClient)) {
//        }
//        return 'not found';
    }
}

if(!function_exists('checkVatVies')) {
    function checkVatVies($vat) {

        $chechClient = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
        $newClient = $chechClient->checkVat(array(
            'countryCode' => 'EL',
            'vatNumber' => $vat
        ));
        //return $newClient;
        if($newClient) {
            $client = [];
            $extractName = explode('||', $newClient->name);
            $client['company'] = $extractName[1];
            $client['title'] = $extractName[0] ?? $extractName[1];
            $extractAddress = explode(' - ', $newClient->address);
            $client['city'] = $extractAddress[1];
            $output = preg_replace('!\s+!', ' ', $extractAddress[0]);
            $extractRoad = explode(' ', $output);
            if(is_numeric($extractRoad[1]) == 1) {
                $client['address'] = $extractRoad[0];
                $client['number'] = $extractRoad[1];
                $client['postal_code'] = $extractRoad[2];
            } else {
                $client['address'] = $extractRoad[0].' '.$extractRoad[1];
                $client['number'] = $extractRoad[2];
                $client['postal_code'] = $extractRoad[3];
            }

            //dd($newClient);
            return json_encode($client, JSON_UNESCAPED_UNICODE);
        } else {
            return 'vat not found';
        }
    }
}

if(!function_exists('addInvoice')) {
    function addInvoice($invoice) {
        $hash = Str::substr(Str::slug(Hash::make( $invoice->invoiceHeader->series.$invoice->invoiceHeader->aa)), 0, 32);
        $client = Client::query()->where('vat', '=', $invoice->counterpart->vatNumber)->first();
        if($client != null) {
            $clientId = $client->id;
        } else {
            $codeNumber = Client::all()->last()->code_number + 1;
            $chechClient = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
            $newClient = $chechClient->checkVat(array(
                'countryCode' => 'EL',
                'vatNumber' => $invoice->counterpart->vatNumber
            ));
            if(isset($newClient->name)) {
                $extractName = explode('||', $newClient->name);
                $company = $extractName[0];
                $companyName = $extractName[1] ?? $extractName[0];
                //dd($newClient);
            } else {
                dd('vat not found');
            }
            $clientHash = Str::substr(Str::slug(Hash::make($company  . $invoice->counterpart->vatNumber)), 0, 32);
            $clientId = DB::table('clients')->insertGetId([
                'hashID' => $clientHash,
                'code_number' => $codeNumber,
                'name' => $companyName,
                'company'=> $company,
                'vat' => $invoice->counterpart->vatNumber
            ]);
            $extractAddress = explode(' - ', $newClient->address);
            $city = $extractAddress[1];
            $output = preg_replace('!\s+!', ' ', $extractAddress[0]);
            $extractRoad = explode(' ', $output);
            if(is_numeric($extractRoad[1]) == 1) {
                $address = $extractRoad[0];
                $number = $extractRoad[1];
                $tk = $extractRoad[2];
            } else {
                $address = $extractRoad[0].' '.$extractRoad[1];
                $number = $extractRoad[2];
                $tk = $extractRoad[3];
            }
            ClientAddresses::create([
                'client_hash' => $clientHash,
                'address_type' => 0,
                'address_name' => 'Έδρα',
                'address' => $address,
                'number' => $number,
                'postal_code' => $tk,
                'city' => $city
            ]);
        }
        DB::table('invoices')->insert(
            array(
                'invoiceID' => $invoice->invoiceHeader->aa,
                'hashID' => $hash,
                'seira' => $invoice->invoiceHeader->series,
                'client_id' => $clientId,
                'paid' => 1,
                'has_parakratisi' => 1,
                'parakratisi_id' => 3,
                'payment_method' => $invoice->paymentMethods[0]->paymentMethodDetails->type,
                'date' => $invoice->invoiceHeader->issueDate,
                'mark' => $invoice->mark
            )
        );

        foreach($invoice->invoiceDetails as $line) {
            DB::table('services')->insert([
                'invoice_number' => $hash,
                'client_id' => $clientId,
                'description' => 'Υπηρεσία',
                'price' => $line->netValue,
                'quantity' => 1,
                'vat_category' => $line->vatCategory,
                'vat_amount' => $line->vatAmount
            ]);
        }



    }
}

if(!function_exists('addSaleInvoice')) {
    function addSaleInvoice($invoice) {

        $client = Client::query()->where('vat', '=', $invoice->counterpart->vatNumber)->first();
        if($client != null) {
            $theClient = $client->id;
        } else {
            $codeNumber = Client::all()->last()->code_number + 1;
            $chechClient = new SoapClient("http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl");
            $newClient = $chechClient->checkVat(array(
                'countryCode' => 'EL',
                'vatNumber' => $invoice->counterpart->vatNumber
            ));
            if(isset($newClient->name)) {
                $extractName = explode('||', $newClient->name);
                $company = $extractName[0];
                $companyName = $extractName[1] ?? $extractName[0];
                //dd($newClient);
            } else {
                dd('vat not found');
            }
            $clientHash = Str::substr(Str::slug(Hash::make($company  . $invoice->counterpart->vatNumber)), 0, 32);
            $theClient = DB::table('clients')->insertGetId([
                'hashID' => $clientHash,
                'code_number' => $codeNumber,
                'name' => $companyName,
                'company'=> $company,
                'vat' => $invoice->counterpart->vatNumber
            ]);
        }
        DB::table('sale_invoices')->insert(
            array(
                'seira' => $invoice->invoiceHeader->series,
                'sale_invoiceID' => $invoice->invoiceHeader->aa,
                'hashID' => Str::substr(Str::slug(Hash::make($invoice->invoiceHeader->series.$invoice->invoiceHeader->aa)), 0, 32),
                'client_id' => $theClient,
                'date' => $invoice->invoiceHeader->issueDate,
                'paid' => 1,
                'payment_method' => $invoice->paymentMethods[0]->paymentMethodDetails->type,
                'mark' => $invoice->mark
            )
        );
    }
}

if(!function_exists('toUpper')) {
    function toUpper($str){
    $search = array('Ά', 'Έ', 'Ί', 'Ή', 'Ύ', 'Ό', 'Ώ');
        $replace = array('Α', 'Ε', 'Ι', 'Η', 'Υ', 'Ο', 'Ω');
        $str = mb_strtoupper($str,  "UTF-8");
        return str_replace($search, $replace, $str);
    }
}

if(!function_exists('removeFromStorage')) {
    function removeFromStorage($quantity, $id) {
        $product = GoodsStorage::query()->where('id', '=', $id)->first();
        $existingQty = $product->quantity;
        $product->update([
            'quantity' => $existingQty - $quantity
        ]);
    }
}

if(!function_exists('addToStorage')) {
    function addToStorage($quantity, $id) {
        $product = GoodsStorage::query()->where('id', '=', $id)->first();
        $existingQty = $product->quantity;
        $product->update([
            'quantity' => $existingQty + $quantity
        ]);
    }
}

if(!function_exists('HoldFromStorage')) {
    function HoldFromStorage($quantity, $id, $retailHash) {
//dd('OK');
        $existings = [];

        $holdedByProducts = HoldedProduct::query()->where('holded_by', '=', $retailHash)->get();

        foreach($holdedByProducts as $h) {
            $existings[] = $h->heled_quantity;
        }
        $existingQty = array_sum($existings);

        $hold = new HoldedProduct();
        $hold->product_id = $id;
        $hold->held_quantity = $existingQty + $quantity;
        $hold->holded_by = $retailHash;
        $hold->save();
    }
}

if(!function_exists('unHoldFromStorage')) {
    function unHoldFromStorage($quantity, $id, $retailHash) {
        $product = HoldedProduct::query()->where('holded_by', '=', $retailHash)->where('product_id', '=', $id)->first();
        if($product) {
            $existingQty = $product->held_quantity;
            if($existingQty - $quantity <= 0) {
                $product->delete();
            } else {
                $product->update([
                    'held_quantity' => $quantity
                ]);
            }
        }
    }
}

if(!function_exists('unHoldSaled')) {
    function unHoldSaled($retailHash) {
        HoldedProduct::query()->whereIn('holded_by', $retailHash)->delete();
    }
}

if(!function_exists('countHolded')) {
    function countHolded($holded)
    {
        $quantity = 0;
        foreach($holded as $hold) {
            $quantity += $hold->held_quantity;
        }
        return $quantity;
    }
}



include_once 'Helpers/productsHelper.php';
include_once 'Helpers/myDataHelper.php';
include_once 'Helpers/notificationsHelper.php';


