<?php

use App\Models\DeliveredGoods;
use App\Models\DeliveryInvoices;
use App\Models\Invoice;
use App\Models\Outcomes;
use App\Models\RetailClassification;
use App\Models\Retails;
use App\Models\SaleInvoices;
use App\Models\Settings;
use HTTP_Request2 as Hrequest;

if(!function_exists('myDataSendInvoices')) {
    function myDataSendInvoices($type, $invoice)
    {
        $settings = Settings::all()->first();
        $myVat = Settings::query()->where('type', '=', 'vat')->first()['value'];
        if($type == 'invoice') {
            $invoice = Invoice::query()->where('hashID', '=', $invoice)->first();
            $total = getFinalPrices($invoice->hashID); // Total price without VAT
            $invoiceType = '2.1';
            $classificationType = 'E3_561_001';
            $classificationCat = 'category1_3';
            $services = $invoice->services()->get();
            $parakratisi = getParakratisiValue($invoice->parakratisi_id);
            $tax = (24 / 100) * $total; // FPA
            $idFormatted = $invoice->invoiceID;
            if($total > 300) {
                $withheld = ($parakratisi / 100) * $total; // Συνολική Παρακράτηση (Συνολικό - 20%)
                $grossValue = ($total - $withheld) + $tax; // Μικτό Ποσό - Πληρωτέο (Συνολικό - 20% + ΦΠΑ)
            } else {
                $grossValue = $total + $tax;
                $withheld = 0.00;
            }
        } elseif($type == 'sale_invoice') {
            $invoice = SaleInvoices::query()->where('hashID', '=', $invoice)->first();
            $total = getSaleInvoicePrices($invoice->hashID); // Total price without VAT
            $invoiceType = '1.1';
            $classificationType = 'E3_561_001';
            $classificationCat = 'category1_1';
            $products = $invoice->deliveredGoods()->get();
            $tax = getSaleInvoiceVat($invoice->hashID);
            $grossValue = getSaleInvoiceFinal($invoice->hashID);
            $withheld = 0.00;
            $idFormatted = $invoice->sale_invoiceID;
        } elseif($type == 'delivery_invoice') {
            $invoice = DeliveryInvoices::query()->where('hashID', '=', $invoice)->first();
            $total = getDeliveryInvoicePrices($invoice->hashID); // Total price without VAT
            $invoiceType = '1.1';
            $classificationType = 'E3_561_001';
            $classificationCat = 'category1_1';
            $products = $invoice->deliveredGoods()->get();
            $tax = getDeliveryInvoiceVat($invoice->hashID);
            $grossValue = getDeliveryInvoiceFinal($invoice->hashID);
            $withheld = 0.00;
            $idFormatted = $invoice->delivery_invoice_id;
        }
//dd($total);
        //dump($invoice);
        //$request = new  Hrequest('https://mydata-dev.azure-api.net/SendInvoices');
        $request = new  Hrequest('https://mydatapi.aade.gr/myDATA/SendInvoices');
        // Test
        //        $headers = array(
        //            'aade-user-id' => 'sphereweb',
        //            'Ocp-Apim-Subscription-Key' => '8c0a25b302714ac3b227d212824e9361',
        //        );
        // Official
        $headers = array(
            'aade-user-id' => 'triasporepe',
            'Ocp-Apim-Subscription-Key' => '7b10c5fb49b6442a931d3322b354246c',
        );

        $request->setHeader($headers);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $sendBody = '<InvoicesDoc xmlns="http://www.aade.gr/myDATA/invoice/v1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:icls="https://www.aade.gr/myDATA/incomeClassificaton/v1.0" xmlns:ecls="https://www.aade.gr/myDATA/expensesClassificaton/v1.0" xsi:schemaLocation="http://www.aade.gr/myDATA/invoice/v1.0/InvoicesDoc-v0.6.xsd">'.PHP_EOL;
        $sendBody .= '<invoice>'.PHP_EOL;
        $sendBody .= '<issuer>'.PHP_EOL;
        $sendBody .= '<vatNumber>'.$myVat.'</vatNumber>'.PHP_EOL;
        $sendBody .= '<country>GR</country>'.PHP_EOL;
        $sendBody .= '<branch>0</branch>'.PHP_EOL;
        $sendBody .= '</issuer>'.PHP_EOL;
        $sendBody .= '<counterpart>'.PHP_EOL;
        $sendBody .= '<vatNumber>'.str_pad($invoice->client->vat, 9, '0', STR_PAD_LEFT).'</vatNumber>'.PHP_EOL;
        $sendBody .= '<country>GR</country>'.PHP_EOL;
        $sendBody .= '<branch>0</branch>'.PHP_EOL;
            $sendBody .= '<address>'.PHP_EOL;
            $sendBody .= '<street>'.$invoice->client->addresses[0]->address.'</street>'.PHP_EOL;
            $sendBody .= '<number>'.$invoice->client->addresses[0]->number.'</number>'.PHP_EOL;
            $sendBody .= '<postalCode>'.$invoice->client->addresses[0]->postal_code.'</postalCode>'.PHP_EOL;
            $sendBody .= '<city>'.$invoice->client->addresses[0]->city.'</city>'.PHP_EOL;
            $sendBody .= '</address>'.PHP_EOL;
        $sendBody .= '</counterpart>'.PHP_EOL;
        $sendBody .= '<invoiceHeader>'.PHP_EOL;
        $sendBody .= '<series>'.$invoice->seira.'</series>'.PHP_EOL;
        $sendBody .= '<aa>'.$idFormatted.'</aa>'.PHP_EOL;
        $sendBody .= '<issueDate>'.$invoice->date.'</issueDate>'.PHP_EOL;
        $sendBody .= '<invoiceType>'.$invoiceType.'</invoiceType>'.PHP_EOL;
        $sendBody .= '<currency>EUR</currency>'.PHP_EOL;
        $sendBody .= '</invoiceHeader>'.PHP_EOL;
        $sendBody .= '<paymentMethods>'.PHP_EOL;
        $sendBody .= '<paymentMethodDetails>'.PHP_EOL;
        $sendBody .= '<type>'.$invoice->payment_method.'</type>'.PHP_EOL;
        $sendBody .= '<amount>'.number_format($grossValue, 2, '.', '' ).'</amount>'.PHP_EOL;
        $sendBody .= '<paymentMethodInfo></paymentMethodInfo>'.PHP_EOL;
        $sendBody .= '</paymentMethodDetails>'.PHP_EOL;
        $sendBody .= '</paymentMethods>'.PHP_EOL;
        $counter = 1;
        if(isset($services)) {
            foreach ($services as $service) {
                $sendBody .= '<invoiceDetails>' . PHP_EOL;
                $sendBody .= '<lineNumber>'.$counter.'</lineNumber>' . PHP_EOL;
                $sendBody .= '<netValue>' . number_format(($service->price * $service->quantity), 2, '.', '') . '</netValue>' . PHP_EOL;
                $sendBody .= '<vatCategory>1</vatCategory>' . PHP_EOL;
                $sendBody .= '<vatAmount>' . number_format(((24/100) * ($service->price * $service->quantity)), 2, '.', '') . '</vatAmount>' . PHP_EOL;
                $sendBody .= '<incomeClassification>' . PHP_EOL;
                $sendBody .= '<icls:classificationType>'.$classificationType.'</icls:classificationType>' . PHP_EOL;
                $sendBody .= '<icls:classificationCategory>'.$classificationCat.'</icls:classificationCategory>' . PHP_EOL;
                $sendBody .= '<icls:amount>' . number_format(($service->price * $service->quantity), 2, '.', '') . '</icls:amount>' . PHP_EOL;
                $sendBody .= '</incomeClassification>' . PHP_EOL;
                $sendBody .= '</invoiceDetails>' . PHP_EOL;
                $counter++;
            }
        } elseif (isset($products)){
            foreach ($products as $product) {
                $sendBody .= '<invoiceDetails>' . PHP_EOL;
                $sendBody .= '<lineNumber>'.$counter.'</lineNumber>' . PHP_EOL;
                $sendBody .= '<netValue>' . number_format(($product->product_price * $product->quantity), 2, '.', '') . '</netValue>' . PHP_EOL;
                $sendBody .= '<vatCategory>1</vatCategory>' . PHP_EOL;
                $sendBody .= '<vatAmount>' . number_format($product->line_vat, 2, '.', '') . '</vatAmount>' . PHP_EOL;
                $sendBody .= '<incomeClassification>' . PHP_EOL;
                $sendBody .= '<icls:classificationType>'.$classificationType.'</icls:classificationType>' . PHP_EOL;
                $sendBody .= '<icls:classificationCategory>'.$classificationCat.'</icls:classificationCategory>' . PHP_EOL;
                $sendBody .= '<icls:amount>' . number_format(($product->product_price * $product->quantity), 2, '.', '') . '</icls:amount>' . PHP_EOL;
                $sendBody .= '</incomeClassification>' . PHP_EOL;
                $sendBody .= '</invoiceDetails>' . PHP_EOL;
                $counter++;
            }
        }
        if(isset($invoice->parakratisi_id)) {
            $sendBody .= '<taxesTotals>'.PHP_EOL;
            $sendBody .= '<taxes>'.PHP_EOL;
            $sendBody .= '<taxType>1</taxType>'.PHP_EOL;
            $sendBody .= '<taxCategory>'.$invoice->parakratisi_id.'</taxCategory>'.PHP_EOL;
            $sendBody .= '<underlyingValue>'.number_format($withheld, 2, '.', ',').'</underlyingValue>'.PHP_EOL;
            $sendBody .= '<taxAmount>'.number_format($withheld, 2, '.', ',').'</taxAmount>'.PHP_EOL;
            $sendBody .= '</taxes>'.PHP_EOL;
            $sendBody .= '</taxesTotals>'.PHP_EOL;
        }
        $sendBody .= '<invoiceSummary>'.PHP_EOL;
        $sendBody .= '<totalNetValue>'.number_format($total, 2, '.', '' ).'</totalNetValue>'.PHP_EOL;
        $sendBody .= '<totalVatAmount>'.number_format($tax , 2, '.', ',').'</totalVatAmount>'.PHP_EOL;
        $sendBody .= '<totalWithheldAmount>'.number_format( $withheld, 2, '.', '').'</totalWithheldAmount>'.PHP_EOL;
        $sendBody .= '<totalFeesAmount>0.00</totalFeesAmount>'.PHP_EOL;
        $sendBody .= '<totalStampDutyAmount>0.00</totalStampDutyAmount>'.PHP_EOL;
        $sendBody .= '<totalOtherTaxesAmount>0.00</totalOtherTaxesAmount>'.PHP_EOL;
        $sendBody .= '<totalDeductionsAmount>0.00</totalDeductionsAmount>'.PHP_EOL;
        $sendBody .= '<totalGrossValue>'.number_format( $grossValue , 2, '.', '' ).'</totalGrossValue>'.PHP_EOL;
        $sendBody .= '<incomeClassification>'.PHP_EOL;
        $sendBody .= '<icls:classificationType>'.$classificationType.'</icls:classificationType>'.PHP_EOL;
        $sendBody .= '<icls:classificationCategory>'.$classificationCat.'</icls:classificationCategory>'.PHP_EOL;
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
        }
        catch (HttpException $ex)
        {
            return $ex;

        }
        //dd($body);
        return $body;
    }
}

if(!function_exists('myDataSendRetailReceipt')) {
    function myDataSendRetailReceipt($retailHashID) {
        $settings = [];
        $allSettings = Settings::all();
        $retail = Retails::query()->where('hashID', '=', $retailHashID)->first();

        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }
        //dd($settings);
        $request = new Hrequest('https://mydatapi.aade.gr/myDATA/SendInvoices');

        // Official
        $headers = array(
            'aade-user-id' => $settings['aade_user_id'],
            'Ocp-Apim-Subscription-Key' => $settings['ocp_apim_subscription_key'],
        );
        $request->setHeader($headers);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        // Request body
        $sendBody = '<InvoicesDoc xmlns="http://www.aade.gr/myDATA/invoice/v1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:icls="https://www.aade.gr/myDATA/incomeClassificaton/v1.0" xmlns:ecls="https://www.aade.gr/myDATA/expensesClassificaton/v1.0" xsi:schemaLocation="http://www.aade.gr/myDATA/invoice/v1.0/InvoicesDoc-v0.6.xsd">'.PHP_EOL;
        $sendBody .= '<invoice>'.PHP_EOL;
        $sendBody .= '<issuer>'.PHP_EOL;
        $sendBody .= '<vatNumber>'.$settings['vat'].'</vatNumber>'.PHP_EOL;
        $sendBody .= '<country>GR</country>'.PHP_EOL;
        $sendBody .= '<branch>0</branch>'.PHP_EOL;
        $sendBody .= '</issuer>'.PHP_EOL;
        $sendBody .= '<invoiceHeader>'.PHP_EOL;
        $sendBody .= '<series>'.$retail->seira.'</series>'.PHP_EOL;
        $sendBody .= '<aa>'.$retail->retailID.'</aa>'.PHP_EOL;
        $sendBody .= '<issueDate>'.$retail->date.'</issueDate>'.PHP_EOL;
        $sendBody .= '<invoiceType>11.1</invoiceType>'.PHP_EOL;
        $sendBody .= '<currency>EUR</currency>'.PHP_EOL;
        $sendBody .= '</invoiceHeader>'.PHP_EOL;
        $sendBody .= '<paymentMethods>'.PHP_EOL;
        foreach($retail->items as $item) {
            $sendBody .= '<paymentMethodDetails>'.PHP_EOL;
            $sendBody .= '<type>'.$item->payment_method.'</type>'.PHP_EOL;
            $sendBody .= '<amount>'.number_format(($item->price + $item->vat), 2, '.', '' ).'</amount>'.PHP_EOL;
            $sendBody .= '<paymentMethodInfo></paymentMethodInfo>'.PHP_EOL;
            $sendBody .= '</paymentMethodDetails>'.PHP_EOL;
        }
        $sendBody .= '</paymentMethods>'.PHP_EOL;
        $counter = 1;
        foreach($retail->items as $item) {
            $sendBody .= '<invoiceDetails>' . PHP_EOL;
            $sendBody .= '<lineNumber>'.$counter.'</lineNumber>' . PHP_EOL;
            $sendBody .= '<netValue>' . number_format($item->price, 2, '.', '') . '</netValue>' . PHP_EOL;
            $sendBody .= '<vatCategory>' . $item->vat_id . '</vatCategory>' . PHP_EOL;
            $sendBody .= '<vatAmount>' . number_format($item->vat, 2, '.', '') . '</vatAmount>' . PHP_EOL;
            $sendBody .= '<incomeClassification>' . PHP_EOL;
            $sendBody .= '<icls:classificationType>E3_561_003</icls:classificationType>' . PHP_EOL;
            $sendBody .= '<icls:classificationCategory>category1_1</icls:classificationCategory>' . PHP_EOL;
            $sendBody .= '<icls:amount>' . number_format($item->price, 2, '.', '') . '</icls:amount>' . PHP_EOL;
            $sendBody .= '</incomeClassification>' . PHP_EOL;
            $sendBody .= '</invoiceDetails>' . PHP_EOL;
            $counter++;
        }

        $sendBody .= '<invoiceSummary>'.PHP_EOL;
        $sendBody .= '<totalNetValue>'.number_format(getRetailPrices($retail)['price'] , 2, '.', '' ).'</totalNetValue>'.PHP_EOL;
        $sendBody .= '<totalVatAmount>'.number_format(getRetailPrices($retail)['vat'], '2', '.', ',').'</totalVatAmount>'.PHP_EOL;
        $sendBody .= '<totalWithheldAmount>0.00</totalWithheldAmount>'.PHP_EOL;
        $sendBody .= '<totalFeesAmount>0.00</totalFeesAmount>'.PHP_EOL;
        $sendBody .= '<totalStampDutyAmount>0.00</totalStampDutyAmount>'.PHP_EOL;
        $sendBody .= '<totalOtherTaxesAmount>0.00</totalOtherTaxesAmount>'.PHP_EOL;
        $sendBody .= '<totalDeductionsAmount>0.00</totalDeductionsAmount>'.PHP_EOL;
        $sendBody .= '<totalGrossValue>'.number_format( getRetailPrices($retail)['full'], 2, '.', '' ).'</totalGrossValue>'.PHP_EOL;
        $sendBody .= '<incomeClassification>'.PHP_EOL;
        $sendBody .= '<icls:classificationType>E3_561_003</icls:classificationType>'.PHP_EOL;
        $sendBody .= '<icls:classificationCategory>category1_1</icls:classificationCategory>'.PHP_EOL;
        $sendBody .= '<icls:amount>'.number_format(getRetailPrices($retail)['price'], 2, '.', '' ).'</icls:amount>'.PHP_EOL;
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
        }
        catch (HttpException $ex)
        {
            return $ex;

        }
       //dd($body);
        return $body;
    }
}

if(!function_exists('myDataRequestMyExpenses')) {
    function myDataRequestMyExpenses()
    {
        $settings = Settings::all()->first();

        $request = new  Hrequest('https://mydatapi.aade.gr/myDATA/RequestMyExpenses?dateFrom=01/01/2021&dateTo=14/10/2022');
        $url = $request->getUrl();

        // Official
        $headers = array(
            'aade-user-id' => $settings->aade_user_id,
            'Ocp-Apim-Subscription-Key' => $settings->ocp_apim_subscription_key,
        );

        $request->setHeader($headers);

        $request->setMethod(HTTP_Request2::METHOD_GET);

        try
        {
            $response = $request->send();
            if($response->getBody()) {
                $xml = simplexml_load_string($response->getBody());
            }

            return $xml;
        }
        catch (HttpException $ex)
        {
            //dd($ex);
        }
    }
}

if(!function_exists('myDataRequestDocs')) {
    function myDataRequestDocs($last)
    {
        $settings = Settings::all()->first();

        $request = new  Hrequest('https://mydatapi.aade.gr/myDATA/RequestDocs?mark=0');
        $url = $request->getUrl();

        // Official
        $headers = array(
            'aade-user-id' => $settings->aade_user_id,
            'Ocp-Apim-Subscription-Key' => $settings->ocp_apim_subscription_key,
        );

        $request->setHeader($headers);

        $request->setMethod(HTTP_Request2::METHOD_GET);

        try
        {
            $response = $request->send();
            if($response->getBody()) {

                $xml = simplexml_load_string($response->getBody());
            }
            return $xml;
        }
        catch (HttpException $ex)
        {
            //dd($ex);
        }
    }
}

if(!function_exists('myDataSendExpensesClassification')) {
    function myDataSendExpensesClassification($outcomeHash) {
        $settings = Settings::all()->first();
        $classifications = RetailClassification::query()->where('outcome_hash', '=', $outcomeHash)->get();
        $outcome = Outcomes::query()->where('hashID', '=', $outcomeHash)->first();

        $counter = 1;

        $request = new  Hrequest('https://mydatapi.aade.gr/myDATA/SendExpensesClassification');

        $headers = array(
            'aade-user-id' => $settings->aade_user_id,
            'Ocp-Apim-Subscription-Key' => $settings->ocp_apim_subscription_key,
        );

        $request->setHeader($headers);

        $request->setMethod(HTTP_Request2::METHOD_POST);

        $sendBody = '<ExpensesClassificationsDoc xmlns="https://www.aade.gr/myDATA/expensesClassificaton/v1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="https://www.aade.gr/myDATA/expensesClassificaton/v1.0">'.PHP_EOL;
        $sendBody .= '<expensesInvoiceClassification>'.PHP_EOL;
        $sendBody .= '<invoiceMark>'.$outcome->minMark.'</invoiceMark>'.PHP_EOL;

        foreach($classifications as $classification) {
            $sendBody .= '<invoicesExpensesClassificationDetails>'.PHP_EOL;
            $sendBody .= '<lineNumber>'.$counter.'</lineNumber>'.PHP_EOL;
            $sendBody .= '<expensesClassificationDetailData>'.PHP_EOL;
            $sendBody .= '<classificationType>'.$classification->classification_type.'</classificationType>'.PHP_EOL;
            $sendBody .= '<classificationCategory>'.$classification->classification_category.'</classificationCategory>'.PHP_EOL;
            $sendBody .= '<amount>'.$classification->price.'</amount>'.PHP_EOL;
            $sendBody .= '<id>1</id>'.PHP_EOL;
            $sendBody .= '</expensesClassificationDetailData>'.PHP_EOL;
            $sendBody .= '<expensesClassificationDetailData>'.PHP_EOL;
            $sendBody .= '<classificationType>VAT_361</classificationType>'.PHP_EOL;
            $sendBody .= '<classificationCategory>'.$classification->classification_category.'</classificationCategory>'.PHP_EOL;
            $sendBody .= '<amount>'.$classification->price.'</amount>'.PHP_EOL;
            $sendBody .= '<id>2</id>'.PHP_EOL;
            $sendBody .= '</expensesClassificationDetailData>'.PHP_EOL;
            $sendBody .= '</invoicesExpensesClassificationDetails>'.PHP_EOL;
            $counter ++;
        }
        $sendBody .= '</expensesInvoiceClassification>'.PHP_EOL;
        $sendBody .= '</ExpensesClassificationsDoc>'.PHP_EOL;

        $request->setBody($sendBody);
        //dd($sendBody);
        try
        {
            $response = $request->send();
            $body = $response->getBody();
        }
        catch (HttpException $ex)
        {
            return $ex;

        }
        dd($body);
        return $body;
    }
}