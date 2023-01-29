{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Καταχώρηση νέου προμηθευτή')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Καταχώρηση νέου προμηθευτή</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div id="prefixes" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Στοιχεία Προμηθευτή</h4>
                <form @if(isset($provider)) action="{{route('provider.update', ['provider' => $provider])}}" @else action="{{route('provider.store')}}" @endif method="post">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m5">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="provider_id" type="text" name="provider_id" @if(isset($provider->provider_id))value="{{old('provider_id', $provider->provider_id)}}"  @else value="{{$number}}" @endif required>
                            <label for="provider_id" class="">Κωδικός Προμηθευτή *</label>
                        </div>
                        <div class="input-field col s12 m7">
                            <i class="material-icons prefix">business_center</i>
                            <input id="provider_name" type="text" name="provider_name" @if(isset($provider->provider_name)) value="{{old('provider_name', $provider->provider_name)}}" @endif required>
                            <label for="provider_name" class="">Επωνυμία Προμηθευτή*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m4">
                            <i class="material-icons prefix">markunread_mailbox</i>
                            <input id="address" type="text" name="address" @if(isset($provider->address)) value="{{old('address', $provider->address)}}" @endif required>
                            <label for="address" class="">Διεύθυνση Έδρας προμηθευτή *</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <i class="material-icons prefix">markunread_mailbox</i>
                            <input id="address_number" type="text" name="address_number" @if(isset($provider->address_number)) value="{{old('address_number', $provider->address_number)}}" @endif required>
                            <label for="address_number" class="">Αριθμός *</label>
                        </div>
                        <div class="input-field col s6 m4">
                            <i class="material-icons prefix">map</i>
                            <input id="city" type="text" name="city" @if(isset($provider->city))  value="{{old('city', $provider->city)}}" @endif required>
                            <label for="city" class="">Πόλη *</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <i class="material-icons prefix">map</i>
                            <input id="address_tk" type="text" name="address_tk" @if(isset($provider->address_tk))  value="{{old('address_tk', $provider->address_tk)}}" @endif required>
                            <label for="address_tk" class="">Τ.Κ. *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m6">
                            <i class="material-icons prefix">flip</i>
                            <input id="provider_vat" type="text" name="provider_vat" @if(isset($provider->provider_vat))  value="{{old('provider_vat', $provider->provider_vat)}}" @endif required>
                            <label for="provider_vat" class="">ΑΦΜ *</label>
                        </div>
                        <div class="input-field col s6 m6">
                            <i class="material-icons prefix">layers</i>
                            <input id="provider_doy" type="text" name="provider_doy" @if(isset($provider->provider_doy))  value="{{old('doy', $provider->provider_doy)}}" @endif required>
                            <label for="provider_doy" class="">ΔΟΥ *</label>
                        </div>
                        <div class="input-field col s6 m6">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" name="email" @if(isset($provider->email))  value="{{old('email', $provider->email)}}" @endif>
                            <label for="email" class="">E-mail Προμηθευτή</label>
                        </div>
                        <div class="input-field col s6 m6">
                            <i class="material-icons prefix">phone</i>
                            <input id="phone" type="text" name="phone" @if(isset($provider->phone))  value="{{old('phone', $provider->phone)}} @endif">
                            <label for="phone" class="">Τηλέφωνο Προμηθευτή</label>
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
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
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
