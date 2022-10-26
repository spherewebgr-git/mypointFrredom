<div class="col s12 m6">
    <div id="profile-card" class="card animate fadeRight">
        <div class="card-image waves-effect waves-block waves-light">
            <img class="activator" src="{{asset('images/gallery/3.png')}}" alt="user bg"/>
        </div>
        <div class="card-content mb-1">
            @if(settings()->logo)
            <img src="{{url('images/system/'.settings()->logo)}}" alt="logo"
                 class="circle responsive-img activator card-profile-image mb-1 waves-effect waves-light  accent-2 z-depth-4 "/> @endif
            <a class="btn-floating activator btn-move-up waves-effect waves-light red accent-2 z-depth-3 right">
                <i class="material-icons">visibility</i>
            </a>
            <h5 class="card-title activator grey-text text-darken-4 mt-2">{{settings()->title}}</h5>
            <p><i class="material-icons profile-card-i">perm_identity</i> {{settings()->company}}</p>
            <p><i class="material-icons profile-card-i">domain</i> {{settings()->address}}</p>
            <p><i class="material-icons profile-card-i">phone_android</i> {{settings()->mobile}}</p>
            @if(settings()->email)
            <p><i class="material-icons profile-card-i">email</i> {{settings()->email}}</p>
            @endif
        </div>
        <div class="card-reveal">
                  <span class="card-title grey-text text-darken-4">{{settings()->company}} - {{settings()->title}} <i
                          class="material-icons right">close</i>
                  </span>
            <p>Συγκεντρωτικά Στοιχεία Επιχείρησης</p>
            <p title="Επάγγελμα"><i class="material-icons">work</i> {{settings()->business}}</p>
            <p><i class="material-icons profile-card-i">domain</i> {{settings()->address}}</p>
            <p><i class="material-icons">perm_phone_msg</i> {{settings()->mobile}}</p>
            <p><i class="material-icons">email</i> {{settings()->email}}</p>
            <p><i class="material-icons">store_mall_directory</i> Α.Φ.Μ.: {{settings()->vat}}, Δ.Ο.Υ.: {{settings()->doy}}</p>
            <p></p>
            <p class="right"><a href="{{route('settings.view')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
                    <i class="material-icons">add</i>
                    <span>Επεξεργασία Στοιχείων Εταιρείας</span>
                </a></p>
            <p></p>
        </div>
    </div>
</div>
