 <aside class="app-sidebar">
      <ul class="app-menu">
        <li><a class="app-menu__item" href="main.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Inicio</span></a></li>
		<?php
		 if ($_SESSION["login"] == 1)
		 {
		?>
		  <li><a class="app-menu__item" href="crear_horario.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Horarios empleados</span></a></li>
		<?php
		 }
		?>
		<li><a class="app-menu__item" href="pacientes.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Pacientes</span></a></li>
        <li><a class="app-menu__item" href="citas.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Tus citas</span></a></li>
        <li><a class="app-menu__item" href="desconectar.php"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Desconectar</span></a></li>
      </ul>
    </aside>