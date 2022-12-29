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
