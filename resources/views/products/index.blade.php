{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Αποθήκη Προϊόντων')

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
                <div class="col s10 m3 l3">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Αποθήκη Προϊόντων</span></h5>
                </div>
                <div class="invoice-head--right row col s12 m9 l9 display-flex justify-content-end align-items-center">
                    <div class="invoice-create-btn col">
                        <a href="{{route('products.create')}}"
                           class="btn waves-effect waves-light invoice-create border-round z-depth-4 green">
                            <i class="material-icons">add</i>
                            <span>Νέο Προϊόν</span>
                        </a>
                    </div>
                    <div class="invoice-create-btn col">
                        <a href="{{route('products.storage')}}"
                           class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                            <i class="material-icons">library_add</i>
                            <span>Απογραφή Αποθήκης</span>
                        </a>
                    </div>
                    <div class="invoice-filter-action col">
                        <a href="javascript:if(window.print)window.print()" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                            <i class="material-icons">print</i>
                            <span>Εκτύπωση Λίστας</span>
                        </a>
                    </div>
                    <div class="invoice-filter-action col">
                        <a href="#" class="btn waves-effect waves-light invoice-export border-round z-depth-4" id="updateEshop">
                            <i class="material-icons">leak_add</i>
                            <span>Ενημέρωση Αποθήκης Καταστήματος</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer mt-3 table-container">
        <table class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
               id="DataTables_Table_0" role="grid" style="border-spacing: 0 5px;">
            <thead>
            <tr role="row">
                <th class="control sorting_disabled" rowspan="1" colspan="1"
                    style="width: 19.8906px; display: none;" aria-label=""></th>
                <th class="center-align">Εικόνα</th>
                <th class="center-align"><span>Κωδ. Προϊόντος</span></th>
                <th>Τίτλος</th>
                <th class="center-align" style="width: 85px!important;">Τιμή</th>
                <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                <th class="center-align" style="width: 85px!important;">Ποσότητα</th>
                <th class="center-align" style="width: 85px!important;">Κατάσταση</th>
                <th class="center-align print-hide" style="width: 85px!important;">Ενέργειες</th>
            </tr>
            </thead>
            <tbody>
                @if(isset($products))
                @foreach($products as $product)
                    <tr class="{{$product->active ? 'active' : 'inactive'}}">
                        <td class="center-align">@if(isset($product->product_image))<img src="{{url('images/products/'.$product->product_image)}}" alt=""  style="max-height: 80px;max-width: 200px;" />@endif</td>
                        <td class="center-align">{{$product->product_number}}</td>
                        <td>{{$product->product_name}}</td>
                        <td class="center-align">&euro; {{number_format($product->price, '2', ',', '.')}}</td>
                        <td class="center-align">&euro; {{number_format($product->vat_price, '2', ',', '.')}}</td>
                        <td class="center-align">{{$product->storage->quantity ?? 0}}</td>
                        <td class="center-align">{{$product->active ? 'ΕΝΕΡΓΟ' : 'ΑΝΕΝΕΡΓΟ'}}</td>
                        <td class="center-align print-hide">
                            <div class="invoice-action">
                                <a href="#modal" class="invoice-action-view mr-4 modal-trigger"
                                   data-product-img="{{url('images/products/'.$product->product_image)}}"
                                   data-product-name="{{$product->product_name}}"
                                   data-product-number="{{$product->product_number}}"
                                   data-category="{{$product->product_category}}"
                                   data-active="{{$product->active ? '<span class="green">ΕΝΕΡΓΟ</span>' : '<span class="red">ΑΝΕΝΕΡΓΟ</span>'}}"
                                   data-quantity="{{$product->storage->quantity ?? 0}}"
                                   data-price="&euro; {{number_format($product->price, '2', ',', '.')}}"
                                   data-vat-price="&euro; {{number_format($product->vat_price, '2', ',', '.')}}"
                                   data-description="{{$product->product_description}}"
                                >
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                <a href="{{route('products.edit', $product->product_number)}}" class="invoice-action-edit">
                                    <i class="material-icons">edit</i>
                                </a>
                                <a href="/" class="invoice-action-edit">
                                    <i class="material-icons">delete</i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <div id="modal" class="modal" tabindex="0" style="z-index: 1003; display: none; opacity: 0; top: 4%; transform: scaleX(0.8) scaleY(0.8);">
                    <div class="modal-content pt-2">
                        <div class="row" id="product-one">
                            <div class="col s12">
                                <a class="modal-close right"><i class="material-icons">close</i></a>
                            </div>
                            <div class="col m6 s12">
                                <img src="" class="responsive-img modal-image" alt="">
                            </div>
                            <div class="col m6 s12">
                                <p class="modal-category"></p>
                                <h5 class="modal-product-name"></h5>
                                <span class="green badge left ml-0 mr-2 modal-active"></span>
                                <p>Απόθεμα: <span class="modal-quantity fw-bolder"></span></p>
                                <hr class="mb-5">
                                <p class="modal-description"></p>
                                <h5 class="modal-price"></h5>
{{--                                <a class="waves-effect waves-light btn gradient-45deg-deep-purple-blue mt-2 mr-2">ADD TO CART</a>--}}
{{--                                <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange mt-2">BUY NOW</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </tbody>
        </table>
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


@section('page-script')

<script>
    $m = jQuery.noConflict();
    $m(document).ready(function() {
        $m('.modal').modal();
        $m('.modal-trigger').on('click', function(){
           let productImg = $m(this).data('product-img');
           let productName = $m(this).data('product-name');
           let productNumber = $m(this).data('product-number');
           let quantity = $m(this).data('quantity');
           let category = $m(this).data('category');
           let status = $m(this).data('active');
           let productDescription = $m(this).data('description');
           let productPrice = $m(this).data('price');
           let productVatPrice = $m(this).data('vat-price');

           $m('#modal .modal-image').attr('src', productImg);
           $m('#modal .modal-image').attr('alt', productName);
           $m('#modal .modal-quantity').text(quantity);
           $m('#modal .modal-category').text(category);
           $m('#modal .modal-price').html(productPrice+'<small class="ml-2">ΦΠΑ: <span class="prise-text-style modal-vat">'+productVatPrice+'</span></small>');
           $m('#modal .modal-active').html(status);
           $m('#modal .modal-description').html(productDescription);
           $m('#modal .modal-product-name').html(productName+' <span class="modal-code small">('+productNumber+')</span>');

        });

        $m('#updateEshop').on('click', function(e){
            e.preventDefault();
            $m('.ajax-preloader').addClass('active');

            let pageToken = $m('meta[name="csrf-token"]').attr('content');

            $m.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': pageToken
                }
            });

            $m.ajax({
                url: "{{ url('/update-eshop-storage') }}",
                method: 'post',

                success: function (result) {
                    console.log(result);
                    $p('.ajax-preloader').removeClass('active');

                }
            });

        });
    });
</script>
@endsection
