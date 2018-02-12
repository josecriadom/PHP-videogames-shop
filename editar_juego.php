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

//array usados
$generos = obtenGeneros();
$pegis = array("3", "7", "12", "16", "18");
$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

//Detectar parámetros de entrada
$titulo = getParameter('titulo');
$precio = getParameter('precio');
$descripcion = getParameter('descripcion');
$desarrollador = getParameter('desarrollador');
$editor = getParameter('editor');
$dia= getParameter( 'dia');
$mes= getParameter( 'mes');
$mes = (integer)(1+(int)$mes);
$año= getParameter( 'año');
$lanzamiento = $año . '-' . $mes . '-' . $dia;
$pegi = getParameter('pegi');
$descripcion_pegi = getParameter('descripcion_pegi');
$genero= getParameterValues( 'genero');

$SO_minimo = getParameter('SO_minimo');
$procesador_minimo = getParameter('procesador_minimo');
$memoria_minimo = getParameter('memoria_minimo');
$graficos_minimo = getParameter('graficos_minimo');
$almac_minimo = getParameter('almac_minimo');

$SO_recom = getParameter('SO_recom');
$procesador_recom = getParameter('procesador_recom');
$memoria_recom = getParameter('memoria_recom');
$graficos_recom = getParameter('graficos_recom');
$almac_recom = getParameter('almac_recom');

$insertar = getParameter('insertar');

$con = conectar();

if(isset($_GET['nombre']) && $titulo == null){
	$titulo = $_GET['nombre'];
	//recupera los datos de un juego
	include( 'datos_juego.php');
	$genero = $categorias;
}

$lanzamiento2 = explode("-", $lanzamiento);
$año = (Integer)$lanzamiento2[0];
$mes = (Integer)$lanzamiento2[1]-1;
$dia = (Integer)$lanzamiento2[2];

if($insertar != null){
	if($titulo != null && $precio != null && $descripcion != null && $editor != null && $pegi != null && $genero != null){
		if(!(isset($_GET['nombre']))) {
			//comprobamos que el juego no existe
			if(!($res = $con->query("SELECT COUNT(*) FROM juego WHERE titulo = '$titulo'"))){
				echo 'error al acceder a la tabla juego';
			} else {
				$fila = $res->fetch_assoc();
				if($fila['COUNT(*)'] == 0){
					//guardamos los datos
					if(!($res = $con->query("INSERT INTO juego (`Titulo`, `Precio`, `Descripcion`, `Desarrollador`, `Editor`, `Lanzamiento`, `Pegi`, `DescripcionPegi`) VALUES ('$titulo','$precio', '$descripcion', '$desarrollador', '$editor', '$lanzamiento','$pegi', '$descripcionpegi')"))){
						echo 'error al insertar juego';
					}else{
						foreach($genero as $valor){
							$res = $con->query("INSERT INTO `genero` (`Titulo`, `Categoria`) VALUES ('$titulo', '$valor')");
						}
						if(!($res = $con->query("INSERT INTO requisitosmax (`Titulo`, `SO`, `Procesador`, `RAM`, `Grafica`, `Almacenamiento`) VALUES ('$titulo', '$SO_recom', '$procesador_recom', '$memoria_recom', '$graficos_recom', 'almac_recom')"))){
							echo 'error al insertar requisitos recomendados';
						}elseif(!($res = $con->query("INSERT INTO requisitosmin (`Titulo`, `SO`, `Procesador`, `RAM`, `Grafica`, `Almacenamiento`) VALUES 	('$titulo', '$SO_minimo', '$procesador_minimo', '$memoria_minimo', '$graficos_minimo', 'almac_minimo')"))){
							echo 'error al insertar requisitos minimos';
						}
					}
				}else{//el juego ya existe
					$existejuego = 1;
				}
			}
		} else {
			$titulo2 = $_GET['nombre'];
			if(!($res = $con->query("UPDATE juego SET Titulo='$titulo', Precio='$precio', Descripcion='$descripcion', Desarrollador='$desarrollador', Editor='$editor', Lanzamiento='$lanzamiento', Pegi='$pegi', DescripcionPegi='$descripcion_pegi' WHERE Titulo='$titulo2'"))){
				echo 'error al insertar juego';
			}else{
				$res = $con->query("DELETE FROM genero WHERE Titulo='titulo2'");
				foreach($genero as $valor){
					$res = $con->query("INSERT INTO `genero` (`Titulo`, `Categoria`) VALUES ('$titulo', '$valor')");
				}
				if(!($res = $con->query("UPDATE requisitosmax SET Titulo='$titulo', SO='$SO_recom', Procesador='$procesador_recom', RAM='$memoria_recom', Grafica='$graficos_recom', Almacenamiento='almac_recom' WHERE Titulo='$titulo2'"))){
					echo 'error al insertar requisitos recomendados';
				}elseif(!($res = $con->query("UPDATE requisitosmax SET Titulo='$titulo', SO='$SO_minimo', Procesador='$procesador_minimo', RAM='$memoria_minimo', Grafica='$graficos_minimo', Almacenamiento='almac_minimo' WHERE Titulo='$titulo2'"))){
					echo 'error al insertar requisitos minimos';
				}elseif($titulo != $titulo2){
					$res = $con->query("UPDATE comprados SET Titulo='$titulo' WHERE Titulo='titulo2'");
					$res = $con->query("UPDATE inicio Titulo='$titulo' WHERE Titulo='titulo2'");
					//$res = $con->query("UPDATE comentarios Titulo='$titulo' WHERE Titulo='titulo2'");
				}
			}
		}
	}else{//no se ha introducido los datos necesario
		$incompleto = 1;
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
		<h2>Nuevo juego!!</h2>
		<p style="color:#A4D007">**Recuerde introducir en la carpeta '/imagenes' la imagen de el juego con extensión '.jpg' y el nombre debe ser el título sustitullendo los espacios por '_'.</p><br>
		
		<form action="" method="post">
			<h3>Datos principales</h3>
			<div class="form-group">
				<label for="titulo">Título</label>
				<input type="text" class="form-control" id="titulo" name="titulo" placeholder="Introduzca el título" value="<?php echo $titulo ?>">
				<?php if(isset($existejuego)){?>
					<p style="color:red">Este juego ya existe, si quiere modificarlo busquelo en la plataforma y modifiqueló ahi</p>
				<?php } ?>
			</div>
			<div class="form-group">
				<label for="precio">Precio</label>
				<input type="number" class="form-control" id="precio" name="precio" value="<?php echo $precio ?>">
			</div>
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<textarea type="text" class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Introduzca la descripción"><?php echo $descripcion ?></textarea>
			</div>
			<div class="form-group">
				<label for="desarrollador">Desarrollador</label>
				<input type="text" class="form-control" id="desarrollador" name="desarrollador" placeholder="Introduzca el desarrollador" value="<?php echo $desarrollador ?>">
			</div>
			<div class="form-group">
				<label for="editor">Editor</label>
				<input type="text" class="form-control" id="editor" name="editor" placeholder="Introduzca el editor" value="<?php echo $editor ?>">
			</div>
			<label for="dia">Fecha de lanzamiento</label>
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
			  <?php for($i=1990;$i<2018;$i++) { ?>
				<option value="<?php echo $i?>" <?php echo ( (strcasecmp( $año, '<?php echo $i?>') == 0) ? 'selected=""' : ''); ?> ><?php echo $i?></option>
			  <?php } ?>
			</select>
			<p style="font-size: 110%;">Seleccione el pegi</p>
			<?php foreach($pegis as $valor){ ?>
				<div class="form-check-inline">
				  <input  type="radio" id="<?php echo $valor ?>" name="pegi[]" value="<?php echo $valor ?>" <?php echo ( ($pegi == $valor) ? 'checked=""' : ''); ?> >
				  <label for="<?php echo $valor ?>" style="font-size: 110%;"><?php echo $valor ?></label>
				</div>
			<?php } ?>
			<br><br>
			<p style="font-size: 110%;">Seleccione los generos a los que pertenece</p>
			<?php foreach($generos as $valor){ ?>
				<div class="form-check-inline">
				  <input  type="checkbox" id="<?php echo $valor ?>" name="genero[]" value="<?php echo $valor ?>" <?php echo (existeMarca( $generos, $valor) ? 'checked=""' : ''); ?> >
				  <label for="<?php echo $valor ?>" style="font-size: 110%;"><?php echo $valor ?></label>
				</div>
			<?php } 
			if(isset($incompleto)){?>
				<p style="color:red">Debe introducir todos los valores anteriores a este mensaje</p>
			<?php } ?>
			<br><br><div class="form-group">
				<label for="descripcionpegi">Descripción del pegi, recuerde introducir los distintos parametros separados por comas</label>
				<input type="text" class="form-control" id="descripcion_pegi" name="descripcion_pegi" placeholder="Introduzca la descrippción del pegi" value="<?php echo $descripcion_pegi; ?>">
			</div>
			
			<h3>Requisitos mínimos</h3>
			<div class="form-group">
				<label for="SO_minimo">Sistema operativo</label>
				<input type="text" class="form-control" id="SO_minimo" name="SO_minimo" placeholder="Introduzca el sistema operativo" value="<?php echo $SO_minimo; ?>">
			</div>
			<div class="form-group">
				<label for="procesador_minimo">Procesador</label>
				<input type="text" class="form-control" id="procesador_minimo" name="procesador_minimo" placeholder="Introduzca el procesador" value="<?php echo $procesador_minimo; ?>">
			</div>
			<div class="form-group">
				<label for="memoria_minimo">RAM, introduzca solo las unidades en GB</label>
				<input type="number" class="form-control" id="memoria_minimo" name="memoria_minimo" value="<?php echo $memoria_minimo; ?>">
			</div>
			<div class="form-group">
				<label for="graficos_minimo">Tarjeta gráfica</label>
				<input type="text" class="form-control" id="graficos_minimo" name="graficos_minimo" placeholder="Introduzca la tarjeta gráfica" value="<?php echo $graficos_minimo; ?>">
			</div>
			<div class="form-group">
				<label for="almac_minimo">Almacenamiento, introduzca solo las unidades en GB</label>
				<input type="number" class="form-control" id="almac_minimo" name="almac_minimo" value="<?php echo $almac_minimo; ?>">
			</div>
			
			<h3>Requisitos recomendados</h3>
			<div class="form-group">
				<label for="SO_recom">Sistema operativo</label>
				<input type="text" class="form-control" id="SO_recom" name="SO_recom" placeholder="Introduzca el sistema operativo" value="<?php echo $SO_recom; ?>">
			</div>
			<div class="form-group">
				<label for="procesador_recom">Procesador</label>
				<input type="text" class="form-control" id="procesador_recom" name="procesador_recom" placeholder="Introduzca el procesador" value="<?php echo $procesador_recom; ?>">
			</div>
			<div class="form-group">
				<label for="memoria_recom">RAM, introduzca solo las unidades en GB</label>
				<input type="number" class="form-control" id="memoria_recom" name="memoria_recom" value="<?php echo $memoria_recom; ?>">
			</div>
			<div class="form-group">
				<label for="graficos_recom">Tarjeta gráfica</label>
				<input type="text" class="form-control" id="graficos_recom" name="graficos_recom" placeholder="Introduzca la tarjeta gráfica" value="<?php echo $graficos_recom; ?>">
			</div>
			<div class="form-group">
				<label for="almac_recom">Almacenamiento, introduzca solo las unidades en GB</label>
				<input type="number" class="form-control" id="almac_recom" name="almac_recom" value="<?php echo $almac_recom; ?>">
			</div>
			
			<br><input type="submit" id="insertar" name="insertar" class="btn btn-primary" value="Insertar">
			<br><br><a href="busqueda.php?mantenimiento=si"><button type="button" class="btn btn-danger">Cancelar</button></a>
		</form>
	</div>
	
<?php } else { ?>
	<div class="contenido">
		<br><br><h2>UPS! No deberias estar aquí</h2>
	</div>
<?php } 
	
		include( 'plantilla_footer.php');
	?>
 </body>