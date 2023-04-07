{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Αποδείξεων Λιανικής')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Αποδείξεων Λιανικής</span></h5>
                </div>
            </div>
        </div>
    </div>
    <section class="invoice-list-wrapper section">
        <div class="responsive-table">
            <div class="card print-hide">
                <div class="card-content container">
                    <h4 class="card-title">Αναζήτηση Βάσει Ημερομηνίας</h4>
                    <form action="{{route('retail-receipts.filter')}}" method="post" class="row display-flex flex-wrap align-items-center justify-content-between invoice-head">
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
                        <div class="invoice-head--right row col">
                            <div class="invoice-create-btn col">
                                <a href="{{route('retail-receipts.create')}}"
                                   class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                    <i class="material-icons">add</i>
                                    <span>Νέα Απόδειξη</span>
                                </a>
                            </div>
                            <div class="invoice-filter-action col">
                                <a href="javascript:if(window.print)window.print()" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                                    <i class="material-icons">print</i>
                                    <span>Εκτύπωση</span>
                                </a>
                            </div>
                        </div>


                    </form>

                </div>
            </div>

            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <div class="clear"></div>
                <div class="table-container">
                    <table class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                           id="DataTables_Table_0" role="grid">
                        <thead>
                        <tr role="row">
                            <th class="control sorting_disabled" rowspan="1" colspan="1"
                                style="width: 19.8906px; display: none;" aria-label=""></th>
                            <th class="center-align"><span>Αρ. Απόδειξης</span></th>
                            <th class="center-align">Ημ/νία Έκδοσης</th>
                            <th class="center-align">Ώρα Έκδοσης</th>
                            <th class="center-align" style="width: 85px!important;">Καθαρό</th>
                            <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                            <th class="center-align" style="width: 85px!important;">Σύνολο</th>
                            <th class="center-align">Τρόποι Πληρωμής</th>
                            <th class="center-align print-hide">Ενέργειες</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($retails as $retail)
                            <tr role="row" class="odd">
                                <td class=" control" tabindex="0" style="display: none;"></td>
                                <td class="sorting_1 center-align"><a href="{{route('retail-receipts.view', ['retail' => $retail->hashID])}}">@if($retail->seira != 'ANEY'){{$retail->seira}}@endif - {{$retail->retailID}}</a></td>
                                <td class="center-align">
                                    <small>{{\Carbon\Carbon::createFromTimestamp(strtotime($retail->date))->format('d/m/Y')}}</small>
                                </td>
                                <td class="center-align">
                                    <small>{{\Carbon\Carbon::createFromTimestamp(strtotime($retail->created_at))->format('H:i')}}</small>
                                </td>
                                <td class="center-align">
                                    &euro; {{number_format(getRetailPrices($retail)['price'], '2', ',', '.')}}
                               </td>
                                <td class="center-align print-hide">
                                    &euro; {{number_format(getRetailPrices($retail)['vat'], '2', ',', '.')}}
                                </td>
                                <td class="center-align">
                                    &euro; {{number_format((getRetailPrices($retail)['price'] + getRetailPrices($retail)['vat']), '2', ',', '.')}}
                                </td>
                                <td class="center-align"> @foreach(getRetailPaymentMethods($retail->hashID) as $method) <small>{{$method}}</small><br /> @endforeach </td>
                                <td class="center-align print-hide">
                                    <div class="invoice-action">
                                        @if(!$retail->mark)
                                            <a href="{{route('retail-receipts.mydata', $retail->hashID)}}" class="invoice-action-mydata mr-4 default" data-retail="{{$retail->hashID}}" title="Αποστολή στο MyData" data-hash="{{$retail->hashID}}">
                                                <i class="material-icons">cloud_upload</i>
                                            </a>
                                            <a href="{{route('retail-receipts.edit', $retail->hashID)}}" class="invoice-action-edit default" data-hash="{{$retail->hashID}}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="{{route('retail-receipts.delete', ['retail' => $retail->retailID])}}" class="invoice-action-edit default" data-hash="{{$retail->hashID}}">
                                                <i class="material-icons">delete</i>
                                            </a>

                                        @endif
                                            <a href="{{route('retail-receipts.print', ['retail' => $retail->hashID])}}" class="invoice-action-print default">
                                                <i class="material-icons">print</i>
                                            </a>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="finals bg-dark">
                            <td></td>
                            <td colspan="3" class="right-align">Σύνολα:</td>
                            <td class="center-align tooltipped" data-position="top" data-tooltip="Σύνολο Εσόδων">&euro; {{number_format($finals, 2, ',', '.')}}</td>
                            <td class="center-align tooltipped" data-position="top" data-tooltip="Σύνολο Φ.Π.Α.">&euro; {{number_format($vats,  2, ',', '.')}}</td>
                            <td class="center-align tooltipped" data-position="top" data-tooltip="Σύνολο Μικτό">&euro; {{number_format($finals + $vats,  2, ',', '.')}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
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

@endsection

@section('page-script')
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
    <script>
        $i = jQuery.noConflict();
        $i(document).ready(function() {
            $i('a.invoice-action-mydata').on('click', function (e) {
                e.preventDefault();

                $i('.ajax-preloader').addClass('active');

                let retailHash = $i(this).data('retail');
                let pageToken = $i('meta[name="csrf-token"]').attr('content');

                $i.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': pageToken
                    }
                });

                $i.ajax({
                    url: "{{ url('/myData-ajax-single') }}",
                    method: 'post',
                    data: {
                        retail: retailHash
                    },
                    success: function (result) {
                        $i('.ajax-preloader').removeClass('active');
                        $i('.hasMark').each(function() {
                           $i(this).removeClass('hide');
                        });
                        $i('a.default[data-retail="'+retailHash+'"]').addClass('hide');
                    }
                });
            });
        });
    </script>
@endsection
