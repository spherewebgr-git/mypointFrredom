{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}

    @section('title','Ενημέρωση Αποθήκης Προϊόντων')


{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dropify.min.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-light pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        <span>Ενημέρωση Αποθήκης Προϊόντων</span>
                    </h5>
                </div>
                <div class="invoice-head--right row col s12 m6 display-flex justify-content-end align-items-center">
                    <form action="/" class="form" method="post">

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card print-hide">
        <div class="card-content container">
            <h4 class="card-title">Αναζήτηση Προϊόντος</h4>
        </div>
    </div>
    <form action="{{route('products.update-products')}}" class="form" method="post">
        @csrf
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
            <table class="table invoice-data-table white border-radius-4 pt-1 dataTable no-footer dtr-column"
                   id="DataTables_Table_0" role="grid" style="border-spacing: 0 5px;">
                <thead>
                <tr role="row">
                    <th>Barcode</th>
                    <th class="center-align"><span>Κωδ. Προϊόντος</span></th>
                    <th>Τίτλος</th>
                    <th class="center-align" style="width: 85px!important;">Ποσότητα</th>
                    <th class="center-align" style="width: 85px!important;">+ Προσθήκη</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($products))
                    @foreach($products as $product)
                        <tr class="{{$product->storage->quantity > 0 ? 'active' : 'inactive'}}">
                            <td class="center-align"><input type="text" value="{{$product->barcode}}" name="barcode-{{$product->id}}" /></td>
                            <td class="center-align">{{$product->product_number}}</td>
                            <td>{{$product->product_name}}</td>
                            <td class="center-align" style="color:{{$product->storage->quantity > 0 ? '#60d360' : '#f36767'}}">{{$product->storage->quantity ?? 0}}</td>
                            <td>
                                <input type="number" name="quantity-{{$product->id}}" style="text-align: center;">
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn mt-3 mb-4"><i class="material-icons left">library_add</i> Ενημέρωση Αποθήκης</button>
    </form>

@endsection
@section('page-script')
    <script>
        $a = jQuery.noConflict();
        $a(document).ready(function(){

        });
    </script>
@endsection
