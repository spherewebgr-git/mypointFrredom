{{-- extend Layout --}}
@extends('layouts.printRetailReceiptLayout')

{{-- page title --}}
@section('title','Εκτύπωση Απόδειξης Λιανικής')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/print-retail-receipt-big.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="print-retail-receipt-wrapper section">
        <div class="row retail-receipt">
            <div class="retail-receipt--head">
                @if(isset($settings['invoice_logo']))
                    <div class="retail-receipt--head---logo center mb-1">
                        <img src="{{url('/images/system/'.$settings['invoice_logo'])}}" alt="company logo" />
                    </div>
                @endif
                <div class="retail-receipt--head---info">
                    <p class="center">

                        {{$settings['company']}}<br />
                        {{$settings['business']}}<br />
                        {{$settings['address']}}<br />
                        ΑΦΜ. {{$settings['vat']}} | ΔΟΥ. {{$settings['doy']}}<br />
                        @if(isset($settings['phone']))
                        Τηλέφωνο: {{$settings['phone']}}
                        @endif
                    </p>

                    <table style="border-top: 2px dashed;border-bottom: 2px dashed">
                        <tr>
                            <td>@if($retail->seira != null && $retail->seira != 'ANEY'){{$retail->seira}}@endif{{str_pad($retail->retailID, 7, 0, STR_PAD_LEFT)}}</td>
                            <td class="right">{{getInvoiceTypeName($retail->invoiceType)}}</td>
                        </tr>
                        <tr>
                            <td>Ημερομηνία</td>
                            <td class="right">{{\Carbon\Carbon::parse($retail->date)->format('d/m/Y')}}</td>
                        </tr>
                        <tr>
                            <td>Τρόπος Πληρωμής</td>
                            <td class="right">{{getPaymentMethodName($retail->items[0]->payment_method)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="retail-receipt--body">

                <table>
                    <tr style="border-bottom: 2px dashed">
                        <th style="width:65%">Είδος<br />Ποσ.</th>
                        <th>Τιμή</th>
                        <th style="text-align: right;">Αξία</th>
                    </tr>
                    @if(isset($retail->items) && count($retail->items) > 0)
                    @foreach($retail->items as $item)
                    <tr>
                        <td colspan="4">{{getProductByID($item->product_service)->product_name ?? 'Πώληση Προϊόντων'}}</td>
                    </tr>
                    <tr>
                        <td>x{{$item->quantity}}</td>
                        <td>{{number_format($item->price + $item->vat, 2, '.', '')}}</td>
                        <td style="text-align: right;">{{number_format($item->quantity * ($item->price + $item->vat), 2, '.', '')}}</td>
                    </tr>
                    @endforeach
                    @endif
                </table>
                <p style="border-bottom: 2px dashed"><strong>Σύνολα</strong></p>
                <table>
                    <tr>
                        <td>Καθαρή Αξία</td>
                        <td class="right">&euro; {{  number_format( getRetailPrices($retail)['price'], 2, '.', '' )  }}</td>
                    </tr>
                    <tr>
                        <td>Αξία Φ.Π.Α. (13%)</td>
                        <td class="right">&euro; {{number_format(getRetailPrices($retail)['vat'], 2, '.', '') }}</td>
                    </tr>
                    <tr>
                        <td>Πληρωτέο</td>
                        <td class="right">&euro; {{number_format(getRetailPrices($retail)['full'], 2, '.', '' )}}</td>
                    </tr>
                </table>
                @if(isset($retail->description))
                    <p><strong>Σχόλια</strong></p>
                    <table>
                        <tr>
                            <td><p>{{$retail->description }}</p></td>
                        </tr>
                    </table>
                @endif
                @if(isset($retail->mark))
                <table style="margin: 35px 0">
                    <tr>
                        <td>ΜΑΡΚ</td>
                        <td>{{$retail->mark}}</td>
                    </tr>
                </table>
                @endif
                <div style="text-align: center">
                <img style="margin: -20px 0" src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo url('/').'/retailReceiptQRCode/'.$retail->hashID;?>&choe=UTF-8" title="Link to Google.com" />
                </div>
            </div>
            <div class="retail-receipt--footer center">
                <div class="legal">***** Νόμιμη Απόδειξη *****</div>
                Ευχαριστούμε για την προτίμησή σας.
            </div>
        </div>
    </section>
@endsection
