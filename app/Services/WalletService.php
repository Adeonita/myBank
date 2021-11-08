<?php
namespace App\Services;


use App\Interfaces\Services\WalletServiceInterface;
use App\Interfaces\Repositories\WalletRepositoryInterface;

class WalletService implements WalletServiceInterface
{
    private $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    private function formatResponse(string $messageContent, int $statusCode)
    {
        return response()
        ->json([
            "response" => $messageContent,
        ], $statusCode);
    }

    public function getBalance(string $userId)
    {
        return $this->walletRepository->getBalance($userId);
    }

    public function create($userId): void
    {
        $this->walletRepository->create($userId);
    }

    public function addMoney(string $userId, float $value)
    {
        $balance = ($this->walletRepository->getBalance(($userId))) + $value;

        $this->walletRepository->updateBalance($userId, $balance);
    }

    public function debitMoney(string $userId, float $value)
    {
        $balance = ($this->walletRepository->getBalance($userId)) - $value;

        $this->walletRepository->updateBalance($userId, $balance);
    }

    public function getByUser(string $userId)
    {
        $userWithWallet = $this->walletRepository->getByUser($userId);
        
        return  $userWithWallet 
                ? $this->formatResponse($userWithWallet, 200)
                : $this->formatResponse("User not found", 404);      
    }
}
