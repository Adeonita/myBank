<?php
namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository {
    public function create($transaction): Transaction
    {
        return Transaction::create($transaction);
    }

    public function getByUser(string $userId)
    {
        return Transaction::where('transactions.payer', $userId)->get();
    }
}