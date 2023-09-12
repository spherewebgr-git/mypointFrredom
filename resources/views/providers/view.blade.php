{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $provider->provider_name.'- Καρτέλα προμηθευτή' )

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-contact.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="col s12">
        <div class="container">
            <!-- Contact Us -->
            <div id="contact-us" class="section">
                <div class="app-wrapper">
                    <div class="contact-header">
                        <div class="row contact-us ml-0 mr-0">
                            <div class="col s12 m12 l4 sidebar-title">
                                <h5 class="m-0"><i
                                        class="material-icons contact-icon vertical-text-top">mail_outline</i> Καρτέλα
                                    Προμηθευτή:</h5>
                                <p class="m-0 font-weight-500 mt-6 hide-on-med-and-down text-ellipsis"
                                   title="{{$provider->name}}">{{$provider->name}}</p>
                                <span class="social-icons hide-on-med-and-down"><i class="fab fa-behance"></i> <i
                                        class="fab fa-dribbble ml-5"></i>
                                    <i class="fab fa-facebook-f ml-5"></i>
                                    <i class="fab fa-instagram ml-5"></i>
                                </span>
                            </div>
                            <div class="col s12 m12 l8 provider-tabs">
                                <ul class="tabs">
                                    <li class="tab col m4"><a class="active" href="#prosfataTimologia">ΠΡΟΣΦΑΤΑ
                                            ΤΙΜΟΛΟΓΙΑ</a></li>
                                    <li class="tab col m4"><a href="#ipiresies">ΥΠΗΡΕΣΙΕΣ</a></li>
                                    <li class="tab col sm m4"><a href="#protimologia">ΥΠΗΡΕΣΙΕΣ ΠΡΟΣ ΤΙΜΟΛΟΓΗΣΗ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Sidenav -->
                    <div id="sidebar-list" class="row contact-sidenav ml-0 mr-0">
                        <div class="col s12 m12 l4">
                            <!-- Sidebar Area Starts -->
                            <div class="sidebar-left sidebar-fixed" style="position: relative">
                                <div class="sidebar">
                                    <div class="sidebar-content">
                                        <div class="sidebar-menu list-group position-relative">
                                            <div class="sidebar-list-padding app-sidebar contact-app-sidebar"
                                                 id="contact-sidenav">
                                                <ul class="contact-list display-grid">
                                                    <li>
                                                        <h6 class="mt-5 line-height">Στοιχεία Τιμολόγησης &
                                                            Επικοινωνίας</h6>
                                                    </li>
                                                    <li>
                                                        <hr class="mt-5">
                                                    </li>
                                                </ul>
                                                <div class="row">
                                                    <!-- Business Info -->
                                                    <div class="col s12 work_title mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="Επάγγελμα"><i class="material-icons">
                                                                computer </i></div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 address mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="Διεύθυνση"><i class="material-icons">
                                                                markunread_mailbox </i></div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0">{{$provider->address.' '.$provider->address_number}}, {{chunk_split($provider->address_tk, 3, ' ')}}, {{$provider->city}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 vat mt-4 m6 p-0">
                                                        <div class="col s2 m2 l2 tooltipped" data-position="top"
                                                             data-tooltip="Α.Φ.Μ."><i class="material-icons"> flip </i>
                                                        </div>
                                                        <div class="col s10 m10 l10">
                                                            <p class="m-0">{{$provider->provider_vat}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col s12 doy mt-4 m6 p-0">
                                                        <div class="col s2 m2 l2 tooltipped" data-position="top"
                                                             data-tooltip="Δ.Ο.Υ."><i class="material-icons">
                                                                layers </i></div>
                                                        <div class="col s10 m10 l10">
                                                            <p class="m-0">{{$provider->provider_doy}}</p>
                                                        </div>
                                                    </div>
                                                    @if($provider->email)
                                                    <div class="col s12 email mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="E-mail"><i class="material-icons"> mail </i>
                                                        </div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0">{{$provider->email}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($provider->phone)
                                                    <div class="col s12 phone mt-4 p-0">
                                                        <div class="col s2 m2 l1 tooltipped" data-position="top"
                                                             data-tooltip="Τηλέφωνο"><i class="material-icons">
                                                                phone </i></div>
                                                        <div class="col s10 m10 l11">
                                                            <p class="m-0">{{$provider->phone}}</p>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <!-- Business Info -->
                                                    <a href="{{route('provider.edit', ['vat' => $provider->provider_vat])}}"
                                                       class="waves-effect waves-light btn mb-1 mr-1 mt-4">
                                                        <i class="material-icons left">edit</i> Επεξεργασία</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Area Ends -->
                        </div>
                        <div class="col s12 m12 l8 contact-form margin-top-contact">
                            <div class="row">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
@endsection

{{-- scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/dataTables.checkboxes.min.js')}}"></script>
{{--    <script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>--}}
    <script src="{{asset('js/vendors.min.js')}}"></script>
    <script>
        $m = jQuery.noConflict();
        $m(document).ready(function () {
            @if(Session::has('notify'))
            M.toast({
                html: '{{Session::get("notify") }}',
                classes: 'rounded',
                timeout: 10000
            });
            @endif
            $m('.modal-trigger').on('click', function() {
                $m('.modal').addClass('open');
                $m('.modal').css({
                    "z-index": "1003",
                    "display": "block",
                    "opacity": 1,
                    "top": "10%",
                    "transform" : "scaleX(1) scaleY(1)"
                });
            });
            $m('.modal-close').on('click', function() {
                $m('.modal').removeClass('open');
                $m('.modal').css({
                    "z-index": "-1",
                    "display": "none",
                    "opacity": 0,
                    "top": "10%",
                    "transform" : "scaleX(1) scaleY(1)"
                });
            });
            $m('input.dt-checkboxes').on('change', function() {
                let checkboxes = $m('input.dt-checkboxes:checked').length;
                if(checkboxes >= 1) {
                    $m('.addToInvoice').addClass('active');
                } else {
                    $m('.addToInvoice').removeClass('active');
                }
            });
            $m('.addToInvoice').on('click', function() {
                let checkboxes = $m('input.dt-checkboxes:checked').length;
                if(checkboxes >= 1) {
                    $m('#servicesForm').submit();
                }
            });


        });
    </script>
@endsection
