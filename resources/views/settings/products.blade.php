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
                    test
                </div>
                <div class="col s12 display-flex justify-content-end form-action mt-2">
                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                </div>
            </form>
        </div>
    </div>
</div>
