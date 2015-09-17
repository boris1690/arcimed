<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../_funciones/parametros.php";
	require "./../_funciones/secure.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();

	// verifico si la sesion de usuario esta activa y si no lo está redirecciono al fin
	if (!$_SESSION['User_Permit_Access']) header("Location: " . $aplAplicationURL . "mantenimiento/cgiClose.php");
?>

<html>
<head>
	<title>.: KFC :.</title>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
</head>
<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<!-- titulo -->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td><img src="../images/cms_titulo_esquina1.png" width="19" height="37" border=0 alt=""></td>
	<td class="titusecc" style="padding-bottom:7px;" background="../images/cms_titulo_fondo.png" width="100%"><img src="../images/cms_titulo_bullet.gif" width="18" height="3" border=0 alt="">Contenido</td>
	<td><img src="../images/cms_titulo_esquina2.png" width="18" height="37" border=0 alt=""></td>
</tr>
<tr>
	<td colspan="3"><img src="../images/blank.gif" width="5" height="10"></td>
</tr>
</table>

<!-- marco principal -->
<table border=0 cellpadding=0 cellspacing=0 width="98%">
<tr>
	<td rowspan=3 valign=top width="100%"><iframe name="form" src="./frm_cont.php" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="no" width="100%" height="100%"></iframe></td>
	<td rowspan=3><img src="./../images/blank.gif" width=15 height=10></td>
	<td valign=top>
		<table width="100%" cellpadding="1" cellspacing="1" border="0"  bordercolor="#515151" bgcolor="#515151">
		<tr>
			<td width="100%%" bgcolor="#515151" align="center" class="titutabl">Contenido</td>
		</tr>
		</table>
	</td>
</tr>
<tr><td><img src="./../images/blank.gif" width=2 height=2></td></tr>
<tr>
	<td height="100%" valign=top><iframe name="ejec" src="./exe_cont.php" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="yes" width="350" height="392"></iframe></td>
</tr>
</table>
</center>

<!-- Archivo de Imágenes -->
<div id="layImagenes" style="POSITION:absolute; Z-INDEX:0; LEFT:485; TOP:50; VISIBILITY:hidden;">
	<table cellpadding="5" cellspacing="1" border="0" width="350" bgcolor="#5e8195">
	<tr>
		<td align="center" valign="top" bgcolor="#f4f4f4">
			<table cellpadding="0" cellspacing="1" border="0" width="100%">
			<tr>
				<td width="100%" style="color:#cc0000" class="label"><b>Archivos:</b></td>
				<td align="right"><a href="#" onClick="document.all['layImagenes'].style.visibility='hidden'; return false;" class="linktabl"><b>X</b></a></td>
			</tr>
			<tr><td colspan="2"><img src="./../images/blank.gif" width=2 height=2></td></tr>
			<tr>
				<td colspan="2"><iframe id="images" name="images" src="./lst_arch.php" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="yes" width="100%" height="320"></iframe></td>
			</tr>
			</table>
		</td>
	</tr>
	</table>	
</div>

</form>
</body>
</html>