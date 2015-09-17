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
	<title><?=$aplNombApli;?></title>
	<script language="javascript" src="./../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
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
		$varCodiSubc = trim($_GET["txtCodiSubc"]);
	}
	else
	{
		$varCodiSubc = trim($_POST["txtCodiSubc"]);
		$varCodiCate = trim($_POST["cboCodiCate"]);
		$varNombSubc = convertir_especiales_html(trim($_POST["txtNombSubc"]));
		$varAltfSubc = convertir_especiales_html(trim($_POST["txtAltfSubc"]));
		$varFaceSubc = trim($_POST["txtFaceSubc"]);
		$varEstaSubc = trim($_POST["cboEstaSubc"]);

		$txtFotoSubc = str_replace("'","\'",trim($_POST["txtFotoSubc"]));
		$varSubcTemp = $_FILES['txtFotoSubc']['tmp_name'];
		$varPathSubc = $_FILES['txtFotoSubc']['name'];
		$varTipoSubc = $_FILES['txtFotoSubc']['type'];
		$varSizeSubc = $_FILES['txtFotoSubc']['size'];
		$varExteSubc = substr($txtFotoSubc,-3);	

		$varListCodiProd = trim($_POST["txtListCodiProd"]);
		$varListNombProd = trim($_POST["txtListNombProd"]);
		$varListDescProd = trim($_POST["txtListDescProd"]);
		$varListPrecProd = trim($_POST["txtListPrecProd"]);
		$varListEstaProd = trim($_POST["txtListEstaProd"]);
		$varListAcciProd = trim($_POST["txtListAcciProd"]);
	}

	// Ingresar
	if ($varComando == "Ingresar")
	{
		// verifica el tamanio del archivo		
		if (($varSizeSubc <= $aplMaxiFileSize)&&($varSizeSubc > 0))
		{
			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_SUBCATEGORIA) as COD_SUBCATEGORIA from ".$aplPrefClie."_dat_subcategoria");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiSubc = $results["COD_SUBCATEGORIA"][0] + 1; else $varCodiSubc = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			$recordset = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_dat_subcategoria values ($varCodiCate,$varCodiSubc,'$varNombSubc','$varFaceSubc','$varPathSubc','$varAltfSubc','$varEstaSubc')");

			// cargo el archivo
			if (is_uploaded_file($varSubcTemp)) copy($varSubcTemp,$aplUploadPathArch.$varPathSubc);		
	
			// ingresa las subsecciones (verificando si es nuevo o actualizacion)
			$varPosiInic1 = 0;
			$varPosiInic2 = 0;
			$varPosiInic3 = 0;
			$varPosiInic4 = 0;
			$varPosiInic5 = 0;
			$varPosiInic6 = 0;
			$varDim = strlen($varListCodiProd);
			while ($varPosiInic1 < $varDim)
			{	
				// calculo las posiciones finales
				$varPosiFina1 = strpos($varListCodiProd,$varDiviChar,$varPosiInic1);
				$varPosiFina2 = strpos($varListNombProd,$varDiviChar,$varPosiInic2);	
				$varPosiFina3 = strpos($varListDescProd,$varDiviChar,$varPosiInic3);
				$varPosiFina4 = strpos($varListPrecProd,$varDiviChar,$varPosiInic4);
				$varPosiFina5 = strpos($varListEstaProd,$varDiviChar,$varPosiInic5);	
				$varPosiFina6 = strpos($varListAcciProd,$varDiviChar,$varPosiInic6);	

				// extraigo los valores de los arreglos
				$varCodiProd = substr($varListCodiProd,$varPosiInic1,($varPosiFina1-$varPosiInic1));
				$varNombProd = convertir_especiales_html(substr($varListNombProd,$varPosiInic2,($varPosiFina2-$varPosiInic2)));
				$varDescProd = convertir_especiales_html(substr($varListDescProd,$varPosiInic3,($varPosiFina3-$varPosiInic3)));
				$varPrecProd = substr($varListPrecProd,$varPosiInic4,($varPosiFina4-$varPosiInic4));
				$varEstaProd = substr($varListEstaProd,$varPosiInic5,($varPosiFina5-$varPosiInic5));
				$varAcciProd = substr($varListAcciProd,$varPosiInic6,($varPosiFina6-$varPosiInic6));
			
				// obtengo el ultimo codigo
				$recordset = funEjecutaQuerySelect ("select max(COD_PRODUCTO) as COD_PRODUCTO  from ".$aplPrefClie."_ref_producto");
				$nr = funDevuelveArregloRecordset ($recordset,$results);
				if ($nr>0) $varCodiProd = $results["COD_PRODUCTO"][0] + 1; 
				funLiberaRecordset ($recordset);				

				// ingreso el registro
				$execute = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_producto values ($varCodiSubc,$varCodiProd,'$varNombProd','$varDescProd',$varPrecProd,'$varEstaProd')");

				// recorro las posiciones iniciales
				$varPosiInic1 = $varPosiFina1 + 1;
				$varPosiInic2 = $varPosiFina2 + 1;
				$varPosiInic3 = $varPosiFina3 + 1;
				$varPosiInic4 = $varPosiFina4 + 1;
				$varPosiInic5 = $varPosiFina5 + 1;
				$varPosiInic6 = $varPosiFina6 + 1;	
			}

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Ingreso Subcategoria','$varNombSubc')");

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
		// actualizo el registro
		$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_subcategoria set COD_CATEGORIA=$varCodiCate, NOM_SUBCATEGORIA='$varNombSubc', FAC_SUBCATEGORIA='$varFaceSubc', ALT_SUBCATEGORIA='$varAltfSubc', EST_SUBCATEGORIA='$varEstaSubc' where COD_SUBCATEGORIA=$varCodiSubc");

		if ($varPathSubc!="")
		{
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_subcategoria set FOT_SUBCATEGORIA='$varPathSubc' where COD_SUBCATEGORIA=$varCodiSubc");
			// cargo el archivo
			if (is_uploaded_file($varSubcTemp)) copy($varSubcTemp,$aplUploadPathArch.$varPathSubc);
		}		
	
		// selecciona y elimina las LC que deben eliminarse (los que están en la base y no en el arreglo)
		$varListCodiProdTemp = str_replace($varDiviChar,",",$varListCodiProd) . "0";
		$recordset = funEjecutaQuerySelect ("SELECT * FROM ".$aplPrefClie."_ref_producto WHERE COD_SUBCATEGORIA=$varCodiSubc AND COD_PRODUCTO NOT IN ($varListCodiProdTemp)");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiProd = $results["COD_PRODUCTO"][$varI];

			// verifico si existen datos ligados a la LC
			$varPermElim = true;

			// elimino fisicamente o cambio el estado del LC
			if ($varPermElim)
			{
				$execute = funEjecutaQueryEdit ("delete from ".$aplPrefClie."_ref_producto where COD_PRODUCTO=$varCodiProd");
			}
		}
		funLiberaRecordset ($recordset);

		// ingresa las subsecciones (verificando si es nuevo o actualizacion)
		$varPosiInic1 = 0;
		$varPosiInic2 = 0;
		$varPosiInic3 = 0;
		$varPosiInic4 = 0;
		$varPosiInic5 = 0;
		$varPosiInic6 = 0;
		$varDim = strlen($varListCodiProd);
		while ($varPosiInic1 < $varDim)
		{	
			// calculo las posiciones finales
			$varPosiFina1 = strpos($varListCodiProd,$varDiviChar,$varPosiInic1);
			$varPosiFina2 = strpos($varListNombProd,$varDiviChar,$varPosiInic2);	
			$varPosiFina3 = strpos($varListDescProd,$varDiviChar,$varPosiInic3);
			$varPosiFina4 = strpos($varListPrecProd,$varDiviChar,$varPosiInic4);
			$varPosiFina5 = strpos($varListEstaProd,$varDiviChar,$varPosiInic5);	
			$varPosiFina6 = strpos($varListAcciProd,$varDiviChar,$varPosiInic6);	

			// extraigo los valores de los arreglos
			$varCodiProd = substr($varListCodiProd,$varPosiInic1,($varPosiFina1-$varPosiInic1));
			$varNombProd = convertir_especiales_html(substr($varListNombProd,$varPosiInic2,($varPosiFina2-$varPosiInic2)));
			$varDescProd = convertir_especiales_html(substr($varListDescProd,$varPosiInic3,($varPosiFina3-$varPosiInic3)));
			$varPrecProd = substr($varListPrecProd,$varPosiInic4,($varPosiFina4-$varPosiInic4));
			$varEstaProd = substr($varListEstaProd,$varPosiInic5,($varPosiFina5-$varPosiInic5));
			$varAcciProd = substr($varListAcciProd,$varPosiInic6,($varPosiFina6-$varPosiInic6));
		
			switch ($varAcciProd)
			{	
				case "I":
					// obtengo el ultimo codigo
					$recordset = funEjecutaQuerySelect ("select max(COD_PRODUCTO) as COD_PRODUCTO  from ".$aplPrefClie."_ref_producto");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					if ($nr>0) $varCodiProd = $results["COD_PRODUCTO"][0] + 1; 
					funLiberaRecordset ($recordset);				

					// ingreso el registro
					$execute = funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_producto values ($varCodiSubc,$varCodiProd,'$varNombProd','$varDescProd',$varPrecProd,'$varEstaProd')");
					break;
				case "A":
					// ingreso el registro
					$execute = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_producto set NOM_PRODUCTO='$varNombProd', DES_PRODUCTO='$varDescProd', PRE_PRODUCTO=$varPrecProd, EST_PRODUCTO='$varEstaProd' where COD_PRODUCTO=$varCodiProd");
					break;
			}

			// recorro las posiciones iniciales
			$varPosiInic1 = $varPosiFina1 + 1;
			$varPosiInic2 = $varPosiFina2 + 1;
			$varPosiInic3 = $varPosiFina3 + 1;
			$varPosiInic4 = $varPosiFina4 + 1;
			$varPosiInic5 = $varPosiFina5 + 1;
			$varPosiInic6 = $varPosiFina6 + 1;	
		}

		// obtengo el codigo ingresado
		$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
		funLiberaRecordset ($recordset);

		// ingresa los valores en la tabla de auditoria
		$varFechCons = date("Y-m-d H:i:s");
		$varUserUsua = $_SESSION['User_User'];
		funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Actualizacion Subcategoria','$varNombSubc')");

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
			$recordset = funEjecutaQuerySelect("select NOM_SUBCATEGORIA from " . $aplPrefClie . "_dat_subcategoria where COD_SUBCATEGORIA=$varCodiSubc");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varNombSubc = $results["NOM_SUBCATEGORIA"][0] ; else $varNombSubc = "";
			funLiberaRecordset ($recordset);
			
			// elimina el registro
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_dat_subcategoria where COD_SUBCATEGORIA=$varCodiSubc");
			$recordset = funEjecutaQueryEdit ("delete from " . $aplPrefClie . "_ref_producto where COD_SUBCATEGORIA=$varCodiSubc");

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(COD_CONSULTA) as COD_CONSULTA from ".$aplPrefClie."_ref_consulta");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiCons = $results["COD_CONSULTA"][0] + 1; else $varCodiCons = 1;
			funLiberaRecordset ($recordset);

			// ingresa los valores en la tabla de auditoria
			$varFechCons = date("Y-m-d H:i:s");
			$varUserUsua = $_SESSION['User_User'];
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_consulta values ('$varUserUsua',$varCodiCons,'$varFechCons','Eliminacion Subcategoria','$varNombSubc')");

			// mensaje de exito
			funLevantaAlert ('El registro fue ELIMINADO exitosamente');
		}
	}

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select A.*, B.NOM_CATEGORIA from " . $aplPrefClie . "_dat_subcategoria A, " . $aplPrefClie . "_dat_categoria B where A.COD_CATEGORIA=B.COD_CATEGORIA order by B.NOM_CATEGORIA, A.NOM_SUBCATEGORIA");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		// variable auxiliar
		$varNombCateAux = "XX";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiSubc = trim($results["COD_SUBCATEGORIA"][$varI]);
			$varNombSubc = trim($results["NOM_SUBCATEGORIA"][$varI]);
			$varEstaSubc = trim($results["EST_SUBCATEGORIA"][$varI]);
			$varNombCate = trim($results["NOM_CATEGORIA"][$varI]);

			if ($varEstaSubc == "A")
			{	
				$varEstaSubcNomb = "(Activo)";
			}
			elseif ($varEstaSubc == "I")
			{
				$varEstaSubcNomb = "(Inactivo)";
			}

			// despliego titulo de seccion
			if ($varNombCateAux != $varNombCate)
			{
				print "<tr>";
				print "	<td colspan=\"2\" class=\"texttabl\" style=\"color:#004080\" bgcolor=\"#e4e3cf\">" . $varNombCate . "</td>";
				print "</tr>";
				$varNombCateAux = $varNombCate;
			}

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\" style=\"padding-left:15px;\"><a href=\"./frm_subc.php?txtCodiSubc=$varCodiSubc\" target=\"form\" class=\"linktabl\">$varNombSubc</a>&nbsp;<font style=\"color:#666666\"><i>$varEstaSubcNomb</i></font></td>";
			print "	<td width=\"3%\" class=\"texttabl\" align=\"center\"><a href=\"./exe_subc.php?txtCodiSubc=$varCodiSubc&cmdComando=Eliminar\" onClick=\"return confirm('Esta seguro que desea eliminar el Registro?');\" class=\"linktabl\"><img src=\"./../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>";
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
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Subcategorias</td>";
		print "</tr>";
		print "</table>";
	}
	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();
?>

</center>
<br>

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