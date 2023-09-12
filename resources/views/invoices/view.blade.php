{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if($invoice->seira == 'ANEY' || $invoice->seira == 'ΑΝΕΥ')
    @section('title','Τιμολογίο Παροχής Υπηρεσιών '.$invoice->invoiceID)
@else
    @section('title','Τιμολογίο Παροχής Υπηρεσιών  '.$invoice->seira.' '.$invoice->invoiceID)
@endif

{{-- page styles --}}

@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <style>
        #main .timologioContent hr.main-color,
        #main .timologioContent .invoice-color {
            color: <?php echo $settings['invoice_color'] ??  '#C62828'; ?>;
            border-color: <?php echo $settings['invoice_color'] ??  '#C62828'; ?>;
        }
        #main .timologioContent .timTable table tr td {
            border-color: <?php echo $settings['invoice_color'] ??  '#C62828'; ?>;
        }
        #main .timologioContent .invoice-color-bg,
        #main .timologioContent .timTable table tr th {
            background-color: <?php echo $settings['invoice_color'] ??  '#C62828'; ?>;
        }
    </style>
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
                            <span>Τιμολόγιο Παροχής Υπηρεσιών {{$invoice->invoiceID}}</span>
                        @else
                            <span>Τιμολόγιο Παροχής Υπηρεσιών {{$invoice->seira.' '.$invoice->invoiceID}}</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="timologioContent row">
        <div class="invoice-table card col s12 m9">
            <div class="invoiceform row display-flex align-items-center flex-wrap">
                <div class="invoice-form--left col s12 m6">
                    @if(isset($settings['invoice_logo']))
                        <img src="{{url('images/system/'.$settings['invoice_logo'])}}"
                                 alt="{{$settings['title'] ?? 'company'}} logo">
                    @endif
                </div>
                <div class="invoice-form--right col s12 m6 tim-info" style="text-align: left">
                    <h4 class="invoice-color">{{$settings['title'] ?? ''}}</h4>
                    <h5 class="invoice-color">{{$settings['company'] ?? 'not set'}}</h5>
                    <p>{{$settings['business'] ?? 'not set'}}<br>{{$settings['address'] ?? 'not set'}}<br>Α.Φ.Μ.: {{$settings['vat'] ?? 'not set'}} -
                        ΔΟΥ: {{$settings['doy'] ?? 'not set'}}</p>
                </div>
            </div>
            <div class="invoiceform row display-flex align-items-center flex-wrap">
                <div class="invoice-form--left col s12 m5">
                    <div class="tim-date"><span class="invoice-color">Ημερομηνία:</span>
                        <strong>{{\Carbon\Carbon::createFromTimestamp(strtotime($invoice->date))->format('d/m/Y')}}</strong>
                    </div>
                </div>
                <div class="invoice-form--right col s12 m7">
                    <p class="timNumber">ΤΙΜΟΛΟΓΙΟ ΠΑΡΟΧΗΣ ΥΠΗΡΕΣΙΩΝ | @if($invoice->seira != 'ANEY') Σειρά: <span><strong class="invoice-color">{{$invoice->seira}}</strong></span> @endif Αρ. Τιμολογίου <span><strong class="invoice-color">{{$invoice->invoiceID}}</strong></span>
                    </p>
                </div>
            </div>

            <div class="clear"></div>
            <hr class="main-color">
            <div class="timClient">
                <span class="invoice-color">Πελάτης:</span>
                <strong>{{$invoice->client->company}}</strong><br>
                {{$invoice->client->work_title ?? ''}}<br>
                @if(count($invoice->client->addresses) > 0)
                {{$invoice->client->addresses[0]->address. ' '. $invoice->client->addresses[0]->number}}, {{chunk_split($invoice->client->addresses[0]->postal_code, 3, ' ')}}<br>
                @endif
                    <strong>ΑΦΜ:</strong> {{$invoice->client->vat}} - @if($invoice->client->doy)<strong>ΔΟΥ: </strong>{{$invoice->client->doy}}<br>@endif
                <strong>ΤΗΛ:</strong> {{$invoice->client->phone ?? ''}} @if(count($invoice->client->addresses) > 0) - <strong>ΠΟΛΗ: </strong>{{$invoice->client->addresses[0]->city}}@endif
                <br>
            </div>
            <hr class="main-color">
            @if(getFinalPrices($invoice->hashID, 'invoice') > 300 && $invoice->has_parakratisi == 1)
            <div class="paratiriseis">
                <span class="invoice-color">Σημειώσεις:</span><br>
                    <div id="parakratisi">ΕΓΙΝΕ ΠΑΡΑΚΡΑΤΗΣΗ ΦΟΡΟΥ 20% ΙΣΗ ΜΕ
                        € {{(20 / 100) * getFinalPrices($invoice->hashID, 'invoice')}} (ΕΥΡΩ)
                    </div>
            </div>
            @endif
            <div class="timTable small-12 columns table-container">
                <table>
                    <tbody>
                    <tr>
                        <th style="width: 7%;" class="invoice-color-bg center">Ποσότητα</th>
                        <th style="width: 60%;min-width: 500px" class="invoice-color-bg">Περιγραφή</th>
                        <th style="width: 10%;min-width: 95px;" class="invoice-color-bg center">Τιμή Μονάδας</th>
                        <th style="width: 10%;min-width: 115px;" class="invoice-color-bg center">Συντελεστής ΦΠΑ</th>
                        <th style="width: 8%;min-width: 80px;" class="invoice-color-bg center">ΦΠΑ</th>
                        <th style="width: 8%;min-width: 75px;" class="invoice-color-bg right-align">Σύνολο</th>
                    </tr>
                    @foreach($invoice->services as $service)
                        <tr class="service" data-quantity="1" data-price="300">
                            <td class="center">{{$service->quantity}}</td>
                            <td>{{$service->description}}</td>
                            <td class="servicePrice center">{{number_format($service->price, 2, ',', '.')}}</td>
                            <td class="serviceVat center">{{getVatPercantageByCategory($service->vat_category)}}%</td>
                            <td class="serviceVat center">{{number_format($service->vat_amount, 2, ',', '.')}}</td>
                            <td class="serviceTotalPrice right-align">{{number_format(($service->price * $service->quantity) + $service->vat_amount, 2, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    @for($i = $invoice->services->count(); $i <= 4; $i++)
                        <tr>
                            <td colspan="6">&nbsp;</td>
                        </tr>
                    @endfor
                    <tr class="right-align">
                        <td colspan="4">ΣΥΝΟΛΟ ΑΞΙΩΝ:</td>
                        <td colspan="2" class="sinoloAxion" data-saprice="">
                            € {{number_format(getFinalPrices($invoice->hashID, 'invoice'), 2, ',', '.')}}</td>
                    </tr>
                    @foreach(getInvoiceTaxByCategory($invoice->hashID) as $key => $finalVat)
                        @if($key != 0)
                        <tr class="right-align">
                            <td colspan="4">Φ.Π.Α. <strong>({{$key}}%)</strong>:</td>
                            <td colspan="2" class="sinoloFpa">
                                € {{number_format($finalVat, 2, ',', '.')}}</td>
                        </tr>
                        @endif
                    @endforeach

                    <tr class="right-align">
                        <td colspan="4">ΓΕΝΙΚΟ ΣΥΝΟΛΟ:</td>
                        <td colspan="2" class="sinoloGeniko">
                            € {{number_format(getFinalPrices($invoice->hashID, 'invoice') + getInvoiceFinalTax($invoice->hashID), 2, ',', '.')}}</td>
                    </tr>

                    <tr class="right-align">
                        <td colspan="4"><strong>ΠΛΗΡΩΤΕΟ ΠΟΣΟ:</strong></td>
                        <td colspan="2" class="pliroteoPoso"><strong>€ @if(getFinalPrices($invoice->hashID, 'invoice') > 300 && $invoice->has_parakratisi == 1)
                                {{number_format(getFinalPrices($invoice->hashID, 'invoice') - ((20 / 100) * getFinalPrices($invoice->hashID, 'invoice')) + getInvoiceFinalTax($invoice->hashID), 2, ',', '.')}} @else
                                {{number_format(getFinalPrices($invoice->hashID, 'invoice') + getInvoiceFinalTax($invoice->hashID), 2, ',', '.')}}
                                @endif</strong></td>
                    </tr>
                    </tbody>
                </table>
                <div class="small-12 columns">
                    @if(isset($settings['signature']))
                    <div class="signature left">
                        <span class="invoice-color">Για τον εκδότη</span>
                        <img src="{{url('images/system/'.$settings['signature'])}}" alt="signature">
                    </div>
                    @endif
                    @if(isset($invoice->mark) && $invoice->mark > 0)
                    <div class="aade-mydata-mark">ΜΑΡΚ: {{$invoice->mark}}</div>
                    @endif
                    <div class="clear"></div>
                    <table class="invoiceform footer">
                        <tbody>
                        <tr>
                            @if(isset($settings['phone']))
                                <td><span class="invoice-color">Τηλ:</span> {{$settings['phone']}}</td>
                            @endif
                            @if(isset($settings['email']))
                            <td><span class="invoice-color">Email:</span> {{$settings['email']}}</td>
                                @endif
                            <td><span class="invoice-color">Χρήση:</span>ΠΕΛΑΤΗΣ</td>
                        </tr>
                        <tr>
                            <td><span class="invoice-color">Κιν:</span> {{$settings['mobile']  ?? 'not set'}}</td>
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
                    <div class="invoice-action-btn mb-2">
                        @if(isset($invoice->client->email))
                        <a href="{{route('invoice.mail', ['invoice' => $invoice->hashID])}}" id="sendEmail" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                            <i class="material-icons mr-4">mail</i>
                            <span class="text-nowrap">Αποστολή Τιμολογίου</span>
                        </a>
                        @endif
                    </div>
                    <div class="invoice-action-btn mb-2">
                        <a href="javascript:if(window.print)window.print()" class="btn-block btn  waves-effect waves-light invoice-print">
                            <i class="material-icons mr-4">print</i>
                            <span>Εκτύπωση</span>
                        </a>
                    </div>
                    @if(!$invoice->mark)
                    <div class="invoice-action-btn mb-2">
                        <a href="{{route('invoice.edit', $invoice->hashID)}}" class="btn-block btn  waves-effect waves-light">
                            <i class="material-icons mr-4">edit</i>
                            <span>Επεξεργασία</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn mb-2">
                        <a href="{{route('invoice.mydata', $invoice->hashID)}}" class="btn-block btn  waves-effect waves-light">
                            <i class="material-icons mr-4">backup</i>
                            <span>Αποστολή στο myData</span>
                        </a>
                    </div>
                    @endif
                    <div class="invoice-action-btn mb-2">
                        <a href="{{route('invoice.save', $invoice->hashID)}}" class="btn-block btn waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Δημιουργία PDF & Λήψη</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn mb-2">
                        <a href="{{route('invoice.download', $invoice->hashID)}}" class="btn-block btn waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Λήψη PDF</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn mb-2">
                        <a href="#" id="addPaymentsPage" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                            <i class="material-icons mr-3">euro_symbol</i>
                            <span class="text-nowrap">Εμφάνιση Τρόπων Πληρωμής</span>
                        </a>
                    </div>
                    @if($invoice->mark)
                    <div class="invoice-action-btn">
                        <a href="{{route('invoice.cancel', ['invoice' => $invoice->hashID])}}" class="btn waves-effect deep-orange accent-4 waves-light display-flex align-items-center justify-content-center">
                            <i class="material-icons mr-3">cancel</i>
                            <span class="text-nowrap">Ακύρωση Τιμολογίου</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="display-flex justify-content-center pb-2 print-hide">
                <form action="{{route('invoice.update-status', ['invoice' => $invoice->hashID])}}" method="get">
                    @csrf
                    <span class="center-align display-block">Πληρωμένο</span>
                    <div class="switch center-align">
                        <label>
                            <input type="checkbox" name="paid" id="payed"
                                   @if(isset($invoice->paid) && $invoice->paid == 1) checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                    <div class="invoice-action-btn payed-status-button" style="display: none">
                        <input type="submit" value="Ενημέρωση Κατάστασης" style="color: #fff;width: 100%;margin-top: 20px;" class="btn">
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="payments-page col s12" style="display: none">
        <div class="card">
            <h3>Διαθέσιμοι Τρόποι Πληρωμής</h3>
            @if(isset($settings['payment_methods'])) {!! html_entity_decode($settings['payment_methods']) !!} @endif
            <div class="clear"></div>
        </div>
    </div>
    <div class="ajax-preloader">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
    <script>
        @if(Session::has('notify'))
        M.toast({
            html: '{{Session::get("notify") }}',
            classes: 'rounded',
            timeout: 10000
        });
        @endif
    </script>
@endsection
@section('page-script')
    <script>
        $i = jQuery.noConflict();
        $i(document).ready(function(){
            $i('.ajax-preloader').removeClass('active');
            $i('#addPaymentsPage').on('click', function(e){
                e.preventDefault();
                $i('.payments-page').show();
            });
            $i('#payed').on('change', function(){
                $i('.payed-status-button').show();
            });
            $i('a#sendEmail').on('click', function(){
                $i('.ajax-preloader').addClass('active');
            });
        });
    </script>
@endsection
