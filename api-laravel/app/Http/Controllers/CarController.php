<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreCarRequest;
use App\Http\Repositories\CarRepository;
use App\Car;

class CarController extends Controller
{   
    public function __construct(){
        
    }
    
    public function index(CarRepository $carRepository){
        $result = $carRepository->getAll();
        
        return response()->json([
            'ok'     => true,
            'body'   => $result
        ],200);
    }

    public function store(StoreCarRequest $request, CarRepository $carRepository){
        
        $request->request->add(['user_id' => $request->user->sub]);
        $params = $request->all();
        $result = $carRepository->create($params);
        
        if(is_null($result)){
            return response()->json([
                'ok'        => false,
                'message'   => 'Error al guardar los registros'
            ],200);
        }
        
        return response()->json([
            'ok'        => true,
            'cars'       => $result,
        ],200);
    }
    
    public function show(CarRepository $carRepository, $id){
        $result = $carRepository->get($id);
        
        if(is_null($result)){
            return response()->json([
                'ok'        => false,
                'message'   => 'Error al guardar los registros'
            ],200);
        }
        
        return response()->json([
            'ok'        => true,
            'car'       => $result
        ],200);
    }
    
    public function update(StoreCarRequest $request,CarRepository $carRepository, $id){
        //$request->request->add(['user_id' => $request->user->sub]);
            
        $params = $request->all();
        $result = $carRepository->updated($id,$params);
        
        if(is_null($result)){
            return response()->json([
                'ok'        => false,
                'message'   => 'Error al guardar los registros'
            ],200);
        }
        
        return response()->json([
            'ok'        => true,
            'message'   => 'Registro editado',
        ],200);
    }
    
    public function destroy(CarRepository $carRepository, $id){
        $result = $carRepository->delete($id);
        
        if(is_null($result)){
            return response()->json([
                'ok'        => false,
                'message'   => 'Error al eliminar los registros'
            ],200);
        }
        
        return response()->json([
            'ok'        => true,
            'message'   => 'Registro eliminado',
        ],200);
    }
}
