<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Transaction as TransactionResource;
use App\Http\Resources\Client as ClientResource;

class Invoice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'client' => new ClientResource($this->client),
            'status' => $this->status,
            'total' => $this->total,
            'transactions' => TransactionResource::collection($this->transactions)
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ];
    }
}
