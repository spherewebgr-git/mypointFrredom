<?php

namespace App\Http\Controllers;

use App\Models\Seires;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        $seires = [];
        $settings = [];
        $allSettings = Settings::all();
        $admin = User::all()[0];
        $allSeires = Seires::all();
        foreach($allSeires as $seira) {
            $seires[$seira->type][] = ['letter' => $seira->letter, 'id' => $seira->id];
        }
        foreach($allSettings as $set) {
            $settings[$set->type] = $set->value;
        }

        return view('settings.index', ['settings' => $settings, 'admin' => $admin, 'seires' => $seires]);
    }

    public function update(Request $request, $form) {
        //dd($request);
        //$settings = Settings::all()[0];
        $admin = User::all()->first();
        $requests = $request->all();

        if($form != 'seires') {
            foreach ($requests as $key => $item) {
                if($key != '_token' && $key != 'file' && $item != null) {
                    $setting = Settings::query()->where('type', '=', $key)->first();
                    if($setting) {
                        $setting->update([
                            'value' => $item
                        ]);
                    } else {
                        DB::table('settings')->insert([
                            'type' => $key,
                            'value' => $item,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
        }
        if($form == 'general') {
            if ($request->file('file')) {
                $name = str_replace([' ', '/', '\\'], '_', $request->file('file')->getClientOriginalName());
                $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'images' . DIRECTORY_SEPARATOR . 'system');
                $request->file('file')->storeAs($path, $name, ['disk' => 'public_folder']);
            }
            $admin->update([
                'name' => $request->name
            ]);
        } elseif($form == 'invoices') {
            $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'images' . DIRECTORY_SEPARATOR . 'system');
            if ($request->file('invoice_file')) {
                $invoice_file_name = str_replace([' ', '/', '\\'], '_', $request->file('invoice_file')->getClientOriginalName());
                $request->file('invoice_file')->storeAs($path, $invoice_file_name, ['disk' => 'public_folder']);
            }
            if ($request->file('signature_file')) {
                $signature_file_name = str_replace([' ', '/', '\\'], '_', $request->file('signature_file')->getClientOriginalName());
                $request->file('signature_file')->storeAs($path, $signature_file_name , ['disk' => 'public_folder']);
            }
        } elseif($form == 'seires') {
            DB::table('seires')->insert([
                'letter' => $request->seira,
                'type' => $request->seiraType
            ]);
        }

        return redirect()->back();
    }
}
