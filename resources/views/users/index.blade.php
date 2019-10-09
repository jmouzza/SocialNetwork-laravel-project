@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Todos los usuarios</h3>
            <hr/>
            <form action="" method="GET" id="buscador">
                 
                 <input type="text" id="search" placeholder=" Buscar usuario..." />
                 <input type="submit" value="Buscar" class="btn-sm btn-info"/>
            </form>
            <!--Listando los usuarios registrados-->
            @foreach($users as $user)
            <a class="link-profile" href="{{route('image.getprofile',['id' => $user->id])}}">
                <div class="profile-user">
                     <div class="profile-avatar">
                         @if($user->image)
                         <img src="{{route('user.avatar',[$user->image])}}"/>
                         @endif
                     </div>
                     <div class="profile-info">
                         <p>{{ "@".$user->nick }}</p>
                         <p>{{$user->name." ".$user->surname}}</p>
                         <p><span class="date-pub">Se unio el: {{$user->created_at->format('d-M-Y')}}</span></p>
                     </div>
                </div>
            </a>
            @endforeach
            
            <!--Paginación-->
            <div class="clearfix"></div>
            {{$users->links()}}
            
        </div>
    </div>
</div>
@endsection
