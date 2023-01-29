@php $trashed = getTrashed(); @endphp
<div class="navbar @if(($configData['isNavbarFixed'])=== true){{'navbar-fixed'}} @endif">
  <nav
    class="navbar-main navbar-color nav-collapsible no-shadow nav-expanded sideNav-lock  navbar-light">
    <div class="nav-wrapper">
        @yield('header-left')
      <ul class="navbar-list right">
          <li class="hide-on-med-and-down">
              <div class="waves-effect waves-block waves-light" id="tour">
                  <i class="material-icons">slideshow</i>
              </div>
          </li>
        <li class="hide-on-med-and-down">
          <a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);">
            <i class="material-icons">settings_overscan</i>
          </a>
        </li>
        <li class="hide-on-large-only search-input-wrapper">
          <a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);">
            <i class="material-icons">search</i>
          </a>
        </li>
          <li>
              <a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);"
                 data-target="binDropdown">
                  <i class="material-icons">delete<small class="notification-badge">{{count($trashed)}}</small></i>
              </a>
          </li>
        <li>
          <a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" title="{{settings()['company']. ' - ' . settings()['title']}}"
            data-target="profile-dropdown">
              @if(isset(settings()['logo']))
                <span class="avatar-status avatar-online">
                  <img src="{{asset('images/system/'.settings()['logo'])}}" alt="{{settings()['company']}} Logo"><i></i>
                </span>
                  @else
                  <span id="avatar-name">{{settings()['company']}}</span>
              @endif
          </a>
        </li>
      </ul>
      <!-- notifications-dropdown-->
      <ul class="dropdown-content" id="binDropdown">
        <li>
          <h6>ΚΑΔΟΣ ΑΝΑΚΥΚΛΩΣΗΣ</h6>
        </li>
        <li class="divider"></li>
          @foreach($trashed as $trash)
              <li>
                  @if(isset($trash->invoiceID))
                  <div class="black-text">
                  <span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span>
                      Τιμολόγιο - m{{str_pad($trash->invoiceID, 4, '0', STR_PAD_LEFT)}}
                  </div>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">Διεγράφη {{ \Carbon\Carbon::parse($trash->deleted_at)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($trash->deleted_at)->format('H:i')}}</time>
                  @else
                  <div class="black-text">
                      <span class="material-icons icon-bg-circle cyan small">receipt</span>
                      {{$trash->outcome_number}} - {{$trash->shop}}
                  </div>
                  <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">Διεγράφη {{ \Carbon\Carbon::parse($trash->deleted_at)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($trash->deleted_at)->format('H:i')}}</time>
                  @endif
              </li>
          @endforeach
      </ul>
      <!-- profile-dropdown-->
      <ul class="dropdown-content" id="profile-dropdown">
        <li>
          <a class="grey-text text-darken-1" href="#">
            <i class="material-icons">help_outline</i>
            Help
          </a>
        </li>
        <li class="divider"></li>
        <li>
          <a class="grey-text text-darken-1" href="{{route('signOut')}}">
            <i class="material-icons">keyboard_tab</i>
            Logout
          </a>
        </li>
      </ul>
    </div>
  </nav>
</div>
