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
	<script language="javascript" src="./../_funciones/showhide.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 

		function funValidaDatos(dml,parECodiBann)
		{
			// titulo
			if (dml.elements['txtNombBann'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE.');
				dml.elements['txtNombBann'].focus();
				return false;
			}

			if (parECodiBann == "")
			{

				// foto 1
				if (dml.elements['txtFotoBann'].value.length==0)
				{
					alert ('No ha ingresado la FOTO.');
					dml.elements['txtFotoBann'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoBann'].value;
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
				if (dml.elements['txtFotoBann'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoBann'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

			}

			// alt home
			if (dml.elements['txtAltfBann'].value.length==0)
			{
				alert ('No ha ingresado el ALT.');
				dml.elements['txtAltfBann'].focus();
				return false;
			}

			// url
			if (dml.elements['txtUrl_Bann'].value.length==0)
			{
				alert ('No ha ingresado el URL');
				dml.elements['txtUrl_Bann'].focus();
				return false;
			}

			// estado
			if (dml.elements['cboEstaBann'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaBann'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_bann.php";
			return false;
		}

	-->
	</script>

	<script language="JavaScript">
	<!--

		function levantaMenuOpciones(parEIdenOpci)
		{
			// oculto todos los menus
			hide('layDatoLink');

			// despliego el menu que corresponda
			if (parEIdenOpci == "LINK")
				show('layDatoLink');
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtNombBann'].focus();">
<form action="./exe_bann.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiBann = trim($_GET["txtCodiBann"]);
	$varNombBann = "";
	$varFotoBann = "";
	$varAltfBann = "";
	$varUrl_Bann = "";
	$varEstaBann = "";

	// Hace la consulta si es necesario
	if ($varCodiBann != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_banner where COD_BANNER=$varCodiBann");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varNombBann = trim($results["NOM_BANNER"][0]);
			$varFotoBann = trim($results["FOT_BANNER"][0]);
			$varAltfBann = trim($results["ALT_BANNER"][0]);
			$varUrl_Bann = trim($results["URL_BANNER"][0]);
			$varEstaBann = trim($results["EST_BANNER"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido estado
		if ($varEstaBann == "A")
		{
			$varEstaBannSeleNada = "";
			$varEstaBannSeleActi = "selected";
			$varEstaBannSeleInac = "";
		}
		elseif ($varEstaBann == "I")
		{
			$varEstaBannSeleNada = "";
			$varEstaBannSeleActi = "";
			$varEstaBannSeleInac = "selected";
		}
		else
		{
			$varEstaBannSeleNada = "selected";
			$varEstaBannSeleActi = "";
			$varEstaBannSeleInac = "";
		}
	}

	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiBann\" value=\"$varCodiBann\">";
?>

<!-- Lista de links -->
<div id="layDatoLink" style="POSITION:absolute; Z-INDEX:10; LEFT:367; TOP:76; VISIBILITY:hidden;">
	<table border="0" cellpadding="0" cellspacing="2" bgcolor="#666666" width="320">
	<tr>
		<td align="right" bgcolor="#ffffff">
			<table cellpadding="1" cellspacing="1" border="0" width="100%">
			<tr>
				<td style="color:#666666;font-size:10px;" class="label" align="left">&nbsp;<b>Links Internos</b>&nbsp;</td>
				<td align="right" valign="top"><a href="#" onClick="hide('layDatoLink'); return false;"><span style="color:#CC0000;font-size:10px;" class="linktabl"><b>X</b></span></a>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<iframe name="lstlink" src="lst_link.php" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="auto" width="310" height="210"></iframe>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td><input type="text" name="txtNombBann" value="<?= $varNombBann ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Banner : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotoBann" value="" maxlength="255" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto Banner : &nbsp;</td>
			<td><input type="text" name="txtAltfBann" value="<?= $varAltfBann ?>" maxlength="120" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Url : &nbsp;</td>
			<td class="label">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><input type="text" name="txtUrl_Bann" value="<?=$varUrl_Bann?>" style="width:389px;" class="textbox"></td>
					<td>&nbsp;<a href="#" onClick="levantaMenuOpciones('LINK'); return false;"><img src="../images/ic_flecverd.gif" width="12" height="12" border="0" alt="Ver Links Internos"></a></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select name="cboEstaBann" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaBannSeleNada?>> ...
					<option value="A" <?=$varEstaBannSeleActi?>> Activo
					<option value="I" <?=$varEstaBannSeleInac?>> Inactivo
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
	<? if ($varCodiBann == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiBann?>');">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiBann?>');">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar el Home - Banner');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>