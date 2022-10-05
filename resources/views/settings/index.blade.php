{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Ρυθμίσεις Εφαρμογής')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-account-settings.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="tabs-vertical mt-1 section">
        <div class="row">
            <div class="col l4 s12">
                <!-- tabs  -->
                <div class="card-panel">
                    <ul class="tabs">
                        <li class="tab">
                            <a href="#general">
                                <i class="material-icons">person</i>
                                <span>ΧΡΗΣΤΗΣ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#info">
                                <i class="material-icons">error_outline</i>
                                <span> ΦΟΡΟΛΟΓΙΚΑ </span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#mydata">
                                <i class="material-icons">link</i>
                                <span> ΣΥΝΔΕΣΗ myData </span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#invoices">
                                <i class="material-icons">lock_open</i>
                                <span>ΠΑΡΑΣΤΑΤΙΚΑ</span>
                            </a>
                        </li>

{{--                        <li class="tab">--}}
{{--                            <a href="#notifications">--}}
{{--                                <i class="material-icons">notifications_none</i>--}}
{{--                                <span> Notifications</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </div>
            <div class="col l8 s12">
                <!-- tabs content -->
                <div id="general">
                    <div class="card-panel">
                        <form action="{{route('settings.update', ['form' => 'general'])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="display-flex">
                                <div class="media">
                                    <img src="{{url('images/system/'.$settings->logo)}}" class="border-radius-4" alt="profile image"
                                         height="64" width="64">
                                </div>
                                <div class="media-body">
                                    <div class="general-action-btn">
                                        <div class="file-field input-field s12">
                                            <div class="btn">
                                                <span>Φωτογραφία / Λογότυπο</span>
                                                <input type="file" name="file" @if(isset($settings->logo))  value="{{old('file', $settings->logo)}}" @endif>
                                            </div>
                                            <div class="file-path-wrapper" style="opacity:0;">
                                                <input class="file-path validate" name="logo" type="text" @if(isset($settings->logo))  value="{{old('file', $settings->logo)}}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 mt-1 clearfix"></div>
                                    <small>Επιτρέπονται JPG ή PNG. Ιδανικές Διαστάσεις 300x300</small>
                                </div>
                            </div>
                            <div class="divider mb-1 mt-1"></div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        <label for="name">Ονοματεπώνυμο Ιδιοκτήτη</label>
                                        <input id="name" name="name" type="text" value="{{$admin->name}}" data-error=".errorTxt2">
                                        <small class="errorTxt2"></small>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <label for="email">E-mail</label>
                                        <input id="email" type="email" name="email" value="{{$admin->email}}" data-error=".errorTxt3" disabled>
                                        <small class="errorTxt3"></small>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <input id="phone" name="phone" type="text" class="validate" value="{{$settings->phone}}">
                                        <label for="phone">Τηλέφωνο</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <input id="mobile" name="mobile" type="text" class="validate" value="{{$settings->mobile}}">
                                        <label for="mobile">Κινητό</label>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end form-action">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="mydata">
                    <div class="card-panel">
                        <form action="{{route('settings.update', ['form' => 'mydata'])}}" method="post" class="paaswordvalidate">
                            @csrf
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="aade_user_id" name="aade_user_id" type="text" value="{{$settings->aade_user_id}}">
                                        <label for="aade_user_id">ΑΑΔΕ User ID</label>
                                        <small class="errorTxt4"></small>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="ocp_apim_subscription_key" name="ocp_apim_subscription_key" type="text" value="{{$settings->ocp_apim_subscription_key}}">
                                        <label for="ocp_apim_subscription_key">MyData Subscription Key</label>
                                        <small class="errorTxt5"></small>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end form-action">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση</button>
                                </div>
                                <div class="col s12 mt-1 mb-1">
                                    <a href="#" id="openMydataInfo" class="btn cyan waves-effect waves-light">
                                        Οδηγίες δημιουργίας κωδικών myData</strong>
                                    </a>
                                </div>
                                <div class="mydata-howto hide col s12 mt-1 mb-1">
                                    <p>Για να δημιουργείσετε τους παραπάνω κωδικούς για την επιχείρησή σας ακολουθήστε τα παρακάτω βήματα:</p>
                                    <ol>
                                        <li>Ακολουθήστε τον σύνδεσμο (<a href="https://www1.aade.gr/saadeapps2/bookkeeper-web/" target="_blank">https://www1.aade.gr/saadeapps2/bookkeeper-web/</a> ) και κάντε σύνδεση με τους κωδικούς taxis σας.</li>
                                        <li>Αφού συνδεθείτε, επιλέξτε <strong>"Εγγραφή στο myDATA REST API"</strong></li>
                                        <li>Έπειτα στην ενότητα "Χρήστες" πατήτε το <strong>"Νέα εγγραφή χρήστη"</strong><br /><img src="{{asset('images/new-user-mydata.png')}}" alt="new user my data" /> </li>
                                        <li>Συμπληρώστε τα πεδία ως εξής:
                                            <ul>
                                                <li><strong>Όνομα χρήστη</strong> | Μπορεί να αποτελείτε μόνο από λατινικούς χαρακτήρες και αριθμούς</li>
                                                <li><strong>Κωδικός πρόσβασης</strong> | Χρησιμοποιήστε ένα κωδικό που χρησιμοποείτε σύχνα.</li>
                                                <li><strong>Επιβεβαίωση κωδ. πρόσβασης</strong> | Επαναλάβετε την εισαγωγή του ίδιου κωδικού</li>
                                                <li><strong>Διεύθυνση ηλ. ταχυδρομείου</strong> | Δήλωστε ένα πραγματικό e-mail στο οποίο έχετε πρόσβαση</li>
                                            </ul>
                                        </li>
                                        <li>Πατήστε <strong>"Προσθήκη χρήστη"</strong></li>
                                        <li>Αντιγράψτε χωρίς κενά το Όνομα χρήστη που δώσατε και το Subscription Key που θα σας δωθεί στα 2 παραπάνω πεδία και πατήστε <strong>"Αποθήκευση"</strong></li>
                                    </ol>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
{{--                <div id="change-password">--}}
{{--                    <div class="card-panel">--}}
{{--                        <form class="paaswordvalidate">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col s12">--}}
{{--                                    <div class="input-field">--}}
{{--                                        <input id="oldpswd" name="oldpswd" type="password" data-error=".errorTxt4">--}}
{{--                                        <label for="oldpswd">Προηγούμενος Κωδικός</label>--}}
{{--                                        <small class="errorTxt4"></small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col s12">--}}
{{--                                    <div class="input-field">--}}
{{--                                        <input id="newpswd" name="newpswd" type="password" data-error=".errorTxt5">--}}
{{--                                        <label for="newpswd">Νέος Κωδικός</label>--}}
{{--                                        <small class="errorTxt5"></small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col s12">--}}
{{--                                    <div class="input-field">--}}
{{--                                        <input id="repswd" type="password" name="repswd" data-error=".errorTxt6">--}}
{{--                                        <label for="repswd">Επαναπληκτρολογήστε το νέο κωδικό</label>--}}
{{--                                        <small class="errorTxt6"></small>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col s12 display-flex justify-content-end form-action">--}}
{{--                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αλλαγή Κωδικού</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div id="info">
                    <div class="card-panel">
                        <form action="{{route('settings.update', ['form' => 'info'])}}" class="infovalidate" method="post">
                            @csrf
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="company" type="text" name="company" value="{{$settings->company}}">
                                        <label for="company">Επωνυμία Επιχείρησης</label>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="company_title" name="title" type="text" value="{{$settings->title}}">
                                        <label for="company_title">Διακριτικός Τίτλος</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="business" name="business" type="text" value="{{$settings->business}}">
                                        <label for="business">Επάγγελμα</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="address" name="address" type="text" value="{{$settings->address}}">
                                        <label for="address">Διεύθυνση Έδρας (Όδος Αριθμός, ΤΚ, Περιοχή, Πόλη)</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <input id="vat" name="vat" type="text" value="{{$settings->vat}}">
                                        <label for="vat">Α.Φ.Μ.</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <label for="doy">ΔΟΥ</label>
                                    <div class="input-field" style="margin-top: -7px;">
                                        <select class="browser-default" id="doy" name="doy">
                                            <option value="Α ΑΘΗΝΩΝ" @if($settings->doy == 'Α ΑΘΗΝΩΝ') selected @endif>ΔΟΥ Α' ΑΘΗΝΩΝ</option>
                                            <option value="Δ ΑΘΗΝΩΝ" @if($settings->doy == 'Δ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ Δ' ΑΘΗΝΩΝ</option>
                                            <option value="ΣΤ ΑΘΗΝΩΝ" @if($settings->doy == 'ΣΤ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΣΤ' ΑΘΗΝΩΝ</option>
                                            <option value="ΙΒ ΑΘΗΝΩΝ" @if($settings->doy == 'ΙΒ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΒ' ΑΘΗΝΩΝ, Ζωγράφου</option>
                                            <option value="ΙΓ ΑΘΗΝΩΝ" @if($settings->doy == 'ΙΓ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΓ' ΑΘΗΝΩΝ</option>
                                            <option value="ΙΔ ΑΘΗΝΩΝ" @if($settings->doy == 'ΙΔ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΔ' ΑΘΗΝΩΝ</option>
                                            <option value="ΙΖ ΑΘΗΝΩΝ" @if($settings->doy == 'ΙΖ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΖ' ΑΘΗΝΩΝ</option>
                                            <option value="ΚΑΤΟΙΚΩΝ ΕΞΩΤΕΡΙΚΟΥ" @if($settings->doy == 'ΚΑΤΟΙΚΩΝ ΕΞΩΤΕΡΙΚΟΥ') selected @endif>ΔΟΥ ΚΑΤΟΙΚΩΝ ΕΞΩΤΕΡΙΚΟΥ</option>
                                            <option value="Φ.Α.Ε. ΑΘΗΝΩΝ" @if($settings->doy == 'Φ.Α.Ε. ΑΘΗΝΩΝ') selected @endif>ΔΟΥ Φ.Α.Ε. ΑΘΗΝΩΝ, Καλλιθέα</option>
                                            <option value="ΑΓΙΟΥ ΔΗΜΗΤΡΙΟΥ" @if($settings->doy == 'ΑΓΙΟΥ ΔΗΜΗΤΡΙΟΥ') selected @endif>ΔΟΥ ΑΓΙΟΥ ΔΗΜΗΤΡΙΟΥ</option>
                                            <option value="ΑΓΙΩΝ ΑΝΑΡΓΥΡΩΝ" @if($settings->doy == 'ΑΓΙΩΝ ΑΝΑΡΓΥΡΩΝ') selected @endif>ΔΟΥ ΑΓΙΩΝ ΑΝΑΡΓΥΡΩΝ</option>
                                            <option value="ΑΙΓΑΛΕΩ" @if($settings->doy == 'ΑΙΓΑΛΕΩ') selected @endif>ΔΟΥ ΑΙΓΑΛΕΩ</option>
                                            <option value="ΑΜΑΡΟΥΣΙΟΥ" @if($settings->doy == 'ΑΜΑΡΟΥΣΙΟΥ') selected @endif>ΔΟΥ ΑΜΑΡΟΥΣΙΟΥ</option>
                                            <option value="ΒΥΡΩΝΑ" @if($settings->doy == 'ΒΥΡΩΝΑ') selected @endif>ΔΟΥ ΒΥΡΩΝΑ</option>
                                            <option value="ΓΑΛΑΤΣΙΟΥ" @if($settings->doy == 'ΓΑΛΑΤΣΙΟΥ') selected @endif>ΔΟΥ ΓΑΛΑΤΣΙΟΥ</option>
                                            <option value="ΓΛΥΦΑΔΑΣ" @if($settings->doy == 'ΓΛΥΦΑΔΑΣ') selected @endif>ΔΟΥ ΓΛΥΦΑΔΑΣ</option>
                                            <option value="ΗΛΙΟΥΠΟΛΗΣ" @if($settings->doy == 'ΗΛΙΟΥΠΟΛΗΣ') selected @endif>ΔΟΥ ΗΛΙΟΥΠΟΛΗΣ</option>
                                            <option value="ΚΑΛΛΙΘΕΑΣ" @if($settings->doy == 'ΚΑΛΛΙΘΕΑΣ') selected @endif>ΔΟΥ ΚΑΛΛΙΘΕΑΣ</option>
                                            <option value="ΚΗΦΙΣΙΑΣ" @if($settings->doy == 'ΚΗΦΙΣΙΑΣ') selected @endif>ΔΟΥ ΚΗΦΙΣΙΑΣ</option>
                                            <option value="ΜΟΣΧΑΤΟΥ" @if($settings->doy == 'ΜΟΣΧΑΤΟΥ') selected @endif>ΔΟΥ ΜΟΣΧΑΤΟΥ</option>
                                            <option value="Ν.ΙΩΝΙΑΣ" @if($settings->doy == 'Ν.ΙΩΝΙΑΣ') selected @endif>ΔΟΥ Ν.ΙΩΝΙΑΣ</option>
                                            <option value="Ν.ΣΜΥΡΝΗΣ" @if($settings->doy == 'Ν.ΣΜΥΡΝΗΣ') selected @endif>ΔΟΥ Ν.ΣΜΥΡΝΗΣ</option>
                                            <option value="Ν.ΗΡΑΚΛΕΙΟΥ" @if($settings->doy == 'Ν.ΗΡΑΚΛΕΙΟΥ') selected @endif>ΔΟΥ Ν.ΗΡΑΚΛΕΙΟΥ</option>
                                            <option value="ΠΑΛ. ΦΑΛΗΡΟΥ" @if($settings->doy == 'ΠΑΛ. ΦΑΛΗΡΟΥ') selected @endif>ΔΟΥ ΠΑΛ. ΦΑΛΗΡΟΥ</option>
                                            <option value="Α ΠΕΡΙΣΤΕΡΙΟΥ" @if($settings->doy == 'Α ΠΕΡΙΣΤΕΡΙΟΥ') selected @endif>ΔΟΥ Α' ΠΕΡΙΣΤΕΡΙΟΥ</option>
                                            <option value="Β ΠΕΡΙΣΤΕΡΙΟΥ" @if($settings->doy == 'Β ΠΕΡΙΣΤΕΡΙΟΥ') selected @endif>ΔΟΥ Β' ΠΕΡΙΣΤΕΡΙΟΥ</option>
                                            <option value="ΧΑΛΑΝΔΡΙΟΥ" @if($settings->doy == 'ΧΑΛΑΝΔΡΙΟΥ') selected @endif>ΔΟΥ ΧΑΛΑΝΔΡΙΟΥ</option>
                                            <option value="ΧΟΛΑΡΓΟΥ" @if($settings->doy == 'ΧΟΛΑΡΓΟΥ') selected @endif>ΔΟΥ ΧΟΛΑΡΓΟΥ</option>
                                            <option value="ΨΥΧΙΚΟΥ" @if($settings->doy == 'ΨΥΧΙΚΟΥ') selected @endif>ΔΟΥ ΨΥΧΙΚΟΥ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col s12 display-flex justify-content-end form-action">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
{{--                <div id="notifications">--}}
{{--                    <div class="card-panel">--}}
{{--                        <div class="row">--}}
{{--                            <h6 class="col s12 mb-2">Activity</h6>--}}
{{--                            <div class="col s12 mb-1">--}}
{{--                                <div class="switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" checked id="accountSwitch1">--}}
{{--                                        <span class="lever"></span>--}}
{{--                                    </label>--}}
{{--                                    <span class="switch-label w-100">Email me when someone comments on my article</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col s12 mb-1">--}}
{{--                                <div class="switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" checked id="accountSwitch2">--}}
{{--                                        <span class="lever"></span>--}}
{{--                                    </label>--}}
{{--                                    <span class="switch-label w-100">--}}
{{--                  Email me when someone answers on my form</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col s12 mb-1">--}}
{{--                                <div class="switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" id="accountSwitch3">--}}
{{--                                        <span class="lever"></span>--}}
{{--                                    </label>--}}
{{--                                    <span class="switch-label w-100">--}}
{{--                  Email me hen someone follows me</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <h6 class="col s12 mb-2 mt-2">Application</h6>--}}
{{--                            <div class="col s12 mb-1">--}}
{{--                                <div class="switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" checked id="accountSwitch4">--}}
{{--                                        <span class="lever"></span>--}}
{{--                                    </label>--}}
{{--                                    <span class="switch-label w-100">News and announcements</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col s12 mb-1">--}}
{{--                                <div class="switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" id="accountSwitch5">--}}
{{--                                        <span class="lever"></span>--}}
{{--                                    </label>--}}
{{--                                    <span class="switch-label w-100">Weekly product updates</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col s12 mb-1">--}}
{{--                                <div class="switch">--}}
{{--                                    <label>--}}
{{--                                        <input type="checkbox" class="custom-control-input" checked id="accountSwitch6">--}}
{{--                                        <span class="lever"></span>--}}
{{--                                    </label>--}}
{{--                                    <span class="switch-label w-100">Weekly blog digest</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col s12 display-flex justify-content-end form-action mt-2">--}}
{{--                                <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div id="invoices">
                    <div class="card-panel">
                        <div class="row">
                            <form action="{{route('settings.update', ['form' => 'invoices'])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="display-flex">
                                    <div class="media">
                                        <img src="{{url('images/system/'.$settings->invoice_logo)}}" class="border-radius-4" alt="profile image"
                                             height="80" width="236">
                                    </div>
                                    <div class="media-body">
                                        <div class="general-action-btn">
                                            <div class="file-field input-field s12">
                                                <div class="btn">
                                                    <span>Λογότυπο Παραστατικών</span>
                                                    <input type="file" name="invoice_file" @if(isset($settings->invoice_logo))  value="{{old('file', $settings->invoice_logo)}}" @endif>
                                                </div>
                                                <div class="file-path-wrapper" style="opacity:0;">
                                                    <input class="file-path validate" name="invoice_logo" type="text" @if(isset($settings->invoice_logo))  value="{{old('file', $settings->invoice_logo)}}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 mt-1 clearfix"></div>
                                        <small>Επιτρέπονται JPG ή PNG με λευκό ή διάφανο background. Ιδανικές Διαστάσεις 235x80</small>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="display-flex">
                                    <div class="media">
                                        <img src="{{url('images/system/'.$settings->signature)}}" class="border-radius-4" alt="signature image"
                                             height="207" width="361">
                                    </div>
                                    <div class="media-body">
                                        <div class="general-action-btn">
                                            <div class="file-field input-field s12">
                                                <div class="btn">
                                                    <span>Σφραγίδα με υπογραφή</span>
                                                    <input type="file" name="signature_file" @if(isset($settings->signature))  value="{{old('file', $settings->signature)}}" @endif>
                                                </div>
                                                <div class="file-path-wrapper" style="opacity:0;">
                                                    <input class="file-path validate" name="signature" type="text" @if(isset($settings->signature))  value="{{old('file', $settings->signature)}}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 mt-1 clearfix"></div>
                                        <small>Επιτρέπονται JPG ή PNG με λευκό ή διάφανο background. Ιδανικές Διαστάσεις 361x207</small>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="col s12 display-flex justify-content-end form-action mt-2">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    <script src="{{asset('js/scripts/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/scripts/page-account-settings.js')}}"></script>
    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function(){
           $m('#openMydataInfo').on('click', function(){
              $m('.mydata-howto').removeClass('hide');
           });
        });
    </script>
@endsection
