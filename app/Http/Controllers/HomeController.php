<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Listar Todas las imagenes en el home ordenadas por ID para mostrar de la mas nueva a la mas vieja
        $images = Image::orderBy('id', 'desc')
                ->paginate(5); //Método que hará la consulta get pero con la paginación, 5la cantidad de fialas a mostrar de la consulta MySQL
        return view('home',[
            'images' => $images
        ]);
    }
}
