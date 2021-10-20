<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;


class UserRepository 
{
    private $wallet;

    public function __construct(WalletService $wallet)
    {
        $this->wallet = $wallet;
    }

    public function createWithWallet($userData): User
    {
        DB::beginTransaction();
            $user = $this->create($userData);

            $this->wallet->create($user->id);
        DB::commit();

        return $user;
    }

    public function create($userData): User
    {
        return User::create($userData);
    }

    public function getAll() 
    {
        return User::all();
    }

    public function get(string $userId): User
    {
        return User::find($userId);
    }
}