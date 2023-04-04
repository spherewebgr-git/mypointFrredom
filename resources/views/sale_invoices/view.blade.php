{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if($invoice->seira == 'ANEY' || $invoice->seira == 'ΑΝΕΥ')
    @section('title','Τιμολογίο '.$invoice->sale_invoiceID)
@else
    @section('title','Τιμολογίο '.$invoice->seira.' '.$invoice->sale_invoiceID)
@endif
{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection
{{-- page content --}}
@section('content')
    <div class="breadcrumbs-light pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        @if($invoice->seira == 'ANEY' || $invoice->seira == 'ΑΝΕΥ')
                            <span>Τιμολόγιο {{$invoice->sale_invoiceID}}</span>
                        @else
                            <span>Τιμολόγιο {{$invoice->seira.' '.$invoice->sale_invoiceID}}</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="timologioContent row">
        <div class="invoice-table card col s9">
            <table class="invoiceform">
                <tbody>
                <tr class="no-border">
                    @if(isset(settings()['invoice_logo']))
                        <td><img src="{{url('images/system/'.settings()['invoice_logo'])}}"
                                 alt="{{settings()['title']}} logo"></td>
                    @endif
                    <td class="tim-info left" style="text-align: left">
                        <h4 class="invoice-color">{{settings()['title']}}</h4>
                        <h5 class="invoice-color">{{settings()['company']}}</h5>
                        <p>{{settings()['business']}}<br>{{settings()['address']}}<br>Α.Φ.Μ.: {{settings()['vat']}} -
                            ΔΟΥ: {{settings()['doy'] ?? 'not exist'}}</p></td>
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
                <span class="invoice-color">Πελάτης:</span>
                <strong>{{$invoice->client->company}}</strong><br>
                {{$invoice->client->work_title}}<br>
                {{$invoice->client->address. ' '. $invoice->client->number}}, {{chunk_split($invoice->client->postal_code, 3, ' ')}}<br>
                <strong>ΑΦΜ:</strong> {{$invoice->client->vat}} - <strong>ΔΟΥ: </strong>{{$invoice->client->doy}}<br>
                <strong>ΤΗΛ:</strong> {{$invoice->client->phone}} - <strong>ΠΟΛΗ: </strong>{{$invoice->client->city}}
                <br>
            </div>
            <hr class="main-color">

            <div class="timTable small-12 columns">
                <table>
                    <tbody>
                    <tr>
                        <th style="width: 7%;background: #C62828" class="invoice-color-bg center">Ποσότητα</th>
                        <th style="width: 70%" class="invoice-color-bg">Περιγραφή</th>
                        <th style="width: 13%" class="invoice-color-bg center">Τιμή Μονάδας</th>
                        <th style="width: 8%" class="invoice-color-bg right-align">Σύνολο</th>
                    </tr>
                    @if($invoice->goods)
                    @foreach($invoice->goods as $service)
                        <tr class="service" data-quantity="1" data-price="300">
                            <td class="center">{{$service->quantity}}</td>
                            <td>{{$service->description}}</td>
                            <td class="servicePrice center">{{number_format($service->price, 2, ',', '.')}}</td>
                            <td class="serviceTotalPrice right-align">{{number_format($service->price * $service->quantity, 2, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    @for($i = $invoice->goods->count(); $i <= 4; $i++)
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                    @endfor
                    @endif
                    <tr class="right-align">
                        <td colspan="2">ΣΥΝΟΛΟ ΑΞΙΩΝ:</td>
                        <td colspan="2" class="sinoloAxion" data-saprice="">
                            € {{number_format(getSaleInvoicePrices($invoice->hashID), 2, ',', '.')}}</td>
                    </tr>
                    <tr class="right-align">
                        <td colspan="2">Φ.Π.Α. <strong>(24%)</strong>:</td>
                        <td colspan="2" class="sinoloFpa">
                            € {{number_format((24 / 100) * getSaleInvoicePrices($invoice->hashID), 2, ',', '.')}}</td>
                    </tr>
                    <tr class="right-align">
                        <td colspan="2">ΓΕΝΙΚΟ ΣΥΝΟΛΟ:</td>
                        <td colspan="2" class="sinoloGeniko">
                            € {{number_format(getSaleInvoicePrices($invoice->hashID) + ((24 / 100) * getSaleInvoicePrices($invoice->hashID)), 2, ',', '.')}}</td>
                    </tr>
                    <tr class="right-align">
                        <td colspan="2"><strong>ΠΛΗΡΩΤΕΟ ΠΟΣΟ:</strong></td>
                        <td colspan="2" class="pliroteoPoso"><strong>€ {{number_format(getSaleInvoicePrices($invoice->hashID) + ((24 / 100) * getSaleInvoicePrices($invoice->hashID)), 2, ',', '.')}}</strong></td>
                    </tr>
                    </tbody>
                </table>
                <div class="small-12 columns">
                    @if(isset(settings()->signature))
                        <div class="signature left">
                            <span class="invoice-color">Για τον εκδότη</span>
                            <img src="{{url('images/system/'.settings()->signature)}}" alt="signature">
                        </div>
                    @endif
                    @if(isset($invoice->mark))
                        <div class="aade-mydata-mark">ΜΑΡΚ: {{$invoice->mark}}</div>
                    @endif
                    <div class="clear"></div>
                    <table class="invoiceform footer">
                        <tbody>
                        <tr>
                            <td> @if(isset(settings()['phone'])) <span class="invoice-color">Τηλ:</span> {{settings()['phone']}} @endif </td>
                            <td> @if(isset(settings()['email'])) <span class="invoice-color">Email:</span> {{settings()['email']}} @endif </td>
                            <td><span class="invoice-color">Χρήση: </span>ΠΕΛΑΤΗΣ</td>
                        </tr>
                        <tr>
                            {{--                            <td><span class="invoice-color">Web:</span> wwww.sphereweb.gr</td>--}}<td></td>
                            <td><span class="invoice-color">Πληρωμή:</span> {{$payment}}</td>
                            <td> @if(isset(settings()['mobile'])) <span class="invoice-color">Κιν:</span> {{settings()['mobile']}} @endif </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col xl3 m4 s12">
            <div class="card invoice-action-wrapper">
                <div class="card-content">
                    <div class="invoice-action-btn">
                        <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                            <i class="material-icons mr-4">check</i>
                            <span class="text-nowrap">Αποστολή Τιμολογίου</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn">
                        <a href="javascript:if(window.print)window.print()" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
                            <i class="material-icons mr-4">print</i>
                            <span>Εκτύπωση</span>
                        </a>
                    </div>
                    @if(!$invoice->mark || !$invoice->goods)
                        <div class="invoice-action-btn">
                            <a href="{{route('sale_invoice.edit', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <i class="material-icons mr-4">edit</i>
                                <span>Επεξεργασία</span>
                            </a>
                        </div>
                        @if(!$invoice->mark)
                        <div class="invoice-action-btn">
                            <a href="{{route('sale_invoice.mydata', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <i class="material-icons mr-4">backup</i>
                                <span>Αποστολή στο myData</span>
                            </a>
                        </div>
                        @endif
                    @endif
                    <div class="invoice-action-btn">
                        <a href="{{route('sale_invoice.save', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Δημιουργία PDF & Λήψη</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn">
                        <a href="{{route('sale_invoice.download', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Λήψη PDF</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn">
                        <a href="#" id="addPaymentsPage" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                            <i class="material-icons mr-3">euro_symbol</i>
                            <span class="text-nowrap">Προσθήκη Τρόπων Πληρωμής</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
