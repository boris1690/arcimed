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
	<script language="javascript" src="./../_funciones/funciones.js"></script>
	<script language="javascript" src="./../_funciones/images.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 
		
		// Variables Globales		
		var varNumeItemProd = -1;
		var varDiviChar =  "<?=$aplDiviChar?>";

		function funValidaDatos(dml,parECodiSubc)
		{
			// categoria
			if (dml.elements['cboCodiCate'].value.length==0)
			{
				alert ('No ha seleccionado la CATEGORIA');
				dml.elements['cboCodiCate'].focus();
				return false;
			}

			// nombre
			if (dml.elements['txtNombSubc'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE de la subcategoria');
				dml.elements['txtNombSubc'].focus();
				return false;
			}

			if (parECodiSubc == "")
			{
				// foto 1
				if (dml.elements['txtFotoSubc'].value.length==0)
				{
					alert ('No ha ingresado la FOTO de la subcategoria.');
					dml.elements['txtFotoSubc'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoSubc'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}
			}
			else
			{
				// foto 1
				if (dml.elements['txtFotoSubc'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoSubc'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}
			}

			// alt
			if (dml.elements['txtAltfSubc'].value.length==0)
			{
				alert ('No ha ingresado el ALT para la foto de la subcategoria');
				dml.elements['txtAltfSubc'].focus();
				return false;
			}

			// categoria
			if (dml.elements['cboEstaSubc'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO de la subcategoria');
				dml.elements['cboEstaSubc'].focus();
				return false;
			}

			// Lleno los arreglos de subsecciones
			dml.elements.txtListCodiProd.value = "";
			dml.elements.txtListNombProd.value = "";
			dml.elements.txtListDescProd.value = "";
			dml.elements.txtListPrecProd.value = "";
			dml.elements.txtListEstaProd.value = "";
			dml.elements.txtListAcciProd.value = "";
			for (varI=0;varI<varNumeProd;varI++)
			{
				dml.elements.txtListCodiProd.value = dml.elements.txtListCodiProd.value + var_RR_codi_Prod[varI] + varDiviChar;
				dml.elements.txtListNombProd.value = dml.elements.txtListNombProd.value + var_RR_nomb_Prod[varI] + varDiviChar;
				dml.elements.txtListDescProd.value = dml.elements.txtListDescProd.value + var_RR_desc_Prod[varI] + varDiviChar;				
				dml.elements.txtListPrecProd.value = dml.elements.txtListPrecProd.value + var_RR_prec_Prod[varI] + varDiviChar;				
				dml.elements.txtListEstaProd.value = dml.elements.txtListEstaProd.value + var_RR_esta_Prod[varI] + varDiviChar;				
				dml.elements.txtListAcciProd.value = dml.elements.txtListAcciProd.value + var_RR_acci_Prod[varI] + varDiviChar;				
			}

			//alert(dml.elements.txtListCodiProd.value);
			//alert(dml.elements.txtListNombProd.value);
			//alert(dml.elements.txtListDescProd.value);
			//alert(dml.elements.txtListPrecProd.value);
			//alert(dml.elements.txtListEstaProd.value);
			//alert(dml.elements.txtListAcciProd.value);

			// categoria
			if (dml.elements['txtListCodiProd'].value=="")
			{
				alert ('No ha ingresado ningun PRODUCTO en la subcategoria');
				return false;
			}

			return true;

		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_subc.php";
			return false;
		}

	-->
	</script>	

	<script language="javascript">
	<!--
				
		// Limpia el formulario 
		function funLimpiaProd()
		{
			// Inicializo las variables
			dml = document.forms[0];

			// Limpio el formularios
			dml.txtNombProd.value = "";
			dml.txtDescProd.value = "";
			dml.txtPrecProd.value = "";
			dml.cboEstaProd.value = "X";
			
			// Seteo el Item de Trabajo en ninguno
			varNumeItemProd = -1;

			// Cambio el boton para indicar actualizacion
			dml.cmdMiniComando[0].value = ">>";

			// Setea el Foco
			dml.txtNombProd.focus();
		}

		// Llama al Ingreso o Actualizacion 
		function funIngrActuProd()
		{
			// si el item de objeto de trabajo esta en ninguno se ingresa
			if (varNumeItemProd == -1)
				funIngresaActualizaProd('I');
			else
				funIngresaActualizaProd('A');
		}

		// Ingresa o Actualiza 
		function funIngresaActualizaProd(parEAccion)
		{			
			// Inicializo las variables
			dml = document.forms[0];

			// Subsección
			if (dml.elements['txtNombProd'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE del producto.');
				dml.elements['txtNombProd'].focus();
				return false;
			}

			// Subsección
			if (dml.elements['txtDescProd'].value.length==0)
			{
				alert ('No ha ingresado la DESCRIPCION del producto.');
				dml.elements['txtDescProd'].focus();
				return false;
			}

			// Subsección
			if (dml.elements['txtPrecProd'].value.length==0)
			{
				alert ('No ha ingresado el PRECIO del producto.');
				dml.elements['txtPrecProd'].focus();
				return false;
			}

			// Subsección
			if (dml.elements['cboEstaProd'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO del producto.');
				dml.elements['cboEstaProd'].focus();
				return false;
			}

			// Segun el tipo de accion veo si creo un registro o sobrescribo alguno existente
			if (parEAccion == 'I')
			{	
				var_RR_codi_Prod[varNumeProd] = "-1";
				var_RR_nomb_Prod[varNumeProd] = dml.txtNombProd.value;
				var_RR_desc_Prod[varNumeProd] = dml.txtDescProd.value;
				var_RR_prec_Prod[varNumeProd] = dml.txtPrecProd.value;
				var_RR_esta_Prod[varNumeProd] = dml.cboEstaProd.value;
				var_RR_acci_Prod[varNumeProd] = "I";
				varNumeProd = varNumeProd + 1;
			}
			else
			{
				var_RR_nomb_Prod[varNumeItemProd] = dml.txtNombProd.value;
				var_RR_desc_Prod[varNumeItemProd] = dml.txtDescProd.value;
				var_RR_prec_Prod[varNumeItemProd] = dml.txtPrecProd.value;
				var_RR_esta_Prod[varNumeItemProd] = dml.cboEstaProd.value;
				// si es uno nuevo que esta actualizando lo deja como ingreso
				if (var_RR_codi_Prod[varNumeItemProd] != "-1")
					var_RR_acci_Prod[varNumeItemProd] = "A";
			}

			// Refresco el iFrame de detalle
			document.frames['lst_subc'].location = "./lst_subc.php";

			// Limpia el textbox
			funLimpiaProd();
		}

		// Elimina las subsecciones
		function funEliminaProd(parEItem)
		{
			// Inicializo las variables
			dml = document.forms[0];

			// Inicializo las variables
			varLen = varNumeProd;

			// Recorro los elementos posteriores al encontrado hacia atras
			for (varJ=parEItem;varJ<varLen-1;varJ++)
			{
				var_RR_codi_Prod[varJ] = var_RR_codi_Prod[varJ+1];
				var_RR_nomb_Prod[varJ] = var_RR_nomb_Prod[varJ+1];
				var_RR_desc_Prod[varJ] = var_RR_desc_Prod[varJ+1];
				var_RR_prec_Prod[varJ] = var_RR_prec_Prod[varJ+1];
				var_RR_esta_Prod[varJ] = var_RR_esta_Prod[varJ+1];
				var_RR_acci_Prod[varJ] = var_RR_acci_Prod[varJ+1];
			}

			// Disminuyo el contador de productos proformados y suspende la busqueda
			varNumeProd = varNumeProd - 1;

			// Refresco el iFrame de detalle
			document.frames['lst_subc'].location = "./lst_subc.php";

			// Limpia el formulario de objetos
			funLimpiaProd();
		}

		// Recupera las categorias y cargos
		function funRecuperaProd(parEItem)
		{
			// Inicializo las variables
			dml = document.forms[0];

			// Recupero los datos
			dml.txtNombProd.value = var_RR_nomb_Prod[parEItem];
			dml.txtDescProd.value = var_RR_desc_Prod[parEItem];
			dml.txtPrecProd.value = var_RR_prec_Prod[parEItem];
			dml.cboEstaProd.value = var_RR_esta_Prod[parEItem];		
			
			// Seteo el item en el recuperado
			varNumeItemProd = parEItem;

			// Cambio el boton para indicar actualizacion
			dml.cmdMiniComando[0].value = "<>";

			// Seteo el foco
			dml.txtNombProd.focus();
		}

	-->	
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
<form action="./exe_subc.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiCate = "";
	$varCodiSubc = trim($_GET["txtCodiSubc"]);
	$varNombSubc = "";
	$varAltfSubc = "";
	$varFaceSubc = "";
	$varEstaSubc = "";
	$varFotoSubc = "";
	$varMaxiNumeProd = 20;
	
	// Hace la consulta si es necesario
	if ($varCodiSubc != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_subcategoria where COD_SUBCATEGORIA=$varCodiSubc");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varCodiCate = trim($results["COD_CATEGORIA"][0]);
			$varNombSubc = trim($results["NOM_SUBCATEGORIA"][0]);
			$varAltfSubc = trim($results["ALT_SUBCATEGORIA"][0]);
			$varFotoSubc = trim($results["FOT_SUBCATEGORIA"][0]);
			$varFaceSubc = trim($results["FAC_SUBCATEGORIA"][0]);
			$varEstaSubc = trim($results["EST_SUBCATEGORIA"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido estado
		if ($varEstaSubc == "A")
		{
			$varEstaSubcSeleNada = "";
			$varEstaSubcSeleActi = "selected";
			$varEstaSubcSeleInac = "";
		}
		elseif ($varEstaSubc == "I")
		{
			$varEstaSubcSeleNada = "";
			$varEstaSubcSeleActi = "";
			$varEstaSubcSeleInac = "selected";
		}
		else
		{
			$varEstaSubcSeleNada = "selected";
			$varEstaSubcSeleActi = "";
			$varEstaSubcSeleInac = "";
		}
	
		// Obtengo las subsecciones	
		$recordset = funEjecutaQuerySelect ("select count(*) as CUENTA from ".$aplPrefClie."_ref_producto where COD_SUBCATEGORIA=$varCodiSubc");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varNumeProd = $results["CUENTA"][0]; else $varNumeProd = 0;
		funLiberaRecordset ($recordset);

		// creo el arreglo de producto
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_ref_producto where COD_SUBCATEGORIA=$varCodiSubc");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		print "\n<script language=\"JavaScript\">";
		print "\n<!--";
		print "\n	var varNumeProd = $varNumeProd";
		print "\n	var var_RR_codi_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_nomb_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_desc_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_prec_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_esta_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_acci_Prod = new Array($varMaxiNumeProd)";	
		for ($varI=0;$varI<$nr;$varI++)
		{
			print "\n	var_RR_codi_Prod[$varI] = \"" . trim($results["COD_PRODUCTO"][$varI]) . "\"";
			print "\n	var_RR_nomb_Prod[$varI] = \"" . trim($results["NOM_PRODUCTO"][$varI]) . "\"";
			print "\n	var_RR_desc_Prod[$varI] = \"" . trim($results["DES_PRODUCTO"][$varI]) . "\"";
			print "\n	var_RR_prec_Prod[$varI] = \"" . trim($results["PRE_PRODUCTO"][$varI]) . "\"";
			print "\n	var_RR_esta_Prod[$varI] = \"" . trim($results["EST_PRODUCTO"][$varI]) . "\"";
			print "\n	var_RR_acci_Prod[$varI] = \"X\"";
		}
		print "\n-->";
		print "\n</script>";
		funLiberaRecordset ($recordset);
	}
	else
	{
		// creo el arreglo de materias
		print "\n<script language=\"JavaScript\">";
		print "\n<!--";
		print "\n	var varNumeProd = 0";
		print "\n	var var_RR_codi_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_nomb_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_desc_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_prec_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_esta_Prod = new Array($varMaxiNumeProd)";
		print "\n	var var_RR_acci_Prod = new Array($varMaxiNumeProd)";
		print "\n-->";
		print "\n</script>";
	}
	
	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiSubc\" value=\"$varCodiSubc\">";
	print "<input type=\"hidden\" name=\"txtListCodiProd\" value=\"\">";
	print "<input type=\"hidden\" name=\"txtListNombProd\" value=\"\">";
	print "<input type=\"hidden\" name=\"txtListDescProd\" value=\"\">";
	print "<input type=\"hidden\" name=\"txtListPrecProd\" value=\"\">";
	print "<input type=\"hidden\" name=\"txtListEstaProd\" value=\"\">";
	print "<input type=\"hidden\" name=\"txtListAcciProd\" value=\"\">";
?>

<!-- marco principal -->
<table width="95%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right" nowrap>Categoria : &nbsp;</td>
			<td>
				<select id="cboCodiCate" name="cboCodiCate" style="width:320px" class="textbox">
				<?
					$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_categoria where EST_CATEGORIA='A' order by NOM_CATEGORIA");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
						if ($varCodiCate == $results["COD_CATEGORIA"][$varI])
						{
							print "		<option value=\"" . $results["COD_CATEGORIA"][$varI] . "\" selected>" . trim($results["NOM_CATEGORIA"][$varI]);
						}
						else
						{
							print "		<option value=\"" . $results["COD_CATEGORIA"][$varI] . "\">" . trim($results["NOM_CATEGORIA"][$varI]);
						}
					}
					funLiberaRecordset ($recordset);
				?>				
				</select>
			</td>
		</tr>
		<tr>
			<td class="label" align="right" nowrap>Subcategoria : &nbsp;</td>
			<td><input type="text" id="txtNombSubc" name="txtNombSubc" value="<?= $varNombSubc ?>" maxlength="120" style="width:320px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Foto : &nbsp;</td>
			<td class="label"><input type="file" id="txtFotoSubc" name="txtFotoSubc" value="" maxlength="200" style="width:320px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto : &nbsp;</td>
			<td><input type="text" id="txtAltfSubc" name="txtAltfSubc" value="<?= $varAltfSubc ?>" maxlength="120" style="width:320px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Link Facebook : &nbsp;</td>
			<td><?= funImprimeCampoArea ("txtFaceSubc", "10", "2", $varFaceSubc, "N", "N", "textbox", "width:320px;", "", "", "") ?></td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select id="cboEstaSubc" name="cboEstaSubc" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaSubcSeleNada?>> ...
					<option value="A" <?=$varEstaSubcSeleActi?>> Activo
					<option value="I" <?=$varEstaSubcSeleInac?>> Inactivo
				</select>				
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- separacion -->
<table cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="../images/blank.gif" width="2" height="7" border=0 alt=""></td></tr>
</table>

<table cellpadding="10" cellspacing="1" border="0" width="95%" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" >
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td align=center>
				<table border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td class="label" align="right" nowrap>Producto : &nbsp;</td>
					<td><input type="text" id="txtNombProd" name="txtNombProd" value="" maxlength="80" style="width:320px;" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
				</tr>
				<tr>
					<td class="label" align="right" nowrap>Descripci&oacute;n : &nbsp;</td>
					<td><input type="text" id="txtDescProd" name="txtDescProd" value="" maxlength="200" style="width:320px;" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
				</tr>
				<tr>
					<td class="label" align="right" nowrap>Precio : &nbsp;</td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td><input type="text" id="txtPrecProd" name="txtPrecProd" value="" maxlength="10" style="width:90px;text-align:right;" class="textbox" onKeyPress="controla_digitacion_decimal(event,this,2)"></td>
								<td class="label" align="right">&nbsp; Estado : &nbsp;</td>
								<td class="label">
									<select id="cboEstaProd" name="cboEstaProd" style="width:90px;" class="textbox">
										<option value="X"> ...
										<option value="A"> Activo
										<option value="I"> Inactivo
									</select>				
								</td>
								<td><img src="./../images/blank.gif" width=13 height=0></td>
								<td><input type=submit name="cmdMiniComando" value=">>" style="height:20px;width:30px;font-size:10px;" onClick="funIngrActuProd(); return false;" ></td>
								<td><img src="./../images/blank.gif" width=4 height=0></td>
								<td><input type=submit name="cmdMiniComando" value="==" style="height:20px;width:30px;font-size:10px;" onClick="funLimpiaProd(); return false;" ></td>
							</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td><img src="./../images/blank.gif" width=5 height=0></td></tr>
		<tr>
			<td><iframe id="subs" name="lst_subc" src="./lst_subc.php" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="yes" width="400" height="110"></iframe></td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- separacion -->
<table cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="../images/blank.gif" width="2" height="7" border=0 alt=""></td></tr>
</table>

<!-- comandos -->
<table width="95%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	<? if ($varCodiSubc == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiSubc?>');">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiSubc?>');">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea elimiar la Subcategoria?');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>