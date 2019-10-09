<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//use App\Image; //PRUEBA FUNCIONALIDAD DEL ORM


Route::get('/', 'HomeController@index');
    
    /*
     * PRUEBA DE FUNCIONALIDAD DE ORM Y LAS RESPECTIVAS RELACIONES ENTRE LAS TABLAS
    $images = Image::all();
    foreach ($images as $image){
        echo $image->image_path."<br/><br/>";
        echo $image->description."<br/>";
        echo "Autor: ".$image->user->name." ".$image->user->surname."<br/><br/>";
        
        if(count($image->comments)>=1){
            echo "COMENTARIOS (".count($image->comments).")<br/>";
            foreach ($image->comments as $comment) {
                echo $comment->user->name." ".$comment->user->surname.": ";
                echo $comment->content . "<br/>";
            }
        }
        echo "Likes: ".count($image->likes)."<br/>";
        foreach ($image->likes as $like) {
                echo $like->user->name." ".$like->user->surname."<br/>";
            }
        echo "<hr/>";
        }
    die();
    */
//    return view('welcome');
//});

//RUTAS GENERALES
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//RUTAS PARA CONTROLADOR UsuarioController
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/configuracion/update', 'UserController@update')->name('config.update');
Route::get('/user/avatar/{filename}', 'UserController@getAvatar')->name('user.avatar');
Route::get('/user/profiles/{search?}', 'UserController@index')->name('user.index'); //Listar los perfiles registrados (todos los usuarios)

//RUTAS PARA CONTROLADOR ImageController
Route::get('/image/upload', 'ImageController@upload')->name('image.upload');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/image/getall/{filename?}', 'ImageController@getImageStorage')->name('image.getall');
Route::get('/image/getprofile/{id}', 'ImageController@getProfile')->name('image.getprofile');
Route::get('/image/getprofile_images/{filename}', 'ImageController@getImageUser')->name('image.getprofile_images');

//RUTAS PARA CONTROLADOR CommentController
Route::get('/comment/create/{image_id}', 'CommentController@create')->name('comment.create');
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

//RUTAS PARA CONTROLADOR LikeController
Route::get('/like/{image_id}', 'LikeController@like')->name('like');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('dislike');
Route::get('/favorites', 'LikeController@favorites')->name('favorites');


