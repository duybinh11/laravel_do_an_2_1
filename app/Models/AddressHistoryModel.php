<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressHistoryModel extends Model
{
    use HasFactory;
    protected $table  = 'address_history';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'province',
        'district',
        'town',
        'place_detail',
        'default',
    ];
    protected $hidden = [
        'id_user',
        'created_at',
    ];
}
