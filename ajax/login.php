<?php
include("../conexion.php");
include("../semillas.php");
$respuesta=new stdClass(); //Creo un objeto vacio
$respuesta->contestacion=1;
$very_bad = array("CONCAT","concat","password","PASSWORD","user","USER","VERSION","version","VALUES","values","NULL","GROUP BY","group by","HEX","hex","CHAR(","char(","UNION","union","WAITFOR","waitfor","BENCHMARK","benchmark","MD5","SHA1","1=1","1=2","delete","update","union","insert","drop","select","UNION","DELETE","UPDATE","INSERT","DROP","SELECT","\x00","\x1a","\'","'","to:","cc:","bcc:","content-type:","mime-version:","multipart-mixed:","content-transfer-enconding:","&","\r","\n","%0a","%0d","?",";","=","$","%","#","<",">","script","*","[","]","{","}","^","http","//",".ru","html","lyubovnaya");


$_POST["email"] = str_replace($very_bad,' ',$_POST["email"]); // SUBSTITUIR POR ESPACIO EN BLANCO
$_POST["email"] = $mysqli->real_escape_string(trim(htmlentities($_POST["email"],ENT_QUOTES)));

$email=$_POST["email"];
$password=$_POST["password"];

$password_sin_encriptar=$_POST["password"];

if ($email == "" || $password == "") 
{
  $respuesta->mensaje="Introduce tu email y contraseña";
}
else 
{
 
 $password=encrypt("".$password."","".$semilla."");
 $result = $mysqli->query("SELECT id FROM administradores WHERE email='$email' AND password='$password'");
 if ($result->num_rows) 
 {
     while ($arr_result = $result->fetch_array())
     {
		 session_start([
			'cookie_lifetime' => 86400,
		]);
		
		$id=$arr_result["id"];
		$_SESSION["login"]=$id;
     }
 
        $respuesta->contestacion=0;
 }
 else
 {
   $respuesta->mensaje="El email $email o la contraseña $password_sin_encriptar son incorrectas";

 }

 
}


echo json_encode($respuesta);
       
?>