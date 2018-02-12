<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//enlazamos con las funcones
require_once( 'funciones.php');

//arrays utilizados
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

//Detectar parámetros de entrada
$cerrar = getParameter("cerrar");
$eliminar = getParameter("eliminar");
$editnombre = getParameter("editnombre");
$editapellidos = getParameter("editapellidos");
$editnacimiento = getParameter("editnacimiento");
$editemail = getParameter("editemail");
$editpais = getParameter("editpais");

$editnombre2 = getParameter("editnombre2");
$editapellidos2 = getParameter("editapellidos2");
$editnacimiento2 = getParameter("editnacimiento2");
$editemail2 = getParameter("editemail2");
$editpais2 = getParameter("editpais2");

//Detectar parámetros de entrada
$valor= (getParameter("valor"));
$pais= getParameter( 'pais');
if ($pais === null) $pais= '';
$dia= getParameter( 'dia');
if ($dia === null) $dia= '';
$mes= getParameter( 'mes');
if ($mes === null) $mes= '';
$mes = (integer)(1+(int)$mes);
$año= getParameter( 'año');
if ($año === null) $año= '';
$editar= (getParameter("editar"));

//realizamos las accines necesarias para cerrar sesion
if($cerrar != null){
	session_destroy();
	header("location: index.php");
	exit();
}

//realizamos las accines necesarias para eliminar sesion
if($eliminar != null){
	session_destroy();
	if(!($con->query("DELETE FROM usuario WHERE Email = '$email'"))){
		echo 'fallo';
	}
	header("location: index.php");
	exit();
}


if($editnombre2 != null){
	if(!($res = $con->query("UPDATE usuario SET nombre = '$valor' WHERE email = '$email'"))){
		echo 'fallo';
	}
	echo 'esto no vaaaaaaaa';
	header('location: perfil.php');
}
if($editapellidos2 != null){
	if(!($res = $con->query("UPDATE usuario SET apellidos = '$valor' WHERE email = '$email'"))){
		echo 'fallo';
	}
	header('location: perfil.php');
}
if($editnacimiento2 != null){
	//guardaos la fecha en su formato
	$fecha = $año . '-' . $mes . '-' . $dia;

	if(!($res = $con->query("UPDATE usuario SET nacimiento = '$fecha' WHERE email = '$email'"))){
		echo 'fallo';
	}
	header('location: perfil.php');
}
if($editemail2 != null){
	$_SESSION['usuario'] = $valor;
	if(!($res = $con->query("UPDATE usuario SET email = '$valor' WHERE email = '$email'"))){
		echo 'fallo';
	}
	header('location: perfil.php');
}
if($editpais2 != null){
	if(!($res = $con->query("UPDATE usuario SET pais = '$valor' WHERE email = '$email'"))){
		echo 'fallo';
	}
	header('location: perfil.php');
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

<?php if($conectado != 'no') { ?>

	<div class="contenido">
		<h2><?php echo $nombre . ' ' . $apellidos ?></h2>
		
		<h3>Datos públicos</h3>
		<div class="perfil">
			<span class="gris">Nombre:</span> <?php echo $nombre ?>
			<form style="display:inline">
				<button type="submit" class="fondo" name="editnombre" value="nombre">
					<img class="boton-perfil_b" src='imagenes/editar_b.png' alt="editar" />
				</button>
			</form>
			<?php if($editnombre != null) { ?>
				<br><form style="display:inline">
					<label for="valor">Introduce el nuevo valor</label>
					<input type="name" class="form-control" style="width:250px" id="valor" name="valor">
					<input style="cursor:pointer" type="submit" id="editnombre2" name="editnombre2" class="btn btn-primary" value="Editar">
				</form>
			<?php } ?>
			
			<br><span class="gris">Apellidos:</span> <?php echo $apellidos ?>
			<form style="display: inline">
				<button type="submit" class="fondo" name="editapellidos" value="apellidos">
					<img class="boton-perfil_b" src='imagenes/editar_b.png' alt="editar" />
				</button>
			</form>
			<?php if($editapellidos != null) { ?>
				<br><form style="display:inline">
					<label for="valor">Introduce el nuevo valor</label>
					<input type="name" class="form-control" style="width:250px" id="valor" name="valor">
					<input style="cursor:pointer" type="submit" id="editapellidos2" name="editapellidos2" class="btn btn-primary" value="Editar">
				</form>
			<?php } ?>
			
			<br><span class="gris">Fecha de nacimiento:</span> <?php echo $nacimiento ?>
			<form style="display: inline">
				<button type="submit" class="fondo" name="editnacimiento" value="nacimiento">
					<img class="boton-perfil_b" src='imagenes/editar_b.png' alt="editar" />
				</button>
			</form>
			<?php if($editnacimiento != null) { ?>
				<br><form style="display:inline">
					<div class="form-group">
						<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="dia" name="dia">
						  <?php for($i=1;$i<32;$i++) { ?>
							<option value="<?php echo $i?>" <?php echo ( (strcasecmp( $dia, '<?php echo $i?>') == 0) ? 'selected=""' : ''); ?> ><?php echo $i?></option>
						  <?php } ?>
						</select>
						<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="mes" name="mes">
						  <?php foreach($meses as $clave => $valor){ ?>
							<option value="<?php echo $clave?>" <?php echo ( (strcasecmp( $mes, '<?php echo $clave?>') == 0) ? 'selected=""' : ''); ?> ><?php echo $valor?></option>
						  <?php } ?>
						</select>
						<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="año" name="año">
						  <?php for($i=1990;$i<2017;$i++) { ?>
							<option value="<?php echo $i?>" <?php echo ( (strcasecmp( $año, '<?php echo $i?>') == 0) ? 'selected=""' : ''); ?> ><?php echo $i?></option>
						  <?php } ?>
						</select>
					</div>
					<input style="cursor:pointer" type="submit" id="editnacimiento2" name="editnacimiento2" class="btn btn-primary" value="Editar">
				</form>
			<?php } ?>
			
			<br><span class="gris">Dirección de email:</span> <?php echo $email ?>
			<form style="display: inline">
				<button type="submit" class="fondo" name="editemail" value="email">
					<img class="boton-perfil_b" src='imagenes/editar_b.png' alt="editar" />
				</button>
			</form>
			<?php if($editemail != null) { ?>
				<br><form style="display:inline">
					<label for="valor">Introduce el nuevo valor</label>
					<input type="email" class="form-control" style="width:250px" id="valor" name="valor">
					<input style="cursor:pointer" type="submit" id="editemail2" name="editemail2" class="btn btn-primary" value="Editar">
				</form>
			<?php } ?>
			
			<br><span class="gris">País:</span> <?php echo $pais ?>
			<form style="display: inline">
				<button type="submit" class="fondo" name="editpais" value="pais">
					<img class="boton-perfil_b" src='imagenes/editar_b.png' alt="editar" />
				</button>
			</form>
			<?php if($editpais != null) { ?>
				<br><form style="display:inline">
					<label for="valor">Introduce el nuevo valor</label>
					<input type="name" class="form-control" style="width:250px" id="valor" name="valor">
					<input style="cursor:pointer" type="submit" id="editpais2" name="editpais2" class="btn btn-primary" value="Editar">
				</form>
			<?php } ?>
			<br>
		</div>
		
		<h3>Opciones</h3>
		<div class="perfil">
			<form>
				<input type="submit" id="cerrar" name="cerrar" class="boton-cerrar" value="Cerrar sesión"><br>
				<input type="submit" id="eliminar" name="eliminar" class="boton-eliminar" value="Eliminar cuenta">
			</form>
		</div>
	</div>
	
<?php } else { ?>
	<div class="contenido">
		<br><br><h2>UPS! No deberias estar aquí</h2>
		<br><h2>Si quieres iniciar sesión, puedes hacerlo aquí:</h2>
		<br><a class="btn boton-verde" href="login.php" role="button">Iniciar sesión</a>
	</div>
<?php } 
		include( 'plantilla_footer.php');
	?>
 </body>
 
 