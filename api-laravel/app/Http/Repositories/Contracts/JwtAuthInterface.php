<?php

namespace App\Http\Repositories\Contracts;

interface JwtAuthInterface
{
    public function signup($email, $password, $getToken = null);
    public function checkToken($jwt, $getIdentity = false);
}