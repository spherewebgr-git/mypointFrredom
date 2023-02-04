<div id="invoices">
    <div class="card-panel">
        <div class="row">
            <form action="{{route('settings.update', ['form' => 'invoices'])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="display-flex">
                    @if(isset($settings['invoice_logo']) && $settings['invoice_logo'] != NULL)
                        <div class="media">
                            <img src="{{url('images/system/'.$settings['invoice_logo'])}}" class="border-radius-4" alt="profile image"
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
                <div class="col s12 m6 input-field">
                    <div class="switch">
                        <label for="show_invoice_email">Εμφάνιση διεύθυνσης e-mail στα παραστατικά
                            <input type="checkbox" name="show_invoice_email" id="show_invoice_email" @if(isset($settings['show_invoice_email']) && $settings['show_invoice_email'] == 'on') checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 m6 input-field">
                    <div class="switch">
                        <label for="show_invoice_logo">Εμφάνιση λογοτύπου στα παραστατικά
                            <input type="checkbox" name="show_invoice_logo" id="show_invoice_logo" @if(isset($settings['show_invoice_logo']) && $settings['show_invoice_logo'] == 'on') checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 m6 input-field">
                    <div class="switch">
                        <label for="show_invoice_phone">Εμφάνιση τηλεφώνου στα παραστατικά
                            <input type="checkbox" name="show_invoice_phone" id="show_invoice_phone" @if(isset($settings['show_invoice_phone']) && $settings['show_invoice_phone'] == 'on') checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 m6 input-field">
                    <div class="switch">
                        <label for="show_invoice_mobile">Εμφάνιση κινητού τηλεφώνου στα παραστατικά
                            <input type="checkbox" name="show_invoice_mobile" id="show_invoice_mobile" @if(isset($settings['show_invoice_mobile']) && $settings['show_invoice_mobile'] == 'on') checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 m6 input-field">
                    <div class="switch">
                        <label for="show_invoice_website">Εμφάνιση ιστοσελίδας στα παραστατικά
                            <input type="checkbox" name="show_invoice_website" id="show_invoice_website" @if(isset($settings['show_invoice_website']) && $settings['show_invoice_website'] == 'on') checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 m4 input-field mt-2">
                    <label for="invoice_color" class="active" style="top: -8px;">Χρώμα τιμολογίου</label>
                    <input type="color" id="invoice_color" name="invoice_color" @if(isset($settings['invoice_color'])) value="{{$settings['invoice_color']}}" @else value="#C62828" @endif">
                </div>
                <div class="clearfix"></div>
                <div class="col s12 mt-4 input-field">
                    <label for="payment_methods">Τρόποι Πληρωμής (για την επισύναψη στο τιμολόγιο)</label>
                        <textarea name="payment_methods" id="payment_methods" class="materialize-textarea"> @if(isset($settings['payment_methods'])){{$settings['payment_methods']}} @endif</textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                </div>
            </form>
        </div>
    </div>
</div>
