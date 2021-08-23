<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\WalletService;
use App\Exceptions\UserNotFound;
use App\Services\TransactionService;
use App\Exceptions\InvalidOperation;
use App\Exceptions\InsufficientFunds;
use App\Validators\TransactionValidator;

class TransactionController extends Controller 
{
    protected $user;
    protected $wallet;
    protected $transaction;
    protected $validator;

    public function __construct(UserService $user, TransactionService $transaction, WalletService $wallet, TransactionValidator $validator)
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->transaction = $transaction;
        $this->validator = $validator;
    }

    private function validateUsers(string $payerId, string $payeeId)
    {
        $hasPayer = $this->user->getById($payerId); //Pagador
        $hasPayee = $this->user->getById($payeeId);

        if ($payerId === $payeeId) {
            throw new InvalidOperation("Payee don't can equal to Payer", 400);
        }

        if (!$hasPayer) {
            throw new UserNotFound("Payer not Found", 404);
        }

        if (!$hasPayee) {
            throw new UserNotFound("Payee not Found", 404);
        }

        if ($hasPayer->type === 'SHOPKEEPER') {
            throw new InvalidOperation("Shopkeeper don't can are Payer", 400);
        }
    }   

    private function validateValueTransaction(float $value, string $payerId) 
    {
        $balance = $this->wallet->getBalance($payerId);
        
        if ($balance < $value) {
            throw new InsufficientFunds("Insufficient Funds", 400);
        }
    }

    public function create(Request $request)
    {
        $errors = $this->validator->validateRequest($request);

        if ($errors) {
            return response()
            ->json($errors, 400);
        }
        
        try {
            $this->validateUsers($request->payer, $request->payee);
            $this->validateValueTransaction($request->value, $request->payer);
        
            $this->transaction->create($request->all());

        } catch (Exception $e) {
            return response()
                ->json([
                    "error" => $e->getMessage()
                ], $e->getCode());
        }
    }

    public function getByUser(string $userId) 
    {
        try {
            $this->user->getById($userId);
            return $this->transaction->getByUser($userId);
        } catch (Exception $e) {
            return response()
                ->json([
                    "error" => $e->getMessage()
                ], $e->getCode());
        }
    }
}
