<div id="addresses">
    <div class="card-panel">
        <div class="row">
            <form action="{{route('settings.update', ['form' => 'addresses'])}}" method="post" enctype="multipart/form-data" class="form invoice-item-repeater">
                @csrf
                @foreach($addresses as $address)
                    @if($address->type !== 'address')
                    <div>
                        <div class="addresses-item position-relative">
                            <div class="col s3">
                                <div class="input-field">
                                    <select name="{{$address['type']}}" class="invoice-item-select browser-default">
                                        <option value="0_edra" @if($address['type'] == 'address_0_edra') selected @endif>Έδρα</option>
                                        <option value="1_ypokatastima" @if($address['type'] == 'address_1_ypokatastima') selected @endif>Υποκατάστημα 1</option>
                                        <option value="2_ypokatastima" @if($address['type'] == 'address_2_ypokatastima') selected @endif>Υποκατάστημα 2</option>
                                        <option value="3_ypokatastima" @if($address['type'] == 'address_3_ypokatastima') selected @endif>Υποκατάστημα 3</option>
                                        <option value="4_ypokatastima" @if($address['type'] == 'address_4_ypokatastima') selected @endif>Υποκατάστημα 4</option>
                                        <option value="5_ypokatastima" @if($address['type'] == 'address_5_ypokatastima') selected @endif>Υποκατάστημα 5</option>
                                        <option value="1_apothiki" @if($address['type'] == 'address_1_apothiki') selected @endif>Αποθήκη 1</option>
                                        <option value="2_apothiki" @if($address['type'] == 'address_2_apothiki') selected @endif>Αποθήκη 2</option>
                                        <option value="3_apothiki" @if($address['type'] == 'address_3_apothiki') selected @endif>Αποθήκη 3</option>
                                        <option value="4_apothiki" @if($address['type'] == 'address_4_apothiki') selected @endif>Αποθήκη 4</option>
                                        <option value="5_apothiki" @if($address['type'] == 'address_5_apothiki') selected @endif>Αποθήκη 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col s9">
                                <div class="input-field">
                                    <input id="address" name="{{$address['type']}}" type="text" @if(isset($address->value)) value="{{old('file', $address->value)}}" @endif>
                                    <label for="{{$address['type']}}">Διεύθυνση (Οδός Αριθμός, ΤΚ, Περιοχή, Πόλη)</label>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <h4 style="font-size: 16px;font-weight: 400;margin: 45px 0 10px 25px;">Προσθήκη Νέων Διευθύνσεων</h4>
                <div  data-repeater-list="addresses">
                    <div class="addresses-item position-relative" data-repeater-item="">
                        <div class="col s3">
                            <div class="input-field">
                                <select name="address_type" class="invoice-item-select browser-default">
                                    <option value="0_edra">Έδρα</option>
                                    <option value="1_ypokatastima">Υποκατάστημα 1</option>
                                    <option value="2_ypokatastima">Υποκατάστημα 2</option>
                                    <option value="3_ypokatastima">Υποκατάστημα 3</option>
                                    <option value="4_ypokatastima">Υποκατάστημα 4</option>
                                    <option value="5_ypokatastima">Υποκατάστημα 5</option>
                                    <option value="1_apothiki">Αποθήκη 1</option>
                                    <option value="2_apothiki">Αποθήκη 2</option>
                                    <option value="3_apothiki">Αποθήκη 3</option>
                                    <option value="4_apothiki">Αποθήκη 4</option>
                                    <option value="5_apothiki">Αποθήκη 5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col s9">
                            <div class="input-field">
                                <input id="address" name="address" type="text">
                                <label for="address">Διεύθυνση (Οδός Αριθμός, ΤΚ, Περιοχή, Πόλη)</label>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <div class="input-field">
                    <button class="btn invoice-repeat-btn" data-repeater-create="" type="button">
                        <i class="material-icons left">add</i>
                        <span>Προσθήκη Γραμμής</span>
                    </button>
                </div>
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                </div>
            </form>
        </div>
    </div>
</div>
