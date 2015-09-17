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
			// registro inicio
			if (dml.elements['txtRegiInic'].value.length==0)
			{
				alert ('No ha ingresado el REGISTRO DE INCIO.');
				dml.elements['txtRegiInic'].focus();
				return false;
			}

			// registro fin
			if (dml.elements['txtRegiFina'].value.length==0)
			{
				alert ('No ha ingresado el REGISTRO DE FIN.');
				dml.elements['txtRegiFina'].focus();
				return false;
			}

			// Valida que los rangos sean coherentes
			varRegiInic = parseFloat(dml.txtRegiInic.value);
			varRegiFina = parseFloat(dml.txtRegiFina.value);
			if (varRegiInic > varRegiFina)
			{
				alert ('El REGISTRO DE INICIO debe ser menor al REGISTRO DE FIN.');
				dml.elements['txtRegiInic'].focus();
				return false;
			}			

			return true;
		}

	-->
	</script>

</head>
<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
<form action="./exe_arch.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<?
	// Se conecta al Servidor y la Base de Datos	
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);
	
	// inicializa las variables
	$varRegiInic = 1;
	$varRegiFina = $aplNumeRegiPagi;
	
	$recordset = funEjecutaQuerySelect ("select COD_ARCHIVO from " . $aplPrefClie . "_dat_archivo");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0)
	{
		if ($nr<$aplNumeRegiPagi) $varRegiFina = $nr;
	}
	else
	{
		$varRegiInic = 0;
		$varRegiFina = 0;
	}
	funLiberaRecordset ($recordset);
?>

<!-- Formulario Principal -->
<table cellpadding="4" cellspacing="1" border="0" width="100%" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="0" cellspacing="1" border="0" width="100%">		
		<tr>			
			<td class="label" align="center" colspan="2"><b><?=$nr?></b>&nbsp;&nbsp;Registros Totales</td>
		</tr>
		<tr>
			<td class="label" align="right" nowrap>Iniciar en el : &nbsp;</td>
			<td class="label"><input type="text" name="txtRegiInic" value="<?=$varRegiInic?>" maxlength="4" style="width:35px;text-align:right;" class="textboxucase" onKeyPress="if (((event.keyCode<48)||(event.keyCode>57))&&(event.keyCode!=45)) event.returnValue=false;">&nbsp;&nbsp;al : &nbsp;<input type="text" name="txtRegiFina" value="<?=$varRegiFina?>" maxlength="4" style="width:35px;text-align:right;" class="textboxucase" onKeyPress="if (((event.keyCode<48)||(event.keyCode>57))&&(event.keyCode!=45)) event.returnValue=false;">&nbsp;&nbsp;&nbsp;<input type=submit name="cmdComando" value="Listar" style="height:20px;width:50px;font-size:10px;" onClick="return funValidaDatos(document.forms[0]);"></td>
		</tr>		
		</table>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>