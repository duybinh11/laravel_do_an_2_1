<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = 'order';
    public $timestamps = false;
    protected $attributes = [
        'is_shop_confirm' => 0,
        'is_rate' => 0
    ];
    protected $fillable = [
        'id_item',
        'id_bill',
        'received',
        'amount',
        'money',
        'is_shop_confirm',
        'fls_percent',
        'is_rate'
    ];
    protected $hidden = [
        'id_item',
        // 'id_bill'
    ];
    public function status_transport()
    {
        return $this->hasMany(StatusTransportModel::class, 'id_order', 'id');
    }
    public function item()
    {
        return $this->belongsTo(ItemModel::class, 'id_item', 'id');
    }
    public function bill()
    {
        return $this->belongsTo(BillModel::class, 'id_bill', 'id');
    }
}
