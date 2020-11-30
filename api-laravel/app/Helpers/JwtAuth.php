<?php

namespace App\Helpers;

use App\Http\Repositories\Contracts\JwtAuthInterface;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use App\User;

class JwtAuth implements JwtAuthInterface
{
    public $key;
    
    public function __construct(){
        $this->key = 'SECRETE_KEY';
    }
    
    public function signup($email, $password, $getToken = null)
    {
        $pwd = hash('sha256',$password);
        
        $user = User::where([
            'email'     => $email,
            'password'  => $pwd
        ])->first();
        
        $sigup = false;
        if(is_object($user)){
            $sigup = true;
        }
        
        if($sigup){
            //Generar el token y devolverlo
            $payload = array(
                'sub'   => $user->id,
                'email' => $user->email,
                'name'  => $user->name.' '.$user->surname,
                'lat'   => time(),
                'exp'   => time() + (7 * 24 * 60 * 60)
            );
            
            $jwt = JWT::encode($payload,'SECRETE_KEY');
            return $jwt;
            
        }else{
            //Devolver un error
            return [
                'status'    => 'error',
                'message'   => 'Login ha fallado'
            ];
        }
        
    }
                        
    public function checkToken($jwt, $getIdentity = false){
        $auth = false;
       
        //$decode = JWT::decode($jwt,$this->key, array('HS256'));
        
        try{
            $decode = JWT::decode($jwt,'SECRETE_KEY', array('HS256'));
        }catch(\UnexpectedValueException $e){
            $auth = false;
        }catch(\DomainException $e){
            $auth = false;
        }
        
        if(isset($decode) && is_object($decode) && isset($decode->sub)){
            $auth = true;
        }else{
            $auth = false;
        }
        
        if($getIdentity){
            return $decode;
        }
        
        return $auth;
    }
}