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
		$varCodiRest = trim($_GET["txtCodiRest"]);
	}
	else
	{
		$varCodiRest = trim($_POST["txtCodiRest"]);
		$varCodiCiud = trim($_POST["cboCodiCiud"]);
		$varNombRest = convertir_especiales_html(trim($_POST["txtNombRest"]));
		$varDireRest = convertir_especiales_html(trim($_POST["txtDireRest"]));
		$varTeleRest = trim($_POST["txtTeleRest"]);
		$varSaloRest = trim($_POST["chkSaloRest"]);
		$varAutoRest = trim($_POST["chkAutoRest"]);
		$varDomiRest = trim($_POST["chkDomiRest"]);
		$varHelaRest = trim($_POST["chkHelaRest"]);
		$varChicRest = trim($_POST["chkChicRest"]);
		$varEstaRest = trim($_POST["cboEstaRest"]);

		$varAltfRest = convertir_especiales_html(trim($_POST["txtAltfRest"]));
		$varAltpMapa = convertir_especiales_html(trim($_POST["txtAltpMapa"]));
		$varAltgMapa = convertir_especiales_html(trim($_POST["txtAltgMapa"]));

		$varFotoRest = str_replace("'","\'",trim($_POST["txtFotoRest"]));
		$varRestTemp = $_FILES['txtFotoRest']['tmp_name'];
		$varPathRest = $_FILES['txtFotoRest']['name'];
		$varTipoRest = $_FILES['txtFotoRest']['type'];
		$varSizeRest = $_FILES['txtFotoRest']['size'];
		$varExteRest = substr($varFotoRest,-3);	

		$varFotpMapa = str_replace("'","\'",trim($_POST["txtFotpMapa"]));
		$varFotpTemp = $_FILES['txtFotpMapa']['tmp_name'];
		$varPathFotp = $_FILES['txtFotpMapa']['name'];
		$varTipoFotp = $_FILES['txtFotpMapa']['type'];
		$varSizeFotp = $_FILES['txtFotpMapa']['size'];
		$varExteFotp = substr($varFotpMapa,-3);	

		$varFotgMapa = str_replace("'","\'",trim($_POST["txtFotgMapa"]));
		$varFotgTemp = $_FILES['txtFotgMapa']['tmp_name'];
		$varPathFotg = $_FILES['txtFotgMapa']['name'];
		$varTipoFotg = $_FILES['txtFotgMapa']['type'];
		$varSizeFotg = $_FILES['txtFotgMapa']['size'];
		$varExteFotg = substr($varFotgMapa,-3);	

	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		if ( ($varSizeRest <= $aplMaxiFileSize)&&($varSizeRest > 0) )
		{
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_RESTAURANTE) as COD_RESTAURANTE from ".$aplPrefClie."_dat_restaurante");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiRest = $results["COD_RESTAURANTE"][0] + 1; else $varCodiRest = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_restaurante values ($varCodiCiud,$varCodiRest,'$varNombRest','$varDireRest','$varTeleRest','$varSaloRest','$varAutoRest','$varDomiRest','$varHelaRest','$varChicRest','$varPathRest','$varPathFotp','$varPathFotg','$varAltfRest','$varAltpMapa','$varAltgMapa','$varEstaRest')");

			// cargo el archivo
			if (is_uploaded_file($varRestTemp)) copy($varRestTemp,$aplUploadPathArch.$varPathRest);

			if ($varPathFotp!="")
			{
				if (is_uploaded_file($varFotpTemp)) copy($varFotpTemp,$aplUploadPathArch.$varPathFotp);
			}

			if ($varPathFotg!="")
			{
				if (is_uploaded_file($varFotgTemp)) copy($varFotgTemp,$aplUploadPathArch.$varPathFotg);
			}

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Restaurante','$varNombRest')");

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
		//if ( ($varSizeRest <= $aplMaxiFileSize)&&($varSizeRest > 0) )
		//{

			// actualizo el registro
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_restaurante set COD_CIUDAD=$varCodiCiud, NOM_RESTAURANTE='$varNombRest', DIR_RESTAURANTE='$varDireRest', TEL_RESTAURANTE='$varTeleRest', TIE_SALORESTAURANTE='$varSaloRest', TIE_AUTORESTAURANTE='$varAutoRest', TIE_DOMIRESTAURANTE='$varDomiRest', TIE_HELARESTAURANTE='$varHelaRest', TIE_CHICRESTAURANTE='$varChicRest', EST_RESTAURANTE='$varEstaRest', ALT_RESTAURANTE='$varAltfRest', ALT_PEQUMAPA='$varAltpMapa', ALT_GRANMAPA='$varAltgMapa' where COD_RESTAURANTE=$varCodiRest");
				
			// cargo el archivo
			if ($varPathRest!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_restaurante set FOT_RESTAURANTE='$varPathRest' where COD_RESTAURANTE=$varCodiRest");
				if (is_uploaded_file($varRestTemp)) copy($varRestTemp,$aplUploadPathArch.$varPathRest);
			}
			if ($varPathFotp!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_restaurante set FOT_PEQUMAPA='$varPathFotp' where COD_RESTAURANTE=$varCodiRest");
				if (is_uploaded_file($varFotpTemp)) copy($varFotpTemp,$aplUploadPathArch.$varPathFotp);
			}

			if ($varPathFotg!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_restaurante set FOT_GRANMAPA='$varPathFotg' where COD_RESTAURANTE=$varCodiRest");
				if (is_uploaded_file($varFotgTemp)) copy($varFotgTemp,$aplUploadPathArch.$varPathFotg);
			}			

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Restaurante','$varNombRest')");

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
			$recordset = funEjecutaQuerySelect("select NOM_RESTAURANTE from " . $aplPrefClie . "_dat_restaurante where COD_RESTAURANTE=$varCodiRest");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombRest = $results["NOM_RESTAURANTE"][0] ; else $varNombRest = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_restaurante where COD_RESTAURANTE=$varCodiRest");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Restaurante','$varNombRest')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select A.*, B.NOM_CIUDAD from " . $aplPrefClie . "_dat_restaurante A, " . $aplPrefClie . "_ref_ciudad B where B.COD_CIUDAD=A.COD_CIUDAD order by B.NOM_CIUDAD, A.NOM_RESTAURANTE");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// valiable auxiliar
		$varNombCiudAux = "XX";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiRest = trim($results["COD_RESTAURANTE"][$varI]);
			$varNombRest = trim($results["NOM_RESTAURANTE"][$varI]);
			$varEstaRest = trim($results["EST_RESTAURANTE"][$varI]);
			$varNombCiud = trim($results["NOM_CIUDAD"][$varI]);

			if ($varEstaRest == "A")
			{	
				$varEstaRestNomb = "(Activo)";
			}
			elseif ($varEstaRest == "I")
			{
				$varEstaRestNomb = "(Inactivo)";
			}

			// despliego el titulo de la posicin
			if ($varNombCiudAux != $varNombCiud)
			{
				print "<tr>";
				print "	<td colspan=2 class=\"texttabl\" bgcolor=\"$aplTigraBackColorOver\"><font style=\"color:#ca6500\">$varNombCiud</font></td>";
				print "</tr>";
				$varNombCiudAux = $varNombCiud;
			}

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\"  style=\"padding-left:15px;\"><a href=\"./frm_rest.php?txtCodiRest=$varCodiRest\" target=\"form\" class=\"linktabl\">$varNombRest</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaRestNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_rest.php?txtCodiRest=$varCodiRest&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Registro?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Restaurantes</td>";
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