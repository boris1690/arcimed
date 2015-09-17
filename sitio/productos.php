<html>
<head>
<title>Productos</title>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
           

			<link href="_funciones/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
			<style type="text/css">
			.contacto table tr th #form1 p label {
	font-size: x-large;
}
            .contacto table tr th #form1 label {
	font-size: x-large;
}
            #apDivproductos {
	position: absolute;
	left: 30px;
	top: 300px;
	width: 61px;
	height: 46px;
	z-index: 2;
}
            </style>        
</head>

<body>
<div id="apDivproductos">
<p class="Categorias"><em><u>CATEGORIAS</u></em>
</p>

<ul id="MenuBar1" class="MenuBarVertical">
<?
	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_categoria WHERE EST_CATEGORIA='A' order by ORD_CATEGORIA");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{		
		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiCate = trim($results["COD_CATEGORIA"][$varI]);
			$varNombCate = trim($results["NOM_CATEGORIA"][$varI]);
			$varEstaCate = trim($results["EST_CATEGORIA"][$varI]);
			
			

			print '<li><a class="MenuBarItemSubmenu" href="detalleproductos.php?txtCodiCate=' . $varCodiCate . '">' . $varNombCate . ' </a></li>';
		}
	}

	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();

?>

</ul>
<p>&nbsp;</p>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</div>
</body>
	<?PHP include('header.php'); ?>      
	<?PHP include('foot.php'); ?>
</html>
