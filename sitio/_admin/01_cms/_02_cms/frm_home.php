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

		function funValidaDatos(dml,parECodiHome)
		{
			// titulo
			if (dml.elements['txtTituHome'].value.length==0)
			{
				alert ('No ha ingresado el TITULO.');
				dml.elements['txtTituHome'].focus();
				return false;
			}

			if (parECodiHome == "")
			{

				// foto 1
				if (dml.elements['txtFotoHome'].value.length==0)
				{
					alert ('No ha ingresado la FOTO para el home.');
					dml.elements['txtFotoHome'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoHome'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

				// foto 2
				if (dml.elements['txtFotoLate'].value.length==0)
				{
					alert ('No ha ingresado la FOTO para el lateral');
					dml.elements['txtFotoLate'].focus();
					return false;
				}
				else
				{
					varValoCamp = dml.elements['txtFotoLate'].value;
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
				if (dml.elements['txtFotoHome'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoHome'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}

				// foto 2
				if (dml.elements['txtFotoLate'].value.length!=0)
				{
					varValoCamp = dml.elements['txtFotoLate'].value;
					varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
					if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
					{
						alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
						return false;
					}
				}
			}

			// alt home
			if (dml.elements['txtAlthHome'].value.length==0)
			{
				alert ('No ha ingresado el ALT para la foto del Home');
				dml.elements['txtAlthHome'].focus();
				return false;
			}

			// alt lateral
			if (dml.elements['txtAltlHome'].value.length==0)
			{
				alert ('No ha ingresado el ALT para la foto Lateral');
				dml.elements['txtAltlHome'].focus();
				return false;
			}

			// posicion
			if (dml.elements['cboPosiHome'].value==-1)
			{
				alert ('No ha seleccionado la POSICION');
				dml.elements['cboPosiHome'].focus();
				return false;
			}

			// texto
			if (dml.elements['txtTextHome'].value.length==0)
			{
				alert ('No ha ingresado el TEXTO');
				dml.elements['txtTextHome'].focus();
				return false;
			}

			if (dml.elements['txtUrlHome'].value.length==0)
			{
				alert ('No ha ingresado el URL');
				dml.elements['txtUrlHome'].focus();
				return false;
			}

			// estado
			if (dml.elements['cboEstaHome'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaHome'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_home.php";
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

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtTituHome'].focus();">
<form action="./exe_home.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiHome = trim($_GET["txtCodiHome"]);
	$varTituHome = "";
	$varFotoHome = "";
	$varAlthHome = "";
	$varFotoLate = "";
	$varAltlHome = "";
	$varPosiHome = "";
	$varTextHome = "";
	$varEstaHome = "";

	// Hace la consulta si es necesario
	if ($varCodiHome != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_home where COD_HOME=$varCodiHome");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varTituHome = trim($results["TIT_HOME"][0]);
			$varFotoHome = trim($results["FOT_HOMEHOME"][0]);
			$varAlthHome = trim($results["ALT_HOMEHOME"][0]);
			$varFotoLate = trim($results["FOT_LATEHOME"][0]);
			$varAltlHome = trim($results["ALT_LATEHOME"][0]);
			$varPosiHome = trim($results["POS_HOME"][0]);
			$varTextHome = trim($results["TEX_HOME"][0]);
			$varUrlHome = trim($results["URL_HOME"][0]);
			$varEstaHome = trim($results["EST_HOME"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido posicion
		if ($varPosiHome == "1")
		{
			$varPosiHomeSeleNada = "";
			$varPosiHomeSeleIzqu = "selected";
			$varPosiHomeSeleMedi = "";
			$varPosiHomeSeleDere = "";
		}
		elseif ($varPosiHome == "2")
		{
			$varPosiHomeSeleNada = "";
			$varPosiHomeSeleIzqu = "";
			$varPosiHomeSeleMedi = "selected";
			$varPosiHomeSeleDere = "";
		}
		elseif ($varPosiHome == "3")
		{
			$varPosiHomeSeleNada = "";
			$varPosiHomeSeleIzqu = "";
			$varPosiHomeSeleMedi = "";
			$varPosiHomeSeleDere = "selected";
		}
		else
		{
			$varPosiHomeSeleNada = "selected";
			$varPosiHomeSeleIzqu = "";
			$varPosiHomeSeleMedi = "";
			$varPosiHomeSeleDere = "";
		}

		// valido estado
		if ($varEstaHome == "A")
		{
			$varEstaHomeSeleNada = "";
			$varEstaHomeSeleActi = "selected";
			$varEstaHomeSeleInac = "";
		}
		elseif ($varEstaHome == "I")
		{
			$varEstaHomeSeleNada = "";
			$varEstaHomeSeleActi = "";
			$varEstaHomeSeleInac = "selected";
		}
		else
		{
			$varEstaHomeSeleNada = "selected";
			$varEstaHomeSeleActi = "";
			$varEstaHomeSeleInac = "";
		}
	}

	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiHome\" value=\"$varCodiHome\">";
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
			<td class="label" align="right">Titulo : &nbsp;</td>
			<td><input type="text" name="txtTituHome" value="<?= $varTituHome ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Home : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotoHome" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Foto Lateral : &nbsp;</td>
			<td class="label"><input type="file" name="txtFotoLate" value="" maxlength="60" style="width:389px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto Home : &nbsp;</td>
			<td><input type="text" name="txtAlthHome" value="<?= $varAlthHome ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Alt Foto Lateral : &nbsp;</td>
			<td><input type="text" name="txtAltlHome" value="<?= $varAltlHome ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Posicion : &nbsp;</td>
			<td class="label">
				<select name="cboPosiHome" style="width:389px;" class="textbox">
					<option value="-1" <?=$varPosiHomeSeleNada?>> ...
					<option value="1" <?=$varPosiHomeSeleIzqu?>> Izquierda - Arriba
					<option value="2" <?=$varPosiHomeSeleMedi?>> Medio - Centro
					<option value="3" <?=$varPosiHomeSeleDere?>> Derecha - Abajo
				</select>				
			</td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Texto : &nbsp;</td>
			<td><?= funImprimeCampoArea ("txtTextHome", "40", "12", $varTextHome, "N", "N", "textbox", "width:389px;", "", "", "") ?></td>
		</tr>
		<tr>
			<td class="label" align="right">Url : &nbsp;</td>
			<td class="label">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><input type="text" name="txtUrlHome" value="<?=$varUrlHome?>" style="width:389px;" class="textbox"></td>
					<td>&nbsp;<a href="#" onClick="levantaMenuOpciones('LINK'); return false;"><img src="../images/ic_flecverd.gif" width="12" height="12" border="0" alt="Ver Links Internos"></a></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select name="cboEstaHome" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaHomeSeleNada?>> ...
					<option value="A" <?=$varEstaHomeSeleActi?>> Activo
					<option value="I" <?=$varEstaHomeSeleInac?>> Inactivo
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
	<? if ($varCodiHome == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiHome?>');">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0],'<?=$varCodiHome?>');">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar el Home - Lateral?');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>