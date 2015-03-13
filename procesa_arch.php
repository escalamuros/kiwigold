<?php
if(isset($_POST['presionometro']))
{
	$arreglo=array();
	$fp = fopen ( $_FILES['arch']['tmp_name'] , 'r' );
	$i=0;
	$j=0;
	$k=0;
	$a=0; 
	while ( $data = fgetcsv($fp) )
	{ 
		if( $k==0 )
		{
			if($i==0 ) { $i++; }
			else
			{
				if($data[0]=="Maximum") { $k=1; }
				else
				{
					if( $j==0 ) { $a=str_replace(',','.',$data[1]); $j++; }
					else { $arreglo[]=array($a,str_replace(',','.',$data[1])) ; $j=0; }
				}
			}
		}	
	} 
	fclose ( $fp );
	print_r(json_encode($arreglo));
}
if(isset($_POST['colorimetro']))
{
	$arreglo=array();
	$fp = fopen ( $_FILES['arch']['tmp_name'] , 'r' );
	$i=0;
	$j=0;
	$a=0; 
	while ( $data = fgetcsv($fp) )
	{ 
		if($i==0 ) { $i++; }
		else
		{
			if( $j==0 ) { $a=$data[0].'.'.$data[1]; $j++; }
			else { $arreglo[]=array($a,$data[0].'.'.$data[1]) ; $j=0; }
		}	
	} 
	fclose ( $fp );
	print_r(json_encode($arreglo));
}
?>