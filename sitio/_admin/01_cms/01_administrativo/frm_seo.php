<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "../_funciones/parametros.php";
	require "../_funciones/secure.php";
	require "../_funciones/funciones.php";
	require "../_funciones/database_$aplDataBaseLibrary.php";

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
			if (dml.elements['txtTituSeo'].value.length==0)
			{
				alert ('No ha ingresado el TITULO');
				dml.elements['txtTituSeo'].focus();
				return false;
			}

			// keywords
			if (dml.elements['txtKeywSeo'].value.length==0)
			{
				alert ('No ha ingresado las KEYWORDS');
				dml.elements['txtKeywSeo'].focus();
				return false;
			}

			// description
			if (dml.elements['txtDescSeo'].value.length==0)
			{
				alert ('No ha ingresado la DESCRIPCION');
				dml.elements['txtDescSeo'].focus();
				return false;
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_seo.php";
			return false;
		}

	-->
	</script>	

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">
<form action="./exe_seo.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Inicializa las $variables
	$varCodiSecc = trim($_GET["txtCodiSecc"]);
	$varSeccSeo = "";
	$varTituSeo = "";
	$varKeywSeo = "";
	$varDescSeo = "";
	

	// Hace la consulta si es necesario
	if ($varCodiSecc != "")
	{
		// Datos del Registro
		$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_seo where COD_SECCION=$varCodiSecc");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0)
		{
			$varTituSeo = trim($results["TIT_SEO"][0]);
			$varKeywSeo = trim($results["KEY_SEO"][0]);
			$varDescSeo = trim($results["DES_SEO"][0]);
		}
		funLiberaRecordset ($recordset);

		// obtengo el nombre de la seccion
		if ($varCodiSecc == "-1")
		{
			$varSeccSeo = "HOME";
		}
		elseif ($varCodiSecc == "-2")
		{
			$varSeccSeo = "ZONA KFC";
		}
		elseif ($varCodiSecc == "-3")
		{
			$varSeccSeo = "PROMOCIONES";
		}
		elseif ($varCodiSecc == "-4")
		{
			$varSeccSeo = "TRABAJA CON NOSOTROS";
		}
		elseif ($varCodiSecc == "-5")
		{
			$varSeccSeo = "MENU";
		}
		elseif ($varCodiSecc == "-6")
		{
			$varSeccSeo = "RESTAURANTES";
		}
		elseif ($varCodiSecc == "-7")
		{
			$varSeccSeo = "MAPA DEL SITIO";
		}
		elseif ($varCodiSecc == "-8")
		{
			$varSeccSeo = "NOTICIAS";
		}
		elseif ($varCodiSecc == "-9")
		{
			$varSeccSeo = "BUSCADOR";
		}
		elseif ($varCodiSecc == "-10")
		{
			$varSeccSeo = "REGISTRO CLIENTES";
		}
		elseif ($varSeccSeo == "")
		{
			$recordset = funEjecutaQuerySelect ("select * from ".$aplPrefClie."_dat_infoseccion where COD_SECCION=$varCodiSecc");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0)
			{
				$varSeccSeo = trim($results["NOM_SECCION"][0]);
			}
			else
			{
				$varSeccSeo = "--";
			}
			funLiberaRecordset ($recordset);
		}
		else
		{
			$varSeccSeo = "--";
		}


	}

	print "<input type=\"hidden\" name=\"txtCodiSecc\" value=\"$varCodiSecc\">";
?>

<!-- marco principal -->
<table width="95%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Seccion : &nbsp;</td>
			<td><input type="text" name="txtSeccSeo" value="<?= $varSeccSeo ?>" maxlength="120" style="width:385px;" class="textboxread" readonly></td>
		</tr>
		<tr>
			<td class="label" align="right">Título : &nbsp;</td>
			<td><input type="text" name="txtTituSeo" value="<?= $varTituSeo ?>" maxlength="120" style="width:385px;" class="textbox"></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Keywords : &nbsp;</td>
			<td><textarea name="txtKeywSeo" maxlength="255" rows=10 style="width:385px;" class="textbox"><?=$varKeywSeo?></textarea></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Descripcion : &nbsp;</td>
			<td><textarea name="txtDescSeo" maxlength="255" rows=10 style="width:385px;" class="textbox"><?=$varDescSeo?></textarea></td>
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
	<? if ($varCodiSecc == "") { ?>
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