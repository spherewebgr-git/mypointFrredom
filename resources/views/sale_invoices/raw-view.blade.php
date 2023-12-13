<?php $color = $settings['invoice_color']; ?>

    <!DOCTYPE html>
<html lang="el">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @font-face {
            font-family: 'RobotoRegular';
            src: url({{ url('/fonts/Roboto/Roboto-Regular.ttf') }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'RobotoBold';
            src: url({{ url('/fonts/Roboto/Roboto-Bold.ttf') }}) format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @page { margin: 0 5px;}
        body { margin: 0 15px; font-size: 14px;}

        * {
            font-family: 'RobotoRegular', sans-serif;
            font-weight: normal;
            font-style: normal;
        }

        strong, h1, h2, h3, h4, h5 {
            font-family: 'RobotoBold', sans-serif;
            font-weight: normal;
            font-style: normal;
        }
        body {
            -webkit-print-color-adjust: exact !important;
        }

        .timologioContent {
            font-size: 14px;
        }
        .timologioContent .row {
            width: 100%;
        }
        .btn.border-round i {
            position: relative;
            top: 4px;
            margin-right: 7px;
        }
        table, p {
            font-size: 13px;
        }
        table tr.no-border, p tr.no-border {
            border: none;
        }
        table tr td, p tr td {
            vertical-align: middle;
        }
        table tr td.success, p tr td.success {
            background: #d7ffd7;
        }
        table tr td.warning, p tr td.warning {
            background: #fbffdd;
        }
        table tr td.tools, p tr td.tools {
            padding: 7px 0;
        }
        table tr td.tools a, p tr td.tools a {
            padding: 2px 7px;
        }
        table tr td.tools i, p tr td.tools i {
            font-size: 12px;
        }
        table tr td i, p tr td i {
            font-size: 12px;
        }
        table tr td i.fa-check, table tr td i.fa-times, table tr td i.fa-smile, table tr td i.fa-frown, p tr td i.fa-check, p tr td i.fa-times, p tr td i.fa-smile, p tr td i.fa-frown {
            color: #2a3f54;
            font-size: 17px;
            font-weight: 300;
        }
        table tr td button, table tr td form.btn, p tr td button, p tr td form.btn {
            padding: 0 5px !important;
        }
        table tr td a.btn-xs, p tr td a.btn-xs {
            font-size: 12px;
        }
        table tr td a.btn-xs i, p tr td a.btn-xs i {
            color: #fff;
        }
        table tr.sumPrices, p tr.sumPrices {
            background: #000;
        }
        table tr.sumPrices td, p tr.sumPrices td {
            color: #fff !important;
            font-size: 13px;
            padding: 14px 10px;
        }
        .timologioContent hr.main-color {
            color: <?php echo $color ? $color : '#C62828'; ?>;
            border: 1px solid <?php echo $color ? $color : '#C62828'; ?>;
            border-top: 0;
        }
        .timologioContent .invoice-color {
            color: <?php echo $color ? $color : '#C62828'; ?>;
        }
        .timologioContent .invoice-color-bg {
            background-color: <?php echo $color ? $color : '#C62828'; ?>;
        }
        .timologioContent .x_panel.container {
            max-width: 1200px;
            padding: 25px 30px 45px 30px;
            margin: 0 auto 10px auto;
            display: block;
        }
        .timologioContent .invoiceform {
            width: 100%;
        }
        .timologioContent .invoiceform .tim-info {
            text-align: right;

        }
        .timologioContent .invoiceform .tim-info p {
            font-size: 13px;
        }
        .timologioContent .invoiceform .tim-info h4 {
            font-size: 20px;
            margin-bottom: 0;
        }
        .timologioContent .invoiceform .tim-info h5 {
            font-size: 15px;
            margin-top: 0;
        }
        .timologioContent .invoiceform .timNumber {
            margin-bottom: 0;
            text-align: right;
            font-size: 13px;
        }
        .timologioContent .invoiceform .tim-date {
            padding-left: 11px;
        }
        .timologioContent .timClient span {
            margin-bottom: 1rem;
            display: block;
        }
        .timologioContent .paratiriseis {
            padding: 0;
        }
        .timologioContent .paratiriseis #parakratisi {
            height: 30px;
            margin-top: 10px;
        }
        .timologioContent .timTable {
            padding: 0;
        }
        .timologioContent .timTable table {
            width: 100%;
            border-spacing: 2px;
            border-collapse: separate;
        }
        .timologioContent .timTable table tr {
            background: #fff;
        }
        .timologioContent .timTable table tr th {
            background-color: <?php echo $color ? $color : '#C62828'; ?>;
            color: #fff;
            padding: 6px;
            font-size: 12px;
        }
        .timologioContent .timTable table tr td {
            padding: 5px 7px;
            font-size: 13px;
            line-height: 13px;
            border-bottom: 1px solid <?php echo $color ? $color : '#C62828'; ?>;
        }
        .timologioContent .timTable table tr td.center {text-align: center}
        .timologioContent .timTable table tr.right-align td {
            text-align: right;
        }
        .timologioContent .timTable .signature {
            width: 50%;
        }
        .timologioContent .timTable .signature span {
            display: block;
            margin: 50px 0 25px 15px;
            font-size: 16px;
            color: <?php echo $color ? $color : '#C62828'; ?>;;
        }
        .timologioContent .timTable .signature img {
            margin-left: 25px;
            width: 260px;
        }
        .timologioContent .invoiceform.footer {
            width: 100%;
            margin-top: 1rem;
        }
        .timologioContent .invoiceform.footer td {
            border: none;
            text-align: center;
        }

    </style>
    <title>Τιμολόγιο Πώλησης - @if($invoice->seira != 'ANEY') {{$invoice->seira}} @endif {{$invoice->sale_invoiceID}}</title>
</head>
<body>
<div class="timologioContent row">
    <div class="invoice-table card col s9">
        <table class="invoiceform">
            <tbody>
            <tr class="no-border">
                <td>
                    @if(isset(settings()['invoice_logo']) && isset(settings()['show_invoice_logo']) && settings()['show_invoice_logo'] == 'on') <img src="{{url('images/system/'.settings()['invoice_logo'])}}"
                                                                                                                                                     alt="{{settings()['title'] ?? ''}} logo"> @endif </td>
                <td class="tim-info">
                    <h4 style="color: <?php echo $color ? $color : '#C62828'; ?>;">{{settings()['title'] ?? 'not set'}}</h4>
                    <h5>{{settings()['company'] ?? 'not set'}}</h5>
                    <p>{{settings()['business'] ?? 'not set'}}<br>{{settings()['address'] ?? 'not set'}}<br>Α.Φ.Μ.: {{settings()['vat'] ?? 'not set'}} -
                        ΔΟΥ: {{settings()['doy'] ?? 'not set'}}</p></td>
            </tr>
            <tr class="no-border">
                <td>
                    <div class="tim-date"><span class="invoice-color">Ημερομηνία:</span>
                        <strong>{{\Carbon\Carbon::createFromTimestamp(strtotime($invoice->date))->format('d/m/Y')}}</strong>
                    </div>
                </td>
                <td>
                    <p class="timNumber">ΤΙΜΟΛΟΓΙΟ ΠΩΛΗΣΗΣ | @if($invoice->seira != 'ANEY') Σειρά: <span><strong class="invoice-color">{{$invoice->seira}}</strong></span> @endif Αρ. Τιμολογίου <span><strong class="invoice-color">{{$invoice->sale_invoiceID}}</strong></span>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="clear"></div>
        <hr class="main-color">
        <div class="timClient">
            <span class="invoice-color">Προς:</span>
            <strong>{{$invoice->client->company}}</strong><br>
            {{$invoice->client->work_title}}<br>
            {{$invoice->client->addresses[0]->address. ' '. $invoice->client->addresses[0]->number}}, {{chunk_split($invoice->client->addresses[0]->postal_code, 3, ' ')}}<br>
            <strong>ΑΦΜ:</strong> {{$invoice->client->vat}} - <strong>ΔΟΥ: </strong>{{$invoice->client->doy}}<br>
            <strong>ΤΗΛ:</strong> {{$invoice->client->phone}} - <strong>ΠΟΛΗ: </strong>{{$invoice->client->addresses[0]->city}}
            <br>
        </div>
        <hr class="main-color">

        <div class="timTable small-12 columns">
            <table>
                <tbody>
                <tr>
                    <th style="width: 7%;background: <?php echo $color ? $color : '#C62828'; ?>;" class="invoice-color-bg center">Ποσότητα</th>
                    <th style="width: 60%" class="invoice-color-bg">Περιγραφή</th>
                    <th style="width: 13%" class="invoice-color-bg center">Τιμή / (τεμ.)</th>
                    <th style="width: 13%" class="invoice-color-bg center">ΦΠΑ / (τεμ.)</th>
                    <th style="width: 8%" class="invoice-color-bg right-align">Σύνολο</th>
                </tr>
                @if(isset($invoice->deliveredGoods))
                @foreach($invoice->deliveredGoods as $product)
                    <tr class="service" data-quantity="1" data-price="300">
                        <td class="center">{{$product->quantity}}</td>
                        <td>{{getProductByID($product->delivered_good_id)->product_name}}</td>
                        <td class="servicePrice center">{{number_format($product->product_price, 2, ',', '.')}}</td>
                        <td class="serviceVat center">{{number_format($product->line_vat / $product->quantity, 2, ',', '.')}} ({{getVatPercentage($product->vat_id)}}%)</td>
                        <td class="serviceTotalPrice right-align">{{number_format($product->product_price * $product->quantity, 2, ',', '.')}}</td>
                    </tr>
                @endforeach
                @endif

                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>

                <tr class="right-align">
                    <td colspan="3">ΣΥΝΟΛΟ ΑΞΙΩΝ:</td>
                    <td colspan="3" class="sinoloAxion" data-saprice="">
                        € {{number_format(getSaleInvoicePrices($invoice->hashID), 2, ',', '.')}}</td>
                </tr>
                <tr class="right-align">
                    <td colspan="3">Φ.Π.Α.:</td>
                    <td colspan="3" class="sinoloFpa">
                        € {{number_format((getSaleInvoiceLineVat($invoice->hashID)), 2, ',', '.')}}</td>
                </tr>
                <tr class="right-align">
                    <td colspan="3">ΓΕΝΙΚΟ ΣΥΝΟΛΟ:</td>
                    <td colspan="3" class="sinoloGeniko">
                        € {{number_format(getSaleInvoicePrices($invoice->hashID) + getSaleInvoiceLineVat($invoice->hashID), 2, ',', '.')}}</td>
                </tr>
                <tr class="right-align">
                    <td colspan="3">ΠΛΗΡΩΤΕΟ ΠΟΣΟ:</td>
                    <td colspan="3" class="pliroteoPoso"><strong>€ {{ number_format( getSaleInvoicePrices($invoice->hashID) + getSaleInvoiceLineVat($invoice->hashID), 2, ',', '.' ) }}</strong></td>
                </tr>
                </tbody>
            </table>
            <div class="small-12 columns">

                @if(isset($invoice->mark) && $invoice->mark > 0)
                    <div style="padding: 140px 0 0 0;float: right;font-size: 18px;font-weight: 500;font-family: 'RobotoRegular', sans-serif;">MAPK: {{$invoice->mark}}</div>
                @endif
                <div class="clear"></div>
                    <table class="invoiceform footer" style="margin-top: 150px;">
                        <tbody>
                        <tr>
                            <td> @if(isset(settings()['phone']) && isset(settings()['show_invoice_phone']) && settings()['show_invoice_phone'] == 'on') <span class="invoice-color">Τηλ:</span> {{settings()['phone']}} @endif </td>
                            <td> @if(isset(settings()['email']) && isset(settings()['show_invoice_email']) && settings()['show_invoice_email'] == 'on') <span class="invoice-color">Email:</span> {{settings()['email']}} @endif </td>
                            <td><span class="invoice-color">Χρήση:</span>ΠΕΛΑΤΗΣ</td>
                        </tr>
                        <tr>
                            <td> @if(isset(settings()['website'])  && isset(settings()['show_invoice_website']) && settings()['show_invoice_website'] == 'on') <span class="invoice-color">Website:</span> {{settings()['website']}} @endif </td>
                            <td> @if(isset(settings()['mobile'])  && isset(settings()['show_invoice_mobile']) && settings()['show_invoice_mobile'] == 'on') <span class="invoice-color">Κιν:</span> {{settings()['mobile']}} @endif </td>
                            <td><span class="invoice-color">Τρόπος Πληρωμής:</span> {{$payment}}</td>
                        </tr>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>