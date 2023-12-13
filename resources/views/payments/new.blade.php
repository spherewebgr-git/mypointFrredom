{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Καταχώρηση νέας πληρωμής')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Καταχώρηση νέας πληρωμής</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div id="prefixes" class="card card card-default scrollspy">
        <div class="card-content">
            <h4 class="card-title">Στοιχεία Πληρωμής</h4>
            <form @if(isset($payment)) action="{{route('payment.update', ['payment' => $payment])}}" @else action="{{route('payment.store')}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">account_circle</i>
                        <select class="invoice-item-select browser-default" id="client" name="client" style="padding-left: 35px;">
                            <option value="" selected disabled>Επιλέξτε Πελάτη</option>
                            @foreach($clients as $client)
                                @if($client->disabled != 1)
                                    <option @if(isset($payment))
                                                @if($invoice->client_id == $client->id)
                                                    selected
                                            @endif
                                            @endif value="{{$client->hashID}}">{{$client->company}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">account_circle</i>
                        <select class="invoice-item-select browser-default" id="invoice" name="invoice" style="padding-left: 35px;">
                            <option value="" selected disabled>Επιλέξτε Τιμολόγιο</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">date_range</i>
                        <div class="display-flex ml-4">
                            <input type="text" class="datepicker mb-1" name="date"
                                   placeholder="Επιλέξτε Ημ/νία" style="padding-left: 30px"
                                   @if(isset($payment->payment_date))
                                       value="{{\Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y')}}"
                                   @else
                                       value="{{date('d/m/Y')}}
                                                       @endif "/>

                        </div>
                    </div>
                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">euro_symbol</i>
                        <input id="payment_price" type="text" name="payment_price" @if(isset($payment->payment_price)) value="{{old('payment_price', $payment->payment_price)}}" @endif required>
                        <label for="payment_price" class="">Ποσό Κατάθεσης *</label>
                    </div>
                </div>
                <div class="row">

                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">account_balance</i>
                        <select class="form-select" name="bank" id="bank" >
                            <option value="">Επιλέξτε Τράπεζα</option>
                            @foreach(getBankNames() as $bank)
                                <option value="{{$bank}}" @if(isset($payment) && $bank == $payment->bank) selected @endif>{{$bank}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">short_text</i>
                        <input id="bank_code" type="text" name="bank_code" @if(isset($payment->bank_code))  value="{{old('bank_code', $payment->bank_code)}}" @endif required>
                        <label for="bank_code" class="">Αρ. Συναλλαγής *</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <i class="material-icons prefix">map</i>
                        <input id="description" type="text" name="description" @if(isset($payment->description))  value="{{old('description', $ayment->description)}}" @endif required>
                        <label for="description" class="">Αιτιολογία *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12">
                        <div class="file-field input-field s12">
                            <div class="btn">
                                <span>Αποδεικτικό Κατάθεσης</span>
                                <input type="file" name="bank_file"
                                       @if(isset($payment->bank_file))  value="{{old('bank_file', $payment->bank_file)}}" @endif>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text"
                                       @if(isset($payment->bank_file))  value="{{old('bank_file', $payment->bank_file)}}" @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">@if(isset($provider->provider_vat)) Ενημέρωση @else Καταχώρηση @endif
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
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
@section('page-script')

    <script>
        $r = jQuery.noConflict();
        $r(document).ready(function () {
            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif
            $r('select#client').on('change', function () {
                $r('.ajax-preloader').addClass('active');

                let clientHash = $r('select#client option:selected').val();
                console.log(clientHash);

                let pageToken = $r('meta[name="csrf-token"]').attr('content');

                $r.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': pageToken
                    }
                });

                $r.ajax({
                    url: "{{ url('/client-invoices-search-ajax') }}",
                    method: 'post',
                    data: {
                        client: clientHash
                    },
                    success: function (result) {
                        console.log(result);
                        $r('.ajax-preloader').removeClass('active');
                        $r('#invoice option').remove();
                        $r('#invoice').append('<option value="">Επιλέξτε Τιμολόγιο</option>');
                        if (result.length > 0) {
                            $r.each(result, function (k, v) {
                                $r('#invoice').append('<option value="'+v.hashID+'">'+v.seira+'/'+v.invoiceID+' | '+v.date+'</option>')
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
