<?php
namespace App\Services;

use Exception;
use App\Models\Transaction;
use App\Http\Interfaces\TransactionServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UnauthorizedTransaction;

class TransactionService implements TransactionServiceInterface
{
    protected $wallet;
    protected $user;
    protected $notification;
    protected $authorization;

    public function __construct(WalletService $wallet, UserService $user, NotificationService $notification, AuthorizationService $authorization)
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->notification = $notification;
        $this->authorization = $authorization;
    }

    public function create($transaction): void
    {
        try {
            DB::beginTransaction();
                $this->wallet->debitMoney($transaction['payer'], $transaction['value']);
                $this->wallet->addMoney($transaction['payee'], $transaction['value']);

                $isAuthorized = $this->authorization->isAuthorized();
                
                if (!$isAuthorized) {
                    throw new UnauthorizedTransaction("Unauthorized Transaction", 401);
                }

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

    public function getByUser(string $userId)
    {
        return Transaction::where('transactions.payer', $userId)->get();
    }
}
