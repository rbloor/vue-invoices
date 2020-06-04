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
            'status' => ['required', 'in:draft,sent,paid,overdue'],
            'client_id' => ['required', 'numeric', 'exists:clients,id']
        ]);

        $invoice = Invoice::create([
            'status' => $request->status,
            'client_id' => $request->client_id,
        ]);
        
        // generate next invoice reference
        $invoice->reference = str_pad($invoice->id + 1, 8, "0", STR_PAD_LEFT);

        // save new transactions
        foreach ($request->transactions as $transaction) {
            $invoice->transactions()->save(new Transaction($transaction));
        }

        // save invoice
        $invoice->save();

        return new InvoiceResource($invoice);
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
            'status' => ['required', 'in:draft,sent,paid,overdue'],
            'client_id' => ['required', 'numeric', 'exists:clients,id']
        ]);

        $invoice = Invoice::findOrFail($id);

        foreach ($request->transactions as $transaction) {
            if (isset($transaction['id'])) {
                Transaction::findOrFail($transaction['id'])->update($transaction);
            } else {
                $invoice->transactions()->save(new Transaction($transaction));
            }
        }

        $invoice->update($request->all());

        return new InvoiceResource($invoice);
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
