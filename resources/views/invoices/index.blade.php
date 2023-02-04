{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Τιμολογίων Παροχής Υπηρεσιών')

@section('header-left')
    <a href="#" class="btn waves-effect waves-light invoices-myData border-round z-depth-4 hide" style="margin-left: 270px;line-height: 2.4rem;">
        <span>Απόστολή στο myData</span>
    </a>
@endsection

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Τιμολογίων Παροχής Υπηρεσιών</span></h5>
                </div>
                <div class="invoice-head--right row col s12 m6 display-flex justify-content-end align-items-center">
                    <div class="invoice-create-btn col">
                        <a href="{{route('invoice.create')}}"
                           class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                            <i class="material-icons">add</i>
                            <span>Νέο Τιμολόγιο</span>
                        </a>
                    </div>
                    @if(count($invoices) < 1)
                        <div class="invoice-create-btn col">
                            <a href="{{route('invoice.getFromMyData')}}"
                               class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                <i class="material-icons">add</i>
                                <span>Λήψη Παραστατικών από MyData</span>
                            </a>
                        </div>
                    @endif
                    <div class="invoice-filter-action col">
                        <a href="javascript:if(window.print)window.print()" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                            <i class="material-icons">print</i>
                            <span>Εκτύπωση Λίστας</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="invoice-list-wrapper section">
        <div class="responsive-table">
            <div class="card print-hide">
                <div class="card-content container">
                    <h4 class="card-title">Αναζήτηση Βάσει Ημερομηνίας</h4>
                    <form action="{{route('invoice.filter')}}" method="post" class="row display-flex flex-wrap align-items-center justify-content-between invoice-head">
                        @csrf
                        <div class="invoice-head--left row display-flex col align-items-center">
                            <label for="start" class="col display-flex align-items-center justify-content-end"><i class="material-icons">date_range</i> Από:</label>
                            <div class="col">
                                <input type="text" id="datepickerStart" name="date-start" class="datepicker"
                                       value="@isset($dateStart){{date('d/m/Y', strtotime($dateStart))}}@else 01/01/{{date('Y')}} @endif"
                                       title="Φίλτρο από:">
                            </div>
                            <label for="end" class="col display-flex align-items-center justify-content-end"><i class="material-icons">date_range</i> Έως: </label>
                            <div class="col">
                                <input type="text" id="datepickerEnd" name="date-end" class="datepicker"
                                       value="@isset($dateEnd){{date('d/m/Y', strtotime($dateEnd))}}@else{{date('d/m/Y')}}@endif"
                                       title="Φίλτρο εως:">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-xs btn-info filter-btn display-flex align-items-center border-round z-depth-4">
                                    <i class="material-icons" style="margin-right: 5px;">search</i> <span>Προσαρμογή Φίλτρου</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <div class="top display-flex mb-2" style="display: none">
                    <div class="action-filters">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <label>
                                <input type="search" class="" placeholder="Αναζήτηση τιμολογίου"
                                       aria-controls="DataTables_Table_0">
                                <div class="filter-btn">
                                    <!-- Dropdown Trigger -->
                                    <a class="dropdown-trigger btn waves-effect waves-light purple darken-1 border-round"
                                       href="#" data-target="btn-filter">
                                        <span class="hide-on-small-only">Κατάσταση</span>
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                    <ul id="btn-filter" class="dropdown-content " tabindex="0" style="">
                                        <li tabindex="0"><a href="#!">Πληρωμένο</a></li>
                                        <li tabindex="0"><a href="#!">Απλήρωτο</a></li>
                                        <li tabindex="0"><a href="#!">Προκαταβολή</a></li>
                                    </ul>
                                    <!-- Dropdown Structure -->
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="actions action-btns display-flex align-items-center">
                        <div class="invoice-filter-action mr-3">
                            <a href="#" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                                <i class="material-icons">picture_as_pdf</i>
                                <span class="hide-on-small-only">Export to PDF</span>
                            </a>
                        </div>
                        <div class="invoice-create-btn">
                            <a href="{{route('invoice.create')}}"
                               class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">Create Invoice</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="table-container">
                    <table class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                           id="DataTables_Table_0" role="grid">
                        <thead>
                        <tr role="row">
                            <th class="control sorting_disabled" rowspan="1" colspan="1"
                                style="width: 19.8906px; display: none;" aria-label=""></th>
                            <th class="invoices-select-all center"><label>
                                    <input type="checkbox" class="select-all-myData" name="myDataAll">
                                    <span></span>
                                </label></th>
                            <th class="center-align">
                                <span>Τ.Π.Υ.</span>
                            </th>
                            <th>Πελάτης</th>
                            <th class="center-align">Ημ/νία Έκδοσης</th>
                            <th class="center-align" style="width: 85px!important;">Τιμή</th>
                            <th class="center-align hide-on-med-and-down" style="width: 85px!important;">Παρ/ση</th>
                            <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                            <th class="center-align print-hide hide-on-med-and-down" style="width: 85px!important;">Σύνολο</th>
                            <th class="center-align print-hide">Κατάσταση</th>
                            <th class="center-align print-hide">Ενέργειες</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)

                            <tr role="row" class="odd">
                                <td class=" control" tabindex="0" style="display: none;"></td>
                                <td class="select-square center">
                                    <label for="send-{{$invoice->invoiceID}}">
                                        <input type="checkbox" data-invoice="{{$invoice->invoiceID}}"  name="send-{{$invoice->invoiceID}}" id="send-{{$invoice->invoiceID}}" @if(isset($invoice->mark) && $invoice->mark != null) class="hasmark" checked disabled @else class="myDataSelect" @endif>
                                        <span></span>
                                    </label>
                                </td>
                                <td class="sorting_1 center-align">
                                    @if($invoice->seira != 'ANEY') {{$invoice->seira}} @endif {{$invoice->invoiceID}}
                                </td>
                                <td class="bold">
                                    @if($invoice->client)
                                    <a href="{{route('client.view', $invoice->client->hashID)}}">{{$invoice->client->company}}</a>
                                        @endif
                                </td>
                                <td class="center-align">
                                    <small>{{\Carbon\Carbon::createFromTimestamp(strtotime($invoice->date))->format('d/m/Y')}}</small>
                                </td>
                                <td class="center-align">
                                    &euro; {{number_format(getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}</td>
                                <td class="center-align count-parakratisi hide-on-med-and-down" @if(getFinalPrices($invoice->hashID, 'invoice') > 300 && $invoice->has_parakratisi == 1) data-price="{{(20 / 100) * getFinalPrices($invoice->hashID, 'invoice')}}" @endif>
                                    @if(getFinalPrices($invoice->hashID, 'invoice') > 300 && $invoice->has_parakratisi == 1)
                                    &euro; {{number_format((20 / 100) * getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}

                                        @else
                                        <span class="bullet blue"></span>
                                    @endif
                                </td>
                                <td class="center-align print-hide">
                                    &euro; {{number_format((24 / 100) * getFinalPrices($invoice->hashID, 'invoice'), '2', ',', '.')}}
                                </td>
                                <td class="center-align hide-on-med-and-down">

                                    &euro; {{number_format(getFinalPrices($invoice->hashID, 'invoice') + ((24 / 100) * getFinalPrices($invoice->hashID, 'invoice')), '2', ',', '.')}}

                                </td>
                                <td class="center-align print-hide">
                                    @if($invoice->paid == 1)
                                        <span class="chip lighten-5 green green-text">ΠΛΗΡΩΜΕΝΟ</span>
                                    @elseif($invoice->paid == 0)
                                        <span class="chip lighten-5 red red-text">ΑΠΛΗΡΩΤΟ</span>
                                    @else
                                        <span class="chip lighten-5 orange orange-text">Προκαταβολή</span>
                                    @endif
                                </td>
                                <td class="center-align print-hide">
                                    <div class="invoice-action">
                                        @if($invoice->mark)
                                            <a href="{{route('invoice.view', ['invoice' => $invoice->hashID])}}" class="invoice-action-view mr-4">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            <a href="{{route('invoice.download', $invoice->hashID)}}" class="invoice-action-view mr-4">
                                                <i class="material-icons">cloud_download</i>
                                            </a>
                                        @else
                                            <a href="{{route('invoice.view', ['invoice' => $invoice->hashID])}}" class="invoice-action-view mr-4">
                                                <i class="material-icons">remove_red_eye</i>
                                            </a>
                                            <a href="{{route('invoice.edit', ['invoice' => $invoice->hashID])}}" class="invoice-action-edit">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="{{route('invoice.delete', ['invoice' => $invoice->hashID])}}" class="invoice-action-edit">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="finals gradient-45deg-indigo-blue">
                            <td></td>
                            <td colspan="3" class="right-align">Σύνολα:</td>
                            <td class="center-align tooltipped" data-position="top" data-tooltip="Σύνολο Εσόδων">&euro; {{number_format($finals, '2', ',', '.')}}</td>
                            <td class="center-align parakratisi-synolo tooltipped" data-position="top" data-tooltip="Σύνολο Παρακράτησης Φόρου"></td>
                            <td class="center-align tooltipped" data-position="top" data-tooltip="Σύνολο Φ.Π.Α.">&euro; {{number_format(((24 / 100) * $finals),  2, ',', '.')}}</td>

                            <td colspan="3" class="tooltipped print-hide" data-position="top" data-tooltip="Σύνολο Μικτό">&euro; {{number_format(($finals + ((24 / 100) * $finals)), 2, ',', '.' )}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
@endsection

{{-- scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
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

            var parakratiseis = 0;
            $m('.count-parakratisi').each(function(){
                let price = $m(this).data('price');
                if(typeof price !== 'undefined'){
                    parakratiseis += parseInt(price);
                }
            });
            $m('.parakratisi-synolo').text('€ '+ custom_number_format(parakratiseis, '2'));

            $m('.select-all-myData').on('change', function(){
                $m('input.myDataSelect').each(function(){
                   $m(this).attr('checked', !$m(this).prop('checked'));
                });
                $m('a.invoices-myData').toggleClass('hide');
            });

            $m('input.myDataSelect').on('change', function(){
                if($m('input.myDataSelect').is(':checked')) {
                    $m('a.invoices-myData').removeClass('hide');
                } else {
                    $m('a.invoices-myData').addClass('hide');
                }
            });
            $m('a.invoices-myData').on('click', function(e){
                e.preventDefault();
               let invoiceIds = [];
                $m('input.myDataSelect:checked').each(function(){
                    let invoiceId = $m(this).data('invoice');
                    invoiceIds.push(invoiceId);
                })
                $m.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $m('meta[name="csrf-token"]').attr('content')
                    }
                });
                $m.ajax({
                    url: "{{route('invoice.mydata.multiple')}}",
                    method: 'POST',
                    data: { ids: invoiceIds},
                    success: function(result) {
                        console.log(result);
                    }
                });
            });
        });


        function custom_number_format( number_input, decimals, dec_point, thousands_sep ) {
            var number       = ( number_input + '' ).replace( /[^0-9+\-Ee.]/g, '' );
            var finite_number   = !isFinite( +number ) ? 0 : +number;
            var finite_decimals = !isFinite( +decimals ) ? 0 : Math.abs( decimals );
            var seperater     = ( typeof thousands_sep === 'undefined' ) ? ',' : thousands_sep;
            var decimal_pont   = ( typeof dec_point === 'undefined' ) ? '.' : dec_point;
            var number_output   = '';
            var toFixedFix = function ( n, prec ) {
                if( ( '' + n ).indexOf( 'e' ) === -1 ) {
                    return +( Math.round( n + 'e+' + prec ) + 'e-' + prec );
                } else {
                    var arr = ( '' + n ).split( 'e' );
                    let sig = '';
                    if ( +arr[1] + prec > 0 ) {
                        sig = '+';
                    }
                    return ( +(Math.round( +arr[0] + 'e' + sig + ( +arr[1] + prec ) ) + 'e-' + prec ) ).toFixed( prec );
                }
            }
            number_output = ( finite_decimals ? toFixedFix( finite_number, finite_decimals ).toString() : '' + Math.round( finite_number ) ).split( '.' );
            if( number_output[0].length > 3 ) {
                number_output[0] = number_output[0].replace( /\B(?=(?:\d{3})+(?!\d))/g, seperater );
            }
            if( ( number_output[1] || '' ).length < finite_decimals ) {
                number_output[1] = number_output[1] || '';
                number_output[1] += new Array( finite_decimals - number_output[1].length + 1 ).join( '0' );
            }
            return number_output.join( decimal_pont );
        }
    </script>
@endsection
