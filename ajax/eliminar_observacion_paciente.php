<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";

if (isset($_SESSION["login"]))
{
  
  $id_anotacion=(int)$_POST["id"];
  

  $result=$mysqli->query("DELETE anotaciones.* FROM anotaciones WHERE id_anotacion=$id_anotacion");
	  
  if ($result)
	$respuesta->mensaje="Observación eliminada. Verás los cambios cuando actualices la página";
  else
  {
    $respuesta->mensaje="No se ha podido eliminar la observación";
    $respuesta->contestacion=0;
  }
	  

  
}
else
{
 $respuesta->mensaje="Tu sesión ha caducado. Por favor, vuelve a iniciar sesión";
 $respuesta->contestacion=1;
}




echo json_encode($respuesta);
?>