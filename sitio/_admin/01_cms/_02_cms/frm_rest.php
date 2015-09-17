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
	<script language="javascript" src="./../_funciones/funciones.js"></script>
	<script language="javascript" src="./../_funciones/images.js"></script>	
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 

		function funValidaDatos(dml,parECodiRest)
		{
			// titulo
			if (dml.elements['txtNombRest'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE.');
				dml.elements['txtNombRest'].focus();
				return false;
			}

			// titulo
			if (dml.elements['txtDireRest'].value.length==0)
			{
				alert ('No ha ingresado la DIRECCION.');
				dml.elements['txtDireRest'].focus();
				return false;
			}

			if (parECodiRest=="")
			{
				// foto 1
				if (dml.elements['txtFotoRest'].value.length==0)
				{
					alert ('No ha ingresado la FOTO.');
					dml.elements['txtFotoRest'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoRest'].value;
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
				if (dml.elements['txtFotoRest'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoRest'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

			}

			// foto 2
			if (dml.elements['txtFotpMapa'].value.length!=0)
			{
				varValoCamp = dml.elements['txtFotoRest'].value;
				varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
				if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
				{
					alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
					return false;
				}
			}

			// foto 3
			if (dml.elements['txtFotgMapa'].value.length!=0)
			{
				varValoCamp = dml.elements['txtFotoRest'].value;
				varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
				if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
				{
					alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
					return false;
				}
			}

			// alt restaurante
			if (dml.elements['txtAltfRest'].value.length==0)
			{
				alert ('No ha ingresado el ALT de la foto del restaurante.');
				dml.elements['txtAltfRest'].focus();
				return false;
			}

			if (dml.elements['txtFotpMapa'].value.length!=0)
			{
				// alt restaurante
				if (dml.elements['txtAltpMapa'].value.length==0)
				{
					alert ('No ha ingresado el ALT de la foto del mapa pequenia.');
					dml.elements['txtAltpMapa'].focus();
					return false;
				}
			}

			// foto 3
			if (dml.elements['txtFotgMapa'].value.length!=0)
			{
				// alt restaurante
				if (dml.elements['txtAltgMapa'].value.length==0)
				{
					alert ('No ha ingresado el ALT de la foto del mapa grande.');
					dml.elements['txtAltgMapa'].focus();
					return false;
				}

			}

		
			// texto
			/*if (dml.elements['txtTeleRest'].value.length==0)
			{
				alert ('No ha ingresado el TELEFONO.');
				dml.elements['txtTeleRest'].focus();
				return false;
			}*/

			// estado
			if (dml.elements['cboEstaRest'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaRest'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_rest.php";
			return false;
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['cboCodiProv'].focus();">
<form action="./exe_rest.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiRest = trim($_GET["txtCodiRest"]);
	$varCodiProv = "";
	$varCodiCiud = "";
	$varNombRest = "";
	$varDireRest = "";
	$varTeleRest = "";
	$varSaloRestSele = "";
	$varAutoRestSele = "";
	$varDomiRestSele = "";
	$varHelaRestSele = "";
	$varChicRestSele = "";
	$varEstaRest = "";
	$varEstaRestSeleNada = "";
	$varEstaRestSeleActi = "";
	$varEstaRestSeleInac = "";
	$varAltfRest = "";
	$varAltpMapa = "";
	$varAltgMapa = "";

	// Hace la consulta si es necesario
	if ($varCodiRest != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select A.*, B.COD_PROVINCIA from ".$aplPrefClie."_dat_restaurante A, ".$aplPrefClie."_ref_ciudad B where A.COD_RESTAURANTE=$varCodiRest and A.COD_CIUDAD=B.COD_CIUDAD");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varCodiProv = trim($results["COD_PROVINCIA"][0]);
			$varCodiCiud = trim($results["COD_CIUDAD"][0]);
			$varNombRest = trim($results["NOM_RESTAURANTE"][0]);
			$varDireRest = trim($results["DIR_RESTAURANTE"][0]);
			$varTeleRest = trim($results["TEL_RESTAURANTE"][0]);
			if (trim($results["TIE_SALORESTAURANTE"][0]) == "S") $varSaloRestSele = "checked"; else $varSaloRestSele = "";
			if (trim($results["TIE_AUTORESTAURANTE"][0]) == "S") $varAutoRestSele = "checked"; else $varAutoRestSele = "";
			if (trim($results["TIE_DOMIRESTAURANTE"][0]) == "S") $varDomiRestSele = "checked"; else $varDomiRestSele = "";
			if (trim($results["TIE_HELARESTAURANTE"][0]) == "S") $varHelaRestSele = "checked"; else $varHelaRestSele = "";
			if (trim($results["TIE_CHICRESTAURANTE"][0]) == "S") $varChicRestSele = "checked"; else $varChicRestSele = "";
			$varEstaRest = trim($results["EST_RESTAURANTE"][0]);
			$varAltfRest = trim($results["ALT_RESTAURANTE"][0]);
			$varAltpMapa = trim($results["ALT_PEQUMAPA"][0]);
			$varAltgMapa = trim($results["ALT_GRANMAPA"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido estado
		if ($varEstaRest == "A")
		{
			$varEstaRestSeleNada = "";
			$varEstaRestSeleActi = "selected";
			$varEstaRestSeleInac = "";
		}
		elseif ($varEstaRest == "I")
		{
			$varEstaRestSeleNada = "";
			$varEstaRestSeleActi = "";
			$varEstaRestSeleInac = "selected";
		}
		else
		{
			$varEstaRestSeleNada = "selected";
			$varEstaRestSeleActi = "";
			$varEstaRestSeleInac = "";
		}
	}

	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	// creo el arreglo de ciudades
	$recordset = funEjecutaQuerySelect ("select COD_PROVINCIA, COD_CIUDAD, NOM_CIUDAD from ".$aplPrefClie."_ref_ciudad order by NOM_CIUDAD");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	funCreaArreglosComboDinamico ("Ciud",$results,$nr,'COD_PROVINCIA','COD_CIUDAD','NOM_CIUDAD');
	funLiberaRecordset ($recordset);

	print "<input type=\"hidden\" name=\"txtCodiRest\" value=\"$varCodiRest\">";
?>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Provincia : &nbsp;</td>
			<td>
				<select id="cboCodiProv" name="cboCodiProv" style="width:190px" class="textbox" onChange="funLlenaComboFiltrado (document.getElementById('cboCodiCiud'),arrFiltCiud,arrCodiCiud,arrTextCiud,this.value,'',false,'','');">
				<?
					$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_ref_provincia A order by A.NOM_PROVINCIA");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
						if ($varCodiProv == $results["COD_PROVINCIA"][$varI])
						{
							print "		<option value=\"" . $results["COD_PROVINCIA"][$varI] . "\" selected>" . trim($results["NOM_PROVINCIA"][$varI]);
						}
						else
						{
							print "		<option value=\"" . $results["COD_PROVINCIA"][$varI] . "\">" . trim($results["NOM_PROVINCIA"][$varI]);
						}
					}
					funLiberaRecordset ($recordset);
				?>				
				</select>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Ciudad : &nbsp;</td>
			<td><select id="cboCodiCiud" name="cboCodiCiud" style="width:190px" class="textbox"></select>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td><input type="text" name="txtNombRest" value="<?= $varNombRest ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Direccion : &nbsp;</td>
			<td><input type="text" name="txtDireRest" value="<?= $varDireRest ?>" maxlength="180" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Restaurante : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotoRest" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Mapa Peque&ntilde;a : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotpMapa" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Mapa Grande : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotgMapa" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto Restaurante : &nbsp;</td>
			<td><input type="text" name="txtAltfRest" value="<?= $varAltfRest ?>" maxlength="120" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Mapa Peque&ntilde;a : &nbsp;</td>
			<td><input type="text" name="txtAltpMapa" value="<?= $varAltpMapa ?>" maxlength="120" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Mapa Grande : &nbsp;</td>
			<td><input type="text" name="txtAltgMapa" value="<?= $varAltgMapa ?>" maxlength="120" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Telefono : &nbsp;</td>
			<td><input type="text" name="txtTeleRest" value="<?= $varTeleRest ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Salon : &nbsp;</td>
			<td>
				<table>
					<tr>
						<td><input type="checkbox" name="chkSaloRest" value="S" <?=$varSaloRestSele?>></td>
						<td>&nbsp;</td>
						<td class="label" align="right">&nbsp;Auto : &nbsp;</td>
						<td><input type="checkbox" name="chkAutoRest" value="S" <?=$varAutoRestSele?>></td>
						<td>&nbsp;</td>
						<td class="label" align="right">Domicilio : &nbsp;</td>
						<td><input type="checkbox" name="chkDomiRest" value="S" <?=$varDomiRestSele?>></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Heladeria : &nbsp;</td>
			<td>
				<table>
					<tr>
						<td><input type="checkbox" name="chkHelaRest" value="S" <?=$varHelaRestSele?>></td>
						<td>&nbsp;</td>
						<td class="label" align="right">Chicky Club : &nbsp;</td>
						<td><input type="checkbox" name="chkChicRest" value="S" <?=$varChicRestSele?>></td>
						<td>&nbsp;</td>
						<td class="label" align="right">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select name="cboEstaRest" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaRestSeleNada?>> ...
					<option value="A" <?=$varEstaRestSeleActi?>> Activo
					<option value="I" <?=$varEstaRestSeleInac?>> Inactivo
				</select>				
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- separacion -->
<br>

<!-- comandos -->
<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	<? if ($varCodiRest == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiRest?>');">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiRest?>');">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar el Restaurante?');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

<script language="JavaScript">
<!--
	// guardo el formulario
	dml = document.forms[0];
	varComboCiud = dml.cboCodiCiud;

	// lleno el combo de departamentos
	funLlenaComboFiltrado (varComboCiud,arrFiltCiud,arrCodiCiud,arrTextCiud,dml.cboCodiProv.value,'<?=$varCodiCiud?>','N','','');

-->
</script>

</form>
</body>
</html>