<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";

if (isset($_SESSION["login"]))
{
  $id_cita=(int)$_POST["id_cita"];
  
  $result=$mysqli->query("SELECT id FROM citas WHERE id=$id_cita AND id_administrador=".$_SESSION["login"]);
  
  if ($result->num_rows)
  {
	  $result_delete=$mysqli->query("DELETE citas.* FROM citas WHERE id=$id_cita");
	  
	  if ($result_delete)
	   $respuesta->mensaje="Cita eliminada correctamente";
	  else
	  {
	   $respuesta->mensaje="La cita no se ha podido eliminar";
	   $respuesta->contestacion=1;
	  }
  }
  else
  {
   $respuesta->mensaje="Error - Solo puedes borrar citas en las que estás asignado/a";
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