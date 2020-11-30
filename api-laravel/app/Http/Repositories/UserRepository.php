<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use App\User;

class UserRepository
{
    public function create($userData)
    {
        if($this->validateUser($userData)){
            return User::create($userData);  
        }
        
        return null;
    }
  
    private function validateUser($userData): bool
    {
        $isset_user = User::where('email','=',$userData['email'])->get();
        return count($isset_user) == 0;
    }
}