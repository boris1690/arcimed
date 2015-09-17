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
	<title><?=$aplNombApli;?></title>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
</head>
<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<center>

<!-- titulo -->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td><img src="../images/cms_titulo_esquina1.png" width="19" height="37" border=0 alt=""></td>
	<td class="titusecc" style="padding-bottom:7px;" background="../images/cms_titulo_fondo.png" width="100%"><img src="../images/cms_titulo_bullet.gif" width="18" height="3" border=0 alt="">Explorador</td>
	<td><img src="../images/cms_titulo_esquina2.png" width="18" height="37" border=0 alt=""></td>
</tr>
<tr>
	<td colspan="3"><img src="../images/blank.gif" width="5" height="10"></td>
</tr>
</table>

<!-- marco principal -->
<table border=0 cellpadding=0 cellspacing=0 width="98%">
<tr>
	<td valign=top width="100%"><iframe name="form" src="./../../explorer.php" frameborder="0" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" scrolling="auto" width="100%" height="392"></iframe></td>
</tr>
</table>

</center>

</body>
</html>