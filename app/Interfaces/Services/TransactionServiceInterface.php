<?php
namespace App\Interfaces\Services;

use App\Models\Transaction;

interface TransactionServiceInterface 
{
    public function create($transaction): Transaction;
    public function getByUser(string $userId);
}
