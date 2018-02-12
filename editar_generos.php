<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//enlazamos con las funcones
require_once( 'funciones.php');

//inicio de sesion
session_start();

// no, si o root
if(isset($_SESSION['conectado']))
	$conectado = $_SESSION['conectado'];
else 
	$conectado = 'no';

$con = conectar();

//obtenemos la lista de generos actual
$generos = obtenGeneros();

//Detectar parámetros de entrada
$eliminar = getParameter('eliminar');
$nuevogenero = getParameter('nuevogenero');
$añadir = getParameter('añadir');


if($eliminar != null){
	if(!($res = $con->query("DELETE FROM genero WHERE Categoria='$eliminar'"))){
		echo 'error al eliminar genero';
	} else {
		$generos = array_diff($generos, array('$eliminar'));
		escribeGeneros($generos);
	}
	echo "1";
}

if($añadir != null && $nuevogenero != null){
	$generos[] = "\n" . $nuevogenero;
	escribeGeneros($generos);
	echo "2";
}
?>

<html>
  <head>
    <title>Xplay</title>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="imagenes/favicon.png" />
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="trabajo.css" type="text/css">
  </head>
  
<body>
	<?php
		include( 'plantilla_cabecera.php');
	?>

	<div class="contenido">
		<nav class="navbar navbar-expand-lg navbar-dark">
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<ul class="nav navbar-nav mr-auto mt-2 mt-lg-0">
			  <li class="nav-item">
				<a class="nav-link" href="index.php">Inicio<span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="cesta.php">Cesta</a>
			  </li>
			  <?php if ($conectado != 'no') { ?>
				 <li class="nav-item">
					<a class="nav-link" href="tusjuegos.php">Tus juegos</a>
				 </li>
			  <?php } ?>
			</ul>
			<?php include( 'barra_busqueda.php'); ?>
		  </div>
		</nav>
	</div>
	
	<?php if($conectado == 'root') { ?>
	
	<div class="contenido">
		<h2>Edita los generos</h2>
		
		<h3>Géneros actuales</h3>
		<?php foreach($generos as $valor){ ?>
			<p style="font-size:130%; display:inline" ><?php echo $valor ?></p>
			<form style="display:inline">
				<button style="display:inline" type="submit" class="fondo" name="eliminar" value="<?php echo $clave ?>">
					<img style="display:inline" class="boton-root" src='imagenes/eliminar.png' alt="eliminar" />
				</button>
			</form><br><br>
		<?php } ?>
		
		<h3>Nuevo género</h3>
		<br><form style="display:inline">
			<label for="nuevogenero" style="font-size:120%">Introduce el nombre del nuevo género.</label>
			<input type="text" class="form-control" style="width:250px" id="nuevogenero" name="nuevogenero">
			<br><input type="submit" id="añadir" name="añadir" class="btn btn-primary" value="Añadir">
		</form>
	
	
	<?php } else { ?>
		<div class="contenido">
			<br><br><h2>UPS! No deberias estar aquí</h2>
		</div>
	<?php } 
	
		include( 'plantilla_footer.php');
		print_r($generos);echo "\n";
	?>
 </body>