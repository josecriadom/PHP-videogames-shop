<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//inicio de sesion
session_start();

//enlazamos con las funcones
require_once( 'funciones.php');

$con = conectar();

//obtenemos el email y comprobamos que esté conectado
if(isset($_SESSION['conectado'])){
	$conectado = $_SESSION['conectado'];
	$email = $_SESSION['usuario'];
} else 
	$conectado = 'no';

	//obtenemos los datos para la página
	if(!($res = $con->query("SELECT * FROM usuario WHERE email = '$email'"))){
		echo 'error al acceder a la tabla usuario';
	} else {
		
		$fila = $res->fetch_assoc();
		$nombre = $fila['Nombre'];
		$apellidos = $fila['Apellidos'];
		$nacimiento = $fila['Nacimiento'];
		$pais = $fila['Pais'];
	}
	unset($res);
?>

<?php
	include( 'plantilla_perfil.php');
?>

