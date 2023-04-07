{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Νέα Απόδειξη Λιανικής')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <form class="form invoice-item-repeater" @if(isset($retail->retailID)) action="{{route('retail-receipts.update', $retail->hashID)}}" @else action="{{route('retail-receipts.store')}}" @endif method="post">
                @csrf
                <input type="hidden" name="retail_type" id="retailType">
                <div class="col xl9 m10 s12">
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
                                            <option value="{{$seira->letter}}"
                                                    @if(isset($retail->seira) && $retail->seira == $seira->letter) selected @endif>{{$seira->letter}}</option>
                                        @endforeach
                                    </select>
                                    <h6 class="invoice-number mr-4 mb-5 ml-4"> # </h6>
                                    <input type="text" name="retailID" placeholder="000" id="retailID"
                                           @if(isset($retail))
                                               value="{{old('retailID', $retail->retailID)}}"
                                           disabled @elseif(isset($last) && $last != '') value="{{$last + 1}}" @endif>
                                </div>
                                <div class="col xl8 m12">
                                    <div class="invoice-date-picker display-flex align-items-center">
                                        <div class="display-flex align-items-center">
                                            <small>Ημ/νία Έκδοσης: </small>
                                            <div class="display-flex ml-4">
                                                <input type="text" class="datepicker mb-1" name="date"
                                                       placeholder="Επιλέξτε Ημ/νία"
                                                       @if(isset($retail->date))
                                                           value="{{\Carbon\Carbon::parse($retail->date)->format('d/m/Y')}}"
                                                       @else
                                                           value="{{date('d/m/Y')}}
                                                       @endif"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col s12">
                                    <h6 class="invoice-number mr-4 mb-2">Στοιχεία Πελάτη: </h6>
                                    <div class="input-field">
                                        <textarea name="client_description" id="client_description" class="materialize-textarea">@if(isset($retail)) {{$retail->client_description}} @endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- product details table-->
                            <div class="invoice-product-details mb-3">
                                <div data-repeater-list="services">
                                    @if(isset($retail) && count($retail->items) > 0)
                                        @foreach($retail->items as $service)
                                            <div class="mb-2 count-repeater" data-repeater-item="">
                                                <!-- invoice Titles -->
                                                <div class="row mb-1">
                                                    <div class="col s12 m5">
                                                        <h6 class="m-0">Προϊόν/Υπηρεσία</h6>
                                                    </div>
                                                    <div class="col s12 m2">
                                                        <h6 class="m-0">Συντελεστής ΦΠΑ</h6>
                                                    </div>
                                                    <div class="col s12 m4">
                                                        <h6 class="m-0">Τρόπος Πληρωμής</h6>
                                                    </div>
                                                    <div class="col s12 m1">
                                                        <h6 style="margin-left: -40px">Τιμή</h6>
                                                    </div>
                                                    <div class="col s12 m1">
                                                        <h6 style="margin-left: -40px">ΦΠΑ</h6>
                                                    </div>
                                                </div>
                                                <div class="invoice-item display-flex">
                                                    <div class="invoice-item-filed row pt-1" style="width: 100%">
                                                        <div class="col m5 s12 input-field">
                                                            <input type="text" value="{{$service->product_service}}" name="product_service"
                                                                   class="product-field">
                                                        </div>
                                                        <div class="col m2 s12 input-field">
                                                            <select name="vat_id" id="vat_id" class="invoice-item-select browser-default">
                                                                <option value="1" @if($service->vat_id == 1) selected @endif>24%</option>
                                                                <option value="4" @if($service->vat_id == 4) selected @endif>17%</option>
                                                                <option value="2" @if($service->vat_id == 2) selected @endif>13%</option>
                                                                <option value="5" @if($service->vat_id == 5) selected @endif>9%</option>
                                                                <option value="3" @if($service->vat_id == 3) selected @endif>6%</option>
                                                                <option value="6" @if($service->vat_id == 6) selected @endif>4%</option>
                                                                <option value="7" @if($service->vat_id == 7) selected @endif>0%</option>
                                                                <option value="8" @if($service->vat_id == 8) selected @endif>Μισθοδοσία, Αποσβέσεις κλπ.</option>
                                                            </select>
                                                        </div>

                                                        <div class="col m3 s12 input-field">
                                                            <select name="payment_method" id="payment_method" class="invoice-item-select browser-default">
                                                                <option value="1" @if($service->payment_method == 1) selected @endif>Επαγ. Λογαριασμός Πληρωμών Ημεδαπής</option>
                                                                <option value="2" @if($service->payment_method == 2) selected @endif>Επαγ. Λογαριασμός Πληρωμών Αλλοδαπής</option>
                                                                <option value="3" @if($service->payment_method == 3) selected @endif>Μετρητά</option>
                                                                <option value="4" @if($service->payment_method == 4) selected @endif>Επιταγή</option>
                                                                <option value="5" @if($service->payment_method == 5) selected @endif>Επί Πιστώσει</option>
                                                                <option value="6" @if($service->payment_method == 6) selected @endif>Web Banking</option>
                                                                <option value="7" @if($service->payment_method == 7) selected @endif>POS / e-POS</option>
                                                            </select>
                                                        </div>
                                                        <div class="col m1 s12 input-field">
                                                            <input type="text" value="{{$service->price}}" name="price" placeholder="0.00"
                                                                   class="price-field">
                                                        </div>
                                                        <div class="col m1 s12 input-field">
                                                            <input type="text" value="{{$service->vat}}" name="vat" placeholder="0.00"
                                                                   class="vat-field">
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="invoice-icon display-flex flex-column justify-content-between">
                                                  <span data-repeater-delete="" class="delete-row-btn">
                                                    <i class="material-icons">clear</i>
                                                  </span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="item" value="{{$service->id}}">
                                            </div>

                                        @endforeach
                                    @else
                                        <div class="mb-2 count-repeater" data-repeater-item="">
                                            <!-- invoice Titles -->
                                            <div class="row mb-1">
                                                <div class="col s12 m5">
                                                    <h6 class="m-0">Προϊόν/Υπηρεσία</h6>
                                                </div>
                                                <div class="col s12 m2">
                                                    <h6 class="m-0" title="Συντελεστής ΦΠΑ">Συντελεστής ΦΠΑ</h6>
                                                </div>
                                                <div class="col s12 m2">
                                                    <h6 class="m-0" title="Τρόπος Πληρωμής">Πληρωμή</h6>
                                                </div>
                                                <div class="col s12 m1">
                                                    <h6 style="margin-left: -40px">Ποσότητα</h6>
                                                </div>
                                                <div class="col s12 m1">
                                                    <h6 style="margin-left: -40px">Τιμή</h6>
                                                </div>
                                                <div class="col s12 m1">
                                                    <h6 style="margin-left: -40px">ΦΠΑ</h6>
                                                </div>
                                            </div>
                                            <div class="invoice-item display-flex">
                                                <div class="invoice-item-filed row pt-1" style="width: 100%">
                                                    <div class="col m5 s12 input-field">
                                                        <input type="text" value="" name="product_service"
                                                               class="product_service-field">
                                                        <select name="product" class="product-field invoice-item-select browser-default" style="display: none">
                                                            <option value="" disabled selected>Επιλέξτε Προϊόν</option>
                                                            @foreach($products as $product)
                                                                <option
                                                                    value="{{$product->id}}"
                                                                    data-vatId="{{$product->product_vat_id}}"
                                                                    data-price="{{$product->retail_price}}"
                                                                    data-vat="{{$product->vat_price}}">{{$product->product_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col m2 s12 input-field">
                                                        <select name="vat_id" id="vat_id" class="invoice-item-select browser-default">
                                                            <option value="1">24%</option>
                                                            <option value="4">17%</option>
                                                            <option value="2">13%</option>
                                                            <option value="5">9%</option>
                                                            <option value="3">6%</option>
                                                            <option value="6">4%</option>
                                                            <option value="7">0%</option>
                                                            <option value="8">Μισθοδοσία, Αποσβέσεις κλπ.</option>
                                                        </select>
                                                    </div>

                                                    <div class="col m2 s12 input-field">
                                                        <select name="payment_method" id="payment_method" class="invoice-item-select browser-default">
                                                            <option value="1">Επαγ. Λογαριασμός Πληρωμών Ημεδαπής</option>
                                                            <option value="2">Επαγ. Λογαριασμός Πληρωμών Αλλοδαπής</option>
                                                            <option value="3" selected>Μετρητά</option>
                                                            <option value="4">Επιταγή</option>
                                                            <option value="5">Επί Πιστώσει</option>
                                                            <option value="6">Web Banking</option>
                                                            <option value="7">POS / e-POS</option>
                                                        </select>
                                                    </div>
                                                    <div class="col m1 s12 input-field">
                                                        <input type="number" value="1" name="quantity" placeholder="0"
                                                               class="quantity-field" style="text-align: center">
                                                    </div>
                                                    <div class="col m1 s12 input-field">
                                                        <input type="text" value="" name="price" placeholder="0.00"
                                                               class="price-field">
                                                    </div>
                                                    <div class="col m1 s12 input-field">
                                                        <input type="text" value="" name="vat" placeholder="0.00"
                                                               class="vat-field">
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
                                            <li class="display-flex justify-content-between" id="parakratisiTotal">
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
                <!-- Sidebar -->
                <div class="col xl3 m2 s12">
                    <div class="card invoice-action-wrapper mb-10">
                        <div class="card-content">
                            <div class="invoice-action-btn">
                                @if(isset($retail) && !isset($retail->mark))

                                        <a href="{{route('retail-receipts.mydata', $retail->hashID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                            <i class="material-icons mr-4">backup</i>
                                            <span>Αποστολή στο myData</span>
                                        </a>

                                @endif
                                @if(isset($retail->retailID))
                                    <input type="submit" value="Ενημέρωση Απόδειξης Λιανικής" style="color: #fff;width: 100%;"
                                           class="btn display-flex align-items-center justify-content-center">
                                @else
                                    <input type="submit" value="Έκδοση Απόδειξης Λιανικής" style="color: #fff;width: 100%;"
                                           class="btn display-flex align-items-center justify-content-center">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="invoice-terms display-flex flex-column" style="margin-top: 8rem;">
                        <div class="display-flex justify-content-between pb-2">
                            <span>Εκτύπωση μετά την έκδοση</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" name="printNow" checked>
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
        $r = jQuery.noConflict();
        $r(document).ready(function() {
            $r('select#seira').on('change', function () {
                $r('.ajax-preloader').addClass('active');

                let retailLetter = $r('select#seira option:selected').text();

                if(retailLetter.indexOf('ΑΛΠ') === 0) {
                    $r('.product_service-field').hide();
                    $r('.product-field').show();
                    $r('#retailType').val('11.1');
                } else {
                    $r('.product_service-field').show();
                    $r('.product-field').hide();
                    $r('#retailType').val('11.2');
                }

                let pageToken = $r('meta[name="csrf-token"]').attr('content');

                $r.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': pageToken
                    }
                });

                $r.ajax({
                    url: "{{ url('/last-retail-ajax') }}",
                    method: 'post',
                    data: {
                        seira: retailLetter
                    },
                    success: function (result) {
                        $r('.ajax-preloader').removeClass('active');
                        $r('input#retailID').val(result);
                    }
                });
            });


            $r('button.invoice-repeat-btn').on('click', function(){
                let retailLetter = $r('select#seira option:selected').text();

                if(retailLetter.indexOf('ΑΛΠ') === 0) {
                    $r('.product_service-field').hide();
                    $r('.product-field').show();
                } else {
                    $r('.product_service-field').show();
                    $r('.product-field').hide();
                }
               console.log('repeater clicked');
            });
        });

        $r('input[type="submit"]').on('click', function () {
            $r('.progress').show();
        })
        $r.fn.countPrices = function () {
            let finalPrice = 0.00;
            $r('.count-repeater').each(function () {
                let price = parseFloat($r(this).find('.price-field').val() * $r(this).find('.quantity-field').val());
                console.log(price);
                if(price) {
                    if($r(this).find('.vat-field').val() === '') {
                        $r(this).find('.vat-field').val(parseFloat((24/100) * price).toFixed(2));
                    }
                    finalPrice += price;
                }
            });
            $r('#subtotal').text(parseFloat(finalPrice).toFixed(2));
            $r('#fpa').text(parseFloat((24 / 100) * finalPrice).toFixed(2));
            $r('#finalPrice').text(parseFloat((24 / 100) * finalPrice + finalPrice).toFixed(2));
            $r('#toPay').text(parseFloat((24 / 100) * finalPrice + finalPrice).toFixed(2));
            $r('#parakratisiTotal').hide();
        }

        $r(document).on('mouseout', '.count-repeater', function () {
            $r(this).countPrices();
        });
        $r(document).on('change', 'select.product-field', function() {
            let vatId = $r('option:selected', this).attr('data-vatId');
            let price = $r('option:selected', this).attr('data-price');
            let vat = $r('option:selected', this).attr('data-vat');
            let extractRowName = $r(this).attr('name');
            let rowName =  extractRowName.substring(0, 11);

            $r('select[name="'+rowName+'[vat_id]"]').val(vatId);
            $r('input[name="'+rowName+'[price]"]').val(price);
            $r('input[name="'+rowName+'[vat]"]').val(vat);

        });

    </script>
@endsection
