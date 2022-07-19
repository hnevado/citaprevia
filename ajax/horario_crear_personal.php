<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";

if (isset($_SESSION["login"]))
{
	$id_administrador=(int)$_POST["id_administrador"];
	$fecha=$_POST["fecha"];
	$hora_inicio=$_POST["hora_inicio"];
	$hora_final=$_POST["hora_final"];
	$hora_inicio2=$_POST["hora_inicio2"];
	$hora_final2=$_POST["hora_final2"];
	$sesiones=$_POST["sesiones"];
	
	$mysqli->query("DELETE horas_disponibles.* FROM horas_disponibles WHERE id_administrador=$id_administrador");
	
	for ($i=0;$i<count($sesiones);$i++)
	{
		
		if ($sesiones[$i] != 0)
		{
			//Si ese día permite citas, saco fechas inicio, final
			$segundos = 60 * $sesiones[$i];
			
			$hora_inicio_select=$hora_inicio[$i];
			$hora_final_select=$hora_final[$i];
			$hora_inicio2_select=$hora_inicio2[$i];
			$hora_final2_select=$hora_final2[$i];
			$sesiones_select=$sesiones[$i];
			
			if ($hora_inicio[$i] != "" && $hora_final[$i] != "")
			{
				
				
				
				$x=0;
				do 
				{
				 
				  if ($x == 0)
				   $hora_inicio[$i] = strtotime($hora_inicio[$i]); 
				  else
				  $hora_inicio[$i] = strtotime($hora_inicio[$i]) + $segundos; 
				  
				  
				  $hora_inicio[$i] = date("H:i",$hora_inicio[$i]);
				  
				  $hora_final[$i] = strtotime($hora_final[$i]);
				  $hora_final[$i] = date("H:i",$hora_final[$i]);
				  
				  $fecha[$i]=date("Y-m-d",strtotime($fecha[$i]));
				  
				  if ($hora_inicio[$i] < $hora_final[$i])
				    $mysqli->query("INSERT horas_disponibles(id_administrador,fecha,hora,hora_inicio,hora_final,hora_inicio2,hora_final2,estado,sesiones) VALUES (".$id_administrador.",'".$fecha[$i]."','".$hora_inicio[$i]."','".$hora_inicio_select."','".$hora_final_select."','".$hora_inicio2_select."','".$hora_final2_select."',0,$sesiones_select)");

				  $x++;
				  
			    } while ($hora_inicio[$i] < $hora_final[$i]);
			  
			}
			
			if ($hora_inicio2[$i] != "" && $hora_final2[$i] != "")
			{
				
				$x=0;
				do 
				{
				 
				  if ($x == 0)
				   $hora_inicio2[$i] = strtotime($hora_inicio2[$i]); 
				  else
				   $hora_inicio2[$i] = strtotime($hora_inicio2[$i]) + $segundos; 
				  
				  
				  $hora_inicio2[$i] = date("H:i",$hora_inicio2[$i]);
				  
				  $hora_final2[$i] = strtotime($hora_final2[$i]);
				  $hora_final2[$i] = date("H:i",$hora_final2[$i]);
				  
				  $fecha[$i]=date("Y-m-d",strtotime($fecha[$i]));
				  
				  if ($hora_inicio2[$i] < $hora_final2[$i])
				    $mysqli->query("INSERT horas_disponibles(id_administrador,fecha,hora,hora_inicio,hora_final,hora_inicio2,hora_final2,estado,sesiones) VALUES (".$id_administrador.",'".$fecha[$i]."','".$hora_inicio2[$i]."','".$hora_inicio_select."','".$hora_final_select."','".$hora_inicio2_select."','".$hora_final2_select."',0,$sesiones_select)");

				  $x++;
				  
			    } while ($hora_inicio2[$i] < $hora_final2[$i]);
				
				
			}
			
			
			
			
			
			
		}
		
		
		
		
	}
	
	$respuesta->mensaje="Fechas y horas guardadas";
	

}
else
{
 $respuesta->mensaje="Tu sesión ha caducado. Por favor, vuelve a iniciar sesión";
 $respuesta->contestacion=1;
}




echo json_encode($respuesta);
?>