<?php

namespace App\Http\Controllers\Outcomes;

use App\Http\Controllers\Controller;
use App\Models\Outcomes;
use App\Models\Provider;
use App\Models\RetailClassification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MyDataController extends Controller
{
    public function requestDocs() {
        $expenses = myDataRequestMyExpenses();
        //dd($expenses);
        foreach ($expenses as $expense) {
            //dd(DB::table('outcomes')->where('shop', '=', $expense->counterVatNumber)->where('date', '=', $expense->issueDate)->where('price', '=', $expense->netValue)->get());

            if(!DB::table('outcomes')->where('shop', '=', $expense->counterVatNumber)->where('date', '=', $expense->issueDate)->where('price', '=', $expense->netValue)) {
                DB::table('outcomes')->insert(
                    array(
                        'hashID' => Str::substr(Str::slug(Hash::make($expense->counterVatNumber . $expense->minMark)), 0, 32),
                        'outcome_number' => '',
                        'shop' => $expense->counterVatNumber,
                        'date' => $expense->issueDate,
                        'price' => $expense->netValue,
                        'vat' => $expense->vatAmount,
                        'invType' => $expense->invType,
                        'minMark' => $expense->minMark,
                        'maxMark' => $expense->maxMark,
                        'file' => ''
                    )
                );
            }
            if(DB::table('outcomes')->where('minMark', '=', 'NULL')->where('shop', '=', $expense->counterVatNumber)->where('date', '=', $expense->issueDate)->where('price', '=', $expense->netValue)) {
                DB::table('outcomes')->update([
                    'invType' => $expense->invType,
                    'minMark' => $expense->minMark,
                    'maxMark' => $expense->maxMark
                ]);
            }
        }

        return redirect('/outcomes');
    }

    public function sendClassifications(Request $request, $hashID) {

        $outcome = Outcomes::query()->where('hashID', '=', $hashID)->first();
        $hash = Str::substr(Str::slug(Hash::make($outcome->shop . Carbon::now())), 0, 32);
        $classifications = $request['group-a'];
        //dd($classifications);

        $classificationsPrice = [];
        if(isset($classifications)) {
            foreach($classifications as $classification) {
                if(isset($classification['price'])) {
                    $classificationsPrice[] = $classification['price'];
                    DB::table('retail_classifications')->insert(
                        array(
                            'hashID' => $hash,
                            'outcome_hash' => $hashID,
                            'classification_category' => $classification['classification_category'],
                            'classification_type' => $classification['classification_type'],
                            'date' => date('Y-m-d'),
                            'price' => $classification['price'],
                            'vat' => $classification['tax'],
                            'vat_amount' => $classification['vat_amount'],
                            'vat_excemption_category' => 0
                        )
                    );
                }
            }
        } elseif(isset($request->price)){
            $classificationsPrice[] = $request->price;
            DB::table('retail_classifications')->insert(
                array(
                    'hashID' => $hash,
                    'outcome_hash' => $hashID,
                    'classification_category' => $request->classification_category,
                    'classification_type' => $request->classification_type,
                    'date' => date('Y-m-d'),
                    'price' => $request->price,
                    'vat' => $request->tax,
                )
            );
        }

        $sumClass = array_sum($classificationsPrice);

        if($outcome->price = $sumClass) {
            $outcome->status = 'crosschecked';
            $outcome->save();

            Session::flash('message', 'Το παραστατικό χαρακτηρίστηκε με επιτυχία');
        } else {
            Session::flash('message', 'Οι χαρακτηρισμοί αποθηκεύτηκαν με επιτυχία');
        }

        return back();
    }

    public function sendClassificationsMyData(Request $request) {
        //dd($request);
        $theOutcome = Outcomes::query()->where('hashID', '=', $request->outcome_hash)->first();
        //dd($theOutcome->invType);
        switch(true) {
            case isset($request->deviation) && $request->deviation == 'on':
                $an = myDataSendInvoiceDeviation($theOutcome->hashID);
                break;
            case $theOutcome->mark !== null: // Αν έχει mark, δλδ έχει έρθει από την εφορία
                $an = myDataSendExpensesClassification($theOutcome->hashID);
                break;
            case $theOutcome->invType === '14.30': // Αν είναι τηλεφωνία - ενέργεια - ΔΕΚΟ
                $an = myDataSendDeko($theOutcome->hashID);
                break;
            case $theOutcome->invType === '14.5': // Αν είναι ΕΦΚΑ
                $an = myDataSendEfka($theOutcome->hashID);
                break;
            case $theOutcome->invType === '14.3': // Αν είναι ενδοκοινοτικό
                $an = myDataSendExpensesIntracommunity($theOutcome->hashID);
                break;
            case $theOutcome->invType === '14.4': // Αν είναι παραστατικό τρίτης χώρας
                $an = myDataSendInvoiceThirdCountry($theOutcome->hashID);
                break;

        }

        //dd($an);
        $theClassification = RetailClassification::query()->where('outcome_hash', '=', $request->outcome_hash)->first();

        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
                "statusCode" => $aade->statusCode,
            );
            array_push($aadeResponse, $aadeObject);
        }
        //dd($xml->response);
        if($aadeResponse[0]['statusCode'] == 'Success') {
            $theOutcome->classified = 1;
            $theOutcome->status = 'classified';
            if(isset($xml->response->invoiceMark)) {
                $theOutcome->mark = $xml->response->invoiceMark;
            }
            $theOutcome->save();

            if(isset($xml->response->classificationMark)){
                $theClassification->mark = $xml->response->classificationMark;
                $theClassification->save();
            }
        } else {
$status = $xml->response['statusCode'];
//dd($xml->response[0]->statusCode->__toString());
            Session::flash('notify', $xml->response[0]->statusCode->__toString());
            foreach ($xml->response->errors as $error) {
                //dd();
                Session::flash('error', $error->error->message->__toString());
            }
            return redirect()->back();
        }

        return redirect('/outcomes');
    }

    public function updateClassifications(Request $request, $hashID) {

        $outcome = Outcomes::query()->where('hashID', '=', $hashID)->first();
//dd($request);
        $oldClassifications = $request['old'];
        $newClassifications = $request['group-a'];

        $newPrices = [];
        if($oldClassifications != null && count($oldClassifications) > 0) {
            foreach($oldClassifications as $old) {
                $newPrices[] = $old['price'];

                //dd($oldClass);
                DB::table('retail_classifications')->where('hashID', '=', $old['classificationHash'])->update([
                    'classification_category' => $old['classification_category'],
                    'classification_type' => $old['classification_type'],
                    'updated_at' => date('Y-m-d'),
                    'price' => $old['price'],
                    'vat' => $old['tax'],
                    'vat_amount' => $old['vat_amount'],
                    'vat_category' => $old['vat_category'],
                    'vat_excemption_category' => $old['vat_excemption_category'] ?? 0
                ]);
            }
        }

        if($newClassifications != null && count($newClassifications) > 0) {
            foreach($newClassifications as $classification) {
                $newPrices[] = $classification['price'];
                if(isset($classification['price'])) {
                    DB::table('retail_classifications')->insert(
                        array(
                            'hashID' => Str::substr(Str::slug(Hash::make($outcome->shop . Carbon::now())), 0, 32),
                            'outcome_hash' => $hashID,
                            'classification_category' => $classification['classification_category'],
                            'classification_type' => $classification['classification_type'],
                            'date' => date('Y-m-d'),
                            'price' => $classification['price'],
                            'vat' => $classification['tax'],
                            'vat_amount' => $classification['vat_amount'],
                            'vat_category' => $classification['vat_category'],
                            'vat_excemption_category' => $classification['vat_excemption_category'] ?? ''
                        )
                    );
                }

            }
        }

        $newPrice = array_sum($newPrices);
        if($newClassifications != null) {
            if($oldClassifications[0]['tax'] == 8 || $newClassifications[0]['tax'] == 8){
                $outcome->status = 'efka';
            } elseif($newPrice = $outcome->price) {
                $outcome->status = 'crosschecked';
            } elseif(!$outcome->minMark && $newPrice == $outcome->price) {
                $outcome->status = 'uncrosschecked';
            } else {
                $outcome->status = 'presaved';
            }
            $outcome->save();
        }



        Session::flash('message', 'Οι χαρακτηρίσμοί ενημερώθηκαν με επιτυχία');
        return back();
    }

    public function deleteClassification(Request $request) {
        DB::table('retail_classifications')->where('hashID', $request->classification)->delete();
        return 'success';
    }

    public function requestExpenses() {

        $getLast = Outcomes::all()->sortBy('mark')->last();
        $last = $getLast ? $getLast->mark : 0;
        //$lastID = $getLast->id;
        $lastProvider = Provider::all()->last();

        $expenses = myDataRequestDocs($last);

        foreach ($expenses as $expense) {
            //dd(DB::table('outcomes')->where('shop', '=', $expense->counterVatNumber)->where('date', '=', $expense->issueDate)->where('price', '=', $expense->netValue)->get());
            if($lastProvider) {
                $counter = $lastProvider->provider_id + 1;
            } else {
                $counter = 1000;
            }
            foreach ($expense as $ex) {
                //dd($ex);
                DB::table('outcomes')->insert(
                    array(
                        'hashID' => Str::substr(Str::slug(Hash::make($ex->counterVatNumber . $ex->mark)), 0, 32),
                        'seira' => $ex->invoiceHeader->series,
                        'outcome_number' => $ex->invoiceHeader->aa,
                        'shop' => $ex->issuer->vatNumber,
                        'date' => $ex->invoiceHeader->issueDate,
                        'price' => $ex->invoiceSummary->totalNetValue,
                        'vat' => $ex->invoiceSummary->totalVatAmount,
                        'invType' => $ex->invoiceHeader->invoiceType,
                        'mark' => $ex->mark,
                        'file' => ''
                    )
                );

                $issuer = Provider::query()->where('provider_vat', '=', $ex->issuer->vatNumber)->first();
                if(!$issuer) {
                    $shop = checkIssuerVatVies($ex->issuer->vatNumber);
                    if($shop) {
                        //dd($shop);
                        $provider = [];
                        if (str_contains($shop->name, '||')) {
                            $extractName = explode('||', $shop->name);
                            $provider['name'] = $extractName[1];
                        } else {
                            $provider['name'] = $shop->name;
                        }

                        $extractAddress = explode(' - ', $shop->address);
                        $provider['city'] = $extractAddress[1];
                        $output = preg_replace('!\s+!', ' ', $extractAddress[0]);
                        $extractRoad = explode(' ', $output);
                        if(is_numeric($extractRoad[1]) == 1) {
                            $provider['address'] = $extractRoad[0];
                            $provider['number'] = $extractRoad[1];
                            $provider['postal_code'] = $extractRoad[2];
                        } else {
                            $provider['address'] = $extractRoad[0].' '.$extractRoad[1];
                            $provider['number'] = $extractRoad[2];
                            $provider['postal_code'] = $extractRoad[3] ?? '';
                        }
                        DB::table('providers')->insert([
                            'provider_id' => $counter,
                            'provider_name' => $provider['name'],
                            'provider_vat' => $ex->issuer->vatNumber,
                            'provider_doy' => 'ΔΟΥ',
                            'address' => $provider['address'],
                            'address_number' => $provider['number'],
                            'address_tk' => $provider['postal_code'],
                            'city' => $provider['city']
                        ]);
                    } else {
                        DB::table('providers')->insert([
                            'provider_vat' => $ex->issuer->vatNumber,
                            'provider_name' => 'Εισάγετε Στοιχεία Προμηθευτή',
                            'provider_id' => $counter
                        ]);
                    }
                }
                $counter++;
            }


        }
        return redirect('/outcomes');
    }
}
