<?php
if($_FILES['archivo']['error']==0)
{
	$nom_carp="../archivos/productor/".$_POST['prod']  ."/".$avi->id;
	if(!is_dir($nom_carp))
	{ mkdir($nom_carp,0777);}
	$sinesp=basename($_FILES['archivo']['name']);
	$sinesp=str_replace(" ","_",$sinesp);
	$i=1;
	do{
		$temp=$nom_carp."/".$i."-".$sinesp;
		$i++;
	}
	while(file_exists($temp));
	$nom_carp=$temp;
	if(move_uploaded_file($_FILES['archivo']['tmp_name'], $nom_carp))
 			{
		$avi->add_arch_adj($nom_carp);
	}
	else
	{	}
}
?>