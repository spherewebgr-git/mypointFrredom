<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::all()[0];
        $admin = User::all()[0];

        return view('settings.index', ['settings' => $settings, 'admin' => $admin]);
    }

    public function update(Request $request, $form) {
        $settings = Settings::all()[0];
        $admin = User::all()->first();
        if($form == 'general') {
            if ($request->file('file')) {
                $name = str_replace([' ', '/', '\\'], '_', $request->file('file')->getClientOriginalName());
                $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'images' . DIRECTORY_SEPARATOR . 'system');
                $request->file('file')->storeAs($path, $name, ['disk' => 'public_folder']);
            } else {
                $name = $request->logo;
            }
            $admin->update([
                'name' => $request->name
            ]);
            $settings->update([
                'logo' => $name,
                'phone' => $request->phone,
                'mobile' => $request->mobile
            ]);
        } elseif($form == 'invoices') {
            $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, 'images' . DIRECTORY_SEPARATOR . 'system');
            if ($request->file('invoice_file')) {
                $invoice_file_name = str_replace([' ', '/', '\\'], '_', $request->file('invoice_file')->getClientOriginalName());
                $request->file('invoice_file')->storeAs($path, $invoice_file_name, ['disk' => 'public_folder']);
            } else {
                $invoice_file_name = $request->invoice_logo;
            }
            if ($request->file('signature_file')) {
                $signature_file_name = str_replace([' ', '/', '\\'], '_', $request->file('signature_file')->getClientOriginalName());
                $request->file('signature_file')->storeAs($path, $signature_file_name , ['disk' => 'public_folder']);
            } else {
                $signature_file_name = $request->signature;
            }
            $settings->update([
                'invoice_logo' => $invoice_file_name,
                'signature' => $signature_file_name,

            ]);
        } elseif($form == 'info') {
            $settings->update([
                'company' => $request->company,
                'title' => $request->title,
                'business' => $request->business,
                'address' => $request->address,
                'vat' => $request->vat,
                'doy' => $request->doy
            ]);
        } elseif($form == 'mydata') {
            $settings->update([
                'aade_user_id' => $request->aade_user_id,
                'ocp_apim_subscription_key' => $request->ocp_apim_subscription_key
            ]);
        }

        return redirect()->back();
    }
}
