<?php
session_start();
session_regenerate_id();
include("../conexion.php");
$respuesta = new stdClass();
$respuesta->mensaje="";

$fecha=$_GET["fecha"];
$fecha=date("Y-m-d",strtotime($fecha));

$asignada=(int)$_GET["asignada"];

$result=$mysqli->query("SELECT hora FROM horas_disponibles WHERE id_administrador=$asignada AND fecha='$fecha' AND estado=0");

if ($result->num_rows)
{
	 //Si hay horas disponibles
	 
	 while ($arr_result = $result->fetch_array())
	 {
	  
		$respuesta->mensaje.='<option value="'.$arr_result["hora"].'">'.$arr_result["hora"].'</option>';
		 
	 }
	 
}

echo json_encode($respuesta);
?>