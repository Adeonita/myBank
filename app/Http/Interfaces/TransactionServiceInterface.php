<?php
namespace App\Http\Interfaces;

use App\Models\Transaction;

interface TransactionServiceInterface 
{
    public function create($transaction): Transaction;
    public function getByUser(string $userId);
}
