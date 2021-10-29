<?php
namespace App\Http\Interfaces;

use App\Models\User;

interface UserServiceInterface 
{
    public function create($user): User;
    public function getAll();
    public function getById(string $document): User;
}