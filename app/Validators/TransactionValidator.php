<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionValidator 
{

  public function validateRequest(Request $request)
  {
    return Validator::make(
      $request->all(),
      [
        'payer' => 'required|integer|exists:users,id',
        'payee' => 'required|integer|exists:users,id',
        'value' => 'required|numeric|gt:0',
      ],
      $messages = [
        'payer.exists' => 'Payer Not Found',
        'payee.exists' => 'Payee Not Found'
      ]
    )->errors()->getMessages();
  }
}