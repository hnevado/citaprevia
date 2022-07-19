<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";

if (isset($_SESSION["login"]))
{
  
  $ruta="../".$_POST["ruta"];
  $id_fichero=(int)$_POST["id_fichero"];
  
  if (unlink($ruta))
  {
	  
	  $result=$mysqli->query("DELETE ficheros.* FROM ficheros WHERE id_fichero=$id_fichero");
	  
	  if ($result)
	   $respuesta->mensaje="Fichero eliminado";
	  else
	  {
	   $respuesta->mensaje="Se ha eliminado el fichero del servidor pero NO la referencia de la base de datos";
	   $respuesta->contestacion=0;
	  }
	  
  }
  else
  {
	  $respuesta->mensaje="Error - El fichero no se ha podido eliminar del servidor";
	  $respuesta->contestacion=1;
  }
  
  
}
else
{
 $respuesta->mensaje="Tu sesión ha caducado. Por favor, vuelve a iniciar sesión";
 $respuesta->contestacion=1;
}




echo json_encode($respuesta);
?>