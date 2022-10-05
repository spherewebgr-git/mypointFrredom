{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Καταχώρηση νέου πελάτη')

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
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Καταχώρηση νέου πελάτη</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div id="prefixes" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Στοιχεία Επιχείρησης</h4>
                <form @if(isset($client)) action="{{route('client.update', ['client' => $client])}}" @else action="{{route('client.store')}}" @endif method="post">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m5">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="name" type="text" name="name" @if(isset($client->name))value="{{old('name', $client->name)}}" @endif required>
                            <label for="name" class="">Ονοματεπώνυμο Υπευθύνου *</label>
                        </div>
                        <div class="input-field col s12 m7">
                            <i class="material-icons prefix">business_center</i>
                            <input id="company" type="text" name="company" @if(isset($client->company)) value="{{old('company', $client->company)}}" @endif required>
                            <label for="company" class="">Επωνυμία Εταιρείας *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m5">
                            <i class="material-icons prefix">computer</i>
                            <input id="work_title" type="text" name="work_title" @if(isset($client->work_title)) value="{{old('work_title', $client->work_title)}}" @endif required>
                            <label for="work_title" class="">Επάγγελμα *</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">markunread_mailbox</i>
                            <input id="address" type="text" name="address" @if(isset($client->address)) value="{{old('address', $client->address)}}" @endif required>
                            <label for="address" class="">Διεύθυνση Έδρας *</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">markunread_mailbox</i>
                            <input id="number" type="text" name="number" @if(isset($client->number)) value="{{old('number', $client->number)}}" @endif required>
                            <label for="number" class="">Αριθμός *</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <i class="material-icons prefix">map</i>
                            <input id="city" type="text" name="city" @if(isset($client->city))  value="{{old('city', $client->city)}}" @endif required>
                            <label for="city" class="">Πόλη *</label>
                        </div>
                        <div class="input-field col s6 m1">
                            <i class="material-icons prefix">map</i>
                            <input id="postal_code" type="text" name="postal_code" @if(isset($client->postal_code))  value="{{old('postal_code', $client->postal_code)}}" @endif required>
                            <label for="postal_code" class="">Τ.Κ. *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">flip</i>
                            <input id="vat" type="text" name="vat" @if(isset($client->vat))  value="{{old('vat', $client->vat)}}" @endif required>
                            <label for="vat" class="">ΑΦΜ *</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">layers</i>
                            <input id="doy" type="text" name="doy" @if(isset($client->doy))  value="{{old('doy', $client->doy)}}" @endif required>
                            <label for="doy" class="">ΔΟΥ *</label>
                        </div>
                        <div class="input-field col s6 m6">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" name="email" @if(isset($client->email))  value="{{old('email', $client->email)}}" @endif required>
                            <label for="email" class="">E-mail Υπευθύνου *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">phone</i>
                            <input id="phone" type="text" name="phone" @if(isset($client->phone))  value="{{old('phone', $client->phone)}} @endif">
                            <label for="phone" class="">Τηλέφωνο Εταιρείας</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">phone_iphone</i>
                            <input id="mobile" type="text" name="mobile" @if(isset($client->mobile)) value="{{old('mobile', $client->mobile)}} @endif">
                            <label for="mobile" class="">Κινητό Υπευθύνου Επικοινωνίας</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">email</i>
                            <input id="mail_account" type="email" name="mail_account" @if(isset($client->mail_account)) value="{{old('mail_account', $client->mail_account)}} @endif">
                            <label for="mail_account" class="">E-mail Λογιστηρίου</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">contact_phone</i>
                            <input id="phone_account" type="text" name="phone_account" @if(isset($client->phone_account)) value="{{old('phone_account', $client->phone_account)}} @endif">
                            <label for="phone_account" class="">Τηλέφωνο Λογιστηρίου</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">@if(isset($client->vat)) Ενημέρωση @else Καταχώρηση @endif
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
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
@endsection
