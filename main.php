<?php
session_start();
session_regenerate_id();

if (!isset($_SESSION["login"]))
 header("Location:index.php");
 
include("conexion.php");
$fecha=date("Y-m-d");

$pacientes=$mysqli->query("SELECT id FROM pacientes");
$citas_hoy=$mysqli->query("SELECT id FROM citas WHERE fecha='$fecha'");
$citas_proximas=$mysqli->query("SELECT id FROM citas WHERE fecha > '$fecha'");
$citas_total=$mysqli->query("SELECT id FROM citas");

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
          <h1><i class="fa fa-dashboard"></i> Inicio</h1>
        
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Registrados</h4>
              <p><b><?php echo $pacientes->num_rows;?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-calendar fa-3x"></i>
            <div class="info">
              <h4>Total citas</h4>
              <p><b><?php echo $citas_total->num_rows;?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-user fa-3x"></i>
            <div class="info">
              <h4>Citas hoy</h4>
              <p><b><?php echo $citas_hoy->num_rows;?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-user fa-3x"></i>
            <div class="info">
              <h4>Próximas citas</h4>
              <p><b><?php echo $citas_proximas->num_rows;?></b></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Calendario citas</h3>
            <div id="container_citas" class="calendar-container"></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Dar citas</h3>
            <form name="citas" id="citas" method="POST">
			  <p>
			    <label><b>Selecciona el paciente</b></label><br/>
				<select name="paciente" class="form-control">
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
				</select>
			  </p>

			  <p>
			   <label><b>¿A quién le asignas la cita?</b></label><br/>
			     <select id="asignada" name="asignada" class="form-control">
				 <?php
				  if ($_SESSION["login"] == 1)
				  {
				 ?>
				   <option value="">- Selecciona - </option>
				<?php
				  }
				?>
				
				<?php
				  if ($_SESSION["login"] == 1)
				    $result_administradores=$mysqli->query("SELECT * FROM administradores");
				  else
				    $result_administradores=$mysqli->query("SELECT * FROM administradores WHERE id=".$_SESSION["login"]);
					
				  while ($arr_result_administradores = $result_administradores->fetch_array())
				  {
			    ?>
					<option value="<?php echo $arr_result_administradores["id"];?>"><?php echo $arr_result_administradores["nombre"]." (".$arr_result_administradores["especialidad"].")";?></option>
				<?php	  
				  }
				 ?>
				</select>
			  </p>
			  
			  <p><label><b>Selecciona una fecha</b></label><br/>
			  <input type="text" class="form-control" id="fecha_cita" name="fecha_cita" readonly></p>
			  
			  <p style="margin-bottom:0px">
			    <label><b>Selecciona una hora</b></label>
			  </p>	
				<div style="font-size:13px">
				(Puedes seleccionar varias horas manteniendo pulsada la tecla SHIFT &#8593;)
				</div>
			  <p>
				<select multiple id="hora" name="hora[]" class="form-control" disabled>
				 <option value="">Elige primero un empleado y una fecha</option>
				</select>
			  </p>
			  

			  
			  <p><input type="button" class="btn btn-success" value="Dar cita" id="btnCita"></p>
			  <div id="resultados" style="display:none"></div>
			</form>
          </div>
        </div>
      </div>
	  
	  <div class="row">
	   <div class="col-md-12">
	    <div class="tile">
            <h3 class="tile-title">Nuevo paciente</h3>
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
				<input type="radio" name="sexo" value="0"> Hombre <br/>
				<input type="radio" name="sexo" value="1"> Mujer</p>
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
			    <p><input type="button" class="btn btn-success" value="Registrar" id="btnPaciente"></p>
			  </div>
			  
			 </div>
			</form>
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
	  $(document).ready(function () {
		//myEvents={ "startDate":"2020-12-2", "endDate":"2020-12-2", "summary":"Prueba" };  
		myEvents="{}";
		$.ajax({
			 type: "POST",
			 async:false,
			 dataType: 'json',
			 url: "ajax/traer_citas.php",
			 success:function(respuesta){	
				console.log(respuesta);
				myEvents=respuesta;
				console.log(myEvents);
			}
																	
		}); // fin $.ajax
		  
		  
		console.log(myEvents);
		
		$("#container_citas").simpleCalendar({
		  months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		  days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sabado'],
		  fixedStartDay: 1, // begin weeks by sunday
		  disableEmptyDetails: true,
		  events: 
			myEvents
		  

		});
	  });
	</script>
	
	<script>
		$(function($){
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		  };
		  $.datepicker.setDefaults($.datepicker.regional['es']);
	   });
	</script>

	<script>
	$(document).ready(function(){
		
	 $("#fecha_cita").change(function() {
		
		if (document.getElementById("fecha_cita").value != "" && document.getElementById("asignada").value != "")
		{
			var fecha=document.getElementById("fecha_cita").value;
			var asignada=document.getElementById("asignada").value;
			
			$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/sacar_horarios.php?fecha="+fecha+"&asignada="+asignada,
			 success:function(respuesta){											
			  document.getElementById("hora").innerHTML=respuesta.mensaje;
			  document.getElementById('hora').disabled = false;	  
			}
																	
		  }); // fin $.ajax
			
		}


	 })
	
	 $("#asignada").change(function() {

		if (document.getElementById("fecha_cita").value != "" && document.getElementById("asignada").value != "")
		{
			var fecha=document.getElementById("fecha_cita").value;
			var asignada=document.getElementById("asignada").value;
			
			$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/sacar_horarios.php?fecha="+fecha+"&asignada="+asignada,
			 success:function(respuesta){											
			  document.getElementById("hora").innerHTML=respuesta.mensaje;
			  document.getElementById('hora').disabled = false;	  
			}
																	
		  }); // fin $.ajax
			
		}

	 })
     
		
	
	 $("#btnCita").click(function() {
		
		var formulario=$("#citas").serialize();
		//alert(formulario);
		$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/alta_cita.php",
			 data: formulario,
			 success:function(respuesta){											
					 alert(respuesta.mensaje);
					 if (respuesta.contestacion == 0)
					  location.reload();
			}
																	
		  }); // fin $.ajax
		 
	 })
	
	 $("#btnPaciente").click(function() {
		
		var formulario=$("#pacientes").serialize();
		$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/alta_paciente.php",
			 data: formulario,
			 success:function(respuesta){											
					 alert(respuesta.mensaje);
					 if (respuesta.contestacion == 0)
					  location.reload();
			}
																	
		  }); // fin $.ajax
		 
	 })
	 
		
		$("#fecha_cita").datepicker({
			dateFormat: 'dd-mm-yy',
			changeYear: false,
			minDate: 0
		 });
	})
	</script>
  </body>
</html>