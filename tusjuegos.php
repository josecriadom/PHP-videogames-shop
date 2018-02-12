<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//inicio de sesion
session_start();

//enlazamos con las funcones
require_once( 'funciones.php');

	// no, si o root
	if(isset($_SESSION['conectado'])){
		$conectado = $_SESSION['conectado'];
		$usuario = $_SESSION['usuario'];
	} else {
		$conectado = 'no';
		$usuario = null;
	}
	
	$con = conectar();

	//realizamos la consulta para para obtener los titulos
	if(!($res = $con->query("SELECT Titulo FROM comprados WHERE email='$usuario'"))){
		echo 'error';
	} else {
		$i = 0;
		while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {	
			foreach ($line as $col_value) {
				//echo "\t\t<td>$col_value</td>\n";
				$juegos[$i]= $col_value;
				$i = $i+1;
			}	
		}
		// Liberar resultados
		mysqli_free_result($res);
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
					<a class="nav-link active" href="tusjuegos.php">Tus juegos</a>
				 </li>
			  <?php } ?>
			</ul>
			<?php include( 'barra_busqueda.php'); ?>
		  </div>
		</nav>
	</div>
		
	<?php if($conectado != 'no') { ?>
		
		<div class="contenido">
			<?php foreach ($juegos as $valor) { ?>
				<div class="card lista">
				  <a href="juego.php?titulo=<?php echo $valor ?>">
					<img style="height:110px" class="card-img-top" src="<?php echo direccionImagen($valor) ?>" alt="<?php echo $valor ?>">
				  </a>
				  <div class="card-body">
					<h4 class="card-title"><?php echo $valor ?></h4>
				  </div>
				</div>
			<?php } ?>
		</div>

	 
	<?php } else { ?>
		<div class="contenido">
			<br><br><h2>UPS! No deberias estar aquí</h2>
		</div>
		
	<?php } 
		include( 'plantilla_footer.php');
	?>
	 </body>