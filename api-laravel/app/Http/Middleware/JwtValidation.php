<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Repositories\Contracts\JwtAuthInterface;

class JwtValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $jwtAuth;
    
    public function __construct(JwtAuthInterface $jwtAuth){
        $this->jwtAuth = $jwtAuth;
    }
    
    public function handle($request, Closure $next)
    {
        $hash = $request->header('Authorization',null);
        
        if(is_null($hash)){
          return response()->json([
              'ok'      => false,
              'message' => 'Usuario no autorizado'
          ],404);
        }
       
        $result = $this->jwtAuth->checkToken($hash,true);
        
        if(is_object($result)){
            $request->request->add(['user' => $result]);
        }
        
        return $next($request);
    }
}
