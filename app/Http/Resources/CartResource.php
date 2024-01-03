<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $item = $this->item;
        $flash_sale = $item->flash_sale;
        return [
            'cart' => [
                'id' => $this->id,
                'amount' => $this->amount,
                'created_at' => $this->created_at,
            ],
            'item' => [
                'id' => $item->id,
                'id_shop' => $item->id_shop,
                'id_category' => $item->id_category,
                'name' => $item->name,
                'price' => $item->price,
                'img' => $item->img,
                'descrip' => $item->descrip,
                'sold' => $item->sold,
                'created_at' => $item->created_at,
                'rate_star' => round($item->rate_star, 1),
                'flash_sale' => $flash_sale,

            ]
        ];
    }
}
