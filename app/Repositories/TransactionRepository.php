<?php
namespace App\Repositories;

use App\Models\Transaction;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create($transaction): Transaction
    {
        return Transaction::create($transaction);
    }

    public function getByUser(string $userId)
    {
        return Transaction::where('transactions.payer', $userId)->get();
    }
}