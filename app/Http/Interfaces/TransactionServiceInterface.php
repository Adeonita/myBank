<?php
    namespace App\Http\Interfaces;

    use App\Models\Transaction;

    interface TransactionServiceInterface {
        public function create($transaction): void;
        public function getByUser(string $userId): Transaction;
    }