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
</head>
<body bgcolor="<?=$aplBackGroundColor;?>" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Recupero el Usuario
	$varUserUser = $_SESSION['User_User'];

	// Extrae los datos de la Forma o del URL
	$varComando = trim($_POST["cmdComando"]);
	if ($varComando == "")
	{
		$varComando = trim($_GET["cmdComando"]);
		$varCodiBann = trim($_GET["txtCodiBann"]);
	}
	else
	{
		$varCodiBann = trim($_POST["txtCodiBann"]);
		$varNombBann = convertir_especiales_html(trim($_POST["txtNombBann"]));
		$varEstaBann = trim($_POST["cboEstaBann"]);
		$varUrl_Bann = trim($_POST["txtUrl_Bann"]);

		$varFotoBann = str_replace("'","\'",trim($_POST["txtFotoBann"]));
		$varBannTemp = $_FILES['txtFotoBann']['tmp_name'];
		$varPathBann = $_FILES['txtFotoBann']['name'];
		$varTipoBann = $_FILES['txtFotoBann']['type'];
		$varSizeBann = $_FILES['txtFotoBann']['size'];
		$varExteBann = substr($varFotoBann,-3);	

		$varAltfBann = convertir_especiales_html(trim($_POST["txtAltfBann"]));
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		if (($varSizeBann <= $aplMaxiFileSize)&&($varSizeBann > 0))
		{
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_BANNER) as COD_BANNER from ".$aplPrefClie."_dat_banner");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiBann = $results["COD_BANNER"][0] + 1; else $varCodiBann = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_banner values ($varCodiBann,'$varNombBann','$varPathBann','$varAltfBann','$varUrl_Bann','$varEstaBann')");

			// cargo el archivo
			if (is_uploaded_file($varBannTemp)) copy($varBannTemp,$aplBannerPathArch.$varPathBann);

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Home - Banner','$varNombBann')");

			// mensaje de exito
			funLevantaAlert ('El registro fue INGRESADO exitosamente');
		}
		else
		{
			// mensaje de exito
			funLevantaAlert ('El archivo NO fue INGRESADO, su tamaño ha excedido el máximo permitido.');
		}
	}

	// Actualizar
	if ($varComando == "Actualizar")
	{
		// verifica el tamanio del archivo
	//	if ( ((($varSizeHome <= $aplMaxiFileSize)&&($varSizeHome > 0)) && (($varSizeLate <= $aplMaxiFileSize)&&($varSizeLate > 0))) || ($varSizeHome == 0 && $varSizeLate == 0) )
	//	{
			// actualizo el registro
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_banner set NOM_BANNER='$varNombBann', EST_BANNER='$varEstaBann', URL_BANNER='$varUrl_Bann', ALT_BANNER='$varAltfBann' where COD_BANNER=$varCodiBann");

			if ($varPathBann!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_banner set FOT_BANNER='$varPathBann' where COD_BANNER=$varCodiBann");
				// cargo el archivo
				if (is_uploaded_file($varBannTemp)) copy($varBannTemp,$aplBannerPathArch.$varPathBann);
			}

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Home - Banner','$varNombBann')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ACTUALIZADO exitosamente');
	//	}
	//	else
	//	{
	//		// mensaje de exito
	//		funLevantaAlert ('El archivo NO fue ACTUALIZADO, su tamaño ha excedido el máximo permitido.');
	//	}
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
			funLevantaAlert ("No puede Eliminar el registro.");
		}
		else
		{
			//obtiene el nombre del archivo que se va eliminar
			$recordset = funEjecutaQuerySelect("select NOM_BANNER from " . $aplPrefClie . "_dat_banner where COD_BANNER=$varCodiBann");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombBann = $results["NOM_BANNER"][0] ; else $varNombBann = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_banner where COD_BANNER=$varCodiBann");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Home - Banner','$varNombBann')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_banner order by COD_BANNER DESC");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiBann = trim($results["COD_BANNER"][$varI]);
			$varNombBann = trim($results["NOM_BANNER"][$varI]);
			$varEstaBann = trim($results["EST_BANNER"][$varI]);

			if ($varEstaBann == "A")
			{	
				$varEstaBannNomb = "(Activo)";
			}
			elseif ($varEstaBann == "I")
			{
				$varEstaBannNomb = "(Inactivo)";
			}

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_bann.php?txtCodiBann=$varCodiBann\" target=\"form\" class=\"linktabl\">$varNombBann</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaBannNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_bann.php?txtCodiBann=$varCodiBann&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Registro?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Home - Banner</td>";
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