{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Παραστατικών Εξόδων')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Παραστατικών Εξόδων</span></h5>
                </div>
            </div>
        </div>
    </div>
    <section class="invoice-list-wrapper section">
        <div class="responsive-table">
            <div class="card print-hide">
                <div class="card-content container">
                    <h4 class="card-title">Αναζήτηση Βάσει Ημερομηνίας</h4>
                    <form action="{{route('outcome.filter')}}" method="post" class="row display-flex align-items-center justify-content-start">
                        @csrf
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
                            <button type="submit" class="btn btn-xs btn-info filter-btn display-flex align-items-center"><i class="material-icons" style="margin-right: 5px;">compare_arrows</i> Προσαρμογή Φίλτρου</button>
                        </div>
                        <div class="invoice-create-btn col ml-18">
                            <a href="{{route('outcome.create')}}"
                               class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                                <i class="material-icons">add</i>
                                <span class="hide-on-small-only">Νέο Παραστατικό</span>
                            </a>
                        </div>
                        <div class="invoice-filter-action col">
                            <a href="javascript:if(window.print)window.print()" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
                                <i class="material-icons">print</i>
                                <span class="hide-on-small-only">Εκτύπωση</span>
                            </a>
                        </div>
                    </form>

                </div>
            </div>
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <div class="clear"></div>
                <table class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                       id="DataTables_Table_0" role="grid">
                    <thead>
                    <tr role="row">
                        <th class="control sorting_disabled" rowspan="1" colspan="1"
                            style="width: 19.8906px; display: none;" aria-label=""></th>
                        <th style="width: 130px!important;">
                            <span>Αρ. Παραστατικού</span>
                        </th>
                        <th style="width: 45%!important;">Κατάστημα</th>
                        <th class="center-align" style="width: 110px!important;">Ημ/νία Έκδοσης</th>
                        <th class="center-align" style="width: 85px!important;">Τιμή</th>
                        <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                        <th class="center-align print-hide" style="width: 85px!important;">Σύνολο</th>
                        <th class="center-align print-hide">Ενέργειες</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($outcomes as $outcome)
                    <tr role="row">
                        <td class=" control" tabindex="0" style="display: none;"></td>
                        <td>{{$outcome->outcome_number}}</td>
                        <td>{{$outcome->shop}}</td>
                        <td class="center-align">{{\Carbon\Carbon::createFromTimestamp(strtotime($outcome->date))->format('d/m/Y')}}</td>
                        <td class="center-align">&euro; {{number_format($outcome->price, 2, ',', '.')}}</td>
                        <td class="center-align">&euro; {{number_format($outcome->vat, 2, ',', '.')}}</td>
                        <td class="center-align">&euro; {{number_format($outcome->price + $outcome->vat, 2, ',', '.')}}</td>
                        <td class="center-align print-hide">
                            <div class="invoice-action">

                                    <a href="{{route('outcome.download', ['outcome' => $outcome->hashID])}}" class="invoice-action-view mr-4">
                                        <i class="material-icons">cloud_download</i>
                                    </a>
                                    <a href="{{route('outcome.edit', ['outcome' => $outcome->hashID])}}" class="invoice-action-edit">
                                        <i class="material-icons">edit</i>
                                    </a>
                                <a href="{{route('outcome.delete', ['outcome' => $outcome->hashID])}}" class="invoice-action-delete">
                                    <i class="material-icons">delete</i>
                                </a>

                            </div>
                        </td>

                    </tr>
                    @endforeach
                    <tr class="sumPrices">
                        <td colspan="2"></td>
                        <td class="">Σύνολα:</td>
                        <td class="center">&euro; {{number_format($finals, 2, ',', '.')}}</td>
                        <td class="center">&euro; {{number_format($fpa, 2, ',', '.')}}</td>
                        <td class="center">&euro; {{number_format($finals + $fpa, 2, ',', '.')}}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
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
        });
@endsection
