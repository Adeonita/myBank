<?php

namespace App\Interfaces\Repositories;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create($transaction): Transaction;
    public function getByUser(string $userId);
}