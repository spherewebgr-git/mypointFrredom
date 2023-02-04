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

        switch(true) {
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

        $oldClassifications = $request['old'];
        $newClassifications = $request['group-a'];

        $newPrices = [];
        if($oldClassifications != null && count($oldClassifications) > 0) {
            foreach($oldClassifications as $old) {
                $newPrices[] = $old['price'];
                DB::table('retail_classifications')->where('hashID', '=', $old['classificationHash'])->update([
                    'classification_category' => $old['classification_category'],
                    'classification_type' => $old['classification_type'],
                    'updated_at' => date('Y-m-d'),
                    'price' => $old['price'],
                    'vat' => $old['tax']
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
            } elseif(!$outcome->minMark && $newPrice = $outcome->price) {
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
        $expenses = myDataRequestDocs($last);

        foreach ($expenses as $expense) {
            //dd(DB::table('outcomes')->where('shop', '=', $expense->counterVatNumber)->where('date', '=', $expense->issueDate)->where('price', '=', $expense->netValue)->get());
            $counter = 1000;
            foreach ($expense as $ex) {
                //dd($ex);
                DB::table('outcomes')->insert(
                    array(
                        'hashID' => Str::substr(Str::slug(Hash::make($ex->counterVatNumber . $ex->mark)), 0, 32),
                        'seira' => $ex->invoiceHeader->series,
                        'outcome_number' => $ex->invoiceHeader->aa,
                        'shop' => $ex->issuer->vatNumber,
                        'date' => $ex->invoiceHeader->issueDate,
                        'price' => $ex->invoiceDetails->netValue,
                        'vat' => $ex->invoiceDetails->vatAmount,
                        'invType' => $ex->invoiceHeader->invoiceType,
                        'mark' => $ex->mark,
                        'file' => ''
                    )
                );
                $issuer = Provider::query()->where('provider_vat', '=', $ex->issuer->vatNumber)->first();
                if(!$issuer) {
                    DB::table('providers')->insert([
                        'provider_vat' => $ex->issuer->vatNumber,
                        'provider_name' => 'Εισάγετε Στοιχεία Προμηθευτή',
                        'provider_id' => $counter
                    ]);
                }
                $counter++;
            }


        }

        return redirect('/outcomes');
    }
}
