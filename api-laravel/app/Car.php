<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    
    protected $fillable = ['title','description','price','status','user_id'];
    
    //Relacion con usuario
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
