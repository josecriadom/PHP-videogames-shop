<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
	//inicio de sesion
	session_start();
	
	//enlazamos con las funcones
	require_once( 'funciones.php');

	//conseguimos el titulo
	$titulo=($_GET['titulo']);
	
	// no, si o root
	if(isset($_SESSION['conectado'])) {
		$conectado = $_SESSION['conectado'];
		$usuario = $_SESSION['usuario'];
	} else 
		$conectado = 'no';

	$con = conectar();
	
	//Detectar parámetros de entrada
	$añadir = getParameter('añadir');
	$comentario = getParameter('comentario');
	$enviar = getParameter('enviar');
	$editar = getParameter('editar');
	$eliminar = getParameter('eliminar');
	$posicion = getParameter('posicion');
	

	//se guarda el comentario
	if($enviar != null && $comentario != null){
		$hoy = getdate();
		$fecha = $hoy['mday'] . '-' . $hoy['mon'] . '-' . $hoy['year'];
		if(isset($_GET['modificar'])){
			if(!($res = $con->query("UPDATE comentarios SET Texto='$comentario' WHERE Email='$usuario' AND Titulo='$titulo'"))){
				echo 'error al actualizar comentario';
			} 
		} else {
			if(!($res = $con->query("INSERT INTO comentarios VALUES ('$titulo', '$usuario', '$comentario', '$fecha')"))){
				echo 'error al insertar comentario';
			} 
		}
		unset($comentario);
	}
	
	//comprobamos que no esté en la cesta
	if(!(isset($_SESSION['cesta']))){//tambien la creamos por si el usuario pasa por aqui antes que por el index
		$cesta = array();
		$_SESSION['cesta'] = $cesta;
	}else{
		$cesta = $_SESSION['cesta'];
		if(in_array($titulo,$cesta))
			$encesta = 1;
	}
	
	//añadimos a la cesta
	if($añadir != null){
		$cesta[] = $titulo;
		$_SESSION['cesta'] = $cesta;
		header("location: cesta.php");
	}

	if($conectado != 'no'){
		//comprobamos que ese juego no este comprado por ese usuario
		if(!($res = $con->query("SELECT COUNT(*) FROM comprados WHERE titulo = '$titulo' AND email = '$usuario'"))){
			echo 'error al acceder a la tabla juego';
		} else {
			$fila = $res->fetch_assoc();
			$existe = $fila['COUNT(*)'];
		}
	}

	//recupera los datos de un juego
	include( 'datos_juego.php');
	
	if(!($res = $con->query("SELECT comentarios.Texto, comentarios.Email, comentarios.Fecha, usuario.Nombre, usuario.Apellidos FROM (comentarios INNER JOIN usuario ON usuario.Email=comentarios.Email) WHERE comentarios.Titulo = '$titulo'"))){
		echo 'error al acceder a la tabla comentarios U usuario';
	} else {
		for ($comentarios = array (); $row = $res->fetch_assoc(); $comentarios[] = $row);
		$n = $res->num_rows;
	}
	
	if($eliminar != null){
		$a1 = $comentarios[$posicion]['Texto'];
		$a2 = $comentarios[$posicion]['Email'];
		if(!($res = $con->query("DELETE FROM comentarios WHERE texto='$a1' AND Email='$a2' AND Titulo='$titulo'"))){
			echo 'error al eliminar comentario';
		} 
	}
	
	if($editar != null){
		$comentario = $comentarios[$posicion]['Texto'];
	} else {
		$comentario = "";
	}
?>

<!DOCTYPE html>
<html lang="es">
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
	
	<div class="contenido">
		<h2><?php echo $titulo ?></h2>
		
		<img class="redondeado contenido" src="<?php echo direccionImagen( $titulo) ?>" alt="<?php $titulo ?>">
	
		<div class="boton-accion">
			<div class="precio-juego"><?php echo $precio . '€' ?></div>
			<div class="añadir-carro">
				<?php if(isset($existe) && $existe != 0) { ?>
					<div class="comprado"> Comprado </div>
				<?php } elseif(isset($encesta)) { ?>
					<div class="comprado"> En cesta </div>
				<?php } else { ?>
					<form action="juego.php?titulo=<?php echo $titulo ?>" method="post">
						<input style="cursor:pointer" type="submit" id="añadir" name="añadir" class="añadir-carro-enlace" value="Añadir al carro">
					</form>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<div class="contenido">
		<div class="contenido2">
			<h3>Acerca de este juego</h3>
		</div>
		
		<div class="contenido2">	
			<p class="texto"><?php echo $descripcion ?></p>
			<br>
		</div>
		<div class="contenido3">
			<span class="gris">Título:</span> <?php echo $titulo ?><br>
			<span class="gris">Género:</span> <?php foreach ($categorias as $valor ) { echo $valor . ',' . ' '; } ?><br>
			<span class="gris">Desarrollador:</span> <?php echo $desarrollador ?><br>
			<span class="gris">Fecha de lanzamiento:</span> <?php echo $lanzamiento ?><br>
		<div style="clear:both"></div>
		</div>
		<div style="clear:both"></div>
		<div class="contenido3">
			<a href="http://www.pegi.info/">
				<?php if ($pegi == 3) { ?><img class="pegi" alt="pegi" src="http://store.akamai.steamstatic.com/public/images/ratings/PEGI/3.gif">
				<?php } elseif ($pegi == 7) { ?><img class="pegi" alt="pegi" src="http://store.akamai.steamstatic.com/public/images/ratings/PEGI/7.gif">
				<?php } elseif ($pegi == 12) { ?><img class="pegi" alt="pegi" src="http://store.akamai.steamstatic.com/public/images/ratings/PEGI/12.gif">
				<?php } elseif ($pegi == 16) { ?><img class="pegi" alt="pegi" src="http://store.akamai.steamstatic.com/public/images/ratings/PEGI/16.gif">
				<?php } elseif ($pegi == 18) { ?><img class="pegi" alt="pegi" src="http://store.akamai.steamstatic.com/public/images/ratings/PEGI/18.gif">
				<?php } ?>
			</a>
			<div class="derecha">
				<?php 
					foreach($descriptores_pegi as $valor) {
							echo $valor;
							?> <br> <?php
					}
				?>
			</div>
			<div style="clear:both"></div>
		</div>
		
		<div class="contenido2 no-estira">
			<h3>Requisitos del sistema</h3>
			<div class="contenido4-izq">
				<h4>Mínimo</h4>
				<p class="texto">
					<span class="gris">SO:</span><?php echo ' ' . $SO_minimo ?><br>
					<span class="gris">Procesador:</span><?php echo ' ' . $procesador_minimo ?><br>
					<span class="gris">Memoria RAM:</span><?php echo ' ' . $memoria_minimo . ' ' . 'GB' ?><br>
					<span class="gris">Gráficos:</span><?php echo ' ' . $graficos_minimo ?><br>
					<span class="gris">Almacenamiento:</span><?php echo ' ' . $almac_minimo . ' ' . 'GB' ?><br>
					</p>
			</div>
			<div class="contenido4-der">
				<h4>Recomendado</h4>
				<p class="texto">
					<span class="gris">SO:</span><?php echo ' ' . $SO_recom ?><br>
					<span class="gris">Procesador:</span><?php echo ' ' . $procesador_recom ?><br>
					<span class="gris">Memoria RAM:</span><?php echo ' ' . $memoria_recom . ' ' . 'GB' ?><br>
					<span class="gris">Gráficos:</span><?php echo ' ' . $graficos_recom ?><br>
					<span class="gris">Almacenamiento:</span><?php echo ' ' . $almac_recom . ' ' . 'GB' ?><br>
					</p>
			</div>
		</div>
		<div style="clear:both"></div>
	</div>
	
	<div class="contenido">
		<h3>Comentarios</h3>
		
		<?php if(isset($comentarios) && $comentarios != null) {
			for($i=0;$i<$n;$i++){ ?>
			
				<div class="comentario">
					<h4><?php echo $comentarios[$i]['Nombre'] . ' ' . $comentarios[$i]['Apellidos'] ?></h4>
					<p style="font-size:120%"><?php echo $comentarios[$i]['Texto'] ?></p>
					<p style="display:inline" class="fecha gris"><?php echo $comentarios[$i]['Fecha'] ?></p>
					<form class="form-comentario" style="display:inline" action="juego.php?titulo=<?php echo $titulo ?>" method="post">
						<input type="hidden" id="posicion" name="posicion" value="<?php echo $i ?>">
						<?php if(isset($usuario) && $comentarios[$i]['Email'] == $usuario) { ?>
							<input type="submit" id="editar" class="btn-comentario" name="editar"  value="Editar">
						<?php } ?>
					</form>
					<form class="form-comentario" style="display:inline" action="juego.php?titulo=<?php echo $titulo ?>&modificar=si" method="post">
						<input type="hidden" id="posicion" name="posicion" value="<?php echo $i ?>">
						<?php if((isset($usuario) && $comentarios[$i]['Email'] == $usuario) || $conectado == 'root') { ?>
							<input type="submit" id="eliminar" class="btn-comentario" name="eliminar"  value="Eliminar">
						<?php } ?>
					</form>
				</div>
			
			<?php } 
		} else { ?>
			<p style="font-size:150%" class="comentario">No hay comentarios aún</p>
		<?php } 
		
		if($conectado != 'no') {?>
			<?php if($editar != null) { ?>
			<form class="comentario" action="juego.php?titulo=<?php echo $titulo ?>&modificar=si" method="post">
			<?php } else { ?>
			<form class="comentario" action="juego.php?titulo=<?php echo $titulo ?>" method="post">
			<?php } ?>
			  <div class="form-group">
				<p style="font-size:120%">Deje su comentario</p>
				<input type="text" class="form-control" id="comentario" name="comentario" rows="2" value="<?php echo $comentario ?>" >
				<br><input type="submit" id="enviar" name="enviar" type="button" class="btn btn-primary" value="Enviar">
			  </div>
			</form>
			
		<?php } ?>
		
	</div>
	
	<?php
		include( 'plantilla_footer.php');
	?>
 </body>