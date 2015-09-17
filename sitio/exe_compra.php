<?
	include('_funciones/parametros.php');
 	include('_funciones/database_mysql.php');

	$varComando = $_POST['cmdComando'];
	$varProducto = $_POST['codProducto'];
	$varCantidad = $_POST['numCantidad'];

	session_start();

	// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// obtengo el codigo ingresado
	$recordset = funEjecutaQuerySelect ("select max(cod_inventario) as cod_inventario from ".$aplPrefClie."_ref_inventario");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) $varCodiInve = $results["cod_inventario"][0] + 1; else $varCodiInve = 1;
	funLiberaRecordset ($recordset);

	// ingreso el registro
	funEjecutaQueryEdit ("insert into " . $aplPrefClie . "_ref_inventario(cod_inventario,cod_producto,cod_cliente,num_inventario,mov_inventario,fec_inventario)
				values ($varCodiInve,$varProducto," . $_SESSION['codigo'] . ",-$varCantidad,'E',NOW())");
    
	// Cierro la conexión
	funCloseConectionToDataBase();

?>

<script>
alert("Su compra ha sido exito");
</script>