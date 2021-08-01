<?php
    namespace App\Http\Interfaces;

    interface WalletServiceInterface {
        public static function create(string $userId): void;
    }
?>