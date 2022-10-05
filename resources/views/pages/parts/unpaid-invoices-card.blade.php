<div class="col s12 m12 l6 card">
    <ul id="unpaids-collection" class="collection animate fadeRight" style="border:none">
        <li class="collection-item avatar">
            <div class="total-unpaid right">Συνολικό Ανεξόφλητο<br />
                <h5 id="unpaid" class="display-flex right no-margin">
                    <span class="sign red-text strong">&euro;</span>
                    <span class="price red-text strong"></span>
                </h5>
            </div>
            <i class="material-icons red accent-2 circle">healing</i>
            <h6 class="collection-header m-0">Ανεξόλητες Οφειλές</h6>
            <p>Τιμολόγια που δεν έχουν ακόμα εξοφληθεί</p>
        </li>
        @foreach($unpaid as $un)
        <li class="collection-item unpaid-invoice" data-price="{{getFinalPrices($un->invoiceID)}}">
            <div class="row display-flex align-items-center">
                <div class="col s2 center"><strong>&euro; {{getFinalPrices($un->invoiceID)}}</strong></div>
                <div class="col s7">
                    <p class="collections-title"><strong>m{{str_pad($un->invoiceID, 4, '0', STR_PAD_LEFT)}}</strong> <small>{{\Carbon\Carbon::createFromTimestamp(strtotime($un->date))->format('d/m/Y')}}</small></p>
                    <p class="collections-content">{{$un->client->company}}</p>
                </div>
                <div class="col s3" style="text-align: right">
                    @if($un->mark)
                        <a href="{{route('invoice.view', ['invoiceID' => $un->invoiceID])}}" class="invoice-action-view mr-4">
                            <i class="material-icons">remove_red_eye</i>
                        </a>
                        <a href="{{route('invoice.download', $un->hashID)}}" class="invoice-action-view mr-4">
                            <i class="material-icons">cloud_download</i>
                        </a>
                    @else
                        <a href="{{route('invoice.view', ['invoiceID' => $un->invoiceID])}}" class="invoice-action-view mr-4">
                            <i class="material-icons">remove_red_eye</i>
                        </a>
                        <a href="{{route('invoice.edit', $un)}}" class="invoice-action-edit">
                            <i class="material-icons">edit</i>
                        </a>
                        <a href="{{route('invoice.delete', ['invoice' => $un->hashID])}}" class="invoice-action-edit">
                            <i class="material-icons">delete</i>
                        </a>
                    @endif

                </div>

            </div>
        </li>
        @endforeach
    </ul>
</div>
@section('panel-scripts')

@endsection
