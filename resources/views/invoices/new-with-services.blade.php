{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Νέο Τιμολόγιο')

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
            <form class="form invoice-item-repeater" action="{{route('invoice.store')}}" method="post">
                @csrf
                <div class="col xl9 m8 s12">
                    <div class="card">
                        <div class="card-content px-36">
                            <div class="progress" style="display: none">
                                <div class="indeterminate"></div>
                            </div>
                            {{$last}}
                            <!-- header section -->
                            <div class="row mb-3">
                                <div class="col xl4 m12 display-flex align-items-center">
                                    <h6 class="invoice-number mr-4 mb-5">Τ.Π.Υ# </h6>
                                    <input type="text" name="invoiceID" placeholder="000"
                                            value="{{$last + 1}}">
                                </div>
                                <div class="col xl8 m12">
                                    <div class="invoice-date-picker display-flex align-items-center">
                                        <div class="display-flex align-items-center">
                                            <small>Ημ/νία Έκδοσης: </small>
                                            <div class="display-flex ml-4">
                                                <input type="text" class="datepicker mb-1" name="date"
                                                       placeholder="Επιλέξτε Ημ/νία" value="{{date('d/m/Y')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- invoice address and contact -->
                            <div class="row mb-3">
                                <div class="col l6 s12">
                                    <h6>Χρέωση σε</h6>
                                    <div class="col s12  input-field">
                                        <div class="col s3 m4">
                                            <label class="m-0" for="client">Πελάτης</label>
                                        </div>
                                        <select class="invoice-item-select browser-default" id="client" name="client">
                                            <option value="" selected disabled>Επιλέξτε Πελάτη</option>
                                            @foreach($clients as $client)
                                                @if($client->disabled != 1)
                                                    <option @if($cli->id == $client->id) selected
                                                            @endif value="{{$client->id}}">{{$client->company}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- product details table-->
                            <div class="invoice-product-details mb-3">

                                <div data-repeater-list="services">
                                    @if(isset($services))
                                        @foreach($services as $service)
                                            <div class="mb-2 count-repeater" data-repeater-item="">
                                                <!-- invoice Titles -->
                                                <div class="row mb-1">
                                                    <div class="col s2">
                                                        <h6 class="m-0">Ποσότητα</h6>
                                                    </div>
                                                    <div class="col s3 m8">
                                                        <h6 class="m-0">Περιγραφή</h6>
                                                    </div>
                                                    <div class="col s2">
                                                        <h6 style="margin-left: -40px">Τιμή</h6>
                                                    </div>

                                                </div>
                                                <div class="invoice-item display-flex">
                                                    <div class="invoice-item-filed row pt-1" style="width: 100%">
                                                        <div class="col m2 s12 input-field">
                                                            <input type="hidden" name="id" value="{{$service->id}}">
                                                            <input type="text" value="{{$service->quantity}}" name="quantity"
                                                                   class="quantity-field">
                                                        </div>
                                                        <div class="col m8 s12 input-field">
                                                        <textarea class="materialize-textarea"
                                                                  name="description">{{$service->description}}</textarea>
                                                        </div>

                                                        <div class="col m2 s12 input-field">
                                                            <input type="text" placeholder="000" name="price"
                                                                   class="price-field" value="{{$service->price}}">
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
                                                <div class="col s2">
                                                    <h6 class="m-0">Ποσότητα</h6>
                                                </div>
                                                <div class="col s3 m8">
                                                    <h6 class="m-0">Περιγραφή</h6>
                                                </div>
                                                <div class="col s2">
                                                    <h6 style="margin-left: -40px">Τιμή</h6>
                                                </div>

                                            </div>
                                            <div class="invoice-item display-flex">
                                                <div class="invoice-item-filed row pt-1" style="width: 100%">
                                                    <div class="col m2 s12 input-field">
                                                        <input type="text" value="1" name="quantity"
                                                               class="quantity-field">
                                                    </div>
                                                    <div class="col m8 s12 input-field">
                                                        <textarea class="materialize-textarea"
                                                                  name="description"></textarea>
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
                                        <span>Προσθήκη Υπηρεσίας</span>
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
                                                <span class="invoice-subtotal-title">Παρακράτηση</span>
                                                <h6 class="invoice-subtotal-value">&euro; <span
                                                        id="parakratisi">00.00</span></h6>
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
                            <div class="invoice-action-btn">
                                <input type="submit" value="Καταχώρηση Τιμολογίου" style="color: #fff;width: 100%;"
                                       class="btn display-flex align-items-center justify-content-center">
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
                                    <input type="checkbox" name="paid">
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
{{-- scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/form_repeater/jquery.repeater.min.js')}}"></script>
@endsection

{{-- scripts --}}
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
            if (finalPrice > 300) {
                $m('#parakratisi').text(parseFloat((20 / 100) * finalPrice).toFixed(2));
                $m('#toPay').text(parseFloat((24 / 100) * finalPrice + finalPrice - (20 / 100) * finalPrice).toFixed(2));
            } else {
                $m('#parakratisi').text(parseFloat(0).toFixed(2));
                $m('#toPay').text(parseFloat((24 / 100) * finalPrice + finalPrice).toFixed(2));
            }
        }

        $m(document).on('mouseout', '.count-repeater', function () {
            $m(this).countPrices();
        });


    </script>

@endsection
