<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    use HasFactory;
    protected $table = 'cart';
    public $timestamps = false;


    protected $fillable = ['id_item', 'id_user', 'amount', 'created_at'];

    public function item()
    {
        return $this->belongsTo(ItemModel::class, 'id_item', 'id');
    }
}
