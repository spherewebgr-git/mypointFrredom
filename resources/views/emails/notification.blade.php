<div class="mail-theme" style="background-color: #f9f9f9; color: #151e27;font-family: 'Open Sans', Calibri, Arial, sans-serif;padding: 20px 25px;">
    <img src="{{URL::to('/')}}/images/system/tim-logo.png" alt="logo" style="margin: 1em auto 3em auto;display: block;" />
    <p style="text-align: center">Σας ενημερώνουμε ότι έχει εκδοθεί νέο τιμολόγιο ({{$invoice}}) για τις παρακάτω υπηρεσίες:</p>

    <table style="width: 100%;max-width: 800px;margin: 2em auto;">
        <tr>
            <th style="background-color: #f04727;color: #fff;padding: 4px;width: 75px;">Ποσότητα</th>
            <th style="background-color: #f04727;color: #fff;padding: 4px;text-align: left">Περιγραφή</th>
            <th style="background-color: #f04727;color: #fff;padding: 4px;">Τελική τιμή</th>
        </tr>
        @foreach($services as $service)
            <tr>
                <td style="background-color: #fff;padding: 4px;text-align: center">{{$service['quantity']}}</td>
                <td style="background-color: #fff;padding: 4px;">{{$service['description']}}</td>
                <td style="background-color: #fff;padding: 4px;text-align: center"><strong>&euro; {{$service['quantity'] * $service['price']}}</strong></td>
            </tr>
        @endforeach
    </table>
    <p style="text-align: center">Το τιμολόγιο επισυνάπτεται σε ηλεκτρονική μορφή και εντός μια εργάσιμης θα αποσταλλεί και ταχυδρομικά.</p>
    <p style="text-align: center">Ευχαριστούμε!</p>
    <p style="text-align: center;font-style: italic;margin-top: 100px;">{{$title}}</p>
</div>

