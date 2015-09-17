<?

// Funcion que Conecta a la Base de Dats
function funConnectToDataBase ($parEServer, $parEUser, $parEPassword, $parEDataBase)
{
	// Declara la variable de conexion global
	global $sock;

	// Se conecta a la Base de Datos
	$sock = mysql_connect($parEServer,$parEUser,$parEPassword);
	if (!$sock) die ("<br>Error de Conexion con Servidor MySQL.<br>");

	// Selecciona la Base de Datos
	$sel = mysql_select_db($parEDataBase);
	if (!$sel) die ("<br>Error de Seleccion de Base de Datos MySQL.<br>");
}

// Funcion que Ejecuta un Query de Consulta
function funEjecutaQuerySelect ($parEQuery)
{
	// Ejecuta el Query
	$recordset = mysql_query($parEQuery) or die ("<br>Error de Consulta: " . $parEQuery . "<br>");

	// Retorna el recordset
	return $recordset;
}

// Funcion que Ejecuta un Query de Edicion
function funEjecutaQueryEdit ($parEQuery)
{
	// Ejecuta el Query
	$resultado = mysql_query($parEQuery); // or die ("<br>Error de Ejecución: " . $parEQuery . "<br>");

	// Retorna el resultado (TRUE - exito / FALSE - error)
	return $resultado;
}

// Funcion que Devuelve una Arreglo desde el Recordset
function funDevuelveArregloRecordset ($parERecordset,&$parSArray)
{
	// Obtiene las logitudes del arreglo
	$nr = mysql_num_rows($parERecordset);
	$nf = mysql_num_fields($parERecordset);

	for ($varI=0;$varI<$nr;$varI++)
	{
		$results = mysql_fetch_array($parERecordset);
		for ($varJ=0;$varJ<$nf;$varJ++)
		{			
			$varFielName = mysql_field_name ($parERecordset,$varJ);
			$parSArray[$varFielName][$varI] = $results[$varFielName];
		}
	}

	// Retorna el numero de registros (filas del arreglo(
	return $nr;
}

// Funcion que Libera la Memoria utilizada por el Recordset
function funLiberaRecordset ($parERecordset)
{
	// Libero la memoria
	mysql_free_result($parERecordset);
}

// Funcion que Cierra la Conexion a la Base de Datos
function funCloseConectionToDataBase ()
{
	// Cierra la conexion abierta
	mysql_close();
}

?>