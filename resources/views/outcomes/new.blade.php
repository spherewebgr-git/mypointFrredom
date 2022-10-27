{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if(isset($outcome->outcome_number))
    @section('title', 'Επεξεργασία παραστατικού εξόδων')
@else
    @section('title', 'Καταχώρηση νέου παραστατικού εξόδων')
@endif
{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')

    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Καταχώρηση νέου παραστατικού εξόδων</span></h5>
                </div>
            </div>
        </div>
    </div>
    <form
        @if(isset($outcome->outcome_number)) action="{{route('outcome.update', ['outcome' => $outcome->hashID])}}"
        @else action="{{route('outcome.store')}}" @endif method="post" enctype="multipart/form-data">
        @csrf
        <div class="col s12 m12 l12">
            <div id="prefixes" class="card card card-default scrollspy">
                <div class="card-content">
                    <h4 class="card-title">Στοιχεία Παραστατικού</h4>
                    @if(count($providers) == 0)
                        <div
                            class="alert-warning red-text display-flex align-items-center center-align flex-wrap mt-2 mb-2 justify-content-center">
                            <strong class="col s12 align-items-center display-flex justify-content-center"><i
                                    class="material-icons prefix">warning</i> Δεν υπάρχουν διαθέσιμοι
                                προμηθευτές.</strong><br/> Θα πρέπει να καταχωρήσετε πρώτα κάποιον προμηθευτή για να
                            μπορέσετε να καταχωρήσετε παραστατικά εξόδων.
                        </div>@endif

                        <div class="row">
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="outcome_number" type="text" name="outcome_number"
                                       @if(isset($outcome->outcome_number))value="{{old('outcome_number', $outcome->outcome_number)}}"
                                       @endif required>
                                <label for="outcome_number" class="">Αριθμός Παραστατικού *</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">local_grocery_store</i>
                                <select name="invType" id="invType">
                                    <option value="" disabled selected>Επιλέξτε Τύπο Παραστατικού</option>
                                    <option value="1" disabled>Τιμολόγια Πώλησης</option>
                                    <option value="1.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '1.1') selected @endif>
                                        Τιμολόγιο Πώλησης
                                    </option>
                                    <option value="1.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '1.2') selected @endif>
                                        Τιμολόγιο Πώλησης / Ενδοκοινοτικές Παραδόσεις
                                    </option>
                                    <option value="1.3"
                                            @if(isset($outcome->invType) && $outcome->invType == '1.3') selected @endif>
                                        Τιμολόγιο Πώλησης / Παραδόσεις Τρίτων Χωρών
                                    </option>
                                    <option value="1.4"
                                            @if(isset($outcome->invType) && $outcome->invType == '1.4') selected @endif>
                                        Τιμολόγιο Πώλησης / Για Λογαριασμό Τρίτων
                                    </option>
                                    <option value="2" disabled>Τιμολόγια Παροχής Υπηρεσιών</option>
                                    <option value="2.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '2.1') selected @endif>
                                        Τιμολόγια Παροχής
                                    </option>
                                    <option value="2.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '2.2') selected @endif>
                                        Τιμολόγιο Παροχής / Ενδοκοινοτική Παροχή Υπηρεσιών
                                    </option>
                                    <option value="2.3"
                                            @if(isset($outcome->invType) && $outcome->invType == '2.3') selected @endif>
                                        Τιμολόγιο Παροχής / Παροχή Υπηρεσιών Τρίτων Χωρών
                                    </option>
                                    <option value="2.4"
                                            @if(isset($outcome->invType) && $outcome->invType == '2.4') selected @endif>
                                        Τιμολόγιο Παροχής / Συμπληρωματικό Παραστατικό
                                    </option>
                                    <option value="3" disabled>Τίτλοι Κτήσης</option>
                                    <option value="3.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '3.1') selected @endif>
                                        Τίτλος Κτήσης (μη υπόχρεος Εκδότης)
                                    </option>
                                    <option value="3.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '3.2') selected @endif>
                                        Τίτλος Κτήσης (άρνηση έκδοσης από υπόχρεο Εκδότη)
                                    </option>
                                    <option value="5" disabled>Πιστωτικά Τιμολόγια</option>
                                    <option value="5.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '5.1') selected @endif>
                                        Πιστωτικό Τιμολόγιο / Συσχετιζόμενο
                                    </option>
                                    <option value="5.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '5.2') selected @endif>
                                        Πιστωτικό Τιμολόγιο / Μη Συσχετιζόμενο
                                    </option>
                                    <option value="6" disabled>Στοιχεία Αυτοπαράδοσης - Ιδιοχρησιμοποίησης</option>
                                    <option value="6.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '6.1') selected @endif>
                                        Στοιχείο Αυτοπαράδοσης
                                    </option>
                                    <option value="6.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '6.2') selected @endif>
                                        Στοιχείο Ιδιοχρησιμοποίησης
                                    </option>
                                    <option value="7" disabled>Συμβόλαια - Έσοδα</option>
                                    <option value="7.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '7.1') selected @endif>
                                        Συμβόλαιο - Έσοδο
                                    </option>
                                    <option value="8" disabled>Αποδείξεις Είσπραξης</option>
                                    <option value="8.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '8.1') selected @endif>
                                        Αποδείξη Είσπραξης
                                    </option>
                                    <option value="8.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '8.2') selected @endif>
                                        Αποδείξη Είσπραξης Φόρου Διαμονής
                                    </option>
                                    <option disabled>Άλλα</option>
                                    <option value="13.3"
                                            @if(isset($outcome->invType) && $outcome->invType == '13.3') selected @endif>
                                        Κοινόχρηστα
                                    </option>
                                    <option value="13.4"
                                            @if(isset($outcome->invType) && $outcome->invType == '13.4') selected @endif>
                                        Συνδρομές
                                    </option>
                                    <option value="14.5"
                                            @if(isset($outcome->invType) && $outcome->invType == '14.5') selected @endif>
                                        ΕΦΚΑ και Λοιποί Ασφαλιστικοί Οργανισμοί
                                    </option>
                                    <option value="17.1"
                                            @if(isset($outcome->invType) && $outcome->invType == '17.1') selected @endif>
                                        Μισθοδοσία
                                    </option>
                                    <option value="17.2"
                                            @if(isset($outcome->invType) && $outcome->invType == '17.1') selected @endif>
                                        Αποσβέσεις
                                    </option>
                                </select>
                                <label for="invType" class="">Τύπος Παραστατικού *</label>
                            </div>
                            <div class="invoice-date-picker align-items-center col m4">
                                <div class="">
                                    <small>Ημ/νία Έκδοσης: </small>
                                    <div class="display-flex" style="margin-top: -6px;">
                                        <input type="text" class="datepicker" name="date" placeholder="Επιλέξτε Ημ/νία"
                                               @if(isset($outcome->date)) value="{{old('date', $outcome->date)}}"
                                               @else value="{{date('Y-m-d')}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m5">
                                <i class="material-icons prefix">local_grocery_store</i>
                                <select name="shop" id="shop">
                                    <option value="" disabled selected>@if(count($providers) > 0)Επιλέξτε Προμηθευτή@elseΔεν
                                        υπάρχουν διαθέσιμοι προμηθευτές@endif</option>
                                    @foreach($providers as $provider)
                                        <option value="{{old('provider_vat', $provider->provider_vat)}}"
                                                @if(isset($outcome->shop) && $provider->provider_vat == $outcome->shop) selected @endif>@if($provider->provider_name){{$provider->provider_name}}@endif</option>
                                    @endforeach
                                </select>
                                {{--                            <input id="shop" type="text" name="shop" @if(isset($outcome->shop)) value="{{old('shop', $outcome->shop)}}" @endif required>--}}
                                <label for="shop" class="">Προμηθευτής</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">euro_symbol</i>
                                <input id="price" type="text" name="price"
                                       @if(isset($outcome->price)) value="{{old('price', $outcome->price)}}"
                                       @endif required>
                                <label for="price" class="">Ποσό *</label>
                            </div>
                            <div class="input-field col s12 m3">
                                <i class="material-icons prefix">label</i>
                                <input id="vat" type="text" name="vat"
                                       @if(isset($outcome->vat))  value="{{old('vat', $outcome->vat)}}" @endif required>
                                <label for="vat" class="">Φ.Π.Α. *</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="file-field input-field s12">
                                <div class="btn">
                                    <span>Αρχείο</span>
                                    <input type="file" name="file"
                                           @if(isset($outcome->file))  value="{{old('file', $outcome->file)}}" @endif>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text"
                                           @if(isset($outcome->file))  value="{{old('file', $outcome->file)}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" type="submit"
                                            name="action">@if(isset($outcome->outcome_number)) Ενημέρωση @else
                                            Καταχώρηση @endif
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </form>
    @if(isset($outcome->invType))
    <div class="col s12 m9" id="classifications">
        <div class="card">
            <div class="card-content">
                <h4 class="card-title">Χαρακτηρισμοί Εξόδων</h4>
                <div class="invoice-product-details mb-3">
                    <form class="form invoice-item-repeater" @if(count($classifications) > 0) action="{{route('outcome.classifications.update', ['outcome' => $outcome->hashID])}}"  @else action="{{route('outcome.classifications', ['outcome' => $outcome->hashID])}}"  @endif method="post">
                        @csrf
                        <div data-repeater-list="group-a">
                            <!-- Classifications Repeater Items-->
                            @foreach($classifications as $key => $classification)
                                <div class="classification-item mb-2 @if($classification->mark != null) marked disabled @endif" data-line="{{$key}}">
                                    <input type="hidden" class="old-hash" name="old[{{$key}}][classificationHash]" value="{{$classification->hashID}}">
                                    <div class="row mb-1">
                                        <div class="col s4"><h6 class="m-0">Γραμμή Χαρακτηρισμού</h6></div>
                                        <div class="col s4"></div>
                                        <div class="col s2"></div>
                                        <div class="col s2"><h6 class="m-0">Καθαρό Ποσό</h6></div>
                                    </div>
                                    <div class="invoice-item display-flex mb-1 row justify-content-between">
                                        <div class="invoice-item-filed row pt-1" style="width: 95%;">
                                            <div class="col s12 m4 input-field">
                                                <select id="classification_category" name="old[{{$key}}][classification_category]" class="invoice-item-select browser-default select-wrapper">
                                                    <option value="" disabled="">Επιλέξτε Κατηγορία</option>
                                                    <option value="category2_1" @if($classification->classification_category == 'category2_1') selected @endif>Αγορές Εμπορευμάτων</option>
                                                    <option value="category2_2" @if($classification->classification_category == 'category2_2') selected @endif>Αγορές Α'-Β' Υλών</option>
                                                    <option value="category2_3" @if($classification->classification_category == 'category2_3') selected @endif>Λήψη Υπηρεσιών</option>
                                                    <option value="category2_4" @if($classification->classification_category == 'category2_4') selected @endif>Γενικά Έξοδα με δικαίωμα έκπτωσης ΦΠΑ</option>
                                                    <option value="category2_5" @if($classification->classification_category == 'category2_5') selected @endif>Γενικά Έξοδα χωρίς δικαίωμα έκπτωσης ΦΠΑ</option>
                                                    <option value="category2_6" @if($classification->classification_category == 'category2_6') selected @endif>Αμοιβές και Παροχές προσωπικού</option>
                                                    <option value="category2_7" @if($classification->classification_category == 'category2_7') selected @endif>Αγορές Παγίων</option>
                                                    <option value="category2_8" @if($classification->classification_category == 'category2_8') selected @endif>Αποσβέσεις Παγίων</option>
                                                    <option value="category2_9" @if($classification->classification_category == 'category2_9') selected @endif>Έξοδα για λ/σμο τρίτων</option>
                                                    <option value="category2_10" @if($classification->classification_category == 'category2_10') selected @endif>Έξοδα προηγούμενων χρήσεων</option>
                                                    <option value="category2_11" @if($classification->classification_category == 'category2_11') selected @endif>Έξοδα επομένων χρήσεων</option>
                                                    <option value="category2_12" @if($classification->classification_category == 'category2_12') selected @endif>Λοιπές Εγγραφές Τακτοποίησης Εξόδων</option>
                                                    <option value="category2_13" @if($classification->classification_category == 'category2_13') selected @endif>Αποθέματα Έναρξης Περιόδου (Ε3 προηγ. Περιόδου)</option>
                                                    <option value="category2_14" @if($classification->classification_category == 'category2_14') selected @endif>Αποθέματα Λήξης Περιόδου (Ε3 τρέχουσας Περιόδου)</option>
                                                    <option value="category2_95" @if($classification->classification_category == 'category2_95') selected @endif>Λοιπά Πληροφοριακά Στοιχεία Εξόδων</option>
                                                </select>
                                                <label for="classification_category">Κατηγορία</label>
                                            </div>
                                            <div class="col s12 m4 input-field">
                                                <select id="classification_type" name="old[{{$key}}][classification_type]" class="browser-default select-wrapper">
                                                    <option value="" disabled="">Επιλέξτε Είδος</option>
                                                    <option value="E3_101" @if($classification->classification_type == 'E3_101') selected @endif>Εμπορεύματα έναρξης [Ε3_101]</option>
                                                    <option value="E3_102_001" @if($classification->classification_type == 'E3_102_001') selected @endif>Αγορές εμπορευμάτων χρήσης (καθ.ποσό) Χονδρικές [Ε3_102_001]</option>
                                                    <option value="E3_102_002" @if($classification->classification_type == 'E3_102_002') selected @endif>Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Λιανικές [Ε3_102_002]</option>
                                                    <option value="E3_102_003" @if($classification->classification_type == 'E3_102_003') selected @endif>Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Αγαθών του άρθρου 39α παρ.5 του Κώδικα Φ.Π.Α. (ν.2859/2000) [Ε3_102_003]</option>
                                                    <option value="E3_102_004" @if($classification->classification_type == 'E3_102_004') selected @endif>Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Εξωτερικού Ενδοκοινοτικές [Ε3_102_004]</option>
                                                    <option value="E3_102_005" @if($classification->classification_type == 'E3_102_005') selected @endif>Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Εξωτερικού Τρίτες Χώρες [Ε3_102_005]</option>
                                                    <option value="E3_102_006" @if($classification->classification_type == 'E3_102_006') selected @endif>Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)Λοιπά [Ε3_102_006]</option>
                                                    <option value="E3_104" @if($classification->classification_type == 'E3_104') selected @endif>Εμπορεύματα λήξης [Ε3_104]</option>
                                                    <option value="E3_201" @if($classification->classification_type == 'E3_201') selected @endif>Πρώτες ύλες και υλικά έναρξης/Παραγωγή [Ε3_201]</option>
                                                    <option value="E3_202_001" @if($classification->classification_type == 'E3_202_001') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Χονδρικές [Ε3_202_001]</option>
                                                    <option value="E3_202_002" @if($classification->classification_type == 'E3_202_002') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λιανικές [Ε3_202_002]</option>
                                                    <option value="E3_202_003" @if($classification->classification_type == 'E3_202_003') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Ενδοκοινοτικές [Ε3_202_003]</option>
                                                    <option value="E3_202_004" @if($classification->classification_type == 'E3_202_004') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Τρίτες Χώρες [Ε3_202_004]</option>
                                                    <option value="E3_202_005" @if($classification->classification_type == 'E3_202_005') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λοιπά [Ε3_202_005]</option>
                                                    <option value="E3_204" @if($classification->classification_type == 'E3_204') selected @endif> Αποθέματα λήξης πρώτων υλών και υλικών/Παραγωγή [E3_204]</option>
                                                    <option value="E3_207" @if($classification->classification_type == 'E3_207') selected @endif> Προϊόντα και παραγωγή σε εξέλιξη έναρξης/Παραγωγή [Ε3_207]</option>
                                                    <option value="E3_209" @if($classification->classification_type == 'E3_209') selected @endif> Προϊόντα και παραγωγή σε εξέλιξη λήξης/Παραγωγή [Ε3_209]</option>
                                                    <option value="E3_301" @if($classification->classification_type == 'E3_301') selected @endif> Πρώτες ύλες και υλικά έναρξης/Αγροτική [Ε3_301]</option>
                                                    <option value="E3_302_001" @if($classification->classification_type == 'E3_302_001') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Χονδρικές [Ε3_302_001]</option>
                                                    <option value="E3_302_002" @if($classification->classification_type == 'E3_302_002') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λιανικές [Ε3_302_002]</option>
                                                    <option value="E3_302_003" @if($classification->classification_type == 'E3_302_003') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Ενδοκοινοτικές [Ε3_302_003]</option>
                                                    <option value="E3_302_004" @if($classification->classification_type == 'E3_302_004') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Τρίτες Χώρες [Ε3_302_004]</option>
                                                    <option value="E3_302_005" @if($classification->classification_type == 'E3_302_005') selected @endif> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λοιπά [Ε3_302_005]</option>
                                                    <option value="E3_581_001" @if($classification->classification_type == 'E3_581_001') selected @endif>Παροχές σε εργαζόμενους/Μικτές αποδοχές [Ε3_581_001]</option>
                                                    <option value="E3_581_002" @if($classification->classification_type == 'E3_581_002') selected @endif>Παροχές σε εργαζόμενους/Εργοδοτικές εισφορές [Ε3_581_002]</option>
                                                    <option value="E3_581_003" @if($classification->classification_type == 'E3_581_003') selected @endif>Παροχές σε εργαζόμενους/Λοιπές παροχές [Ε3_581_003]</option>
                                                    <option value="E3_582" @if($classification->classification_type == 'E3_582') selected @endif> Ζημιές επιμέτρησης περιουσιακών στοιχείων [E3_582]</option>
                                                    <option value="E3_583" @if($classification->classification_type == 'E3_583') selected @endif> Χρεωστικές συναλλαγματικές διαφορές [E3_583]</option>
                                                    <option value="E3_584" @if($classification->classification_type == 'E3_584') selected @endif> Ζημιές από διάθεση-απόσυρση μη κυκλοφορούντων περιουσιακών στοιχείων [E3_584]</option>
                                                    <option value="E3_585_001" @if($classification->classification_type == 'E3_585_001') selected @endif>Προμήθειες διαχείρισης ημεδαπής - αλλοδαπής (management fees) [Ε3_585_001]</option>
                                                    <option value="E3_585_002" @if($classification->classification_type == 'E3_585_002') selected @endif>Δαπάνες από συνδεδεμένες επιχειρήσεις [Ε3_585_002]</option>
                                                    <option value="E3_585_003" @if($classification->classification_type == 'E3_585_003') selected @endif>Δαπάνες από μη συνεργαζόμενα κράτη ή από κράτη με προνομιακό φορολογικό καθεστώς [Ε3_585_003]</option>
                                                    <option value="E3_585_004" @if($classification->classification_type == 'E3_585_004') selected @endif>Δαπάνες για ενημερωτικές ημερίδες [Ε3_585_004]</option>
                                                    <option value="E3_585_005" @if($classification->classification_type == 'E3_585_005') selected @endif>Έξοδα υποδοχής και φιλοξενίας [Ε3_585_005]</option>
                                                    <option value="E3_585_006" @if($classification->classification_type == 'E3_585_006') selected @endif>Έξοδα ταξιδιών [Ε3_585_006]</option>
                                                    <option value="E3_585_007" @if($classification->classification_type == 'E3_585_007') selected @endif>Ασφαλιστικές Εισφορές Αυτοαπασχολούμενων [Ε3_585_007]</option>
                                                    <option value="E3_585_008" @if($classification->classification_type == 'E3_585_008') selected @endif>Έξοδα και προμήθειες παραγγελιοδόχου για λογαριασμό αγροτών [Ε3_585_008]</option>
                                                    <option value="E3_585_009" @if($classification->classification_type == 'E3_585_009') selected @endif>Λοιπές Αμοιβές για υπηρεσίες ημεδαπής [Ε3_585_009]</option>
                                                    <option value="E3_585_010" @if($classification->classification_type == 'E3_585_010') selected @endif>Λοιπές Αμοιβές για υπηρεσίες αλλοδαπής [Ε3_585_010]</option>
                                                    <option value="E3_585_011" @if($classification->classification_type == 'E3_585_011') selected @endif>Ενέργεια [Ε3_585_011]</option>
                                                    <option value="E3_585_012" @if($classification->classification_type == 'E3_585_012') selected @endif>Ύδρευση [Ε3_585_012]</option>
                                                    <option value="E3_585_013" @if($classification->classification_type == 'E3_585_013') selected @endif>Τηλεπικοινωνίες [Ε3_585_013]</option>
                                                    <option value="E3_585_014" @if($classification->classification_type == 'E3_585_014') selected @endif>Ενοίκια [Ε3_585_014]</option>
                                                    <option value="E3_585_015" @if($classification->classification_type == 'E3_585_015') selected @endif>Διαφήμιση και προβολή [Ε3_585_015]</option>
                                                    <option value="E3_585_016" @if($classification->classification_type == 'E3_585_016') selected @endif>Λοιπά έξοδα [Ε3_585_016]</option>
                                                    <option value="E3_586" @if($classification->classification_type == 'E3_586') selected @endif>Χρεωστικοί τόκοι και συναφή έξοδα [Ε3_586]</option>
                                                    <option value="E3_587" @if($classification->classification_type == 'E3_587') selected @endif>Αποσβέσεις [Ε3_587]</option>
                                                    <option value="E3_588" @if($classification->classification_type == 'E3_588') selected @endif>Ασυνήθη έξοδα, ζημιές και πρόστιμα [Ε3_588]</option>
                                                    <option value="E3_589" @if($classification->classification_type == 'E3_589') selected @endif>Προβλέψεις (εκτός από προβλέψεις για το προσωπικό) [Ε3_589]</option>
                                                    <option value="E3_881_001" @if($classification->classification_type == 'E3_881_001') selected @endif>Πωλήσεις για λογ/σμο Τρίτων Χονδρικές [E3_881_001]</option>
                                                    <option value="E3_881_002" @if($classification->classification_type == 'E3_881_002') selected @endif>Πωλήσεις για λογ/σμο Τρίτων Λιανικές [E3_881_002]</option>
                                                    <option value="E3_881_003" @if($classification->classification_type == 'E3_881_003') selected @endif>Πωλήσεις για λογ/σμο Τρίτων Εξωτερικού Ενδοκοινοτικές [E3_881_003]</option>
                                                    <option value="E3_881_004" @if($classification->classification_type == 'E3_881_004') selected @endif>Πωλήσεις για λογ/σμο Τρίτων Εξωτερικού Τρίτες Χώρες [E3_881_004]</option>
                                                    <option value="E3_882_001" @if($classification->classification_type == 'E3_882_001') selected @endif>Αγορές ενσώματων παγίων χρήσης/Χονδρικές [Ε3_882_001]</option>
                                                    <option value="E3_882_002" @if($classification->classification_type == 'E3_882_002') selected @endif>Αγορές ενσώματων παγίων χρήσης/Λιανικές [Ε3_882_002]</option>
                                                    <option value="E3_882_003" @if($classification->classification_type == 'E3_882_003') selected @endif>Αγορές ενσώματων παγίων χρήσης/Εξωτερικού Ενδοκοινοτικές [Ε3_882_003]</option>
                                                    <option value="E3_882_004" @if($classification->classification_type == 'E3_882_004') selected @endif>Αγορές ενσώματων παγίων χρήσης/Εξωτερικού Τρίτες Χώρες [Ε3_882_004]</option>
                                                    <option value="E3_883_001" @if($classification->classification_type == 'E3_883_001') selected @endif>Αγορές μη ενσώματων παγίων χρήσης/Χονδρικές [Ε3_883_001]</option>
                                                    <option value="E3_883_002" @if($classification->classification_type == 'E3_883_002') selected @endif>Αγορές μη ενσώματων παγίων χρήσης/Λιανικές [Ε3_883_002]</option>
                                                    <option value="E3_883_003" @if($classification->classification_type == 'E3_883_003') selected @endif>Αγορές μη ενσώματων παγίων χρήσης/Εξωτερικού Ενδοκοινοτικές [Ε3_883_003]</option>
                                                    <option value="E3_883_004" @if($classification->classification_type == 'E3_883_004') selected @endif>Αγορές μη ενσώματων παγίων χρήσης/Εξωτερικού Τρίτες Χώρες [Ε3_883_004]</option>
                                                    <option value="VAT_361" @if($classification->classification_type == 'VAT_361') selected @endif>Αγορές & δαπάνες στο εσωτερικό της χώρας [VAT_361]</option>
                                                    <option value="VAT_362" @if($classification->classification_type == 'VAT_362') selected @endif>Αγορές & εισαγωγές επενδ. Αγαθών (πάγια) [VAT_362]</option>
                                                    <option value="VAT_363" @if($classification->classification_type == 'VAT_363') selected @endif>Λοιπές εισαγωγές εκτός επενδ. Αγαθών (πάγια) [VAT_363]</option>
                                                    <option value="VAT_364" @if($classification->classification_type == 'VAT_364') selected @endif>Ενδοκοινοτικές αποκτήσεις αγαθών [VAT_364]</option>
                                                    <option value="VAT_365" @if($classification->classification_type == 'VAT_365') selected @endif>Ενδοκοινοτικές λήψεις υπηρεσιών άρθρ. 14.2.α [VAT_365]</option>
                                                    <option value="VAT_366" @if($classification->classification_type == 'VAT_366') selected @endif>Λοιπές πράξεις λήπτη [VAT_366]</option>
                                                </select>
                                                <label for="classification_type">Είδος</label>
                                            </div>
                                            <div class="col s2 input-field c-tax">
                                                <select id="tax" name="old[{{$key}}][tax]" class="invoice-tax browser-default select-wrapper">
                                                    <option value="" disabled="">ΦΠΑ</option>
                                                    <option value="1" @if($classification->vat == '1') selected @endif>24%</option>
                                                    <option value="4" @if($classification->vat == '4') selected @endif>17%</option>
                                                    <option value="2" @if($classification->vat == '2') selected @endif>13%</option>
                                                    <option value="5" @if($classification->vat == '5') selected @endif>9%</option>
                                                    <option value="3" @if($classification->vat == '3') selected @endif>6%</option>
                                                    <option value="6" @if($classification->vat == '6') selected @endif>4%</option>
                                                    <option value="7" @if($classification->vat == '7') selected @endif>0%</option>
                                                    <option value="8" @if($classification->vat == '8') selected @endif>-</option>
                                                </select>
                                                <label for="tax">Συντελεστής ΦΠΑ</label>
                                            </div>
                                            <div class="col m2 s12 input-field c-price">
                                                <input type="text" class="classification-price"  placeholder="0.00" name="old[{{$key}}][price]" value="{{$classification->price}}">
{{--                                                <label for="price">Ποσό</label>--}}
                                            </div>
                                        </div>
                                        <div class="invoice-icon display-flex flex-column justify-content-between">
                                          <span class="delete-row-btn delete-line" data-line="{{$key}}">
                                            <i class="material-icons">clear</i>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="classification-item mb-2" data-repeater-item="">
                                <div class="row mb-1">
                                    <div class="col s4"><h6 class="m-0">Γραμμή Χαρακτηρισμού</h6></div>
                                    <div class="col s4"></div>
                                    <div class="col s2"></div>
                                    <div class="col s2"><h6 class="m-0">Καθαρό Ποσό</h6></div>
                                </div>
                                <div class="invoice-item display-flex mb-1 row justify-content-between">
                                    <div class="invoice-item-filed row pt-1" style="width: 95%;">
                                        <div class="col s12 m4 input-field">
                                                <select id="classification_category" name="classification_category" class="invoice-item-select browser-default select-wrapper">
                                                    <option value="" disabled="">Επιλέξτε Κατηγορία</option>
                                                    <option value="category2_1">Αγορές Εμπορευμάτων</option>
                                                    <option value="category2_2">Αγορές Α'-Β' Υλών</option>
                                                    <option value="category2_3">Λήψη Υπηρεσιών</option>
                                                    <option value="category2_4" selected>Γενικά Έξοδα με δικαίωμα έκπτωσης ΦΠΑ</option>
                                                    <option value="category2_5">Γενικά Έξοδα χωρίς δικαίωμα έκπτωσης ΦΠΑ</option>
                                                    <option value="category2_6">Αμοιβές και Παροχές προσωπικού</option>
                                                    <option value="category2_7">Αγορές Παγίων</option>
                                                    <option value="category2_8">Αποσβέσεις Παγίων</option>
                                                    <option value="category2_9">Έξοδα για λ/σμο τρίτων</option>
                                                    <option value="category2_10">Έξοδα προηγούμενων χρήσεων</option>
                                                    <option value="category2_11">Έξοδα επομένων χρήσεων</option>
                                                    <option value="category2_12">Λοιπές Εγγραφές Τακτοποίησης Εξόδων</option>
                                                    <option value="category2_13">Αποθέματα Έναρξης Περιόδου (Ε3 προηγ. Περιόδου)</option>
                                                    <option value="category2_14">Αποθέματα Λήξης Περιόδου (Ε3 τρέχουσας Περιόδου)</option>
                                                    <option value="category2_95">Λοιπά Πληροφοριακά Στοιχεία Εξόδων</option>
                                                </select>
                                            <label for="classification_category">Κατηγορία</label>
                                        </div>
                                        <div class="col s12 m4 input-field">
                                            <select id="classification_type" name="classification_type" class="invoice-item-select browser-default select-wrapper">
                                                <option value="" disabled="">Επιλέξτε Είδος</option>
                                                <option value="Ε3_101">Εμπορεύματα έναρξης [Ε3_101]</option>
                                                <option value="Ε3_102_001" data-categories="category2_1">Αγορές εμπορευμάτων χρήσης (καθ.ποσό) Χονδρικές [Ε3_102_001]</option>
                                                <option value="Ε3_102_002">Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Λιανικές [Ε3_102_002]</option>
                                                <option value="Ε3_102_003" data-categories="category2_1">Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Αγαθών του άρθρου 39α παρ.5 του Κώδικα Φ.Π.Α. (ν.2859/2000) [Ε3_102_003]</option>
                                                <option value="Ε3_102_004">Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Εξωτερικού Ενδοκοινοτικές [Ε3_102_004]</option>
                                                <option value="Ε3_102_005">Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)/Εξωτερικού Τρίτες Χώρες [Ε3_102_005]</option>
                                                <option value="Ε3_102_006">Αγορές εμπορευμάτων χρήσης (καθαρό ποσό)Λοιπά [Ε3_102_006]</option>
                                                <option value="Ε3_104">Εμπορεύματα λήξης [Ε3_104]</option>
                                                <option value="Ε3_201">Πρώτες ύλες και υλικά έναρξης/Παραγωγή [Ε3_201]</option>
                                                <option value="E3_202_001" data-categories="category2_2"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Χονδρικές [Ε3_202_001]</option>
                                                <option value="E3_202_002"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λιανικές [Ε3_202_002]</option>
                                                <option value="E3_202_003"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Ενδοκοινοτικές [Ε3_202_003]</option>
                                                <option value="E3_202_004"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Τρίτες Χώρες [Ε3_202_004]</option>
                                                <option value="E3_202_005"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λοιπά [Ε3_202_005]</option>
                                                <option value="E3_204"> Αποθέματα λήξης πρώτων υλών και υλικών/Παραγωγή [E3_204]</option>
                                                <option value="E3_207"> Προϊόντα και παραγωγή σε εξέλιξη έναρξης/Παραγωγή [Ε3_207]</option>
                                                <option value="E3_209"> Προϊόντα και παραγωγή σε εξέλιξη λήξης/Παραγωγή [Ε3_209]</option>
                                                <option value="E3_301"> Πρώτες ύλες και υλικά έναρξης/Αγροτική [Ε3_301]</option>
                                                <option value="E3_302_001" data-categories="category2_2"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Χονδρικές [Ε3_302_001]</option>
                                                <option value="E3_302_002"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λιανικές [Ε3_302_002]</option>
                                                <option value="E3_302_003"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Ενδοκοινοτικές [Ε3_302_003]</option>
                                                <option value="E3_302_004"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Εξωτερικού Τρίτες Χώρες [Ε3_302_004]</option>
                                                <option value="E3_302_005"> Αγορές πρώτων υλών και υλικών χρήσης (καθαρό ποσό)/Λοιπά [Ε3_302_005]</option>
                                                <option value="Ε3_581_001">Παροχές σε εργαζόμενους/Μικτές αποδοχές [Ε3_581_001]</option>
                                                <option value="Ε3_581_002">Παροχές σε εργαζόμενους/Εργοδοτικές εισφορές [Ε3_581_002]</option>
                                                <option value="Ε3_581_003">Παροχές σε εργαζόμενους/Λοιπές παροχές [Ε3_581_003]</option>
                                                <option value="E3_582"> Ζημιές επιμέτρησης περιουσιακών στοιχείων [E3_582]</option>
                                                <option value="E3_583"> Χρεωστικές συναλλαγματικές διαφορές [E3_583]</option>
                                                <option value="E3_584"> Ζημιές από διάθεση-απόσυρση μη κυκλοφορούντων περιουσιακών στοιχείων [E3_584]</option>
                                                <option value="Ε3_585_001" data-categories="category2_3,category2_4,category2_5">Προμήθειες διαχείρισης ημεδαπής - αλλοδαπής (management fees) [Ε3_585_001]</option>
                                                <option value="Ε3_585_002" data-categories="category2_4,category2_5">Δαπάνες από συνδεδεμένες επιχειρήσεις [Ε3_585_002]</option>
                                                <option value="Ε3_585_003">Δαπάνες από μη συνεργαζόμενα κράτη ή από κράτη με προνομιακό φορολογικό καθεστώς [Ε3_585_003]</option>
                                                <option value="Ε3_585_004" data-categories="category2_3,category2_4,category2_5">Δαπάνες για ενημερωτικές ημερίδες [Ε3_585_004]</option>
                                                <option value="Ε3_585_005" data-categories="category2_4,category2_5">Έξοδα υποδοχής και φιλοξενίας [Ε3_585_005]</option>
                                                <option value="Ε3_585_006" data-categories="category2_4,category2_5">Έξοδα ταξιδιών [Ε3_585_006]</option>
                                                <option value="Ε3_585_007">Ασφαλιστικές Εισφορές Αυτοαπασχολούμενων [Ε3_585_007]</option>
                                                <option value="Ε3_585_008" data-categories="category2_4,category2_5">Έξοδα και προμήθειες παραγγελιοδόχου για λογαριασμό αγροτών [Ε3_585_008]</option>
                                                <option value="Ε3_585_009" data-categories="category2_3,category2_4,category2_5">Λοιπές Αμοιβές για υπηρεσίες ημεδαπής [Ε3_585_009]</option>
                                                <option value="Ε3_585_010" data-categories="category2_3">Λοιπές Αμοιβές για υπηρεσίες αλλοδαπής [Ε3_585_010]</option>
                                                <option value="Ε3_585_011" data-categories="category2_4,category2_5">Ενέργεια [Ε3_585_011]</option>
                                                <option value="Ε3_585_012" data-categories="category2_4,category2_5">Ύδρευση [Ε3_585_012]</option>
                                                <option value="Ε3_585_013" data-categories="category2_4,category2_5">Τηλεπικοινωνίες [Ε3_585_013]</option>
                                                <option value="Ε3_585_014">Ενοίκια [Ε3_585_014]</option>
                                                <option value="Ε3_585_015" data-categories="category2_4,category2_5">Διαφήμιση και προβολή [Ε3_585_015]</option>
                                                <option value="Ε3_585_016" data-categories="category2_3,category2_4,category2_5" selected>Λοιπά έξοδα [Ε3_585_016]</option>
                                                <option value="Ε3_586" data-categories="category2_4,category2_5">Χρεωστικοί τόκοι και συναφή έξοδα [Ε3_586]</option>
                                                <option value="Ε3_587">Αποσβέσεις [Ε3_587]</option>
                                                <option value="Ε3_588">Ασυνήθη έξοδα, ζημιές και πρόστιμα [Ε3_588]</option>
                                                <option value="Ε3_589">Προβλέψεις (εκτός από προβλέψεις για το προσωπικό) [Ε3_589]</option>
                                                <option value="E3_881_001">Πωλήσεις για λογ/σμο Τρίτων Χονδρικές [E3_881_001]</option>
                                                <option value="E3_881_002">Πωλήσεις για λογ/σμο Τρίτων Λιανικές [E3_881_002]</option>
                                                <option value="E3_881_003">Πωλήσεις για λογ/σμο Τρίτων Εξωτερικού Ενδοκοινοτικές [E3_881_003]</option>
                                                <option value="E3_881_004">Πωλήσεις για λογ/σμο Τρίτων Εξωτερικού Τρίτες Χώρες [E3_881_004]</option>
                                                <option value="Ε3_882_001" data-categories="category2_7">Αγορές ενσώματων παγίων χρήσης/Χονδρικές [Ε3_882_001]</option>
                                                <option value="Ε3_882_002">Αγορές ενσώματων παγίων χρήσης/Λιανικές [Ε3_882_002]</option>
                                                <option value="Ε3_882_003">Αγορές ενσώματων παγίων χρήσης/Εξωτερικού Ενδοκοινοτικές [Ε3_882_003]</option>
                                                <option value="Ε3_882_004">Αγορές ενσώματων παγίων χρήσης/Εξωτερικού Τρίτες Χώρες [Ε3_882_004]</option>
                                                <option value="Ε3_883_001" data-categories="category2_7">Αγορές μη ενσώματων παγίων χρήσης/Χονδρικές [Ε3_883_001]</option>
                                                <option value="Ε3_883_002">Αγορές μη ενσώματων παγίων χρήσης/Λιανικές [Ε3_883_002]</option>
                                                <option value="Ε3_883_003">Αγορές μη ενσώματων παγίων χρήσης/Εξωτερικού Ενδοκοινοτικές [Ε3_883_003]</option>
                                                <option value="Ε3_883_004">Αγορές μη ενσώματων παγίων χρήσης/Εξωτερικού Τρίτες Χώρες [Ε3_883_004]</option>
                                                <option value="VAT_361">Αγορές & δαπάνες στο εσωτερικό της χώρας [VAT_361]</option>
                                                <option value="VAT_362">Αγορές & εισαγωγές επενδ. Αγαθών (πάγια) [VAT_362]</option>
                                                <option value="VAT_363">Λοιπές εισαγωγές εκτός επενδ. Αγαθών (πάγια) [VAT_363]</option>
                                                <option value="VAT_364">Ενδοκοινοτικές αποκτήσεις αγαθών [VAT_364]</option>
                                                <option value="VAT_365">Ενδοκοινοτικές λήψεις υπηρεσιών άρθρ. 14.2.α [VAT_365]</option>
                                                <option value="VAT_366">Λοιπές πράξεις λήπτη [VAT_366]</option>
                                            </select>
                                            <label for="classification_type">Είδος</label>
                                        </div>
                                        <div class="col s2 input-field c-tax">
                                            <select id="tax" name="tax" class="invoice-tax browser-default select-wrapper">
                                                <option value="" disabled="">ΦΠΑ</option>
                                                <option value="1" selected>24%</option>
                                                <option value="4">17%</option>
                                                <option value="2">13%</option>
                                                <option value="5">9%</option>
                                                <option value="3">6%</option>
                                                <option value="6">4%</option>
                                                <option value="7">0%</option>
                                                <option value="8">-</option>
                                            </select>
                                            <label for="tax">Συντελεστής ΦΠΑ</label>
                                        </div>
                                        <div class="col m2 s12 input-field c-price">
                                            <input type="text" class="classification-price" id="price" placeholder="0.00" name="price" pattern="^\d{0,8}(\.\d{1,4})?$">
                                            <label for="price">Ποσό</label>
                                        </div>
                                    </div>
                                    <div class="invoice-icon display-flex flex-column justify-content-between">
                                          <span data-repeater-delete="" class="delete-row-btn">
                                            <i class="material-icons">clear</i>
                                          </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-field">
                            <button class="btn invoice-repeat-btn waves-effect waves-light" data-repeater-create="" type="button">
                                <i class="material-icons left">add</i>
                                <span>Προσθήκη Γραμμής</span>
                            </button>
                        </div>
                        <div class="input-field mt-5 display-flex justify-content-center">
                            <button type="submit" id="classificationsSend" class="btn waves-effect waves-light">
                                <i class="material-icons left">save</i>
                                <span>Αποθήκευση</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div class="col s12 m3">
            <div class="card classifications-calculations-card">
                <div class="card-content">
                    <h5 class="card-title">Υπολογισμός Χαρακτηρισμών</h5>
                    <div class="classifications-calculations">
                        <div class="class-calculator total display-flex justify-content-between">
                            <div class="class-calculator--title">Συνολικό Ποσό</div> <div class="class-calculator--metric">{{$outcome->price}}</div>
                        </div>
                    </div>
                    <div class="classifications-calculations-balance">
                        <div class="class-calculator balance display-flex justify-content-between @if($classifiedPrice == $outcome->price) valid @endif">
                            <div class="class-calculator--title">Αχαρακτήριστο Ποσό</div> <div class="class-calculator--metric"> @if($classifiedPrice == $outcome->price) 0.00 @else {{$outcome->price}} @endif</div>
                        </div>
                    </div>
                </div>
            </div>
            @if($classifiedPrice == $outcome->price)
            <div class="display-flex send-my-data justify-content-center mt-10">
                <form action="{{route('outcome.mydata')}}" method="post">
                    @csrf
                    <input type="hidden" name="outcome_hash" value="{{$outcome->hashID}}">
                    <button type="submit" id="classificationsSendMyData" class="btn waves-effect waves-light" >
                        <i class="material-icons left">backup</i>
                        <span>Αποστολη στο MyData</span>
                    </button>
                </form>
            </div>
            @endif
        </div>
    @endif
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
    <script>
        $c = jQuery.noConflict();

        $c(document).ready(function(){
            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif
        });
        $c(document).on('click', '.delete-line', function(){
           let lineNum = $c(this).data('line');
           let oldHash =  $c('.classification-item[data-line="'+lineNum+'"]').find('.old-hash').val();
            let pageToken = $i('meta[name="csrf-token"]').attr('content');
           console.log(oldHash);


            $c.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': pageToken
                }
            });

            $c.ajax({
                url: "{{ url('/ajax-delete-classification') }}",
                method: 'post',
                data: {
                    classification: oldHash
                },
                success: function (result) {
                    console.log(result);
                    $c('.classification-item[data-line="'+lineNum+'"]').remove();
                }
            });

        });

        if($c('#classifications').length > 0) {
            $c(document).on('change', '.classification-price', function(){
                let totalPrice = '{{ $outcome ?? '' }}';
                $c('.class-calculator.class-price').remove();
                $c('.send-my-data').remove();
                $c('.invoice-item-filed').each(function() {
                    let lineVat = $c(this).find('.invoice-tax').children("option:selected").val();
                    if(lineVat) {
                        let linePrice = $c(this).find('.classification-price').val();
                        let newPrice = number_format(linePrice, 2 ,'.', '');
                        console.log(lineVat,linePrice);
                        $c('.classifications-calculations').append('<div class="class-calculator class-price display-flex justify-content-between" data-line="" data-vat="'+lineVat+'"><div class="class-calculator--title">Συντελεστής ΦΠΑ ('+lineVat+')</div> <div class="class-calculator--metric to-remove">-'+newPrice+'</div></div>');
                    }
                });
                let removes = 0;

                $c('.classification-price').each(function() {
                    removes += Number($c(this).val());
                })
                $c('.class-calculator.balance .class-calculator--metric').text(number_format((totalPrice - removes), 2, ',', ''));
                if((totalPrice - removes) === 0.00) {
                    $c('.class-calculator.balance').removeClass('invalid');
                    $c('.class-calculator.balance').addClass('valid');
                    //$c('#classificationsSend').attr('disabled', false);
                } else if((totalPrice - removes) < 0.00) {
                    $c('.class-calculator.balance').removeClass('valid');
                    $c('.class-calculator.balance').addClass('invalid');
                    //$c('#classificationsSend').attr('disabled', true);
                }
            });
        }

        function number_format( number_input, decimals, dec_point, thousands_sep ) {
            var number       = ( number_input + '' ).replace( /[^0-9+\-Ee.]/g, '' );
            var finite_number   = !isFinite( +number ) ? 0 : +number;
            var finite_decimals = !isFinite( +decimals ) ? 0 : Math.abs( decimals );
            var seperater     = ( typeof thousands_sep === 'undefined' ) ? ',' : thousands_sep;
            var decimal_pont   = ( typeof dec_point === 'undefined' ) ? '.' : dec_point;
            var number_output   = '';
            var toFixedFix = function ( n, prec ) {
                if( ( '' + n ).indexOf( 'e' ) === -1 ) {
                    return +( Math.round( n + 'e+' + prec ) + 'e-' + prec );
                } else {
                    var arr = ( '' + n ).split( 'e' );
                    let sig = '';
                    if ( +arr[1] + prec > 0 ) {
                        sig = '+';
                    }
                    return ( +(Math.round( +arr[0] + 'e' + sig + ( +arr[1] + prec ) ) + 'e-' + prec ) ).toFixed( prec );
                }
            }
            number_output = ( finite_decimals ? toFixedFix( finite_number, finite_decimals ).toString() : '' + Math.round( finite_number ) ).split( '.' );
            if( number_output[0].length > 3 ) {
                number_output[0] = number_output[0].replace( /\B(?=(?:\d{3})+(?!\d))/g, seperater );
            }
            if( ( number_output[1] || '' ).length < finite_decimals ) {
                number_output[1] = number_output[1] || '';
                number_output[1] += new Array( finite_decimals - number_output[1].length + 1 ).join( '0' );
            }
            return number_output.join( decimal_pont );
        }
    </script>
@endsection
