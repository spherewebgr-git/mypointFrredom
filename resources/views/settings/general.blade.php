<div id="general">
    <div class="card-panel">
        <form action="{{route('settings.update', ['form' => 'general'])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="display-flex">
                @if(isset($settings['logo']))
                    <div class="media">
                        <img src="{{url('images/system/'.$settings['logo'])}}" class="border-radius-4" alt="profile image"
                             height="64" width="64">
                    </div>
                @endif
                <div class="media-body">
                    <div class="general-action-btn">
                        <div class="file-field input-field s12">
                            <div class="btn">
                                <span>Φωτογραφία / Λογότυπο</span>
                                <input type="file" name="file" @if(isset($settings['logo']))  value="{{old('file', $settings['logo'])}}" @endif>
                            </div>
                            <div class="file-path-wrapper" style="opacity:0;">
                                <input class="file-path validate" name="logo" type="text" @if(isset($settings['logo']))  value="{{old('file', $settings['logo'])}}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1 mt-1 clearfix"></div>
                    <small>Επιτρέπονται JPG ή PNG. Ιδανικές Διαστάσεις 300x300</small>
                </div>
            </div>
            <div class="divider mb-1 mt-1"></div>
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <label for="name">Ονοματεπώνυμο Ιδιοκτήτη</label>
                        <input id="name" name="name" type="text" value="{{$admin->name}}" data-error=".errorTxt2">
                        <small class="errorTxt2"></small>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field">
                        <label for="email">E-mail</label>
                        <input id="email" type="email" name="email" value="{{$admin->email}}" data-error=".errorTxt3" disabled>
                        <small class="errorTxt3"></small>
                    </div>
                </div>
                <div class="col s6">
                    <div class="input-field">
                        <input id="phone" name="phone" type="text" class="validate" @if(isset($settings['phone'])) value="{{$settings['phone']}}" @endif>
                        <label for="phone">Τηλέφωνο</label>
                    </div>
                </div>
                <div class="col s6">
                    <div class="input-field">
                        <input id="mobile" name="mobile" type="text" class="validate" @if(isset($settings['mobile'])) value="{{$settings['mobile']}}" @endif>
                        <label for="mobile">Κινητό</label>
                    </div>
                </div>
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Αποθήκευση Αλλαγών</button>
                </div>
            </div>
        </form>
    </div>
</div>
