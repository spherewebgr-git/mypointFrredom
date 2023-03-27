<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Filters\V1\invoicesFilter;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $filter = new invoicesFilter();
        $queryItems = $filter->transform($request);

        //dd($request);

        if(count($queryItems) == 0) {
            return new InvoiceCollection(Invoice::all());
        } else {
            return new InvoiceCollection(Invoice::where($queryItems)->get());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {
        return new InvoiceResource(Invoice::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return InvoiceResource
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
