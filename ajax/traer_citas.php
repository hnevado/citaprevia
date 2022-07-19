<?php
session_start();
session_regenerate_id();
include("../conexion.php");
$respuesta = array();
$fecha=date("Y-m-d");
$id_administrador=(int)$_SESSION["login"];

if ($id_administrador == 1)
{
  $result=$mysqli->query("SELECT pacientes.nombre as nombre_paciente,pacientes.apellidos as apellidos_paciente, administradores.nombre as nombre, citas.fecha as fecha, citas.hora as hora FROM administradores,citas,pacientes WHERE citas.id_administrador = administradores.id AND citas.id_paciente = pacientes.id AND citas.fecha >= '$fecha'");	
}
else
{
  $result=$mysqli->query("SELECT pacientes.nombre as nombre_paciente,pacientes.apellidos as apellidos_paciente, administradores.nombre as nombre, citas.fecha as fecha, citas.hora as hora FROM administradores,citas,pacientes WHERE citas.id_administrador = administradores.id AND citas.id_paciente = pacientes.id AND citas.id_administrador=".$_SESSION["login"]." AND citas.fecha >= '$fecha'");
}

$contador=0;

if ($result->num_rows)
{
	while ($arr_result = $result->fetch_array())
	{
		//echo "ENTRO";
		
		/*$respuesta->startDate=$arr_result["fecha"]." ".$arr_result["hora"];
		$respuesta->endDate=$arr_result["fecha"]." ".$arr_result["hora"];
		$respuesta->summary=$arr_result["nombre_paciente"]." ".$arr_result["apellidos_paciente"]." ( ".$arr_result["hora"]." - ".$arr_result["nombre"].")";
		*/
		$respuesta[$contador]= array("startDate"=>$arr_result["fecha"]." ".$arr_result["hora"],"endDate"=>$arr_result["fecha"]." ".$arr_result["hora"],"summary"=>$arr_result["nombre_paciente"]." ".$arr_result["apellidos_paciente"]." ( ".$arr_result["hora"]." - ".$arr_result["nombre"].")");
	    $contador++;
	}
	
//print_r($respuesta);
	
}
echo json_encode($respuesta);
?>