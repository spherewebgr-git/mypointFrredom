{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if(isset($retail->seira))
@if($retail->seira == 'ANEY' || $retail->seira == 'ΑΝΕΥ')
    @section('title','Απόδειξη Λιανικής Πώλησης '.$retail->retailID ?? '')
@else
    @section('title','Απόδειξη Λιανικής Πώλησης '.$retail->seira.' '.$retail->retailID)
@endif
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
                    @if(isset($retail->seira))
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        @if($retail->seira == 'ANEY' || $retail->seira == 'ΑΝΕΥ')
                            <span>Απόδειξη Λιανικής Πώλησης {{$retail->retailID}}</span>
                        @else
                            <span>Απόδειξη Λιανικής Πώλησης {{$retail->seira.' '.$retail->retailID}}</span>
                        @endif
                    </h5>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="timologioContent row">
        <div class="invoice-table card col s9">
            <table class="invoiceform">
                <tbody>
                    <tr class="no-border">
                        @if(isset($settings['invoice_logo']))
                        <td>
                            <img src="{{url('images/system/'.$settings['invoice_logo'])}}"  alt="{{$settings['title'] ?? 'company'}} logo">
                        </td>
                        @endif
                        <td class="tim-info @if(isset($settings['invoice_logo'])) right @else left @endif" style="text-align: left">
                            <h4 class="invoice-color">{{$settings['title'] ?? ''}}</h4>
                            <h5 class="invoice-color">{{$settings['company'] ?? 'not set'}}</h5>
                            <p>{{$settings['business'] ?? 'not set'}}<br>{{$settings['address'] ?? 'not set'}}<br>Α.Φ.Μ.: {{$settings['vat'] ?? 'not set'}} -
                                ΔΟΥ: {{$settings['doy'] ?? 'not set'}}</p></td>
                    </tr>
                    <tr class="no-border">
                        <td>
                            <div class="tim-date"><span class="invoice-color">Ημερομηνία:</span>
                                <strong>{{\Carbon\Carbon::createFromTimestamp(strtotime($retail->date))->format('d/m/Y')}}</strong>
                            </div>
                        </td>
                        <td>
                            <p class="timNumber">ΑΠΟΔΕΙΞΗ ΛΙΑΝΙΚΗΣ ΠΩΛΗΣΗΣ | @if($retail->seira != 'ANEY') Σειρά: <span><strong class="invoice-color">{{$retail->seira}}</strong></span> @endif Αρ. Απόδειξης <span><strong class="invoice-color">{{$retail->retailID}}</strong></span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="clear"></div>
            <hr class="main-color">
            @if(isset($retail->client_description))
            <div class="timClient">
                <span class="invoice-color">Προς:</span>
                <textarea disabled style="border: none; font-weight: bold">{{$retail->client_description}}</textarea>
            </div>
            <hr class="main-color">
            @endif
            <div class="timTable small-12 columns">
                <table>
                    <tbody>
                        <tr>
                            <th style="width: 7%;background: #C62828" class="invoice-color-bg center">Ποσότητα</th>
                            <th style="width: 50%" class="invoice-color-bg">Περιγραφή</th>
                            <th style="width: 20%" class="center-align">Τρόπος Πληρωμής</th>
                            <th style="width: 13%" class="invoice-color-bg center">Τιμή Μονάδας</th>
                            <th style="width: 13%" class="invoice-color-bg center">Φ.Π.Α.</th>
                            <th style="width: 8%" class="invoice-color-bg center-align">Σύνολο</th>
                        </tr>
                        @foreach($retail->items as $item)
                        <tr>
                            <td class="center-align">{{$item->quantity}}</td>
                            <td>{{is_numeric($item->product_service) ? getProductByID($item->product_service)->product_name : $item->product_service}}</td>
                            <td class="center-align">{{getPaymentMethodName($item->payment_method)}}</td>
                            <td class="center-align">{{number_format(($item->price - $item->vat), 2, ',', '.')}}</td>
                            <td class="center-align">{{number_format($item->vat, 2, ',', '.')}}</td>
                            <td class="center-align">{{number_format(($item->quantity * $item->price), 2, ',', '.')}}</td>
                        </tr>
                        @endforeach
                        @for($i = $retail->items->count(); $i <= 5; $i++)
                            <tr>
                                <td colspan="6">&nbsp;</td>
                            </tr>
                        @endfor
                        <tr class="right-align">
                            <td colspan="4">ΣΥΝΟΛΟ ΑΞΙΩΝ:</td>
                            <td colspan="2" class="sinoloAxion" data-saprice="">
                                € {{number_format((getRetailPrices($retail)['full'] - getRetailPrices($retail)['vat']), 2, ',', '.')}}</td>
                        </tr>
                        <tr class="right-align">
                            <td colspan="4">Φ.Π.Α.:</td>
                            <td colspan="2" class="sinoloFpa">
                                € {{number_format(getRetailPrices($retail)['vat'], 2, ',', '.')}}</td>
                        </tr>
                        <tr class="right-align">
                            <td colspan="4">ΓΕΝΙΚΟ ΣΥΝΟΛΟ:</td>
                            <td colspan="2" class="sinoloGeniko">
                                € {{number_format(getRetailPrices($retail)['full'], 2, ',', '.')}}</td>
                        </tr>
                        <tr class="right-align">
                            <td colspan="4"><strong>ΠΛΗΡΩΤΕΟ ΠΟΣΟ:</strong></td>
                            <td colspan="2" class="pliroteoPoso"><strong>€ {{number_format(getRetailPrices($retail)['full'], 2, ',', '.')}}</strong></td>
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
                    @if(isset($retail->mark))
                        <div class="aade-mydata-mark">ΜΑΡΚ: {{$retail->mark}}</div>
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
                            <td><span class="invoice-color">Κιν:</span> {{$settings['mobile']  ?? ''}}</td>
                            @if(isset($settings['website']))
                            <td><span class="invoice-color">Web:</span> {{$settings['website']}}</td>
                            @endif
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
                        <a href="javascript:if(window.print)window.print()" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
                            <i class="material-icons mr-4">print</i>
                            <span>Εκτύπωση</span>
                        </a>
                    </div>
                    @if(!$retail->mark)
                        <div class="invoice-action-btn mb-2">
                            <a href="{{route('retail-receipts.edit', $retail->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <i class="material-icons mr-4">edit</i>
                                <span>Επεξεργασία</span>
                            </a>
                        </div>
                        <div class="invoice-action-btn mb-2">
                            <a href="{{route('retail-receipts.mydata', $retail->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                <i class="material-icons mr-4">backup</i>
                                <span>Αποστολή στο myData</span>
                            </a>
                        </div>
                    @endif
                    <div class="invoice-action-btn mb-2">
                        <a href="{{route('retail-receipts.save', $retail->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Δημιουργία PDF & Λήψη</span>
                        </a>
                    </div>
                    <div class="invoice-action-btn">
                        <a href="{{route('invoice.download', $retail->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                            <i class="material-icons mr-4">picture_as_pdf</i>
                            <span>Λήψη PDF</span>
                        </a>
                    </div>

                </div>
            </div>
            <div class="display-flex justify-content-center pb-2 print-hide">
                <form action="{{route('invoice.update-status', ['invoice' => $retail->hashID])}}" method="get">
                    @csrf
                    <span class="center-align display-block">Πληρωμένο</span>
                    <div class="switch center-align">
                        <label>
                            <input type="checkbox" name="paid" id="payed"
                                   @if(isset($retail->paid) && $retail->paid == 1) checked @endif>
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

@endsection
