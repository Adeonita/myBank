<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Interfaces\Services\UserServiceInterface;
use App\Validators\UserValidator;

class UserController extends Controller
{

    protected $user;
    protected $validator;

    public function __construct(UserServiceInterface $user, UserValidator $validator)
    {
        $this->user = $user;
        $this->validator = $validator;
    }

    public function create(Request $request)
    {
        $validator = $this->validator->validateRequest($request);

        if ($validator) {
            return response()
            ->json($validator, 400);
        }

        $user = $this->user->create($request->all());

        return response()->json([
            "userId" => $user->id
        ], 201);
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
            $users = $this->user->getAll();
        
            return response()
            ->json(
                $users
            , 200);
        } catch (Exception $e) {
            return response()
            ->json([
                "error" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
