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
	<title><?=$aplNombApli;?></title>
	<script language="javascript" src="./../../_funciones/funciones.js"></script>
	<script language="javascript" src="./../../_funciones/images.js"></script>
	<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
	<link rel="stylesheet" href="./../../_funciones/style.css" type="text/css">

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
			if (dml.elements['txtNombProd'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE');
				dml.elements['txtNombProd'].focus();
				return false;
			}

			if (parECodiSubc == "")
			{
				// foto 1
				if (dml.elements['txtFotoProd'].value.length==0)
				{
					alert ('No ha ingresado la FOTO');
					dml.elements['txtFotoProd'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoProd'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no est� permitido.');
						return false;
					}
				}
			}
			else
			{
				// foto 1
				if (dml.elements['txtFotoProd'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoProd'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no est� permitido.');
						return false;
					}
				}
			}

			// estadoi
			if (dml.elements['txtPrecProd'].value=="")
			{
				alert ('No ha ingresado el PRECIO');
				dml.elements['txtPrecProd'].focus();
				return false;
			}
				
			// estadoi
			if (dml.elements['txtDescProd'].value=="")
			{
				alert ('No ha ingresado la DESCRIPCION');
				dml.elements['txtDescProd'].focus();
				return false;
			}
			
			// estadoi
			if (dml.elements['cboEstaProd'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaProd'].focus();
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


</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
<form action="./exe_subc.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiCate = "";	
	$varCodiProd = trim($_GET["txtCodiProd"]);
	$varNombProd = "";
	$varDescProd = "";
	$varPrecProd = "";
	$varEstaProd = "";
	
	// Hace la consulta si es necesario
	if ($varCodiProd != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_ref_producto where COD_PRODUCTO=$varCodiProd");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varCodiCate = trim($results["COD_CATEGORIA"][0]);
			$varCodiProd = trim($results["COD_PRODUCTO"][0]);			
			$varNombProd = trim($results["NOM_PRODUCTO"][0]);
			$varDescProd = trim($results["DES_PRODUCTO"][0]);
			$varPrecProd = trim($results["PRE_PRODUCTO"][0]);
			$varEstaProd = trim($results["EST_PRODUCTO"][0]);
		}
		funLiberaRecordset ($recordset);
		
		// valido estado
		if ($varEstaProd == "A")
		{
			$varEstaProdSeleNada = "";
			$varEstaProdSeleActi = "selected";
			$varEstaProdSeleInac = "";
		}
		elseif ($varEstaProd == "I")
		{
			$varEstaProdSeleNada = "";
			$varEstaProdSeleActi = "";
			$varEstaProdSeleInac = "selected";
		}
		else
		{
			$varEstaProdSeleNada = "selected";
			$varEstaProdSeleActi = "";
			$varEstaProdSeleInac = "";
		}

		
	
	}
	
	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiProd\" value=\"$varCodiProd\">";
	
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
					$recordset = funEjecutaQuerySelect ("SELECT * from ".$aplPrefClie."_dat_categoria A WHERE A.EST_CATEGORIA='A'");
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
			<td class="label" align="right">Foto : &nbsp;</td>
			<td class="label"><input type="file" id="txtFotoProd" name="txtFotoProd" value="" maxlength="200" style="width:320px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right" nowrap>Producto : &nbsp;</td>
			<td><input type="text" id="txtNombProd" name="txtNombProd" value="<?=$varNombProd?>" maxlength="80" style="width:320px;" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
		</tr>
		<tr>
			<td class="label" align="right" nowrap>Descripci&oacute;n : &nbsp;</td>
			<td><textarea type="text" id="txtDescProd" name="txtDescProd" style="width:320px;" class="textbox"><?=$varDescProd?></textarea></td>
		</tr>
		<tr>
			<td class="label" align="right" nowrap>Precio : &nbsp;</td>
			<td><input type="text" id="txtPrecProd" name="txtPrecProd" value="<?=$varPrecProd?>" maxlength="10" style="width:90px;text-align:right;" class="textbox" onKeyPress="controla_digitacion_decimal(event,this,2)"></td>
		</tr>
		<tr>
			<td class="label" align="right">&nbsp; Estado : &nbsp;</td>
			<td class="label">
				<select id="cboEstaProd" name="cboEstaProd" style="width:90px;" class="textbox">
					<option value="X" <?=$varEstaProdSeleNada?>> ...
					<option value="A" <?=$varEstaProdSeleActi?>> Activo
					<option value="I" <?=$varEstaProdSeleInac?>> Inactivo
				</select>				
			</td>										
		</tr>
			
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
	<? if ($varCodiProd == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiProd?>');">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiProd?>');">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea elimiar la Subcategoria?');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>

<script>
	tinymce.init({
		selector: "textarea",
		plugins: [
			"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
		],

		toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
		toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
		toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

		menubar: false,
		toolbar_items_size: 'small',

		style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		],

		templates: [
			{title: 'Test template 1', content: 'Test 1'},
			{title: 'Test template 2', content: 'Test 2'}
		]
	});
</script>
</body>
</html>