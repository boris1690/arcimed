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
	<script language="javascript" src="./../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
</head>
<body bgcolor="<?=$aplBackGroundColor;?>" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	$varPerfUsua = $_SESSION['Perf_User'];

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where (COD_ESPADRESECCION='S' or NIV_SECCION=1) and COD_SECCION in (select COD_SECCION from " . $aplPrefClie . "_rel_perfilinfoseccion WHERE COD_PERFIL=" . $varPerfUsua . ") order by ORD_SECCION");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		print "\n<tr>";
		print "\n	<td class=\"label\">";
		print "\n	<span style=\"color:#666666;\"><b>SECCIONES</b></span>";
		print "\n	</td>";
		print "\n</tr>";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiInfo = trim($results["COD_SECCION"][$varI]);
			$varNombInfo = trim($results["NOM_SECCION"][$varI]);
			$varNiveInfo = trim($results["NIV_SECCION"][$varI]);
			$varTipoInfo = trim($results["TIP_SECCION"][$varI]);
			$varEstaInfo = trim($results["EST_SECCION"][$varI]);
		
			// seteo el icono de estado
			if ($varEstaInfo == "A") $varIconEsta = ""; else $varIconEsta = "<img src=\"../graficos/ic_x3.gif\" width=\"12\" height=\"11\">";
			
			// despliego los datos
			if ($varNiveInfo == "1")
			{
				print "<tr>";
				if (($varTipoInfo == "L")||($varTipoInfo == "H"))
					print "	<td width=\"100%\" style=\"color:#ca6500\" class=\"linktabl\">$varNombInfo<br><span style=\"color:#6C6C6C;\">./interna.php?txtCodiInfo=$varCodiInfo</span></td>";
				else
					print "	<td width=\"100%\" style=\"color:#ca6500\" class=\"linktabl\">$varNombInfo</td>";
				print "</tr>";
			}
			
			$recordsubs = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where COD_SECCIONPADRE='$varCodiInfo' and COD_SECCION <> COD_SECCIONPADRE  order by ORD_SECCION");
			$ns = funDevuelveArregloRecordset ($recordsubs,$resultsubs);
			for ($varJ=0;$varJ<$ns;$varJ++)
			{
				// guardo los datos en variables
				$varCodiSubs = trim($resultsubs["COD_SECCION"][$varJ]);
				$varNombSubs = trim($resultsubs["NOM_SECCION"][$varJ]);
				$varNiveSubs = trim($resultsubs["NIV_SECCION"][$varJ]);
				$varTipoSubs = trim($resultsubs["TIP_SECCION"][$varJ]);
				$varEstaSubs = trim($resultsubs["EST_SECCION"][$varJ]);
			
				// seteo el icono de estado
				if ($varEstaSubs == "A") $varIconEsta = ""; else $varIconEsta = "<img src=\"../graficos/ic_x3.gif\" width=\"12\" height=\"11\">";
			
				if ($varNiveSubs == "1")
				{
					print "<tr>";
					if (($varTipoSubs == "L")||($varTipoSubs == "H"))
						print "	<td width=\"100%\" style=\"color:#000000\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs\" target=\"form\" style=\"color:#000000\" class=\"linktabl\">$varNombSubs</a> $varIconEsta</td>";
					else
						print "	<td width=\"100%\" style=\"color:#000000\" class=\"texttabl\">$varNombSubs $varIconEsta</td>";
					print "</tr>";
				}
				elseif ($varNiveSubs == "2")
				{
					print "<tr>";
					if (($varTipoSubs == "L")||($varTipoSubs == "H"))
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:20px;\" class=\"texttabl\">$varNombSubs<br><span style=\"color:#6C6C6C;\">./interna.php?txtCodiInfo=$varCodiSubs</span></td>";
					else
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:20px;\" class=\"texttabl\">$varNombSubs $varIconEsta</td>";
					print "</tr>";
				}
				elseif ($varNiveSubs == "3")
				{
					print "<tr>";
					if (($varTipoSubs == "L")||($varTipoSubs == "H"))
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:40px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs\" target=\"form\" style=\"color:#000000\" class=\"linktabl\">$varNombSubs</a> $varIconEsta</td>";
					else
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:40px;\" class=\"texttabl\">$varNombSubs $varIconEsta</td>";
					print "</tr>";
				}
				elseif ($varNiveSubs == "4")
				{
					print "<tr>";
					if (($varTipoSubs == "L")||($varTipoSubs == "H"))
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:60px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs\" target=\"form\" style=\"color:#000000\" class=\"linktabl\">$varNombSubs</a> $varIconEsta</td>";
					else
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:60px;\" class=\"texttabl\">$varNombSubs $varIconEsta</td>";
					print "</tr>";
				}
				elseif ($varNiveSubs == "5")
				{
					print "<tr>";
					if (($varTipoSubs == "L")||($varTipoSubs == "H"))
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:80px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs\" target=\"form\" style=\"color:#000000\" class=\"linktabl\">$varNombSubs</a> $varIconEsta</td>";
					else
						print "	<td width=\"100%\" style=\"color:#000000;padding-left:80px;\" class=\"texttabl\">$varNombSubs $varIconEsta</td>";
					print "</tr>";
				}

				$recordsubs2 = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where COD_SECCIONPADRE='$varCodiSubs' and COD_SECCION<>COD_SECCIONPADRE order by ORD_SECCION");
				$ns2 = funDevuelveArregloRecordset ($recordsubs2,$resultsubs2);
				for ($varK=0;$varK<$ns2;$varK++)
				{
					// guardo los datos en variables
					$varCodiSubs2 = trim($resultsubs2["COD_SECCION"][$varK]);
					$varNombSubs2 = trim($resultsubs2["NOM_SECCION"][$varK]);
					$varNiveSubs2 = trim($resultsubs2["NIV_SECCION"][$varK]);
					$varTipoSubs2 = trim($resultsubs2["TIP_SECCION"][$varK]);
					$varEstaSubs2 = trim($resultsubs2["EST_SECCION"][$varK]);
				
					// seteo el icono de estado
					if ($varEstaSubs2 == "A") $varIconEsta = ""; else $varIconEsta = "<img src=\"../graficos/ic_x3.gif\" width=\"12\" height=\"11\">";
					
					if ($varNiveSubs2 == "1")
					{
						print "<tr>";
						if (($varTipoSubs2 == "L")||($varTipoSubs2 == "H"))
							print "	<td width=\"100%\" style=\"color:#cc9900\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs2\" target=\"form\" style=\"color:#cc9900\" class=\"linktabl\">$varNombSubs2</a> $varIconEsta</td>";
						else
							print "	<td width=\"100%\" style=\"color:#cc9900\" class=\"texttabl\">$varNombSubs2 $varIconEsta</td>";
						print "</tr>";
					}
					elseif ($varNiveSubs2 == "2")
					{
						print "<tr>";
						if (($varTipoSubs2 == "L")||($varTipoSubs2 == "H"))
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:20px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs2\" target=\"form\" style=\"color:#cc9900\" class=\"linktabl\">$varNombSubs2</a> $varIconEsta</td>";
						else
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:20px;\" class=\"texttabl\">$varNombSubs2 $varIconEsta</td>";
						print "</tr>";
					}
					elseif ($varNiveSubs2 == "3")
					{
						print "<tr>";
						if (($varTipoSubs2 == "L")||($varTipoSubs2 == "H"))
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:40px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs2\" target=\"form\" style=\"color:#cc9900\" class=\"linktabl\">$varNombSubs2</a> $varIconEsta</td>";
						else
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:40px;\" class=\"texttabl\">$varNombSubs2 $varIconEsta</td>";
						print "</tr>";
					}
					elseif ($varNiveSubs2 == "4")
					{
						print "<tr>";
						if (($varTipoSubs2 == "L")||($varTipoSubs2 == "H"))
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:60px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs2\" target=\"form\" style=\"color:#cc9900\" class=\"linktabl\">$varNombSubs2</a> $varIconEsta</td>";
						else
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:60px;\" class=\"texttabl\">$varNombSubs2 $varIconEsta</td>";
						print "</tr>";
					}
					elseif ($varNiveSubs2 == "5")
					{
						print "<tr>";
						if (($varTipoSubs2 == "L")||($varTipoSubs2 == "H"))
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:80px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs2\" target=\"form\" style=\"color:#cc9900\" class=\"linktabl\">$varNombSubs2</a> $varIconEsta</td>";
						else
							print "	<td width=\"100%\" style=\"color:#cc9900;padding-left:80px;\" class=\"texttabl\">$varNombSubs2 $varIconEsta</td>";
						print "</tr>";
					}

					$recordsubs3 = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where COD_SECCIONPADRE='$varCodiSubs2' and COD_SECCION<>COD_SECCIONPADRE order by ORD_SECCION");
					$ns3 = funDevuelveArregloRecordset ($recordsubs3,$resultsubs3);
					for ($varL=0;$varL<$ns3;$varL++)
					{
						// guardo los datos en variables
						$varCodiSubs3 = trim($resultsubs3["COD_SECCION"][$varL]);
						$varNombSubs3 = trim($resultsubs3["NOM_SECCION"][$varL]);
						$varNiveSubs3 = trim($resultsubs3["NIV_SECCION"][$varL]);
						$varTipoSubs3 = trim($resultsubs3["TIP_SECCION"][$varL]);
						$varEstaSubs3 = trim($resultsubs3["EST_SECCION"][$varL]);
					
						// seteo el icono de estado
						if ($varEstaSubs3 == "A") $varIconEsta = ""; else $varIconEsta = "<img src=\"../graficos/ic_x3.gif\" width=\"12\" height=\"11\">";
						
						if ($varNiveSubs3 == "1")
						{
							print "<tr>";
							if (($varTipoSubs3 == "L")||($varTipoSubs3 == "H"))
								print "	<td width=\"100%\" style=\"color:#004080\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs3\" target=\"form\" style=\"color:#004080\" class=\"linktabl\">$varNombSubs3</a> $varIconEsta</td>";
							else
								print "	<td width=\"100%\" style=\"color:#004080\" class=\"texttabl\">$varNombSubs3 $varIconEsta</td>";
							print "</tr>";
						}
						elseif ($varNiveSubs3 == "2")
						{
							print "<tr>";
							if (($varTipoSubs3 == "L")||($varTipoSubs3 == "H"))
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:20px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs3\" target=\"form\" style=\"color:#004080\" class=\"linktabl\">$varNombSubs3</a> $varIconEsta</td>";
							else
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:20px;\" class=\"texttabl\">$varNombSubs3 $varIconEsta</td>";
							print "</tr>";
						}
						elseif ($varNiveSubs3 == "3")
						{
							print "<tr>";
							if (($varTipoSubs3 == "L")||($varTipoSubs3 == "H"))
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:40px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs3\" target=\"form\" style=\"color:#004080\" class=\"linktabl\">$varNombSubs3</a> $varIconEsta</td>";
							else
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:40px;\" class=\"texttabl\">$varNombSubs3 $varIconEsta</td>";
							print "</tr>";
						}
						elseif ($varNiveSubs3 == "4")
						{
							print "<tr>";
							if (($varTipoSubs3 == "L")||($varTipoSubs3 == "H"))
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:60px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs3\" target=\"form\" style=\"color:#004080\" class=\"linktabl\">$varNombSubs3</a> $varIconEsta</td>";
							else
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:60px;\" class=\"texttabl\">$varNombSubs3 $varIconEsta</td>";
							print "</tr>";
						}
						elseif ($varNiveSubs3 == "5")
						{
							print "<tr>";
							if (($varTipoSubs3 == "L")||($varTipoSubs3 == "H"))
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:80px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs3\" target=\"form\" style=\"color:#004080\" class=\"linktabl\">$varNombSubs3</a> $varIconEsta</td>";
							else
								print "	<td width=\"100%\" style=\"color:#004080;padding-left:80px;\" class=\"texttabl\">$varNombSubs3 $varIconEsta</td>";
							print "</tr>";
						}

						$recordsubs4 = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_infoseccion where COD_SECCIONPADRE='$varCodiSubs3' and COD_SECCION<>COD_SECCIONPADRE order by ORD_SECCION");
						$ns4 = funDevuelveArregloRecordset ($recordsubs4,$resultsubs4);
						for ($varO=0;$varO<$ns4;$varO++)
						{
							// guardo los datos en variables
							$varCodiSubs4 = trim($resultsubs4["COD_SECCION"][$varO]);
							$varNombSubs4 = trim($resultsubs4["NOM_SECCION"][$varO]);
							$varNiveSubs4 = trim($resultsubs4["NIV_SECCION"][$varO]);
							$varTipoSubs4 = trim($resultsubs4["TIP_SECCION"][$varO]);
							$varEstaSubs4 = trim($resultsubs4["EST_SECCION"][$varO]);
						
							// seteo el icono de estado
							if ($varEstaSubs4 == "A") $varIconEsta = ""; else $varIconEsta = "<img src=\"../graficos/ic_x3.gif\" width=\"12\" height=\"11\">";
							
							if ($varNiveSubs4 == "1")
							{
								print "<tr>";
								if (($varTipoSubs4 == "L")||($varTipoSubs4 == "H"))
									print "	<td width=\"100%\" style=\"color:#8a8a8a\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs4\" target=\"form\" style=\"color:#8a8a8a\" class=\"linktabl\">$varNombSubs4</a> $varIconEsta</td>";
								else
									print "	<td width=\"100%\" style=\"color:#8a8a8a\" class=\"texttabl\">$varNombSubs4 $varIconEsta</td>";
								print "</tr>";
							}
							elseif ($varNiveSubs4 == "2")
							{
								print "<tr>";
								if (($varTipoSubs4 == "L")||($varTipoSubs4 == "H"))
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:20px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs4\" target=\"form\" style=\"color:#8a8a8a\" class=\"linktabl\">$varNombSubs4</a> $varIconEsta</td>";
								else
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:20px;\" class=\"texttabl\">$varNombSubs4 $varIconEsta</td>";
								print "</tr>";
							}
							elseif ($varNiveSubs4 == "3")
							{
								print "<tr>";
								if (($varTipoSubs4 == "L")||($varTipoSubs4 == "H"))
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:40px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs4\" target=\"form\" style=\"color:#8a8a8a\" class=\"linktabl\">$varNombSubs4</a> $varIconEsta</td>";
								else
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:40px;\" class=\"texttabl\">$varNombSubs4 $varIconEsta</td>";
								print "</tr>";
							}
							elseif ($varNiveSubs4 == "4")
							{
								print "<tr>";
								if (($varTipoSubs4 == "L")||($varTipoSubs4 == "H"))
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:60px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs4\" target=\"form\" style=\"color:#8a8a8a\" class=\"linktabl\">$varNombSubs4</a> $varIconEsta</td>";
								else
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:60px;\" class=\"texttabl\">$varNombSubs4 $varIconEsta</td>";
								print "</tr>";
							}
							elseif ($varNiveSubs4 == "5")
							{
								print "<tr>";
								if (($varTipoSubs4 == "L")||($varTipoSubs4 == "H"))
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:80px;\" class=\"texttabl\"><a href=\"./frm_cont.php?txtCodiInfo=$varCodiSubs4\" target=\"form\" style=\"color:#8a8a8a\" class=\"linktabl\">$varNombSubs4</a> $varIconEsta</td>";
								else
									print "	<td width=\"100%\" style=\"color:#8a8a8a;padding-left:80px;\" class=\"texttabl\">$varNombSubs4 $varIconEsta</td>";
								print "</tr>";
							}				
						}
						funLiberaRecordset ($recordsubs4);

					}
					funLiberaRecordset ($recordsubs3);

				}
				funLiberaRecordset ($recordsubs2);

			}
			funLiberaRecordset ($recordsubs);

		}

		// cierra la tabla
		print "</table>";

		print "\n<script language=\"JavaScript\">";
		print "\n<!--";
		print "\n	tigra_tables('tabDatos', 0, 0, '$aplTigraBackColorUno', '$aplTigraBackColorDos', '$aplTigraBackColorOver', '$aplTigraBackColorSelect');";
		print "\n-->";
		print "\n</script>";
	}
	else
	{
		print "<br>";		
		print "\n<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"$aplFormTableBackColor\" style=\"border: 1px solid rgb($aplFormTableBorderColor)\">";
		print "<tr>";
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">$aplMensTablSecc</td>";
		print "</tr>";
		print "</table>";
	}
	funLiberaRecordset ($recordset);

	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_promocion order by NOM_PROMOCION");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// crea la tabla
		print "\n<table id=\"tabDatos\" width=\"100%\" cellpadding=\"2\" cellspacing=\"2\" border=\"0\">";

		print "\n<tr>";
		print "\n	<td class=\"label\">";
		print "\n	<span style=\"color:#666666;\"><b>PROMOCIONES</b></span>";
		print "\n	</td>";
		print "\n</tr>";

		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiProm = trim($results["COD_PROMOCION"][$varI]);
			$varNombProm = trim($results["NOM_PROMOCION"][$varI]);
			$varEstaProm = trim($results["EST_PROMOCION"][$varI]);

			if ($varEstaProm == "A")
			{	
				$varEstaPromNomb = "(Activo)";
			}
			elseif ($varEstaProm == "I")
			{
				$varEstaPromNomb = "(Inactivo)";
			}

			// despliego los datos
			print "<tr>";
			print "	<td width=\"97%\" class=\"texttabl\">$varNombProm&nbsp;<font style=\"color:#666666\"><i>$varEstaPromNomb</i></font><br><span style=\"color:#6C6C6C;\">./interna_promocion.php?txtCodiProm=$varCodiProm</span></td>";
			print "</tr>";
		}

		// cierra la tabla
		print "</table>";

		print "\n<script language=\"JavaScript\">";
		print "\n<!--";
		print "\n	tigra_tables('tabDatos', 0, 0, '$aplTigraBackColorUno', '$aplTigraBackColorDos', '$aplTigraBackColorOver', '$aplTigraBackColorSelect');";
		print "\n-->";
		print "\n</script>";
	}
	else
	{
		print "<br>";		
		print "\n<table width=\"100%\" cellpadding=\"2\" cellspacing=\"0\" bgcolor=\"$aplFormTableBackColor\" style=\"border: 1px solid rgb($aplFormTableBorderColor)\">";
		print "<tr>";
		print "	<td class=\"message\" bgcolor=\"#f9f9f9\">No existen Promociones</td>";
		print "</tr>";
		print "</table>";
	}
	funLiberaRecordset ($recordset);		

	// Cierro la conexión
	funCloseConectionToDataBase();
?>

</center>
<br>

<!-- verifico si debe limpiar el formulario -->
<? if ($varComando != "") { ?>
	<script language="JavaScript">
	<!--
		parent.frames[0].funLimpiaDatos();
	-->
	</script>
<? } ?>

</body>
</html>