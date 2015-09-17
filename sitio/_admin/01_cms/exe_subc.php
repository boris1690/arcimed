<?
	// abre y mantiene la sesion
	session_start();
	
	// importo las librerias
	require "./../../_funciones/parametros.php";	
	require "./../../_funciones/funciones.php";
	require "./../../_funciones/database_$aplDataBaseLibrary.php";	

	
?>

<html>
<head>
	<title><?=$aplNombApli;?></title>
	<script language="javascript" src="./../../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../../_funciones/style.css" type="text/css">
</head>
<body bgcolor="<?=$aplBackGroundColor;?>" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<? 	
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Recupera las variables de sesion
	$varPerfUsua = $_SESSION['Perf_User'];

	// Inicializo las variables
	$varDiviChar = $aplDiviChar;

	// Extrae los datos de la Forma o del URL
	$varComando = trim($_POST["cmdComando"]);
	
	if ($varComando == "")
	{
		$varComando = trim($_GET["cmdComando"]);
		$varCodiProd = trim($_GET["txtCodiProd"]);
	}
	else
	{		
		$varCodiCate = trim($_POST["cboCodiCate"]);
		$varCodiProd = trim($_POST["txtCodiProd"]);
		$varNombProd = convertir_especiales_html(trim($_POST["txtNombProd"]));
		$varDescProd = convertir_especiales_html(trim($_POST["txtDescProd"]));
		$varPrecProd = convertir_especiales_html(trim($_POST["txtPrecProd"]));
		$varEstaProd = trim($_POST["cboEstaProd"]);
		
		$txtFotoSubc = str_replace("'","\'",trim($_POST["txtFotoProd"]));
		$varSubcTemp = $_FILES['txtFotoProd']['tmp_name'];
		$varPathSubc = $_FILES['txtFotoProd']['name'];
		$varTipoSubc = $_FILES['txtFotoProd']['type'];
		$varSizeSubc = $_FILES['txtFotoProd']['size'];
		$varExteSubc = substr($varPathSubc,-3);	

	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_PRODUCTO) as COD_PRODUCTO from ".$aplPrefClie."_ref_producto");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiProd = $results["COD_PRODUCTO"][0] + 1; else $varCodiProd = 1;
			funLiberaRecordset ($recordset);
			if (is_uploaded_file($varSubcTemp)) copy($varSubcTemp,$aplUploadPathArch.'imagen_'.$varCodiProd.'.'.$varExteSubc);	
			
			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_producto values ($varCodiCate,$varCodiProd,'$varNombProd','$varDescProd',$varPrecProd,'imagen_" . $varCodiProd . "." . $varExteSubc . "','$varEstaProd')");

			// mensaje de exito
			funLevantaAlert ('El registro fue INGRESADO exitosamente');
		
	}	

	// Actualizar
	if ($varComando == "Actualizar")
	{
		// actualizo el registro
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_producto set COD_CATEGORIA=$varCodiCate,NOM_PRODUCTO='$varNombProd',DES_PRODUCTO='$varDescProd',PRE_PRODUCTO=$varPrecProd,EST_PRODUCTO='$varEstaProd' where COD_PRODUCTO=$varCodiProd");

		if ($varPathSubc!="")
		{
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_producto set IMG_PRODUCTO='imagen_" . $varCodiProd . "." . $varExteSubc . "' where COD_PRODUCTO=$varCodiProd");
			// cargo el archivo
			if (is_uploaded_file($varSubcTemp)) copy($varSubcTemp,$aplUploadPathArch.$varPathSubc);
		}		
	
		
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
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_ref_producto where COD_PRODUCTO=$varCodiProd");			

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_producto WHERE EST_PRODUCTO='A'");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		
		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiProd = trim($results["COD_PRODUCTO"][$varI]);
			$varNombProd = trim($results["NOM_PRODUCTO"][$varI]);
			$varEstaProd = trim($results["EST_PRODUCTO"][$varI]);

			if ($varEstaProd == "A")
			{	
				$varEstaProdNomb = "(Activo)";
			}
			elseif ($varEstaProd == "I")
			{
				$varEstaProdNomb = "(Inactivo)";
			}

			
			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\" style=\"padding-left:25px;\"><a href=\"./frm_subc.php?txtCodiProd=$varCodiProd\" target=\"ejec\" class=\"linktabl\">$varNombProd</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaProdNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_subc.php?txtCodiProd=$varCodiProd&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Registro?');\" class=\"linktabl\"><img src=\"./../../_imagenes/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Productos</td>";
		print "</tr>";
		print "</table>";
	}
	
	print "<br>";		
	print "\n<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"$aplFormTableBackColor\" style=\"border: 1px solid rgb($aplFormTableBorderColor)\">";
	print "<tr>";
	print "	<td class=\"message\" bgcolor=\"#f9f9f9\"><a href=\"./frm_subc.php\" class=\"texttabl\"><img src=\"./../../_imagenes/add-icon.png\" width=\"15px\"/></a></td>";
	print "</tr>";

	// cierra la tabla
	print "</table>";
	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();
?>

</center>
<br>



</body>
</html>