<?php
session_start();
session_regenerate_id();
include("../conexion.php");

$id_paciente=(int)$_GET["id"];
$fichero = $_FILES['file']['name'];
$respuesta = new stdClass();
$respuesta->contestacion=0; 
if (isset($_SESSION["login"]))
{

	if ($_FILES['file']['name'] == "") {
		 $respuesta->mensaje="Debes subir un fichero";
		 $respuesta->contestacion=1;
	}
	else
	{
		 //extract($_REQUEST);
		 $ext = pathinfo($fichero, PATHINFO_EXTENSION);

		 if( strtolower($ext) != 'pdf' && strtolower($ext) != 'mpg' && strtolower($ext) != 'mp4' && strtolower($ext) != 'gif' && strtolower($ext) != 'jpg' && strtolower($ext) != 'png' && strtolower($ext) != 'jpeg'){
			$respuesta->contestacion=1; 
			$respuesta->mensaje="Extensión del fichero incorrecta. Ficheros permitidos: PDF, MPG, MP4, JPG, GIF, JPEG y PNG";
		 }
		 else if (filesize($_FILES['file']['tmp_name']) > 8000000)
		 {
			 $respuesta->contestacion=1; 
			 $respuesta->mensaje="El fichero es demasiado grande. Tamaño máximo permitido: 8 MB";
		 }
		 else
		 { 

			$fichero   =   preg_replace('/\\s+/', '-', time()."_".$fichero);
			$path  =  "../ficheros/".$fichero;

			if (move_uploaded_file($_FILES['file']['tmp_name'],$path))
			{
				
				$result=$mysqli->query("INSERT ficheros(id_paciente,fichero) VALUES ($id_paciente,'$path')");
			  
				if ($result)
				{
					$respuesta->mensaje="Fichero guardado correctamente en la base de datos";
				}
				else
				{
					$respuesta->mensaje="El fichero no se ha podido guardar en la base de datos. Vuelve a intentarlo";
					$respuesta->contestacion=1;
				}
				
			}	
			else
			{
					$respuesta->mensaje="El fichero es correcto pero no se ha podido guardar. Por favor, cambia su nombre y vuelve a intentarlo";
					$respuesta->contestacion=1;
			}
		}
		
	}
}
else
{
 $respuesta->mensaje="Tu sesión ha caducado. Por favor, vuelve a iniciar sesión";
 $respuesta->contestacion=1;
}

echo json_encode($respuesta);
?>