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

		function funValidaDatos(dml)
		{
			// titulo
			if (dml.elements['txtTituInfo'].value.length==0)
			{
				alert ('No ha ingresado el TITULO');
				dml.elements['txtTituInfo'].focus();
				return false;
			}

			// frase
			if (dml.elements['txtFrasInfo'].value.length==0)
			{
				alert ('No ha ingresado la FRASE');
				dml.elements['txtFrasInfo'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_cont.php";
			return false;
		}

	-->
	</script>	

	<script language="JavaScript">
	<!--

		function levantaImagenes()
		{	
			// ubica y visualiza la ventana de enlaces (FF)
			parent.document.getElementById('layImagenes').style.visibility = "visible";
		}

	-->
	</script>

	<!-- TinyMCE -->
	<script type="text/javascript" src="./tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			// General options
			mode : "exact",
			elements : "txtTextInfo",
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

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
<form action="./exe_cont.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiInfo = trim($_GET["txtCodiInfo"]);
	$varTituInfo = "";
	$varSeleFotoInfo = "";
	$varSeleVideInfo = "";
	$varVideInfo = "";
	$varFrasInfo = "";
	$varTextInfo = "";

	// Hace la consulta si es necesario
	if ($varCodiInfo != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_infoseccion where COD_SECCION=$varCodiInfo");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varTituInfo = trim($results["NOM_SECCION"][0]);
			$varFrasInfo = trim($results["FRA_SECCION"][0]);
			$varTextInfo = trim($results["TEX_SECCION"][0]);
			$varFotoInfo = trim($results["FOT_SECCION"][0]);
			$varAltfInfo = trim($results["ALT_SECCION"][0]);
			$varVideInfo = trim($results["VID_SECCION"][0]);

		}
		funLiberaRecordset ($recordset);

	}

	print "<input type=\"hidden\" name=\"txtCodiInfo\" value=\"$varCodiInfo\">";
?>

<!-- marco principal -->
<table width="95%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Título : &nbsp;</td>
			<td><input type="text" name="txtTituInfo" value="<?= $varTituInfo ?>" maxlength="120" style="width:385px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Foto : &nbsp;</td>
			<td><input type="file" name="txtFotoInfo" value="" maxlength="120" style="width:385px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto : &nbsp;</td>
			<td><input type="textbox" name="txtAltfInfo" value="<?=$varAltfInfo?>" maxlength="120" style="width:385px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Video : &nbsp;</td>
			<td valign="top"><textarea name="txtVideInfo" maxlength="120" style="width:385px;" class="textbox"><?=$varVideInfo?></textarea></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Frase : &nbsp;</td>
			<td>
				<table border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td valign="top">
						<textarea name="txtFrasInfo" maxlength="120" style="width:385px;" class="textbox"><?=$varFrasInfo?></textarea>
					</td>
					<td><img src="./../images/blank.gif" width=4 height=5></td>
					<td><a href="#" onClick="levantaImagenes(); return false;"><img src="../images/ic_images.gif" width="20" height="18" border=0 alt="Archivo de Imágenes"></a></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><textarea name="txtTextInfo" style="width:613px;height:215px;" class="textbox"><?= $varTextInfo ?></textarea></td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- separacion -->
<table cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="../images/blank.gif" width="2" height="7" border=0 alt=""></td></tr>
</table>

<table width="95%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	<? if ($varCodiInfo == "") { ?>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>