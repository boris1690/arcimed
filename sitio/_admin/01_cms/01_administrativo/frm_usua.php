<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "../_funciones/parametros.php";
	require "../_funciones/secure.php";
	require "../_funciones/database_$aplDataBaseLibrary.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();

	// verifico si la sesion de usuario esta activa y si no lo está redirecciono al fin
	if (!$_SESSION['User_Permit_Access']) header("Location: " . $aplAplicationURL . "mantenimiento/cgiClose.php");
?>

<html>
<head>
	<title><?=$aplNombApli;?></title>
	<script language="javascript" src="../_funciones/funciones.js"></script>
	<script language="javascript" src="../_funciones/images.js"></script>
	<link rel="stylesheet" href="../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 

		function funValidaDatos(dml)
		{
			// Nombre
			if (dml.elements['txtNombUsua'].value.length==0)
			{
				alert ('<?=$aplMensNombUsua;?>');
				dml.elements['txtNombUsua'].focus();
				return false;
			}

			// Perfil
			if (dml.elements['cboCodiPerf'].options.length==0)
			{
				alert ('<?=$aplMensCodiPerf;?>');
				dml.elements['cboCodiPerf'].focus();
				return false;
			}

			// User
			if (dml.elements['txtUserUsua'].value.length==0)
			{
				alert ('<?=$aplMensUserUsua;?>');
				dml.elements['txtUserUsua'].focus();
				return false;
			}

			// Password
			if (dml.elements['txtPassUsua'].value.length==0)
			{
				alert ('<?=$aplMensContUsua;?>');
				dml.elements['txtPassUsua'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_usua.php";
			return false;
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" >
<form action="./exe_usua.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiPerf = "";
	$varUserUsua = trim($_GET["txtUserUsua"]);
	$varNombUsua = "";
	$varPassUsua = "";
	$varLogeUsua = "";

	// Hace la consulta si es necesario
	if ($varUserUsua != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_usuario where USR_USUARIO='$varUserUsua'");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) 
		{
			$varCodiPerf = trim($results["COD_PERFIL"][0]);
			$varNombUsua = trim($results["NOM_USUARIO"][0]);
			//$varPassUsua = base64_decode(trim($results["PAS_USUARIO"][0]));
			$varPassUsua = trim($results["PAS_USUARIO"][0]);
			$varLogeUsua = trim($results["LOG_USUARIO"][0]);
		}
		funLiberaRecordset ($recordset);
	}
?>

<table width="95%" height="100" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td colspan="3"><input type="text" name="txtNombUsua" value="<?= $varNombUsua ?>" maxlength="120" style="width:320px;" class="textboxucase" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
		</tr>
		<tr>
			<td class="label" align="right">Perfil : &nbsp;</td>
			<td colspan="3">
				<select name="cboCodiPerf" style="width:320px;" class="textbox">
				<?
					if ($aplUsuaAdmi == "S")
						$recordset = funEjecutaQuerySelect ("select COD_PERFIL, NOM_PERFIL from ".$aplPrefClie."_ref_perfil order by NOM_PERFIL");
					else
						$recordset = funEjecutaQuerySelect ("select COD_PERFIL, NOM_PERFIL from ".$aplPrefClie."_ref_perfil where COD_PERFIL<>0 order by NOM_PERFIL");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
						if (trim($varCodiPerf) == trim($results["COD_PERFIL"][$varI]))
							print "		<option value=\"" . $results["COD_PERFIL"][$varI] . "\" selected> " . trim($results["NOM_PERFIL"][$varI]);
						else
							print "		<option value=\"" . $results["COD_PERFIL"][$varI] . "\"> " . trim($results["NOM_PERFIL"][$varI]);
					}
					funLiberaRecordset ($recordset);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Username : &nbsp;</td>
			<? if ($varUserUsua != "") { ?>
				<td><input type="text" name="txtUserUsua" value="<?= $varUserUsua ?>" maxlength="15" style="width:120px;" readonly class="textboxread" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
			<? } else { ?>
				<td><input type="text" name="txtUserUsua" value="<?= $varUserUsua ?>" maxlength="15" style="width:120px;" class="textboxlcase" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
			<? } ?>
			<td class="label" align="right">Password : &nbsp;</td>
			<td><input type="password" name="txtPassUsua" value="<?= $varPassUsua ?>" maxlength="15" style="width:118px;" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
		</tr>
		<tr>
			<td class="label" align="right">Logeado : &nbsp;</td>
			<td colspan="3">
				<select name="cboLogeUsua" style="width:118px;" class="textbox">
				<?
					if ($varLogeUsua == "S")
					{
						print "		<option value=\"N\"> NO";
						print "		<option value=\"S\" selected> SI";
					}
					else
					{
						print "		<option value=\"N\" selected> NO";
						print "		<option value=\"S\"> SI";
					}
				?>
				</select>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<!-- separacion -->
<table cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="../graficos/blank.gif" width="2" height="7" border=0 alt=""></td></tr>
</table>

<table width="95%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	<? if ($varUserUsua == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('<?=$aplBorrUsuaMens;?>');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>