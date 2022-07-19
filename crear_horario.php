<?php
session_start();
session_regenerate_id();

if (!isset($_SESSION["login"]) || $_SESSION["login"] != 1)
 header("Location:index.php");
 
include("conexion.php");
$fecha=date("Y/m/d");


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
          <h1><i class="fa fa-dashboard"></i> Crear horario</h1>
        
        </div>
      </div>

      <?php
	    $result_administradores=$mysqli->query("SELECT * FROM administradores");
		
		while ($arr_result_administradores = $result_administradores->fetch_array())
		{
			
	   ?>
		  <div class="row">

			<div class="col-md-12">
			 <h2><?php echo $arr_result_administradores["nombre"]." (".$arr_result_administradores["especialidad"].")";?></h2>
			 <form name="sesiones" id="form<?php echo $arr_result_administradores["id"];?>" method="POST" action="#">
			  <input style="display:none" type="text" name="id_administrador" value="<?php echo $arr_result_administradores["id"];?>">
			  <table class="table">
				<tr>
				  <td>Fecha</td>
				  <td>Hora inicio</td>
				  <td>Hora final</td>
				  <td>Hora inicio</td>
				  <td>Hora final</td>
				  <td>Sesión cada</td>
				</tr>
				<?php
				 for ($i=0;$i<=30;$i++)
				 {
					 $siguiente_fecha = date('d-m-Y',strtotime($fecha . "+".$i." days"));
					 $siguiente_fecha_db = date('Y-m-d',strtotime($fecha . "+".$i." days"));
					 
					 $result_existe=$mysqli->query("SELECT * FROM horas_disponibles WHERE id_administrador=".$arr_result_administradores['id']." AND fecha='".$siguiente_fecha_db."' LIMIT 1");
					 
					 if ($result_existe->num_rows)
					 {
						 while ($arr_result_existe = $result_existe->fetch_array())
						 {
						   $hora_inicio_db=$arr_result_existe["hora_inicio"];
						   $hora_final_db=$arr_result_existe["hora_final"];
						   $hora_inicio2_db=$arr_result_existe["hora_inicio2"];
						   $hora_final2_db=$arr_result_existe["hora_inicio2"];
						   $sesiones_db=$arr_result_existe["sesiones"];
						 }
						 
					 }
					 else
					 {
						  $hora_inicio_db="";
						  $hora_final_db="";
						  $hora_inicio2_db="";
						  $hora_final2_db="";
						  $sesiones_db="";
					 }
				?>
					<tr>
					  <td><input readonly type="text" name="fecha[]" class="form-control" value="<?php echo $siguiente_fecha;?>"></td>
					  <td>
					  <select name="hora_inicio[]" class="form-control">
						 <option value="">- Hora inicio -</option>
						 <option value="09:00" <?php if ($hora_inicio_db == "09:00") { ?> selected <?php } ?>>09:00 </option>
						 <option value="09:30" <?php if ($hora_inicio_db == "09:30") { ?> selected <?php } ?>>09:30 </option>
						 <option value="10:00" <?php if ($hora_inicio_db == "10:00") { ?> selected <?php } ?>>10:00 </option>
						 <option value="10:30" <?php if ($hora_inicio_db == "10:30") { ?> selected <?php } ?>>10:30 </option>
						 <option value="11:00" <?php if ($hora_inicio_db == "11:00") { ?> selected <?php } ?>>11:00 </option>
						 <option value="11:30" <?php if ($hora_inicio_db == "11:30") { ?> selected <?php } ?>>11:30 </option>
						 <option value="12:00" <?php if ($hora_inicio_db == "12:00") { ?> selected <?php } ?>>12:00 </option>
						 <option value="12:30" <?php if ($hora_inicio_db == "12:30") { ?> selected <?php } ?>>12:30 </option>
						 <option value="13:00" <?php if ($hora_inicio_db == "13:00") { ?> selected <?php } ?>>13:00 </option>
						 <option value="13:30" <?php if ($hora_inicio_db == "13:30") { ?> selected <?php } ?>>13:30 </option>
						 <option value="14:00" <?php if ($hora_inicio_db == "14:00") { ?> selected <?php } ?>>14:00 </option>
						 <option value="14:30" <?php if ($hora_inicio_db == "14:30") { ?> selected <?php } ?>>14:30 </option>
						 <option value="15:00" <?php if ($hora_inicio_db == "15:00") { ?> selected <?php } ?>>15:00 </option>
						 <option value="15:30" <?php if ($hora_inicio_db == "15:30") { ?> selected <?php } ?>>15:30 </option>
						 <option value="16:00" <?php if ($hora_inicio_db == "16:00") { ?> selected <?php } ?>>16:00 </option>
						 <option value="16:30" <?php if ($hora_inicio_db == "16:30") { ?> selected <?php } ?>>16:30 </option>
						 <option value="17:00" <?php if ($hora_inicio_db == "17:00") { ?> selected <?php } ?>>17:00 </option>
						 <option value="17:30" <?php if ($hora_inicio_db == "17:30") { ?> selected <?php } ?>>17:30 </option>
						 <option value="18:00" <?php if ($hora_inicio_db == "18:00") { ?> selected <?php } ?>>18:00 </option>
						 <option value="18:30" <?php if ($hora_inicio_db == "18:30") { ?> selected <?php } ?>>18:30 </option>
						 <option value="19:00" <?php if ($hora_inicio_db == "19:00") { ?> selected <?php } ?>>19:00 </option>
						 <option value="19:30" <?php if ($hora_inicio_db == "19:30") { ?> selected <?php } ?>>19:30 </option>
						 <option value="20:00" <?php if ($hora_inicio_db == "20:00") { ?> selected <?php } ?>>20:00 </option>
						</select>
					  </td>
					   <td>
					  <select name="hora_final[]" class="form-control">
						 <option value="">- Hora final -</option>
						 <option value="09:00" <?php if ($hora_final_db == "09:00") { ?> selected <?php } ?>>09:00 </option>
						 <option value="09:30" <?php if ($hora_final_db == "09:30") { ?> selected <?php } ?>>09:30 </option>
						 <option value="10:00" <?php if ($hora_final_db == "10:00") { ?> selected <?php } ?>>10:00 </option>
						 <option value="10:30" <?php if ($hora_final_db == "10:30") { ?> selected <?php } ?>>10:30 </option>
						 <option value="11:00" <?php if ($hora_final_db == "11:00") { ?> selected <?php } ?>>11:00 </option>
						 <option value="11:30" <?php if ($hora_final_db == "11:30") { ?> selected <?php } ?>>11:30 </option>
						 <option value="12:00" <?php if ($hora_final_db == "12:00") { ?> selected <?php } ?>>12:00 </option>
						 <option value="12:30" <?php if ($hora_final_db == "12:30") { ?> selected <?php } ?>>12:30 </option>
						 <option value="13:00" <?php if ($hora_final_db == "13:00") { ?> selected <?php } ?>>13:00 </option>
						 <option value="13:30" <?php if ($hora_final_db == "13:30") { ?> selected <?php } ?>>13:30 </option>
						 <option value="14:00" <?php if ($hora_final_db == "14:00") { ?> selected <?php } ?>>14:00 </option>
						 <option value="14:30" <?php if ($hora_final_db == "14:30") { ?> selected <?php } ?>>14:30 </option>
						 <option value="15:00" <?php if ($hora_final_db == "15:00") { ?> selected <?php } ?>>15:00 </option>
						 <option value="15:30" <?php if ($hora_final_db == "15:30") { ?> selected <?php } ?>>15:30 </option>
						 <option value="16:00" <?php if ($hora_final_db == "16:00") { ?> selected <?php } ?>>16:00 </option>
						 <option value="16:30" <?php if ($hora_final_db == "16:30") { ?> selected <?php } ?>>16:30 </option>
						 <option value="17:00" <?php if ($hora_final_db == "17:00") { ?> selected <?php } ?>>17:00 </option>
						 <option value="17:30" <?php if ($hora_final_db == "17:30") { ?> selected <?php } ?>>17:30 </option>
						 <option value="18:00" <?php if ($hora_final_db == "18:00") { ?> selected <?php } ?>>18:00 </option>
						 <option value="18:30" <?php if ($hora_final_db == "18:30") { ?> selected <?php } ?>>18:30 </option>
						 <option value="19:00" <?php if ($hora_final_db == "19:00") { ?> selected <?php } ?>>19:00 </option>
						 <option value="19:30" <?php if ($hora_final_db == "19:30") { ?> selected <?php } ?>>19:30 </option>
						 <option value="20:00" <?php if ($hora_final_db == "20:00") { ?> selected <?php } ?>>20:00 </option>
						</select>
					  </td>
					   <td>
					  <select name="hora_inicio2[]" class="form-control">
						 <option value="">- Hora inicio -</option>
						 <option value="09:00" <?php if ($hora_inicio2_db == "09:00") { ?> selected <?php } ?>>09:00 </option>
						 <option value="09:30" <?php if ($hora_inicio2_db == "09:30") { ?> selected <?php } ?>>09:30 </option>
						 <option value="10:00" <?php if ($hora_inicio2_db == "10:00") { ?> selected <?php } ?>>10:00 </option>
						 <option value="10:30" <?php if ($hora_inicio2_db == "10:30") { ?> selected <?php } ?>>10:30 </option>
						 <option value="11:00" <?php if ($hora_inicio2_db == "11:00") { ?> selected <?php } ?>>11:00 </option>
						 <option value="11:30" <?php if ($hora_inicio2_db == "11:30") { ?> selected <?php } ?>>11:30 </option>
						 <option value="12:00" <?php if ($hora_inicio2_db == "12:00") { ?> selected <?php } ?>>12:00 </option>
						 <option value="12:30" <?php if ($hora_inicio2_db == "12:30") { ?> selected <?php } ?>>12:30 </option>
						 <option value="13:00" <?php if ($hora_inicio2_db == "13:00") { ?> selected <?php } ?>>13:00 </option>
						 <option value="13:30" <?php if ($hora_inicio2_db == "13:30") { ?> selected <?php } ?>>13:30 </option>
						 <option value="14:00" <?php if ($hora_inicio2_db == "14:00") { ?> selected <?php } ?>>14:00 </option>
						 <option value="14:30" <?php if ($hora_inicio2_db == "14:30") { ?> selected <?php } ?>>14:30 </option>
						 <option value="15:00" <?php if ($hora_inicio2_db == "15:00") { ?> selected <?php } ?>>15:00 </option>
						 <option value="15:30" <?php if ($hora_inicio2_db == "15:30") { ?> selected <?php } ?>>15:30 </option>
						 <option value="16:00" <?php if ($hora_inicio2_db == "16:00") { ?> selected <?php } ?>>16:00 </option>
						 <option value="16:30" <?php if ($hora_inicio2_db == "16:30") { ?> selected <?php } ?>>16:30 </option>
						 <option value="17:00" <?php if ($hora_inicio2_db == "17:00") { ?> selected <?php } ?>>17:00 </option>
						 <option value="17:30" <?php if ($hora_inicio2_db == "17:30") { ?> selected <?php } ?>>17:30 </option>
						 <option value="18:00" <?php if ($hora_inicio2_db == "18:00") { ?> selected <?php } ?>>18:00 </option>
						 <option value="18:30" <?php if ($hora_inicio2_db == "18:30") { ?> selected <?php } ?>>18:30 </option>
						 <option value="19:00" <?php if ($hora_inicio2_db == "19:00") { ?> selected <?php } ?>>19:00 </option>
						 <option value="19:30" <?php if ($hora_inicio2_db == "19:30") { ?> selected <?php } ?>>19:30 </option>
						 <option value="20:00" <?php if ($hora_inicio2_db == "20:00") { ?> selected <?php } ?>>20:00 </option>
						</select>
					  </td>
					   <td>
					  <select name="hora_final2[]" class="form-control">
						 <option value="">- Hora final -</option>
						 <option value="09:00" <?php if ($hora_final2_db == "09:00") { ?> selected <?php } ?>>09:00 </option>
						 <option value="09:30" <?php if ($hora_final2_db == "09:30") { ?> selected <?php } ?>>09:30 </option>
						 <option value="10:00" <?php if ($hora_final2_db == "10:00") { ?> selected <?php } ?>>10:00 </option>
						 <option value="10:30" <?php if ($hora_final2_db == "10:30") { ?> selected <?php } ?>>10:30 </option>
						 <option value="11:00" <?php if ($hora_final2_db == "11:00") { ?> selected <?php } ?>>11:00 </option>
						 <option value="11:30" <?php if ($hora_final2_db == "11:30") { ?> selected <?php } ?>>11:30 </option>
						 <option value="12:00" <?php if ($hora_final2_db == "12:00") { ?> selected <?php } ?>>12:00 </option>
						 <option value="12:30" <?php if ($hora_final2_db == "12:30") { ?> selected <?php } ?>>12:30 </option>
						 <option value="13:00" <?php if ($hora_final2_db == "13:00") { ?> selected <?php } ?>>13:00 </option>
						 <option value="13:30" <?php if ($hora_final2_db == "13:30") { ?> selected <?php } ?>>13:30 </option>
						 <option value="14:00" <?php if ($hora_final2_db == "14:00") { ?> selected <?php } ?>>14:00 </option>
						 <option value="14:30" <?php if ($hora_final2_db == "14:30") { ?> selected <?php } ?>>14:30 </option>
						 <option value="15:00" <?php if ($hora_final2_db == "15:00") { ?> selected <?php } ?>>15:00 </option>
						 <option value="15:30" <?php if ($hora_final2_db == "15:30") { ?> selected <?php } ?>>15:30 </option>
						 <option value="16:00" <?php if ($hora_final2_db == "16:00") { ?> selected <?php } ?>>16:00 </option>
						 <option value="16:30" <?php if ($hora_final2_db == "16:30") { ?> selected <?php } ?>>16:30 </option>
						 <option value="17:00" <?php if ($hora_final2_db == "17:00") { ?> selected <?php } ?>>17:00 </option>
						 <option value="17:30" <?php if ($hora_final2_db == "17:30") { ?> selected <?php } ?>>17:30 </option>
						 <option value="18:00" <?php if ($hora_final2_db == "18:00") { ?> selected <?php } ?>>18:00 </option>
						 <option value="18:30" <?php if ($hora_final2_db == "18:30") { ?> selected <?php } ?>>18:30 </option>
						 <option value="19:00" <?php if ($hora_final2_db == "19:00") { ?> selected <?php } ?>>19:00 </option>
						 <option value="19:30" <?php if ($hora_final2_db == "19:30") { ?> selected <?php } ?>>19:30 </option>
						 <option value="20:00" <?php if ($hora_final2_db == "20:00") { ?> selected <?php } ?>>20:00 </option>
						</select>
					  </td>
					 
					 
					  <td>
					   <select name="sesiones[]" class="form-control">
						<option value="0">Sin citas este día</option>
						<option value="15" <?php if ($sesiones_db == 15) { ?> selected <?php } ?>>Cada 15 minutos</option>
						<option value="20" <?php if ($sesiones_db == 20) { ?> selected <?php } ?>>Cada 20 minutos</option>
						<option value="25" <?php if ($sesiones_db == 25) { ?> selected <?php } ?>>Cada 25 minutos</option>
						<option value="30" <?php if ($sesiones_db == 30) { ?> selected <?php } ?>>Cada 30 minutos</option>
						<option value="45" <?php if ($sesiones_db == 45) { ?> selected <?php } ?>>Cada 45 minutos</option>
						<option value="60" <?php if ($sesiones_db == 60) { ?> selected <?php } ?>>Cada 60 minutos</option>
					   </select>
					  </td>
					</tr>
					
			<?php
			 }
			?>
			<tr>
			  <td colspan="6"><input style="width:100%;padding:5px" type="button" id="<?php echo $arr_result_administradores["id"];?>" class="guardar btn-success" value="Guardar horario de <?php echo $arr_result_administradores["nombre"];?>"></td>
			</tr>
		   </table>
		 </form>
		</div>

	  </div>
	 <?php
		}
	 ?>

	  
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
	$(document).ready(function(){
		
		
		
	
	 $(".guardar").click(function() {
		
		var id=this.id;
		var formulario=$("#form"+id).serialize();
		//alert(formulario);
		$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/horario_crear_personal.php",
			 data: formulario,
			 success:function(respuesta){											
					 alert(respuesta.mensaje);
					 if (respuesta.contestacion == 0)
					  location.reload();
			}
																	
		  });
		 
	 })
	
	 
		
	})
	</script>
  </body>
</html>