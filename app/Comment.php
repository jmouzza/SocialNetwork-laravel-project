<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //Indicarle al ORM que tabla estaremos modificando en la base de datos utilizando $table
    protected $table = 'comments';
    
    //Relaciones con otras tablas, en este caso, ambas relaciones son externas FOREIGN KEYS (Many to One)
    public function user(){
        return $this->belongsTo('App\User', 'user_id'); //Muchos comentarios a un usuario
    }
    public function image(){
        return $this->belongsTo('App\Image', 'image_id'); //Muchos comentarios a una imagen
    }
    
}
