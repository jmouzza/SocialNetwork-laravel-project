<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //Indicarle al ORM que tabla estaremos modificando en la base de datos utilizando $table
    protected $table = 'images';
    
    //Relación one to many (uno a muchos) = un solo modelo puede tener muchos comentarios
    public function comments(){
        
        /* Se indica con que modelo/entidad quiere relacionarse, indicandole el fichero ('App/Comment').
        *  Este método mediante el id de imagen guardado en comentarios, conseguirá un array
        *  de objetos de los comentarios que existen en esta Image. */
        return $this->hasMany('App\Comment'); //Una imagen a muchos comentarios
    }
    
    //El mismo tipo de relacion one to many pero entidades diferentes
    public function likes(){
        
        return $this->hasMany('App\Like');//Una imagen a muchos likes
    }
        
    //Relacion Many to One (de muchos a uno) ejemplo muchas imagenes las puede crear un mismo usuario
    public function user(){
        //belongsTo('Fichero con el que se relacionara', 'campo con el que se va a relacionar')
        return $this->belongsTo('App\User', 'user_id');//Muchas imagenes a un usuario
        //Esto sacará la/s imagen/es que tenga/n relacion con el user_id que la/s creo
    }    
    
    
}
