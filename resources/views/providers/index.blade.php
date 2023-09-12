{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Προμηθευτών')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Προμηθευτών</span></h5>
                </div>
            </div>
        </div>
    </div>
    <section class="invoice-list-wrapper section">
        <!-- create invoice button-->
        <!-- Options and filter dropdown button-->
        <!-- create invoice button-->
        <div class="responsive-table">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <div class="top display-flex  mb-2">
                    <div class="action-filters">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                <input type="search" class="" placeholder="Αναζήτηση πελάτη"
                                       aria-controls="DataTables_Table_0">
                            </label>
                        </div>
                    </div>
                    <div class="actions action-btns display-flex align-items-center">
                        <div class="invoice-filter-action mr-3">
                            <a href="javascript:if(window.print)window.print()"
                               class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                                <i class="material-icons">print</i>
                                <span class="hide-on-small-only">Εκτύπωση</span>
                            </a>
                        </div>
                        <div class="invoice-create-btn">
                            <a href="{{route('provider.add')}}"
                               class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">Νέος Προμηθευτής</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="table-container">
                    <table
                        class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column providers-table"
                        id="DataTables_Table_0" role="grid">
                        <thead>
                        <tr role="row">
                            <th class="center-align">Κωδ. Προμηθευτή</th>
                            <th class="center-align">ΑΦΜ Προμηθευτή</th>
                            <th style="min-width: 410px!important;">Επωνυμία Προμηθευτή</th>
                            <th class="center-align">Υπόλοιπο Καρτέλας</th>
                            <th>Ενέργειες</th>
                        </tr>
                        </thead>

                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($providers as $provider)
                            @if($provider->disabled == 0)
                                <tr role="row" class="{{(++$count%2 ? "odd" : "even")}} provider-row"
                                    data-number="{{$provider->provider_id}}">
                                    <td class="center-align">{{$provider->provider_id}}</td>
                                    <td class="center-align">{{str_pad($provider->provider_vat, 9, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$provider->provider_name}}</td>
                                    <td class="center-align">0</td>
                                    <td class="print-hide">
                                        <div class="invoice-action">
                                            <a href="{{route('provider.view', ['vat' => $provider->provider_vat])}}"
                                               class="invoice-action-view mr-4 tooltipped" data-position="left"
                                               data-tooltip="Προβολή καρτέλας προμηθευτή"> <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            <a href="{{route('provider.edit', ['vat' => $provider->provider_vat])}}"
                                               class="invoice-action-edit tooltipped" data-position="left"
                                               data-tooltip="Επεξεργασία στοιχείων προμηθευτή">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#modal" class="invoice-action-delete mr-4 tooltipped modal-trigger"
                                               data-position="left" data-vat="{{$provider->provider_vat}}"
                                               data-provider="{{$provider->company}}"
                                               data-tooltip="Διαγραφή προμηθευτή">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @foreach($providers as $provider)
                            @if($provider->disabled == 1)
                                <tr role="row" class="{{(++$count%2 ? "odd" : "even")}} disabled provider-row"
                                    data-number="{{$provider->provider_id}}">
                                    <td class="center-align">{{$provider->provider_id}}</td>
                                    <td class="center-align">{{str_pad($provider->provider_vat, 9, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$provider->provider_name}}</td>
                                    <td class="center-align">0</td>
                                    <td class="print-hide">
                                        <div class="invoice-action">
                                            <a href="{{route('provider.view', ['vat' => $provider->provider_vat])}}"
                                               class="invoice-action-view mr-4 tooltipped" data-position="left"
                                               data-tooltip="Προβολή καρτέλας προμηθευτή">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            <a href="{{route('provider.edit', ['vat' => $provider->provider_vat])}}"
                                               class="invoice-action-edit tooltipped" data-position="left"
                                               data-tooltip="Επεξεργασία στοιχείων προμηθευτή">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#modal" class="invoice-action-delete mr-4 tooltipped modal-trigger"
                                               data-position="left" data-vat="{{$provider->provider_vat}}"
                                               data-provider="{{$provider->company}}"
                                               data-tooltip="Διαγραφή προμηθευτή">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bottom">

                </div>
            </div>
        </div>
    </section>
    <div id="modal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4>Επιβεβαίωση Διαγραφής Πελάτη</h4>
            <p>Θέλετε σίγουρα να διαγράψετε τον πελάτη <span class="provider-to-delete"></span>;</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-light blue-grey lighten-1 btn ">Ακύρωση</a>
            <a href="#" class="modal-action modal-close waves-effect waves-light green btn delete-action">Διαγραφή</a>
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

{{-- scripts --}}
@section('page-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function () {
            $m('.modal').modal({
                dismissible: true,
            });
            $m('.modal-trigger').on('click', function () {
                let provider = $m(this).data('provider');
                let vatProvider = $m(this).data('vat');
                $m('.modal .provider-to-delete').text(provider);
                $m('.modal .delete-action').attr('href', '/delete-provider/' + vatProvider);
            });

            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif

            $m('.dataTables_filter input').on('keyup', function () {
                if ($m(this).val().length > 2) {
                    $m('.provider-row').hide();
                    $m('tr.nothing').remove();
                    $m('.ajax-preloader').addClass('active');
                    let pageToken = $m('meta[name="csrf-token"]').attr('content');
                    $m.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': pageToken
                        }
                    });


                    let query = $m(this).val();
                    $m.ajax({
                        url: "{{ url('/provider-search-ajax') }}",
                        method: 'post',
                        data: {
                            ask: query
                        },
                        success: function (result) {
                            console.log(result);
                            $m('.ajax-preloader').removeClass('active');
                            if (result.length > 0) {
                                $m.each(result, function (k, v) {
                                    console.log(v.provider_id);
                                    $m('.provider-row[data-number="' + v.provider_id + '"]').show();
                                });
                            } else {
                                $m('.providers-table tbody').append('<tr class="nothing"><td colspan="6" class="center-align red-text">Δεν βρέθηκαν πελάτες με τα κριτήρια αναζήτησης που δόθηκαν</td></tr>');
                            }

                        }
                    });
                } else {
                    $m('.provider-row').show();
                }
            });

        });
    </script>
@endsection
