<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTransportModel extends Model
{
    use HasFactory;

    protected $table  = 'status_transport';
    public $timestamps = false;
    protected $hidden = ['id_order'];
    protected $fillable = [
        'id_order',
        'place',
        'created_at'
    ];
}
