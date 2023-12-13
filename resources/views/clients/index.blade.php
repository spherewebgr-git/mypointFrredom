{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Πελατών')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Πελατών</span></h5>
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
                            <a href="{{route('client.add')}}"
                               class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">Νέος Πελάτης</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="table-container">
                    <table
                        class="table clients-table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                        id="DataTables_Table_0" role="grid">
                        <thead>
                        <tr role="row">
                            <th class="control sorting_disabled" rowspan="1" colspan="1"
                                style="display: none;" aria-label=""></th>
                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="min-width: 60px!important;">
                                <span>Κωδικός <span class="hide-on-mobile">Πελάτη</span></span>
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="text-align: center;min-width: 100px!important;">
                                <span>Α.Φ.Μ. Πελάτη</span>
                            </th>
                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="min-width: 440px!important;"
                                aria-sort="ascending" aria-label=" Invoice#: activate to sort column descending">
                                <span>Επωνυμία Εταιρείας</span>
                            </th>
                            <th class="sorting_asc center-align" tabindex="0" aria-controls="DataTables_Table_0"
                                rowspan="1" colspan="1"
                                aria-sort="ascending" aria-label="Υπόλοιπο Καρτέλας">Υπόλοιπο <span class="hide-on-mobile">Καρτέλας</span>
                            </th>
                            <th class="sorting_asc print-hide right-align" rowspan="1" colspan="1"
                                aria-label="Action">Ενέργειες
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($clients as $client)
                            @if($client->disabled == 0)
                                <tr role="row" class="odd client-row" data-number="{{$client->code_number}}">
                                    <td class=" control" tabindex="0" style="display: none;"></td>
                                    <td class="sorting" style="text-align: center">
                                        {{$client->code_number}}
                                    </td>
                                    <td class="sorting" style="text-align: center">
                                        {{str_pad($client->vat, 9, '0', STR_PAD_LEFT)}}
                                    </td>
                                    <td class="sorting_1">
                                        {{$client->company}}
                                    </td>
                                    <td class="sorting_1 center-align">
                                        {{number_format($client->price_balance, 2, ',', '.')}}
                                    </td>
                                    <td class="print-hide right-align">
                                        <div class="invoice-action">
                                            <a href="{{route('client.view', ['hashID' => $client->hashID])}}"
                                               class="invoice-action-view mr-4 tooltipped" data-position="left"
                                               data-tooltip="Προβολή καρτέλας πελάτη"> <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            <a href="{{route('client.edit', ['hashID' => $client->hashID])}}"
                                               class="invoice-action-edit tooltipped" data-position="left"
                                               data-tooltip="Επεξεργασία στοιχείων πελάτη">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#modal" class="invoice-action-delete mr-4 tooltipped modal-trigger"
                                               data-position="left" data-hash="{{$client->hashID}}"
                                               data-client="{{$client->company}}" data-tooltip="Διαγραφή πελάτη">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @foreach($clients as $client)
                            @if($client->disabled == 1)
                                <tr role="row" class="odd disabled" data-number="{{$client->code_number}}">
                                    <td class=" control" tabindex="0" style="display: none;"></td>
                                    <td class="sorting">
                                        {{$client->code_number}}
                                    </td>
                                    <td class="sorting">
                                        {{str_pad($client->vat, 9, '0', STR_PAD_LEFT)}}
                                    </td>
                                    <td class="sorting_1">
                                        {{$client->company}}
                                    </td>
                                    <td class="sorting_1 center-align">
                                        {{number_format($client->price_balance, 2, ',', '.')}}
                                    </td>
                                    <td class="print-hide">
                                        <div class="invoice-action">
                                            <a href="{{route('client.view', ['hashID' => $client->hashID])}}"
                                               class="invoice-action-view mr-4 tooltipped" data-position="left"
                                               data-tooltip="Προβολή καρτέλας πελάτη"> <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            <a href="{{route('client.enable', ['hashID' => $client->hashID])}}"
                                               class="invoice-action-edit tooltipped" data-position="left"
                                               data-tooltip="Επανενεργοποίηση Πελάτη">
                                                <i class="material-icons">restore</i>
                                            </a>
                                            <a href="#modal" class="invoice-action-delete mr-4 tooltipped modal-trigger"
                                               data-position="left" data-hash="{{$client->hashID}}"
                                               data-client="{{$client->company}}" data-tooltip="Διαγραφή πελάτη">
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
            <p>Θέλετε σίγουρα να διαγράψετε τον πελάτη <span class="client-to-delete"></span>;</p>
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
                let client = $m(this).data('client');
                let hashClient = $m(this).data('hash');
                $m('.modal .client-to-delete').text(client);
                $m('.modal .delete-action').attr('href', '/delete-client/' + hashClient);
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
                    $m('.client-row').hide();
                    $m('tr.nothing').remove();
                    let pageToken = $m('meta[name="csrf-token"]').attr('content');
                    $m.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': pageToken
                        }
                    });


                    let query = $m(this).val();
                    $m.ajax({
                        url: "{{ url('/client-search-ajax') }}",
                        method: 'post',
                        data: {
                            ask: query
                        },
                        success: function (result) {
                            console.log(result);
                            $m('.ajax-preloader').removeClass('active');
                            if (result.length > 0) {
                                $m.each(result, function (k, v) {
                                    console.log(v.code_number);
                                    $m('.client-row[data-number="' + v.code_number + '"]').show();
                                });
                            } else {
                                $m('.clients-table tbody').append('<tr class="nothing"><td colspan="6" class="center-align red-text">Δεν βρέθηκαν πελάτες με τα κριτήρια αναζήτησης που δόθηκαν</td></tr>');
                            }

                        }
                    });
                } else {
                    $m('.client-row').show();
                }
            });
        });
    </script>
@endsection
