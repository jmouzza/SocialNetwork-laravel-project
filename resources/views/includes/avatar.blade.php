@if(Auth::user()->image)
<!--Si el usuario logeado tiene una imagen de avatar 
en su base de datos entonces ejecuta lo siguiente-->
<div class="container-avatar">
    <img src="{{route('user.avatar',[Auth::user()->image])}}" class="avatar"/>
</div>
@endif