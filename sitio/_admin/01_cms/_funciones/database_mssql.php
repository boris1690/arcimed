<?

// Funcion que Conecta a la Base de Dats
function funConnectToDataBaseMS ($parEServer, $parEUser, $parEPassword, $parEDataBase)
{
	// Declara la variable de conexion global
	global $sockMS;

	// Se conecta a la Base de Datos
	$sockMS = mssql_connect($parEServer,$parEUser,$parEPassword);
	if (!$sockMS) die ("<br>Error de Conexion con Servidor MSSQL.<br>");

	// Selecciona la Base de Datos
	$selMS = mssql_select_db($parEDataBase);
	if (!$selMS) die ("<br>Error de Seleccion de Base de Datos MSSQL.<br>");
}

// Funcion que Ejecuta un Query de Consulta
function funEjecutaQuerySelectMS ($parEQuery)
{
	// Ejecuta el Query
	$recordsetMS = mssql_query($parEQuery) or die ("<br>Error de Consulta: " . $parEQuery . "<br>");

	// Retorna el recordsetMS
	return $recordsetMS;
}

// Funcion que Ejecuta un Query de Edicion
function funEjecutaQueryEditMS ($parEQuery)
{
	// Ejecuta el Query
	$resultadoMS = mssql_query($parEQuery) or die ("<br>Error de Ejecucion: " . $parEQuery . "<br>");

	// Retorna el resultadoMS (TRUE - exito / FALSE - error)
	return $resultadoMS;
}

// Funcion que Devuelve una Arreglo desde el Recordset
function funDevuelveArregloRecordsetMS ($parERecordset,&$parSArray)
{
	// Obtiene las logitudes del arreglo
	$nrMS = mssql_num_rows($parERecordset);
	$nfMS = mssql_num_fields($parERecordset);

	for ($varI=0;$varI<$nrMS;$varI++)
	{
		$results = mssql_fetch_array($parERecordset);
		for ($varJ=0;$varJ<$nfMS;$varJ++)
		{			
			$varFielName = mssql_field_name ($parERecordset,$varJ);
			$parSArray[$varFielName][$varI] = $results[$varFielName];
		}
	}

	// Retorna el numero de registros (filas del arreglo(
	return $nrMS;
}

// Funcion que Libera la Memoria utilizada por el Recordset
function funLiberaRecordsetMS ($parERecordset)
{
	// Libero la memoria
	mssql_free_result($parERecordset);
}

// Funcion que Cierra la Conexion a la Base de Datos
function funCloseConectionToDataBaseMS ()
{
	// Cierra la conexion abierta
	mssql_close();
}

?>