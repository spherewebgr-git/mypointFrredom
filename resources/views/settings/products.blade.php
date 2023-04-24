<div id="products">
    <div class="card-panel">
        <div class="row">
            <form action="{{route('settings.update', ['form' => 'products'])}}" method="post">
                @csrf
                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Γενικές Ρυθμίσεις</h4>
                <div class="divider"></div>
                <div class="col s12 m6 input-field">
                    <div class="switch">
                        <label for="show_products">Εμφάνιση - Χρήση Αποθήκης Προϊόντων
                            <input type="checkbox" id="show_products" name="products" @if(isset($settings['products']) && $settings['products'] == 'on') checked @endif>
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="product-settings row col s12">
                    <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Ρυθμίσεις Σύνδεσης με Woocommerce</h4>
                    <div class="divider mb-2"></div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            <input id="woocommerce_store_url" name="woocommerce_store_url" type="text" value="{{$settings['woocommerce_store_url'] ?? ''}}">
                            <label for="woocommerce_store_url" class="active">Woocommerce Store URL</label>
                            <small class="errorTxt4"></small>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            <input id="woocommerce_consumer_key" name="woocommerce_consumer_key" type="text" value="{{$settings['woocommerce_consumer_key'] ?? ''}}">
                            <label for="woocommerce_consumer_key" class="active">Woocommerce Consumer Key</label>
                            <small class="errorTxt4"></small>
                        </div>
                    </div>
                    <div class="col s12 m4">
                        <div class="input-field">
                            <input id="woocommerce_consumer_secret" name="woocommerce_consumer_secret" type="text" value="{{$settings['woocommerce_consumer_secret'] ?? ''}}">
                            <label for="woocommerce_consumer_secret" class="active">Woocommerce Consumer Secret</label>
                            <small class="errorTxt4"></small>
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
