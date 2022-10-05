<!-- BEGIN: Footer-->
<footer
  class="{{$configData['mainFooterClass']}} @if($configData['isFooterFixed']=== true){{'footer-fixed'}}@else {{'footer-static'}} @endif @if($configData['isFooterDark']=== true) {{'footer-dark'}} @elseif($configData['isFooterDark']=== false) {{'footer-light'}} @else {{$configData['mainFooterColor']}} @endif">
  <div class="footer-copyright">
    <div class="container">
      <span>&copy; myPoint App 2022  All rights reserved.
      </span>
      <span class="right hide-on-small-only">
        Developed by <a href="https://www.sphereweb.gr"
                        target="_blank">Sphere Web Solutions</a>
      </span>
    </div>
  </div>
</footer>

<!-- END: Footer-->
