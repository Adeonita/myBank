<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Validators\UserValidator;

class UserController extends Controller
{

    protected $user;
    protected $validator;

    public function __construct(UserService $user, UserValidator $validator)
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
