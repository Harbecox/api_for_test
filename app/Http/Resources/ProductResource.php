<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currency = $this->converted_currency ?? 'RUB';

        $rates = [
            'RUB' => 1,
            'USD' => 90,
            'EUR' => 100,
        ];

        $convertedPrice = $this->price / ($rates[$currency] ?? 1);
        $formattedPrice = match ($currency) {
            'USD' => '$' . number_format($convertedPrice, 2),
            'EUR' => '€' . number_format($convertedPrice, 2),
            'RUB' => number_format($convertedPrice, 0, '', ' ') . ' ₽',
            default => $this->price
        };

        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $formattedPrice,
        ];
    }
}
