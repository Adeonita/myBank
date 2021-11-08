<?php
namespace App\Services;

use Exception;
use App\Models\Transaction;

use Illuminate\Support\Facades\DB;
use App\Exceptions\UnauthorizedTransaction;
use App\Interfaces\Services\TransactionServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Services\WalletServiceInterface;
use App\Interfaces\Repositories\TransactionRepositoryInterface;

class TransactionService implements TransactionServiceInterface
{
    protected $walletService;
    protected $userService;
    protected $notificationService;
    protected $authorizationService;
    protected $transactionRepository;

    public function __construct(
        WalletServiceInterface $walletService, 
        UserServiceInterface $userService, 
        NotificationService $notificationService, 
        AuthorizationService $authorizationService,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->userService = $userService;
        $this->walletService = $walletService;
        $this->notificationService = $notificationService;
        $this->authorizationService = $authorizationService;
        $this->transactionRepository = $transactionRepository;
    }

    private function getTransactionData($transaction)
    {
        $payerName = $this->userService->getById($transaction['payer'])->firstName;
        $payee = $this->userService->getById($transaction['payee']);
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
                $this->walletService->debitMoney($transaction['payer'], $transaction['value']);
                $this->walletService->addMoney($transaction['payee'], $transaction['value']);

                $isAuthorized = $this->authorizationService->isAuthorized();
                
                if (!$isAuthorized) {
                    throw new UnauthorizedTransaction("Unauthorized Transaction", 401);
                }

                $transaction = $this->transactionRepository->create($transaction);
                $this->notificationService->send(...$this->getTransactionData($transaction));
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
