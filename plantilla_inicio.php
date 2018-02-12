<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//enlazamos con las funcones
require_once( 'funciones.php');

$con = conectar();

//obtenemos la lista de generos actual
$generos = obtenGeneros();

//Detectar parámetros de entrada
$editdestacados = getParameter('editdestacados');
$elimdestacados = getParameter('elimdestacados');
$elimofertas = getParameter('elimofertas');
$elimtopventas = getParameter('elimtopventas');
$añadirofertas = getParameter('añadirofertas');
$añadirtopventas = getParameter('añadirtopventas');
$añadir = getParameter('añadir');
$añadir2 = getParameter('añadir2');
$cancelar = getParameter('cancelar');
$valor = getParameter('valor');


if($cancelar != null){
	header("location: index.php");
}

if($elimofertas != null){
	if(!($con->query("DELETE FROM inicio WHERE titulo = '$ofertas[$elimofertas]' AND posicion='ofertas'"))){
		echo 'fallo';
	} else {
		header("location: index.php");
	}
}

if($elimtopventas != null){
	if(!($con->query("DELETE FROM inicio WHERE titulo = '$top_ventas[$elimtopventas]' AND posicion='top ventas'"))){
		echo 'fallo';
	} else {
		header("location: index.php");
	}
}

if($elimdestacados != null){
	if(!($con->query("DELETE FROM inicio WHERE titulo = '$destacados[$elimdestacados]' AND posicion='destacados'"))){
		echo 'fallo';
	} else {
		header("location: index.php");
	}
}

if($añadir != null){
	//realizamos la consulta para comprobar que existe ese juego en la base de datos
	if(!($res = $con->query("SELECT COUNT(*) FROM juego WHERE titulo = '$valor'"))){
		echo 'error al acceder a la tabla juego';
	} else {
		$fila = $res->fetch_assoc();
		if ($existe == 1){
			$res = $con->query("INSERT INTO `inicio` (`Titulo`, `Posicion`) VALUES ('$valor', '$añadir2')");
		}else{
			$incorrecto = 1;
			if($añadir2 == 'ofertas'){
				$añadirofertas = 1;
			}elseif($añadir2 == 'top ventas'){
				$añadirtopventas = 1;
			}else{
				$añadirdestacados = 1;
			}
		}
	}
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
				<a class="nav-link active" href="index.php">Inicio<span class="sr-only">(current)</span></a>
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
	
	<div class="lateral">
		<h4 class="elem-lateral2">BÚSQUEDA</h4>
		<a href="busqueda.php" class="elem-lateral2">Todos los juegos</a>
		<ul class="elem-lateral1, elem-lateral2">
			<li class="elem-lateral2"><p class="elem-lateral2">Generos</p></li>
			<?php foreach($generos as $valor){ ?>
				<li class="elem-lateral2"><a href="busqueda.php?genero=<?php echo $valor ?>"><?php echo $valor ?></a></li>
			<?php } ?>
		</ul>
		
		<?php if($conectado == 'root') { ?>
			<h4 class="elem-lateral2">Mantenimiento</h4>
			<a class="elem-lateral2" href="editar_generos.php"><button type="button" class="btn btn-primary">Comenzar</button></a>
		<?php } ?>
		
	</div>
	
	<div class="contenido">
		<h3>Destacados</h3>
		
		<div id="carouselExampleIndicators" class="contenido carousel slide" data-ride="carousel">
		  <ol class="carousel-indicators">
		    <?php foreach ($destacados as $clave => $valor) { 
				if($clave != 0) {?>
					<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $clave ?>" ></li>
				<?php } else { ?>
					<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $clave ?>" class="active"></li>
				<?php }
			} ?>
		  </ol>
		  
		  <div class="carousel-inner">
			<?php foreach ($destacados as $clave => $valor) { 
				if($clave != 0) {?>
					<div class="carousel-item">
					  <a href="juego.php?titulo=<?php echo $valor ?>"><img class="d-block w-100" src="<?php echo direccionImagen($valor) ?>" alt="First slide"></a>
					</div>
				<?php } else { ?>
					<div class="carousel-item active">
					  <a href="juego.php?titulo=<?php echo $valor ?>"><img class="d-block w-100" src="<?php echo direccionImagen($valor) ?>" alt="First slide"></a>
					</div>
				<?php }
			} ?>
		  </div>
		  
		  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		  </a>
		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Siguiente</span>
		  </a>
		</div>
		<?php if($editdestacados != null) { ?>
		    <br><form style="display:inline">
				<?php foreach($destacados as $clave => $valor){ ?>
					<?php echo $valor ?>&nbsp; 
					<button type="submit" class="fondo" name="elimdestacados" value="<?php echo $clave ?>">
						<img class="boton-root" src='imagenes/eliminar.png' alt="eliminar" />
					</button><br>
				<?php } ?>
				
				<br>
				<label for="valor"><span style="font-size:120%">Introduce el nombre del nuevo juego.</span> <br>Recuerde que debe estar en la base de datos.</label>
				<input type="text" class="form-control" style="width:250px" id="valor" name="valor">
				<?php if (isset($incorrecto)) { ?> <span style="color:red">Titulo incorrecto<span><br> <?php } ?>
				<input type="hidden" id="añadir2" name="añadir2" value="destacados">
				<br><input type="submit" id="añadir" name="añadir" class="btn btn-primary" value="Añadir">
				<input type="submit" id="cancelar" name="cancelar" class="btn btn-danger" value="Cancelar">
			</form>
		  <?php } elseif ($conectado == 'root') { ?>
			<form>
				<button type="submit" class="fondo" name="editdestacados" value="editar">
					<img class="boton-root" src='imagenes/editar.png' alt="editar" />
				</button>
			</form>
		  <?php } ?>
	</div>
	
	<div class="contenido">
		<h3>Ofertas</h3>
	
		<div class="card-deck">
			<?php foreach ($ofertas as $clave => $valor) { ?>
				<div class="card" style="width: 20rem;">
					<a href="juego.php?titulo=<?php echo $valor ?>">
					  <img class="card-img-top" src="<?php echo direccionImagen($valor) ?>" alt="<?php echo $valor ?>">
					</a>
					  <div class="card-body">
						<p class="precio-verde"><?php echo preciojuego($valor) . ' ' . '€' ?></p>
						<p class="card-title"><?php echo $valor ?></p>
						<?php if ($conectado == 'root') { ?>
							<form class="grupo-bot-root">
								<button type="submit" class="fondo" name="elimofertas" value="<?php echo $clave ?>">
									<img class="boton-root" src='imagenes/eliminar.png' alt="eliminar" />
								</button>
							 </form>
						<?php } ?>
					  </div>
				</div>
			<?php } ?>
		</div>
		
		<?php
		if ($añadirofertas != null) { ?>
			<br><form style="display:inline">
				<label for="valor"><span style="font-size:120%">Introduce el nombre del nuevo juego.</span> <br>Recuerde que debe estar en la base de datos.</label>
				<input type="text" class="form-control" style="width:250px" id="valor" name="valor">
				<?php if (isset($incorrecto)) { ?> <span style="color:red">Titulo incorrecto<span><br> <?php } ?>
				<input type="hidden" id="añadir2" name="añadir2" value="ofertas">
				<br><input type="submit" id="añadir" name="añadir" class="btn btn-primary" value="Añadir">
				<input type="submit" id="cancelar" name="cancelar" class="btn btn-danger" value="Cancelar">
			</form>
		<?php } elseif ($conectado == 'root') { ?>
			<form>
				<button type="submit" class="fondo" name="añadirofertas" value="añadirofertas">
					<img class="boton-root-añadir" src='imagenes/añadir.png' alt="añadir" />
				</button>
			</form>
		<?php } ?>
	</div>
	
	<div class="contenido">
		<h3>Top ventas</h3>
		
		<?php foreach ($top_ventas as $clave => $valor) { ?>
			<div class="card lista">
			  <a href="juego.php?titulo=<?php echo $valor ?>">
				<img style="height:110px" class="card-img-top" src="<?php echo direccionImagen($valor) ?>" alt="imagen">
			  </a>
			  <div class="card-body">
				<h4 class="card-title"><?php echo $valor ?></h4>
				<p class="card-text">¡Compralo ya!</p>
				<div class="cuesta">
					<p class="nuevo-precio-card"><?php echo preciojuego($valor) . ' ' . '€' ?></p>
				</div>
				<?php if ($conectado == 'root') { ?>
					<form class="grupo-bot-root">
						<button type="submit" class="fondo" name="elimtopventas" value="<?php echo $clave ?>">
							<img class="boton-root" src='imagenes/eliminar.png' alt="eliminar" />
						</button>
					</form>
				<?php } ?>
			  </div>
			</div>
		<?php }
		
		if ($añadirtopventas != null) {	?>
			<br><form style="display:inline">
				<label for="valor"><span style="font-size:120%">Introduce el nombre del nuevo juego.</span> <br>Recuerde que debe estar en la base de datos.</label>
				<input type="text" class="form-control" style="width:250px" id="valor" name="valor">
				<?php if (isset($incorrecto)) { ?> <span style="color:red">Titulo incorrecto<span><br> <?php } ?>
				<input type="hidden" id="añadir2" name="añadir2" value="top ventas">
				<br><input type="submit" id="añadir" name="añadir" class="btn btn-primary" value="Añadir">
				<input type="submit" id="cancelar" name="cancelar" class="btn btn-danger" value="Cancelar">
			</form>
		<?php } elseif ($conectado == 'root') { ?>
				<form>
					<button type="submit" class="fondo" name="añadirtopventas" value="añadirtopventas">
						<img class="boton-root-añadir" src='imagenes/añadir.png' alt="añadir" />
					</button>
				</form>
		<?php } ?>
	</div>
	
	<?php if ($conectado == 'root') { ?>
	<div class="contenido">
		<h3>Entrar en el mantenimiento de los juegos</h3>
			<a href="busqueda.php?mantenimiento=si"><button type="button" class="btn btn-primary">Comenzar</button></a>
	</div>
	<?php } ?>
 
	<?php
		include( 'plantilla_footer.php');
	?>
 </body>