<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResoruce extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'item' => array_merge(
                $this->item->toArray(), // Chuyển thông tin của item thành mảng
                ['rate_star' => round($this->item->rate_star, 1)] // Thêm thông tin về rate_star vào mảng và làm tròn
            ),
            'flash_sale' => [
                'id' => $this->id,
                'id_item' => $this->id_item,
                'time_start' => $this->time_start,
                'time_end' => $this->time_end,
                'percent' => $this->percent,
            ]
        ];
    }
}
