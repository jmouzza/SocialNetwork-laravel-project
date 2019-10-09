@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Publicaciones que te gustan</h3>
            <hr/>
            @if(count($likes)>=1)
                <!--Listando las imágenes o publicaciones favoritas del usuario-->
                @foreach($likes as $like)
                <!--Relación like con el modelo Image, enviará la información de la tabla imágenes-->
                @include('includes.image',['pic' => $like->image])
                @endforeach
            @else
            <h4>No has dado like a ninguna publicación</h4>
            <img src="{{ asset('icon/sad.png') }}"/>
            @endif
            <!--Mostrando las publicaciones favoritas paginadas de a 5 publicaciones por página-->
            <div class="clearfix"></div>
            {{$likes->links()}}
        </div>
    </div>
</div>
@endsection