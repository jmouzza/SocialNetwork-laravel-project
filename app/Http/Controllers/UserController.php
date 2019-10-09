<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response; //Importante para poder devolver la imagen del avatar almacenada en el STORAGE
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; //para el manejo de ficheros
use App\User;


class UserController extends Controller{
   //Controlador que deberá ser protegido con autenticación ya que se maneja información privada 
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index($search = null){
        if($search == null){
            //No hay search...
            //Listar todos los usuarios registrados en la aplicación
            $users = User::orderBy('id','desc')
                        ->paginate(5);
        }else{
            //Buscar usuario que coincida con lo que viene en search
            $users = User::where('nick','LIKE','%'.$search.'%') //Buscando con comodines en el campo nick
                        ->orWhere('name','LIKE','%'.$search.'%') //Buscando con comodines en el campo name
                        ->orWhere('surname','LIKE','%'.$search.'%') //Buscando con comodines en el campo surname
                        ->orderBy('id','desc')
                        ->paginate(5);
        }
        return view('users.index', [
                'users' => $users
        ]);
            
    }
    
    public function config(){
        //asociado a una vista
        return view('users.config');
    }
    
    public function update(Request $request){
        
        //Asignar el objeto del usuario identificado
        $user = \Auth::user();
        //Sacar el id para la validación y posterior actualizacion de datos
        $id = $user->id;
        //validar los datos del formulario, que cumplan con ciertas condiciones
                   //$this se refiere a la clase actual que tiene heredado validate de Controller
        $validate = $this->validate($request, [
            'name' => ['required', 'alpha_spaces', 'max:255'], //alpha_spaces una validacion personalizada en AppServiceProvider con mensaje asociado en resources lang en validation
            'surname' => ['required', 'alpha_spaces', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],//buscará que el nick no coincida con otro usuario, dejando guardar solo(excepcion) si el nick no haya sufrido cambio y sea el mismo
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id]//buscará que el nick no coincida con otro usuario, dejando guardar solo(excepcion) si el nick no haya sufrido cambio y sea el mismo
        ]);
        
        //Recoger y asignar en variables los datos recogidos y validados del formulario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        //Realizar una simple asignación de valores al usuario activo
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;
        //Subir imagen AVATAR
        //Comprobar que llega imagen
        $image_path = $request->file('image');
        //si existe image_path es que el usuario quiere subir la imagen
        if($image_path){
            //Crear nombre al archivo de tal forma que sea unico en el disco donde 
            //se almacenará, utilizamos el metodo time() para asegurarnos q no se repita
            $image_path_name = time()."_".$nick."_".$image_path->getClientOriginalName(); 
            //Utilizar objeto Storage para utilizar el método disk que permite 
            //almacenar en los discos virtuales, informando en que disco se almacenará.
            //Luego usamos el metódo put: 
            //- primer parámetro nombre del archivo con el que se almacenará
            // -segundo parámetro el fichero recibido desde el formulario
            //La información del disco 'users' permite a Laravel saber el storage_path en nuestro proyecto
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //Asignación del valor 'image' al usuario activo (utilizar el nombre 
            //de archivo que será único y evitar problemas con archivos repetidos)
            //para posteriormente guardarlo en la base de datos
            $user->image = $image_path_name;
        }
        //Realizar el update del objeto
        $user->update();
        
        //Una vez actualizado el objeto redirigimos a la página con los datos del usuario y un mensaje de session "flash" accion completada
        return redirect()->route('config')
                ->with(['message' => 'Your profile was updated']);
    }
    public function getAvatar($filename){
        //Accedemos al objeto Storage concretamente al disco donde se encuentra la imagen
        //y utilizamos el método get para sacar la imagen concreta que queremos.
        $file = Storage::disk('users')->get($filename);
        //Esta función devolverá una respuesta con una respuesta dentro estará el fichero y el código 200 de operación satisfactoria
        //Se deberá importar el objeto Response en la cabecera del controlador para tenerlo disponible
        return new Response($file, 200);
    }
    
}
