<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserValidator 
{

  public function validateRequest(Request $request)
  {
    return Validator::make(
      $request->all(), 
      [
        'firstName' => 'required',
        'lastName' => 'required',
        'document' => 'required|unique:users|min:11|max:14',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'phoneNumber' => 'required|unique:users',
        'type' => 'required|in:COMMON,SHOPKEEPER'
      ]
    )->errors()->getMessages();
  }
}
