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
