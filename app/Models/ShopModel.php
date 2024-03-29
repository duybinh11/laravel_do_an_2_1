<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopModel extends Model
{
    use HasFactory;
    protected $table = 'shop';
    public $timestamps = false;

    public function item()
    {
        return $this->hasMany(ItemModel::class, 'id_shop', 'id');
    }
}
