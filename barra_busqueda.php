<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//enlazamos con las funcones
require_once( 'funciones.php');

//obtenemos los parametros de entrada
$buscar = getParameter('buscar');
$busqueda = getParameter('busqueda');


if($buscar != null){
	if($busqueda != null){
		header("location: busqueda.php?busqueda=$busqueda");
	}
}
?>

<html>
  <head>
  </head>
<body>
	<form class="form-inline">
		<input class="form-control mr-sm-2" type="text" placeholder="Buscar" id="busqueda" name="busqueda" placeholder="Buscar" value="<?php echo $busqueda ?>">
		<input class="btn btn-primary my-2 my-sm-0" type="submit" id="buscar" name="buscar" value="Buscar">
	</form>
 </body>