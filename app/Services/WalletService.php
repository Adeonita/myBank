<?php
    namespace App\Services;

    use App\Models\Wallet;
    use App\Http\Interfaces\WalletServiceInterface;

    class WalletService implements WalletServiceInterface {
        
        public static function create($userId): void {
            Wallet::create([
                'user_id' => $userId,
                'money' => 0
            ]);
        }
    }
