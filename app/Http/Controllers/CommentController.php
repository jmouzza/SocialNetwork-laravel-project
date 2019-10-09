<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image; //Modelo de imagen para poder utilizarlo dentro del controlador
use App\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function create($image_id){
        //Id de la imagen a comentar viene por parámetro recibido por GET
           
        //Buscar la imagen en la que se realizará el comentario
        $image = Image::where('id', $image_id)
                ->get();
        
        return view('comments.create', [
           'image' => $image 
        ]);
    }
    
    public function save(Request $request){
        //METODO PARA GUARDAR EL COMENTARIO EN BASE DE DATOS
        //Validamos los datos recibidos por el formulario
        $validate = $this->validate($request, [
           'content' => ['required', 'string']
        ]); 
        
        //Recogemos los datos recibidos por el formulario
        $content = $request->input('content');
        $user_id = $request->input('user_id');
        $image_id = $request->input('image_id');
        
        //Crear un nuevo objeto y asignarle valores
        $comment = new Comment(); //instanciamos el objeto (modelo)
        $comment->user_id = $user_id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        $comment->save();
        
        return redirect()->route('comment.create',$image_id)->with([
            'message' => 'Tu comentario ha sido publicado correctamente'
        ]);
    }
    
    public function delete($id){
        //Id del comentario a borrar
        $comment_id = $id;
    
        //Borrar el comentario que coincida en la base de datos
        $comment = Comment::where('id', $comment_id)
                ->delete();
        
        return redirect()->route('home')->with([
            'message' => 'Tu comentario ha sido eliminado'
        ]);
    }
}
