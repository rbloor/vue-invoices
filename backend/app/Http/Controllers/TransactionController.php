<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\Transaction as TransactionResource;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return TransactionResource::collection($transactions);
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
            'quantity' => ['required', 'numeric'],
            'unit' => ['required', 'in:hour,day,service,product'],
            'description' => ['required', 'string', 'max:255'],
            'unit_cost' => ['required', 'numeric'],
            'invoice_id' => ['required', 'numeric', 'exists:invoices,id']
        ]);

        return Transaction::create([
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
            'unit_cost' => $request->unit_cost,
            'invoice_id' => $request->invoice_id,
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
        $transaction = Transaction::findOrFail($id);
        return new TransactionResource($transaction);
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
            'quantity' => ['required', 'numeric'],
            'unit' => ['required', 'in:hour,day,service,product'],
            'description' => ['required', 'string', 'max:255'],
            'unit_cost' => ['required', 'numeric'],
            'invoice_id' => ['required', 'numeric', 'exists:invoices,id']
        ]);

        return Transaction::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Transaction::findOrFail($id)->delete();
    }
}
