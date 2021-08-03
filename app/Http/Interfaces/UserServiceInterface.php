<?php
    namespace App\Http\Interfaces;

    use App\Models\User;

    interface UserServiceInterface {
        public function create(User $user): void;
        public function getByDocument(string $document): User;
        public function getById(string $document): User;
    }