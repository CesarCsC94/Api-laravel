<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Repositories\UserRepository;

use App\Http\Repositories\Contracts\JwtAuthInterface;

class UserController extends Controller
{   
    public function register(StoreUserRequest $request, UserRepository $userRepository){
        $params = $request->all();
        $params['role'] = 'ROLE_USER';
        
        $user = $userRepository->create($params);
        $data = [];
        
        if(!is_null($user)){
            $data = [
                'status'        => 'success',
                'code'          => 200,
                'message'       => 'Usuario registrado correctamente'
            ];
        }else{
            $data = [
                'status'    => 'error',
                'code'      => 400, 
                'message'   => 'El usuario no se ha creado'
            ];
        }
                
        return response()->json($data,200);
    }//end login
  
    public function login(StoreLoginRequest $request, JwtAuthInterface $jwtAuth){
        $params = $request->all();
        $jwt = $jwtAuth->signup($params['email'],$params['password']);
        
        return response()->json([
            'message' => 'LOGIN PASS',
            'jwtAuth' => $jwt
        ],200);
    }//end login
}
