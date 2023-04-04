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
                <div class="col s12 m6 mb-4 mt-2 display-flex justify-content-end">
                    <a href="{{route('invoice.mydata.get-invoices')}}" class="btn display-flex align-items-center" style="gap: 10px;"><i class="material-icons">archive</i> Εισαγωγή Δεδομένων από MyData</a>
                </div>
                <div class="col s12 m6 mb-4 mt-2 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση</button>
                </div>
                <div class="col s12 mt-1 mb-1">
                    <a href="#" id="openMydataInfo" class="btn cyan waves-effect waves-light">
                        <strong>Οδηγίες δημιουργίας κωδικών myData</strong>
                    </a>
                </div>
                <div class="mydata-howto hide col s12 mt-1 mb-1">
                    <p>Για να δημιουργείσετε τους παραπάνω κωδικούς για την επιχείρησή σας ακολουθήστε τα παρακάτω βήματα:</p>
                    <ol>
                        <li>Ακολουθήστε τον σύνδεσμο (<a href="https://www1.aade.gr/saadeapps2/bookkeeper-web/" target="_blank">https://www1.aade.gr/saadeapps2/bookkeeper-web/</a> ) και κάντε σύνδεση με τους κωδικούς taxis σας.</li>
                        <li>Αφού συνδεθείτε, επιλέξτε <strong>"Εγγραφή στο myDATA REST API"</strong></li>
                        <li>Έπειτα στην ενότητα "Χρήστες" πατήτε το <strong>"Νέα εγγραφή χρήστη"</strong></li>
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
