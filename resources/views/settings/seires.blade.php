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
            @if(isset($settings['delivery_invoices']) && $settings['delivery_invoices'] == 'on')
                <div class="col s12 m6">
                    <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Σειρές ΤΔΑ</h4>
                    <ul class="collection">
                        @foreach($seires['delivery_invoices'] as $deliveryType)
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
                            <option value="delivery_invoices">Τιμολόγια - Δελτία Αποστολής</option>
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
