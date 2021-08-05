<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{

    protected $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    private function validateRequest(Request $request)
    {
        return $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'document' => 'required|unique:users|min:11|max:14',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phoneNumber' => 'required|unique:users',
            'type' => 'required|in:COMMON,SHOPKEEPER'
        ]);
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);
        $this->user->create($request->all());
    }

    public function find(string $id)
    {
        try {
            return $this->user->getById($id);                
        } catch (Exception $e) {
            return response()
            ->json([
                "error" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function getAll()
    {
        try {
            return $this->user->getAll();                
        } catch (Exception $e) {
            return response()
            ->json([
                "error" => $e->getMessage()
            ], $e->getCode());
        }
    }


    
}
