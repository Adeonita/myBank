<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Services\UserService;
    use Exception;

    class UserController extends Controller {
        private function validateRequest(Request $request) {
            return $this->validate($request, [
                'firstName' => 'required',
                'lastName' => 'required',
                'document' => 'required|unique:users|min:11|max:14',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'phoneNumber' => 'required|unique:users',
                'type' => 'in:COMMON,SHOPKEEPER'
            ]);
        }

        public function create(Request $request) {
            $this->validateRequest($request);
           
            UserService::create($request->all());
        }

        //TODO: mover para classe de erro
        private function getCustomError(Exception $e) {
            $errorType = get_class($e);
            if($errorType === "App\Exceptions\UserNotFound"){
                return response()->json([
                    'message' => $e->getMessage()
                ], 404);
            }
        }

        public function find(string $document) {
            try {
                return UserService::get($document);                
            } catch (Exception $e) {
               return $this->getCustomError($e);  
            }
        }
        
    }