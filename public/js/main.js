var url= 'http://proyecto-laravel-redsocial.com.devel';
window.addEventListener("load", function(){
    
    $('.btn-to-like').css('cursor', 'pointer');
    $('.btn-to-dislike').css('cursor', 'pointer');
    
    //Botón hacer like: pasar el corazon de gris a rojo
    function like(){
        $('.btn-to-like').unbind('click').click(function(){
            console.log('like');
            $(this).addClass('btn-to-dislike').removeClass('btn-to-like');
            $(this).attr('src',url+'/icon/heart-red.png');
            
            //Petición ajax para ejecutar el método like de manera asincrona refrescar el elemento 
            //sin refrescar toda la página
            //traemos la información del id de la imagen a través de un atributa html data-id={{$pic->id}}            
            $.ajax({
               url: url+'/like/'+$(this).attr('data-id'),
               type: 'GET',
               success: function(response){
                   if(response.like){
                       console.log('Has dado like a la publicación');
                   }else{
                       console.log('Error al dar like');
                   }
               }
            });
            
            //Sirve para recargar el dom realiza un bindeo, por lo cual es necesario unbind en cada click futuro
            //y así no acumular los bindeos
            dislike();
        })    
    }
    like();
    
    //Botón hacer dislike: pasar el corazon de rojo a gris
    function dislike(){
        $('.btn-to-dislike').unbind('click').click(function(){
            console.log('dislike');
            $(this).addClass('btn-to-like').removeClass('btn-to-dislike');
            $(this).attr('src',url+'/icon/heart-gray.png');
            
            //Petición ajax para ejecutar el método dislike de manera asincrona refrescar el elemento 
            //sin refrescar toda la página
            //traemos la información del id de la imagen a través de un atributa html data-id={{$pic->id}}            
            $.ajax({
               url: url+'/dislike/'+$(this).attr('data-id'),
               type: 'GET',
               success: function(response){
                   if(response.like){
                       console.log('Has dado dislike a la publicación');
                   }else{
                       console.log('Error al dar dislike');
                   }
               }
            });
            
            //Sirve para recargar el dom realiza un bindeo, por lo cual es necesario unbind en cada click futuro
            //y así no acumular los bindeos
            like();
        }) 
    }
    dislike();
    
    //BUSCADOR de usuarios
    //Seleccionamos el formulario del buscador de usuarios, al dar submit tendremos una función de callback
    //que permitirá modificar el atributo action del buscador
    $('#buscador').submit(function(e){
       
       $(this).attr('action',url+'/user/profiles/'+$('#buscador').val()); 
       
    });
    
});
