{{-- extend Layout --}}
@extends('layouts.qrcodeRetailReceipt')

{{-- page title --}}
@section('title','Απόδειξη Λιανικής '. $retail->seira.'-'.str_pad($retail->retailID, 7, 0, STR_PAD_LEFT))

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/qrcode-retail-receipt.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/qrcode-retail-receipt.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="qrcode-retail-receipt-wrapper">
        <div class="row retail-receipt">
            <div class="retail-receipt--head">
                <div class="retail-receipt--head---invoiceType" style="background-color: <?php echo $settings['invoice_color'] ?>">
                    @if($settings['website'])
                    <a href="{{$settings['website']}}">
                        <div class="back"></div>
                    </a>
                    @endif
                    <h1>{{getInvoiceTypeName($retail->invoiceType)}}</h1>
                </div>
                <div class="retail-receipt--head---info">
                    <div class="retail-receipt--head---info-left">
                        @if(isset($settings['invoice_logo']))
                            <div class="retail-receipt--head---logo mb-1">
                                <img src="{{url('/images/system/'.$settings['invoice_logo'])}}" alt="company logo" />
                            </div>
                        @endif
                        <div class="info-items">
                            {{$settings['company']}}<br />
                            {{$settings['business']}}<br />
                            {{$settings['address']}}<br />
                            ΑΦΜ. {{$settings['vat']}} | ΔΟΥ. {{$settings['doy']}}<br />
                            @if(isset($settings['phone']))
                                Τηλέφωνο: {{$settings['phone']}}
                            @endif
                        </div>

                    </div>
                    <div class="retail-receipt--head---info-right">
                        <h2 style="color: <?php echo $settings['invoice_color'] ?>">ΑΠΟΔΕΙΞΗ</h2>
                        <div class="retail-number">@if($retail->seira != null && $retail->seira != 'ANEY'){{$retail->seira}}@endif{{str_pad($retail->retailID, 7, 0, STR_PAD_LEFT)}}</div>
                        <h4>Συνολικό Ποσό</h4>
                        <div class="retailValue">&euro; {{number_format(getRetailPrices($retail)['full'], 2, '.', '' )}}</div>
                    </div>
                </div>
            </div>

            <div class="retail-receipt--body">
                <h3>Στοιχεία Απόδειξης</h3>
                <div class="retail-receipt--body---left">
                    <div class="item">
                        <div class="item-title">Είδος Απόδειξης</div>
                        <div class="item-value">{{getInvoiceTypeName($retail->invoiceType)}}</div>
                    </div>
                    <div class="item">
                        <div class="item-title">Αριθμός Απόδειξης</div>
                        <div class="item-value">{{$retail->seira.'-'.str_pad($retail->retailID, 7, 0, STR_PAD_LEFT)}}</div>
                    </div>
                    <div class="item">
                        <div class="item-title">Τρόπος Πληρωμής</div>
                        <div class="item-value">{{getPaymentMethodName($retail->items[0]->payment_method)}}</div>
                    </div>
                </div>
                <div class="retail-receipt--body---right">
                    <div class="item">
                        <div class="item-title">Ημερομηνία Συναλλαγής</div>
                        <div class="item-value">{{\Carbon\Carbon::parse($retail->date)->format('d/m/Y')}}</div>
                    </div>
                    <div class="item">
                        <div class="item-title">Ώρα Συναλλαγής</div>
                        <div class="item-value">{{\Carbon\Carbon::parse($retail->date)->format('H:i:s')}}</div>
                    </div>
                    @if(isset($retail->mark))
                        <div class="item">
                            <div class="item-title">MyData ΜΑΡΚ</div>
                            <div class="item-value">{{$retail->mark}}</div>
                        </div>
                    @endif
                </div>
                <table>
                    <tr style="background-color: <?php echo $settings['invoice_color'] ?>">
                        <th style="width:65%">Είδος<br />Ποσ.</th>
                        <th>Τιμή</th>
                        <th>ΦΠΑ</th>
                        <th style="text-align: right;">Αξία</th>
                    </tr>
                    @foreach($retail->items as $item)
                        <tr class="product-head">
                            <td colspan="4" class="product-name">{{getProductByID($item->product_service)->product_name}}</td>
                        </tr>
                        <tr class="product-body">
                            <td>x{{$item->quantity}}</td>
                            <td>{{number_format($item->price, 2, '.', '')}}</td>
                            <td>{{number_format($item->vat, 2, '.', '')}}</td>
                            <td style="text-align: right;">{{number_format($item->quantity * $item->price, 2, '.', '')}}</td>
                        </tr>
                    @endforeach
                </table>

                <table class="synola">
                    <tr>
                        <td>Καθαρή Αξία</td>
                        <td class="right">&euro; {{  number_format( getRetailPrices($retail)['price'], 2, '.', '' )  }}</td>
                    </tr>
                    <tr>
                        <td><strong>Αξία Φ.Π.Α. (24%)</strong></td>
                        <td class="right"><strong>&euro; {{number_format(getRetailPrices($retail)['vat'], 2, '.', '') }}</strong></td>
                    </tr>
                    <tr class="total">
                        <td>Πληρωτέο</td>
                        <td class="right"><strong>&euro; {{number_format(getRetailPrices($retail)['full'], 2, '.', '' )}}</strong></td>
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

            </div>
        </div>
    </section>

@endsection
