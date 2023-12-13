<?php

namespace App\Http\Controllers;

use App\Models\ForeignProviders;
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

    public function selectYear($year) {
        $outcomes = Outcomes::query()->where( DB::raw('YEAR(date)'), '=', $year)->whereNotNull('outcome_number')->get()->sortBy('date');

        $finalOutcome = [];
        $finalFpa = [];

        foreach ($outcomes as $outcome) {
            $finalOutcome[] = $outcome->price;
            $finalFpa[] = $outcome->vat;
        }

        $final = array_sum($finalOutcome);
        $fpa = array_sum($finalFpa);

        return view('outcomes.list', ['outcomes' => $outcomes, 'finals' => $final, 'fpa' => $fpa, 'year' => $year]);
    }

    public function new()
    {
        $providers = Provider::all();
        $foreign = ForeignProviders::all();

        return view('outcomes.new', ['providers' => $providers, 'foreign' => $foreign]);
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
                'seira' => $request->seira,
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
        return redirect('/outcomes')->with('notify', 'Το παραστατικό καταχωρήθηκε με επιτυχία');
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
        $foreign = ForeignProviders::all();
        $classPrices = [];
        $classifications = DB::table('retail_classifications')->where('outcome_hash','=', $outcome->hashID)->get();

        foreach($classifications as $class) {
            $classPrices[] = $class->price;
        }

        $currentPrice = array_sum($classPrices);

        //dd($classifications);
        return view('outcomes.new', ['outcome' => $outcome, 'providers' => $providers, 'classifications' => $classifications, 'classifiedPrice' => $currentPrice, 'foreign' => $foreign]);
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
            'price' => $request->price,
            'seira' => $request->seira,
            'outcome_number' => $request->outcome_number,
            'invType' => $request->invType,
            'paymentMethod' => $request->paymentMethod,
            'vat' => $request->vat,
            'date' => $date,
            'file' => $name,
            'mark' => $request->mark
        ]);
        if($outcome->mark === null) {
            $outcome->update([
                'seira' => $request->seira,
                'invType' => $request->invType,
                'outcome_number' => $request->outcome_number,
                'shop' => $request->shop,
                'mark' => $request->mark
            ]);
        }

        Session::flash('notify', 'Το παραστατικό εξόδου ενημερώθηκε');

        return back();
    }

}
