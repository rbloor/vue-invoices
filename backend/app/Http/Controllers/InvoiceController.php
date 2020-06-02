<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\Invoice as InvoiceResource;
use App\Http\Resources\Transaction as TransactionResource;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return InvoiceResource::collection($invoices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference' => ['required', 'unique:invoices', 'max:16'],
            'is_sent' => ['boolean'],
            'is_paid' => ['boolean'],
            'client_id' => ['required', 'numeric', 'exists:clients,id']
        ]);

        return Invoice::create([
            'reference' => $request->reference,
            'is_sent' => $request->is_sent,
            'is_paid' => $request->is_paid,
            'client_id' => $request->client_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return new InvoiceResource($invoice);
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
        $request->validate([
            'reference' => ['required', 'unique:invoices,id,$id', 'max:16'],
            'is_sent' => ['boolean'],
            'is_paid' => ['boolean'],
            'client_id' => ['required', 'numeric', 'exists:clients,id']
        ]);

        return Invoice::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Invoice::findOrFail($id)->delete();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transactions($id)
    {
        $transactions = Transaction::where('invoice_id', $id)->get();
        return TransactionResource::collection($transactions);
    }
}
