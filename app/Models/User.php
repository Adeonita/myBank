<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class User extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'firstName', 'lastName', 'document', 'email', 'password', 'phoneNumber', 'type'
    ];

    protected $hidden = [
        'password',
    ];

    public function wallet(){
        return $this->hasOne(Wallet::class);
    }
}
