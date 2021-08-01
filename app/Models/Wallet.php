<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Wallet extends Model {
        public $timestamps = false;

        protected $fillable = [
            'money', "user_id",
        ];
    }