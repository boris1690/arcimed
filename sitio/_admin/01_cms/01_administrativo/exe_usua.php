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
	<title><?=$aplNombApli;?></title>
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
		$varUserUsua = trim($_GET["txtUserUsua"]);
		$varOrde = trim($_GET["txtOrde"]);
		$varTipoOrde = trim($_GET["txtTipoOrde"]);
	}
	else
	{
		$varCodiPerf = trim($_POST["cboCodiPerf"]);
		$varNombUsua = strtoupper(trim($_POST["txtNombUsua"]));
		$varUserUsua = strtolower(trim($_POST["txtUserUsua"]));
		$varPassUsua = trim($_POST["txtPassUsua"]);
		$varLogeUsua = strtoupper(trim($_POST["cboLogeUsua"]));
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// seteo los permisos como habilitados
		$varPermUsua = true;

		// verifico si existe ya el username
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_ref_usuario where USR_USUARIO='$varUserUsua'");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varPermUsua = false;
		funLiberaRecordset ($recordset);

		// valido si se permitio el ingreso pasando la prueba de UserName repetido
		if ($varPermUsua == false)
		{
			// mensaje de error
			funLevantaAlert ($aplUserRepeErro);
		}
		else
		{
			// encripta la contraseña
			//$varPassUsuaEncr = base64_encode($varPassUsua);
			// ingreso el usuario
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_usuario values ($varCodiPerf,'$varUserUsua','$varPassUsua','$varNombUsua','$varLogeUsua')");
			
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into ".$aplPrefClie."_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Usuario','$varNombUsua')");
		}
	}

	// Actualizar
	if ($varComando == "Actualizar")
	{
		// Encripta Contraseña
		//$varPassUsuaEncr = base64_encode($varPassUsua);

        // actualizo el usuario
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_usuario set COD_PERFIL=$varCodiPerf, PAS_USUARIO='$varPassUsua', NOM_USUARIO='$varNombUsua', LOG_USUARIO='$varLogeUsua' where USR_USUARIO='$varUserUsua'");                 

		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		// ingresa los valores en la tabla de auditoria
		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Usuario','$varNombUsua')");
	}

	// Eliminar
	if ($varComando == "Eliminar")
	{
		// seteo los permisos como habilitados
		$varPermElim = true;

		// verifico datos relacionados
		//$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_cliente where USR_USUARIO='$varUserUsua' or USR_REGISTRO='$varUserUsua'");
		//$nr = funDevuelveArregloRecordset ($recordset,$results);
		//if ($nr>0) $varPermElim = false;
		//funLiberaRecordset ($recordset);

		// valido si se permitio la eliminacion pasando la prueba de registros relacionados
		if ($varPermElim == false)
		{
			// mensaje de error
			funLevantaAlert ("No se pudo Eliminar el Usuario.\\nExisten Registros relacionados en la Base de Datos.");
		}
		else
		{
			// obtiene el nombre del perfil que se va a eliminar
			$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_ref_usuario where USR_USUARIO='$varUserUsua'");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombUsua = $results["NOM_USUARIO"][0]; else $varNombUsua = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("DELETE from ".$aplPrefClie."_ref_usuario where USR_USUARIO='$varUserUsua'");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Usuario','$varNombUsua')");
		}
	}

	// Selecciona los registros
	if ($aplUsuaAdmi == "S")
		$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_usuario $varOrdeBy");
	else
		$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_usuario where USR_USUARIO<>'administrador' $varOrdeBy");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varUserUsua = trim($results["USR_USUARIO"][$varI]);
			$varNombUsua = trim($results["NOM_USUARIO"][$varI]);
			$varLogeUsua = trim($results["LOG_USUARIO"][$varI]);

			// despliego los datos			
			print "<tr>";
			if ($varLogeUsua == "S")
				print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_usua.php?txtUserUsua=$varUserUsua\" target=\"form\" style=\"color:#007700\" class=\"linktabl\">$varNombUsua</a></td>";
			else
				print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_usua.php?txtUserUsua=$varUserUsua\" target=\"form\" class=\"linktabl\">$varNombUsua</a></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_usua.php?txtUserUsua=$varUserUsua&cmdComando=Eliminar\" onClick=\"return confirm('$aplBorrUsuaMens');\" class=\"linktabl\"><img src=\"../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">$aplMensTablUsua</td>";
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