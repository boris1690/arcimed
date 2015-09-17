<?PHP include('_funciones/parametros.php');?>	
<?PHP include('_funciones/database_mysql.php');?>	

<html>
<head>



<title>Productos</title>
<link href="_funciones/styles.css" rel="stylesheet" type="text/css" />
<link href="_funciones/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<?PHP include('header.php'); ?>
<?PHP include('productos.php'); ?>
<?PHP include('foot.php'); ?>

<script>


</script>
</head>

<body>
<div id="respuesta"></div>
<div style="position:absolute;top:500px;left:700px;width:1500px;height:800px;overflow:scroll">

<table width="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="<?=$aplFormTableBackColor;?>" style="border: 1px solid rgb(<?=$aplFormTableBorderColor;?>)">
    <tr>
        <td align="center" style="color:#FFF;background-color:#1E90FF">
            Imagen
        </td>
        <td align="center" style="color:#FFF;background-color:#1E90FF">
            Producto
        </td>
        <td align="center" style="color:#FFF;background-color:#1E90FF">
            Cantidad
        </td>

        <td align="center" style="color:#FFF;background-color:#1E90FF">
            Fecha
        </td>
        <td align="center" style="color:#FFF;background-color:#1E90FF">
            Precio/Uni
        </td>
        <td align="center" style="color:#FFF;background-color:#1E90FF">
            Total
        </td>
    </tr>
 
<?
    $varCliente = $_SESSION['codigo'];

	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select *,(PRE_PRODUCTO*num_inventario) as precio from arcimed_ref_inventario A JOIN arcimed_ref_producto B ON A.cod_producto=B.COD_PRODUCTO WHERE A.cod_cliente=" . $varCliente);
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{	
		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++) {
            // guardo los datos en variables
            $varCodiProd = trim($results["COD_PRODUCTO"][$varI]);
            $varNombProd = trim($results["NOM_PRODUCTO"][$varI]);
            $varImagProd = trim($results["IMG_PRODUCTO"][$varI]);
            $varPrecProd = trim($results["PRE_PRODUCTO"][$varI]);
            $varNumeInve = trim($results["num_inventario"][$varI]);
            $varFechInve = trim($results["fec_inventario"][$varI]);
            $varTotaInve = trim($results["precio"][$varI]);


        ?>
            <tr>
                <td align="center" >
                    <img width="100px" height="80px" src="_upload/<?=$varImagProd?>" style="padding-left:20px" />
                </td>
                <td align="center">
                    <?=$varNombProd?>
                </td>

                <td align="center">
                    <?=($varNumeInve*-1)?>
                </td>
                <td align="center">
                    <?=$varFechInve?>
                </td>
                <td align="center">
                    <?=$varPrecProd?>
                </td>
                <td align="center">
                    <?=($varTotaInve*-1)?>
                </td>

            </tr>

        <?

        }
        print '</table>';
        print '</div>';


	}

	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();

?>
</body>
</html>