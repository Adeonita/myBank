<?php
namespace App\Services;

use App\Models\Wallet;
use App\Http\Interfaces\WalletServiceInterface;
use Illuminate\Support\Facades\DB;

class WalletService implements WalletServiceInterface
{

    public function getBalance(string $userId)
    {
        $wallet = Wallet::firstWhere('user_id', $userId);
        return $wallet->money;
    }

    public function create($userId): void
    {
        Wallet::create([
            'user_id' => $userId,
            'money' => 0
        ]);
    }

    private function updateBalance(string $userId, float $value)
    {
        return Wallet::where('user_id', $userId)
            ->update(['money' => $value]);
    }

    public function addMoney(string $userId, float $value)
    {
        $balance = ($this->getBalance(($userId))) + $value;

        $this->updateBalance($userId, $balance);
    }

    public function debitMoney(string $userId, float $value)
    {
        $balance = ($this->getBalance($userId)) - $value;

        $this->updateBalance($userId, $balance);
    }

    public function getByUser(string $userId)
    {
        $userwithWallet = DB::table('wallets')
        ->select(['users.firstName', 'users.lastName', 'wallets.money'])
        ->join('users', 'users.id', '=', 'wallets.user_id')
        ->where('wallets.user_id', '=', $userId)
        ->get();

        //TODO: revisar se é o padrão correto de retorno para rest
        return response()
        ->json([
            "response" => $userwithWallet,
            "code" => 200
        ],200);
    }
}
