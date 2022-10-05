{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Νέα Απόδειξη Λιανικής')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <form class="form invoice-item-repeater" @if(isset($retail->retailID)) action="{{route('retail-receipts.update', $retail->hashID)}}" @else action="{{route('retail-receipts.store')}}" @endif method="post">
                @csrf
                <div class="col xl9 m8 s12">
                    <div class="card">
                        <div class="card-content px-36">
                            <div class="progress" style="display: none">
                                <div class="indeterminate"></div>
                            </div>
                            <!-- header section -->
                            <div class="row mb-3">
                                <div class="col xl6 m12 display-flex align-items-center">
                                    <h6 class="invoice-number mr-4 mb-5 col-8">Απόδειξη Λιανικής Πώλησης - Σειρά: L #</h6>
                                    <input type="hidden" name="seira" value="L">
                                    <div class="al-number col-4">
                                        <input type="text" name="retailID" placeholder="0001" @if(isset($last)) value="{{str_pad($last+1, 4, '0', STR_PAD_LEFT)}}" @elseif(isset($retail->retailID)) value="{{str_pad($retail->retailID, 4, '0', STR_PAD_LEFT)}}" @endif>
                                    </div>
                                </div>
                                <div class="col xl6 m12">
                                    <div class="invoice-date-picker display-flex align-items-center">
                                        <div class="display-flex align-items-center">
                                            <small>Ημ/νία Έκδοσης: </small>
                                            <div class="display-flex ml-4">
                                                <input type="text" class="datepicker mb-1" name="date"
                                                       placeholder="Επιλέξτε Ημ/νία" value="@if(isset($retail->date)) {{\Carbon\Carbon::createFromTimestamp(strtotime($retail->date))->format('d/m/Y')}} @else {{date('d/m/Y')}} @endif" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col l12 s12">
                                    <h6>Πλροφορίες Έκδοσης</h6>
                                    <div class="col s12 m12  input-field">
                                        <div class="col s12 m4">
                                            <label class="m-0" for="description">Γενική περιγραφή (προαιρετική)</label>
                                        </div>
                                        <div class="col m12 s12 input-field">
                                            <textarea name="mainDescription" id="description" class="materialize-textarea">@if(isset($retail->description)) {{$retail->description}} @endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-product-details mb-3">
                                <!-- invoice Titles -->
                                <div class="row mb-1">
                                    <div class="col s12 m10">
                                        <h6 class="m-0">Περιγραφή Παρεχόμενης Υπηρεσίας</h6>
                                    </div>
                                    <div class="col m2 hide-on-med-and-down">
                                        <h6 style="margin-left: -40px">Τιμή</h6>
                                    </div>

                                </div>
                                <div class="invoice-item display-flex">
                                    <div class="invoice-item-filed row pt-1" style="width: 100%">
                                        <div class="col m10 s12 input-field">
                                            <textarea class="materialize-textarea"
                                                      name="description" placeholder="Περιγραφή Παρεχόμενης Υπηρεσίας">@if(isset($retail->service)) {{$retail->service}} @endif</textarea>
                                        </div>

                                        <div class="col m2 s12 input-field">
                                            <input type="text" placeholder="Τελικό Ποσό" name="price"
                                                   class="price-field" value="@if(isset($retail->price)) {{$retail->price}} @endif">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col xl3 m4 s12">
                    <div class="card invoice-action-wrapper mb-10">
                        <div class="card-content">
                            <div class="invoice-action-btn">
                                @if(isset($retail) && !isset($retail->mark))

                                        <a href="{{route('retail-receipts.mydata', $retail->retailID)}}" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                            <i class="material-icons mr-4">backup</i>
                                            <span>Αποστολή στο myData</span>
                                        </a>

                                @endif
                                @if(isset($retail->retailID))
                                    <input type="submit" value="Ενημέρωση Απόδειξης Λιανικής" style="color: #fff;width: 100%;"
                                           class="btn display-flex align-items-center justify-content-center">
                                @else
                                    <input type="submit" value="Έκδοση Απόδειξης Λιανικής" style="color: #fff;width: 100%;"
                                           class="btn display-flex align-items-center justify-content-center">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="invoice-terms display-flex flex-column" style="margin-top: 8rem;">
                        <div class="display-flex justify-content-between pb-2">
                            <span>Εκτύπωση μετά την έκδοση</span>
                            <div class="switch">
                                <label>
                                    <input type="checkbox" name="printNow" checked>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('page-script')
    <script src="{{asset('js/scripts/app-invoice.js')}}"></script>
@endsection
