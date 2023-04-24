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
    <div class="breadcrumbs-light pb-0 pt-4" id="breadcrumbs-wrapper">
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
            <form class="form" @if(isset($product)) action="{{route('products.update')}}" @else action="{{route('products.store')}}" @endif method="post" enctype="multipart/form-data">
                @csrf
                <div class="col xl9 m8 s12">
                    @if(isset($product))
                        <input type="hidden" name="product_id" value="{{$product['id']}}" />
                    @endif
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
                                <div class="col s6 m2">
                                    <div class="input-field">
                                        <input type="text" id="product_number" name="product_number" @if(isset($product)) value="{{$product['product_number']}}" @endif required>
                                        <label for="product_number">Κωδικός Προϊόντος *</label>
                                    </div>
                                </div>
                                <div class="col s6 m2">
                                    <div class="input-field">
                                        <input type="text" id="woocommerce_id" name="woocommerce_id" @if(isset($product)) value="{{$product['woocommerce_id']}}" @endif>
                                        <label for="woocommerce_id">Woocommerce ID </label>
                                    </div>
                                </div>
                                <div class="col s6 m2">
                                    @if(isset($product))
                                        <div class="product-storage">
                                            <div class="product-storage--label">Απόθεμα</div>
                                            <div class="product-storage--quantity">{{$product->storage->quantity}}</div>
                                        </div>
                                    @else
                                        <div class="input-field">
                                            <input type="number" id="quantity" name="quantity"  required>
                                            <label for="quantity">Ποσότητα *</label>
                                        </div>
                                    @endif
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
                                            <option value="Χωρίς Κατηγορία" @if(isset($product) && $product->product_category === 'Χωρίς Κατηγορία') selected @endif >Χωρίς Κατηγορία</option>
                                            <option value="Le farine dei nostri sacchi" @if(isset($product) && $product->product_category === 'Le farine dei nostri sacchi') selected @endif >Le farine dei nostri sacchi</option>
                                            <option value="Natisani" @if(isset($product) && $product->product_category === 'Natisani') selected @endif >Natisani</option>
                                            <option value="Jukeros" @if(isset($product) && $product->product_category === 'Jukeros') selected @endif >Jukeros</option>
                                            <option value="foodNess" @if(isset($product) && $product->product_category === 'foodNess') selected @endif >foodNess</option>
                                            <option value="Nutorious" @if(isset($product) && $product->product_category === 'Nutorious') selected @endif >Nutorious</option>
                                            <option value="Spigabuona" @if(isset($product) && $product->product_category === 'Spigabuona') selected @endif >Spigabuona</option>
                                            <option value="Stayia farm" @if(isset($product) && $product->product_category === 'Stayia farm') selected @endif >Stayia farm</option>
                                        </select>
                                        <label for="product_category">Κατηγορία</label>
                                    </div>
                                </div>
                                <div class="col s12 m3">
                                    <div class="input-field">
                                        <i class="material-icons prefix">local_grocery_store</i>
                                        <select name="mm_type" id="mm_type">
                                            <option value="" disabled>Επιλέξτε Μονάδα Μέτρησης</option>
                                            <option value="101" @if(isset($product) && $product->mm_type == 101) selected @endif >Τεμάχιο</option>
                                            <option value="107" @if(isset($product) && $product->mm_type == 107) selected @endif >Κιβώτιο</option>
                                            <option value="120" @if(isset($product) && $product->mm_type == 120) selected @endif >Μέτρο</option>
                                            <option value="141" @if(isset($product) && $product->mm_type == 141) selected @endif >Λίτρο</option>
                                            <option value="150" @if(isset($product) && $product->mm_type == 150) selected @endif >Κιλό</option>
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
                                            <option value="2" data-val="13" @if(isset($product) && $product->product_vat_id == 2) selected @endif >13%</option>
                                            <option value="3" data-val="6" @if(isset($product) && $product->product_vat_id == 3) selected @endif >6%</option>
                                            <option value="4" data-val="17" @if(isset($product) && $product->product_vat_id == 4) selected @endif >17%</option>
                                            <option value="5" data-val="9" @if(isset($product) && $product->product_vat_id == 5) selected @endif >9%</option>
                                            <option value="5" data-val="4" @if(isset($product) && $product->product_vat_id == 6) selected @endif >4%</option>
                                            <option value="7" data-val="0" @if(isset($product) && $product->product_vat_id == 7) selected @endif >0%</option>
                                            <option value="8" data-val="0" @if(isset($product) && $product->product_vat_id == 8) selected @endif >-</option>
                                        </select>
                                        <label for="product_vat_id">Κατηγορία ΦΠΑ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">euro_symbol</i>
                                        <input type="text" id="price" name="price" @if(isset($product)) value="{{$product->price}}" @endif required>
                                        <label for="price">Τιμή Λιανικής *</label>
                                    </div>
                                </div>
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">loupe</i>
                                        <input type="text" id="vat_price" name="vat_price" @if(isset($product)) value="{{$product->vat_price}}" @endif required>
                                        <label for="vat_price">Φ.Π.Α. *</label>
                                    </div>
                                </div>
                                <div class="col s12 m4">
                                    <div class="input-field">
                                        <i class="material-icons prefix">card_giftcard</i>
                                        <input type="text" id="discount_price" name="discount_price" @if(isset($product)) value="{{$product->discount_price}}" @endif>
                                        <label for="discount_price">Ποσοστό Έκπτωσης</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col s12 m10">
                                    <div class="input-field">
                                        <i class="material-icons prefix">description</i>
                                        <textarea id="product_description" name="product_description" class="materialize-textarea"> @if(isset($product)) {{$product->product_description}} @endif </textarea>
                                        <label for="product_description">Περιγραφή Προϊόντος</label>
                                    </div>
                                </div>
                                <div class="col s12 m2">
                                    <div class="input-field">
                                        <div class="switch">
                                            <label>
                                                Ανενεργό
                                                <input type="checkbox" name="active" @if(isset($product) && $product->active == 1) checked @endif>
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
                    <h6 style="margin-top: -20px">Εικόνα Προϊόντος</h6>
                    <div class="input-field product-image">
                        <input type="file" name="image" data-max-file-size="3M" data-show-errors="true" data-allowed-file-extensions="png jpg JPG JPEG"
                               class="img-field dropify" @if( isset($product) && $product->product_image != NULL )  data-default-file="{{url('images/products/'.$product->product_image)}}" @endif
                               value="" />
                    </div>
                    <div class="get-from-shop">
                        <a href="#" class="btn">Get Image from Shop</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="ajax-preloader">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
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
                  let vatValue = price * (vat / 100);
                  $p('label[for="vat_price"]').addClass('active');
                  $p('input#vat_price').val(custom_number_format(vatValue, 2, '.'));
                  console.log(vatValue)
              }
           });
            @if(isset($product))
                $p('.get-from-shop a').on('click', function(e){
                    e.preventDefault();
                    $p('.ajax-preloader').addClass('active');

                    let pageToken = $p('meta[name="csrf-token"]').attr('content');

                    $p.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': pageToken
                        }
                    });

                    $p.ajax({
                        url: "{{ url('/get-product-image/'.$product->woocommerce_id) }}",
                        method: 'get',

                        success: function (result) {
                            console.log(result);
                            $p('.ajax-preloader').removeClass('active');
                            location.href='/products';
                        }
                    });

                })
            @endif
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
