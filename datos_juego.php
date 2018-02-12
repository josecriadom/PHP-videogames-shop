<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php

	//recupera los datos de un juego a partir de un titulo

//realizamos la consulta para obtener los datos de ese juego
	if(!($res = $con->query("SELECT * FROM juego WHERE Titulo = '$titulo'"))){
		echo 'error al acceder a la tabla juego';
	} else {
		$fila = $res->fetch_assoc();
		$precio = $fila['Precio'];
		$descripcion = $fila['Descripcion'];
		$desarrollador = $fila['Desarrollador'];
		$editor = $fila['Editor'];
		$lanzamiento = $fila['Lanzamiento'];
		$pegi = $fila['Pegi'];
		$descripcion_pegi = $fila['DescripcionPegi'];
		$descriptores_pegi = explode(", ", $descripcion_pegi);
	}
	
	//realizamos la consulta para recuperoar los generos
	if(!($res = $con->query("SELECT Categoria FROM genero WHERE titulo='$titulo'"))){
		echo 'error';
	} else {
		$i = 0;
		while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {	
			foreach ($line as $col_value) {
				//echo "\t\t<td>$col_value</td>\n";
				$categorias[$i]= $col_value;
				$i = $i+1;
			}	
		}
		// Liberar resultados
		mysqli_free_result($res);
	}
	
	//realizamos la consulta para obtener los datos de ese juego
	if(!($res = $con->query("SELECT * FROM requisitosmin WHERE Titulo = '$titulo'"))){
		echo 'error al acceder a la tabla reqisitos min';
	} else {
		$fila = $res->fetch_assoc();
		$SO_minimo = $fila['SO'];
		$procesador_minimo = $fila['Procesador'];
		$memoria_minimo = $fila['RAM'];
		$graficos_minimo = $fila['Grafica'];
		$almac_minimo = $fila['Almacenamiento'];
	}
	
	//realizamos la consulta para obtener los datos de ese juego
	if(!($res = $con->query("SELECT * FROM requisitosmax WHERE Titulo = '$titulo'"))){
		echo 'error al acceder a la tabla reqisitos max';
	} else {
		$fila = $res->fetch_assoc();
		$SO_recom = $fila['SO'];
		$procesador_recom = $fila['Procesador'];
		$memoria_recom = $fila['RAM'];
		$graficos_recom = $fila['Grafica'];
		$almac_recom = $fila['Almacenamiento'];
	}
?>