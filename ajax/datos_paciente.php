<?php
session_start();
session_regenerate_id();

include("../conexion.php");
$respuesta = new stdClass();
$respuesta->contestacion=0;
$respuesta->mensaje="";
$id_paciente=(int)$_POST["id_paciente"];
$anotaciones="";
$ficheros="<p><strong>Ficheros Subidos</strong><hr/></p>";
if (isset($_SESSION["login"]))
{
	if ($id_paciente == 0)
	{
		
		$respuesta->mensaje="Debes seleccionar un paciente";
		$respuesta->contestacion=1;
	}
	else
	{

		$result=$mysqli->query("SELECT * FROM pacientes WHERE id=$id_paciente");
		
		if ($result->num_rows)
		{
			
			while ($arr_result = $result->fetch_array())
			{
				
			  $respuesta->nombre=html_entity_decode($arr_result["nombre"]);
			  $respuesta->apellidos=html_entity_decode($arr_result["apellidos"]);
			  $respuesta->nif=html_entity_decode($arr_result["nif"]);
			  $respuesta->fecha_nacimiento=$arr_result["fecha_nacimiento"];
			  $respuesta->sexo=$arr_result["sexo"];
			  $respuesta->observaciones=html_entity_decode($arr_result["observaciones"]);
			  $respuesta->telefono_fijo=$arr_result["telefono_fijo"];
			  $respuesta->telefono_movil=$arr_result["telefono_movil"];
			  $respuesta->telefono_movil2=$arr_result["telefono_movil2"];
			  $respuesta->email=$arr_result["email"];
			  $respuesta->direccion=html_entity_decode($arr_result["direccion"]);
			  $respuesta->localidad=html_entity_decode($arr_result["localidad"]);
			  $respuesta->provincia=html_entity_decode($arr_result["provincia"]);
			  $respuesta->cp=$arr_result["cp"];
				
			}
			
			//Ficheros
			$result_ficheros=$mysqli->query("SELECT id_fichero,fichero FROM ficheros WHERE id_paciente=".$id_paciente);
			if ($result_ficheros->num_rows)
			{
				while ($arr_result_ficheros = $result_ficheros->fetch_array())
				{
					
					$id_fichero=$arr_result_ficheros["id_fichero"];
					$fichero=str_replace("../","",$arr_result_ficheros["fichero"]);
					
					$ficheros.="<span class='eliminar_fichero' onclick='eliminaFichero($id_fichero,\"$fichero\")'>X</span> <a target='_blank' href='".$fichero."'>".str_replace("ficheros/","",$fichero)."</a><br/>";
					
				}
				$ficheros.="<hr/>";
				$respuesta->ficheros=$ficheros;
			}
			else
			{
				$respuesta->ficheros="Todavía no has subido ficheros a este paciente";
			}
			
			
			//Anotaciones
			$result_anotaciones=$mysqli->query("SELECT anotaciones.*, administradores.especialidad as especialista FROM anotaciones,administradores WHERE administradores.id = anotaciones.id_administrador AND anotaciones.id_paciente=$id_paciente ORDER BY fecha,hora DESC");
			if ($result_anotaciones->num_rows)
			{
				while ($arr_result_anotaciones = $result_anotaciones->fetch_array())
				{
					$id_anotacion=$arr_result_anotaciones["id_anotacion"];
					
				 if ($arr_result_anotaciones["nutricion"] == 1)
				 {
					//$anotaciones.="<b>".date("d-m-Y",strtotime($arr_result_anotaciones["fecha"]))." a las ".$arr_result_anotaciones["hora"]."</b> por <b>".$arr_result_anotaciones["especialista"]."</b><br/>";
					$anotaciones.="<table style='background:#e0bfc573;margin-top:25px' class='table'>";
					 $anotaciones.="<tr><td colspan='3' style='background:black;color:white;'><span onclick='deleteObservacion($id_anotacion)' style='color:red;font-weight:bold'>X</span> HOJA SEGUIMIENTO NUTRICIÓN</td></tr>";
					 $anotaciones.="<tr><td style='background:#c0efc0ad'>Fecha<br/>".date("d-m-Y",strtotime($arr_result_anotaciones["fecha"]))."</td><td style='background:#c0efc0ad'>Peso<br/>".$arr_result_anotaciones["peso"]."</td><td style='background:#c0efc0ad'>Kg. Perdidos<br/>".$arr_result_anotaciones["kg_perdidos"]."</td></tr>";
					 $anotaciones.="<tr><td>Hora<br/>".$arr_result_anotaciones["hora"]."</td><td>Regla<br/>".$arr_result_anotaciones["regla"]."</td><td rowspan='3' style='background:#feffd5'>Tratamiento<br/>".$arr_result_anotaciones["tratamiento"]."</td></tr>";
					 $anotaciones.="<tr><td>Ropa<br/>".$arr_result_anotaciones["ropa"]."</td><td>Baño<br/>".$arr_result_anotaciones["banyo"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Salud<br/>".$arr_result_anotaciones["salud"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Ánimos<br/>".$arr_result_anotaciones["animos"]."</td><td rowspan='3' style='background:#feffd5'>Tratamiento dado<br/>".$arr_result_anotaciones["tratamiento_dado"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Observaciones<br/>".$arr_result_anotaciones["anotacion"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Acontecimientos<br/>".$arr_result_anotaciones["acontecimientos"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#c6bfe073' colspan='2'>Dieta<br/>".$arr_result_anotaciones["dieta"]."</td></tr>";
					$anotaciones.="</table>";
					 
				 }
				 else if ($arr_result_anotaciones["psicologia"] == 1)
				 {
					$anotaciones.="<table style='background:#e0bfc573;margin-top:25px' class='table'>";
					$anotaciones.="<tr><td colspan='3' style='background:black;color:white;'><span onclick='deleteObservacion($id_anotacion)' style='cursor:pointer;color:red;font-weight:bold'>X</span> HOJA SEGUIMIENTO PSICOLOGÍA</td></tr>";
					$anotaciones.="<tr><td style='background:#c0efc0ad'>Fecha<br/>".date("d-m-Y",strtotime($arr_result_anotaciones["fecha"]))."</td><td style='background:#c0efc0ad'>Antecedentes<br/>".$arr_result_anotaciones["antecedentes"]."</td></tr>";
					$anotaciones.="<tr><td>Motivo consulta<br/>".$arr_result_anotaciones["motivo_consulta"]."</td><td>Situación actual<br/>".$arr_result_anotaciones["situacion_actual"]."</td></tr>";
					$anotaciones.="<tr><td style='background:#c6bfe073' colspan='2'>Anotaciones generales<br/>".$arr_result_anotaciones["anotacion"]."</td></tr>";
				   $anotaciones.="</table>";
				 }
				 else if ($arr_result_anotaciones["podologia"] == 1) 
				 {

					$anotaciones.="<table style='background:#e0bfc573;margin-top:25px' class='table'>";
					 $anotaciones.="<tr><td colspan='3' style='background:black;color:white;'><span onclick='deleteObservacion($id_anotacion)' style='cursor:pointer;color:red;font-weight:bold'>X</span> HOJA SEGUIMIENTO PODOLOGÍA</td></tr>";
					 $anotaciones.="<tr><td style='background:#c0efc0ad'>Fecha<br/>".date("d-m-Y",strtotime($arr_result_anotaciones["fecha"]))."</td><td style='background:#c0efc0ad'>Motivo consulta<br/>".$arr_result_anotaciones["motivo_consulta"]."</td><td style='background:#c0efc0ad'>Antecedentes<br/>".$arr_result_anotaciones["antecedentes"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Antecedentes podológicos<br/>".$arr_result_anotaciones["antecedentes_podologicos"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Medicación<br/>".$arr_result_anotaciones["medicacion"]."</td><td rowspan='3' style='background:#feffd5'>Tratamiento dado<br/>".$arr_result_anotaciones["tratamiento"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Alergias<br/>".$arr_result_anotaciones["alergias"]."</td></tr>";
					 $anotaciones.="<tr><td style='background:#a6ccec9e' colspan='2'>Seguimiento<br/>".$arr_result_anotaciones["seguimiento"]."</td></tr>";
					$anotaciones.="</table>";

				 }
				 else
				 {
					$anotaciones.="<table style='background:#e0bfc573;margin-top:25px' class='table'>";
					$anotaciones.="<tr><td colspan='3' style='background:black;color:white;'><span onclick='deleteObservacion($id_anotacion)' style='cursor:pointer;color:red;font-weight:bold'>X</span> OBSERVACIONES ".strtoupper(html_entity_decode($arr_result_anotaciones["especialista"]))."</td></tr>";
					$anotaciones.="<tr><td style='background:#c0efc0ad'>Fecha<br/>".date("d-m-Y",strtotime($arr_result_anotaciones["fecha"]))."</td><td style='background:#c0efc0ad'>Observación<br/>".$arr_result_anotaciones["anotacion"]."</td></tr>";
					//$anotaciones.="<tr><td<b>".date("d-m-Y",strtotime($arr_result_anotaciones["fecha"]))." a las ".$arr_result_anotaciones["hora"]."</b> por <b>".$arr_result_anotaciones["especialista"]."</b>: ".$arr_result_anotaciones["anotacion"]."</tr>";
					$anotaciones.="</table>";
				 }
				
				}
				$respuesta->anotaciones=$anotaciones;
			}	
			else
		    {
			  $respuesta->anotaciones="No hay anotaciones para este paciente...";
			}
			
		}
		else
		{
			$respuesta->mensaje="No se han encontrado datos de este paciente";
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