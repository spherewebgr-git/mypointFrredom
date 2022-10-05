<?php

namespace App\Http\Controllers;

use App\Models\Outcomes;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OutcomesController extends Controller
{
    public function index()
    {
        $outcomes = Outcomes::query()->where('date', '>=', date('Y') . '-01-01')->get()->sortByDesc('date');

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
        return view('outcomes.new');
    }

    public function store(Request $request)
    {

        $requestDate = DateTime::createFromFormat('d/m/Y', $request->date);

        $date = $requestDate->format('Y-m-d');

        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

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
                'vat' => $request->vat,
                'file' => $name
            )
        );
        return redirect()->route('outcome.list')->with('notify', 'Το παραστατικό καταχωρήθηκε με επιτυχία');
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

        $outcomes = Outcomes::query()->where('date', '>=', $from)->where('date', '<=', $to)->get()->sortByDesc('date');
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
        return view('outcomes.new', ['outcome' => $outcome]);
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
            'vat' => $request->vat,
            'file' => $name
        ]);

        return redirect()->route('outcome.list')->with('notify', 'Το παραστατικό ενημερώθηκε');
    }
}
