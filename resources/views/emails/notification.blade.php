
<div class="mail-theme" style="background-color: #f9f9f9; color: #151e27;font-family: 'Open Sans', Calibri, Arial, sans-serif;padding: 20px 25px;">
    <img src="{{url('images/system/'.$settings['invoice_logo'])}}" alt="logo" style="margin: 1em auto 3em auto;display: block;" />
    <p style="text-align: center">Σας ενημερώνουμε ότι έχει εκδοθεί νέο τιμολόγιο ({{($invoice->seira !== 'ANEY') ? $invoice->seira :  ''}} {{$invoice->sale_invoiceID ?? $invoice->invoiceID}})
        @if(isset($services))για τις παρακάτω υπηρεσίες: @else . @endif</p>
    @if(isset($services))
    <table style="width: 100%;max-width: 800px;margin: 2em auto;">
        <tr>
            <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;width: 75px;">Ποσότητα</th>
            <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;text-align: left">Περιγραφή</th>
            <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;">Τιμή Μονάδας</th>
            <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;">ΦΠΑ</th>
            <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;">Σύνολο</th>
        </tr>
        @foreach($services as $service)
            <tr>
                <td style="background-color: #fff;padding: 4px;text-align: center">{{$service['quantity']}}</td>
                <td style="background-color: #fff;padding: 4px;">{{$service['description']}}</td>
                <td style="background-color: #fff;padding: 4px;text-align: center"><strong>&euro; {{number_format($service['price'], 2, ',', '.')}}</strong></td>
                <td style="background-color: #fff;padding: 4px;text-align: center"><strong>&euro; {{number_format($service['vat_amount'], 2, ',', '.')}}</strong></td>
                <td style="background-color: #fff;padding: 4px;text-align: center"><strong>&euro; {{number_format($service['price'] + $service['vat_amount'] * $service['quantity'], 2 ,',', '.')}}</strong></td>
            </tr>
        @endforeach
    </table>
    @else
        <h4 style="text-align: center; padding-bottom: 10px;border-bottom: thin solid {{$settings['invoice_color'] ?? '#f04727'}}">Προϊόντα στο Τιμολόγιο</h4>
        <table style="width: 100%;max-width: 800px;margin: 2em auto;font-size: 14px;">
            <tr>
                <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px 10px;text-align: left">Προϊόν</th>
                <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;width: 75px;">Ποσότητα (M/M)</th>
                <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;">Τιμή</th>
                <th style="background-color: {{$settings['invoice_color'] ?? '#f04727'}};color: #fff;padding: 4px;">ΦΠΑ</th>
            </tr>
            @foreach($invoice->deliveredGoods as $product)
            <tr>
                <td style="padding: 4px 10px">{{getProductByID($product->delivered_good_id)['product_name']}}</td>
                <td style="text-align: center;padding: 4px;">{{$product->quantity. ' ('. getMmType($product->delivered_good_id).')'}}</td>
                <td style="text-align: center;padding: 4px;">&euro; {{$product->product_price}}</td>
                <td style="text-align: center;padding: 4px;">&euro; {{$product->line_vat / $product->quantity}}</td>
            </tr>
            @endforeach
        </table>
    @endif
    <p style="text-align: center">Το τιμολόγιο επισυνάπτεται σε ηλεκτρονική μορφή.</p>
    <p style="text-align: center">Ευχαριστούμε!</p>
    <p style="text-align: center;font-style: italic;margin-top: 100px;">{{$title}}</p>
    @if(isset($settings['website']) && isset($settings['show_invoice_website']) && $settings['show_invoice_website'] == 'on')
    <p style="text-align: center;"><a href="{{$settings['website']}}">{{$settings['website']}}</a></p>
    @endif
</div>

