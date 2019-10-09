@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--Mensaje FLASH de Comentario publicado correctamente -->
            @include('includes.show_message')
            @foreach($image as $pic)
            <div class="card pub_image">
                <div class="card-header">
                    <a href="{{route('image.getprofile',[$pic->user->id])}}">
                        <!--Comprobando si el usuario del timeline tiene avatar guardado-->
                        @if($pic->user->image)
                        <div class="container-avatar">
                            <img src="{{route('user.avatar',[$pic->user->image])}}" class="avatar"/>
                        </div>
                        @endif
                        <div class="data-user">
                            {{ $pic->user->name.' '.$pic->user->surname}}
                            <span class="nickname"> {{" | @".$pic->user->nick}}</span>
                        </div>
                    </a>
                </div>
                <div class="card-body">
                    <div class="container-image-pub">
                        <div class="image-timeline">
                            <!--Metodo para buscar imagen del storage-->
                            <img src="{{ route('image.getprofile_images',[$pic->image_path]) }}"/>
                        </div> 
                        <div class="description-timeline">
                            {{"@".$pic->user->nick." "}}<br/>{{$pic->description}}
                        </div>
                        <div class="create-comment">
                            <form action="{{ route('comment.save') }}" method="post">
                                @csrf
                                <label id="label-comment" for="content">Deja tu comentario: </label><br/>
                                <textarea class="form-control" type="text" name="content"></textarea><br/>
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
                                <input type="hidden" name="image_id" value="{{$pic->id}}"/>
                                <input type="submit" class="btn btn-primary" value="Crear Comentario"/>
                            </form>
                        </div>
                        @if(count($pic->comments)>=1)
                        <div class="comments-pub">
                            <hr/><span class="comment-title">Comentarios: {{count($pic->comments)}}</span>
                            @foreach($pic->comments as $comment)
                            <div class="comentario">
                                {{$comment->user->name." ".$comment->user->surname.": ".$comment->content}}
                            </div>
                            @endforeach
                        </div> 
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection