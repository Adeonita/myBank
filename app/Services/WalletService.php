<?php
    namespace App\Services;

    use App\Models\Wallet;
    use App\Http\Interfaces\WalletServiceInterface;

    class WalletService implements WalletServiceInterface {

        public function getBalance($userId){
            $wallet = Wallet::firstWhere('user_id', $userId);
            return $wallet->money;
        }

        public static function create($userId): void {
            Wallet::create([
                'user_id' => $userId,
                'money' => 0
            ]);
        }
    }
