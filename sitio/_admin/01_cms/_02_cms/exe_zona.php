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

	// verifico si la sesion de usuario esta activa y si no lo est� redirecciono al fin
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
		$varCodiZona = trim($_GET["txtCodiZona"]);
	}
	else
	{
		$varCodiZona = trim($_POST["txtCodiZona"]);
		$varNombZona = convertir_especiales_html(trim($_POST["txtNombZona"]));
		$varVideZona = trim($_POST["txtVideZona"]);
		$varEstaZona = trim($_POST["cboEstaZona"]);
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_ZONA) as COD_ZONA from ".$aplPrefClie."_dat_zonakfc");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiZona = $results["COD_ZONA"][0] + 1; else $varCodiZona = 1;
		funLiberaRecordset ($recordset);

		// ingreso el registro
		$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_zonakfc values ($varCodiZona,'$varNombZona','$varVideZona','$varEstaZona')");

		// inactivo todos los anteriores si este ingresa activo
		if ($varEstaZona == "A")
		{
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_zonakfc set EST_ZONA='I' where COD_ZONA<>$varCodiZona");
		}
						
		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		// ingresa los valores en la tabla de auditoria
		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Zona KFC','$varNombZona')");

		// mensaje de exito
		funLevantaAlert ('El registro fue INGRESADO exitosamente');
	}

	// Actualizar
	if ($varComando == "Actualizar")
	{

		// actualizo el registro
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_zonakfc set NOM_ZONA='$varNombZona', VID_ZONA='$varVideZona', EST_ZONA='$varEstaZona' where COD_ZONA=$varCodiZona");
			

		// inactivo todos los anteriores si este ingresa activo
		if ($varEstaZona == "A")
		{
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_zonakfc set EST_ZONA='I' where COD_ZONA<>$varCodiZona");
		}

		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		// ingresa los valores en la tabla de auditoria
		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Zona FKC','$varNombZona')");

		// mensaje de exito
		funLevantaAlert ('El registro fue ACTUALIZADO exitosamente');
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
			$recordset = funEjecutaQuerySelect("select NOM_ZONA from " . $aplPrefClie . "_dat_zonakfc where COD_ZONA=$varCodiZona");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombZona = $results["NOM_ZONA"][0] ; else $varNombZona = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_zonakfc where COD_ZONA=$varCodiZona");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Zona KFC','$varNombZona')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_zonakfc order by NOM_ZONA");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";


		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiZona = trim($results["COD_ZONA"][$varI]);
			$varNombZona = trim($results["NOM_ZONA"][$varI]);
			$varEstaZona = trim($results["EST_ZONA"][$varI]);

			if ($varEstaZona == "A")
			{	
				$varEstaZonaNomb = "(Activo)";
			}
			elseif ($varEstaZona == "I")
			{
				$varEstaZonaNomb = "(Inactivo)";
			}

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\"><a href=\"./frm_zona.php?txtCodiZona=$varCodiZona\" target=\"form\" class=\"linktabl\">$varNombZona</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaZonaNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_zona.php?txtCodiZona=$varCodiZona&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Registro?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Zonas KFC</td>";
		print "</tr>";
		print "</table>";
	}
	funLiberaRecordset ($recordset);
    
	// Cierro la conexi�n
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