<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashSaleModel extends Model
{
    use HasFactory;
    protected $table = 'flash_sale';

    public $timestamps = false;

    public function item()
    {
        return $this->BelongsTo(ItemModel::class, 'id_item', 'id');
    }
}
