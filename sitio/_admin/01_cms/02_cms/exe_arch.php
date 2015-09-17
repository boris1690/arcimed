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
		$varCodiArch = trim($_GET["txtCodiArch"]);
	}
	else
	{
		$varCodiArch = trim($_POST["txtCodiArch"]);
		$varNombArch = str_replace("'","\'",trim($_POST["txtNombArch"]));
		$varArchTemp = $_FILES['txtArchArch']['tmp_name'];
		$varPathArch = $_FILES['txtArchArch']['name'];
		$varTipoArch = $_FILES['txtArchArch']['type'];
		$varSizeArch = $_FILES['txtArchArch']['size'];
		$varExteArch = substr($varArchNotaNomb,-3);	
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		if (($varSizeArch <= $aplMaxiFileSize)&&($varSizeArch > 0))
		{
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_ARCHIVO) as COD_ARCHIVO from ".$aplPrefClie."_dat_archivo");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiArch = $results["COD_ARCHIVO"][0] + 1; else $varCodiArch = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_archivo values ('$varUserUser',$varCodiArch,'$varNombArch','$varPathArch')");

			// cargo el archivo
			if (is_uploaded_file($varArchTemp)) copy($varArchTemp,$aplUploadPathArch.$varPathArch);
							
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','$aplIngrArch','$varNombArch')");

			// mensaje de exito
			funLevantaAlert ('El archivo fue INGRESADO exitosamente');
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
		if (($varSizeArch <= $aplMaxiFileSize)&&($varSizeArch > 0))
		{	
			// actualizo el registro
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_archivo set NOM_ARCHIVO='$varNombArch', FIL_ARCHIVO='$varPathArch' where COD_ARCHIVO=$varCodiArch");
				
			// cargo el archivo
			if (is_uploaded_file($varArchTemp)) copy($varArchTemp,$aplUploadPathArch.$varPathArch);

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','$aplActuArch','$varNombArch')");

			// mensaje de exito
			funLevantaAlert ('El archivo fue ACTUALIZADO exitosamente');
		}
		else
		{
			// mensaje de exito
			funLevantaAlert ('El archivo NO fue ACTUALIZADO, su tamaño ha excedido el máximo permitido.');
		}
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
			funLevantaAlert ("File can't be deleted");
		}
		else
		{
			//obtiene el nombre del archivo que se va eliminar
			$recordset = funEjecutaQuerySelect("select NOM_ARCHIVO from " . $aplPrefClie . "_dat_archivo where COD_ARCHIVO =$varCodiArch");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombArch = $results["NOM_ARCHIVO"][0] ; else $varNombArch = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_archivo where COD_ARCHIVO=$varCodiArch");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','$aplBorrArch','$varNombArch')");

			// mensaje de exito
			funLevantaAlert ('El archivo fue ELIMINADO exitosamente');
		}
	}

	// Listar
	if ($varComando == "Listar")
	{
		$varRegiInic =  trim($_POST["txtRegiInic"]);
		$varRegiFina =  trim($_POST["txtRegiFina"]);
	}
	else
	{
		// inicializa las variables
		$varRegiInic = 1;
		$varRegiFina = $aplNumeRegiPagi;

		$recordset = funEjecutaQuerySelect ("select COD_ARCHIVO from " . $aplPrefClie . "_dat_archivo");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if($nr>0)
		{
			if($nr<$aplNumeRegiPagi) $varRegiFina = $nr;
		}
		else
		{
			$varRegiInic = 0;
			$varRegiFina = 0;
		}
		funLiberaRecordset ($recordset);
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_archivo order by NOM_ARCHIVO");
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

			// control de paginacion
			if (($varI+1>=$varRegiInic) && ($varI+1<=$varRegiFina))
			{
				// despliego los datos
				print "<tr>";
				print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_arch.php?txtCodiArch=$varCodiArch\" target=\"form\" class=\"linktabl\">$varNombArch</a><br><font style=\"color:#ca6500\">../../_upload/$varFileArch</font></td>";
				print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_arch.php?txtCodiArch=$varCodiArch&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Archivo?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
				print "</tr>";
			}
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
<br><br>

<!-- verifico si debe limpiar el formulario -->
<? if ($varComando != "") { ?>
	<script language="JavaScript">
	<!--
		parent.frames[0].funLimpiaDatos();
		parent.frames[1].location.reload(true);
	-->
	</script>
<? } ?>

</body>
</html>