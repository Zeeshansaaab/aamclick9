<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GatewayResource extends JsonResource
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
            "id" => $this->id,
            "form_id" => $this->form_id,
            "name" => $this->name,
            "slug" => $this->slug,
            "image" => $this->image,
            "min_amount" => $this->min_amount,
            "max_amount" => $this->max_amount,
            "gateway_parameters" => json_decode($this->gateway_parameters),
            "supported_currencies" => $this->supported_currencies,
            "extra" => $this->extra,
            "description" => $this->description,
        ];
    }
}
