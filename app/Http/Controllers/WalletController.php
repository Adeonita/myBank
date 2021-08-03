<?php 
    namespace App\Http\Controllers;

    use App\Services\UserService;
use App\Services\WalletService;
use Exception;

class WalletController {
        protected $user;
        protected $wallet;

        public function __construct(UserService $user, WalletService $wallet) {
            $this->user = $user;
            $this->wallet = $wallet;
        }

        public function getByUser(string $userId) {
            try{
                $this->user->getById($userId);
                return $this->wallet->getByUser($userId);
            } catch(Exception $e) {
                return response()
                ->json([
                    "error" => $e->getMessage()
                ], $e->getCode());
            }
        }
    }