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
	if (!$_SESSION['User_Permit_Access']) header("Location: " . $aplAplicationURL . "kfccms/cgiClose.php");
?>

<html>
<head>
	<title>.: KFC :.</title>
	<script language="JavaScript" src="./../_funciones/funciones.js"></script>
	<script language="JavaScript" src="./../_funciones/images.js"></script>
	<script language="JavaScript" src="./../_funciones/browsercheck.js"></script>
	<script language="JavaScript" src="./../_funciones/showhide.js"></script>
	<script language="JavaScript" src="./../_funciones/dynlayer.js"></script>
	<script language="JavaScript" src="./../_funciones/liquid.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	<script language="JavaScript">
	<!--

		function levantasubmenu1ones(parEIdenOpci)
		{
			// oculto todos los menus
			hide('ModuAdmi');
			hide('ModuCms');
			hide('ModuCons');

			// despliego el menu que corresponda
			if (parEIdenOpci == "ADMI")
				show('ModuAdmi');
			else if (parEIdenOpci == "CMS")
				show('ModuCms');
			else if (parEIdenOpci == "CONS")
				show('ModuCons');
		}

	-->
	</script>

	<script type="text/javascript">
	<!--
		var timer = null

		function stop()
		{
			clearTimeout(timer)
		}

		function start()
		{
			var time = new Date()
			var hours = time.getHours()
			var minutes = time.getMinutes()
			var seconds = time.getSeconds()
			var clock = hours

			var varFilaList = document.getElementById('tabDateTime').rows;
			var varColuList = varFilaList[0].cells;

			clock += ((minutes < 10) ? ":0" : ":") + minutes
			clock += ((seconds < 10) ? ":0" : ":") + seconds

			cambia_innerText (varColuList[2], clock);
			timer = setTimeout("start()",1000);
		}
	-->
	</script>

</head>

<?
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);
?>

<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="start(); focus();" onUnload="stop()">

<!-- Menu Administrativo -->
<div id="ModuAdmi" style="POSITION:absolute; Z-INDEX:0; LEFT:955; TOP:88; VISIBILITY:hidden;" onMouseOver="show('ModuAdmi');" onMouseOut="hide('ModuAdmi');">
	<table border="0" cellpadding="2" cellspacing="1" bgcolor="#c9c9c9" width="120">
	<tr>
		<td bgcolor="#f3f3f3">
			<table cellpadding="0" cellspacing="3" border="0" width="120">
			<?
				$recordset = funEjecutaQuerySelect ("SELECT A.cod_opcionsistema, B.nom_opcionsistema, B.url_opcionsistema, B.tip_opcionsistema FROM " . $aplPrefClie . "_rel_perfilopcionsistema A, " . $aplPrefClie . "_sis_opcionsistema B WHERE A.cod_perfil=" . $_SESSION['Perf_User'] . " AND A.cod_opcionsistema=B.cod_opcionsistema AND B.tip_opcionsistema='A' ORDER BY B.tip_opcionsistema, B.ord_opcionsistema");
				$nr = funDevuelveArregloRecordset ($recordset,$results);
				if ($nr>0)
				{
					// inicializo la seccion del menu
					$varTipoOpciSistAuxi = trim($results["tip_opcionsistema"][0]);

					// opciones
					for ($varI=0;$varI<$nr;$varI++)
					{
						// despliego la opcion
						print "<tr>";
						print "	<td class=\"submenu1\" style=\"text-align:right;padding-right:4px;\"><a href=\"" . trim($results["url_opcionsistema"][$varI]) . "\" target=\"sist\" class=\"submenu1\">" . trim($results["nom_opcionsistema"][$varI]) . "</a></td>";
						print "</tr>";

						if ($varI != $nr-1)
						{
							print "<tr>";
							print "	<td bgcolor=\"#ffffff\"><img src=\"../images/blank.gif\" width=\"2\" height=\"1\" border=0 alt=\"\"></td>";
							print "</tr>";
						}
					}

				}
				funLiberaRecordset ($recordset);
			?>
			</table>
		</td>
	</tr>
	</table>
</div>

<!-- Menu CMS -->
<div id="ModuCms" style="POSITION:absolute; Z-INDEX:0; LEFT:1065; TOP:88; VISIBILITY:hidden;" onMouseOver="show('ModuCms');" onMouseOut="hide('ModuCms');">
	<table border="0" cellpadding="2" cellspacing="1" bgcolor="#c9c9c9" width="120">
	<tr>
		<td bgcolor="#f3f3f3">
			<table cellpadding="0" cellspacing="3" border="0" width="140">
			<?
				$recordset = funEjecutaQuerySelect ("SELECT A.cod_opcionsistema, B.nom_opcionsistema, B.url_opcionsistema, B.tip_opcionsistema FROM " . $aplPrefClie . "_rel_perfilopcionsistema A, " . $aplPrefClie . "_sis_opcionsistema B WHERE A.cod_perfil=" . $_SESSION['Perf_User'] . " AND A.cod_opcionsistema=B.cod_opcionsistema AND B.tip_opcionsistema='C' ORDER BY B.tip_opcionsistema, B.ord_opcionsistema");
				$nr = funDevuelveArregloRecordset ($recordset,$results);
				if ($nr>0)
				{
					// inicializo la seccion del menu
					$varTipoOpciSistAuxi = trim($results["tip_opcionsistema"][0]);

					// opciones
					for ($varI=0;$varI<$nr;$varI++)
					{
						// despliego la opcion
						print "<tr>";
						print "	<td class=\"submenu1\" style=\"text-align:right;padding-right:4px;\"><a href=\"" . trim($results["url_opcionsistema"][$varI]) . "\" target=\"sist\" class=\"submenu1\">" . trim($results["nom_opcionsistema"][$varI]) . "</a></td>";
						print "</tr>";

						if ($varI != $nr-1)
						{
							print "<tr>";
							print "	<td bgcolor=\"#ffffff\"><img src=\"../images/blank.gif\" width=\"2\" height=\"1\" border=0 alt=\"\"></td>";
							print "</tr>";
						}
					}

				}
				funLiberaRecordset ($recordset);
			?>
			</table>
		</td>
	</tr>
	</table>
</div>

<!-- Menu Consultas -->
<div id="ModuCons" style="POSITION:absolute; Z-INDEX:0; LEFT:1205; TOP:88; VISIBILITY:hidden;" onMouseOver="show('ModuCons');" onMouseOut="hide('ModuCons');">
	<table border="0" cellpadding="2" cellspacing="1" bgcolor="#c9c9c9" width="120">
	<tr>
		<td bgcolor="#f3f3f3">
			<table cellpadding="0" cellspacing="3" border="0" width="120">
			<?
				$recordset = funEjecutaQuerySelect ("SELECT A.cod_opcionsistema, B.nom_opcionsistema, B.url_opcionsistema, B.tip_opcionsistema FROM " . $aplPrefClie . "_rel_perfilopcionsistema A, " . $aplPrefClie . "_sis_opcionsistema B WHERE A.cod_perfil=" . $_SESSION['Perf_User'] . " AND A.cod_opcionsistema=B.cod_opcionsistema AND B.tip_opcionsistema='R' ORDER BY B.tip_opcionsistema, B.ord_opcionsistema");
				$nr = funDevuelveArregloRecordset ($recordset,$results);
				if ($nr>0)
				{
					// inicializo la seccion del menu
					$varTipoOpciSistAuxi = trim($results["tip_opcionsistema"][0]);

					// opciones
					for ($varI=0;$varI<$nr;$varI++)
					{
						// despliego la opcion
						print "<tr>";
						print "	<td class=\"submenu1\" style=\"text-align:right;padding-right:4px;\"><a href=\"" . trim($results["url_opcionsistema"][$varI]) . "\" target=\"sist\" class=\"submenu1\">" . trim($results["nom_opcionsistema"][$varI]) . "</a></td>";
						print "</tr>";

						if ($varI != $nr-1)
						{
							print "<tr>";
							print "	<td bgcolor=\"#ffffff\"><img src=\"../images/blank.gif\" width=\"2\" height=\"1\" border=0 alt=\"\"></td>";
							print "</tr>";
						}
					}

				}
				funLiberaRecordset ($recordset);
			?>
			</table>
		</td>
	</tr>
	</table>
</div>

<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td height="88" align="center" background="../images/cms_header_fondo.jpg">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr> 
			<td height="58">
				<table width="100%" height="58" border="0" cellpadding="0" cellspacing="0">
				<tr> 
					<td width="20">&nbsp;</td>
					<td><img src="../images/cms_header_logo.png" width="131" height="35"></td>
					<td align="right" valign="top">
						&nbsp;
					</td>
					<td width="20">&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr> 
			<td height="30" align="right" background="../images/cms_header_basemenu.gif" style="padding-right:20px;">
				<table border="0" cellpadding="0" cellspacing="0" width="360">
				<tr>
					<td width="33%" class="seccion" align="center"><a href="#" onClick="levantasubmenu1ones('ADMI');" class="seccion">Administrativo</a></td>
					<td><img src="../images/cms_header_separa.gif" width="25" height="7"></td>
					<td width="34%" class="seccion" align="center"><a href="#" onClick="levantasubmenu1ones('CMS');" class="seccion">CMS</a></td>
					<td><img src="../images/cms_header_separa.gif" width="25" height="7"></td>
					<td width="33%" class="seccion" align="center"><a href="#" onClick="levantasubmenu1ones('CONS');" class="seccion">Consultas</a></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="100%" align="center" valign="top" background="../images/cms_contenido_fondo.jpg"> 
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="14">&nbsp;</td>
			<td valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td height="100%" valign="top"><iframe name="sist" src="#" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="no" width="100%" height="461"></iframe></td>
				</tr>
				</table>
			</td>
			<td width="14">&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="30" align="center" background="../images/cms_footer_fondo.jpg">
		<table id="tabDateTime" name="tabDateTime" cellpadding="0" cellspacing="0" border="0" width="98%">
		<tr>
			<td class="linkcerrsesi" width="30%" align="left"><?= $_SESSION['Nomb_User'] ?></td>
			<td class="linkcerrsesi" width="25%" align="right"><?= funObtieneNombreMes (date("m"),15) . " " . date("d") . ", " . date("Y") ?>&nbsp;-&nbsp;</td>
			<td class="linkcerrsesi" width="25%" align="left"></td>
			<td class="linkcerrsesi" width="20%" align="right"><a href="./sistema_close.php" class="linkcerrsesi" target="_top">Cerrar</a></td>
		</tr>
		</table>
	</td>
</tr>
</table>

</body>
</html>