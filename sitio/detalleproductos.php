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

	function comprar(inpproducto,inpnumero,elemento)
	{
		bool = true;
		while(bool)
		{
			var cantidad = prompt("Ingrese la cantidad que desea comprar", "");

			if (cantidad.length==0 || isNaN(cantidad)) 
			{
	    		alert('Deben ingresar numeros');
			}
			else
			{				
				if(cantidad>inpnumero)
				{
					alert("Solo pueden comparar hasta " + inpnumero + " item del producto.");
				}
				else
				{
					var url = "exe_compra.php"; // El script a dónde se realizará la petición.
    				$.ajax({
           				type: "POST",
           				url: url,
           				data: {"cmdComando":"Comprar","codProducto":inpproducto,"numCantidad":cantidad}, // Adjuntar los campos del formulario enviado.
           				success: function(data)
           				{
               				$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
               				console.log($('#paypal form'));

							$('#paypal form').append('<input name="rm" type="hidden" value="' + cantidad + '">');
               				$('#paypal form').submit();

               				//location.reload();
           				}
         			});
 
					bool = false;	
				}
				

			}
		}


		
	}
</script>
</head>

<body>
<div id="respuesta"></div>
 
<?
	$varCodiCate = !empty($_GET['txtCodiCate']) ? $_GET['txtCodiCate'] : '';
	$varCodiProd = !empty($_GET['txtCodiProd']) ? $_GET['txtCodiProd'] : '';

	$varQuery = "";

	if(!empty($varCodiCate))$varQuery = " AND A.COD_CATEGORIA=" . $varCodiCate;

	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Selecciona los registros
	$recordset = funEjecutaQuerySelect ("select *,(select IFNULL(SUM(num_inventario),0) from arcimed_ref_inventario where cod_producto=A.COD_PRODUCTO) as num_inventario from arcimed_ref_producto A where A.EST_PRODUCTO='A' $varQuery");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{	
		print '<div style="position:absolute;top:500px;left:700px;width:1500px;height:800px;overflow:scroll">';
		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiProd = trim($results["COD_PRODUCTO"][$varI]);
			$varNombProd = trim($results["NOM_PRODUCTO"][$varI]);
			$varImagProd = trim($results["IMG_PRODUCTO"][$varI]);
			$varPrecProd = trim($results["PRE_PRODUCTO"][$varI]);
			$varDescProd = trim($results["DES_PRODUCTO"][$varI]);			
			$varNumeInve = trim($results["num_inventario"][$varI]);	

			print '<div style="float:left;padding:20px;">';
			print '<table border=1>';
			print '<tr>';
			print '<td align="center">';
			print '<img width="150px" height="180px" src="_upload/' . $varImagProd . '" style="padding-left:20px" />';
			print '</td>';
			print '</tr>';
			print '<tr style="background-color:#2080D0;">';
			print '<td align="center">';
			print '<b style="font-size:20;color:#FFF">Nombre</b>';
			print '</td>';
			print '</tr>';
			print '<tr>';
			print '<td align="center">';
			print '<span style="font-size:20">' . $varNombProd .'</span>';
			print '</td>';
			print '</tr>';
			print '<tr style="background-color:#2080D0;">';
			print '<td align="center">';
			print '<b style="font-size:20;color:#FFF">Precio</b>';
			print '</td>';
			print '</tr>';
			print '<tr>';
			print '<td align="center">';
			print '<span style="font-size:20">$' . $varPrecProd .'</span>';
			print '</td>';
			print '</tr> ';

			if(!empty($_SESSION['conx']))
			{
				if($varNumeInve>0)
				{
					print '<tr>';
					print '<td align="center">';
					print '<a href="#" onclick="comprar('.$varCodiProd.','.$varNumeInve.',this);" ><img src="_imagenes/icono_comprar.png"/></a>';
					print '<div id="paypal" style="display:none;"><form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="SJY7SL22Z6GKJ"></form></div>';
					print '</td>';
					print '</tr> ';	
				}
				else
				{
					print '<tr>';
					print '<td align="center">';
					print 'Sin stock';
					print '</td>';
					print '</tr> ';	
				}	
			}
			
			

			//print '<tr>';
			//print '<td align="center">';
			//print '<span style="font-size:20">$' . $varDescProd .'</span>';
			//print '</td>';
			//print '</tr>';
			print '</table>';
			print '</div>';
		}
		print '</div>';
	}

	funLiberaRecordset ($recordset);
    
	// Cierro la conexión
	funCloseConectionToDataBase();

?>
</body>
</html>