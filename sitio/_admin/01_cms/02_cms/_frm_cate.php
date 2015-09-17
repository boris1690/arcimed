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

		function funValidaDatos(dml)
		{
			// titulo
			if (dml.elements['txtNombCate'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE.');
				dml.elements['txtNombCate'].focus();
				return false;
			}

			// estado
			if (dml.elements['cboEstaCate'].value=="X")
			{
				alert ('No ha seleccionado el ESTADO');
				dml.elements['cboEstaCate'].focus();
				return false;
			}

			//ciudad
			if (dml.elements['cboCiudCate'].value=="X")
			{
				alert ('No ha seleccionado una CIUDAD');
				dml.elements['cboCiudCate'].focus();
				return false;
			}
			
			return true;
			
			
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_cate.php";
			return false;
		}

	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtNombCate'].focus();">
<form action="./exe_cate.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiCate = trim($_GET["txtCodiCate"]);
	$varNombCate = "";
	$varEstaCate = "";

	// Hace la consulta si es necesario
	if ($varCodiCate != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_categoria where COD_CATEGORIA=$varCodiCate");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varNombCate = trim($results["NOM_CATEGORIA"][0]);
			$varEstaCate = trim($results["EST_CATEGORIA"][0]);
			$varCiudCate = trim($results["COD_CIUDAD"][0]);
		}
		funLiberaRecordset ($recordset);

		// valido estado
		if ($varEstaCate == "A")
		{
			$varEstaCateSeleNada = "";
			$varEstaCateSeleActi = "selected";
			$varEstaCateSeleInac = "";
		}
		elseif ($varEstaCate == "I")
		{
			$varEstaCateSeleNada = "";
			$varEstaCateSeleActi = "";
			$varEstaCateSeleInac = "selected";
		}
		else
		{
			$varEstaCateSeleNada = "selected";
			$varEstaCateSeleActi = "";
			$varEstaCateSeleInac = "";
		}
	}

	// Calcula el maximo tamanio de archivo permitido en MB
	$varMaxiFileSize = $aplMaxiFileSize / (1024*1024);

	print "<input type=\"hidden\" name=\"txtCodiCate\" value=\"$varCodiCate\">";
?>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
         <tr>
			<td class="label" align="right">Ciudad : &nbsp;</td>
			<td class="label">
				<select name="cboCiudCate" style="width:194px;" class="textbox">
					<option value="X" > ...
					<? // recupero informacion SEO
						$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_ref_ciudad where LST_CIUDAD='S'");
						$nr = funDevuelveArregloRecordset ($recordset,$results);
						for ($varI=0;$varI<$nr;$varI++)
						{
							if($varCiudCate == $results['COD_CIUDAD'][$varI])echo "<option value=\"" . $results['COD_CIUDAD'][$varI] . "\" selected> " . $results['NOM_CIUDAD'][$varI];
							else echo "<option value=\"" . $results['COD_CIUDAD'][$varI] . "\" > " . $results['NOM_CIUDAD'][$varI];
							
						}
												
						funLiberaRecordset ($recordset);
					?>
				</select>				
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td><input type="text" name="txtNombCate" value="<?= $varNombCate ?>" maxlength="60" style="width:389px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right">Estado : &nbsp;</td>
			<td class="label">
				<select name="cboEstaCate" style="width:194px;" class="textbox">
					<option value="X" <?=$varEstaCateSeleNada?>> ...
					<option value="A" <?=$varEstaCateSeleActi?>> Activo
					<option value="I" <?=$varEstaCateSeleInac?>> Inactivo
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
	<? if ($varCodiCate == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('Esta seguro que desea eliminar la Categoria');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>