{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Ρυθμίσεις Εφαρμογής')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-account-settings.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="tabs-vertical mt-1 section">
        <div class="row">
            <div class="col l3 s12">
                <!-- tabs  -->
                <div class="card-panel">
                    <ul class="tabs">
                        <li class="tab">
                            <a href="#general">
                                <i class="material-icons">person</i>
                                <span>ΔΙΑΧΕΙΡΙΣΤΗΣ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#permissions">
                                <i class="material-icons">person</i>
                                <span>ΧΡΗΣΤΕΣ & ΔΙΚΑΙΩΜΑΤΑ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#info">
                                <i class="material-icons">error_outline</i>
                                <span> ΦΟΡΟΛΟΓΙΚΑ </span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#addresses">
                                <i class="material-icons">business</i>
                                <span> ΔΙΕΥΘΥΝΣΕΙΣ </span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#mydata">
                                <i class="material-icons">link</i>
                                <span> ΣΥΝΔΕΣΗ myData </span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#invoices">
                                <i class="material-icons">settings</i>
                                <span>ΡΥΘΜΙΣΕΙΣ ΠΑΡΑΣΤΑΤΙΚΩΝ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#parastatika">
                                <i class="material-icons">library_books</i>
                                <span>ΕΙΔΗ ΠΑΡΑΣΤΑΤΙΚΩΝ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#seires">
                                <i class="material-icons">import_export</i>
                                <span>ΣΕΙΡΕΣ ΠΑΡΑΣΤΑΤΙΚΩΝ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#products">
                                <i class="material-icons">local_grocery_store</i>
                                <span>ΡΥΘΜΙΣΕΙΣ ΠΡΟΪΟΝΤΩΝ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#services">
                                <i class="material-icons">autorenew</i>
                                <span>ΡΥΘΜΙΣΕΙΣ ΥΠΗΡΕΣΙΩΝ</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col l9 s12">
                <!-- tabs content -->
                @include('settings.general')

                @include('settings.permissions')

                @include('settings.mydata')

                @include('settings.info')

                @include('settings.addresses')

                @include('settings.invoices')

                @include('settings.seires')

                @include('settings.parastatika')

                @include('settings.products')

                @include('settings.services')

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
    </section>
@endsection

@section('page-script')
    <script src="{{asset('js/scripts/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/form_repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function(){
            $m(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%'
            });
           $m('#openMydataInfo').on('click', function(){
              $m('.mydata-howto').removeClass('hide');
           });
           $m('#show_products').on('change', function(){
               if($m(this).is(':checked')) {
                   //$m('.product-settings').removeClass('hide');
                   $m('.product-settings').slideDown();
               } else {
                   //$m('.product-settings').addClass('hide');
                   $m('.product-settings').slideUp();
               }
           });
           $m('input[type="checkbox"]').on('click', function(){
               let dataName = $m(this).attr('name');
              if(!$m(this).is(':checked')){
                  $m('<input type="hidden" name="'+dataName+'" value="off" />').insertAfter(this);
              }
           });
        });
    </script>
@endsection
