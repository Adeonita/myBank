<?php
namespace App\Services;

use Exception;
use App\Models\User;
use App\Services\WalletService;
use App\Exceptions\UserNotFound;
use Illuminate\Support\Facades\DB;
use App\Http\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{

    protected $wallet;

    public function __construct(WalletService $wallet)
    {
        $this->wallet = $wallet;
    }

    public function create(User $user): void
    {
        try {              
            DB::beginTransaction();
                $user =  User::create($user);

                $this->wallet->create($user->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getByDocument(string $document): User
    {
        $user = User::firstWhere('document',$document);
        
        if (!$user) {
            throw new UserNotFound("User not Found", 404);
        }
        
        return $user;
    }


    public function getById(string $id): User
    {
        $user = User::find($id);

        if (!$user) {
            throw new UserNotFound("User not Found", 404);
        }
        
        return $user;
    }
}
