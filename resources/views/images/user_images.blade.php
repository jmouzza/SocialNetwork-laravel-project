@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--Listando las imagenes del Perfil-->
            @foreach($images as $pic)
                @include('includes.image',['pic'=>$pic])
            @endforeach
            <!--Paginacion-->
            <div class="clearfix"></div>
            {{$images->links()}}
        </div>
    </div>
</div>
@endsection
