<div class="mail-theme" style="background-color: #f9f9f9; color: #151e27;font-family: 'Open Sans', Calibri, Arial, sans-serif;padding: 20px 25px;">
    <img src="{{URL::to('/')}}/images/system/{{$settings['invoice_logo']}}" alt="logo" style="margin: 1em auto 3em auto;display: block;" />
    <p style="text-align: center;max-width: 550px;margin: 1em auto;font-size: 15px;">Σας ενημερώνουμε ότι σύντομα λήγει η περίοδος παροχής της υπηρεσίας <strong>"{{$service}}"</strong>
        για το domain <strong>{{$domain}}</strong>.</p>
    <p style="text-align: center;max-width: 550px;margin: 1em auto;font-size: 15px;">Για την αποφυγή διακοπής της υπηρεσίας σας, παρακαλώ εξοφλήστε τη συνδρομή σας εώς και <strong>{{$date}}</strong>.</p>

    <table style="width: 100%;max-width: 800px;margin: 2em auto;">
        <tr>
            <th style="background-color: <?php echo $settings['invoice_color']; ?>;color: #fff;padding: 4px;width: 160px;font-size: 14px;">Περίοδος Χρέωσης</th>
            <th style="background-color: <?php echo $settings['invoice_color']; ?>;color: #fff;padding: 4px;text-align: left;font-size: 14px;">Περιγραφή</th>
            <th style="background-color: <?php echo $settings['invoice_color']; ?>;color: #fff;padding: 4px;font-size: 14px;">Τιμή</th>
            <th style="background-color: <?php echo $settings['invoice_color']; ?>;color: #fff;padding: 4px;font-size: 14px;">Φ.Π.Α</th>
            <th style="background-color: <?php echo $settings['invoice_color']; ?>;color: #fff;padding: 4px;font-size: 14px;">Τελική τιμή</th>
        </tr>
        <tr>
            <td style="background-color: #fff;padding: 4px;text-align: center;font-size: 14px;">ανά {{notificationName($duration)}}</td>
            <td style="background-color: #fff;padding: 4px;font-size: 14px;">{{$service}}</td>
            <td style="background-color: #fff;padding: 4px;text-align: center;font-size: 14px;"><strong>&euro; {{number_format($cost, 2)}}</strong></td>
            <td style="background-color: #fff;padding: 4px;text-align: center;font-size: 14px;"><strong>&euro; {{number_format($vat, 2)}}</strong></td>
            <td style="background-color: #fff;padding: 4px;text-align: center;font-size: 17px;"><strong>&euro; {{number_format(($cost + $vat), 2)}}</strong></td>
        </tr>
    </table>
    <h2 style="font-size: 18px;text-align: center;border-bottom: thin solid #000;padding-bottom: 7px;margin: 70px 10% 35px 10%;">Τρόποι Πληρωμής</h2>
    <div style="text-align: center; font-size: 15px;">{!! $settings['payment_methods'] !!}</div>
    <p style="margin: 30px 0;text-align: center;font-size: 20px;font-weight: bold">- ή -</p>
    <p style="text-align: center;margin-bottom: 25px;">για άμεση ανανέωση...</p>
    <p style="text-align: center">
        <a href="#" style="background: #000;color: #fff;text-decoration: none;font-size: 14px;font-weight: 600;padding: 10px 20px;border-radius: 6px;">ΣΥΝΔΕΘΕΙΤΕ &amp; ΠΛΗΡΩΣΤΕ ΜΕ ΚΑΡΤΑ</a>
    </p>
    <p style="text-align: center;margin-top: 80px;">Ευχαριστούμε!</p>
    <p style="text-align: center;font-style: italic;margin-top: 0;">
        {{$settings['title']}} - {{$settings['company']}}<br />
        {{$settings['business']}}<br />
        {{$settings['address_0_edra']}}<br />
        <strong>Τηλ: </strong>{{$settings['mobile']}}<br />
        <a href="//{{$settings['website']}}" target="_blank">{{$settings['website']}}</a>
    </p>

</div>
