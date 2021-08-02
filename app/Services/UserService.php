<?php
    namespace App\Services;

    use App\Models\User;
    use App\Services\WalletService;
    use App\Exceptions\UserNotFound;
    use Illuminate\Support\Facades\DB;
    use App\Http\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface  {
        
        public static function create($user): void {
            try {              
                DB::beginTransaction();
                    $user =  User::create($user);
                    WalletService::create($user->id);
                DB::commit();

            } catch(\Exception $e) {
                DB::rollBack();

                echo response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }
        }

        public static function getByDocument(string $document): User {
            $user = User::firstWhere('document',$document);
            
            if (!$user){
                throw new UserNotFound("User not Found");
            }
            
            return $user;
        }


        public static function getById(string $id): User {
            return User::find($id);
        }
    }