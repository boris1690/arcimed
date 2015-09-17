<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../_funciones/parametros.php";
	require "./../_funciones/secure.php";
	require "./../_funciones/funciones.php";
	require "./../_funciones/database_$aplDataBaseLibrary.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();

	// verifico si la sesion de usuario esta activa y si no lo está redirecciono al fin
	if (!$_SESSION['User_Permit_Access']) header("Location: " . $aplAplicationURL . "mantenimiento/cgiClose.php");
?>

<html>
<head>
	<title>.: KFC :.</title>
	<script language="javascript" src="./../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">

	<script language="JavaScript">
	<!--

		function escribeImagen(parEUrlImagen)
		{
			;
			// escribe el codigo de la imagen en el textbox
			//parent.document.frames['form'].document.forms[0].txtTextInfo.value = "Hola Alex";
		}

	-->
	</script>

</head>
<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Recupero el Usuario
	$varUserUser = $_SESSION['User_User'];

	// Selecciona los registros
	if ($varUserUser == "administrador")
		$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_archivo");
	else
		$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_archivo where USR_USUARIO='$varUserUser'");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiArch = trim($results["COD_ARCHIVO"][$varI]);
			$varNombArch = trim($results["NOM_ARCHIVO"][$varI]);
			$varFileArch = trim($results["FIL_ARCHIVO"][$varI]);

			// despliego los datos
			print "<tr>";
			print "	<td width=\"100%\" class=\"texttabl\"><a href=\"#\" onClick=\"escribeImagen('./_upload/$varFileArch'); return false;\" class=\"linktabl\">$varNombArch</a><br><font style=\"color:#ca6500\">./_upload/$varFileArch</font></td>";
			print "</tr>";
		}

		// cierra la tabla
		print "</table>";

		print "\n<script language=\"JavaScript\">";
		print "\n<!--";
		print "\n	tigra_tables('tabDatos', 0, 0, '$aplTigraBackColorUno', '$aplTigraBackColorDos', '$aplTigraBackColorOver', '$aplTigraBackColorSelect');";
		print "\n-->";
		print "\n</script>";
	}
	else
	{
		print "<br>";		
		print "\n<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"$aplFormTableBackColor\" style=\"border: 1px solid rgb($aplFormTableBorderColor)\">";
		print "<tr>";
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Archivos</td>";
		print "</tr>";
		print "</table>";
	}
	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();
?>

</center>

</body>
</html>