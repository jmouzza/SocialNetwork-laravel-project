@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--Mensaje FLASH de Foto subida correctamente -->
            @include('includes.show_message')
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            
            <!--Listando las imagenes de todos los usuarios-->
            @foreach($images as $pic)
                @include('includes.image',['pic'=>$pic])
            @endforeach
            <!--Paginación-->
            <div class="clearfix"></div>
            {{$images->links()}}
        </div>
    </div>
</div>
@endsection
