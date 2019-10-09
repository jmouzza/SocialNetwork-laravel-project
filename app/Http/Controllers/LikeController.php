<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function like($image_id){
        //recoger datos del usuario
        $user_id = \Auth::user()->id;
        //el id de la imagen a la que se hará like vendrá por parámetro recibido por GET
        
        //Condición para comprobar si el like existe y no se duplique
        $isset_like = Like::where('user_id',$user_id)
                            ->where('image_id',$image_id) //Doble condición para saber si existe el like
                            ->count(); //Si el conteo me arroja 1 o más filas, existe
                    
        if($isset_like == 0){ //si el conteo es igual a 0 no existe el like y podrá avanzar y guardarse
            $like = new Like();
            $like->user_id = $user_id;
            $like->image_id = (int)$image_id; //convertir a entero
            $like->save();
        
            return response()->json([
                'like' => $like
            ]);
        }else{//El like ya existe
            return response()->json([
                'message' => 'El like ya existe'
            ]);     
        }   
        
        
    }
    public function dislike($image_id){
        //recoger datos del usuario
        $user_id = \Auth::user()->id;
        //el id de la imagen a la que se hará like vendrá por parámetro recibido por GET
        
        //Condición para comprobar si el like existe y posteriormente eliminarlo
        $like = Like::where('user_id',$user_id)
                    ->where('image_id',$image_id) //Doble condición para saber si existe el like
                    ->first(); //Permite tomar un unico objeto de la consulta
                    
        if($like){ //si like existe, entonces elimínalo
            $like->delete();
        
            return response()->json([
                'like' => $like,
                'message' => 'Dislike efectuado'
            ]);
        }else{//El like no existe
            return response()->json([
                'message' => 'El like no existe'
            ]);     
        }   
    }
    
    public function favorites(){
        //Id de usuario a mostrar sus LIKES
        $user_id = \Auth::user()->id;
        //Buscar los likes del usuario, obtenerlos con paginate
        $likes = Like::where('user_id', $user_id)
                    ->orderBy('id','desc')
                    ->paginate(5);
        return view('likes.favorites', [
           'likes' => $likes 
        ]);
        
    }
}
