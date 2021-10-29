<?php
namespace App\Services;

use Exception;
use App\Models\User;
use App\Services\WalletService;
use App\Exceptions\UserNotFound;
use Illuminate\Support\Facades\DB;
use App\Http\Interfaces\UserServiceInterface;
use App\Repositories\UserRepository;

class UserService implements UserServiceInterface
{

    protected $wallet;
    private $userRepository;

    public function __construct(WalletService $wallet, UserRepository $userRepository)
    {
        $this->wallet = $wallet;
        $this->userRepository = $userRepository;
    }

    public function create($userData): User
    {
        try {     
            return $this->userRepository->createWithWallet($userData);
        } catch (Exception $e) {
            DB::rollBack();
            echo response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getAll() {
        return $this->userRepository->getAll();
    }

    public function getById(string $id): User
    {
        $user = $this->userRepository->get($id);

        if (!$user) {
            throw new UserNotFound("User Not Found", 404);
        }
        
        return $user;
    }
}
