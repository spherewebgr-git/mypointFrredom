{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Τιμολογίο m'.str_pad($invoice->invoiceID, 4, '0', STR_PAD_LEFT))

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        <span>Τιμολόγιο {{$invoice->invoiceID}}</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="timologioContent row">
        <div class="invoice-table card col s9">
            <table class="invoiceform">
                <tbody>
                <tr class="no-border">
                    @if(settings()->invoice_logo)
                    <td><img src="{{url('images/system/'.settings()->invoice_logo)}}"
                             alt="{{settings()->title}} logo"></td>
                    @endif
                    <td class="tim-info left" style="text-align: left">
                        <h4 class="invoice-color">{{settings()->title}}</h4>
                        <h5 class="invoice-color">{{settings()->company}}</h5>
                        <p>{{settings()->business}}<br>{{settings()->address}}<br>Α.Φ.Μ.: {{settings()->vat}} -
                            ΔΟΥ: {{settings()->doy}}</p></td>
                </tr>
                <tr class="no-border">
                    <td>
                        <div class="tim-date"><span class="invoice-color">Ημερομηνία:</span>
                            <strong>{{\Carbon\Carbon::createFromTimestamp(strtotime($invoice->date))->format('d/m/Y')}}</strong>
                        </div>
                    </td>
                    <td>
                        <p class="timNumber">ΤΙΜΟΛΟΓΙΟ ΠΑΡΟΧΗΣ ΥΠΗΡΕΣΙΩΝ | Αρ. Τιμολογίου <span>
                                        <strong
                                            class="invoice-color">{{$invoice->invoiceID}}</strong></span>
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
            @if(getFinalPrices($invoice->hashID) > 300 && $invoice->has_parakratisi == 1)
            <div class="paratiriseis">
                <span class="invoice-color">Σημειώσεις:</span><br>
                    <div id="parakratisi">ΕΓΙΝΕ ΠΑΡΑΚΡΑΤΗΣΗ ΦΟΡΟΥ 20% ΙΣΗ ΜΕ
                        € {{(20 / 100) * getFinalPrices($invoice->hashID)}} (ΕΥΡΩ)
                    </div>
            </div>
            @endif
            <div class="timTable small-12 columns">
                <table>
                    <tbody>
                    <tr>
                        <th style="width: 7%;background: #C62828" class="invoice-color-bg center">Ποσότητα</th>
                        <th style="width: 70%" class="invoice-color-bg">Περιγραφή</th>
                        <th style="width: 13%" class="invoice-color-bg center">Τιμή Μονάδας</th>
                        <th style="width: 8%" class="invoice-color-bg right-align">Σύνολο</th>
                    </tr>
                    @foreach($invoice->services as $service)
                        <tr class="service" data-quantity="1" data-price="300">
                            <td class="center">{{$service->quantity}}</td>
                            <td>{{$service->description}}</td>
                            <td class="servicePrice center">{{number_format($service->price, 2, ',', '.')}}</td>
                            <td class="serviceTotalPrice right-align">{{number_format($service->price * $service->quantity, 2, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    @for($i = $invoice->services->count(); $i <= 4; $i++)
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                    @endfor
                    <tr class="right-align">
                        <td colspan="2">ΣΥΝΟΛΟ ΑΞΙΩΝ:</td>
                        <td colspan="2" class="sinoloAxion" data-saprice="">
                            € {{number_format(getFinalPrices($invoice->hashID), 2, ',', '.')}}</td>
                    </tr>
                    <tr class="right-align">
                        <td colspan="2">Φ.Π.Α. <strong>(24%)</strong>:</td>
                        <td colspan="2" class="sinoloFpa">
                            € {{number_format((24 / 100) * getFinalPrices($invoice->hashID), 2, ',', '.')}}</td>
                    </tr>
                    <tr class="right-align">
                        <td colspan="2">ΓΕΝΙΚΟ ΣΥΝΟΛΟ:</td>
                        <td colspan="2" class="sinoloGeniko">
                            € {{number_format(getFinalPrices($invoice->hashID) + ((24 / 100) * getFinalPrices($invoice->hashID)), 2, ',', '.')}}</td>
                    </tr>
                    <tr class="right-align">
                        <td colspan="2"><strong>ΠΛΗΡΩΤΕΟ ΠΟΣΟ:</strong></td>
                        <td colspan="2" class="pliroteoPoso"><strong>€ @if(getFinalPrices($invoice->hashID) > 300 && $invoice->has_parakratisi == 1)
                                {{number_format(getFinalPrices($invoice->hashID) - ((20 / 100) * getFinalPrices($invoice->hashID)) + ((24 / 100) * getFinalPrices($invoice->hashID)), 2, ',', '.')}} @else
                                {{number_format(getFinalPrices($invoice->hashID) + ((24 / 100) * getFinalPrices($invoice->hashID)), 2, ',', '.')}}
                                @endif</strong></td>
                    </tr>
                    </tbody>
                </table>
                <div class="small-12 columns">
                    @if(settings()->signature)
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
                            @if(settings()->phone)
                                <td><span class="invoice-color">Τηλ:</span> {{settings()->phone}}</td>
                            @endif
                            @if(settings()->email)
                            <td><span class="invoice-color">Email:</span> {{settings()->email}}</td>
                                @endif
                            <td><span class="invoice-color">Χρήση:</span>ΠΕΛΑΤΗΣ</td>
                        </tr>
                        <tr>
                            <td><span class="invoice-color">Κιν:</span> {{settings()->mobile}}</td>
{{--                            <td><span class="invoice-color">Web:</span> wwww.sphereweb.gr</td>--}}
                            <td><span class="invoice-color">Πληρωμή:</span> {{$payment}}</td>
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
                    @if(!$invoice->mark)
                    <div class="invoice-action-btn">
                        <a href="{{route('invoice.edit', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">edit</i>
                            <span>Επεξεργασία</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn">
                        <a href="{{route('invoice.mydata', $invoice->invoiceID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">backup</i>
                            <span>Αποστολή στο myData</span>
                        </a>
                    </div>
                    @endif
                    <div class="invoice-action-btn">
                        <a href="{{route('invoice.save', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Δημιουργία PDF & Λήψη</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn">
                        <a href="{{route('invoice.download', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
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
    <div class="payments-page col s12" style="display: none">
        <div class="card">
            <h3>Διαθέσιμοι Τρόποι Πληρωμής</h3>
            <h4 class="col s12">Τραπεζική Κατάθεση</h4>
            <div class="col s6">
                <p><strong>Τράπεζα Πειραιώς</strong></p>
                <p><strong>IBAN:</strong> GR08 0171 8320 0068 3214 4649 840</p>
                <p><strong>Διακιούχος:</strong> ΚΑΡΑΓΙΑΝΝΗΣ, ΣΠΥΡΙΔΩΝ, ΔΗΜΗΤΡΙΟΥ</p>
            </div>
            <div class="col s6">
                <p><strong>Εθνική Τράπεζα</strong></p>
                <p><strong>IBAN:</strong> GR36 0110 0770 0000 0770 0248 219</p>
                <p><strong>Διακιούχος:</strong> ΣΠΥΡΙΔΩΝ ΚΑΡΑΓΙΑΝΝΗΣ</p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
@endsection


@section('page-script')
    <script>
        $i = jQuery.noConflict();
        $i(document).ready(function(){
            $i('#addPaymentsPage').on('click', function(e){
                e.preventDefault();
                $i('.payments-page').show();
            });

        });
    </script>
@endsection
