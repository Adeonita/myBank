<?php
    namespace App\Services;

    use App\Models\Wallet;
    use App\Http\Interfaces\WalletServiceInterface;

    class WalletService implements WalletServiceInterface {

        public function getBalance($userId){
            $wallet = Wallet::firstWhere('user_id', $userId);
            return $wallet->money;
        }

        public function create($userId): void {
            Wallet::create([
                'user_id' => $userId,
                'money' => 0
            ]);
        }

        private function updateBalance($userId, $value) {
            return Wallet::where('user_id', $userId)
                ->update(['money' => $value]);
        }

        public function addMoney($userId, $value) {
            $balance = ($this->getBalance(($userId))) + $value;

            $this->updateBalance($userId, $balance);
        }

        public function debitMoney($userId, $value) {
            $balance = ($this->getBalance($userId)) - $value;

            $this->updateBalance($userId, $balance);
        }
    }
