{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if(isset($client))
    @section('title','Επεξεργασία καρτέλας πελάτη')
@else
    @section('title','Καταχώρηση νέου πελάτη')
@endif
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
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        @if(isset($client))
                            <span>Επεξεργασία καρτέλας πελάτη</span>
                        @else
                            <span>Καταχώρηση νέου πελάτη</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div id="prefixes" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Στοιχεία Επιχείρησης</h4>
                <form @if(isset($client)) action="{{route('client.update', ['client' => $client])}}" @else action="{{route('client.store')}}" @endif method="post" class="addresses-item-repeater">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">business_center</i>
                            <input id="company" type="text" name="company" @if(isset($client->company)) value="{{old('company', $client->company)}}" @endif required>
                            <label for="company" class="">Επωνυμία Εταιρείας *</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">computer</i>
                            <input id="work_title" type="text" name="work_title" @if(isset($client->work_title)) value="{{old('work_title', $client->work_title)}}" @endif required>
                            <label for="work_title" class="">Επάγγελμα *</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="name" type="text" name="name" @if(isset($client->name))value="{{old('name', $client->name)}}" @endif required>
                            <label for="name" class="">Ονοματεπώνυμο Υπευθύνου *</label>
                        </div>

                    </div>
                    <div class="row edra">
                        <div class="input-field col s6 m5">
                            <i class="material-icons prefix">markunread_mailbox</i>
                            <input id="address" type="text" name="address" @if(isset($edra)) value="{{old('address', $edra->address)}}" @endif required>
                            <label for="address" class="">Διεύθυνση Έδρας *</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <i class="material-icons prefix">looks_one</i>
                            <input id="number" type="text" name="number" @if(isset($edra->number)) value="{{old('number', $edra->number)}}" @endif required>
                            <label for="number" class="">Αριθμός *</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <i class="material-icons prefix">map</i>
                            <input id="city" type="text" name="city" @if(isset($edra->city))  value="{{old('city', $edra->city)}}" @endif required>
                            <label for="city" class="">Πόλη *</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <i class="material-icons prefix">location_searching

                            </i>
                            <input id="postal_code" type="text" name="postal_code" @if(isset($edra->postal_code))  value="{{old('postal_code', $edra->postal_code)}}" @endif required>
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
                    </div>
                    <div class="row adresses-repeater">
                        <h4 class="card-title">Υποκαταστήματα - Αποθήκες</h4>
                        @if($client->addresses)
                            @foreach($client->addresses as $add)
                                @if($add->address_type !== 0)
                                    <div data-address-id="{{$add->id}}">
                                        <div class="mb-1 count-repeater col sm12 width-100">
                                            <div class="input-field col s6 m2">
                                                <i class="material-icons prefix">buisness</i>
                                                <input type="hidden" name="address_id" value="{{$add->id}}">
                                                <select type="text" name="address_type" required class="invoice-item-select browser-default" style="padding-left: 40px;">
                                                    <option value="Υποκατάστημα" @if($add->address_name = 'Υποκατάστημα') selected @endif>Υποκατάστημα</option>
                                                    <option value="Αποθήκη" @if($add->address_name = 'Αποθήκη') selected @endif>Αποθήκη</option>
                                                </select>
                                            </div>
                                            <div class="input-field col s6 m3">
                                                <i class="material-icons prefix">markunread_mailbox</i>
                                                <input type="text" name="address" placeholder="Διεύθυνση *" value="{{$add->address}}" required>
                                            </div>
                                            <div class="input-field col s6 m1">
                                                <i class="material-icons prefix">looks_one</i>
                                                <input type="text" name="number" placeholder="Αριθμός *" value="{{$add->number}}" required>
                                            </div>
                                            <div class="input-field col s6 m3">
                                                <i class="material-icons prefix">map</i>
                                                <input type="text" name="city" placeholder="Πόλη *" value="{{$add->city}}" required>
                                            </div>
                                            <div class="input-field col s6 m2">
                                                <i class="material-icons prefix">location_searching</i>
                                                <input id="postal_code" type="text" name="postal_code" placeholder="Τ.Κ. *" value="{{$add->postal_code}}" required>
                                            </div>
                                            <div class="invoice-icon display-flex flex-column justify-content-between" style="margin-top: 22px;">
                                              <span class="delete-row-btn delete-address cursor-pointer" data-id="{{$add->id}}">
                                                <i class="material-icons">clear</i>
                                              </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        @if(count($client->addresses) == 1)
                            <p class="mb-3">Δεν υπάρχουν αποθηκευμένα υποκαταστήματα ή αποθήκες για τον πελάτη <strong>{{$client->company}}</strong></p>
                        @endif
                        <h4 class="card-title">Προσθήκη Νέας Διεύθυνσης</h4>
                        <div data-repeater-list="addresses">
                            <div class="mb-1 count-repeater col sm12 width-100" data-repeater-item="">
                                <div class="input-field col s6 m2">
                                    <i class="material-icons prefix">business</i>
                                    <select type="text" name="address_type" required class="invoice-item-select browser-default" style="padding-left: 40px;">
                                        <option value="Υποκατάστημα">Υποκατάστημα</option>
                                        <option value="Αποθήκη">Αποθήκη</option>
                                    </select>
                                </div>
                                <div class="input-field col s6 m3">
                                    <i class="material-icons prefix">markunread_mailbox</i>
                                    <input type="text" name="address" placeholder="Διεύθυνση *" required>
                                </div>
                                <div class="input-field col s6 m1">
                                    <i class="material-icons prefix">looks_one</i>
                                    <input type="text" name="number" placeholder="Αριθμός *" required>
                                </div>
                                <div class="input-field col s6 m3">
                                    <i class="material-icons prefix">map</i>
                                    <input type="text" name="city" placeholder="Πόλη *" required>
                                </div>
                                <div class="input-field col s6 m2">
                                    <i class="material-icons prefix">location_searching</i>
                                    <input id="postal_code" type="text" name="postal_code" placeholder="Τ.Κ. *" required>
                                </div>
                                <div class="invoice-icon display-flex flex-column justify-content-between" style="margin-top: 22px;">
                                  <span data-repeater-delete="" class="delete-row-btn cursor-pointer">
                                    <i class="material-icons">clear</i>
                                  </span>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <button class="btn invoice-repeat-btn" data-repeater-create="" type="button">
                                <i class="material-icons left">add</i>
                                <span>Προσθήκη Διεύθυνσης</span>
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn cyan waves-effect waves-light right" type="submit" name="action">@if(isset($client->vat)) Ενημέρωση @else Καταχώρηση @endif
                                <i class="material-icons right">send</i>
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
