<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'item' => array_merge(
                [
                    'id' => $this->id,
                    'id_shop' => $this->id_shop,
                    'id_category' => $this->id_category,
                    'name' => $this->name,
                    'price' => $this->price,
                    'img' => $this->img,
                    'descrip' => $this->descrip,
                    'sold' => $this->sold,
                    'created_at' => $this->created_at,
                    'rate_star' => round($this->rate_star, 1),
                ]
            ),
            'flash_sale' => $this->flash_sale
        ];
    }
}
