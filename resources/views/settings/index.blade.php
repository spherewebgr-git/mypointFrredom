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
                                <i class="material-icons">settings</i>
                                <span>ΡΥΘΜΙΣΕΙΣ ΠΑΡΑΣΤΑΤΙΚΩΝ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#parastatika">
                                <i class="material-icons">library_books</i>
                                <span>ΕΙΔΗ ΠΑΡΑΣΤΑΤΙΚΩΝ</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#seires">
                                <i class="material-icons">import_export</i>
                                <span>ΣΕΙΡΕΣ ΠΑΡΑΣΤΑΤΙΚΩΝ</span>
                            </a>
                        </li>
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
                                @if(isset($settings['logo']))
                                <div class="media">
                                    <img src="{{url('images/system/'.$settings['logo'])}}" class="border-radius-4" alt="profile image"
                                         height="64" width="64">
                                </div>
                                @endif
                                <div class="media-body">
                                    <div class="general-action-btn">
                                        <div class="file-field input-field s12">
                                            <div class="btn">
                                                <span>Φωτογραφία / Λογότυπο</span>
                                                <input type="file" name="file" @if(isset($settings['logo']))  value="{{old('file', $settings['logo'])}}" @endif>
                                            </div>
                                            <div class="file-path-wrapper" style="opacity:0;">
                                                <input class="file-path validate" name="logo" type="text" @if(isset($settings['logo']))  value="{{old('file', $settings['logo'])}}" @endif>
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
                                        <input id="phone" name="phone" type="text" class="validate" @if(isset($settings['phone'])) value="{{$settings['phone']}}" @endif>
                                        <label for="phone">Τηλέφωνο</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <input id="mobile" name="mobile" type="text" class="validate" @if(isset($settings['mobile'])) value="{{$settings['mobile']}}" @endif>
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
                                        <input id="aade_user_id" name="aade_user_id" type="text" @if(isset($settings['aade_user_id'])) value="{{$settings['aade_user_id']}}" @endif>
                                        <label for="aade_user_id">ΑΑΔΕ User ID</label>
                                        <small class="errorTxt4"></small>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="ocp_apim_subscription_key" name="ocp_apim_subscription_key" type="text" @if(isset($settings['ocp_apim_subscription_key']))  value="{{$settings['ocp_apim_subscription_key']}}" @endif>
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

                <div id="info">
                    <div class="card-panel">
                        <form action="{{route('settings.update', ['form' => 'info'])}}" class="infovalidate" method="post">
                            @csrf
                            <div class="row">
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="company" type="text" name="company" @if(isset($settings['company'])) value="{{$settings['company']}}" @endif>
                                        <label for="company">Επωνυμία Επιχείρησης</label>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input id="company_title" name="title" type="text" @if(isset($settings['title'])) value="{{$settings['title']}}" @endif>
                                        <label for="company_title">Διακριτικός Τίτλος</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="business" name="business" type="text" @if(isset($settings['business'])) value="{{$settings['business']}}" @endif>
                                        <label for="business">Επάγγελμα</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="address" name="address" type="text" @if(isset($settings['address'])) value="{{$settings['address']}}" @endif>
                                        <label for="address">Διεύθυνση Έδρας (Όδος Αριθμός, ΤΚ, Περιοχή, Πόλη)</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="input-field">
                                        <input id="vat" name="vat" type="text" @if(isset($settings['vat']))  value="{{$settings['vat']}}" @endif>
                                        <label for="vat">Α.Φ.Μ.</label>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <label for="doy">ΔΟΥ</label>
                                    <div class="input-field" style="margin-top: -7px;">
                                        <select class="browser-default" id="doy" name="doy">
                                            <option value="" disabled selected>Επιλέξτε ΔΟΥ</option>
                                            <option value="Α ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'Α ΑΘΗΝΩΝ') selected @endif>ΔΟΥ Α' ΑΘΗΝΩΝ</option>
                                            <option value="Δ ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'Δ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ Δ' ΑΘΗΝΩΝ</option>
                                            <option value="ΣΤ ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'ΣΤ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΣΤ' ΑΘΗΝΩΝ</option>
                                            <option value="ΙΒ ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'ΙΒ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΒ' ΑΘΗΝΩΝ, Ζωγράφου</option>
                                            <option value="ΙΓ ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'ΙΓ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΓ' ΑΘΗΝΩΝ</option>
                                            <option value="ΙΔ ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'ΙΔ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΔ' ΑΘΗΝΩΝ</option>
                                            <option value="ΙΖ ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'ΙΖ ΑΘΗΝΩΝ') selected @endif>ΔΟΥ ΙΖ' ΑΘΗΝΩΝ</option>
                                            <option value="ΚΑΤΟΙΚΩΝ ΕΞΩΤΕΡΙΚΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΚΑΤΟΙΚΩΝ ΕΞΩΤΕΡΙΚΟΥ') selected @endif>ΔΟΥ ΚΑΤΟΙΚΩΝ ΕΞΩΤΕΡΙΚΟΥ</option>
                                            <option value="Φ.Α.Ε. ΑΘΗΝΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'Φ.Α.Ε. ΑΘΗΝΩΝ') selected @endif>ΔΟΥ Φ.Α.Ε. ΑΘΗΝΩΝ, Καλλιθέα</option>
                                            <option value="ΑΓΙΟΥ ΔΗΜΗΤΡΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΑΓΙΟΥ ΔΗΜΗΤΡΙΟΥ') selected @endif>ΔΟΥ ΑΓΙΟΥ ΔΗΜΗΤΡΙΟΥ</option>
                                            <option value="ΑΓΙΩΝ ΑΝΑΡΓΥΡΩΝ" @if(isset($settings['doy']) && $settings['doy'] == 'ΑΓΙΩΝ ΑΝΑΡΓΥΡΩΝ') selected @endif>ΔΟΥ ΑΓΙΩΝ ΑΝΑΡΓΥΡΩΝ</option>
                                            <option value="ΑΙΓΑΛΕΩ" @if(isset($settings['doy']) && $settings['doy'] == 'ΑΙΓΑΛΕΩ') selected @endif>ΔΟΥ ΑΙΓΑΛΕΩ</option>
                                            <option value="ΑΜΑΡΟΥΣΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΑΜΑΡΟΥΣΙΟΥ') selected @endif>ΔΟΥ ΑΜΑΡΟΥΣΙΟΥ</option>
                                            <option value="ΒΥΡΩΝΑ" @if(isset($settings['doy']) && $settings['doy'] == 'ΒΥΡΩΝΑ') selected @endif>ΔΟΥ ΒΥΡΩΝΑ</option>
                                            <option value="ΓΑΛΑΤΣΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΓΑΛΑΤΣΙΟΥ') selected @endif>ΔΟΥ ΓΑΛΑΤΣΙΟΥ</option>
                                            <option value="ΓΛΥΦΑΔΑΣ" @if(isset($settings['doy']) && $settings['doy'] == 'ΓΛΥΦΑΔΑΣ') selected @endif>ΔΟΥ ΓΛΥΦΑΔΑΣ</option>
                                            <option value="ΗΛΙΟΥΠΟΛΗΣ" @if(isset($settings['doy']) && $settings['doy'] == 'ΗΛΙΟΥΠΟΛΗΣ') selected @endif>ΔΟΥ ΗΛΙΟΥΠΟΛΗΣ</option>
                                            <option value="ΚΑΛΛΙΘΕΑΣ" @if(isset($settings['doy']) && $settings['doy'] == 'ΚΑΛΛΙΘΕΑΣ') selected @endif>ΔΟΥ ΚΑΛΛΙΘΕΑΣ</option>
                                            <option value="ΚΗΦΙΣΙΑΣ" @if(isset($settings['doy']) && $settings['doy'] == 'ΚΗΦΙΣΙΑΣ') selected @endif>ΔΟΥ ΚΗΦΙΣΙΑΣ</option>
                                            <option value="ΜΟΣΧΑΤΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΜΟΣΧΑΤΟΥ') selected @endif>ΔΟΥ ΜΟΣΧΑΤΟΥ</option>
                                            <option value="Ν.ΙΩΝΙΑΣ" @if(isset($settings['doy']) && $settings['doy'] == 'Ν.ΙΩΝΙΑΣ') selected @endif>ΔΟΥ Ν.ΙΩΝΙΑΣ</option>
                                            <option value="Ν.ΣΜΥΡΝΗΣ" @if(isset($settings['doy']) && $settings['doy'] == 'Ν.ΣΜΥΡΝΗΣ') selected @endif>ΔΟΥ Ν.ΣΜΥΡΝΗΣ</option>
                                            <option value="Ν.ΗΡΑΚΛΕΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'Ν.ΗΡΑΚΛΕΙΟΥ') selected @endif>ΔΟΥ Ν.ΗΡΑΚΛΕΙΟΥ</option>
                                            <option value="ΝΙΚΑΙΑΣ" @if(isset($settings['doy']) && $settings['doy'] == 'ΝΙΚΑΙΑΣ') selected @endif>ΔΟΥ ΝΙΚΑΙΑΣ</option>
                                            <option value="ΠΑΛ. ΦΑΛΗΡΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΠΑΛ. ΦΑΛΗΡΟΥ') selected @endif>ΔΟΥ ΠΑΛ. ΦΑΛΗΡΟΥ</option>
                                            <option value="Α ΠΕΡΙΣΤΕΡΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'Α ΠΕΡΙΣΤΕΡΙΟΥ') selected @endif>ΔΟΥ Α' ΠΕΡΙΣΤΕΡΙΟΥ</option>
                                            <option value="Β ΠΕΡΙΣΤΕΡΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'Β ΠΕΡΙΣΤΕΡΙΟΥ') selected @endif>ΔΟΥ Β' ΠΕΡΙΣΤΕΡΙΟΥ</option>
                                            <option value="ΧΑΛΑΝΔΡΙΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΧΑΛΑΝΔΡΙΟΥ') selected @endif>ΔΟΥ ΧΑΛΑΝΔΡΙΟΥ</option>
                                            <option value="ΧΟΛΑΡΓΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΧΟΛΑΡΓΟΥ') selected @endif>ΔΟΥ ΧΟΛΑΡΓΟΥ</option>
                                            <option value="ΨΥΧΙΚΟΥ" @if(isset($settings['doy']) && $settings['doy'] == 'ΨΥΧΙΚΟΥ') selected @endif>ΔΟΥ ΨΥΧΙΚΟΥ</option>
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

                <div id="invoices">
                    <div class="card-panel">
                        <div class="row">
                            <form action="{{route('settings.update', ['form' => 'invoices'])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="display-flex">
                                    @if(isset($settings['invoice_logo']) && $settings['invoice_logo'] != NULL)
                                    <div class="media">
                                        <img src="{{url('images/system/'.$settings->invoice_logo)}}" class="border-radius-4" alt="profile image"
                                             height="80" width="236">
                                    </div>
                                    @endif
                                    <div class="media-body">
                                        <div class="general-action-btn">
                                            <div class="file-field input-field s12">
                                                <div class="btn">
                                                    <span>Λογότυπο Παραστατικών</span>
                                                    <input type="file" name="invoice_file" @if(isset($settings['invoice_logo']))  value="{{old('file', $settings['invoice_logo'])}}" @endif>
                                                </div>
                                                <div class="file-path-wrapper" style="opacity:0;">
                                                    <input class="file-path validate" name="invoice_logo" type="text" @if(isset($settings['invoice_logo']))  value="{{old('file', $settings['invoice_logo'])}}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 mt-1 clearfix"></div>
                                        <small>Επιτρέπονται JPG ή PNG με λευκό ή διάφανο background. Ιδανικές Διαστάσεις 235x80</small>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="display-flex">
                                    @if(isset($settings['signature']))
                                    <div class="media">
                                        <img src="{{url('images/system/'.$settings['signature'])}}" class="border-radius-4" alt="signature image"
                                             height="207" width="361">
                                    </div>
                                    @endif
                                    <div class="media-body">
                                        <div class="general-action-btn">
                                            <div class="file-field input-field s12">
                                                <div class="btn">
                                                    <span>Σφραγίδα με υπογραφή</span>
                                                    <input type="file" name="signature_file" @if(isset($settings['signature'])) value="{{old('file', $settings['signature'])}}" @endif>
                                                </div>
                                                <div class="file-path-wrapper" style="opacity:0;">
                                                    <input class="file-path validate" name="signature" type="text" @if(isset($settings['signature']))  value="{{old('file', $settings['signature'])}}" @endif>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1 mt-1 clearfix"></div>
                                        <small>Επιτρέπονται JPG ή PNG με λευκό ή διάφανο background. Ιδανικές Διαστάσεις 361x207</small>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Ρυθμίσεις τιμολογίου</h4>
                                <div class="divider"></div>
                                <div class="col s12 input-field">
                                    <div class="switch">
                                        <label>Εμφάνιαη διεύθυνσης e-mail στα παρααστατικά
                                            <input type="checkbox">
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col s12 input-field">
                                    <div class="switch">
                                        <label>Εμφάνιση λογοτύπου στα παρααστατικά
                                            <input type="checkbox">
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="seires">
                    <div class="card-panel">

                        <div class="row">
                            <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Σειρές Παραστατικών</h4>
                            <div class="divider"></div>
                            @if(isset($settings['invoices']) && $settings['invoices'] == 'on')
                            <div class="col s12 m6">
                                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Σειρές Τιμολογίων Παροχής</h4>
                                <ul class="collection">
                                    @foreach($seires['invoices'] as $invoiceType)
                                        <li class="collection-item">{{$invoiceType['letter']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(isset($settings['retails']) && $settings['retails'] == 'on')
                            <div class="col s12 m6">
                                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Σειρές Αποδείξεων Λιανικής</h4>
                                <ul class="collection">
                                    @foreach($seires['retails'] as $retailType)
                                        <li class="collection-item">{{$retailType['letter']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(isset($settings['sale_invoices']) && $settings['sale_invoices'] == 'on')
                            <div class="col s12 m6">
                                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Σειρές Τιμολογίων Πώλησης</h4>
                                <ul class="collection">
                                    @foreach($seires['sale_invoices'] as $invoiceType)
                                        <li class="collection-item">{{$invoiceType['letter']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if(isset($settings['delivery_notes']) && $settings['delivery_notes'] == 'on')
                            <div class="col s12 m6">
                                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Σειρές Δελτίων Αποστολής</h4>
                                <ul class="collection">
                                    @foreach($seires['delivery_notes'] as $deliveryType)
                                        <li class="collection-item">{{$deliveryType['letter']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="clearfix"></div>
                            <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px; display: inline-block">Προσθήκη νέας σειράς</h4>
                            <div class="divider mb-2"></div>
                            <form action="{{route('settings.update', ['form' => 'seires'])}}" class="infovalidate" method="post">
                                @csrf
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <select name="seiraType" id="seiraType">
                                            <option value="invoices">Τιμολόγια Παροχής Υπηρεσιών</option>
                                            <option value="sale_invoices">Τιμολόγια Πώλησης</option>
                                            <option value="delivery_notes">Δελτία Αποστολής</option>
                                            <option value="retails">Αποδείξεις Λιανικής</option>
                                        </select>
                                        <label for="seiraType">Είδος Παραστατικού</label>
                                    </div>
                                </div>
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input type="text" name="seira" id="seira">
                                        <label for="seira">Νέα Σειρά Παραστατικού</label>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end form-action mt-2">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="parastatika">
                    <div class="card-panel">
                        <div class="row">
                            <form action="{{route('settings.update', ['form' => 'parastatika'])}}" method="post">
                                @csrf
                                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Είδη Παραστατικών</h4>
                                <div class="divider"></div>
                                <p style="padding-left: 15px;">Επιλέξτε τα είδη των παραστατικά που εκδίδετε</p>
                                <div class="col s12 m6 input-field">
                                    <div class="switch">
                                        <label for="sale_invoices">ΤΙΜΟΛΟΓΙΑ ΠΩΛΗΣΗΣ
                                            <input type="checkbox" id="sale_invoices" name="sale_invoices" @if(isset($settings['sale_invoices']) && $settings['sale_invoices'] == 'on') checked @endif>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <div class="switch">
                                        <label for="delivery_notes">ΔΕΛΤΙΑ ΑΠΟΣΤΟΛΗΣ
                                            <input type="checkbox" id="delivery_notes" name="delivery_notes" @if(isset($settings['delivery_notes']) && $settings['delivery_notes'] == 'on') checked @endif>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <div class="switch">
                                        <label for="service_invoices">ΤΙΜΟΛΟΓΙΑ ΠΑΡΟΧΗΣ ΥΠΗΡΕΣΙΩΝ
                                            <input type="checkbox" id="service_invoices" name="invoices" @if(isset($settings['invoices']) && $settings['invoices'] == 'on') checked @endif>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col s12 m6 input-field">
                                    <div class="switch">
                                        <label for="retails">ΑΠΟΔΕΙΞΕΙΣ ΛΙΑΝΙΚΗΣ
                                            <input type="checkbox" id="retails" name="retails" @if(isset($settings['retails']) && $settings['retails'] == 'on') checked @endif>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </div>
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
           $m('input[type="checkbox"]').on('click', function(){
               let dataName = $m(this).attr('name');
              if(!$m(this).is(':checked')){
                  $m('<input type="hidden" name="'+dataName+'" value="off" />').insertAfter(this);
              }
           });
        });
    </script>
@endsection
