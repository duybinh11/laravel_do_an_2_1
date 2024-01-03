<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateItemModel extends Model
{
    use HasFactory;
    protected $table = 'rate_item';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_item',
        'rate_star',
        'comment',
        'created_at'
    ];
    protected $hidden = [
        'id_item',
        'id_user'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
