<?php
namespace App\Interfaces\Repositories;

interface WalletRepositoryInterface 
{
    public function create(string $userId);
    public function getByUser(string $userId);
    public function getBalance($userId);
    public function updateBalance(string $userId, float $value);
}