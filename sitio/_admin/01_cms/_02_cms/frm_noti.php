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

		function funValidaDatos(dml,parECodiNoti)
		{
			// titulo
			if (dml.elements['txtTituNoti'].value.length==0)
			{
				alert ('No ha ingresado el TITUTLO.');
				dml.elements['txtTituNoti'].focus();
				return false;
			}

			// extraxto
			if (dml.elements['txtExtrNoti'].value.length==0)
			{
				alert ('No ha ingresado el EXTRACTO.');
				dml.elements['txtExtrNoti'].focus();
				return false;
			}

			if (parECodiNoti == "")
			{
				// foto 1
				if (dml.elements['txtFotoPequ'].value.length==0)
				{
					alert ('No ha ingresado la FOTO pequenia.');
					dml.elements['txtFotoPequ'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoPequ'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

				// foto 2
				if (dml.elements['txtFotoGran'].value.length==0)
				{
					alert ('No ha ingresado la FOTO grande');
					dml.elements['txtFotoGran'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoGran'].value;
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
				if (dml.elements['txtFotoPequ'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoPequ'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

				// foto 2
				if (dml.elements['txtFotoGran'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoGran'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

			}

			// alt foto pequenia
			if (dml.elements['txtAltfPequ'].value.length==0)
			{
				alert ('No ha ingresado el ALT de la foto pequenia');
				dml.elements['txtAltfPequ'].focus();
				return false;
			}

			// alt foto grande
			if (dml.elements['txtAltfGran'].value.length==0)
			{
				alert ('No ha ingresado el ALT de la foto grande');
				dml.elements['txtAltfGran'].focus();
				return false;
			}

			// estado
			if (dml.elements['cboEstaNoti'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaNoti'].focus();
				return false;
			}

			// texto
			//if (tinyMCE.get('txtTextNoti').getContent()=="")
			//{
			//	alert ('No ha ingresado el TEXTO');
			//	dml.elements['txtTextNoti'].focus();
			//	return false;
			//}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_noti.php";
			return false;
		}

	-->
	</script>

	<!-- TinyMCE -->
	<script type="text/javascript" src="./tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			// General options
			mode : "exact",
			elements : "txtTextNoti",
			theme : "advanced",
			plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,forecolor,|,styleselect",
						theme_advanced_buttons2 : "link,unlink,tablecontrols,code,|,image,media",
						theme_advanced_buttons3 : "",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "",
						extended_valid_elements : "a[class|name|href|target|title|onclick],img[style|class|src|border|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],embed[quality|type|pluginspage|width|height|src|align|wmode]",

			// Example content CSS (should be your site CSS)
			content_css : "./../css/lista.css"	

		});
	</script>
	<!-- /TinyMCE -->

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtTituNoti'].focus();">
<form action="./exe_noti.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiNoti = trim($_GET["txtCodiNoti"]);
	$varTituNoti = "";
	$varFotoPequ = "";
	$varFotoGran = "";
	$varTextNoti = "";
	$varExtrNoti = "";
	$varEstaNoti = "";
	$varAltfPequ = "";
	$varAltfGran = "";

	// Hace la consulta si es necesario
	if ($varCodiNoti != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_noticia where COD_NOTICIA=$varCodiNoti");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varTituNoti = trim($results["TIT_NOTICIA"][0]);
			$varFotoPequ = trim($results["FOT_PEQUNOTICIA"][0]);
			$varFotoGran = trim($results["FOT_GRANNOTICIA"][0]);
			$varTextNoti = trim($results["TEX_NOTICIA"][0]);
			$varEstaNoti = trim($results["PUB_NOTICIA"][0]);
			$varAltfPequ = trim($results["ALT_PEQUNOTICIA"][0]);
			$varAltfGran = trim($results["ALT_GRANNOTICIA"][0]);
			$varExtrNoti = trim($results["EST_NOTICIA"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido estado
		if ($varEstaNoti == "A")
		{
			$varEstaNotiSeleNada = "";
			$varEstaNotiSeleActi = "selected";
			$varEstaNotiSeleInac = "";
		}
		elseif ($varEstaNoti == "I")
		{
			$varEstaNotiSeleNada = "";
			$varEstaNotiSeleActi = "";
			$varEstaNotiSeleInac = "selected";
		}
		else
		{
			$varEstaNotiSeleNada = "selected";
			$varEstaNotiSeleActi = "";
			$varEstaNotiSeleInac = "";
		}
	}

	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiNoti\" value=\"$varCodiNoti\">";
?>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="9" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Titulo : &nbsp;</td>
			<td><input type="text" name="txtTituNoti" value="<?= $varTituNoti ?>" maxlength="120" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Extracto : &nbsp;</td>
			<td><?= funImprimeCampoArea ("txtExtrNoti", "10", "2", $varExtrNoti, "N", "N", "textbox", "width:389px;", "", "", "") ?></td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Peque&ntilde;a : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotoPequ" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Grande : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotoGran" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto Peque&ntilde;a : &nbsp;</td>
			<td><input type="text" name="txtAltfPequ" value="<?= $varAltfPequ ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto Grande : &nbsp;</td>
			<td><input type="text" name="txtAltfGran" value="<?= $varAltfGran ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select name="cboEstaNoti" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaNotiSeleNada?>> ...
					<option value="A" <?=$varEstaNotiSeleActi?>> Activo
					<option value="I" <?=$varEstaNotiSeleInac?>> Inactivo
				</select>				
			</td>
		</tr>
		<tr>
			<td colspan="2"><?= funImprimeCampoArea ("txtTextNoti", "40", "13", $varTextNoti, "N", "N", "textbox", "width:613px;height:180px;", "", "", "") ?></td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- separacion -->
<br style="line-height:3px;">

<!-- comandos -->
<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	<? if ($varCodiNoti == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiNoti?>');">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiNoti?>');">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar la Noticia');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>