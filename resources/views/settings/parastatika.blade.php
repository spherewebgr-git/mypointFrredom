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
                        <label for="delivery_invoices">ΤΙΜΟΛΟΓΙΑ - ΔΕΛΤΙΑ ΑΠΟΣΤΟΛΗΣ
                            <input type="checkbox" id="delivery_invoices" name="delivery_invoices" @if(isset($settings['delivery_invoices']) && $settings['delivery_invoices'] == 'on') checked @endif>
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
