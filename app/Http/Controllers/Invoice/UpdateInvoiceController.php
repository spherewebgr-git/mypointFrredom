<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UpdateInvoiceController extends Controller
{
    public function updateStatus(Request $request, Invoice $invoice) {
        if($request->paid == 'on') {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $invoice->save();

        Session::flash('notify', 'Το τιμολόγιο ενημερώθηκε με επιτυχία');
        return back();
    }
}
