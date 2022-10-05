{{-- extend Layout --}}
@extends('layouts.printRetailReceiptLayout')

{{-- page title --}}
@section('title','Εκτύπωση Απόδειξης Λιανικής')

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/print-retail-receipt.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <section class="print-retail-receipt-wrapper section">
        <div class="row retail-receipt">
            <div class="retail-receipt--head">
                <div class="retail-receipt--head---logo center mb-1">
                    <img src="{{asset('images/system/tim-logo.png')}}" alt="company logo" />
                </div>
                <div class="retail-receipt--head---info">
                    <h4 class="center">Απόδειξη Παροχής<br />Υπηρεσιών Λιανικής</h4>
                    <p class="center">
                        {{$settings->title}}<br />
                        {{$settings->company}}<br />
                        {{$settings->business}}<br />
                        {{$settings->address}}<br />
                        <small>ΑΦΜ. {{$settings->vat}} | ΔΟΥ. {{$settings->doy}}</small>
                    </p>
                </div>
            </div>
            <div class="retail-receipt--body">
                <h5>Στοιχεία Πώλησης</h5>
                <table>
                    <tr>
                        <td>Ημερομηνία</td>
                        <td class="right">{{\Carbon\Carbon::parse($retail->date)->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td>Ώρα</td>
                        <td class="right">{{\Carbon\Carbon::parse($retail->created_at)->format('H:i')}}</td>
                    </tr>
                    <tr>
                        <td>Αρ. Απόδειξης</td>
                        <td class="right">{{$retail->seira . ' '.  str_pad($retail->retailID, 4, '0', STR_PAD_LEFT)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Υπηρεσία</td>
                    </tr>
                </table>
                <h5>Παρεχόμενη Υπηρεσία</h5>
                <table>
                    <tr>
                        <td><p class="center">{{$retail->service }}</p></td>
                    </tr>
                </table>
                <h5>Ποσά</h5>
                <table>
                    <tr>
                        <td>Καθαρή Αξία</td>
                        <td class="right">&euro; {{  number_format( $retail->price - $retail->vat, 2, '.', '' )  }}</td>
                    </tr>
                     <tr>
                         <td>Αξία Φ.Π.Α. (24%)</td>
                         <td class="right">&euro; {{number_format($retail->vat, 2, '.', '') }}</td>
                     </tr>
                    <tr>
                        <td>Τελικό ποσό</td>
                        <td class="right">&euro; {{number_format($retail->price, 2, '.', '' )}}</td>
                    </tr>
                </table>
                @if(isset($retail->description))
                <h5>Περισσότερες Πληροφορίες</h5>
                <table>
                    <tr>
                        <td><p>{{$retail->description }}</p></td>
                    </tr>
                </table>
                @endif

            </div>
            <div class="retail-receipt--footer center">
                <div class="legal">***** Νόμιμη Απόδειξη *****</div>
                Ευχαριστούμε για την προτίμησή σας.
            </div>
        </div>
    </section>
@endsection
