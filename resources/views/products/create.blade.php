{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@if(isset($product))
    @section('title','Επεξεργασία Καταχώρησης Προϊόντος')
@else
    @section('title','Καταχώρηση Νέου Προϊόντος')
@endif

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dropify.min.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
        <!-- Search for small screen-->
        <div class="container">
            <div class="row">
                <div class="col s10 m6 l6">
                    <h5 class="breadcrumbs-title mt-0 mb-0">
                        @if(isset($product))
                            <span>Επεξεργασία Καταχώρησης Προϊόντος</span>
                        @else
                            <span>Καταχώρηση Νέου Προϊόντος</span>
                        @endif
                    </h5>
                </div>
                <div class="invoice-head--right row col s12 m6 display-flex justify-content-end align-items-center">
                </div>
            </div>
        </div>
    </div>
    <section class="invoice-edit-wrapper section">
        <div class="row">
            <!-- product add/edit page -->
            <form class="form" @if(isset($product)) action="/" @else action="{{route('products.store')}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                @dump($product)
                <div class="col xl9 m8 s12">
                    <div class="card">
                        <div class="card-content px-36">
                            <div class="progress" style="display: none">
                                <div class="indeterminate"></div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="row mb-2">
                                <div class="col s12 m6">
                                    <div class="input-field">
                                        <input type="text" id="product_name" name="product_name" @if(isset($product)) value="{{$product['product_name']}}" @endif required>
                                        <label for="product_name">Ονομασία Προϊόντος *</label>
                                    </div>
                                </div>
                                <div class="col s6 m4">
                                    <div class="input-field">
                                        <input type="text" id="product_number" name="product_number" @if(isset($product)) value="{{$product['product_number']}}" @endif required>
                                        <label for="product_number">Κωδικός Προϊόντος *</label>
                                    </div>
                                </div>
                                <div class="col s6 m2">
                                    <div class="input-field">
                                        <input type="number" id="quantity" name="quantity" @if(isset($product)) value="{{$product->storage->quantity}}" @endif required>
                                        <label for="quantity">Ποσότητα *</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">flip</i>
                                        <input type="text" id="barcode" name="barcode" @if(isset($product)) value="{{$product['barcode']}}" @endif >
                                        <label for="barcode">Barcode</label>
                                    </div>
                                </div>
                                <div class="col s12 m3">
                                    <div class="input-field">
                                        <i class="material-icons prefix">archive</i>
                                        <select name="product_category" id="product_category">
                                            <option value="" disabled>Επιλέξτε Κατηγορία</option>
                                            <option value="Κατηγορία 1" @if(isset($product) && $product->product_category == 'Κατηγορία 1') value="{{$product['product_number']}}" @endif >Κατηγορία 1</option>
                                            <option value="Κατηγορία 2">Κατηγορία 2</option>
                                            <option value="Κατηγορία 3">Κατηγορία 3</option>
                                            <option value="Κατηγορία 4">Κατηγορία 4</option>
                                        </select>
                                        <label for="product_category">Κατηγορία</label>
                                    </div>
                                </div>
                                <div class="col s12 m3">
                                    <div class="input-field">
                                        <i class="material-icons prefix">local_grocery_store</i>
                                        <select name="mm_type" id="mm_type">
                                            <option value="" disabled>Επιλέξτε Μονάδα Μέτρησης</option>
                                            <option value="101">Τεμάχιο</option>
                                            <option value="107">Κιβώτιο</option>
                                            <option value="120">Μέτρο</option>
                                            <option value="141">Λίτρο</option>
                                            <option value="150">Κιλό</option>
                                        </select>
                                        <label for="mm_type">Μονάδα Μέτρησης (ανά / )</label>
                                    </div>
                                </div>
                                <div class="col s12 m2">
                                    <div class="input-field">
                                        <i class="material-icons prefix">local_grocery_store</i>
                                        <select name="product_vat_id" id="product_vat_id">
                                            <option value="" disabled>Επιλέξτε ΦΠΑ</option>
                                            <option value="1" data-val="24" selected>24%</option>
                                            <option value="2" data-val="13">13%</option>
                                            <option value="3" data-val="6">6%</option>
                                            <option value="4" data-val="17">17%</option>
                                            <option value="5" data-val="9">9%</option>
                                            <option value="5" data-val="4">4%</option>
                                            <option value="7" data-val="0">0%</option>
                                            <option value="8" data-val="0">-</option>
                                        </select>
                                        <label for="product_vat_id">Κατηγορία ΦΠΑ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">euro_symbol</i>
                                        <input type="text" id="price" name="price" required>
                                        <label for="price">Τιμή Λιανικής *</label>
                                    </div>
                                </div>
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">loupe</i>
                                        <input type="text" id="vat_price" name="vat_price" required>
                                        <label for="vat_price">Φ.Π.Α. *</label>
                                    </div>
                                </div>
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">card_giftcard</i>
                                        <input type="text" id="discount_price" name="discount_price">
                                        <label for="discount_price">Ποσοστό Έκπτωσης</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col s12 m10">
                                    <div class="input-field">
                                        <i class="material-icons prefix">description</i>
                                        <textarea id="product_description" name="product_description" class="materialize-textarea"></textarea>
                                        <label for="product_description">Περιγραφή Προϊόντος</label>
                                    </div>
                                </div>
                                <div class="col s12 m2">
                                    <div class="input-field">
                                        <div class="switch">
                                            <label>
                                                Ανενεργό
                                                <input type="checkbox" name="active">
                                                <span class="lever"></span>
                                                Ενεργό
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="invoice-action-btn col s12 m4 right">
                                    @if(isset($product))
                                        <input type="submit" value="Ενημέρωση Προϊόντος" style="color: #fff;width: 100%;"
                                               class="btn display-flex align-items-center justify-content-center">
                                    @else
                                        <input type="submit" value="Καταχώρηση Νέου Προϊόντος" style="color: #fff;width: 100%;"
                                               class="btn display-flex align-items-center justify-content-center">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col xl3 m4 s12">
                    <h6 style="color: #fff;margin-top: -20px">Εικόνα Προϊόντος</h6>
                    <div class="input-field product-image">
                        <input type="file" name="image" data-max-file-size="3M" data-show-errors="true" data-allowed-file-extensions="png jpg JPG JPEG"
                               class="img-field dropify" value="">
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('page-script')
    <script src="{{asset('js/dropify.min.js')}}"></script>
    <script>
        $p = jQuery.noConflict();
        $p(document).ready(function(){
           $p('.dropify').dropify();

           $p('input#price').on('mouseout', function(){
              let price = $p(this).val();
              let vat = $p('select#product_vat_id option:selected').data('val');
              if(price > 0) {
                  //console.log(price, vat);
                  let vatValue = (price / (vat /100)) * price;
                  $p('label[for="vat_price"]').addClass('active');
                  $p('input#vat_price').val(custom_number_format(vatValue, 2, '.'));
                  console.log(vatValue)
              }
           });
        });

        function custom_number_format( number_input, decimals, dec_point, thousands_sep ) {
            var number       = ( number_input + '' ).replace( /[^0-9+\-Ee.]/g, '' );
            var finite_number   = !isFinite( +number ) ? 0 : +number;
            var finite_decimals = !isFinite( +decimals ) ? 0 : Math.abs( decimals );
            var seperater     = ( typeof thousands_sep === 'undefined' ) ? ',' : thousands_sep;
            var decimal_pont   = ( typeof dec_point === 'undefined' ) ? '.' : dec_point;
            var number_output   = '';
            var toFixedFix = function ( n, prec ) {
                if( ( '' + n ).indexOf( 'e' ) === -1 ) {
                    return +( Math.round( n + 'e+' + prec ) + 'e-' + prec );
                } else {
                    var arr = ( '' + n ).split( 'e' );
                    let sig = '';
                    if ( +arr[1] + prec > 0 ) {
                        sig = '+';
                    }
                    return ( +(Math.round( +arr[0] + 'e' + sig + ( +arr[1] + prec ) ) + 'e-' + prec ) ).toFixed( prec );
                }
            }
            number_output = ( finite_decimals ? toFixedFix( finite_number, finite_decimals ).toString() : '' + Math.round( finite_number ) ).split( '.' );
            if( number_output[0].length > 3 ) {
                number_output[0] = number_output[0].replace( /\B(?=(?:\d{3})+(?!\d))/g, seperater );
            }
            if( ( number_output[1] || '' ).length < finite_decimals ) {
                number_output[1] = number_output[1] || '';
                number_output[1] += new Array( finite_decimals - number_output[1].length + 1 ).join( '0' );
            }
            return number_output.join( decimal_pont );
        }
    </script>
@endsection
