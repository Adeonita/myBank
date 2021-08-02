<?php
    namespace App\Http\Interfaces;

    use App\Models\User;

    interface UserServiceInterface {
        public static function create(User $user): void;
        public static function getByDocument(string $document): User;
        public static function getById(string $document): User;

    }