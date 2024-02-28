<?php
namespace App\Interfaces\Repositories;

use App\Models\User;

interface UserRepositoryInterface 
{
    public function createWithWallet($userData): User;
    public function create($userData): User;
    public function getAll();
    public function get(string $userId): User;
}