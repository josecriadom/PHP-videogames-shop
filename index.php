<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//inicio de sesion
session_start();

//enlazamos con las funcones
require_once( 'funciones.php');

// no, si o root
if(isset($_SESSION['conectado']))
	$conectado = $_SESSION['conectado'];
else 
	$conectado = 'no';

//creamos la cesta
if(!(isset($_SESSION['cesta']))){
	$cesta = array();
	$_SESSION['cesta'] = $cesta;
}

$con = conectar();

//realizamos la consulta para obtener la lista de juegos
if(!($result = $con->query("SELECT titulo FROM inicio WHERE posicion='destacados'"))){
	echo 'error';
} else {
	$i = 0;
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
		foreach ($line as $col_value) {
			$destacados[$i]= $col_value;
			$i = $i+1;
		}	
	}
	// Liberar resultados
	mysqli_free_result($result);
}

//realizamos la consulta para obtener la lista de juegos
if(!($result = $con->query("SELECT titulo FROM inicio WHERE posicion='ofertas'"))){
	echo 'error';
} else {
	$i = 0;
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
		foreach ($line as $col_value) {
			$ofertas[$i]= $col_value;
			$i = $i+1;
		}	
	}
	// Liberar resultados
	mysqli_free_result($result);
}

//realizamos la consulta para obtener la lista de juegos
if(!($result = $con->query("SELECT titulo FROM inicio WHERE posicion='top ventas'"))){
	echo 'error';
} else {
	$i = 0;
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {	
		foreach ($line as $col_value) {
			$top_ventas[$i]= $col_value;
			$i = $i+1;
		}	
	}
	// Liberar resultados
	mysqli_free_result($result);
}

?>

<?php
	include( 'plantilla_inicio.php');
?>

