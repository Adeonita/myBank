<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\WalletService;
use App\Exceptions\InvalidValue;
use App\Exceptions\UserNotFound;
use App\Services\TransactionService;
use App\Exceptions\InvalidOperation;
use App\Exceptions\InsufficientFunds;

class TransactionController extends Controller 
{
    protected $user;
    protected $wallet;
    protected $transaction;

    public function __construct(UserService $user, TransactionService $transaction, WalletService $wallet)
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->transaction = $transaction;
    }

    private function validateRequest(Request $request)
    {
        $this->validate($request, [
            'payer' => 'required',
            'payee' => 'required',
            'value' => 'required',
        ]);    
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

        if ($hasPayer && $hasPayer->type === 'SHOPKEEPER') {
            throw new InvalidOperation("Shopkeeper don't can are Payer", 400);
        }
    }   

    private function validateValueTransaction(float $value, string $payerId) 
    {
        $balance = $this->wallet->getBalance($payerId);
        
        if (!$value) {
            throw new InvalidValue("Value must be greater than 0", 400);
        }

        if ($balance < $value) {
            throw new InsufficientFunds("Insufficient Funds", 400);
        }
    }

        //TODO: Cada transação gera dois registros
        //Um crédito na conta do payee
        //Um débito na conta do payer
    public function create(Request $request)
    {
        try {
            $this->validateRequest($request);
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
            dd($e);
            return response()
                ->json([
                    "error" => $e->getMessage()
                ], $e->getCode());
        }
    }
}
