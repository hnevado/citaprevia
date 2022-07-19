<?php
session_start();
session_regenerate_id();

if (!isset($_SESSION["login"]))
 header("Location:index.php");
 
include("conexion.php");
$fecha=date("Y-m-d");
?>
<html lang="es">
  <head>
    <meta name="description" content="app BLANQUER salud">
    <title>App BLANQUER Salud</title>
    <meta charset="utf-8">
	<meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist/simple-calendar.css">
    <link rel="stylesheet" href="css/demo.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<style>
	 label {font-weight:bold;}
	</style>
  </head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="index.php"><img src="https://blanquersalud.es/wp-content/uploads/2019/11/Blanquer-Salud-Nutricion-Podologia-Logopedia-Psicologia-Dietista-1-2-e1573302616706.png"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <?php include("menu.php");?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> Pacientes</h1>
        
        </div>
      </div>

	  
	  <div class="row">
	   <div class="col-md-12">
	    <div class="tile">
			<h3 class="tile-title">Elige un paciente</h3>
			<p><select id="paciente" name="paciente" class="form-control">
				 <option value="">- Selecciona - </option>
				 <?php
				  $result_pacientes=$mysqli->query("SELECT * FROM pacientes ORDER BY nombre,apellidos ASC");
				  while ($arr_result_pacientes = $result_pacientes->fetch_array())
				  {
			    ?>
					<option value="<?php echo $arr_result_pacientes["id"];?>"><?php echo $arr_result_pacientes["nombre"]." ".$arr_result_pacientes["apellidos"];?></option>
				<?php	  
				  }
				 ?>
			</select></p>
			
			<div id="modificacion" style="display:none">
            <h3 class="tile-title">Modificar paciente</h3>
            <form name="pacientes" id="pacientes" method="POST">
			 <div class="row">
			  <div class="col-md-6">
				<p><label><b>Nombre</b></label><br/>
				<input type="text" name="nombre" class="form-control" placeholder="Nombre"></p>
			  </div>
			  
			  <div class="col-md-6">
			   <p><label><b>Apellidos</b></label><br/>
				<input type="text" name="apellidos" class="form-control" placeholder="Apellidos"></p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>DNI/CIF</b></label><br/>
				<input type="text" name="dni" class="form-control" placeholder="DNI / CIF"></p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>Fecha de nacimiento</b></label><br/>
				<input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha nacimiento"></p>
			  </div>

			  <div class="col-md-6">
			    <p><label><b>Sexo</b></label><br/>
				<input type="radio" name="sexo" value="0" id="sexohombre"> Hombre <br/>
				<input type="radio" name="sexo" value="1" id="sexomujer"> Mujer</p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>Teléfono fijo</b></label><br/>
				<input type="text" name="telefono_fijo" class="form-control" placeholder="Teléfono"></p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>Teléfono móvil</b></label><br/>
				<input type="text" name="telefono_movil1" class="form-control" placeholder="Teléfono móvil"></p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>Teléfono móvil 2</b></label><br/>
				<input type="text" name="telefono_movil2" class="form-control" placeholder="Teléfono móvil"></p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>E-mail</b></label><br/>
				<input type="text" name="email" class="form-control" placeholder="Email"></p>
			  </div>
			 
			  <div class="col-md-6">
			    <p><label><b>Dirección</b></label><br/>
				<input type="text" name="direccion" class="form-control" placeholder="Dirección"></p>
			  </div>
			  
			  <div class="col-md-6">
			    <p><label><b>Localidad</b></label><br/>
				<input type="text" name="localidad" class="form-control" placeholder="Localidad"></p>
			  </div>
			 
			  <div class="col-md-6">
			    <p><label><b>Provincia</b></label><br/>
				<input type="text" name="provincia" class="form-control" placeholder="Provincia"></p>
			  </div>
			 
			  <div class="col-md-6">
			    <p><label><b>CP</b></label><br/>
				<input type="text" name="cp" class="form-control" placeholder="Código Postal"></p>
			  </div>
			   
			  <div class="col-md-6">
			    <p><label><b>Observaciones</b></label><br/>
				<textarea name="observaciones" class="form-control" placeholder="Observaciones"></textarea></p>
			  </div> 
			   
			   <div class="col-md-12">
			    <p><input type="button" class="btn btn-success" value="Actualizar datos del paciente" id="btnPaciente"></p>
			  </div>
			  
			 </div>
			</form>
			
			
			<!-- dejar anotaciones -->
			<h3 class="tile-title">Seguimiento paciente</h3>
			<form id="dejar_anotacion" name="dejar_anotacion" method="POST" action="#">
			 <input type="text" class="form-control" style="display:none" name="id_paciente" id="id_paciente_anotacion">	
			<?php
			 if ($_SESSION["login"] == 1)
			 {
			?>
			 <div class="row"> 
			   <div class="col-md-3"><label>Peso</label></div>
			   <div class="col-md-3"><p><input type="text" class="form-control" name="peso" placeholder="peso"></p></div>
			   <div class="col-md-3"><label>Kg. Perdidos</label></div>
			   <div class="col-md-3"><p><input type="text" class="form-control" name="kg_perdidos" placeholder="Kg perdidos"></p></div>
			 </div>
			 
			 <div class="row">
			   <div class="col-md-3"><label>Regla</label></div>
			   <div class="col-md-3"><p><input type="text" class="form-control" name="regla" placeholder="Regla"></p></div>
			   <div class="col-md-3"><label>Ropa</label></div>
			   <div class="col-md-3"><p><input type="text" class="form-control" name="ropa" placeholder="Ropa"></p></div>
			 </div>
			 
			 <div class="row">
			   <div class="col-md-3"><label>Baño</label></div>
			   <div class="col-md-3"><p><input type="text" class="form-control" name="banyo" placeholder="Baño"></p></div>
			   <div class="col-md-3"><label>Salud</label></div>
			   <div class="col-md-3"><p><textarea class="form-control" placeholder="Salud" name="salud"> </textarea></p></div>
			 </div>
			 
			 <div class="row">
			   <div class="col-md-3"><label>Ánimos</label></div>
			   <div class="col-md-3"><p><textarea class="form-control" placeholder="Ánimos" name="animos"> </textarea></p></div>
			   <div class="col-md-3"><label>Observaciones</label></div>
			   <div class="col-md-3">
			    <p><textarea class="form-control" placeholder="Observaciones" name="anotacion"> </textarea></p>
			   </div>
			 </div>
			 
			 <div class="row">
			   <div class="col-md-3"><label>Acontecimientos</label></div>
			   <div class="col-md-3"><p><textarea class="form-control" placeholder="Acontecimientos" name="acontecimientos"> </textarea></p></div>
			   <div class="col-md-3"><label>Dieta</label></div>
			   <div class="col-md-3"><p><textarea class="form-control" placeholder="Dieta" name="dieta"> </textarea></p></div>
			 </div>
			 
			 <div class="row">
			   <div class="col-md-3"><label>Tratamiento</label></div>
			   <div class="col-md-3"><p><textarea class="form-control" placeholder="Tratamiento" name="tratamiento"> </textarea></p></div>
			   <div class="col-md-3"><label>Tratamiento dado</label></div>
			   <div class="col-md-3"><p><textarea class="form-control" placeholder="Tratamiento dado" name="tratamiento_dado"> </textarea></p></div>
			 </div>
			<?php
			 }
			 else if ($_SESSION["login"] == 5)
			 {
				 //Podología
			?>
				<div class="row">
				 <div class="col-md-3"><label>Motivo Consulta</label></div>
				 <div class="col-md-9"><p><textarea class="form-control" placeholder="Motivo consulta" name="motivo_consulta"> </textarea></p></div>
			   </div>
			   <div class="row">
				<div class="col-md-3"><label>Antecedentes</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Antecedentes" name="antecedentes"> </textarea></p></div>
			  </div>
			  <div class="row">
				<div class="col-md-3"><label>Antecedentes podológicos</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Antecedentes" name="antecedentes_podologicos"> </textarea></p></div>
			  </div>
			  <div class="row">
				<div class="col-md-3"><label>Medicación</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Antecedentes" name="medicacion"> </textarea></p></div>
			  </div>
			  <div class="row">
				<div class="col-md-3"><label>Alergias</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Alergias" name="alergias"> </textarea></p></div>
			  </div>
			  <div class="row">
				<div class="col-md-3"><label>Tratamiento</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Tratamiento" name="tratamiento"> </textarea></p></div>
			  </div>
			  <div class="row">
				<div class="col-md-3"><label>Seguimiento</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Seguimiento" name="seguimiento"> </textarea></p></div>
			  </div>
			<?php
			 }
			 else if ($_SESSION["login"] == 6)
			 {
				 //Psicología
			 ?>
				
				<div class="row">
				<div class="col-md-3"><label>Antecedentes</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Antecedentes" name="antecedentes"> </textarea></p></div>
			  </div>
			
			  <div class="row">
			     <div class="col-md-3"><label>Motivo consulta</label></div>
				<div class="col-md-9"><p><textarea class="form-control" placeholder="Motivo consulta" name="motivo_consulta"> </textarea></p></div>
			 </div>
			  <div class="row">
				<div class="col-md-3"><label>Situación actual</label></div>
				<div class="col-md-9">
				<p><textarea class="form-control" placeholder="Situación actual" name="situacion_actual"> </textarea></p>
			 	</div>	
			 </div>
			<?php
			 }
			?>
				<div class="row">
				   <div class="col-md-3"><label>Observaciones generales</label></div>
				   <div class="col-md-9">
					<p><textarea class="form-control" placeholder="Observaciones" name="anotacion"> </textarea></p>
				   </div>
			 </div>
			
			 <div class="row">
			  <div class="col-md-12"><input type="button" class="btn btn-success" value="Guardar anotación del paciente" id="btnAnotacion"></div>
			 </div>
			</form>
			
			<!-- Ficheros subidos -->
			<h3 class="tile-title">Ficheros</h3>
			<form method="POST" id="fichero-form" enctype="multipart/form-data" onsubmit="return false;">	
			  <p><input type="file" name="file" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" id="file"></p>
			  <p><input type="submit" value="SUBIR FICHERO" class="btn btn-success"></p>
			</form>
			
			<div id="msg"></div>
			
			<div id="ficheros_subidos">
			
			</div>
			
			<!-- anotaciones que hay en la bd -->
			<h3 class="tile-title">Anotaciones</h3>
			<div id="info_anotaciones">
			
			</div>
			
			
		   </div>	
			
          </div>
	   </div>
	  </div>
	  
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
	<script src="dist/jquery.simple-calendar.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>
	function deleteObservacion(id)
	{
		
	  if (confirm("Vas a eliminar una observación. Esta acción es irreversible. ¿Estás seguro/a?"))
	  {
		  
		  $.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/eliminar_observacion_paciente.php",
			 data: {id:id},
			 success:function(respuesta){											
					 alert(respuesta.mensaje);
			}
																	
		  }); // fin $.ajax
		  
		  
	  }
		
	}
	
	
	function eliminaFichero(id_fichero,ruta)
	{
		
	  if (confirm("Vas a eliminar un fichero. Esta acción es irreversible. ¿Estás seguro/a?"))
	  {
		  
		  $.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/eliminar_fichero_paciente.php",
			 data: {id_fichero:id_fichero,ruta:ruta},
			 success:function(respuesta){											
					 alert(respuesta.mensaje);
			}
																	
		  }); // fin $.ajax
		  
		  
	  }
		
		
		
	}
	
	$(document).ready(function(){

	

	$("#fichero-form").on("submit", function() {
		
		var id_paciente=document.getElementById("paciente").value;
		$("#msg").html('<div class="alert alert-info"><i class="fa fa-spin fa-spinner"></i> Por favor, espere...</div>');
		  var form = new FormData(this);
		  console.log(form);
		$.ajax({
		  type: "POST",
		  dataType: 'json',	
		  url: "https://blanquersalud.es/app/ajax/subida_ficheros.php?id="+id_paciente,
		  data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		  contentType: false, // The content type used when sending data to the server.
		  cache: false, // To unable request pages to be cached
		  processData: false, // To send DOMDocument or non processed data file it is set to false
		  success: function(respuesta) {
			 
			if (respuesta.contestacion == 0 || parseInt(respuesta.contestacion) == 0) {
				
			  $("#msg").html(
				'<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Fichero subido correctamente.</div>'
			  );
				
			  //setTimeout(function(){ location.reload(); }, 3000);	
			  	 
				
			} else {
			  $("#msg").html(respuesta.mensaje);
			}
		  },
		  error: function(respuestas) {
			$("#msg").html(
			  '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Ocurrió un error.</div>'
			);
		  }
		});
	  });









	//Anotaciones
    $("#btnAnotacion").click(function() {
		
		var formulario=$("#dejar_anotacion").serialize();
		 $.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/guardar_anotacion.php",
			 data: formulario,
			 success:function(respuesta){											
				 alert(respuesta.mensaje);
				 if (respuesta.contestacion == 0)
				  location.reload();
			}
																	
		  }); // fin $.ajax
	});

	$("#paciente").change(function() {
		
		var id_paciente=this.value;
		
		if (this.value == "")
		  document.getElementById("modificacion").style.display="none";
		else
		{
		 document.getElementById("id_paciente_anotacion").value=id_paciente;
		 //Saco los datos
		 $.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/datos_paciente.php",
			 data: {id_paciente:id_paciente},
			 success:function(respuesta){											
				if (respuesta.contestacion == 0)
				{
				  $("input[name='nombre']").val(respuesta.nombre);
				  $("input[name='apellidos']").val(respuesta.apellidos);
				  $("input[name='dni']").val(respuesta.nif);
				  $("input[name='fecha_nacimiento']").val(respuesta.fecha_nacimiento);
				  if (respuesta.sexo == 0)
				    $("#sexohombre").prop("checked", true);
				  else
				    $("#sexomujer").prop("checked", true);
				  $("textarea[name='observaciones']").val(respuesta.observaciones);
				  $("input[name='telefono_fijo']").val(respuesta.telefono_fijo);
				  $("input[name='telefono_movil1']").val(respuesta.telefono_movil);
				  $("input[name='telefono_movil2']").val(respuesta.telefono_movil2);
				  $("input[name='email']").val(respuesta.email);
				  $("input[name='direccion']").val(respuesta.direccion);
				  $("input[name='localidad']").val(respuesta.localidad);
				  $("input[name='provincia']").val(respuesta.provincia);
				  $("input[name='cp']").val(respuesta.cp);
				  
				  $("#info_anotaciones").html(respuesta.anotaciones);
				  $("#ficheros_subidos").html(respuesta.ficheros);
				}
				else
				 alert(respuesta.mensaje);
			}
																	
		  }); // fin $.ajax
		 
		 
		 document.getElementById("modificacion").style.display="block";
		}
	})

	 $("#btnPaciente").click(function() {
		
		var formulario=$("#pacientes").serialize();
		var id_paciente=document.getElementById("paciente").value;
		$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/actualizar_paciente.php?id_paciente="+id_paciente,
			 data: formulario,
			 success:function(respuesta){											
					 alert(respuesta.mensaje);
			}
																	
		  }); // fin $.ajax
		 
	 })
	 
	})
	</script>
  </body>
</html>