<?php

namespace App\Http\Controllers;

use App\Image; //Modelo de imagen para poder utilizarlo dentro del controlador
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response; //Importante para poder devolver las imagenes almacenadas en el STORAGE
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Collection;
use App\Comment;
use App\Like;

class ImageController extends Controller
{
    public function __construct(){
        //Método que restingirá el acceso solo a usuarios identificados
        $this->middleware('auth');
    }
    
    public function upload(){
        return view('images.upload');
    }
    
    public function save(Request $request){
        //METODO PARA GUARDAR IMAGENE EN BASE DE DATOS Y STORAGE
        //Validamos los datos recibidos por el formulario
        $validate = $this->validate($request, [
           'image_path' => ['required', 'mimes:jpg,jpeg,png,gif'], //Laravel trae una regla de validación para evitar tener que escribir todos los mimes, la regla seria 'image'
           'description' => ['required', 'string']
        ]); 
        
        //Recogemos el id del usuario que hace la subida de imagenes para guardarla en la base de datos
        $user_id = \Auth::user()->id;
        
        //Recogemos los datos recibidos por el formulario
        $description = $request->input('description');
        $image_path = $request->file('image_path');
        
        //Crear un nuevo objeto y asignarle valores
        $image = new Image(); //instanciamos el objeto (modelo)
        $image->user_id = $user_id;
        $image->description = $description;
        
        //Subir imagen (FICHERO)
        if($image_path){
            //Asignar nombre único a la imagen antes de ser guardada en disco
            $image_path_name = time().$image_path->getClientOriginalName();//nombre de la imagen incluyendo extension
            //Utilizamos el metodo Storage para subir la imagen al disco configurado
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name; //Asi se guardará en la base de datos
        }
        
        //Guardar los datos que hemos almacenado en los respectivos atributos ejecutando el metodo save
        $image->save();
        
        return redirect()->route('home')->with([
            'message' => 'La foto ha sido subida correctamente'
        ]);
        
    }
    public function getImageStorage($filename){
        //METODO PARA DEVOLVER LAS IMAGENES ALMACENADAS EN STORAGE 
        $file = Storage::disk('images')->get($filename); //usamos Storage entramos en el disco requerido usamos el metodo get para tomar la info del archivo
        return new Response($file, 200); //devolvemos el archivo buscado almacenado en storage 
    }
    
    public function getProfile($id){
        //Id del usuario a mostrar
        $user_id = $id;
        //Listar Todas las imagenes del usuario en particular ordenadas por ID para mostrar de la mas nueva a la mas vieja
        $image_user = Image::where('user_id', $user_id)
                ->orderBy('id','desc')
                ->paginate(5); //Método que hará la consulta get pero con la paginación, 5la cantidad de fialas a mostrar de la consulta MySQL
        
        return view('images.user_images', [
           'images' => $image_user 
        ]);
        
    }
    public function getImageUser($filename){
        //METODO PARA DEVOLVER LAS IMAGENES ALMACENADAS EN STORAGE 
        $file = Storage::disk('images')->get($filename); //usamos Storage entramos en el disco requerido usamos el metodo paginateget para tomar la info del archivo
        return new Response($file, 200); //devolvemos el archivo buscado almacenado en storage
    }
    
    public function delete($id){
        
        //id de imagen que será eliminada
        $user = \Auth::user();
        //Tomar el registro entero de la imagen
        $image = Image::find($id);
       
        //Hay que borrar registros asociados al registro, porque la integridad referencial no lo permitirá sin borrarlos antes
        //Paso 1 - Sacar los comentarios asociados a la imagen
        $comments = Comment::where('image_id', $id)->get();
        //Paso 2 - Sacar los likes asociados a la imagen
        $likes = Like::where('image_id', $id)->get();
        
        //Confirmar que el usuario loggeado es el propietario de la imagen
        if($user && $image && $image->user->id == $user->id){
            
            //Eliminar comentarios
            if($comments && count($comments)>=1){
                foreach($comments as $comment){
                    $comment->delete(); //borrando cada comentario asociado a la publicacion
                }
            }
            //Eliminar likes
            if($likes && count($likes)>=1){
                foreach($likes as $like){
                    $like->delete(); //borrando cada like asociado a la publicacion
                }
            }
            //Eliminar ficheros almacenados en el storage
            Storage::disk('images')->delete($image->image_path);
            
            //Eliminar registro de imagen en la base de datos
            $image->delete();
            $message = array('message' => 'La imagen se ha borrado correctamente');
        }else{
            $message = array('message' => 'La imagen no se ha borrado');
        }
        return redirect()->route('home')->with($message);
    }
}
