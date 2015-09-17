<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../../_funciones/parametros.php";	
	require "./../../_funciones/funciones.php";
	require "./../../_funciones/database_$aplDataBaseLibrary.php";

?>

<html>
<head>
	<title>.: Arcimed :.</title>
	<script language="javascript" src="./../../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../../_funciones/style.css" type="text/css">
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
		$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_categoria values ($varCodiCate,'$varNombCate','$varEstaCate',$varOrdCate)");

		// mensaje de exito
		funLevantaAlert ('El registro fue INGRESADO exitosamente');
	}

	// Actualizar
	if ($varComando == "Actualizar")
	{
		// actualizo el registro
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_categoria set NOM_CATEGORIA='$varNombCate', EST_CATEGORIA='$varEstaCate',ORD_CATEGORIA=$varOrdCate where COD_CATEGORIA=$varCodiCate");

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
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_categoria where COD_CATEGORIA=$varCodiCate");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}
	
	$varJ = 0;
	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_categoria");
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

			if ($varEstaCate == "A")
			{	
				$varEstaCateNomb = "(Activo)";
			}
			elseif ($varEstaCate == "I")
			{
				$varEstaCateNomb = "(Inactivo)";
			}
			
			
			
				// despliego los datos
				print "<tr>";
				print "	<td width=\"97%\" class=\"texttabl\" style=\"padding-left:15px;\"><a href=\"./frm_cate.php?txtCodiCate=$varCodiCate\" target=\"ejec\" class=\"linktabl\">$varNombCate</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaCateNomb</i></font></td>";
				print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_cate.php?txtCodiCate=$varCodiCate&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar la Categoria?');\" class=\"linktabl\"><img src=\"./../../_imagenes/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
				print "</tr>";
			
		}
		

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
	print "<br>";		
	print "\n<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"$aplFormTableBackColor\" style=\"border: 1px solid rgb($aplFormTableBorderColor)\">";
	print "<tr>";
	print "	<td class=\"message\" bgcolor=\"#f9f9f9\"><a href=\"./frm_cate.php\" class=\"texttabl\"><img src=\"./../../_imagenes/add-icon.png\" width=\"15px\"/></a></td>";
	print "</tr>";

	// cierra la tabla
	print "</table>";
	
	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();
?>

</center>
<br><br>



</body>
</html>