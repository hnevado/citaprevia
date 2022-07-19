<?php
session_start();
session_regenerate_id();

if (isset($_SESSION["login"]))
 header("Location:main.php");
 
?>

<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="robots" content="noindex,nofollow" />
    <title>App</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        
      </div>
      <div class="login-box">
        <form class="login-form" method="POST">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Inicia sesión</h3>
          <div class="form-group">
            <label class="control-label">Email</label>
            <input id="email" class="form-control" type="text" placeholder="Email">
          </div>
          <div class="form-group">
            <label class="control-label">Contraseña</label>
            <input id="password" class="form-control" type="password" placeholder="Password">
          </div>
		  
          <div class="form-group btn-container">
            <input type="button" id="login" class="btn btn-primary btn-block" value="Conectar">
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
	<script>
	$(document).ready(function(){
		
		$("#login").click(function() {
			
			var email=document.getElementById("email").value;
			var password=document.getElementById("password").value;
			
			$.ajax({
			 type: "POST",
			 dataType: 'json',
			 url: "ajax/login.php",
			 data: {email:email,password:password},
			 success:function(respuesta){											
					 if (respuesta.contestacion == 0)
					  window.location.assign("main.php");
					 else
					  alert(respuesta.mensaje);
			}
																	
		  }); // fin $.ajax
			
			
		})
		
		
		$(document).on('keypress',function(e) {
			if(e.which == 13) {
				var email=document.getElementById("email").value;
				var password=document.getElementById("password").value;
				
				$.ajax({
				 type: "POST",
				 dataType: 'json',
				 url: "ajax/login.php",
				 data: {email:email,password:password},
				 success:function(respuesta){											
						 if (respuesta.contestacion == 0)
						  window.location.assign("main.php");
						 else
						  alert(respuesta.mensaje);
				}
																		
			  }); // fin $.ajax
			}
		});
		
		
		
	})	
	</script>	
	
  </body>
</html>