<?php
namespace App\Interfaces\Services;

interface WalletServiceInterface
{
    public function create(string $userId): void;
    public function getBalance(string $userId);
    public function addMoney(string $userId, float $value);
    public function debitMoney(string $userId, float $value);
    public function getByUser(string $userId);
}
