<?php

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Outcomes;
use App\Models\Services;
use App\Models\Settings;
use App\Models\Tasks;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use HTTP_Request2 as Hrequest;


if(!function_exists('settings'))
{
    function settings()
    {
        $settings = Settings::all()->first();

        return $settings;
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
     * @param $invoiceID
     * @return mixed
     */
    function getFinalPrices( $invoiceID )
    {
        $invoice = Invoice::query()->where('invoiceID', '=', $invoiceID)->first();
        $total = [];
        $services = $invoice->services()->get();
        foreach ($services as $service)
        {
            $total[] = $service->price * $service->quantity;
        }
        $invoicePrice = collect($total)->sum();

        return $invoicePrice;
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

        $incomesTotals = [];
        foreach ($incomes as $invoice)
        {
            $incomesTotals[] = getFinalPrices($invoice->invoiceID);
        }
        $finalIncomes = collect($incomesTotals)->sum();

        return number_format($finalIncomes, 2, ',', '.');
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
            $fpaTotals[] = getFinalPrices($invoice->invoiceID);

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
        $pdf = PDF::loadView('invoices.raw-view', ['invoice' => $invoice], [], 'ASCII,JIS,UTF-8,EUC-JP,SJIS');
        $pdf->setPaper('A4', 'portrait');
        Storage::put('public/pdf/'.$year.'/'.$month.'/invoice-m'.str_pad($invoice->invoiceID, 4, '0', STR_PAD_LEFT).'.pdf', $pdf->output());

        $invoice->update(['file_invoice' => 'invoice-m'.str_pad($invoice->invoiceID, 4, '0', STR_PAD_LEFT).'.pdf']);
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

if(!function_exists('myDataSendInvoices')) {
    function myDataSendInvoices($invoice)
    {
        $settings = Settings::all()->first();
        $invoice = Invoice::query()->where('invoiceID', '=', $invoice)->first();
        //dump($invoice);
        $services = $invoice->services()->get();

        //$request = new  Hrequest('https://mydata-dev.azure-api.net/SendInvoices');
        $request = new  Hrequest('https://mydatapi.aade.gr/myDATA/SendInvoices');
        // Test
        //        $headers = array(
        //            'aade-user-id' => 'sphereweb',
        //            'Ocp-Apim-Subscription-Key' => '8c0a25b302714ac3b227d212824e9361',
        //        );
        // Official
        $headers = array(
            'aade-user-id' => $settings->aade_user_id,
            'Ocp-Apim-Subscription-Key' => $settings->ocp_apim_subscription_key,
        );

        $idFormatted = str_pad($invoice->invoiceID, 4, '0', STR_PAD_LEFT);
        $total = getFinalPrices($invoice->invoiceID); // Total price without VAT
        $tax = (24 / 100) * $total; // FPA
        if($total > 300) {
            $withheld = (20 / 100) * $total; // Συνολική Παρακράτηση (Συνολικό - 20%)
            $grossValue = ($total - $withheld) + $tax; // Μικτό Ποσό - Πληρωτέο (Συνολικό - 20% + ΦΠΑ)
        } else {
            $grossValue = $total + $tax;
            $withheld = 0.00;
        }
        $request->setHeader($headers);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $sendBody = '<InvoicesDoc xmlns="http://www.aade.gr/myDATA/invoice/v1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:icls="https://www.aade.gr/myDATA/incomeClassificaton/v1.0" xmlns:ecls="https://www.aade.gr/myDATA/expensesClassificaton/v1.0" xsi:schemaLocation="http://www.aade.gr/myDATA/invoice/v1.0/InvoicesDoc-v0.6.xsd">'.PHP_EOL;
        $sendBody .= '<invoice>'.PHP_EOL;
        $sendBody .= '<issuer>'.PHP_EOL;
        $sendBody .= '<vatNumber>'.settings()->vat.'</vatNumber>'.PHP_EOL;
        $sendBody .= '<country>GR</country>'.PHP_EOL;
        $sendBody .= '<branch>0</branch>'.PHP_EOL;
        $sendBody .= '</issuer>'.PHP_EOL;
        $sendBody .= '<counterpart>'.PHP_EOL;
        $sendBody .= '<vatNumber>'.$invoice->client->vat.'</vatNumber>'.PHP_EOL;
        $sendBody .= '<country>GR</country>'.PHP_EOL;
        $sendBody .= '<branch>0</branch>'.PHP_EOL;
        $sendBody .= '<address>'.PHP_EOL;
        $sendBody .= '<street>'.$invoice->client->address.'</street>'.PHP_EOL;
        $sendBody .= '<number>'.$invoice->client->number.'</number>'.PHP_EOL;
        $sendBody .= '<postalCode>'.$invoice->client->postal_code.'</postalCode>'.PHP_EOL;
        $sendBody .= '<city>'.$invoice->client->city.'</city>'.PHP_EOL;
        $sendBody .= '</address>'.PHP_EOL;
        $sendBody .= '</counterpart>'.PHP_EOL;
        $sendBody .= '<invoiceHeader>'.PHP_EOL;
        $sendBody .= '<series>M</series>'.PHP_EOL;
        $sendBody .= '<aa>'.$idFormatted.'</aa>'.PHP_EOL;
        $sendBody .= '<issueDate>'.$invoice->date.'</issueDate>'.PHP_EOL;
        $sendBody .= '<invoiceType>2.1</invoiceType>'.PHP_EOL;
        $sendBody .= '<currency>EUR</currency>'.PHP_EOL;
        $sendBody .= '</invoiceHeader>'.PHP_EOL;
        $sendBody .= '<paymentMethods>'.PHP_EOL;
        $sendBody .= '<paymentMethodDetails>'.PHP_EOL;
        $sendBody .= '<type>5</type>'.PHP_EOL;
        $sendBody .= '<amount>'.number_format($total, 2, '.', '' ).'</amount>'.PHP_EOL;
        $sendBody .= '<paymentMethodInfo></paymentMethodInfo>'.PHP_EOL;
        $sendBody .= '</paymentMethodDetails>'.PHP_EOL;
        $sendBody .= '</paymentMethods>'.PHP_EOL;
        $counter = 1;
        foreach ($services as $service) {
            $sendBody .= '<invoiceDetails>' . PHP_EOL;
            $sendBody .= '<lineNumber>'.$counter.'</lineNumber>' . PHP_EOL;
            $sendBody .= '<netValue>' . number_format(($service->price * $service->quantity), 2, '.', '') . '</netValue>' . PHP_EOL;
            $sendBody .= '<vatCategory>1</vatCategory>' . PHP_EOL;
            $sendBody .= '<vatAmount>' . number_format(((24/100) * ($service->price * $service->quantity)), 2, '.', '') . '</vatAmount>' . PHP_EOL;
            $sendBody .= '<incomeClassification>' . PHP_EOL;
            $sendBody .= '<icls:classificationType>E3_561_001</icls:classificationType>' . PHP_EOL;
            $sendBody .= '<icls:classificationCategory>category1_3</icls:classificationCategory>' . PHP_EOL;
            $sendBody .= '<icls:amount>' . number_format(($service->price * $service->quantity), 2, '.', '') . '</icls:amount>' . PHP_EOL;
            $sendBody .= '</incomeClassification>' . PHP_EOL;
            $sendBody .= '</invoiceDetails>' . PHP_EOL;
        $counter++;
        }
        $sendBody .= '<taxesTotals>'.PHP_EOL;
        $sendBody .= '<taxes>'.PHP_EOL;
        $sendBody .= '<taxType>1</taxType>'.PHP_EOL;
        $sendBody .= '<taxCategory>2</taxCategory>'.PHP_EOL;
        $sendBody .= '<underlyingValue>'.number_format($withheld, 2, '.', ',').'</underlyingValue>'.PHP_EOL;
        $sendBody .= '<taxAmount>'.number_format($withheld, 2, '.', ',').'</taxAmount>'.PHP_EOL;
        $sendBody .= '</taxes>'.PHP_EOL;
        $sendBody .= '</taxesTotals>'.PHP_EOL;
        $sendBody .= '<invoiceSummary>'.PHP_EOL;
        $sendBody .= '<totalNetValue>'.number_format($total, 2, '.', '' ).'</totalNetValue>'.PHP_EOL;
        $sendBody .= '<totalVatAmount>'.number_format($tax , '2', '.', ',').'</totalVatAmount>'.PHP_EOL;
        $sendBody .= '<totalWithheldAmount>'.number_format( $withheld, 2, '.', '').'</totalWithheldAmount>'.PHP_EOL;
        $sendBody .= '<totalFeesAmount>0.00</totalFeesAmount>'.PHP_EOL;
        $sendBody .= '<totalStampDutyAmount>0.00</totalStampDutyAmount>'.PHP_EOL;
        $sendBody .= '<totalOtherTaxesAmount>0.00</totalOtherTaxesAmount>'.PHP_EOL;
        $sendBody .= '<totalDeductionsAmount>0.00</totalDeductionsAmount>'.PHP_EOL;
        $sendBody .= '<totalGrossValue>'.number_format( $grossValue , 2, '.', '' ).'</totalGrossValue>'.PHP_EOL;
        $sendBody .= '<incomeClassification>'.PHP_EOL;
        $sendBody .= '<icls:classificationType>E3_561_001</icls:classificationType>'.PHP_EOL;
        $sendBody .= '<icls:classificationCategory>category1_3</icls:classificationCategory>'.PHP_EOL;
        $sendBody .= '<icls:amount>'.number_format($total, 2, '.', '' ).'</icls:amount>'.PHP_EOL;
        $sendBody .= '</incomeClassification>'.PHP_EOL;
        $sendBody .= '</invoiceSummary>'.PHP_EOL;
        $sendBody .= '</invoice>'.PHP_EOL;
        $sendBody .= '</InvoicesDoc>'.PHP_EOL;
        //dd($sendBody);
        $request->setBody($sendBody);
        try
        {
            $response = $request->send();
            $body = $response->getBody();
           // dd($response->getBody());


        }
        catch (HttpException $ex)
        {
            return $ex;
        }
        //dd($body);
        return $body;
    }
}

if(!function_exists('checkVat')) {
    function checkVat($vat) {

    }
}
