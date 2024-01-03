<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'email',
        'password',
        'img',
        'phone',
        'address',
        'token',
        'img'
    ];
    protected $attributes = [
        'img' => null
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    public function address_history()
    {
        return $this->hasOne(AddressHistoryModel::class, 'id_user', 'id');
    }

    public function cart()
    {
        return $this->hasMany(CartModel::class, 'id_user', 'id');
    }
}
