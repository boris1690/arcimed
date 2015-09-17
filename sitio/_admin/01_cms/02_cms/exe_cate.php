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
		$varCodiCate = trim($_GET["txtCodiCate"]);
	}
	else
	{
		$varCodiCate = trim($_POST["txtCodiCate"]);
		$varNombCate = convertir_especiales_html(trim($_POST["txtNombCate"]));
		$varEstaCate = trim($_POST["cboEstaCate"]);
		$varCiudCate = trim($_POST["cboCiudCate"]);
		$varOrdCate = trim($_POST["txtOrdCate"]);
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CATEGORIA) as COD_CATEGORIA from ".$aplPrefClie."_dat_categoria");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCate = $results["COD_CATEGORIA"][0] + 1; else $varCodiCate = 1;
		funLiberaRecordset ($recordset);

		// ingreso el registro
		$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_categoria values ($varCodiCate,'$varNombCate','$varEstaCate',$varCiudCate,$varOrdCate)");

		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		// ingresa los valores en la tabla de auditoria
		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Categoria','$varNombCate')");

		// mensaje de exito
		funLevantaAlert ('El registro fue INGRESADO exitosamente');
	}

	// Actualizar
	if ($varComando == "Actualizar")
	{
		// actualizo el registro
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_categoria set NOM_CATEGORIA='$varNombCate', EST_CATEGORIA='$varEstaCate',COD_CIUDAD=$varCiudCate ,ORD_CATEGORIA=$varOrdCate where COD_CATEGORIA=$varCodiCate");

		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		// ingresa los valores en la tabla de auditoria
		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Categoria','$varNombCate')");

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
			$recordset = funEjecutaQuerySelect("select NOM_CATEGORIA from " . $aplPrefClie . "_dat_categoria where COD_CATEGORIA=$varCodiCate");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombCate = $results["NOM_CATEGORIA"][0] ; else $varNombCate = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_categoria where COD_CATEGORIA=$varCodiCate");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Categoria','$varNombCate')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}
	
	$varJ = 0;
	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_categoria order by COD_CIUDAD");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiCate = trim($results["COD_CATEGORIA"][$varI]);
			$varNombCate = trim($results["NOM_CATEGORIA"][$varI]);
			$varEstaCate = trim($results["EST_CATEGORIA"][$varI]);
			$varCiudCate = trim($results["COD_CIUDAD"][$varI]);

			if ($varEstaCate == "A")
			{	
				$varEstaCateNomb = "(Activo)";
			}
			elseif ($varEstaCate == "I")
			{
				$varEstaCateNomb = "(Inactivo)";
			}
			
			if($varJ != $varCiudCate)
			{
				$recordset1 = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_ciudad where COD_CIUDAD=$varCiudCate");
				$nr1 = funDevuelveArregloRecordset ($recordset1,$results1);
				if ($nr1>0)
				{
					print "<tr>";
					print "	<td colspan=\"2\" class=\"texttabl\" bgcolor=\"$aplTigraBackColorOver\"><font style=\"color:#ca6500\">". $results1['NOM_CIUDAD'][0] ."</font></td>";
					print "<tr>";
				}
				$varJ = $varCiudCate;
			}
			
				// despliego los datos
				print "<tr>";
				print "	<td width=\"97%\" class=\"texttabl\" style=\"padding-left:15px;\"><a href=\"./frm_cate.php?txtCodiCate=$varCodiCate\" target=\"form\" class=\"linktabl\">$varNombCate</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaCateNomb</i></font></td>";
				print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_cate.php?txtCodiCate=$varCodiCate&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar la Categoria?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Categorias</td>";
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