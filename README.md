# citaprevia
Aplicación de cita previa para negocios. Esta app tiene en cuenta distintos empleados / profesiones, horarios y el tiempo de cada sesión para que lo puedas personalizar según tus necesidades.

Esta aplicación fué desarrollada en el año 2016 utilizando PHP, JavaScript y jQuery y desde ese año, únicamente recibe alguna actualización para añadir alguna pequeña funcionalidad o solucionar algún problema de compatibilidad con las versiones más recientes de PHP pero sin grandes cambios.

La aplicación ha sido testeada hasta la versión 8.1 de PHP y todo funciona correctamente.


![pantallazo1](https://user-images.githubusercontent.com/2469833/145722282-7c12c2c6-af15-410c-8fc3-2c0067baf157.png)
![pantallazo2](https://user-images.githubusercontent.com/2469833/145722283-f93923e7-9350-4d93-a33a-b3f9725df6ed.png)
![pantallazo3](https://user-images.githubusercontent.com/2469833/145722284-d76eb9c2-2850-40a9-a086-1d94083ecca5.png)
![pantallazo4](https://user-images.githubusercontent.com/2469833/145722286-21eadc23-e882-4977-8156-1e21c177d8b2.png)


El .sql contiene solo la estructura (sin ningún dato). Añade los datos que quieras de pacientes como de profesionales.

Las contraseñas se encriptan / desencriptan mediante el fichero semillas.php. Este fichero tiene 2 funciones: encrypt y decrypt. De esta forma las contraseñas son mucho más seguras, ya que eres tú el que le indica los carácteres de la semilla (para encriptar / desencriptar)

¿Cómo creas una contraseña encriptada?

include("semillas.php");
$password=encrypt($password_sin_encriptar,$semilla);    
//Ahora en $password tienes la contraseña encriptada


¿Cómo desencriptas una contraseña?

include("semillas.php");
$password=decrypt($password_encriptada,$semilla); 
//Ahora en $password tienes la contraseña desencriptada


A partir de aquí, siéntete libre de clonar este repositorio, modificar y hacer / deshacer lo que consideres oportuno.
