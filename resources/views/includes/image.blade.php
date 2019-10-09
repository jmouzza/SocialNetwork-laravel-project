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
                <img src="{{ route('image.getall',[$pic->image_path]) }}"/>
            </div>
            <div class="like-comment-section">
                <!--Acciones LIKE Y COMENTARIOS-->
                <?php $user_like = false ?>
                <!--Recorriendo el array de likes para comprobar si  el usuario loggeado dio like en la publicacion-->
                @foreach($pic->likes as $like)
                @if($like->user->id == Auth::user()->id)
                <?php $user_like = true ?>
                @endif
                @endforeach

                @if($user_like == true)
                <!--Usuario ya dio like-->
                <img class="btn-to-dislike like-icon" data-id="{{$pic->id}}" src="{{ asset('icon/heart-red.png') }}"/>
                @if(count($pic->likes)>=1)
                <span class="number_likes">{{count($pic->likes)}}</span>
                @endif
                @else
                <!--Usuario no ha dado like-->
                <img class="btn-to-like like-icon" data-id="{{$pic->id}}" src="{{ asset('icon/heart-gray.png') }}"/>
                @if(count($pic->likes)>=1)
                <span class="number_likes">{{count($pic->likes)}}</span>
                @endif
                @endif
                <a href="{{route('comment.create',[$pic->id])}}">
                    <img class="comment-icon" src="{{ asset('icon/comments.png') }}"/>
                </a>
                @if(Auth::user() && Auth::user()->id == $pic->user->id)
                <!--Eliminando la publicación en caso del ser el autor utilizando Modal de Bootstrap-->
                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-info btn-lg btn-sm btn-danger" data-toggle="modal" data-target="#myModal">Eliminar</button>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Eliminar Publicación</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de eliminar la publicación?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="{{route('image.delete',['id' => $pic->id])}}" class="btn btn-default btn-danger">Eliminar</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>

                    </div>
                </div>
                @endif
            </div>
            <!--Descripción de la publicación-->
            <div class="description-timeline">
                {{"@".$pic->user->nick." "}}<span class="date-pub">{{$pic->created_at->format('d-M-Y')}}</span><br/>{{$pic->description}}
            </div>
            <!--Comentarios de la publicación--> 
            @if(count($pic->comments)>=1)
            <div class="comments-pub">
                <hr/><span class="comment-title">Comentarios: {{count($pic->comments)}}</span>
                <!--Recorriendo los comentarios asociados a una publicación-->
                @foreach($pic->comments as $comment)
                <div class="comentario">
                    {{$comment->user->name." ".$comment->user->surname.": ".$comment->content}}
                    <!--Si el usuario loggeado es el autor de un comentario puede eliminar dicho comentario-->
                    @if($comment->user->id == Auth::user()->id)
                    <a href="{{route('comment.delete', [$comment->id])}}">Eliminar comentario</a>
                    @endif
                </div>
                @endforeach
            </div> 
            @endif
        </div>
    </div>
</div>