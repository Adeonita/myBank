<?php 
    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Transaction extends Model {
        //todo: remover o timestamps false
        public $timestamps = false;
        //todo: definir se terá ou não tipo da transação
        protected $fillable = [
            'payer',
            'payee',
            'value',  
            'type'
        ];
    }