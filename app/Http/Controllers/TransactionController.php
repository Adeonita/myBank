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
    protected $userService;
    protected $walletService;
    protected $transactionService;
    protected $validator;

    public function __construct(
        UserService $userService,
        WalletService $walletService,
        TransactionService $transactionService,
        TransactionValidator $validator
    )
    {
        $this->userService = $userService;
        $this->walletService = $walletService;
        $this->transactionService = $transactionService;
        $this->validator = $validator;
    }

    private function validateUsers(string $payerId, string $payeeId)
    {
        $hasPayer = $this->userService->getById($payerId); //Pagador
        $hasPayee = $this->userService->getById($payeeId);

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
        $balance = $this->walletService->getBalance($payerId);
        
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
        
            $transaction = $this->transaction->create($request->all());

            return response()
                ->json([ 
                    "transactionId" => $transaction->id
                ], 201);

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
            $this->userService->getById($userId);
            return $this->transaction->getByUser($userId);
        } catch (Exception $e) {
            return response()
                ->json([
                    "error" => $e->getMessage()
                ], $e->getCode());
        }
    }
}
