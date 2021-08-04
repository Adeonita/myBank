<?php
namespace App\Services;

use Exception;
use App\Models\Transaction;
use App\Http\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    protected $wallet;

    public function __construct(WalletService $wallet)
    {
        $this->wallet = $wallet;
    }

    //TODO: Adicionar tipo a transaction
    public function create($transaction): void
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

    public function getByUser(string $userId): Transaction
    {
        return Transaction::where('transactions.payer', $userId)->get();
    }
}
