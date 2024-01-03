<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemModel extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $casts = [
        'rate_star' => 'float',

    ];

    public $timestamps = false;
    public function flash_sale()
    {
        return $this->hasOne(FlashSaleModel::class, 'id_item', 'id');
    }
    public function shop()
    {
        return $this->belongsTo(ShopModel::class, 'id_shop', 'id');
    }
    public function rate()
    {
        return $this->hasMany(RateItemModel::class, 'id_item', 'id');
    }
    public function rate_star()
    {
        return $this->hasMany(RateItemModel::class, 'id_item', 'id')->avg('rate_star');
    }
    public function order()
    {
        return $this->HasMany(OrderModel::class, 'id_item', 'id');
    }
}
