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
		$varCodiHome = trim($_GET["txtCodiHome"]);
	}
	else
	{
		$varCodiHome = trim($_POST["txtCodiHome"]);
		$varTituHome = convertir_especiales_html(trim($_POST["txtTituHome"]));
		$varPosiHome = trim($_POST["cboPosiHome"]);
		$varTextHome = convertir_especiales_html(trim($_POST["txtTextHome"]));
		$varEstaHome = trim($_POST["cboEstaHome"]);
		$varUrlHome = trim($_POST["txtUrlHome"]);

		$varFotoHome = str_replace("'","\'",trim($_POST["txtFotoHome"]));
		$varHomeTemp = $_FILES['txtFotoHome']['tmp_name'];
		$varPathHome = $_FILES['txtFotoHome']['name'];
		$varTipoHome = $_FILES['txtFotoHome']['type'];
		$varSizeHome = $_FILES['txtFotoHome']['size'];
		$varExteHome = substr($varFotoHome,-3);	

		$varFotoLate = str_replace("'","\'",trim($_POST["txtFotoLate"]));
		$varLateTemp = $_FILES['txtFotoLate']['tmp_name'];
		$varPathLate = $_FILES['txtFotoLate']['name'];
		$varTipoLate = $_FILES['txtFotoLate']['type'];
		$varSizeLate = $_FILES['txtFotoLate']['size'];
		$varExteLate = substr($varFotoLate,-3);	

		$varAlthHome = convertir_especiales_html(trim($_POST["txtAlthHome"]));
		$varAltlHome = convertir_especiales_html(trim($_POST["txtAltlHome"]));
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		if ((($varSizeHome <= $aplMaxiFileSize)&&($varSizeHome > 0)) && ($varSizeLate <= $aplMaxiFileSize)&&($varSizeLate > 0))
		{
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_HOME) as COD_HOME from ".$aplPrefClie."_dat_home");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiHome = $results["COD_HOME"][0] + 1; else $varCodiHome = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_home values ($varCodiHome,'$varTituHome','$varPathHome','$varAlthHome','$varPathLate','$varAltlHome','$varPosiHome','$varTextHome','$varUrlHome','$varEstaHome')");

			// cargo el archivo
			if (is_uploaded_file($varHomeTemp)) copy($varHomeTemp,$aplUploadPathArch.$varPathHome);
			if (is_uploaded_file($varLateTemp)) copy($varLateTemp,$aplUploadPathArch.$varPathLate);

			// inactivo todos los anteriores si este ingresa activo
			if ($varEstaHome == "A")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_home set EST_HOME='I' where COD_HOME<>$varCodiHome and POS_HOME='$varPosiHome'");
			}
							
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Home - Lateral','$varTituHome')");

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
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_home set TIT_HOME='$varTituHome', POS_HOME='$varPosiHome', TEX_HOME='$varTextHome', EST_HOME='$varEstaHome', URL_HOME='$varUrlHome', ALT_HOMEHOME='$varAlthHome', ALT_LATEHOME='$varAltlHome' where COD_HOME=$varCodiHome");

			if ($varPathHome!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_home set FOT_HOMEHOME='$varPathHome' where COD_HOME=$varCodiHome");
				// cargo el archivo
				if (is_uploaded_file($varHomeTemp)) copy($varHomeTemp,$aplUploadPathArch.$varPathHome);
			}

			if ($varPathLate!="")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_home set FOT_LATEHOME='$varPathLate' where COD_HOME=$varCodiHome");
				// cargo el archivo
				if (is_uploaded_file($varLateTemp)) copy($varLateTemp,$aplUploadPathArch.$varPathLate);
			}
			
			// inactivo todos los anteriores si este ingresa activo
			if ($varEstaHome == "A")
			{
				$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_home set EST_HOME='I' where COD_HOME<>$varCodiHome and POS_HOME='$varPosiHome'");
			}

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Home - Lateral','$varTituHome')");

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
			$recordset = funEjecutaQuerySelect("select TIT_HOME from " . $aplPrefClie . "_dat_home where COD_HOME=$varCodiHome");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varTituHome = $results["TIT_HOME"][0] ; else $varTituHome = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_home where COD_HOME=$varCodiHome");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Home - Lateral','$varTituHome')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_home order by POS_HOME, TIT_HOME");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// valiable auxiliar
		$varPosiHomeAux = "X";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiHome = trim($results["COD_HOME"][$varI]);
			$varTituHome = trim($results["TIT_HOME"][$varI]);
			$varEstaHome = trim($results["EST_HOME"][$varI]);
			$varPosiHome = trim($results["POS_HOME"][$varI]);

			if ($varEstaHome == "A")
			{	
				$varEstaHomeNomb = "(Activo)";
			}
			elseif ($varEstaHome == "I")
			{
				$varEstaHomeNomb = "(Inactivo)";
			}

			// despliego el titulo de la posicin
			if ($varPosiHomeAux != $varPosiHome)
			{
				if ($varPosiHome == "1")
				{
					$varPosiHomeNomb = "Izquierda - Arriba";
				}
				elseif ($varPosiHome == "2")
				{
					$varPosiHomeNomb = "Medio - Centro";
				}
				elseif ($varPosiHome == "3")
				{
					$varPosiHomeNomb = "Derecha - Abajo";
				}

				print "<tr>";
				print "	<td colspan=2 class=\"texttabl\" bgcolor=\"$aplTigraBackColorOver\"><font style=\"color:#ca6500\">$varPosiHomeNomb</font></td>";
				print "</tr>";
				$varPosiHomeAux = $varPosiHome;
			}


			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_home.php?txtCodiHome=$varCodiHome\" target=\"form\" class=\"linktabl\">$varTituHome</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaHomeNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_home.php?txtCodiHome=$varCodiHome&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Registro?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Home - Lateral</td>";
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