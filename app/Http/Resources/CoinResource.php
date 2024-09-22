<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, integer|string|float>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'coin_id' => $this->coin_api_id,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'price' => $this->price,
            'created_at' => $this->created_at,
        ];
    }
}
