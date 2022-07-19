<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";

$paciente=(int)$_POST["paciente"];

$fecha_cita=date("Y-m-d",strtotime($_POST["fecha_cita"]));
$hora=$_POST["hora"];
$id_administrador=(int)$_POST["asignada"];
  
if (isset($_SESSION["login"]))
{
	if ($_POST["paciente"] == 0)
	{
		  $respuesta->mensaje="Debes seleccionar un paciente";
		  $respuesta->contestacion=1;
	}
	else if ($_POST["fecha_cita"] == "")
	{
		  $respuesta->mensaje="Debes seleccionar una fecha";
		  $respuesta->contestacion=1; 
	}
	else if ($id_administrador == 0)
	{
		  $respuesta->mensaje="Debes indicar a quién le asignas la cita";
		  $respuesta->contestacion=1; 	
	}
	else
	{
		 
	   $result_existe=$mysqli->query("SELECT id FROM citas WHERE id_paciente=$paciente AND fecha='$fecha_cita' AND hora='$hora'");

	   if ($result_existe->num_rows)
	   {
		  $respuesta->mensaje="Este paciente ya tiene asignada una cita para esta fecha y hora";
		  $respuesta->contestacion=1; 		   
	   }
	   else
	   {
		  
		  for ($i=0;$i<count($hora);$i++)
		  {
			$hora_simple=$hora[$i];
			
		    $result=$mysqli->query("INSERT citas(id_administrador,id_paciente,fecha,hora) VALUES($id_administrador,$paciente,'$fecha_cita','$hora_simple')");
			
			if ($result)
			{
				  $respuesta->mensaje="Cita añadida correctamente";
				  $mysqli->query("UPDATE horas_disponibles set estado=1 WHERE id_administrador=$id_administrador AND fecha='$fecha_cita' AND hora='$hora_simple'");
			}
			else
			{
				  $respuesta->mensaje="La cita no se ha podido añadir. Vuelve a intentarlo";
				  $respuesta->contestacion=1; 			  
			}
		  			
          }
		  
		   
	   }
		
	}
}
else
{
	$respuesta->mensaje="Tu sesión ha caducado. Vuelve a iniciar sesión";
	$respuesta->contestacion=1;
}



echo json_encode($respuesta);
?>