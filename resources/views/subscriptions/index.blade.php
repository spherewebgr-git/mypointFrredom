{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Λίστα Συνδρομών')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Λίστα Συνδρομών</span></h5>
                </div>
                <div class="invoice-head--right row col s12 m6 display-flex justify-content-end align-items-center">
                    <div class="invoice-create-btn col">
                        <a href="{{route('subscriptions.new')}}"
                           class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                            <i class="material-icons">add</i>
                            <span>Νέα Συνδρομή</span>
                        </a>
                    </div>
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
            <div class="table-container">
                <table class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                       id="DataTables_Table_0" role="grid">
                    <thead>
                    <tr role="row">
                        <th class="control sorting_disabled" rowspan="1" colspan="1"
                            style="width: 19.8906px; display: none;" aria-label=""></th>
                        <th>Πελάτης</th>
                        <th class="center-align">Είδος Υπηρεσίας</th>
                        <th class="center-align">Domain</th>
                        <th class="center-align">Συνδρομή ανά</th>
                        <th class="center-align" style="width: 85px!important;" title="Τιμή Χωρίς ΦΠΑ">Τιμή</th>
                        <th class="center-align print-hide hide-on-med-and-down" title="Ημερομηνία Επόμενης Τιμολόγησης">Ημ/νία Τιμολόγησης</th>
                        <th class="center-align print-hide">Κατάσταση</th>
                        <th class="center-align print-hide">Ενέργειες</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($services) > 0)
                        @php $count = 0; @endphp
                        @foreach($services as $service)
                            <tr role="row" class="{{(++$count%2 ? "odd" : "even")}}">
                                <td><a href="{{route('client.view', $service->client->hashID)}}">{{$service->client->company}}</a></td>
                                <td class="center-align">{{$service->service_type}}</td>
                                <td class="center-align"><a href="//{{$service->service_domain}}" target="_blank" class="display-flex align-items-center justify-content-center">{{$service->service_domain}} <i class="material-icons" style="font-size: 17px;margin-left: 3px;">launch</i></a></td>
                                <td class="center-align">{{$service->service_duration}}</td>
                                <td class="center-align">&euro; {{$service->duration_price}}</td>
                                <td class="center-align"><small>{{\Carbon\Carbon::createFromTimestamp(strtotime($service->first_payment))->format('d')}}/{{date('m', strtotime('1 month'))}}</small></td>
                                <td class="center-align"><i class="material-icons prefix {{$service->active_subscription == 1 ? 'green-text' : 'red-text'}}">{{$service->active_subscription == 1 ? 'blur_on' : 'blur_off'}}</i></td>
                                <td class="center-align print-hide">
                                    <div class="invoice-action">
                                        <a href="{{route('subscriptions.edit', ['service' => $service->hashID])}}" class="invoice-action-view mr-4">
                                            <i class="material-icons">edit</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="notification">
                            <td class="center-align" colspan="9">Δεν υπάρχουν καταχωρημένες συνδρομές</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
{{-- scripts --}}
@section('page-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
    <script>
    @if(Session::has('notify'))
        M.toast({
            html: '{{Session::get("notify") }}',
            classes: 'rounded',
            timeout: 10000
        });
    @endif
    </script>
@endsection
