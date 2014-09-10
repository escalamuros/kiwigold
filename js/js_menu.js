// JavaScript Document
$(document).ready(function(e)
{
	var he=window.innerHeight-50;
	
	$('#contenedor').css('height',he);
	//accion para la barra del menu(menu.php), segun cada boton presionado
	$('.barra').bind('click',function()
	{
		var opcion=$(this).attr('id');
		$.ajax({
			url:opcion+'.php',
			type:'POST',
			success:function(e){$('#cont_centro').html(e);}
		});	
	});
	//boton cerrar session, (menu.php) 
	$('#finsession').bind('click',function(){window.location='logout.php';});

});