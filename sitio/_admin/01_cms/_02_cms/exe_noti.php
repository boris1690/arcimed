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
		$varCodiNoti = trim($_GET["txtCodiNoti"]);
	}
	else
	{
		$varCodiNoti = trim($_POST["txtCodiNoti"]);

		$varTituNoti = convertir_especiales_html(trim($_POST["txtTituNoti"]));
		$varTextNoti = convertir_especiales_html(trim($_POST["txtTextNoti"]));
		$varExtrNoti = convertir_especiales_html(trim($_POST["txtExtrNoti"]));
		$varEstaNoti = trim($_POST["cboEstaNoti"]);

		$varFotoPequ = str_replace("'","\'",trim($_POST["txtFotoPequ"]));
		$varPequTemp = $_FILES['txtFotoPequ']['tmp_name'];
		$varPathPequ = $_FILES['txtFotoPequ']['name'];
		$varTipoPequ = $_FILES['txtFotoPequ']['type'];
		$varSizePequ = $_FILES['txtFotoPequ']['size'];
		$varExtePequ = substr($varFotoPequ,-3);	

		$varFotoGran = str_replace("'","\'",trim($_POST["txtFotoGran"]));
		$varGranTemp = $_FILES['txtFotoGran']['tmp_name'];
		$varPathGran = $_FILES['txtFotoGran']['name'];
		$varTipoGran = $_FILES['txtFotoGran']['type'];
		$varSizeGran = $_FILES['txtFotoGran']['size'];
		$varExteGran = substr($varFotoGran,-3);	

		$varAltfPequ = convertir_especiales_html(trim($_POST["txtAltfPequ"]));
		$varAltfGran = convertir_especiales_html(trim($_POST["txtAltfGran"]));
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		if ((($varSizePequ <= $aplMaxiFileSize)&&($varSizePequ > 0)) && (($varSizeGran <= $aplMaxiFileSize)&&($varSizeGran > 0)))
		{
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_NOTICIA) as COD_NOTICIA from ".$aplPrefClie."_dat_noticia");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiNoti = $results["COD_NOTICIA"][0] + 1; else $varCodiNoti = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_noticia values ($varCodiNoti,'$varTituNoti','$varExtrNoti','$varTextNoti','$varPathPequ','$varPathGran','$varAltfPequ','$varAltfGran','$varEstaNoti')");

			// cargo el archivo
			if (is_uploaded_file($varPequTemp)) copy($varPequTemp,$aplUploadPathArch.$varPathPequ);
			if (is_uploaded_file($varGranTemp)) copy($varGranTemp,$aplUploadPathArch.$varPathGran);

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Noticia','$varTituNoti')");

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
		//if ((($varSizePequ <= $aplMaxiFileSize)&&($varSizePequ > 0)) && ($varSizeGran <= $aplMaxiFileSize)&&($varSizeGran > 0))
		//{

			// actualizo el registro
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_noticia set TIT_NOTICIA='$varTituNoti', ALT_PEQUNOTICIA='$varAltfPequ', ALT_GRANNOTICIA='$varAltfGran', TEX_NOTICIA='$varTextNoti', PUB_NOTICIA='$varEstaNoti', EST_NOTICIA='$varExtrNoti' where COD_NOTICIA=$varCodiNoti");


			if ($varPathPequ!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_noticia set FOT_PEQUNOTICIA='$varPathPequ' where COD_NOTICIA=$varCodiNoti");
				// cargo el archivo
				if (is_uploaded_file($varPequTemp)) copy($varPequTemp,$aplUploadPathArch.$varPathPequ);
			}

			if ($varPathGran!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_noticia set FOT_GRANNOTICIA='$varPathGran' where COD_NOTICIA=$varCodiNoti");
				// cargo el archivo
				if (is_uploaded_file($varGranTemp)) copy($varGranTemp,$aplUploadPathArch.$varPathGran);
			}
				

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Noticia','$varTituNoti')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ACTUALIZADO exitosamente');
		//}
		//else
		//{
		//	// mensaje de exito
		//	funLevantaAlert ('El archivo NO fue ACTUALIZADO, su tamaño ha excedido el máximo permitido.');
		//}
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
			$recordset = funEjecutaQuerySelect("select TIT_NOTICIA from " . $aplPrefClie . "_dat_noticia where COD_NOTICIA=$varCodiNoti");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varTituNoti = $results["TIT_NOTICIA"][0] ; else $varTituNoti = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_noticia where COD_NOTICIA=$varCodiNoti");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Noticia','$varTituNoti')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_noticia order by COD_NOTICIA DESC");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiNoti = trim($results["COD_NOTICIA"][$varI]);
			$varTituNoti = trim($results["TIT_NOTICIA"][$varI]);
			$varEstaNoti = trim($results["PUB_NOTICIA"][$varI]);

			if ($varEstaNoti == "A")
			{	
				$varEstaNotiNomb = "(Activo)";
			}
			elseif ($varEstaNoti == "I")
			{
				$varEstaNotiNomb = "(Inactivo)";
			}

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_noti.php?txtCodiNoti=$varCodiNoti\" target=\"form\" class=\"linktabl\">$varTituNoti</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaNotiNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_noti.php?txtCodiNoti=$varCodiNoti&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar la Noticia?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Noticias</td>";
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