<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Transaction extends Model {
        protected $fillable = [
            'payer',
            'payee',
            'value',  
            'type'
        ];
    }