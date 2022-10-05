{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Καταχώρηση νέου παραστατικού εξόδων')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0"><span>Καταχώρηση νέου παραστατικού εξόδων</span></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div id="prefixes" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Στοιχεία Παραστατικού</h4>
                <form @if(isset($outcome->outcome_number)) action="{{route('outcome.update', ['outcome' => $outcome->hashID])}}" @else action="{{route('outcome.store')}}" @endif method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="outcome_number" type="text" name="outcome_number" @if(isset($outcome->outcome_number))value="{{old('outcome_number', $outcome->outcome_number)}}" @endif required>
                            <label for="outcome_number" class="">Αριθμός Παραστατικού *</label>
                        </div>
                        <div class="invoice-date-picker align-items-center col m6">
                            <div class="">
                                <small>Ημ/νία Έκδοσης: </small>
                                <div class="display-flex" style="margin-top: -6px;">
                                    <input type="text" class="datepicker" name="date" placeholder="Επιλέξτε Ημ/νία"
                                           @if(isset($outcome->date)) value="{{old('date', $outcome->date)}}" @else value="{{date('Y-m-d')}}" @endif>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m5">
                            <i class="material-icons prefix">local_grocery_store</i>
                            <input id="shop" type="text" name="shop" @if(isset($outcome->shop)) value="{{old('shop', $outcome->shop)}}" @endif required>
                            <label for="shop" class="">Επωνυμία Καταστήματος *</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <i class="material-icons prefix">euro_symbol</i>
                            <input id="price" type="text" name="price" @if(isset($outcome->price)) value="{{old('price', $outcome->price)}}" @endif required>
                            <label for="price" class="">Ποσό *</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <i class="material-icons prefix">label</i>
                            <input id="vat" type="text" name="vat" @if(isset($outcome->vat))  value="{{old('vat', $outcome->vat)}}" @endif required>
                            <label for="vat" class="">Φ.Π.Α. *</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field s12">
                            <div class="btn">
                                <span>Αρχείο</span>
                                <input type="file" name="file" @if(isset($outcome->file))  value="{{old('file', $outcome->file)}}" @endif>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" @if(isset($outcome->file))  value="{{old('file', $outcome->file)}}" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">@if(isset($outcome->outcome_number)) Ενημέρωση @else Καταχώρηση @endif
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.js')}}"></script>
@endsection
