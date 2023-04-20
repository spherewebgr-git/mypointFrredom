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

            </div>
        </div>
    </div>
    <div class="card print-hide">
        <div class="card-content container row">
            <h4 class="card-title col s12 ">Αναζήτηση Προϊόντος</h4>
            <div class="product-filters col s12 m6">
                <label for="search">Αναζήτηση</label>
                <input type="text" name="search" placeholder="(με κωδικό, barcode ή τίτλο)" />
            </div>
            <div class="product-filters col s12 m3 display-flex align-items-center" style="height: 70px;justify-content: space-around">
                <label>
                    <input name="status" value="all" type="radio" checked />
                    <span>Όλα</span>
                </label>
                <label>
                    <input name="status" value="1" type="radio" />
                    <span>Ενεργά</span>
                </label>
                <label>
                    <input name="status" value="0" type="radio" />
                    <span>Ανενεργά</span>
                </label>
            </div>
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
                    <th>Brand</th>
                    <th class="center-align" style="width: 85px!important;">Ποσότητα</th>
                    <th class="center-align" style="width: 85px!important;">Δεσμευμένα</th>
                    <th class="center-align" style="width: 85px!important;">+ Προσθήκη</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($products))
                    @foreach($products as $product)

                        <tr class="product-line {{$product->storage->quantity > 0 ? 'active' : 'inactive'}}"
                        data-product-number="{{$product->product_number}}"
                        data-barcode="{{$product->barcode}}"
                        data-active="{{$product->storage->quantity > 0 ? 1 : 0}}"
                        data-name="{{toUpper($product->product_name)}}"
                        data-brand="{{mb_strtoupper($product->product_category)}}">
                            <td class="center-align"><input type="text" value="{{$product->barcode}}" name="barcode-{{$product->id}}" /></td>
                            <td class="center-align" style="font-size: 16px;font-weight: bold;">{{$product->product_number}}</td>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_category}}</td>
                            <td class="center-align" style="color:{{$product->storage->quantity > 0 ? '#60d360' : '#f36767'}}">{{$product->storage->quantity ?? 0}}</td>
                            <td class="center-align">{{countHolded($product->holds) ?? 0}}</td>
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
            $a('input[name="search"]').on('keyup', function(){
                let searchTerm = $a(this).val().toUpperCase();
                console.log(searchTerm);
                let status = $a('input[name="status"]:checked').val();
                if(searchTerm.length > 2) {
                    let status = $a('input[name="status"]:checked').val();
                    $a('tr.product-line').hide(400);
                    if(status === 'all') {
                        $a('tr.product-line[data-name*="'+searchTerm+'"]').show(400);
                        $a('tr.product-line[data-product-number*="'+searchTerm+'"]').show(400);
                        $a('tr.product-line[data-barcode*="'+searchTerm+'"]').show(400);
                        $a('tr.product-line[data-brand*="'+searchTerm+'"]').show(400);
                    } else {
                        $a('tr.product-line[data-name*="'+searchTerm+'"][data-active="'+status+'"]').show(400);
                        $a('tr.product-line[data-product-number*="'+searchTerm+'"][data-active="'+status+'"]').show(400);
                        $a('tr.product-line[data-barcode*="'+searchTerm+'"][data-active="'+status+'"]').show(400);
                        $a('tr.product-line[data-brand*="'+searchTerm+'"][data-active="'+status+'"]').show(400);
                    }

                } else {
                    if(status === 'all') {
                        $a('tr.product-line').show(400);
                    } else {
                        $a('tr.product-line[data-active="' + status + '"]').show(400);
                    }
                }
            });
            $a('input[name="status"]').on('change', function(){
               let status = $a(this).val();
                $a('input[name="search"]').val('');
                if(status === 'all') {
                   $a('tr.product-line').show(400);
               } else {
                    $a('tr.product-line').hide(400);
                   $a('tr.product-line[data-active="' + status + '"]').show(400);
               }

            });
        });

    </script>
@endsection
