<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<html>
  <head>
  </head>
<body>
	<div class="cabecera">
		<div class="contenido">
			<div class="centro">
				<h1><a href="index.php"><img src="imagenes/X.png" alt="icono xplay" width="50" height="50"/>play</a></h1>
			</div>
			
			<?php if ($conectado == 'no'){ ?>
				<div class="contenido">
					<a class="login" href="login.php">Iniciar sesión/Registrarse</a>
				</div>
			<?php } else { ?>
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Mi cuenta
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="perfil.php">Perfil público</a>
					<a class="dropdown-item" href="#">Mis datos</a>
				  </div>
				</div>
			<?php } ?>
			
		</div>
	</div>	
 </body>