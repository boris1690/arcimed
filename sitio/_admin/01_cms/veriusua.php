<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../../_funciones/parametros.php";
	require "./../../_funciones/secure.php";
	require "./../../_funciones/database_$aplDataBaseLibrary.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();
?>

<html>
<head>
	<script language="JavaScript">
	<!--
		function funEjecutaResultadoVerificacion(parECaso,parETipoVent)
		{
			switch (parECaso)
			{
				// Usuario validado
				case '0':
					parent.document.forms[0].txtUserUsua.value = "";
					parent.document.forms[0].txtPassUsua.value = "";
					if (parETipoVent == "popup")
					{
						funLevantaPopUp ('mant','./sistema_frame.php','no','no','900','750','','');
						document.location = './nada.php?txtBGColor=ffffff'
					}
					else
						parent.location = './sistema_frame.php';
					break;
				// Mala contraseña
				case '1':
					alert ('<?=$aplPassMens;?>');
					parent.document.forms[0].txtPassUsua.focus();
					parent.document.forms[0].txtPassUsua.select();
					break;
				// Logeo simultaneo
				case '2':
					alert ('<?=$aplLogeMens;?>');
					parent.document.forms[0].txtUserUsua.focus();
					parent.document.forms[0].txtUserUsua.select();
					break;
				// No Existe el usuario
				case '3':
					alert ('<?=$aplUsuaMens;?>');
					parent.document.forms[0].txtUserUsua.focus();
					parent.document.forms[0].txtUserUsua.select();
					break;
			}
		}
	-->
	</script>

</head>
<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<?
	// Se conecta al Servidor y la Base de Datos
	//funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Recupero los datos
	$varUserUsua = $_POST["txtUserUsua"];
	$varPassUsua = $_POST["txtPassUsua"];
	//$varPassUsua = base64_encode($_POST["txtPassUsua"]);

	// Valido el usuario
	/*$recordset = funEjecutaQuerySelect ("select COD_PERFIL, USR_USUARIO, PAS_USUARIO, NOM_USUARIO, LOG_USUARIO from " . $aplPrefClie . "_ref_usuario where USR_USUARIO='$varUserUsua'");
	$nr = funDevuelveArregloRecordset ($recordset,$results);

	// Si existe el usuario
	if ($nr>0)
	{
		// valido contraseña
		if (trim($results["PAS_USUARIO"][0]) != $varPassUsua)
		{
			$varIndiResu = "1";
			$_SESSION['Perf_User'] = "";
			$_SESSION['User_User'] = "";
			$_SESSION['Nomb_User'] = "";
			$_SESSION['User_Permit_Access'] = false;                        
		}
		// valido logeo simultaneo
		else if (($aplLogeCont == "S")&&(trim($results["LOG_USUARIO"][0]) == "S"))
		{
			$varIndiResu = "2";
			$_SESSION['Perf_User'] = trim($results["COD_PERFIL"][0]);
			$_SESSION['User_User'] = trim($results["USR_USUARIO"][0]);
			$_SESSION['Nomb_User'] = trim($results["NOM_USUARIO"][0]);
			$_SESSION['User_Permit_Access'] = true;
		}
		else
		{
			$varIndiResu = "0";
			$_SESSION['Perf_User'] = trim($results["COD_PERFIL"][0]);
			$_SESSION['User_User'] = trim($results["USR_USUARIO"][0]);
			$_SESSION['Nomb_User'] = trim($results["NOM_USUARIO"][0]);
			$_SESSION['User_Permit_Access'] = true;
			// logeo al usuario
			$recordset = funEjecutaQueryEdit ("update " . $aplPrefClie . "_ref_usuario set LOG_USUARIO='S' where USR_USUARIO='" . $_SESSION['User_User'] . "'");
		}
	}
	// no existe el usuario
	else
	{
		$varIndiResu = "3";
		$_SESSION['Perf_User'] = "";
		$_SESSION['User_User'] = "";
		$_SESSION['Nomb_User'] = "";
		$_SESSION['User_Permit_Access'] = false;
	}
	*/

	

	if($varUserUsua== "administrador" && $varPassUsua=="administrador")
	{
		$_SESSION['User_Permit_Access'] = true;
		print "<script>parent.location = '../indexmodulos.php';</script>";
	}
	else
	{
		$_SESSION['User_Permit_Access'] = false;
		print "<script>alert('Usuario/contraseña mal ingresados.');</script>";
	}
	
	/*
	// Libero la memoria
	funLiberaRecordset ($recordset);

	// Se desconecta al Servidor y la Base de Datos
	funCloseConectionToDataBase ();
	*/
?>

<script language="JavaScript">
<!--
	// ejecuta el resultado de la verificacion
	//funEjecutaResultadoVerificacion('<?=$varIndiResu;?>','<?=$aplTipVent?>');       
-->
</script>

</body>
</html>