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
			if (dml.elements['txtNombZona'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE.');
				dml.elements['txtNombZona'].focus();
				return false;
			}

			// texto
			if (dml.elements['txtVideZona'].value.length==0)
			{
				alert ('No ha ingresado el LINK del video');
				dml.elements['txtVideZona'].focus();
				return false;
			}

			// estado
			if (dml.elements['cboEstaZona'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaZona'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_zona.php";
			return false;
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtNombZona'].focus();">
<form action="./exe_zona.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiZona = trim($_GET["txtCodiZona"]);
	$varNombZona = "";
	$varVideZona = "";
	$varEstaZona = "";

	// Hace la consulta si es necesario
	if ($varCodiZona != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_zonakfc where COD_ZONA=$varCodiZona");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varNombZona = trim($results["NOM_ZONA"][0]);
			$varVideZona = trim($results["VID_ZONA"][0]);
			$varEstaZona = trim($results["EST_ZONA"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido estado
		if ($varEstaZona == "A")
		{
			$varEstaZonaSeleNada = "";
			$varEstaZonaSeleActi = "selected";
			$varEstaZonaSeleInac = "";
		}
		elseif ($varEstaZona == "I")
		{
			$varEstaZonaSeleNada = "";
			$varEstaZonaSeleActi = "";
			$varEstaZonaSeleInac = "selected";
		}
		else
		{
			$varEstaZonaSeleNada = "selected";
			$varEstaZonaSeleActi = "";
			$varEstaZonaSeleInac = "";
		}
	}

	print "<input type=\"hidden\" name=\"txtCodiZona\" value=\"$varCodiZona\">";
?>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td><input type="text" name="txtNombZona" value="<?= $varNombZona ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Link Video : &nbsp;</td>
			<td><?= funImprimeCampoArea ("txtVideZona", "40", "9", $varVideZona, "N", "N", "textbox", "width:389px;", "", "", "") ?></td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select name="cboEstaZona" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaZonaSeleNada?>> ...
					<option value="A" <?=$varEstaZonaSeleActi?>> Activo
					<option value="I" <?=$varEstaZonaSeleInac?>> Inactivo
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
	<? if ($varCodiZona == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar el Video de la Zona KFC?');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>