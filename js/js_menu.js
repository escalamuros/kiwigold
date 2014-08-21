// JavaScript Document
$	(document).ready(function(e) {
	
	var he=window.innerHeight-50,minpeso=999999,maxpeso=0,minpres=999999,maxpres=0,mincol=999999,maxcol=0,minss=999999,maxss=0,minseca=999999,maxseca=0;
	$('#contenedor').css('height',he);
	
	$('.barra').click(function(){
		var opcion=$(this).attr('id');
		$.ajax({url:opcion+'.php',type:'post',success:function(e){$('#cont_centro').html(e);}});	
		
	});
	
	$('#umsearch').keyup(function(e) {
		if($('#umsearch').val()!=''){
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{findum:$('#umsearch').val()},
			success:function(e){
				$('#rs_search').show(200);
				$('#rs_search').html(e);	
				}
			});
		}else{$('#rs_search').hide(200);}
    });
	
	$('#rs_search').click(function(e) {
        alert('dddd');
    });
    
	$('#finsession').click(function(){window.location='logout.php';});
	
	
	
	$('.cuadrito').keydown(function(e) {
        if(e.keyCode==38){
			var fo=this.id.substring(0,6);
			var fu=this.id.substring(6);
			if(fu!=1){
				fu=parseInt(fu)-1;
				$('#'+fo+fu).focus();
				}
			}
		if(e.keyCode==40 || e.keyCode==13){
			var fo=this.id.substring(0,6);
			var fu=this.id.substring(6);
			if(fu!=48){
				fu=parseInt(fu)+1;
				$('#'+fo+fu).focus();
				}
			
			}
    });
	
	$('.cuadrito').change(function(e) {	
       	var fo=this.id.substring(0,6);
		var fu=this.id.substring(6);
		rangos(fo,fu);
		calcular(fu);
		desviaciones();
    });
	$('.cuadrito').focusin(function(e) {
		
		if($('#'+this.id).val()==0){
			$('#'+this.id).val('');
			}
		/*if($('#'+this.id).val(''){
			alert ('ddd');
		*/	
		
	});
	$('#fmuestra').change(function(e) {
        $.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{nuevafecha:$('#fmuestra').val(),fin:sessionStorage['ning']}
			});
    });
	
	$('#btn_subir').click(function(e) {
        $.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{
				subir_data:sessionStorage['ning']
				},
			success:function(){alert ('Informacion subida con exito!')}
			});
    });
	
	$('#btningresar').click(function(e) {
		var us=$('#user').val(),pa=$('#pass').val();
		if(us!='' && pa!=''){
		$.ajax({
			url:'recibekg.php',
			type:'POST',
			data:{usuario:us,pass:pa},
			success:function(){
					location.href='index.php';
				}
			});
		}else{
			alert('Debe ingresar usuario y contraseña!');
			if(us==''){$('#user').focus();}else{$('#pass').focus();}
			}
    });
	$('.adder').click(function(e) {
		
		
		for(var aa=1;aa<=48;aa++){
		
			var numm=$('#nummer'+aa).html();
			var peso=$('#l_peso'+aa).val();
			var presion1=$('#l_pre1'+aa).val();
			var presion2=$('#l_pre2'+aa).val();		
			var ss=$('#l_solu'+aa).val();
			var color1=$('#l_col1'+aa).val();
			var color2=$('#l_col2'+aa).val();
			var pesoi=$('#l_pesi'+aa).val();
			var pesof=$('#l_pesf'+aa).val();
			var obs=$('#l_obse'+aa).val();
			var ning=sessionStorage['ning'];
			$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{numm:numm,peso:peso,presion1:presion1,presion2:presion2,ss:ss,color1:color1,color2:color2,pesoi:pesoi,pesof:pesof,obs:obs,ingbd:ning},
			success:function(e){
				if(e==48){alert ('Datos guardados con exito!')}
				}
				
			});		
			}
			
    });
	
	function rangos(fo,fu){
		var nu=$('#'+fo+fu).val(),box=$('#'+fo+fu);
		if (fo=='l_peso'){
			if(nu<60 || nu>191){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
			}
		if (fo=='l_pre1' || fo=='l_pre2' ){
			if(nu<8 || nu>17){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
			}
		if (fo=='l_solu'){
			if(nu<3.7 || nu>12){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
			}
		if (fo=='l_col1' || fo=='l_col2'){
			if(nu<103 || nu>115){alert('Sus valores estan fuera de rango permitido. De todas formas, estos se guardaran para referencia');}
			}
	}
	function calcular(fu){
		var p1=$('#l_pre1'+fu).val();
		var p2=$('#l_pre2'+fu).val();
		var p3=$('#l_col1'+fu).val();
		var p4=$('#l_col2'+fu).val();
		var p5=$('#l_pesi'+fu).val();
		var p6=$('#l_pesf'+fu).val();
		if(p1!='' && p2!=''){
			var total=((parseFloat(p1)+parseFloat(p2))/2).toFixed(1);
        	$('#p_pres'+fu).html(total);
			}else{$('#p_pres'+fu).html('');}
		if(p3!='' && p4!=''){
			var total=((parseFloat(p3)+parseFloat(p4))/2).toFixed(1);
        	$('#p_colo'+fu).html(total);
			}else{$('#p_colo'+fu).html('');}
		if(p5!='' && p6!=''){
			var total=(100*(parseFloat(p6)/parseFloat(p5))).toFixed(1);
        $('#m_seca'+fu).html(total);
			}else{$('#m_seca'+fu).html('');}
		}
	$('#fanalisis').change(function(e) { // AQUI REVISA SI EXISTEN ANALISIS
		
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{um:$('#flab').val(),fecha:$('#fanalisis').val()},
			success:function(e){
				
				if(e!=''){traerDatos(e);}else{crearDatos();}
				}
			});
        $('#add_data').show(200);
		$('#resultados').show(250);
    });
	function crearDatos(){
		for(var de=1;de<=48;de++){
			$('#l_peso'+de).val('');
			$('#l_pre1'+de).val('');
			$('#l_pre2'+de).val('');
			$('#l_solu'+de).val('');
			$('#l_col1'+de).val('');
			$('#l_col2'+de).val('');
			$('#l_pesi'+de).val('');
			$('#l_pesf'+de).val('');
			$('#l_obse'+de).val('');
			calcular(de);
			desviaciones();
		}
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{lab:$('#flab').val(),fecha:$('#fanalisis').val()},
			success:function(e){
				sessionStorage['ning']=e;
				}
			});
		}
	function traerDatos(e){
		sessionStorage['ning']=e;
		$.ajax({
			url:'recibeajax.php',
			type:'POST',
			data:{ning:e},
			dataType:"json",
			success:function(e){
				completarCampos(e);
				}
			});
		}
	function completarCampos(per){
		for(var de=1;de<=48;de++){
			$('#l_peso'+de).val(per[de][1]);
			$('#l_pre1'+de).val(per[de][2]);
			$('#l_pre2'+de).val(per[de][3]);
			$('#l_solu'+de).val(per[de][4]);
			$('#l_col1'+de).val(per[de][5]);
			$('#l_col2'+de).val(per[de][6]);
			$('#l_pesi'+de).val(per[de][7]);
			$('#l_pesf'+de).val(per[de][8]);
			$('#l_obse'+de).val(per[de][9]);
			calcular(de);
			desviaciones();
			}	
		}
	function desviaciones(){
		
		var sumapeso=0,validospeso=0,sumdifpeso,prompeso,difpeso=0;
		var sumapres=0,validospres=0,sumdifpres,prompres,difpres=0;
		var sumasss=0,validosss=0,sumdifss,promss,difss=0;
		var sumacol=0,validoscol=0,sumdifcol,promcol,difcol=0;
		var sumaseca=0,validosseca=0,sumdifseca,promseca,difseca=0;
		for(var de=1;de<=48;de++){
			if($('#l_peso'+de).val()>0){
				
				sumapeso=parseFloat($('#l_peso'+de).val())+sumapeso;
				validospeso++;
				if (minpeso>parseFloat($('#l_peso'+de).val())){minpeso=parseFloat($('#l_peso'+de).val());}
				if (maxpeso<parseFloat($('#l_peso'+de).val())){maxpeso=parseFloat($('#l_peso'+de).val());}
			}
			if($('#p_pres'+de).html()>0){
				
				sumapres=parseFloat($('#p_pres'+de).html())+sumapres;
				validospres++;
				if (minpres>parseFloat($('#p_pres'+de).html())){minpres=parseFloat($('#p_pres'+de).html());}
				if (maxpres<parseFloat($('#p_pres'+de).html())){maxpres=parseFloat($('#p_pres'+de).html());}
			}
			if($('#p_colo'+de).html()>0){
				
				sumacol=parseFloat($('#p_colo'+de).html())+sumacol;
				validoscol++;
				if (mincol>parseFloat($('#p_colo'+de).html())){mincol=parseFloat($('#p_colo'+de).html());}
				if (maxcol<parseFloat($('#p_colo'+de).html())){maxcol=parseFloat($('#p_colo'+de).html());}
			}
			if($('#l_solu'+de).val()>0){
				
				sumasss=parseFloat($('#l_solu'+de).val())+sumasss;
				validosss++;
				if (minss>parseFloat($('#l_solu'+de).val())){minss=parseFloat($('#l_solu'+de).val());}
				if (maxss<parseFloat($('#l_solu'+de).val())){maxss=parseFloat($('#l_solu'+de).val());}
			}
			if($('#m_seca'+de).html()>0){
				
				sumaseca=parseFloat($('#m_seca'+de).html())+sumaseca;
				validosseca++;
				if (minseca>parseFloat($('#m_seca'+de).html())){minseca=parseFloat($('#m_seca'+de).html());}
				if (maxseca<parseFloat($('#m_seca'+de).html())){maxseca=parseFloat($('#m_seca'+de).html());}
			}
		}
		
		prompeso=(sumapeso/validospeso).toFixed(1);
		prompres=(sumapres/validospres).toFixed(1);
		promcol=(sumacol/validoscol).toFixed(1);
		promss=(sumasss/validosss).toFixed(1);
		promseca=(sumaseca/validosseca).toFixed(1);
		
		for (var ede=1;ede<=48;ede++){	
			if($('#l_peso'+ede).val()>0){
				sumdifpeso=Math.pow(parseFloat($('#l_peso'+ede).val())-prompeso,2);
				difpeso=difpeso+sumdifpeso;
			}
			if($('#p_pres'+ede).html()>0){
				sumdifpres=Math.pow(parseFloat($('#p_pres'+ede).html())-prompres,2);
				difpres=difpres+sumdifpres;
			}
			if($('#p_colo'+ede).html()>0){
				sumdifcol=Math.pow(parseFloat($('#p_colo'+ede).html())-promcol,2);
				difcol=difcol+sumdifcol;
			}
			if($('#l_solu'+ede).val()>0){
				sumdifss=Math.pow(parseFloat($('#l_solu'+ede).val())-promss,2);
				difss=difss+sumdifss;
			}
			if($('#m_seca'+ede).html()>0){
				sumdifseca=Math.pow(parseFloat($('#m_seca'+ede).html())-promseca,2);
				difseca=difseca+sumdifseca;
			}
		}
		var desv=Math.sqrt(difpeso/validospeso).toFixed(1);
		var desvp=Math.sqrt(difpres/validospres).toFixed(1);
		var desvc=Math.sqrt(difcol/validoscol).toFixed(1);
		var desvs=Math.sqrt(difss/validosss).toFixed(1);
		var desvm=Math.sqrt(difseca/validosseca).toFixed(1);
		
		
		$('#resvalidos').html(validospeso);
		$('#resprom').html(prompeso);
		$('#resmin').html(minpeso);
		$('#resmax').html(maxpeso);
		$('#resdesv').html(desv);
		$('#resvalidosp').html(validospres);
		$('#respromp').html(prompres);
		$('#resminp').html(minpres);
		$('#resmaxp').html(maxpres);
		$('#resdesvp').html(desvp);
		$('#resvalidosc').html(validoscol);
		$('#respromc').html(promcol);
		$('#resminc').html(mincol);
		$('#resmaxc').html(maxcol);
		$('#resdesvc').html(desvc);
		$('#resvalidoss').html(validosss);
		$('#resproms').html(promss);
		$('#resmins').html(minss);
		$('#resmaxs').html(maxss);
		$('#resdesvs').html(desvs);
		$('#resvalidosm').html(validosseca);
		$('#respromm').html(promseca);
		$('#resminm').html(minseca);
		$('#resmaxm').html(maxseca);
		$('#resdesvm').html(desvm);
		$('#minpeso').html((prompeso-3.35*desv).toFixed(1));
		$('#maxpeso').html((parseFloat(prompeso)+3.35*parseFloat(desv)).toFixed(1));
		$('#minpre').html((prompres-3.35*desvp).toFixed(1));
		$('#maxpre').html((parseFloat(prompres)+3.35*parseFloat(desvp)).toFixed(1));
		$('#minss').html((promss-3.35*desvs).toFixed(1));
		$('#maxss').html((parseFloat(promss)+3.35*parseFloat(desvs)).toFixed(1));
		$('#mincol').html((promcol-3.35*desvc).toFixed(1));
		$('#maxcol').html((parseFloat(promcol)+3.35*parseFloat(desvc)).toFixed(1));
		$('#minseca').html((promseca-3.35*desvm).toFixed(1));
		$('#maxseca').html((parseFloat(promseca)+3.35*parseFloat(desvm)).toFixed(1));
		$('#deppeso').html(((prompeso*validospeso-minpeso-maxpeso)/(validospeso-2)).toFixed(1));
		$('#deppre').html(((prompres*validospres-minpres-maxpres)/(validospres-2)).toFixed(1));
		$('#depss').html(((promss*validosss-minss-maxss)/(validosss-2)).toFixed(1));
		$('#depcol').html(((promcol*validoscol-mincol-maxcol)/(validoscol-2)).toFixed(1));
		$('#depseca').html(((promseca*validosseca-minseca-maxseca)/(validosseca-2)).toFixed(1));
		}
	
});