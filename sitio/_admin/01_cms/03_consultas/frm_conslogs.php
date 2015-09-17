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
	<title>:: NETLIFE ::</title>
	<script language="javascript" src="./../_funciones/funciones.js"></script>
	<script language="javascript" src="./../_funciones/images.js"></script>	
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 

		function funValidaDatos(dml)
		{
			// Fecha Inicio
			if ((dml.txtFechDesdDia.value.length==0)||(dml.txtFechDesdMes.value.length==0)||(dml.txtFechDesdAnio.value.length==0))
			{
				alert ('La FECHA DE INICIO está mal ingresada.');
				dml.elements['txtFechDesdDia'].focus();
				return false;
			}

			// Fecha Fin
			if ((dml.txtFechHastDia.value.length==0)||(dml.txtFechHastMes.value.length==0)||(dml.txtFechHastAnio.value.length==0))
			{
				alert ('La FECHA DE FIN está mal ingresada.');
				dml.elements['txtFechHastDia'].focus();
				return false;
			}

			// Fecha de Inicio menor a Fecha de Fin
			var_DiaFechInic = parseFloat(dml.txtFechDesdDia.value);
			var_MesFechInic = parseFloat(dml.txtFechDesdMes.value);
			varAnioFechInic = parseFloat(dml.txtFechDesdAnio.value);
			var_DiaFechFina = parseFloat(dml.txtFechHastDia.value);
			var_MesFechFina = parseFloat(dml.txtFechHastMes.value);
			varAnioFechFina = parseFloat(dml.txtFechHastAnio.value);				
			if ((varAnioFechFina<varAnioFechInic)||((varAnioFechFina==varAnioFechInic)&&(var_MesFechFina<var_MesFechInic))||((varAnioFechFina==varAnioFechInic)&&(var_MesFechFina==var_MesFechInic)&&(var_DiaFechFina<=var_DiaFechInic)))
			{
				alert ('La FECHA DE FIN debe ser posterior a la FECHA DE INICIO.');
				dml.elements['txtFechHastDia'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			parent.document.location = "./fra_conslogs.php";
			return false;
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['cboCodiPerf'].focus();">
<form action="./exe_conslogs.php" target="ejec" method="post" >

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	$varFechDesd = "2008-01-01";
	$varFechHast = date('Y-m-d');
?>

<!-- marco principal -->
<table width="70%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Usuario : &nbsp;</td>
			<td colspan="3">
				<select name="cboCodiPerf" style="width:350px;" class="textbox">
				<?
					if ($aplUsuaAdmi == "S")
						$recordset = funEjecutaQuerySelect ("select NOM_USUARIO, USR_USUARIO from ".$aplPrefClie."_ref_usuario order by NOM_USUARIO");
					else
						$recordset = funEjecutaQuerySelect ("select NOM_USUARIO, USR_USUARIO from ".$aplPrefClie."_ref_usuario where COD_PERFIL<>0 order by NOM_USUARIO");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
						print "		<option value=\"" . $results["USR_USUARIO"][$varI] . "\"> " . trim($results["NOM_USUARIO"][$varI]);
					}
					funLiberaRecordset ($recordset);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Desde : &nbsp;</td>
			<td class="label"><?= funImprimeCampoFecha ("txtFechDesd",$varFechDesd,"S","N","textbox","dma",""); ?>(dd/mm/aaaa)</td>				
		</tr>
		<tr>
			<td class="label" align="right">Hasta : &nbsp;</td>
			<td class="label"><?= funImprimeCampoFecha ("txtFechHast",$varFechHast,"S","N","textbox","dma",""); ?>(dd/mm/aaaa)</td>				
		</tr>
		<tr><td colspan="2"><img src="./../images/blank.gif" width=4 height=2></td></tr>
		<tr>
			<td align="center" colspan="2">
				<input type=submit name=cmdComando value="Buscar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
				<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">	
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

</form>
</body>
</html>