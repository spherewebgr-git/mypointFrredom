{{-- extend Layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Στατιστικά Κίνησης')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <div class="section">
        @include('pages.parts.homepage-stats')
{{--        @include('pages.parts.chart-dashboard')--}}
        <!--work collections start-->
        <div id="work-collections">
            <div class="row">
{{--                @include('pages.parts.projects-card')--}}
{{--                @include('pages.parts.issues-card')--}}
                @include('pages.parts.homepage-tasks')
                @include('pages.parts.unpaid-invoices-card')
            </div>
        </div>
        <!--work collections end-->
        <!--card widgets start-->
        <div id="card-widgets">
            <div class="row">

                @include('pages.parts.card-weather')
                @include('pages.parts.card-company')
            </div>
        </div>
        <!--card widgets end-->
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('vendors/chartjs/chart.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/dashboard-analytics.js')}}"></script>
    <script>
        $c = jQuery.noConflict();
        $c(document).ready(function(){
            // Bar chart ( New Clients)
            $c("#clients-bar").sparkline([70, 80, 65, 78, 58, 80, 78, 80, 20, 50, 75, 65, 80, 70, 65, 90, 65, 80, 70, 65, 90], {
                type: "bar",
                height: "25",
                barWidth: 7,
                barSpacing: 4,
                barColor: "#b2ebf2",
                negBarColor: "#81d4fa",
                zeroColor: "#81d4fa"
            });
            $c('select').formSelect({
                'dropdown': 10
            });
        });
    </script>
    <script>
        $u = jQuery.noConflict();
        $u(document).ready(function(){
            let sum = 0;
            $u('.unpaid-invoice').each(function(){
                let price = $u(this).data('price');
                sum+=parseFloat(price) || 0;
            });
            $u('#unpaid .price').text(sum);
        });
    </script>
@endsection
