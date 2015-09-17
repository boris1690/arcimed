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
	<title><?=$aplNombApli;?></title>
	<script language="javascript" src="./../_funciones/funciones.js"></script>
	<script language="javascript" src="./../_funciones/tigra_tables.js"></script>
	<script language="javascript" src="./../_funciones/images.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
</head>
<body bgcolor="<?=$aplBackGroundListColor?>" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<script language="JavaScript">
<!--

	// Guardo los arreglos en variables
	arrProd = parent.var_RR_nomb_Prod;
	arrPrec = parent.var_RR_prec_Prod;
	arrEsta = parent.var_RR_esta_Prod;
	varLen = parent.varNumeProd;

	// Verifico que existan objetos
	if (varLen > 0)
	{
		// Cabecera de la Tabla
		document.write ('<table id="tabDatos" width="100%" cellpadding="2" cellspacing="1" border="0">')

		// llena todos los elementos de la lista
		for (varI=0;varI<varLen;varI++)
		{
			
			if (arrEsta[varI] == "A")
			{	
				varEstaProdNomb = "(Activo)";
			}
			else if (arrEsta[varI] == "I")
			{
				varEstaProdNomb = "(Inactivo)";
			}

			document.write ("<tr>")			
			document.write ("	<td width=\"70%\" class=\"texttabl\"><a href=\"#\" onClick=\"parent.funRecuperaProd(" + varI + "); return false;\" class=\"linktabl\">" + arrProd[varI] + "</a> <font style=\"color:#666666\"><i>"  + varEstaProdNomb + "</i></font></td>")
			document.write ("	<td width=\"23%\" class=\"texttabl\" align=\"right\" style=\"padding-right:10px;\">" + arrPrec[varI] + "</td>")
			document.write ("	<td width=\"7%\" class=\"texttabl\" align=\"center\"><a href=\"#\" onClick=\"if (confirm('¿Está seguro que desea Eliminar este Producto?')) { parent.funEliminaProd(" + varI + "); } return false;\"><img src=\"../images/btnx.gif\" width=\"12\" height=\"12\" border=0></a></td>")			
			document.write ("</tr>")
		}

		// Cierro la Tabla
		document.write ('</table>')

		// Seteo los Colores de la Tabla
		tigra_tables('tabDatos',0,0,'<?=$aplTigraBackColorUno?>','<?=$aplTigraBackColorDos?>','<?=$aplTigraBackColorOver?>','<?=$aplTigraBackColorSelect?>');
	}

-->
</script>

</body>
</html>