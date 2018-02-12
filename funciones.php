<!-- José Criado Miguel --> 
<!-- Raúl Piorno Ramos --> 

<?php
function conectar(){
	//conectamos con la base de datos
	$con= new mysqli( 'localhost', 'root', '', 'xplay');
	$con->set_charset("utf8");
	
	return $con;
}


//----------------------------------------------------------------------------
//Funcion para ver los datos contenidos en un array de datos recibido 
//como parametro...
function verDatosColeccion( $clave, $coleccion, $nivel)
{
  //Ver parametros de la coleccion recibida...
  $tot= count( $coleccion);
  echo str_repeat( '.', $nivel*4) . 'Coleccion "' . $clave . '" con ' . $tot . ' elementos.' . '<br/>'."\n";
  foreach( $coleccion as $clave=>$valor) {
    verDatosParametro( $clave, $valor, $nivel + 1);
  }//foreach
}//verDatosColeccion


//----------------------------------------------------------------------------
//Funcion para ver el contenido de un Parametro determinado, detectando 
//si es un String único, o es un Array de Strings...
function verDatosParametro( $clave, $valor, $nivel)
{
  //Mirar a ver si el valor recibido es un Array o no...
  if (is_array( $valor)) {
    //Si es un Array, se recorre para mostrar su contenido...
    echo str_repeat( '.', $nivel*4) . $clave . '=Array(' . count( $valor) . ')' . '<br/>'."\n";
    foreach( $valor as $clave2 => $valor2) {
      verDatosParametro( $clave . "[" . $clave2 . "]", $valor2, $nivel + 1);
    }//foreach
  } else {
    echo str_repeat( '.', $nivel*4) . $clave . '= ' . $valor . '<br/>'."\n";
  }//if
}//verDatosParametro

//---------------------------------------------------------------------------
//Funciones para emular los metodos del objeto Request en JSP...
//---------------------------------------------------------------------------

//---------------------------------------------------------------------------
//Obtener un Array de Cadenas con los nombres de los parametros recibidos
function getParameterNames()
{
  $res= array();
  
  //Recorrer el array $_GET
  foreach( $_GET as $clave => $valor) {
    $res[]= $clave;
  }//foreach

  //Recorrer el array $_POST
  foreach( $_POST as $clave => $valor) {
    $res[]= $clave;
  }//foreach
  
  return ($res);
}//getParameterNames

//---------------------------------------------------------------------------
//Funcion para obtener un parametro de $_POST o $_GET, en ese orden.
//Si se encuentra el parametro deseado, se devuelve un String, o "null" si no.
function getParameter( $nombre)
{
  $res= null;
  
  if (isset( $_POST[$nombre])) {
    $res= $_POST[$nombre];
  } else if (isset( $_GET[$nombre])) {
    $res= $_GET[$nombre];
  }//if
  
  //Si el resultado es un array, coger el primer elemento del array.
  if (is_array($res)) {
    $res= reset( $res);
  }//if
  
  return ($res);
}//getParameter

//---------------------------------------------------------------------------
//Funcion para obtener el array de parametros de $_POST o $_GET, en ese orden.
//Si se encuentra el parametro deseado, se devuelve un Array de Strings,
//o "null" si no...
function getParameterValues( $nombre)
{
  $res= null;
  
  if (isset( $_POST[$nombre])) {
    $res= $_POST[$nombre];
  } else if (isset( $_GET[$nombre])) {
    $res= $_GET[$nombre];
  }//if
  
  //Si el resultado no es un array, se crea como array de 1 elemento.
  if (!is_array($res)) {
    $res=array( (string)$res);
  }//if
  
  return ($res);
}//getParameterValues



//direccion de la imagen
function direccionImagen( $nombre) {
	return ('imagenes/' . str_replace(" ", "_", $nombre) . '.jpg');
}//direccionImagen

function existeMarca( $lista, $dato)
{
  $res= false;
  
  foreach( $lista as $clave => $valor) {
    if (strcasecmp( $dato, $valor) == 0) {
      $res= true; break;
    }//if
  }//foreach
  
  return ($res);
}//existeMarca

function preciojuego($nombre) {
	$con = conectar();
	
	//realizamos la consulta para comprobar el precio del juego
	$res = $con->query("SELECT precio FROM juego WHERE Titulo = '$nombre'");
	
	//obtenemos el valor de la consulta
	//es un array de un unico elemento
	for($i = $res->num_rows-1; $i>=0;$i--){
		$res->data_seek(0);
		$fila = $res->fetch_assoc();
		//echo $fila['precio'] . "\n";
		$precio = $fila['precio'];
		//echo $precio;
	}
	
	return ($precio);
}//preciojuego

function obtenGeneros(){
	$fp = fopen("generos.txt", "r");
	
	$generos = array();
	
	while(!feof($fp)) {
		$linea = fgets($fp);
		$generos[] = $linea;
	}
	
	fclose($fp);
	
	return ($generos);
}

function escribeGeneros($generos){
	$fp = fopen("generos.txt", "w");
	
	foreach($generos as $valor){
		fwrite($fp, $valor);
	}
	
	fclose($fp);
}

//NO hace falta cerrar el modo PHP, asi nos aseguramos que no hay lineas en
//blanco o espacios que afecten a la salida HTML.