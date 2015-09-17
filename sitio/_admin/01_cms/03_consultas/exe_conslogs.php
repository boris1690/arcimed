<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../_funciones/parametros.php";
	require "./../_funciones/secure.php";
	require "./../_funciones/database_$aplDataBaseLibrary.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();

	// verifico si la sesion de usuario esta activa y si no lo está redirecciono al fin
	if (!$_SESSION['User_Permit_Access']) header("Location: " . $aplAplicationURL . "mantenimiento/cgiClose.php");
?>

<html>
<head>
	<title>:: NETLIFE ::</title>
	<script language="javascript" src="./../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
</head>
<body bgcolor="ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	//recupera los parametros del formulario
	$varUserUsua = trim($_POST["cboCodiPerf"]);
	$varFechDesd = $_POST["txtFechDesdAnio"]."-".$_POST["txtFechDesdMes"]."-".$_POST["txtFechDesdDia"]." 00:00:00";
	$varFechHast = $_POST["txtFechHastAnio"]."-".$_POST["txtFechHastMes"]."-".$_POST["txtFechHastDia"]." 23:59:59";

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_consulta where USR_USUARIO='$varUserUsua' and FEC_CONSULTA>='$varFechDesd' and FEC_CONSULTA<='$varFechHast'");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"95%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\">";
		print "\n<tr>";
		print "\n	<td width=\"25%\" bgcolor=\"$aplTituTableBackColor\" align=\"center\" class=\"titutabl\">Usuario</td>";		
		print "\n	<td width=\"25%\" bgcolor=\"$aplTituTableBackColor\" align=\"center\" class=\"titutabl\">Fecha</td>";		
		print "\n	<td width=\"25%\" bgcolor=\"$aplTituTableBackColor\" align=\"center\" class=\"titutabl\">Acción</td>";
		print "\n	<td width=\"25%\" bgcolor=\"$aplTituTableBackColor\" align=\"center\" class=\"titutabl\">Detalles</td>";		
		print "\n</tr>";

		// imprime los registros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varFechCons = trim($results["FEC_CONSULTA"][$varI]);
			$varSeccCons = trim($results["SEC_CONSULTA"][$varI]);
			$varTituCons = trim($results["TIT_CONSULTA"][$varI]);
			$varUserUsua = trim($results["USR_USUARIO"][$varI]);
			$varFechHora = explode(" ",$varFechCons);

			// despliego los datos
			print "<tr>";
			print "	<td width=\"25%\" class=\"texttabl\">&nbsp;&nbsp;$varUserUsua</td>";
			print "	<td width=\"25%\" class=\"texttabl\" align=\"center\">$varFechHora[0]&nbsp;<font color=\"#B70F49\">$varFechHora[1]</font></td>";
			print "	<td width=\"25%\" class=\"texttabl\">&nbsp;&nbsp;$varSeccCons</td>";			
			print "	<td width=\"25%\" class=\"texttabl\">&nbsp;&nbsp;$varTituCons</td>";			
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
		print "\n<table width=\"95%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"$aplFormTableBackColor\" style=\"border: 1px solid rgb($aplFormTableBorderColor)\">";
		print "<tr>";
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen registros de Logs</td>";
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