<?php 
    namespace App\Http\Controllers;

    use Exception;
    use App\Interfaces\Services\UserServiceInterface;
    use App\Interfaces\Services\WalletServiceInterface;

    
    class WalletController extends Controller {
        protected $user;
        protected $wallet;

        public function __construct(UserServiceInterface $user, WalletServiceInterface $wallet) {
            $this->user = $user;
            $this->wallet = $wallet;
        }

        public function getByUser(string $userId) {
            try {
                $this->user->getById($userId);
                return $this->wallet->getByUser($userId);
            } catch (Exception $e) {
                return response()
                ->json([
                    "error" => $e->getMessage()
                ], $e->getCode());
            }
        }
    }
