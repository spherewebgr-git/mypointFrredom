<div id="services">
    <div class="card-panel">

        <div class="row">
            <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Ρυθμίσεις Παρεχόμενων Υπηρεσιών</h4>
            <p style="padding-left: 25px;">Η ενότητα αφορά παρεχόμενες υπηρεσίες σε πελάτες οι οποίες χρεώνονται σε τακτά χρονικά διαστήματα.</p>
            <div class="divider"></div>
            <form action="{{route('settings.update', ['form' => 'services'])}}" class="infovalidate" method="post">
                @csrf
                <div class="col s12 m4">
                    <div class="input-field">
                        <div class="switch">
                            <label for="show_services">Χρήση των Υπηρεσιών
                                <input type="checkbox" id="show_services" name="services" @if(isset($settings['services']) && $settings['services'] == 'on') checked @endif>
                                <span class="lever"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col s12 display-flex justify-content-end form-action mt-2">
                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                </div>
            </form>
        </div>
    </div>
</div>
