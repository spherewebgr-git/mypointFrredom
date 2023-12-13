{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Πληρωμών')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Πληρωμών</span></h5>
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
                                <input type="search" class="" placeholder="Αναζήτηση Πληρωμής"
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
                            <a href="{{route('payment.add')}}"
                               class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">Νέα Πληρωμή</span>
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
                            <th class="center-align">Πελάτης</th>
                            <th class="center-align">ΑΦΜ Πελάτη</th>
                            <th style="min-width: 410px!important;">Ποσό Κατάθεσης</th>
                            <th class="center-align">Ημ/νία Κατάθεσης</th>
                            <th class="center-align">Αποδεικτικό Κατάθεσης</th>
                            <th>Ενέργειες</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $count = 0; @endphp
                        @foreach($payments as $payment)
                            <tr role="row" class="{{(++$count%2 ? "odd" : "even")}} payment-row"
                                data-number="{{$payment->paymentHash}}">
                                <td>{{$payment->client->company}}</td>
                                <td class="center-align">{{$payment->client->vat}}</td>
                                <td>&euro; {{number_format($payment->payment_price, 2, ',', '.')}}</td>
                                <td class="center-align">{{\Carbon\Carbon::createFromTimestamp(strtotime($payment->payment_date))->format('d/m/Y')}}</td>
                                <td class="center-align"><a href="{{route('payment.download', ['payment' => $payment->paymentHash])}}" class="btn btn-small align-items-center display-flex" style="gap: 10px"><i class="material-icons">cloud_download</i> Λήψη Αποδεικτικού</a></td>
                                <td>
                                    <div class="invoice-action">
                                        <a href="#"
                                           class="invoice-action-view mr-4 tooltipped" data-position="left"
                                           data-tooltip="Προβολή καρτέλας προμηθευτή"> <i class="material-icons">remove_red_eye</i>
                                        </a>
                                        <a href="#"
                                           class="invoice-action-edit tooltipped" data-position="left"
                                           data-tooltip="Επεξεργασία στοιχείων προμηθευτή">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <a href="#modal" class="invoice-action-delete mr-4 tooltipped modal-trigger"
                                           data-position="left" data-vat="#"
                                           data-provider="#"
                                           data-tooltip="Διαγραφή προμηθευτή">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @php $count++; @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
