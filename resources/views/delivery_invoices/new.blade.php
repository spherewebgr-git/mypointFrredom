{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if(isset($invoice->sale_invoiceID))
    @section('title','Επεξεργασία Τιμολογίου - Δελτίου Αποστολής')
@else
    @section('title','Νέο Τιμολόγιο - Δελτίο Αποστολής')
@endif
{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <!-- invoice view page -->
            <form class="form invoice-item-repeater"
                  @if(isset($invoice->delivery_invoice_id)) action="{{route('delivery_invoice.update', ['invoice' => $invoice->hashID])}}"
                  @else action="{{route('delivery_invoice.store')}}" @endif method="post">
                @csrf
                <div class="col xl9 m8 s12">
                    <div class="card">
                        <div class="card-content px-36">
                            <div class="progress" style="display: none">
                                <div class="indeterminate"></div>
                            </div>
                            <!-- header section -->
                            <div class="row mb-3">
                                <div class="col xl4 m12 display-flex align-items-center">
                                    <h6 class="invoice-number mr-4 mb-5">Σειρά: </h6>
                                    <select name="seira" id="seira">
                                        @foreach($seires as $seira)
                                            <option value="{{$seira->letter}}" @if(isset($invoice->seira) && $invoice->seira == $seira->letter) selected @endif>{{$seira->letter}}</option>
                                        @endforeach
                                    </select>
                                    <h6 class="invoice-number mr-4 mb-5 ml-4">Τ.Δ.Α. # </h6>
                                    <input type="text" name="delivery_invoice_id" placeholder="000" id="delivery_invoice_id"
                                           @if(isset($invoice))
                                           value="{{old('delivery_invoice_id', $invoice->delivery_invoice_id)}}"
                                           @elseif(isset($last) && $last != '') value="{{$last + 1}}" @endif>
                                </div>
                                <div class="col xl4 m6 display-flex align-items-center" style="gap: 10px">
                                    <small>Τρόπος Πληρωμής: </small>
                                    <select name="paymentMethod" id="paymentMethod">
                                        <option value="1" @if(isset($invoice->payment_method) && $invoice->payment_method == 1) selected @endif>Επαγ. Λογαριασμός Πληρωμών Ημεδαπής</option>
                                        <option value="2" @if(isset($invoice->payment_method) && $invoice->payment_method == 2) selected @endif>Επαγ. Λογαριασμός Πληρωμών Αλλοδαπής</option>
                                        <option value="3" @if(isset($invoice->payment_method) && $invoice->payment_method == 3) selected @endif>Μετρητά</option>
                                        <option value="4" @if(isset($invoice->payment_method) && $invoice->payment_method == 4) selected @endif>Επιταγή</option>
                                        <option value="5" @if(!isset($invoice->payment_method) || $invoice->payment_method == 5) selected @endif>Επί Πιστώσει</option>
                                    </select>
                                </div>
                                <div class="col xl4 m12">
                                    <div class="invoice-date-picker display-flex align-items-center">
                                        <div class="display-flex align-items-center">
                                            <small>Ημ/νία Έκδοσης: </small>
                                            <div class="display-flex ml-4">
                                                <input type="text" class="datepicker mb-1" name="date"
                                                       placeholder="Επιλέξτε Ημ/νία"
                                                       @if(isset($invoice->date))
                                                       value="{{\Carbon\Carbon::parse($invoice->date)->format('d/m/Y')}}"
                                                       @else
                                                       value="{{date('d/m/Y')}}
                                                       @endif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- invoice address and contact -->
                            <div class="row mb-3">
                                <div class="col l4 s12">
                                    <h6>Αποστολή από:</h6>
                                    <div class="divider"></div>
                                    <div class="col s12  input-field">
                                        <div class="col s12">
                                            <label class="m-0" for="client">Διεύθυνση Επιχείρησης</label>
                                        </div>
                                        @if(count($addresses) > 1)
                                            <select class="invoice-item-select browser-default" id="sendFrom" name="sendFrom">
                                                <option value="" selected disabled>Επιλέξτε Διεύθυνση</option>
                                                @foreach($addresses as $address)
                                                    <option @if($address->type == 'address_0_edra') selected @endif value="{{$address->type}}">{{$address->value}}</option>
                                                @endforeach
                                            </select>
                                        @elseif(count($addresses) == 1)
                                            <p>{{$addresses[0]->value}}</p>
                                            <input type="hidden" name="sendFrom" value="address_0_edra" />
                                        @endif
                                    </div>
                                </div>

                                <div class="col l8 s12">
                                    <h6>Αποστολή προς:</h6>
                                    <div class="divider"></div>
                                    <div class="col s12 m6  input-field">
                                        <div class="col s12">
                                            <label class="m-0" for="client">Πελάτης</label>
                                        </div>
                                        <select class="invoice-item-select browser-default" id="client" name="client">
                                            <option value="" selected disabled>Επιλέξτε Πελάτη</option>
                                            @foreach($clients as $client)
                                                @if($client->disabled != 1)
                                                    <option @if(isset($invoice))
                                                                @if($invoice->client_id == $client->id)
                                                                    selected
                                                            @endif
                                                            @endif data-client-hash="{{$client->hashID}}" value="{{$client->id}}">{{$client->company}}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col s12 m6  input-field">
                                        <div class="col s12">
                                            <label class="m-0" for="clientAddress">Διεύθυνση Πελάτη</label>
                                        </div>
                                        <select class="invoice-item-select browser-default" id="clientAddress" name="clientAddress">
                                            <option value="" selected disabled>Επιλέξτε Διεύθυνση</option>
                                            @if(isset($clientAddresses))
                                                @foreach($clientAddresses as $caddress)
                                                <option value="{{$caddress->id}}" @if($caddress->id == $selectedAddress->id) selected @endif>{{$caddress->address.' '.$caddress->number.' - '.$caddress->city}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- product details table-->
                            <div class="invoice-product-details mb-3">
                                <div data-repeater-list="products">
                                    @if(isset($invoice->hashID) && count($invoice->deliveredGoods) > 0)
                                        @foreach($invoice->deliveredGoods as $good)
                                            <div class="mb-2 count-repeater" data-repeater-item="">
                                                <input type="hidden" name="id" value="{{$good->id}}">
                                                <!-- invoice Titles -->
                                                <div class="row mb-1">
                                                    <div class="col s2 m1">
                                                        <h6 class="m-0">Ποσότητα</h6>
                                                    </div>
                                                    <div class="col s1 m1">
                                                        <h6 class="m-0">Μ.Μ.</h6>
                                                    </div>
                                                    <div class="col s3 m8">
                                                        <h6 class="m-0">Προϊόν</h6>
                                                    </div>
                                                    <div class="col s2 m2">
                                                        <h6 style="margin-left: -40px">Τιμή Μονάδας</h6>
                                                    </div>

                                                </div>
                                                <div class="invoice-item display-flex">
                                                    <div class="invoice-item-filed row pt-1" style="width: 100%">
                                                        <div class="col m1 s12 input-field">
                                                            <input type="text" value="{{$good->quantity}}" name="quantity"
                                                                   class="quantity-field">
                                                        </div>
                                                        <div class="col m1 s12 input-field">
                                                            <input type="text" value="{{ getMmType($good->delivered_good_id) }}"
                                                                   class="mm-field" disabled>
                                                        </div>
                                                        <div class="col m8 s12 input-field">
                                                            <select name="product" id="product" class="product-selection browser-default">
                                                                <option selected disabled>Επιλέξτε Προϊόν</option>
                                                                @foreach($products as $product)
                                                                    <option value="{{$product->id}}" data-price="{{$product->price}}" @if($product->id == $good->delivered_good_id) selected @endif>{{$product->product_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col m2 s12 input-field">
                                                            <input type="text" placeholder="000" name="price"
                                                                   class="price-field" value="{{$good->product_price}}">
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="invoice-icon display-flex flex-column justify-content-between">
                                                  <span data-repeater-delete="" class="delete-row-btn">
                                                    <i class="material-icons">clear</i>
                                                  </span>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @else
                                        <div class="mb-2 count-repeater" data-repeater-item="">
                                            <!-- invoice Titles -->
                                            <div class="row mb-1">
                                                <div class="col s2 m2">
                                                    <h6 class="m-0">Ποσότητα</h6>
                                                </div>
                                                <div class="col s3 m8">
                                                    <h6 class="m-0">Προϊόν</h6>
                                                </div>
                                                <div class="col s2 m2">
                                                    <h6 style="margin-left: -40px">Τιμή Μονάδας</h6>
                                                </div>

                                            </div>
                                            <div class="invoice-item display-flex">
                                                <div class="invoice-item-filed row pt-1" style="width: 100%">
                                                    <div class="col m2 s12 input-field">
                                                        <input type="text" value="1" name="quantity"
                                                               class="quantity-field">
                                                    </div>
                                                    <div class="col m8 s12 input-field">
                                                        <select name="product" id="product" class="product-selection browser-default">
                                                            <option selected disabled>Επιλέξτε Προϊόν</option>
                                                            @foreach($products as $product)
                                                                <option value="{{$product->id}}" data-price="{{$product->price}}">{{$product->product_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col m2 s12 input-field">
                                                        <input type="text" placeholder="000" name="price"
                                                               class="price-field">
                                                    </div>
                                                </div>
                                                <div
                                                    class="invoice-icon display-flex flex-column justify-content-between">
                                                  <span data-repeater-delete="" class="delete-row-btn">
                                                    <i class="material-icons">clear</i>
                                                  </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="input-field">
                                    <button class="btn invoice-repeat-btn" data-repeater-create="" type="button">
                                        <i class="material-icons left">add</i>
                                        <span>Προσθήκη Γραμμής</span>
                                    </button>
                                </div>

                            </div>
                            <!-- invoice subtotal -->
                            <div class="invoice-subtotal">
                                <div class="row">
                                    <div class="col m5 s12">

                                    </div>
                                    <div class="col xl4 m7 s12 offset-xl3">
                                        <ul>
                                            <li class="display-flex justify-content-between">
                                                <span class="invoice-subtotal-title">Υποσύνολο</span>
                                                <h6 class="invoice-subtotal-value">&euro; <span
                                                        id="subtotal">00.00</span></h6>
                                            </li>
                                            <li class="display-flex justify-content-between">
                                                <span class="invoice-subtotal-title">Φ.Π.Α. (24%)</span>
                                                <h6 class="invoice-subtotal-value">&euro; <span id="fpa">00.00</span>
                                                </h6>
                                            </li>
                                            <li>
                                                <div class="divider mt-2 mb-2"></div>
                                            </li>
                                            <li class="display-flex justify-content-between">
                                                <span class="invoice-subtotal-title">Συνολικό Ποσό</span>
                                                <h6 class="invoice-subtotal-value">&euro; <span
                                                        id="finalPrice">00.00</span></h6>
                                            </li>
                                            <li class="display-flex justify-content-between">
                                                <span class="invoice-subtotal-title">Πληρωτέο</span>
                                                <h6 class="invoice-subtotal-value" style="font-weight: bold">&euro;
                                                    <span id="toPay">00.00</span></h6>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- invoice action  -->
                <div class="col xl3 m4 s12">
                    <div class="card invoice-action-wrapper mb-10">
                        <div class="card-content">

                            @if(!isset($invoice->mark))
                                <div class="invoice-action-btn">
                                    <div class="invoice-action-btn">
                                        <a href="{{route('delivery_invoice.mydata', $invoice->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                            <i class="material-icons mr-4">backup</i>
                                            <span>Αποστολή στο myData</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="invoice-action-btn">
                                @if(isset($invoice->delivery_invoice_id))
                                    <input type="submit" value="Ενημέρωση Τιμολογίου" style="color: #fff;width: 100%;"
                                           class="btn display-flex align-items-center justify-content-center">
                                @else
                                    <input type="submit" value="Καταχώρηση Τιμολογίου" style="color: #fff;width: 100%;"
                                           class="btn display-flex align-items-center justify-content-center">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="invoice-terms display-flex flex-column" style="margin-top: 8rem;">
                        <div class="display-flex justify-content-between pb-2">
                            <span>Να σταλεί και στον πελάτη</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" name="sendClient">
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </div>
                        <div class="display-flex justify-content-between pb-2">
                            <span>Πληρωμένο</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" name="paid"
                                           @if(isset($invoice->paid) && $invoice->paid == 1) checked @endif>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="ajax-preloader">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    <script src="{{asset('vendors/form_repeater/jquery.repeater.min.js')}}"></script>
@endsection
@section('page-script')
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function () {
            $m(this).countPrices();
            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif

            $m('select#client').on('change', function () {
                $m('.ajax-preloader').addClass('active');
                let pageToken = $m('meta[name="csrf-token"]').attr('content');
                let clientHash = $m('select#client option:selected').data('client-hash');

                $m.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': pageToken
                    }
                });

                $m.ajax({
                    url: "{{ url('/client-address-ajax') }}",
                    method: 'post',
                    data: {
                        client: clientHash
                    },
                    success: function (result) {
                        //console.log(result);
                        $m('.ajax-preloader').removeClass('active');
                        $m('select#clientAddress option').remove();
                        //console.log(result);
                        $m.each(result, function(k, v){
                            let number = '';
                            if(v.number > 0) {
                               number = v.number;
                            }
                            let fullAddress = v.address + ' ' + number + ' - ' + v.city;
                            $m('select#clientAddress').append('<option value="'+v.id+'">'+fullAddress+'</option>');
                            console.log(v.id)
                        });
                    }
                });

            });

            $m('select#seira').on('change', function () {
                $m('.ajax-preloader').addClass('active');

                let invoiceLetter = $m('select#seira option:selected').text();

                let pageToken = $m('meta[name="csrf-token"]').attr('content');

                $m.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': pageToken
                    }
                });

                $m.ajax({
                    url: "{{ url('/last-invoice-ajax') }}",
                    method: 'post',
                    data: {
                        seira: invoiceLetter
                    },
                    success: function (result) {
                        console.log(result);
                        $m('.ajax-preloader').removeClass('active');
                        $m('input#invoiceID').val(result);
                    }
                });
            });

        });
        $m('input[type="submit"]').on('click', function () {
            $m('.progress').show();
        })
        $m.fn.countPrices = function () {
            let finalPrice = 0;
            $m('.count-repeater').each(function () {
                let quantity = $m(this).find('.quantity-field').val();
                let price = $m(this).find('.price-field').val();
                finalPrice += quantity * price;
            });
            $m('#subtotal').text(parseFloat(finalPrice).toFixed(2));
            $m('#fpa').text(parseFloat((24 / 100) * finalPrice).toFixed(2));
            $m('#finalPrice').text(parseFloat((24 / 100) * finalPrice + finalPrice).toFixed(2));
            if (finalPrice > 300 && $m('input#hasParakratisi').is(':checked')) {
                $m('#parakratisi').text(parseFloat((20 / 100) * finalPrice).toFixed(2));
                $m('#toPay').text(parseFloat((24 / 100) * finalPrice + finalPrice - (20 / 100) * finalPrice).toFixed(2));
                $m('#parakratisiTotal').show();
            } else {
                $m('#parakratisi').text(parseFloat(0).toFixed(2));
                $m('#toPay').text(parseFloat((24 / 100) * finalPrice + finalPrice).toFixed(2));
                $m('#parakratisiTotal').hide();
            }
        }

        $m(document).on('mouseout', '.count-repeater', function () {
            $m(this).countPrices();
        });
        $m(document).on('change', 'select.product-selection', function(){
            let productId = $m(this).attr('name').replace(/[^0-9]/g,'');
            let productPrice = $m(this).find('option:selected').data('price');

            $m('input[name="products['+productId+'][price]"]').val(productPrice);
            //console.log(productId);
        });

    </script>

@endsection
