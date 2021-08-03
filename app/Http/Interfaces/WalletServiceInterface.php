<?php
namespace App\Http\Interfaces;

interface WalletServiceInterface
{
    public function create(string $userId): void;
}
