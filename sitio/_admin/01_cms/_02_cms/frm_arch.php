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
			// Nombre
			if (dml.elements['txtNombArch'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE del archivo');
				dml.elements['txtNombArch'].focus();
				return false;
			}

			// Archivo
			if (dml.elements['txtArchArch'].value.length==0)
			{
				alert ('No ha ingresado el ARCHIVO');
				dml.elements['txtArchArch'].focus();
				return false;
			}
			else
			{
				varValoCamp = dml.elements['txtArchArch'].value;
				varExteArch = varValoCamp.substring(varValoCamp.length-3,varValoCamp.length).toUpperCase();
				if ((varExteArch == "ASP")||(varExteArch == "PHP")||(varExteArch == "JSP")||(varExteArch == "EXE")||(varExteArch == "BAT")||(varExteArch == "COM"))
				{
					alert ('El TIPO DE ARCHIVO SELECCIONADO no está permitido.');
					return false;
				}
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_arch.php";
			return false;
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtNombArch'].focus();">
<form action="./exe_arch.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiArch = trim($_GET["txtCodiArch"]);
	$varNombArch = "";
	$varFileArch = "";

	// Hace la consulta si es necesario
	if ($varCodiArch != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_archivo where COD_ARCHIVO=$varCodiArch");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varNombArch = trim($results["NOM_ARCHIVO"][0]);
			$varFileArch = trim($results["FIL_ARCHIVO"][0]);
		}
		funLiberaRecordset ($recordset);
	}

	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiArch\" value=\"$varCodiArch\">";
?>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td><input type="text" name="txtNombArch" value="<?= $varNombArch ?>" maxlength="60" style="width:290px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Archivo : &nbsp;</td>
			<td class="label"><input type="file" name="txtArchArch" value="" maxlength="60" style="width:289px;" class="textbox">&nbsp(<?=$varMaxiFileSize?> MB)</td>
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
	<? if ($varCodiArch == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar el Archivo?');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>