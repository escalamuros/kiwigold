// JavaScript Document
$	(document).ready(function(e) {

	$('#user').focus();	
	
	var he=window.innerHeight-50,minpeso=999999,maxpeso=0,minpres=999999,maxpres=0,mincol=999999,maxcol=0,minss=999999,maxss=0,minseca=999999,maxseca=0;
	$('#contenedor').css('height',he);
	$('#user').keypress(function(e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if(keycode == 13) { $('#pass').focus();}
    });
	$('#pass').keypress(function(e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if(keycode == 13)
		{
				var us=$('#user').val(),pa=$('#pass').val();
			if(us!='' && pa!=''){
			$.ajax({
				url:'val_login.php',
				type:'POST',
				data:{usuario:us,pass:pa},
				success:function(rsp){ window.location=rsp;},
				error: function() { alert( "Ha ocurrido un error al intentar conectarse a la base de datos" );}
				});
			}else{
				alert('Debe ingresar usuario y contraseña!');
				if(us==''){$('#user').focus();}else{$('#pass').focus();}
			}
		}
	});	
	$('#btningresar').click(function(e) {
		var us=$('#user').val(),pa=$('#pass').val();
		if(us!='' && pa!=''){
		$.ajax({
			url:'val_login.php',
			type:'POST',
			data:{usuario:us,pass:pa},
			success:function(rsp){ window.location=rsp;},
			error: function() { alert( "Ha ocurrido un error al intentar conectarse a la base de datos" );}
			});
		}else{
			alert('Debe ingresar usuario y contraseña!');
			if(us==''){$('#user').focus();}else{$('#pass').focus();}
			}
    });
	
});