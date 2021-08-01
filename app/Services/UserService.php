<?php
    namespace App\Services;

    use Exception;
    use App\Models\User;
    use App\Services\WalletService;
    use App\Http\Interfaces\UserServiceInterface;
    use App\Exceptions\UserNotFound;

    class UserService implements UserServiceInterface  {
        
        public static function create($user): void {
            try {              
               $user =  User::create($user);
               WalletService::create($user->id);
            } catch(Exception $e) {
                response()->json([
                    'message' => $e
                ], 400);
            }
        }

        public static function get(string $document): User {
            $user = User::firstWhere('document',$document);
            
            if (!$user){
                throw new UserNotFound("User not Found");
            }
            
            return $user;
        }
    }