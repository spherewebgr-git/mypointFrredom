{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if(isset($service))
    @section('title','Επεξεργασία Συνδρομής')
@else
    @section('title','Καταχώρηση νέας συνδρομής')
@endif
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
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        @if(isset($service))
                            <span>Επεξεργασία Συνδρομής'</span>
                        @else
                            <span>Καταχώρηση νέας συνδρομής</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div id="prefixes" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Στοιχεία Συνδρομής</h4>
                <form @if(isset($service)) action="{{route('subscriptions.update', ['subscription' => $service])}}" @else action="{{route('subscriptions.store')}}" @endif method="post" class="addresses-item-repeater">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m1">
                            <i class="material-icons prefix">settings_ethernet</i>
                            <input id="subscription_number" type="text" name="subscription_number" @if(isset($service->subscription_number)) value="{{old('subscription_number', $service->subscription_number)}}" @else value="{{$num}}" @endif required>
                            <label for="subscription_number" class="">Κωδικός *</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select class="invoice-item-select" id="client" name="client">
                                <option value="" selected disabled>Επιλέξτε Πελάτη</option>
                                @foreach($clients as $client)
                                    @if($client->disabled != 1)
                                        <option @if(isset($service))
                                                    @if($service->client_hash == $client->hashID)
                                                        selected
                                                @endif
                                                @endif value="{{$client->hashID}}">{{$client->company}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="client" class="">Πελάτης *</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select class="invoice-item-select" id="service_type" name="service_type">
                                <option value="" selected disabled>Επιλέξτε Υπηρεσία</option>
                                <option value="Hosting" @if(isset($service) && $service->service_type === 'Hosting') selected @endif>Hosting</option>
                                <option value="Τεχνική Υποστήριξη" @if(isset($service) && $service->service_type === 'Τεχνική Υποστήριξη') selected @endif>Τεχνική Υποστήριξη</option>
                                <option value="Συνδρομή MyPoint App" @if(isset($service) && $service->service_type === 'Συνδρομή MyPoint App') selected @endif>Συνδρομή MyPoint App</option>
                            </select>
                            <label for="service_type" class="">Υπηρεσία *</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <i class="material-icons prefix">developer_board</i>
                            <input id="service_title" type="text" name="service_title" @if(isset($service->service_title)) value="{{old('service_title', $service->service_title)}}" @endif required>
                            <label for="service_title" class="">Περιγραφή Υπηρεσίας *</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <i class="material-icons prefix">link</i>
                            <input id="service_domain" type="text" name="service_domain" @if(isset($service->service_domain)) value="{{old('service_domain', $service->service_domain)}}" @endif >
                            <label for="service_domain" class="">Domain</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <select class="invoice-item-select" id="service_duration" name="service_duration" required>
                                <option value="" selected disabled>Επιλέξτε Χρέωση</option>
                                <option value="annually" @if(isset($service) && $service->service_duration === 'annually') selected @endif>Άνα Έτος</option>
                                <option value="sixmonths" @if(isset($service) && $service->service_duration === 'sixmonths') selected @endif>Ανά Εξάμηνο</option>
                                <option value="threemonths" @if(isset($service) && $service->service_duration === 'threemonths') selected @endif>Ανά Τρίμηνο</option>
                                <option value="twomonths" @if(isset($service) && $service->service_duration === 'twomonths') selected @endif>Ανά Δίμηνο</option>
                                <option value="monthly" @if(isset($service) && $service->service_duration === 'monthly') selected @endif>Ανά Μήνα</option>
                            </select>
                            <label for="service_duration" class="">Χρέωση & Τιμολόγηση *</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="material-icons prefix">euro_symbol</i>
                            <input id="duration_price" type="text" name="duration_price" pattern="[0-9]*[.]?[0-9]+" title="Για υποδιαστολή χρησιμοποιήστε την τελεία και όχι κόμμα" @if(isset($service->duration_price)) value="{{old('duration_price', $service->duration_price)}}" @endif >
                            <label for="duration_price" class="">Ποσό χρέωσης</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="material-icons prefix">date_range</i>
                            <input id="first_payment" type="date" name="first_payment" @if(isset($service->first_payment)) value="{{old('first_payment', $service->first_payment)}}" @endif >
                            <label for="first_payment" class="">Ημ/νία χρέωσης</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <i class="material-icons prefix">date_range</i>
                            <select id="active_subscription" name="active_subscription">
                                <option value="1" @if(isset($service) && $service->active_subscription = 1) selected @endif>ΕΝΕΡΓΗ</option>
                                <option value="0" @if(isset($service) && $service->active_subscription = 0) selected @endif>ΑΝΕΝΕΡΓΗ</option>
                            </select>
                            <label for="active_subscription" class="">Κατάσταση Συνδρομής</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">@if(isset($service)) Ενημέρωση @else Καταχώρηση @endif
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/form_repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
@endsection

@section('page-script')
    <script>
        $a = jQuery.noConflict();
        $a(document).ready(function () {
            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif
            $a('input#vat').on('mouseout', function(){
                let afm = $a(this).val();
                if(afm.length > 6) {
                    let pageToken = $a('meta[name="csrf-token"]').attr('content');
                    $a.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': pageToken
                        }
                    });
                    $a.ajax({
                        method: "post",
                        url: "{{route('client.vatCheck')}}",
                        data: {vat: afm}
                    }).done(function(response){
                        console.log(response);
                    });
                }
            });
            var uniqueId = 1;
            if ($a(".addresses-item-repeater").length) {
                $a(".addresses-item-repeater").repeater({
                    show: function () {
                        /* Assign unique id to new dropdown */
                        $a(this).find(".dropdown-button").attr("data-target", "dropdown-discount" + uniqueId + "");
                        $a(this).find(".dropdown-content").attr("id", "dropdown-discount" + uniqueId + "");
                        uniqueId++;
                        /* showing the new repeater */
                        $a(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        $a(this).slideUp(deleteElement);
                    }
                });
            }


            $a('.delete-address').on('click', function () {
                $a('.ajax-preloader').addClass('active');

                let addressId = $a(this).data('id');

                let pageToken = $a('meta[name="csrf-token"]').attr('content');

                $a.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': pageToken
                    }
                });

                $a.ajax({
                    url: "{{ url('/delete-address-ajax') }}",
                    method: 'post',
                    data: {
                        id: addressId
                    },
                    success: function (result) {
                        console.log(result);
                        $a('.ajax-preloader').removeClass('active');
                        M.toast({
                            html: result,
                            classes: 'rounded',
                            timeout: 10000
                        });
                        $a('div[data-address-id="'+addressId+'"]').remove();
                    }
                });
            });



        });
    </script>
@endsection
