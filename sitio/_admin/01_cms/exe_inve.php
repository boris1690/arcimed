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


</head>

<? 
	// Se conecta al Servidor y la Base de Datos
	print funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	$varquery = '';

	if(!empty($_POST['cmdComando']))
	{
		$varComando = $_POST['cmdComando'];

		if($varComando == 'Ingresar')
		{
			$varProducto = $_POST['cboCodiInve'];
			$varCantidad = $_POST['txtCantInve'];

			// obtengo el codigo ingresado
			$recordset = funEjecutaQuerySelect ("select max(cod_inventario) as cod_inventario from ".$aplPrefClie."_ref_inventario");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) $varCodiInve = $results["cod_inventario"][0] + 1; else $varCodiInve = 1;
			funLiberaRecordset ($recordset);

			// ingreso el registro
			funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_inventario(cod_inventario,cod_producto,cod_cliente,num_inventario,mov_inventario,fec_inventario)
				values ($varCodiInve,$varProducto,-1,$varCantidad,'I',NOW())");

		}
		elseif($varComando == 'Consultar')
		{
			$varProducto = $_POST['cboCodiInve'];

			if($varProducto!="-1")$varquery = "WHERE A.cod_producto=$varProducto";
		}	
		elseif($varComando == 'Guardar')
		{
			$varProducto = $_GET['cboCodiInve'];
			

			//if($varProducto!="-1" || $varProducto!="")$varquery = "WHERE A.cod_producto=$varProducto";
		}

			
	}

	
	
?>

<body bgcolor="#ffffff" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0" onLoad="document.forms[0].elements['txtNombCate'].focus();">
<form action="./exe_inve.php<? print ($varProducto!=-1)?'?cboCodiInve='.$varProducto:''?>" target="ejecrepo" method="post" enctype="multipart/form-data">

<center>



<!-- marco principal -->
<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
	<tr>
		<td align="center" style="color:#FFF;background-color:#1E90FF">
			Cliente
		</td>
		<td align="center" style="color:#FFF;background-color:#1E90FF">
			Producto
		</td>
		<td align="center" style="color:#FFF;background-color:#1E90FF">
			Cantidad
		</td>
		<td align="center" style="color:#FFF;background-color:#1E90FF">
			Movimiento
		</td>
		<td align="center" style="color:#FFF;background-color:#1E90FF">
			Fecha
		</td>
		<td align="center" style="color:#FFF;background-color:#1E90FF">
			Facturado
		</td>
	</tr>

	<?
		// Selecciona los registros
		$recordset = funEjecutaQuerySelect ("SELECT * FROM arcimed_ref_inventario A LEFT JOIN arcimed_dat_cliente B ON A.cod_cliente=B.cod_cliente JOIN arcimed_ref_producto C ON A.cod_producto=C.COD_PRODUCTO $varquery");
		$nr = funDevuelveArregloRecordset ($recordset,$results);
		if ($nr>0) 
		{
			// imprime los regsitros
			for ($varI=0;$varI<$nr;$varI++)
			{
				// guardo los datos en variables
				$varCodiInve = $results["cod_inventario"][$varI];
				$varUsuario = trim($results["nom_cliente"][$varI]) . ' ' . trim($results["ape_cliente"][$varI]);
				$varProducto = trim($results["NOM_PRODUCTO"][$varI]);
				$varCantidad = trim($results["num_inventario"][$varI]);
				$varFecha = trim($results["fec_inventario"][$varI]);
				$varMovimiento = trim($results["mov_inventario"][$varI]);
				$varFactura = trim($results["fac_estado"][$varI]);

				if($varComando=='Guardar')
				{
					// ingreso el registro
					$varChkEsta = $_POST['chk_' . $varCodiInve];
					
					if(!empty($varChkEsta))
					{
						funEjecutaQueryEdit ("UPDATE  " . $aplPrefClie . "_ref_inventario SET fac_estado='" . $varChkEsta . "' WHERE cod_inventario=" . $varCodiInve);
						$varFactura = $varChkEsta;
					}
				}

	?>
		<tr>
			<td align="center" >
				<?=(trim($varUsuario)=='')?'Admin':$varUsuario?>
			</td>
			<td align="center">
				<?=$varProducto?>
			</td>
			<td align="center">
				<?=$varCantidad?>
			</td>
			<td align="center">
				<?=($varMovimiento=='I')?'Ingreso':'Egreso'?>
			</td>
			<td align="center">
				<?=$varFecha?>
			</td>
			<td align="center">
				<input type="checkbox" name="chk_<?=$varCodiInve?>" value="S" <?=($varFactura=='S')?'checked':'' ?>/>
			</td>
		</tr>
	<?
			}

		?>
		<tr>
			<td colspan="6" align="center">
				<input type="submit" value="Guardar" name="cmdComando"/>
			</td>
		</tr>

		<?
		}
	?>
	
</table>

<!-- separacion -->
<br>


</center>

</form>
</body>
</html>