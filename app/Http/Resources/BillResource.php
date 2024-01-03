<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address_receive,
            'money' => $this->money,
            'is_payment' => $this->is_payment,
            'is_vnpay' => $this->is_vnpay,
        ];
    }
}
