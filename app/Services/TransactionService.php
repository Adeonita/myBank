<?php
namespace App\Services;

use Exception;
use App\Models\Transaction;
use App\Http\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    protected $wallet;
    protected $user;
    protected $notification;

    public function __construct(WalletService $wallet, UserService $user, NotificationService $notification)
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->notification = $notification;
    }

    //TODO: Adicionar tipo a transaction
    public function create($transaction ): void
    {
        try {
            DB::beginTransaction();
                $this->wallet->debitMoney($transaction['payer'], $transaction['value']);
                $this->wallet->addMoney($transaction['payee'], $transaction['value']);
            
                Transaction::create($transaction);

                $payerName = $this->user->getById($transaction['payer'])->firstName;
                $user = $this->user->getById($transaction['payee']);
                $email = $user->email;
                $phoneNumber = $user->phoneNumber;

                $this->notification->send($email, $phoneNumber, $transaction['value'], $payerName);
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 400);
        }
    }

    public function getByUser(string $userId): Transaction
    {
        return Transaction::where('transactions.payer', $userId)->get();
    }
}
