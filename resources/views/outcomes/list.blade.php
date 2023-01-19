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
                <div class="col s10 m6 l4">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Παραστατικών Εξόδων</span></h5>
                </div>
                <div class="invoice-head--right row col s12 m6 l8 display-flex justify-content-end align-items-center">
                    <div class="invoice-create-btn col ml-18">
                        <a href="{{route('outcome.getExpenses')}}"
                           class="btn waves-effect waves-light invoice-create border-round z-depth-4" title="Ενημέρωση Εξόδων προς Χαρακτηρισμό από το myData">
                            <i class="material-icons">rotate_right</i>
                            <span class="hide-on-small-only">Ενημέρωση Εξόδων</span>
                        </a>
                    </div>
                    <div class="invoice-create-btn col">
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
                </div>
            </div>
        </div>
    </div>

    <section class="invoice-list-wrapper section">

        <div class="responsive-table">
            <div class="card print-hide">
                <div class="card-content container">
                    <h4 class="card-title">Αναζήτηση Βάσει Ημερομηνίας</h4>
                    <form action="{{route('outcome.filter')}}" method="post" class="row display-flex align-items-center justify-content-between">
                        @csrf
                        <div class="col display-flex align-items-center">
                            <label for="start" class="col display-flex align-items-center justify-content-end"><i class="material-icons">date_range</i> Από:</label>
                            <div class="col">
                                <input type="text" id="datepickerStart" name="date-start" class="datepicker"
                                       value="@isset($dateStart){{date('d/m/Y', strtotime($dateStart))}}@else 01/01/{{date('Y')}} @endif"
                                       title="Φίλτρο από:">
                            </div>
                        </div>
                        <div class="col display-flex align-items-center">
                            <label for="end" class="col display-flex align-items-center justify-content-end"><i class="material-icons">date_range</i> Έως: </label>
                            <div class="col">
                                <input type="text" id="datepickerEnd" name="date-end" class="datepicker"
                                       value="@isset($dateEnd){{date('d/m/Y', strtotime($dateEnd))}}@else{{date('d/m/Y')}}@endif"
                                       title="Φίλτρο εως:">
                            </div>
                        </div>
                        <div class="col display-flex align-items-center">
                            <div class="col select-wrapper">
                                <select name="status" id="status" class="browser-default select-wrapper">
                                    <option value="" selected disabled>Επιλέξτε Κατάσταση</option>
                                    <option value="crosschecked">Αντιστοιχισμένα</option>
                                    <option value="uncrosschecked">Αναντιστοίχιστα</option>
                                    <option value="classified">Χαρακτηρισμένα</option>
                                </select>
                                <label for="status" class="active">Κατάσταση</label>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-xs btn-info filter-btn display-flex align-items-center"><i class="material-icons" style="margin-right: 5px;">compare_arrows</i> Προσαρμογή Φίλτρου</button>
                            </div>
                        </div>
                        <div class="col select-wrapper">
                            <select name="year" id="year" class="browser-default select-wrapper">
                                <option value="2023" @if(!isset($year)) selected @endif>2023</option>
                                <option value="2022" @if(isset($year) && $year == 2022) selected @endif>2022</option>
                                <option value="2021" @if(isset($year) && $year == 2021) selected @endif>2021</option>
                                <option value="2020" @if(isset($year) && $year == 2020) selected @endif>2020</option>
                            </select>
                            <label for="year" class="active">Επιλέξτε Έτος</label>
                        </div>

                    </form>

                </div>
            </div>
            <div class="card color-info">
                <div class="card-container">
                    <ul>
                        <li>
                            <div class="color" style="background-color: #fff;"></div> <span>Εισαγωγή από MyDATA</span>
                        </li>
                        <li>
                            <div class="color" style="background-color: #fff3d0;"></div> <span>Αντιστοιχισμένα</span>
                        </li>
                        <li>
                            <div class="color" style="background-color: #fad5eb;"></div> <span>Αναντιστοίχιστα</span>
                        </li>
                        <li>
                            <div class="color" style="background-color: #e4ffe4;"></div> <span>Χαρακτηρισμένα</span>
                        </li>
                    </ul>
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
                        <th style="width: 25%!important;">Επωνυμία Προμηθευτή</th>
                        <th class="center-align">Τύπος Παραστατικού</th>
                        <th class="center-align" style="width: 110px!important;">Ημ/νία Έκδοσης</th>
                        <th class="center-align" style="width: 85px!important;">Τιμή</th>
                        <th class="center-align" style="width: 85px!important;">Φ.Π.Α.</th>
                        <th class="center-align print-hide" style="width: 85px!important;">Σύνολο</th>
                        <th class="center-align print-hide" style="width: 85px!important;">Κατάσταση</th>
                        <th class="center-align print-hide" style="width: 75px!important;">Ενέργειες</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($outcomes as $outcome)

                        <tr role="row" class="{{$outcome->status}}">
                            <td class=" control" tabindex="0" style="display: none;"></td>
                            <td>@if($outcome->outcome_number) {{$outcome->outcome_number}} @else - @endif</td>
                            <td>@if($outcome->status == 'efka') ΕΦΚΑ @else {{getProviderName($outcome->shop)}} @endif</td>
                            <td class="center-align">{{getInvoiceTypeName($outcome->invType)}}</td>
                            <td class="center-align">{{\Carbon\Carbon::createFromTimestamp(strtotime($outcome->date))->format('d/m/Y')}}</td>
                            <td class="center-align">&euro; {{number_format($outcome->price, 2, ',', '.')}}</td>
                            <td class="center-align">&euro; {{number_format($outcome->vat, 2, ',', '.')}}</td>
                            <td class="center-align">&euro; {{number_format($outcome->price + $outcome->vat, 2, ',', '.')}}</td>
                            <td class="center-align class-status">
                                <i class="material-icons open-statuses">art_track</i>
                                <div class="outcome-classifications-status-list">
                                    <ul>
                                        <li class="display-flex align-items-center">
                                            <i class="material-icons mr-4" style="color: green">compare_arrows</i> @if($outcome->minMark) Εισαγωγή από MyDATA @else Εισαγωγή από το χρήστη @endif
                                        </li>
                                        <li class="display-flex align-items-center">
                                            @if($outcome->status == 'crosschecked' || $outcome->status == 'efka')
                                                <i class="material-icons mr-4" style="color: green">check</i> @else <i class="material-icons mr-4" style="color: red">close</i> @endif  Έχουν χαρακτηρίσει</li>
                                        <li class="display-flex align-items-center">@if(isset($outcome->mark))
                                                <i class="material-icons mr-4" style="color: green">developer_mode</i> @else <i class="material-icons mr-4" style="color: orange">hourglass_empty</i> @endif Έχουν μαρκαριστεί</li>
                                    </ul>
                                </div>
                            </td>
                            <td class="center-align print-hide">
                                <div class="invoice-action">
                                    @if(isset($outcome->file) && $outcome->file != '')
                                    <a href="{{route('outcome.download', ['outcome' => $outcome->hashID])}}" class="invoice-action-edit">
                                        <i class="material-icons">cloud_download</i>
                                    </a>
                                    @else
                                        <a href="#" class="invoice-action-edit">
                                            <i class="material-icons">cloud_off</i>
                                        </a>
                                    @endif
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
                        <td colspan="3"></td>
                        <td class="">Σύνολα:</td>
                        <td class="center">&euro; {{number_format($finals, 2, ',', '.')}}</td>
                        <td class="center">&euro; {{number_format($fpa, 2, ',', '.')}}</td>
                        <td class="center">&euro; {{number_format($finals + $fpa, 2, ',', '.')}}</td>
                        <td></td>
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
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>

    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function () {

            $m('#year').on('change', function(){
                let url = window.location.href;
                let year = $m(this).val();
                window.location.href = '/filter-outcomes/year/'+year;
            });

            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif

        });
    </script>
@endsection
