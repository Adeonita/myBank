<?php
namespace App\Services;

use Exception;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionService 
{
    protected $wallet;

    public function __construct(WalletService $wallet)
    {
        $this->wallet = $wallet;
    }

    public function create(Transaction $transaction)
    {
        try {
            DB::beginTransaction();
                $this->wallet->debitMoney($transaction['payer'], $transaction['value']);
                $this->wallet->addMoney($transaction['payee'], $transaction['value']);
            
                Transaction::create($transaction);
            
            DB::commit();

        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            throw new Exception($e->getMessage(), 400);
        }
    }

    public function getByUser(string $userId)
    {
        return Transaction::where('transactions.payer', $userId)->get();
    }
}
