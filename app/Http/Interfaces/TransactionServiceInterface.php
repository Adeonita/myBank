<?php
namespace App\Http\Interfaces;

interface TransactionServiceInterface 
{
    public function create($transaction): void;
    public function getByUser(string $userId);
}
