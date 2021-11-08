<?php 

namespace App\Repositories;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Repositories\WalletRepositoryInterface;

class WalletRepository implements WalletRepositoryInterface
{
    public function create(string $userId)
    {
        Wallet::create([
            'user_id' => $userId,
            'money' => 0
        ]);
    }

    public function getByUser(string $userId)
    {
        return DB::table('wallets')
        ->select(['users.firstName', 'users.lastName', 'wallets.money'])
        ->join('users', 'users.id', '=', 'wallets.user_id')
        ->where('wallets.user_id', '=', $userId)
        ->get();
    }

    public function getBalance($userId)
    {
        $wallet = Wallet::firstWhere('user_id', $userId);
        return $wallet->money;
    }

    public function updateBalance(string $userId, float $value)
    {
        return Wallet::where('user_id', $userId)
            ->update(['money' => $value]);
    }
}