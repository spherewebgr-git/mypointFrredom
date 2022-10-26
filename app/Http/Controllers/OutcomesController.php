<?php

namespace App\Http\Controllers;

use App\Models\Outcomes;
use App\Models\Provider;
use App\Models\RetailClassification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use mysql_xdevapi\Table;

class OutcomesController extends Controller
{
    public function index()
    {

        $outcomes = Outcomes::query()->where('date', '>=', date('Y') . '-01-01')->whereNotNull('outcome_number')->get()->sortByDesc('date');

        $finalOutcome = [];
        $finalFpa = [];

        foreach ($outcomes as $outcome) {
            $finalOutcome[] = $outcome->price;
            $finalFpa[] = $outcome->vat;
        }

        $final = array_sum($finalOutcome);
        $fpa = array_sum($finalFpa);

        return view('outcomes.list', ['outcomes' => $outcomes, 'finals' => $final, 'fpa' => $fpa]);
    }

    public function new()
    {
        $providers = Provider::all();

        return view('outcomes.new', ['providers' => $providers]);
    }

    public function store(Request $request)
    {

        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);

        $date = $requestDate->format('Y-m-d');

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
//dd($request->price);
       // dd($year);
        if ($request->file('file')) {
            $name = str_replace([' ', '/', '\\'], '_', $request->file('file')->getClientOriginalName());
            $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'public' . DIRECTORY_SEPARATOR . 'outcomes' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month);
            File::ensureDirectoryExists(storage_path('app') . DIRECTORY_SEPARATOR . $path);
            $request->file('file')->storeAs($path, $name);
        } else {
            $name = '';
        }

        DB::table('outcomes')->insert(
            array(
                'hashID' => Str::substr(Str::slug(Hash::make($request->shop . $request->outcome_number)), 0, 32),
                'outcome_number' => $request->outcome_number,
                'shop' => $request->shop,
                'date' => $date,
                'price' => $request->price,
                'invType' => $request->invType,
                'vat' => $request->vat,
                'file' => $name,
                'status' => 'stored'
            )
        );
        return back()->with('notify', 'Το παραστατικό καταχωρήθηκε με επιτυχία');
    }

    public function download($hashID)
    {
        $outcome = Outcomes::query()->where('hashID', '=', $hashID)->first();
        $year = date('Y', strtotime($outcome->date));
        $month = date('m', strtotime($outcome->date));

        return response()->download(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'outcomes' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $outcome->file);
    }

    public function destroy($outcome)
    {
        $out = Outcomes::query()->where('hashID', '=', $outcome)->first();

        $out->delete();

        Session::flash('message', 'Το παραστατικό διαγράφηκε με επιτυχία');
        return Redirect::to('/outcomes');
    }

    public function filter(Request $request)
    {
       // dd($request);
        $fromDate = DateTime::createFromFormat('d/m/Y', $request['date-start']);
        $from = $fromDate->format('Y-m-d');
        $toDate = DateTime::createFromFormat('d/m/Y', $request['date-end']);
        $to = $toDate->format('Y-m-d');

        if(!isset($request->status)) {
            $outcomes = Outcomes::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortByDesc('date');
        } else {
            $query = DB::table('outcomes');
            $query->where('date', '>=', $from)->where('date', '<=', $to);
            if($request->status == 'uncrosschecked') {
                $query->where('minMark', '=', null)->where('status', '!=', 'efka');
            } else {
                $query->where('status', '=', $request->status);
                $query->orWhere('status', '=', 'efka');
            }
            $outcomes =$query->get()->sortByDesc('date');
        }

        $finalOutcome = [];
        $finalFpa = [];

        foreach ($outcomes as $outcome) {
            $finalOutcome[] = $outcome->price;
            $finalFpa[] = $outcome->vat;
        }

        $final = array_sum($finalOutcome);
        $fpa = array_sum($finalFpa);

        return view('outcomes.list', ['outcomes' => $outcomes, 'finals' => $final, 'fpa' => $fpa]);
    }

    public function edit(Outcomes $outcome)
    {
        $providers = Provider::all();
        $classPrices = [];
        $classifications = DB::table('retail_classifications')->where('outcome_hash','=', $outcome->hashID)->get();

        foreach($classifications as $class) {
            $classPrices[] = $class->price;
        }

        $currentPrice = array_sum($classPrices);

        //dd($classifications);
        return view('outcomes.new', ['outcome' => $outcome, 'providers' => $providers, 'classifications' => $classifications, 'classifiedPrice' => $currentPrice]);
    }

    public function update(Request $request, Outcomes $outcome)
    {

        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);
        if(!$requestDate) {
            $requestDate = DateTime::createFromFormat('Y-m-d', $request->date);
        }

        $date = $requestDate->format('Y-m-d');
        if ($request->file('file')) {
            $name = str_replace([' ', '/', '\\'], '_', $request->file('file')->getClientOriginalName());
            $year = date('Y', strtotime($request->date));
            $month = date('m', strtotime($request->date));
            $path = $request->file('file')->storeAs('public' . '/outcomes/' . $year . DIRECTORY_SEPARATOR . $month, $name);
        } else {
            $name = $outcome->file;
        }
        $outcome->update([
            'outcome_number' => $request->outcome_number,
            'shop' => $request->shop,
            'date' => $date,
            'price' => $request->price,
            'invType' => $request->invType,
            'vat' => $request->vat,
            'file' => $name
        ]);

        return back();
    }

    public function requestExpenses() {
        $expenses = myDataRequestMyExpenses();
        dd($expenses);
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

        $classifications = $request['group-a'];

        $classificationsPrice = [];

        foreach($classifications as $classification) {
            if(isset($classification['price'])) {
                $classificationsPrice[] = $classification['price'];
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
        $an = myDataSendExpensesClassification($request->outcome_hash);
        //dd($an);
        $theOutcome = Outcomes::query()->where('hashID', '=', $request->outcome_hash)->first();
        $aadeResponse = array();
        $xml = simplexml_load_string($an);
        foreach($xml->response as $aade) {
            $aadeObject = array(
//                "index" => $aade->firstname,
//                "invoiceUid" => $aade->invoiceUid,
//                "invoiceMark" => $aade->invoiceMark,
                "statusCode" => $aade->statusCode,
            );
            array_push($aadeResponse, $aadeObject);
        }
        dd($xml->response);
        if($aadeResponse[0]['statusCode'] == 'Success') {
            $theOutcome->classified = 1;
            $theOutcome->save();
        } else {
            dd($aadeResponse[0]['statusCode']);
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
}
