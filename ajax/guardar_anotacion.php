<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";
$id_paciente=(int)$_POST["id_paciente"];
$anotacion=$mysqli->real_escape_string(trim(htmlentities($_POST["anotacion"],ENT_QUOTES)));


if (isset($_POST["peso"]))
{
 $peso=$mysqli->real_escape_string(trim(htmlentities($_POST["peso"],ENT_QUOTES)));
 $nutricion=1;
}
else
{
 $peso="";
 $nutricion=0;
}

if (isset($_POST["kg_perdidos"]))
 $kg_perdidos=$mysqli->real_escape_string(trim(htmlentities($_POST["kg_perdidos"],ENT_QUOTES)));
else
 $kg_perdidos="";

if (isset($_POST["regla"]))
 $regla=$mysqli->real_escape_string(trim(htmlentities($_POST["regla"],ENT_QUOTES)));
else
 $regla="";

if (isset($_POST["ropa"]))
 $ropa=$mysqli->real_escape_string(trim(htmlentities($_POST["ropa"],ENT_QUOTES)));
else
 $ropa="";

if (isset($_POST["banyo"]))
 $banyo=$mysqli->real_escape_string(trim(htmlentities($_POST["banyo"],ENT_QUOTES)));
else
 $banyo="";

if (isset($_POST["salud"]))
 $salud=$mysqli->real_escape_string(trim(htmlentities($_POST["salud"],ENT_QUOTES)));
else
 $salud="";

if (isset($_POST["animos"]))
 $animos=$mysqli->real_escape_string(trim(htmlentities($_POST["animos"],ENT_QUOTES)));
else
 $animos="";

if (isset($_POST["acontecimientos"]))
 $acontecimientos=$mysqli->real_escape_string(trim(htmlentities($_POST["acontecimientos"],ENT_QUOTES)));
else
 $acontecimientos="";

if (isset($_POST["dieta"]))
 $dieta=$mysqli->real_escape_string(trim(htmlentities($_POST["dieta"],ENT_QUOTES)));
else
 $dieta="";
 
if (isset($_POST["tratamiento"]))
 $tratamiento=$mysqli->real_escape_string(trim(htmlentities($_POST["tratamiento"],ENT_QUOTES)));
else
 $tratamiento="";

if (isset($_POST["tratamiento_dado"]))
 $tratamiento_dado=$mysqli->real_escape_string(trim(htmlentities($_POST["tratamiento_dado"],ENT_QUOTES)));
else
 $tratamiento_dado=""; 
 
if (isset($_POST["antecedentes"]))
 $antecedentes=$mysqli->real_escape_string(trim(htmlentities($_POST["antecedentes"],ENT_QUOTES)));
else
 $antecedentes="";

if (isset($_POST["motivo_consulta"]))
 $motivo_consulta=$mysqli->real_escape_string(trim(htmlentities($_POST["motivo_consulta"],ENT_QUOTES)));
else
 $motivo_consulta="";

if (isset($_POST["situacion_actual"]))
{
 $situacion_actual=$mysqli->real_escape_string(trim(htmlentities($_POST["situacion_actual"],ENT_QUOTES)));
 $psicologia=1;
}
else
{
 $situacion_actual="";
 $psicologia=0;
}

if (isset($_POST["antecedentes_podologicos"]))
 $antecedentes_podologicos=$mysqli->real_escape_string(trim(htmlentities($_POST["antecedentes_podologicos"],ENT_QUOTES)));
else
 $antecedentes_podologicos="";

 if (isset($_POST["medicacion"]))
 $medicacion=$mysqli->real_escape_string(trim(htmlentities($_POST["medicacion"],ENT_QUOTES)));
else
 $medicacion="";


if (isset($_POST["alergias"]))
 $alergias=$mysqli->real_escape_string(trim(htmlentities($_POST["alergias"],ENT_QUOTES)));
else
 $alergias="";

if (isset($_POST["seguimiento"]))
{
 $seguimiento=$mysqli->real_escape_string(trim(htmlentities($_POST["seguimiento"],ENT_QUOTES)));
 $podologia=1;
}
else
{
 $seguimiento="";
 $podologia=0;
}

if (isset($_SESSION["login"]))
{

  if ($id_paciente == 0)
  {
	  $respuesta->mensaje="Ocurrió un error al cargar el ID del paciente. Vuelve a seleccionarlo del desplegable superior";
  }
  else if (trim($anotacion) == "" && $psicologia == 0)
  {
	  $respuesta->mensaje="La anotación no puede estar vacia";
	  $respuesta->contestacion=1;
  }
  else
  {
	  
	  $anotacion=trim($anotacion);
	  $fecha=date("Y-m-d");
	  $hora=date("H:i");
	  $id_administrador=$_SESSION["login"];
	  
	  
	  
	  $result=$mysqli->query("INSERT anotaciones(id_paciente,id_administrador,anotacion,fecha,hora,peso,kg_perdidos,regla,ropa,banyo,tratamiento,salud,animos,acontecimientos,tratamiento_dado,dieta,nutricion,antecedentes,motivo_consulta,situacion_actual,psicologia,antecedentes_podologicos,medicacion,alergias,seguimiento,podologia) 
	  VALUES ($id_paciente,$id_administrador,'$anotacion','$fecha','$hora','$peso','$kg_perdidos','$regla','$ropa','$banyo','$tratamiento','$salud','$animos','$acontecimientos','$tratamiento_dado','$dieta',$nutricion,'$antecedentes','$motivo_consulta','$situacion_actual',$psicologia,'$antecedentes_podologicos','$medicacion','$alergias','$seguimiento',$podologia)");
	  
	  if ($result)
	    $respuesta->mensaje="Anotación guardada correctamente";
	  else
	  {
	    $respuesta->mensaje="La anotación no se ha podido guardar. Vuelve a intentarlo";
		$respuesta->contestacion=1;
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