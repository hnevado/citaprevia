<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";

if (isset($_SESSION["login"]))
{
	if (!isset($_POST["sexo"]))
	{
		
		$respuesta->mensaje="Debes seleccionar el sexo del paciente";
		$respuesta->contestacion=1;
	}
	else
	{
	  $nombre=$mysqli->real_escape_string(trim(htmlentities($_POST["nombre"],ENT_QUOTES)));
	  $apellidos=$mysqli->real_escape_string(trim(htmlentities($_POST["apellidos"],ENT_QUOTES)));
	  $dni=$mysqli->real_escape_string(trim(htmlentities($_POST["dni"],ENT_QUOTES)));
	  $fecha_nacimiento=$_POST["fecha_nacimiento"];
	  $telefono_fijo=(int)$_POST["telefono_fijo"];
	  $movil1=(int)$_POST["telefono_movil1"];
	  $movil2=(int)$_POST["telefono_movil2"];
	  $email=$mysqli->real_escape_string(trim($_POST["email"]));  
	  $direccion=$mysqli->real_escape_string(trim(htmlentities($_POST["direccion"],ENT_QUOTES)));
	  $localidad=$mysqli->real_escape_string(trim(htmlentities($_POST["localidad"],ENT_QUOTES)));
	  $provincia=$mysqli->real_escape_string(trim(htmlentities($_POST["provincia"],ENT_QUOTES)));
	  $cp=(int)$_POST["cp"];
	  $sexo=(int)$_POST["sexo"];
	  $fecha_registro=date("Y-m-d H:i:s");
	  $observaciones=$mysqli->real_escape_string(trim(htmlentities($_POST["observaciones"],ENT_QUOTES)));
	  
	  if ($nombre == "")
	  {
		  $respuesta->mensaje="El nombre es obligatorio";
		  $respuesta->contestacion=1;
	  }
	  else if ($apellidos == "")
	  {
		  $respuesta->mensaje="Los apellidos son obligatorios";
		  $respuesta->contestacion=1; 
	  }
	  else if ($fecha_nacimiento == "")
	  {

		  $respuesta->mensaje="La fecha de nacimiento es obligatoria";
		  $respuesta->contestacion=1; 

	  }
	  else if ($telefono_fijo == 0 && $movil1 == "" && $movil2 == "")
	  {
		  $respuesta->mensaje="Debes indicar algún número de teléfono";
		  $respuesta->contestacion=1; 
	  }
	  else
	  {
		 
		 if ($telefono_fijo == 0)
		   $telefono_fijo="NULL";
		   
		 if ($movil1 == 0)
		   $movil1="NULL";
		   
		 if ($movil2 == 0)
		   $movil2="NULL";
		
		 
		 $result=$mysqli->query("INSERT pacientes(nombre,apellidos,nif,fecha_nacimiento,sexo,observaciones,telefono_fijo,telefono_movil,telefono_movil2,email,direccion,localidad,provincia,cp,fecha_registro) VALUES ('$nombre','$apellidos','$dni','$fecha_nacimiento',$sexo,'$observaciones',$telefono_fijo,$movil1,$movil2,'$email','$direccion','$localidad','$provincia',$cp,'$fecha_registro')");
		
		 if ($result)
		 {
			$respuesta->mensaje="Paciente dado de alta correctamente. Ahora puedes asignarle una cita"; 
		 }
		 else
		 {
			 //echo "INSERT pacientes(nombre,apellidos,nif,sexo,observaciones,telefono_fijo,telefono_movil,telefono_movil2,email,direccion,localidad,provincia,cp,fecha_registro) VALUES ('$nombre','$apellidos','$dni',$sexo,'$observaciones',$telefono_fijo,$movil1,$movil2,'$email','$direccion','$localidad','$provincia',$cp,'$fecha_registro')";
			$respuesta->mensaje="Ocurrió un error al dar de alta el paciente. Comprueba los campos y vuelve a intentarlo";
			$respuesta->contestacion=1; 
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