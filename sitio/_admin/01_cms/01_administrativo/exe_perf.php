<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "../_funciones/parametros.php";
	require "../_funciones/secure.php";
	require "../_funciones/funciones.php";
	require "../_funciones/database_$aplDataBaseLibrary.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();

	// verifico si la sesion de usuario esta activa y si no lo está redirecciono al fin
	if (!$_SESSION['User_Permit_Access']) header("Location: " . $aplAplicationURL . "mantenimiento/cgiClose.php");
?>

<html>
<head>
	<title>.: KFC :.</title>
	<script language="javascript" src="../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="../_funciones/style.css" type="text/css">
</head>
<body bgcolor="<?=$aplBackGroundColor;?>" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Extrae los datos de la Forma o del URL
	$varComando = trim($_POST["cmdComando"]);
	if ($varComando == "")
	{
		$varComando = trim($_GET["cmdComando"]);
		$varCodiPerf = trim($_GET["txtCodiPerf"]);
	}
	else
	{
		$varCodiPerf = trim($_POST["txtCodiPerf"]);
		$varNombPerf = strtoupper(trim($_POST["txtNombPerf"]));
		$varListCodiOpci = trim($_POST["txtListCodiOpci"]);
		$varListCodiSecc = trim($_POST["txtListCodiSecc"]);
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_PERFIL) as COD_PERFIL from ".$aplPrefClie."_ref_perfil");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiPerf = $results["COD_PERFIL"][0] + 1; else $varCodiPerf = 1;
		funLiberaRecordset ($recordset);

		// ingresa el registro
		$recordset = funEjecutaQueryEdit ("insert into ".$aplPrefClie."_ref_perfil values ($varCodiPerf,'$varNombPerf')");

		// ingresa las opciones de los modulos
		$varPosiInic = 0;
		$varDim = strlen($varListCodiOpci);
		while ($varPosiInic<$varDim)
		{	
			// calculo las posiciones finales
			$varPosiFina = strpos($varListCodiOpci,",",$varPosiInic);

			// extraigo los valores de los arreglos
			$varCodiOpci = strtoupper(substr($varListCodiOpci,$varPosiInic,($varPosiFina-$varPosiInic)));

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into ".$aplPrefClie."_rel_perfilopcionsistema values ($varCodiPerf,$varCodiOpci,'E')");

			// recorro las posiciones iniciales
			$varPosiInic = $varPosiFina + 1;
		}

		// ingresa las secciones
		$varPosiInic = 0;
		$varDim = strlen($varListCodiSecc);
		while ($varPosiInic<$varDim)
		{	
			// calculo las posiciones finales
			$varPosiFina = strpos($varListCodiSecc,",",$varPosiInic);

			// extraigo los valores de los arreglos
			$varCodiSecc = strtoupper(substr($varListCodiSecc,$varPosiInic,($varPosiFina-$varPosiInic)));

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_rel_perfilinfoseccion values ($varCodiPerf,$varCodiSecc)");

			// recorro las posiciones iniciales
			$varPosiInic = $varPosiFina + 1;
		}

		// ingresa los valores en la tabla de auditoria
		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into ".$aplPrefClie."_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Perfil','$varNombPerf')");
	}

	// Actualizar
	if ($varComando == "Actualizar")
	{
		// actualizo el registro
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_perfil set NOM_PERFIL='$varNombPerf' where COD_PERFIL=$varCodiPerf");
		
		// elimino las opciones de los modulos y de secciones
		$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_rel_perfilopcionsistema where COD_PERFIL=$varCodiPerf");
		$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_rel_perfilinfoseccion where COD_PERFIL=$varCodiPerf");

		// ingresa las opciones de los modulos
		$varPosiInic = 0;
		$varDim = strlen($varListCodiOpci);
		while ($varPosiInic<$varDim)
		{	
			// calculo las posiciones finales
			$varPosiFina = strpos($varListCodiOpci,",",$varPosiInic);

			// extraigo los valores de los arreglos
			$varCodiOpci = strtoupper(substr($varListCodiOpci,$varPosiInic,($varPosiFina-$varPosiInic)));

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into ".$aplPrefClie."_rel_perfilopcionsistema values ($varCodiPerf,$varCodiOpci,'E')");

			// recorro las posiciones iniciales
			$varPosiInic = $varPosiFina + 1;
		}

		// ingresa las secciones
		$varPosiInic = 0;
		$varDim = strlen($varListCodiSecc);
		while ($varPosiInic<$varDim)
		{	
			// calculo las posiciones finales
			$varPosiFina = strpos($varListCodiSecc,",",$varPosiInic);

			// extraigo los valores de los arreglos
			$varCodiSecc = strtoupper(substr($varListCodiSecc,$varPosiInic,($varPosiFina-$varPosiInic)));

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_rel_perfilinfoseccion values ($varCodiPerf,$varCodiSecc)");

			// recorro las posiciones iniciales
			$varPosiInic = $varPosiFina + 1;
		}

		// ingresa los valores en la tabla de auditoria
		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into ".$aplPrefClie."_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Perfil','$varNombPerf')");
	}

	// Eliminar
	if ($varComando == "Eliminar")
	{
		// seteo los permisos como habilitados
		$varPermElim = true;

		// valido si se permitio la eliminacion pasando la prueba de registros relacionados
		if ($varPermElim == false)
		{
			// mensaje de error
			funLevantaAlert ('$aplBorrPerfErro');
		}
		else
		{
			// obtiene el nombre del perfil que se va a eliminar
			$recordset = funEjecutaQuerySelect ("select * from  ".$aplPrefClie."_ref_perfil where COD_PERFIL=$varCodiPerf");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombPerf = $results["NOM_PERFIL"][0]; else $varNombPerf = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_rel_perfilopcionsistema where COD_PERFIL=$varCodiPerf");
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_rel_perfilinfoseccion where COD_PERFIL=$varCodiPerf");
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_ref_perfil where COD_PERFIL=$varCodiPerf");

			// ingresa los valores en la tabla de auditoria
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from  ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into  ".$aplPrefClie."_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Perfil','$varNombPerf')");
		}
	}

	// Selecciona los registros
	if ($aplUsuaAdmi == "S")
		$recordset = funEjecutaQuerySelect ("select * from  ".$aplPrefClie."_ref_perfil $varOrdeBy");
	else
		$recordset = funEjecutaQuerySelect ("select * from  ".$aplPrefClie."_ref_perfil where COD_PERFIL<>0 $varOrdeBy");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiPerf = trim($results["COD_PERFIL"][$varI]);
			$varNombPerf = trim($results["NOM_PERFIL"][$varI]);

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_perf.php?txtCodiPerf=$varCodiPerf\" target=\"form\" class=\"linktabl\">$varNombPerf</a></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_perf.php?txtCodiPerf=$varCodiPerf&cmdComando=Eliminar\" onClick=\"return confirm('$aplMensBorrPerf');\" class=\"linktabl\"><img src=\"../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">$aplMensTablPerf</td>";
		print "</tr>";
		print "</table>";
	}
	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();
?>

</center>
<br><br>

<!-- verifico si debe limpiar el formulario -->
<? if ($varComando != "") { ?>
	<script language="JavaScript">
	<!--
		parent.frames[0].funLimpiaDatos();
	-->
	</script>
<? } ?>

</body>
</html>