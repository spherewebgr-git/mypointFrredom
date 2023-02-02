{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $client->company.'- Καρτέλα πελάτη' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-contact.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="col s12">
        <div class="container">
            <!-- Contact Us -->
            <div id="contact-us" class="section">
                <div class="app-wrapper">
                    <div class="contact-header">
                        <div class="row contact-us ml-0 mr-0">
                            <div class="col s12 m12 l4 sidebar-title">
                                <h5 class="m-0"><i
                                        class="material-icons contact-icon vertical-text-top">mail_outline</i> Καρτέλα
                                    Πελάτη ( #{{$client->code_number}} ):</h5>
                                <p class="m-0 font-weight-500 mt-6 hide-on-med-and-down text-ellipsis"
                                   title="{{$client->company}}">{{$client->company}}</p>
                            </div>
                            <div class="col s12 m12 l9 client-tabs">
                                <ul class="tabs">
                                    <li class="tab col m3"><a class="active" href="#prosfataTimologia">ΤΙΜΟΛΟΓΙΑ ΠΩΛΗΣΗΣ</a></li>
                                    <li class="tab col m3"><a href="#deltiaApostolis">ΤΙΜΟΛΟΓΙΑ / ΔΕΛΤΙΑ ΑΠΟΣΤΟΛΗΣ</a></li>
                                    <li class="tab col m3"><a href="#ipiresies">ΥΠΗΡΕΣΙΕΣ</a></li>
                                    <li class="tab col sm m3"><a href="#protimologia">ΥΠΗΡΕΣΙΕΣ ΠΡΟΣ ΤΙΜΟΛΟΓΗΣΗ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Sidenav -->
                    <div id="sidebar-list" class="row contact-sidenav ml-0 mr-0">
                        <div class="col s12 m12 l3">
                            <!-- Sidebar Area Starts -->
                            <div class="sidebar-left sidebar-fixed" style="position: relative">
                                <div class="sidebar">
                                    <div class="sidebar-content">
                                        <div class="sidebar-menu list-group position-relative">
                                            <div class="sidebar-list-padding app-sidebar contact-app-sidebar"
                                                 id="contact-sidenav">
                                                <ul class="contact-list display-grid">
                                                    <li>
                                                        <h6 class="mt-5 line-height">Στοιχεία Τιμολόγησης &
                                                            Επικοινωνίας</h6>
                                                    </li>
                                                    <li>
                                                        <hr class="mt-5">
                                                    </li>
                                                </ul>
                                                <div class="row">
                                                    <!-- Business Info -->
                                                    <div class="col s12 work_title mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="Επάγγελμα"><i class="material-icons">
                                                                computer </i></div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0">{{$client->work_title}}</p>
                                                        </div>
                                                    </div>
                                                    @if($client->addresses)
                                                        @foreach($client->addresses as $address)
                                                        <div class="col s12 address mt-4 p-0">
                                                            <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                                 data-tooltip="{{$address->address_name}}"><i class="material-icons">
                                                                    @if($address->address_type == 0) markunread_mailbox @else business @endif</i></div>
                                                            <div class="col s10 m10 l11">
                                                                <p class="m-0">{{$address->address.' '.$address->number}}, {{chunk_split($address->postal_code, 3, ' ')}}, {{$address->city}}</p>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @endif
                                                    @if($client->vat)
                                                    <div class="col s12 vat mt-4 m6 p-0">
                                                        <div class="col s2 m2 l2 tooltipped" data-position="top"
                                                             data-tooltip="Α.Φ.Μ."><i class="material-icons"> flip </i>
                                                        </div>
                                                        <div class="col s10 m10 l10">
                                                            <p class="m-0">{{$client->vat}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($client->doy)
                                                    <div class="col s12 doy mt-4 m6 p-0">
                                                        <div class="col s2 m2 l2 tooltipped" data-position="top"
                                                             data-tooltip="Δ.Ο.Υ."><i class="material-icons">
                                                                layers </i></div>
                                                        <div class="col s10 m10 l10">
                                                            <p class="m-0">{{$client->doy}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($client->email)
                                                    <div class="col s12 email mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="E-mail"><i class="material-icons"> mail </i>
                                                        </div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0">{{$client->email}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($client->phone)
                                                    <div class="col s12 phone mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="Τηλέφωνο"><i class="material-icons">
                                                                phone </i></div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0">{{$client->phone}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <!-- Business Info -->
                                                    <a href="{{route('client.edit', ['vat' => $client->vat])}}"
                                                       class="waves-effect waves-light btn mb-1 mr-1 mt-4">
                                                        <i class="material-icons left">edit</i> Επεξεργασία</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Area Ends -->
                        </div>
                        <div class="col s12 m12 l9 contact-form margin-top-contact">
                            <div class="row">
                                <div id="prosfataTimologia" class="col s12">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                                        <table
                                            class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                                            id="DataTables_Table_0" role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th class="control sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 19.8906px; display: none;" aria-label=""></th>
                                                <th class="center-align">Σειρά</th>
                                                <th>
                                                    <span>Αριθμός</span>
                                                </th>
                                                <th class="center-align">Ημ/νία Έκδοσης</th>
                                                <th class="center-align" style="width: 85px!important;">Τιμή</th>
                                                <th class="center-align" style="width: 85px!important;">Παρ/ση</th>
                                                <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                                                <th class="center-align print-hide" style="width: 85px!important;">
                                                    Καθαρό
                                                </th>
                                                <th class="center-align print-hide">Κατάσταση</th>
                                                <th class="center-align print-hide">Ενέργειες</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($invoices as $invoice)
                                                <tr role="row" class="odd" data-date="{{$invoice->date}}">
                                                    <td class="center-align" title="Τιμολόγιο Παροχής Υπηρεσιών"><small>{{$invoice->seira == 'ANEY' ? '' : $invoice->seira}}</small></td>
                                                    <td class=" control" tabindex="0" style="display: none;"></td>
                                                    <td class="sorting_1 center-align">{{$invoice->invoiceID}}</td>
                                                    <td class="center-align">
                                                        <small>{{\Carbon\Carbon::createFromTimestamp(strtotime($invoice->date))->format('d/m/Y')}}</small>
                                                    </td>
                                                    <td class="center-align">
                                                        &euro; {{number_format(getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}</td>
                                                    <td class="center-align count-parakratisi"
                                                        @if(getFinalPrices($invoice->hashID, 'invoice') > 300) data-price="{{(20 / 100) * getFinalPrices($invoice->hashID, 'invoice')}}" @endif>
                                                        @if(getFinalPrices($invoice->hashID, 'invoice') <= 300)
                                                            <span class="bullet blue"></span>
                                                            @else
                                                            &euro; {{number_format((20 / 100) * getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}
                                                        @endif
                                                    </td>
                                                    <td class="center-align print-hide">
                                                        &euro; {{number_format((24 / 100) * getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}
                                                    </td>
                                                    <td class="center-align">
                                                        @if(getFinalPrices($invoice->hashID, 'invoice') <= 300)
                                                        {{number_format(getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}
                                                        @else
                                                        &euro; {{number_format(getFinalPrices($invoice->hashID, 'invoice') - ((20 / 100) * getFinalPrices($invoice->hashID, 'invoice')), '2', ',', '.')}}
                                                        @endif
                                                    </td>
                                                    <td class="center-align print-hide">
                                                        @if($invoice->paid == 1)
                                                            <span
                                                                class="chip lighten-5 green green-text">ΠΛΗΡΩΜΕΝΟ</span>
                                                        @elseif($invoice->paid == 0)
                                                            <span class="chip lighten-5 red red-text">ΑΠΛΗΡΩΤΟ</span>
                                                        @else
                                                            <span
                                                                class="chip lighten-5 orange orange-text">Προκαταβολή</span>
                                                        @endif
                                                    </td>
                                                    <td class="center-align print-hide">
                                                        <div class="invoice-action">
                                                            @if($invoice->mark)
                                                                <a href="#" class="invoice-action-view mr-4">
                                                                    <i class="material-icons">cloud_download</i>
                                                                </a>
                                                            @else
                                                                <a href="{{route('invoice.view', ['invoice' => $invoice->hashID])}}"
                                                                   class="invoice-action-view mr-4">
                                                                    <i class="material-icons">remove_red_eye</i>
                                                                </a>
                                                                <a href="{{route('invoice.edit', ['invoice' => $invoice])}}"
                                                                   class="invoice-action-edit">
                                                                    <i class="material-icons">edit</i>
                                                                </a>
                                                                <a href="{{route('invoice.delete', ['invoice' => $invoice->hashID])}}"
                                                                   class="invoice-action-edit">
                                                                    <i class="material-icons">delete</i>
                                                                </a>
                                                            @endif

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach($sale_invoices as $invoice)
                                                <tr role="row" class="odd" data-date="{{$invoice->date}}">
                                                    <td class="center-align" title="Τιμολόγιο Πώλησης"><small>Τ.Π</small></td>
                                                    <td class=" control" tabindex="0" style="display: none;"></td>
                                                    <td class="sorting_1 center-align">
                                                        @if($invoice->seira != 'ANEY') {{$invoice->seira}} @endif {{$invoice->sale_invoiceID}}
                                                    </td>
                                                    <td class="center-align">
                                                        <small>{{\Carbon\Carbon::createFromTimestamp(strtotime($invoice->date))->format('d/m/Y')}}</small>
                                                    </td>
                                                    <td class="center-align">
                                                        &euro; {{number_format(getSaleInvoicePrices($invoice->hashID), '2', ',', '.')}}</td>
                                                    <td class="center-align count-parakratisi"
                                                        @if(getSaleInvoicePrices($invoice->hashID) > 300) data-price="{{(20 / 100) * getSaleInvoicePrices($invoice->hashID)}}" @endif>
                                                        @if(getSaleInvoicePrices($invoice->hashID) <= 300)
                                                            <span class="bullet blue"></span>
                                                            @else
                                                            &euro; {{number_format((20 / 100) * getSaleInvoicePrices($invoice->hashID), '2', ',', '.')}}
                                                        @endif
                                                    </td>
                                                    <td class="center-align print-hide">
                                                        &euro; {{number_format((24 / 100) * getSaleInvoicePrices($invoice->hashID), '2', ',', '.')}}
                                                    </td>
                                                    <td class="center-align">
                                                        {{number_format(getSaleInvoicePrices($invoice->hashID), '2', ',', '.')}}
                                                    </td>
                                                    <td class="center-align print-hide">
                                                        @if($invoice->paid == 1)
                                                            <span
                                                                class="chip lighten-5 green green-text">ΠΛΗΡΩΜΕΝΟ</span>
                                                        @elseif($invoice->paid == 0)
                                                            <span class="chip lighten-5 red red-text">ΑΠΛΗΡΩΤΟ</span>
                                                        @else
                                                            <span
                                                                class="chip lighten-5 orange orange-text">Προκαταβολή</span>
                                                        @endif
                                                    </td>
                                                    <td class="center-align print-hide">
                                                        <div class="invoice-action">
                                                            @if($invoice->mark)
                                                                <a href="#" class="invoice-action-view mr-4">
                                                                    <i class="material-icons">cloud_download</i>
                                                                </a>
                                                            @else
                                                                <a href="{{route('invoice.view', ['invoice' => $invoice->hashID])}}"
                                                                   class="invoice-action-view mr-4">
                                                                    <i class="material-icons">remove_red_eye</i>
                                                                </a>
                                                                <a href="{{route('invoice.edit', ['invoice' => $invoice])}}"
                                                                   class="invoice-action-edit">
                                                                    <i class="material-icons">edit</i>
                                                                </a>
                                                                <a href="{{route('invoice.delete', ['invoice' => $invoice->hashID])}}"
                                                                   class="invoice-action-edit">
                                                                    <i class="material-icons">delete</i>
                                                                </a>
                                                            @endif

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="deltiaApostolis" class="col-12">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                                        <table
                                            class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                                            id="DataTables_Table_0" role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th class="control sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 19.8906px; display: none;" aria-label=""></th>
                                                <th class="center-align">Σειρά</th>
                                                <th><span>Αριθμός</span></th>
                                                <th class="center-align" style="width: 85px!important;">Πελάτης</th>
                                                <th class="center-align">Ημ/νία Έκδοσης</th>
                                                <th class="center-align" style="width: 85px!important;">Τιμή</th>
                                                <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                                                <th class="center-align print-hide" style="width: 85px!important;">Σύνολο</th>
                                                <th class="center-align print-hide">Κατάσταση</th>
                                                <th class="center-align print-hide">Ενέργειες</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sale_invoices as $saleInvoice)

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="ipiresies" class="col s12">

                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                                        <table
                                            class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                                            id="DataTables_Table_0" role="grid">
                                            <thead>
                                            <tr role="row">
                                                <th class="control sorting_disabled" rowspan="1" colspan="1"
                                                    style="width: 19.8906px; display: none;" aria-label=""></th>
                                                <th><span>Τ.Π.Υ.</span></th>
                                                <th class="center-align" style="width: 85px!important;">Ποσότητα</th>
                                                <th>Υπηρεσία</th>
                                                <th class="center-align" style="width: 85px!important;">Τιμή</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($services as $service)
                                                <tr>
                                                    <td>
                                                        {{str_pad($service->invoice_number, 4, '0', STR_PAD_LEFT)}}</td>
                                                    <td>{{$service->quantity}}</td>
                                                    <td>{{$service->description}}</td>
                                                    <td>&euro; {{number_format($service->price, '2', ',', '.')}}</td>
                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                        <!-- Modal Trigger -->
                                        <a class="waves-effect waves-light btn modal-trigger mt-3" href="#modal1">Προσθήκη
                                            νέας υπηρεσίας</a>
                                        <!-- Modal Structure -->
                                        <div id="modal1" class="modal modal-fixed-footer">
                                            <form method="post"
                                                  action="{{route('service.store', ['client' => $client->hashID])}}">
                                                @csrf
                                                <div class="modal-content">
                                                    <h4>Προσθήκη Νέας Υπηρεσίας</h4>

                                                    <div class="row">
                                                        <div class="input-field col s12 m6">
                                                            <i class="material-icons prefix">swap_vert</i>
                                                            <input id="quantity" type="number" name="quantity" value="1"
                                                                   required>
                                                            <label for="quantity" class="">Ποσότητα</label>
                                                        </div>
                                                        <div class="input-field col s12 m4">
                                                            <i class="material-icons prefix">euro_symbol</i>
                                                            <input id="price" type="text" name="price" value="0"
                                                                   required>
                                                            <label for="price" class="">Ποσό *</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="input-field col s12">
                                                            <i class="material-icons prefix">local_grocery_store</i>
                                                            <textarea id="description" name="description" rows="4"
                                                                      style="height: auto;"> </textarea>
                                                            <label for="description" class="">Υπηρεσία *</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input class="waves-effect waves-light btn mr-1" type="submit"
                                                           value="Καταχώρηση Υπηρεσίας">
                                                    <a href="#!"
                                                       class="modal-action btn modal-close waves-effect waves-orange mr-1">Άκυρο</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="protimologia" class="col s12">
                                    <section class="invoice-list-wrapper section">
                                        <div class="responsive-table">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                                                <form id="servicesForm" action="{{route('service.invoice', ['client' => $client->hashID])}}" method="post">
                                                    @csrf
                                                    <table
                                                        class="table  invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                                                        id="DataTables_Table_0" role="grid">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="control sorting_disabled" rowspan="1" colspan="1"
                                                                style="width: 19.8906px; display: none;" aria-label=""></th>
                                                            <th class="dt-checkboxes-cell sorting_disabled" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                                style="width: 17px!important;padding: 0 0 0 20px;"
                                                                data-col="1" aria-label=""></th>
                                                            <th class="center-align" style="width: 85px!important;">
                                                                Ποσότητα
                                                            </th>
                                                            <th>Υπηρεσία</th>
                                                            <th class="center-align" style="width: 85px!important;">Τιμή
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                                @foreach($servicesNew as $service)
                                                                    <tr data-id="{{$service->id}}">
                                                                        <td class="dt-checkboxes-cell">
                                                                            <input type="checkbox" name="services[{{$service->id}}]" class="dt-checkboxes">
                                                                        </td>
                                                                        <td class="center-align">{{$service->quantity}}</td>
                                                                        <td>{{$service->description}}</td>
                                                                        <td class="center-align">
                                                                            &euro; {{number_format($service->price, '2', ',', '.')}}</td>
                                                                    </tr>

                                                                @endforeach

                                                        </tbody>
                                                    </table>
                                                </form>

                                                <!-- Modal Trigger -->
                                                <a class="waves-effect waves-light btn modal-trigger mt-3"
                                                   href="#modal1">Προσθήκη νέας υπηρεσίας</a>
                                                <!-- Modal Structure -->
                                                <a class="waves-effect waves-light btn mt-3 mr-3 addToInvoice btn-light-indigo"
                                                   href="#">Τιμολόγηση Υπηρεσιών</a>
                                                <div id="modal1" class="modal modal-fixed-footer">
                                                    <form method="post"
                                                          action="{{route('service.store', ['client' => $client->hashID])}}">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <h4>Προσθήκη Νέας Υπηρεσίας</h4>

                                                            <div class="row">
                                                                <div class="input-field col s12 m6">
                                                                    <i class="material-icons prefix">swap_vert</i>
                                                                    <input id="quantity" type="number" name="quantity"
                                                                           value="1" required>
                                                                    <label for="quantity" class="">Ποσότητα</label>
                                                                </div>
                                                                <div class="input-field col s12 m4 ">
                                                                    <i class="material-icons prefix">euro_symbol</i>
                                                                    <input id="price" type="text" name="price" value="0"
                                                                           required>
                                                                    <label for="price" class="">Ποσό *</label>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="input-field col s12">
                                                                    <i class="material-icons prefix">local_grocery_store</i>
                                                                    <textarea id="description" name="description"
                                                                              rows="4"
                                                                              style="height: auto;"> </textarea>
                                                                    <label for="description" class="">Υπηρεσία *</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input class="waves-effect waves-light btn mr-1"
                                                                   type="submit" value="Καταχώρηση Υπηρεσίας">
                                                            <a href="#!"
                                                               class="modal-action btn modal-close waves-effect waves-orange mr-1">Άκυρο</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
@endsection

{{-- scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/dataTables.checkboxes.min.js')}}"></script>
{{--    <script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>--}}
    <script src="{{asset('js/vendors.min.js')}}"></script>
    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function () {
            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif
            $m('.modal-trigger').on('click', function() {
                $m('.modal').addClass('open');
                $m('.modal').css({
                    "z-index": "1003",
                    "display": "block",
                    "opacity": 1,
                    "top": "10%",
                    "transform" : "scaleX(1) scaleY(1)"
                });
            });
            $m('.modal-close').on('click', function() {
                $m('.modal').removeClass('open');
                $m('.modal').css({
                    "z-index": "-1",
                    "display": "none",
                    "opacity": 0,
                    "top": "10%",
                    "transform" : "scaleX(1) scaleY(1)"
                });
            });
            $m('input.dt-checkboxes').on('change', function() {
                let checkboxes = $m('input.dt-checkboxes:checked').length;
                if(checkboxes >= 1) {
                    $m('.addToInvoice').addClass('active');
                } else {
                    $m('.addToInvoice').removeClass('active');
                }
            });
            $m('.addToInvoice').on('click', function() {
                let checkboxes = $m('input.dt-checkboxes:checked').length;
                if(checkboxes >= 1) {
                    $m('#servicesForm').submit();
                }
            });


        });
    </script>
@endsection
