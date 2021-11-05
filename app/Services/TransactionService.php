<?php
namespace App\Services;

use Exception;
use App\Models\Transaction;

use Illuminate\Support\Facades\DB;
use App\Exceptions\UnauthorizedTransaction;
use App\Interfaces\Services\TransactionServiceInterface;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class TransactionService implements TransactionServiceInterface
{
    protected $wallet;
    protected $user;
    protected $notification;
    protected $authorization;
    protected $transactionRepository;

    //TODO: Receber interfaces do wallet, user, notification e autorization
    public function __construct(
        WalletService $wallet, 
        UserService $user, 
        NotificationService $notification, 
        AuthorizationService $authorization,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->user = $user;
        $this->wallet = $wallet;
        $this->notification = $notification;
        $this->authorization = $authorization;
        $this->transactionRepository = $transactionRepository;
    }

    private function getTransactionData($transaction)
    {
        $payerName = $this->user->getById($transaction['payer'])->firstName;
        $payee = $this->user->getById($transaction['payee']);
        $payeeEmail = $payee->email;
        $payeePhoneNumber = $payee->phoneNumber;

        return [ 
            $payeeEmail,
            $payeePhoneNumber,
            $transaction->value,
            $payerName,
        ];
    }

    public function create($transaction): Transaction
    {
        try {
            DB::beginTransaction();
                $this->wallet->debitMoney($transaction['payer'], $transaction['value']);
                $this->wallet->addMoney($transaction['payee'], $transaction['value']);

                $isAuthorized = $this->authorization->isAuthorized();
                
                if (!$isAuthorized) {
                    throw new UnauthorizedTransaction("Unauthorized Transaction", 401);
                }

                $transaction = $this->transactionRepository->create($transaction);
                $this->notification->send(...$this->getTransactionData($transaction));
            DB::commit();
            
            if ($transaction) {
                return $transaction;
            }

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 400);
        }
    }

    public function getByUser(string $userId)
    {
        return $this->transactionRepository->getByUser($userId);
    }
}
