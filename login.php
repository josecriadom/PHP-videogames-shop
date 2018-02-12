<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
//inicio de sesion
session_start();

// no, si o root
if(isset($_SESSION['conectado']))
	$conectado = $_SESSION['conectado'];
else 
	$conectado = 'no';

//enlazamos con las funcones
require_once( 'funciones.php');

$con = conectar();


//Detectar parámetros de entrada
$inicioEmail= getParameter("inicio_e-mail");
$inicioContraseña= getParameter("inicio_contraseña");
$btnIniciar= (getParameter("btnIniciar"));


$crearNombre= (getParameter("crear_nombre"));
$crearApellidos= (getParameter("crear_apellidos"));
$pais= getParameter( 'pais');
if ($pais === null) $pais= '';
$dia= getParameter( 'dia');
if ($dia === null) $dia= '';
$mes= getParameter( 'mes');
if ($mes === null) $mes= '';
$mes = (integer)(1+(int)$mes);
$año= getParameter( 'año');
if ($año === null) $año= '';
$crearEmail= (getParameter("crear_e-mail"));
$crearcontraseña= (getParameter("crear_contraseña"));
$confContraseña= (getParameter("crear_conf_contraseña"));
$crearAdmin= (getParameter("root_contraseña"));
$btnCrear= (getParameter("btnCrear"));

//arrays utilizados
$paises = array("España", "Zimbabwe", "Rumania", "Portugal", "Francia", "Suecia", "Japón");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

//comprobamos is el usuario quiere iniciar sesion o registrarse
if($btnIniciar !== null){
	if(($inicioEmail != null) && ($inicioContraseña != null)){
		//realizamos la consulta para comprobar que existe ese email en la base de datos
		if(!($res = $con->query("SELECT * FROM usuario WHERE Email = '$inicioEmail'"))){
			echo 'error al acceder a la tabla usuario';
		} else {
			$fila = $res->fetch_assoc();		
			if($res->num_rows == 1){
				$contraseña = $fila['Contraseña'];
				
				if($contraseña == $inicioContraseña){
					//se guarda el email para mas tarda recuperar los datos de la base de datos que correspondan a este email
					$_SESSION['usuario'] = $inicioEmail;
					
					//obtenemos el valor de root
					$root = $fila['root'];

					if($root == 1)
						$_SESSION['conectado'] = 'root';
					else
						$_SESSION['conectado'] = 'si';
					header("location: index.php");	//Se redirige
					exit();	//Evitar la generacion del html
				} else {
					$errorInicio = 1;
				}
			} else {
				$errorEmail = 1;
			}
	}
	}
} unset($res);

if($btnCrear !== null) {
	//hay que tener en cuenta que de la forma que esta hecho los valores de pais, dia, mes y año mo pueden quedar vacios
	if (($crearNombre !== null) && ($crearApellidos !== null) && ($crearEmail !== null) && ($crearcontraseña !== null) && ($confContraseña !== null)){
		//guardaos la fecha en su formato
		$fecha = $año . '-' . $mes . '-' . $dia;
		
		//guardamos el valor del pais
		$pais = $paises[$pais];
		
		//realizamos la consulta para comprobar que existe ese email en la base de datos
		if(!($res = $con->query("SELECT COUNT(*) FROM usuario WHERE Email = '$crearEmail'"))){
			echo 'error al acceder a la tabla usuario';
		} else {
			$fila = $res->fetch_assoc();
		
		
			if($fila['COUNT(*)'] == 0){
				if($crearcontraseña == $confContraseña){
					//guardamos el email en la sesion
					$_SESSION['usuario'] = $crearEmail;
					
					//comprobamos si es root
					if($crearAdmin != null){
						
						//realizamos la consulta para comprobar que existe esa contraseña
						if(!($res = $con->query("SELECT COUNT(*) FROM contraseñasroot WHERE valor = '$crearAdmin'"))){
							echo 'error al acceder a la tabla contraseñaroot';
						} else {
							$fila = $res->fetch_assoc();
							if($fila['COUNT(*)'] == 1){
								$_SESSION['conectado'] = 'root';
								
								//------------insertamos la tupla con root---------------
								if(!($con->query("INSERT INTO `usuario` (`Nombre`, `Apellidos`, `Pais`, `Nacimiento`, `Email`, `Contraseña`, `root`) VALUES
		('$crearNombre', '$crearApellidos', '$pais', '$fecha', '$crearEmail', '$crearcontraseña', 1)"))){
									echo 'fallo al insertar usuario';
								} else {
									header("location: index.php");	//Se redirige
									exit();	//Evitar la generacion del html
								}
							} else {
								$errorRoot = 1;
							}
						}
					} else {
						$_SESSION['conectado'] = 'si';
						
						//--------------insertamos la tupla sin root-------------
						if(!($con->query("INSERT INTO `usuario` (`Nombre`, `Apellidos`, `Pais`, `Nacimiento`, `Email`, `contraseña`, `root`) VALUES
	('$crearNombre', '$crearApellidos', '$pais', '$fecha', '$crearEmail', '$crearcontraseña', 0)"))){
							echo 'fallo al insertar usuario';
						} else {
							header("location: index.php");	//Se redirige
							exit();	//Evitar la generacion del html
						}
					}
				} else {
					$errorContraseña = 1;
				}
			} else {
				$errorEmail = 1;
			}
		}
	}
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
	
	<?php if($conectado == 'no') { ?>
	
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
		<div class="contenido5-izq">
			<h3>Iniciar sesión</h3>
			<form action="" method="post">
				<div class="form-group">
					<label for="inicio_e-mail">Dirección de e-mail</label>
					<input type="email" class="form-control" id="inicio_e-mail" name="inicio_e-mail" aria-describedby="inicio_emailHelp" placeholder="Introduzca su e-mail" value="<?php echo $inicioEmail; ?>">
					<small id="inicio_emailHelp" class="form-text text-muted">El e-mail no será compartido</small>
				</div>
				<?php if(isset($errorEmail) && ($inicioEmail != null)) { ?>
					<p style="color:red">E-mail inexistente</p><br>
				<?php } ?>
				<div class="form-group">
					<label for="inicio_contraseña">Contraseña</label>
					<input type="password" class="form-control" id="inicio_contraseña" name="inicio_contraseña" placeholder="Introduzca su contraseña">
				</div>
				<?php if(isset($errorInicio) && (($inicioEmail != null) || ($inicioContraseña != null))) { ?>
					<p style="color:red">E-mail o contraseña incorrectos</p><br>
				<?php } ?>
				<input type="submit" id="btnIniciar" name="btnIniciar" class="btn btn-primary" value="Aceptar">
			</form>
		</div>
				
		<div class="contenido5-der">
			<h3>Crear</h3>
			<form action="" method="post">
				<div class="form-group">
					<label for="crear_nombre">Nombre</label>
					<input type="text" class="form-control" id="crear_nombre" name="crear_nombre" placeholder="Introduzca su nombre" value="<?php echo $crearNombre; ?>">
				</div>
				<div class="form-group">
					<label for="crear_apellidos">Apellidos</label>
					<input type="name" class="form-control" id="crear_apellidos" name="crear_apellidos" placeholder="Introduzca sus apellidos" value="<?php echo $crearApellidos; ?>">
				</div>
				<div class="form-group">
					<label for="pais">País de residencia &emsp;</label>
					<select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="pais" name="pais">
					  <?php foreach($paises as $clave => $valor){ ?>
						<option value="<?php echo $clave?>" <?php echo ( (strcasecmp( $pais, '<?php echo $clave?>') == 0) ? 'selected=""' : ''); ?> ><?php echo $valor?></option>
					  <?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="dia">Fecha de nacimiento</label>
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
				<div class="form-group">
					<label for="crear_e-mail">Dirección de e-mail</label>
					<input type="email" class="form-control" id="crear_e-mail" name="crear_e-mail" placeholder="Introduzca su e-mail" value="<?php echo $crearEmail; ?>">
				</div>
				<?php if(isset($errorEmail) && ($crearEmail != null)){ ?>
					<p style="color:red">Este e-mail ya existe</p><br>
				<?php } ?>
				
				<div class="form-group">
					<label for="crear_contraseña">Contraseña</label>
					<input type="password" class="form-control" id="crear_contraseña" name="crear_contraseña" placeholder="Introduzca su contraseña">
				</div>
				<div class="form-group">
					<label for="crear_conf_contraseña">Confirmar contraseña</label>
					<input type="password" class="form-control" id="crear_conf_contraseña" name="crear_conf_contraseña" placeholder="Confirme su contraseña">
					<?php if(isset($errorContraseña)) { ?>
						<p style="color:red">Las contraseñas no coinciden</p><br>
					<?php } ?>
				</div>
				<h4><br>Crear cuenta administrador</h4>
				<div class="form-group">
					<label for="root_contraseña">Contraseña suministrada por un administrador</label>
					<input type="password" class="form-control" id="root_contraseña" name="root_contraseña" aria-describedby="crear_emailHelp" placeholder="Contraseña administrador">
					<small id="crear_emailHelp" class="form-text text-muted">Esta contraseña es necesaria para comprobar que usted tiene permiso para crear una cuenta de administrador</small>
					<?php if(isset($errorRoot) && ($crearAdmin != null)){ ?>
						<p style="color:red">Contraseña de administrador incorrecta. Introduzca una correcta o dejelo en blanco</p><br>
					<?php } ?>
				</div>
				<input type="submit" id="btnCrear" name="btnCrear" class="btn btn-primary" value="Aceptar">
			</form>
		</div>
	</div>
	
	<?php } else { ?>
		<div class="contenido">
			<br><br><h2>Ya estas conectado, desde aquí puedes ir a tu perfil:</h2>
			<a class="btn boton-verde" href="perfil.php" role="button">Perfil</a>
		</div>
		
	<?php } 
		include( 'plantilla_footer.php');
	?>
 </body>
 