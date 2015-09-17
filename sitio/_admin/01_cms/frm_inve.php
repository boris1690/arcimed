<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../../_funciones/parametros.php";	
	require "./../../_funciones/funciones.php";
	require "./../../_funciones/database_$aplDataBaseLibrary.php";

?>

<html>
<head>
	<title>.: Arcimed :.</title>
	<script language="javascript" src="./../../_funciones/funciones.js"></script>
	<script language="javascript" src="./../../_funciones/showhide.js"></script>
	<link rel="stylesheet" href="./../../_funciones/style.css" type="text/css">

	<script language="javascript">
	<!-- 

		function funValidaDatos(dml)
		{
			// titulo
			if (dml.elements['cboCodiInve'].value=="-1")
			{
				alert ('Seleccione un PRODUCTO.');
				dml.elements['cboCodiInve'].focus();
				return false;
			}

			if (isNaN(dml.elements['txtCantInve'].value) || dml.elements['txtCantInve'].value.length==0)
			{
				alert ('Cantidad debe ser numero.');
				dml.elements['txtCantInve'].focus();
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
<form action="./exe_inve.php" target="ejecrepo" method="post" enctype="multipart/form-data">

<center>

<? 
	// Se conecta al Servidor y la Base de Datos
	print funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	
	
?>

<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
<tr>
	<td align="center">
		<table cellpadding="1" cellspacing="1" border="0">
         
		
		<tr>
			<td class="label" align="right" nowrap>Producto : &nbsp;</td>
			<td>
				<select id="cboCodiCate" name="cboCodiInve" style="width:320px" class="textbox">
				<?
					print "		<option value=\"-1\">TODOS....";

					$recordset = funEjecutaQuerySelect ("SELECT * from ".$aplPrefClie."_ref_producto A WHERE A.EST_PRODUCTO='A'");
					$nr = funDevuelveArregloRecordset ($recordset,$results);
					for ($varI=0;$varI<$nr;$varI++)
					{
					
							print "		<option value=\"" . $results["COD_PRODUCTO"][$varI] . "\">" . trim($results["NOM_PRODUCTO"][$varI]);
					}
					funLiberaRecordset ($recordset);
				?>				
				</select>
			</td>
		</tr>
		<tr>
			<td class="label" align="right">Cantidad : &nbsp;</td>
			<td><input type="text" name="txtCantInve"  maxlength="60" style="width:80px;" class="textbox"></td>
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
	
		<input type=submit name=cmdComando value="Ingresar" style="width:90px;" onClick="return funValidaDatos(document.forms[0]);">
		
		<input type=submit name=cmdComando value="Consultar" style="width:90px;">	
	</td>
</tr>
</table>
<br>
<iframe src="exe_inve.php" name="ejecrepo" width="100%" height="500px" frameborder="0">

</center>

</form>
</body>
</html>