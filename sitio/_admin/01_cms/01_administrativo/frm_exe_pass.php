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
			// Password Actual
			if (dml.elements['txtPassUsua'].value.length==0)
			{
				alert ('No ha ingresado la CONTRASEÑA actual.');
				dml.elements['txtPassUsua'].focus();
				return false;
			}

			// Nuevo Password
			if (dml.elements['txtPassUsuaNuev'].value.length==0)
			{
				alert ('No ha ingresado la nueva CONTRASEÑA.');
				dml.elements['txtPassUsuaNuev'].focus();
				return false;
			}

			// Confirmacion Password
			if (dml.elements['txtPassUsuaConf'].value.length==0)
			{
				alert ('No ha ingresado la CONFIRMACIÓN de la nueva CONTRASEÑA.');
				dml.elements['txtPassUsuaConf'].focus();
				return false;
			}

			// Password Nuevo = Confirmacion
			if (dml.elements['txtPassUsuaNuev'].value!=dml.elements['txtPassUsuaConf'].value)
			{
				alert ('La CONTRASEÑA nueva y su CONFIRMACIÓN no son iguales.');
				dml.elements['txtPassUsuaConf'].focus();
				return false;
			}

			// Password Nuevo != Password Actual
			if (dml.elements['txtPassUsuaNuev'].value==dml.elements['txtPassUsua'].value)
			{
				alert ('La CONTRASEÑA actual y la NUEVA deben ser distintas.');
				dml.elements['txtPassUsuaNuev'].focus();
				return false;
			}
			
			return true;
		}

	-->
	</script>

</head>
<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtPassUsua'].focus();">
<form action="./frm_exe_pass.php"  method="post">

<center>

<? 
	// Verifico si viene de la misma página o es la primera vez que ingresa
	$varComando = trim($_POST["cmdComando"]);
	if ($varComando == "Actualizar")
	{
		// Se conecta al Servidor y la Base de Datos
		funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

		// Recupero el nombre de Usuario y lo guardo en la variable
		$varUserUsua = $_SESSION['User_User'];

		// Recupero las contraseñas enviada del formulario
		$varPassUsua = trim($_POST["txtPassUsua"]);
		$varPassUsuaNuev =trim($_POST["txtPassUsuaNuev"]);

		// Encripta las contraseñas
		//$varPassUsuaEncr = base64_encode($varPassUsua);
		//$varPassUsuaEncrNuev = base64_encode($varPassUsuaNuev);
		
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select PAS_USUARIO from " . $aplPrefClie . "_ref_usuario where USR_USUARIO='$varUserUsua' and PAS_USUARIO='$varPassUsua'");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) 
		{
			$execute = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_usuario set PAS_USUARIO='$varPassUsuaNuev' where USR_USUARIO='$varUserUsua'");
			funLevantaAlert ("La CONTRASEÑA fue actualizada exitosamente.");
		}
		else
		{
			funLevantaAlert ("La CONTRASEÑA no fue actualizada; la CONTRASEÑA ACTUAL ingresada, no es correcta.");
		}
		funLiberaRecordset ($recordset);
	}
?>

<!-- titulo -->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td><img src="../images/cms_titulo_esquina1.png" width="19" height="37" border=0 alt=""></td>
	<td class="titusecc" style="padding-bottom:7px;" background="../images/cms_titulo_fondo.png" width="100%"><img src="../images/cms_titulo_bullet.gif" width="18" height="3" border=0 alt="">Password</td>
	<td><img src="../images/cms_titulo_esquina2.png" width="18" height="37" border=0 alt=""></td>
</tr>
<tr>
	<td colspan="3"><img src="../images/blank.gif" width="5" height="10"></td>
</tr>
</table>

<!-- marco principal -->
<table width="560" height="100" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">		
		<tr>
			<td class="label" align="right">Password Actual : &nbsp;</td>
			<td colspan="3"><input type="password" name="txtPassUsua" value="" maxlength="15" style="width:120px;" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>		
		</tr>		
		<tr>
			<td class="label" align="right">Nuevo Password : &nbsp;</td>
			<td colspan="3"><input type="password" name="txtPassUsuaNuev" value="" maxlength="15" style="width:120px" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
		</tr>		
		<tr>
			<td class="label" align="right">Confirmar Password : &nbsp;</td>
			<td colspan="3"><input type="password" name="txtPassUsuaConf" value="" maxlength="15" style="width:120px;" class="textbox" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
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
<table width="560" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	
		<input type=submit name=cmdComando value="Actualizar" style="width:110px;font-size:12px;" onClick="return funValidaDatos(document.forms[0]);">&nbsp;&nbsp;
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>