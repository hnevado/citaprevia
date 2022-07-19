<?php
session_start();
session_regenerate_id();

if (!isset($_SESSION["login"]))
 header("Location:index.php");
 
include("conexion.php");
$fecha=date("Y-m-d");

$citas_hoy=$mysqli->query("SELECT id FROM citas WHERE id_administrador=".$_SESSION["login"]." AND fecha='$fecha'");
$citas=$mysqli->query("SELECT pacientes.*,citas.id as id_cita,citas.fecha as fecha, citas.hora as hora FROM pacientes, citas WHERE pacientes.id = citas.id_paciente AND citas.id_administrador=".$_SESSION["login"]." AND fecha >= '$fecha' ORDER BY fecha,hora ASC");
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
          <h1><i class="fa fa-dashboard"></i> Citas</h1>
        
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title"><?php echo $citas->num_rows;?> próximas citas. Hoy tienes asignadas <?php echo $citas_hoy->num_rows;?> citas</h3>
			<?php
			 if ($citas->num_rows)
			 {
			?>
			  <table class="table">
				<tr>
				  <th scope="col">Fecha</th>
				  <th scope="col">Hora</th>
				  <th scope="col">Paciente</th>
				  <th scope="col">Acciones</th>
				</tr>
				<?php
				 while ($arr_result = $citas->fetch_array())
				 {
			    ?>
				  <tr>
				    <td><?php echo date("d-m-Y",strtotime($arr_result["hora"]));?>
					<td><?php echo $arr_result["hora"];?>
					<td><?php echo $arr_result["nombre"]." ".$arr_result["apellidos"];?></td>
					<td><span class="btn btn-danger" onclick="eliminaCita(<?php echo $arr_result["id_cita"];?>)">Eliminar cita</span></td>			
				  </tr>
				<?php
				 }
				?>
				
			  
			  </table>
			<?php 
			 }
			?>
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
	 function eliminaCita(cita)
	 {
		 
		 var id_cita=cita;
	   if (confirm("Vas a eliminar la cita. Esta acción es irreversible. ¿Estás seguro/a?"))
	   {
		 $.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/elimina_cita.php",
			 data: {id_cita:id_cita},
			 success:function(respuesta){
					alert(respuesta.mensaje);
					if (respuesta.contestacion == 0)
					 location.reload();
			}
																	
		  }); // fin $.ajax
	   } 
		 
	 }
	
	</script>
  </body>
</html>