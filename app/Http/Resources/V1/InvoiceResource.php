<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'seira' => $this->seira,
            'invoiceID' => $this->invoiceID,
            'date' => $this->date,
            'paymentMethod' => getPaymentMethodName($this->payment_method),
            'client' => [
                'name' => $this->client->name,
                'company' => $this->client->company,
                'workTitle' => $this->client->work_title,
                'email' => $this->client->email,
                'phone' => $this->client->phone,
                'vat' => $this->client->vat,
                'doy' => $this->client->doy,
                'hasParakratisi' => (bool)$this->has_parakratisi,
                'parakratisiId' => $this->parakratisi_id
            ],
            'servicesLines' => $this->services,
            'invoicePrices' => [
                'final' => number_format(getFinalPrices($this->hashID, 'invoice'), '2', ',', '.'),
                'fpa' => number_format(((24 / 100) * getFinalPrices($this->hashID, 'invoice')), '2', ',', '.'),
                'total' => number_format(getFinalPrices($this->hashID, 'invoice') + ((24 / 100) * getFinalPrices($this->hashID, 'invoice')), '2', ',', '.')
            ]
        ];
    }
}
