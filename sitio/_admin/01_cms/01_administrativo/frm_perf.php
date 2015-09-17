<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../_funciones/parametros.php";
	require "./../_funciones/secure.php";
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
	<script language="javascript" src="../_funciones/funciones.js"></script>
	<script language="javascript" src="../_funciones/images.js"></script>
	<link rel="stylesheet" href="../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 
		
		function funValidaDatos(dml)
		{
			// Nombre
			if (dml.elements['txtNombPerf'].value.length==0)
			{
				alert ('No ha ingresado el NOMBRE del perfil.');
				dml.elements['txtNombPerf'].focus();
				return false;
			}

			// Opciones
			if (dml.elements['cboListCodiOpci'].value.length==0)
			{
				alert ('No ha seleccionado las OPCIONES del perfil.');
				dml.elements['cboListCodiOpci'].focus();
				return false;
			}
			else
			{
				dml.txtListCodiOpci.value = "";
				for (varI=0;varI<dml.cboListCodiOpci.length;varI++)
				{
					if (dml.cboListCodiOpci.options[varI].selected==true)
					{
						dml.txtListCodiOpci.value = dml.txtListCodiOpci.value + dml.cboListCodiOpci.options[varI].value + ",";
					}
				}
			}

			// Secciones
			if (dml.elements['cboListCodiSecc'].value.length==0)
			{
				alert ('No ha seleccionado las SECCIONES del perfil.');
				dml.elements['cboListCodiSecc'].focus();
				return false;
			}
			else
			{
				dml.txtListCodiSecc.value = "";
				for (varI=0;varI<dml.cboListCodiSecc.length;varI++)
				{
					if (dml.cboListCodiSecc.options[varI].selected==true)
					{
						dml.txtListCodiSecc.value = dml.txtListCodiSecc.value + dml.cboListCodiSecc.options[varI].value + ",";
					}
				}
			}

			return true;
		}

		function funLimpiaDatos()
		{
			// Recargo la pagina
			document.location = "./frm_perf.php";
			return false;
		}
	-->
	</script>

</head>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" >
<form action="./exe_perf.php" target="ejec" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Recupera las variables de sesion
	$varPerfUsua = $_SESSION['Perf_User'];

	// Inicializa las $variables
	$varCodiPerf = trim($_GET["txtCodiPerf"]);
	$varNombPerf = "";
	$varListCodiOpci = ",";
	$varListCodiSecc = ",";

	// Hace la consulta si es necesario
	if ($varCodiPerf != "")
	{
		// datos del registro
		$recordset = funEjecutaQuerySelect ("SELECT * FROM ".$aplPrefClie."_ref_perfil WHERE COD_PERFIL=$varCodiPerf");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) $varNombPerf = trim($results["NOM_PERFIL"][0]);
		funLiberaRecordset ($recordset);

		// opciones del perfil
		$recordset = mysql_query("select COD_OPCIONSISTEMA from " . $aplPrefClie . "_rel_perfilopcionsistema where COD_PERFIL=$varCodiPerf");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		for ($varI=0;$varI<$nr;$varI++)
		{
			$varListCodiOpci = $varListCodiOpci . $results["COD_OPCIONSISTEMA"][$varI] . ",";
		}
		funLiberaRecordset ($recordset);

		// secciones del perfil
		$recordset = mysql_query("select COD_SECCION from " . $aplPrefClie . "_rel_perfilinfoseccion where COD_PERFIL=$varCodiPerf");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		for ($varI=0;$varI<$nr;$varI++)
		{
			$varListCodiSecc = $varListCodiSecc . $results["COD_SECCION"][$varI] . ",";
		}
		funLiberaRecordset ($recordset);
	}

	print "<input type=\"hidden\" name=\"txtCodiPerf\" value=\"$varCodiPerf\">";
	print "<input type=\"hidden\" name=\"txtListCodiOpci\" value=\"\">";
	print "<input type=\"hidden\" name=\"txtListCodiSecc\" value=\"\">";
?>

<!-- marco principal -->
<table width="95%" height="371" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
		<tr>
			<td class="label" align="right">Nombre : &nbsp;</td>
			<td colspan="2"><input type="text" name="txtNombPerf" value="<?=$varNombPerf?>" maxlength="60" style="width:320px;" class="textboxucase" onKeyPress="if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;"></td>
		</tr>
		<tr>
			<td class="label" align="right" valign="top">Opciones : &nbsp;</td>
			<td colspan="2">
				<select name="cboListCodiOpci" multiple size="13" style="width:320px" class="textboxucase">
				<?
					$recordset = funEjecutaQuerySelect ("select COD_OPCIONSISTEMA, NOM_OPCIONSISTEMA, TIP_OPCIONSISTEMA from ".$aplPrefClie."_sis_opcionsistema order by TIP_OPCIONSISTEMA, ORD_OPCIONSISTEMA");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
						if (trim(strpos($varListCodiOpci,"," . $results["COD_OPCIONSISTEMA"][$varI] . ",")) != "")
							print "		<option value=\"" . $results["COD_OPCIONSISTEMA"][$varI] . "\" selected>(" . trim($results["TIP_OPCIONSISTEMA"][$varI]) . ") " . trim($results["NOM_OPCIONSISTEMA"][$varI]);
						else
							print "		<option value=\"" . $results["COD_OPCIONSISTEMA"][$varI] . "\">(" . trim($results["TIP_OPCIONSISTEMA"][$varI]) . ") " . trim($results["NOM_OPCIONSISTEMA"][$varI]);
					}
					funLiberaRecordset ($recordset);
				?>
				</select>
			</td>
		</tr>
				<tr>
			<td class="label" align="right" valign="top">Secciones : &nbsp;</td>
			<td>
				<select name="cboListCodiSecc" multiple size="13" style="width:320px" class="textboxucase">
				<?
					// Selecciona los registros
					$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where (COD_ESPADRESECCION='S' and NIV_SECCION=1) or (COD_ESPADRESECCION='N' and NIV_SECCION=1) order by ORD_SECCION");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
						// guardo los datos en variables
						$varCodiInfo = trim($results["COD_SECCION"][$varI]);
						$varNombInfo = trim($results["NOM_SECCION"][$varI]);
						$varNiveInfo = trim($results["NIV_SECCION"][$varI]);
						$varTipoInfo = trim($results["TIP_SECCION"][$varI]);
						
						// despliego los datos
						if (trim(strpos($varListCodiSecc,"," . $varCodiInfo . ",")) != "")
							print "		<option style=\"color:#004080\" value=\"" . $varCodiInfo . "\" selected>" . $varNombInfo;
						else
							print "		<option style=\"color:#004080\" value=\"" . $varCodiInfo . "\">" . $varNombInfo;

						$recordsubs = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where COD_SECCIONPADRE='$varCodiInfo' and COD_SECCION<>COD_SECCIONPADRE  order by ORD_SECCION");
						$ns = funDevuelveArregloRecordset ($recordsubs,$resultsubs);
						for ($varJ=0;$varJ<$ns;$varJ++)
						{
							// guardo los datos en variables
							$varCodiSubs = trim($resultsubs["COD_SECCION"][$varJ]);
							$varNombSubs = trim($resultsubs["NOM_SECCION"][$varJ]);
							$varNiveSubs = trim($resultsubs["NIV_SECCION"][$varJ]);
							$varTipoSubs = trim($resultsubs["TIP_SECCION"][$varJ]);
							
							// crea los espacios de nivel
							$varEspacios = "";
							for ($varM=1;$varM<$resultsubs["NIV_SECCION"][$varJ];$varM++)
							{
								$varEspacios = $varEspacios . "&nbsp;&nbsp;&nbsp;";
							}

							if (trim(strpos($varListCodiSecc,"," . $varCodiSubs . ",")) != "")
								print "		<option style=\"color:#000000\" value=\"" . $varCodiSubs . "\" selected>" . $varEspacios . $varNombSubs;
							else
								print "		<option style=\"color:#000000\" value=\"" . $varCodiSubs . "\">" . $varEspacios . $varNombSubs;

							$recordsubs2 = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where COD_SECCIONPADRE='$varCodiSubs' and COD_SECCION<>COD_SECCIONPADRE order by ORD_SECCION");
							$ns2 = funDevuelveArregloRecordset ($recordsubs2,$resultsubs2);
							for ($varK=0;$varK<$ns2;$varK++)
							{
								// guardo los datos en variables
								$varCodiSubs2 = trim($resultsubs2["COD_SECCION"][$varK]);
								$varNombSubs2 = trim($resultsubs2["NOM_SECCION"][$varK]);
								$varNiveSubs2 = trim($resultsubs2["NIV_SECCION"][$varK]);
								$varTipoSubs2 = trim($resultsubs2["TIP_SECCION"][$varK]);
							
								// crea los espacios de nivel
								$varEspacios2 = "";
								for ($varM=1;$varM<$resultsubs2["NIV_SECCION"][$varK];$varM++)
								{
									$varEspacios2 = $varEspacios2 . "&nbsp;&nbsp;&nbsp;";
								}
								
								if (trim(strpos($varListCodiSecc,"," . $varCodiSubs2 . ",")) != "")
									print "		<option style=\"color:#8a8a8a\" value=\"" . $varCodiSubs2 . "\" selected>" . $varEspacios2 . $varNombSubs2;
								else
									print "		<option style=\"color:#8a8a8a\" value=\"" . $varCodiSubs2 . "\">" . $varEspacios2 . $varNombSubs2;
							}
							funLiberaRecordset ($recordsubs2);
						}
						funLiberaRecordset ($recordsubs);
					}
					funLiberaRecordset ($recordset);
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
<tr><td><img src="../images/blank.gif" width="2" height="7" border=0 alt=""></td></tr>
</table>

<table width="95%" border="0" cellpadding="4" cellspacing="0" bgcolor="<?=$aplCommandTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center" nowrap>
	<? if ($varCodiPerf == "") { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } else { ?>
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" disabled>
		<input type=submit name=cmdComando value="Actualizar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		<input type=submit name=cmdComando value="Eliminar" style="width:90px;" onClick="return confirm('<?=$aplMensBorrPerf;?>');">
		<input type=submit name=cmdComando value="Limpiar" style="width:90px;" onClick="return funLimpiaDatos();">
	<? } ?>
	</td>
</tr>
</table>

</center>

</form>
</body>
</html>