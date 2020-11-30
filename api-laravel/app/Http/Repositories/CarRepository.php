<?php

namespace App\Http\Repositories;

use App\Car;

class CarRepository{
    
    public function create($data){
        try{
            return Car::create($data);
        }catch (Exception $e){
            return null;
        }
    }
    
    public function getAll(){
        try{
            return Car::all();
            
        }catch (Exception $e){
            return null;
        }
    }
    
    public function get($id){
        try{
            return Car::find($id)->load('user');
        }catch (Exception $e){
            return null;
        }
    }
    
    public function updated($id, $data){
        try{
            unset($data['user']);
            $result = Car::where('id',$id)->update($data);
            
            return $result;
        }catch (Exception $e){
            return null;
        }
    }
    
    public function delete($id){
        try{
            $result = Car::find($id)->delete();
            
            return $result;
        }catch (Exception $e){
            return null;
        }
    }
}