<?
	// importo las librerias
	require "./../_funciones/parametros.php";
	require "./../_funciones/secure.php";
	require "./../_funciones/funciones.php";
	require "./../_funciones/database_$aplDataBaseLibrary.php";
	require "./../_funciones/database_$aplDataBaseLibraryMS.php";

	//funcion de seguridad
	$seguro = new secure();
	$seguro->secureGlobals();
?>

<html>
<head>
	<title>.: KFC - BATCH CLIENTES :.</title>
	<script language="javascript" src="./../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../_funciones/style.css" type="text/css">
</head>
<body bgcolor="<?=$aplBackGroundColor;?>" topmargin="0" marginheight="0" leftmargin="0" marginwidth="0">

<? 
	
	// Se conecta al Servidor y la Base de Datos MSSQL
	funConnectToDataBaseMS ($aplServerMS,$aplUserMS,$aplPasswordMS,$aplDataBaseMS);

	// Se conecta al Servidor y la Base de Datos MySQL
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Selecciona los registros de MySQL
	$recordset = funEjecutaQuerySelect ("select * from " . $aplPrefClie . "_dat_cliente where EST_CLIENTE='I' order by COD_CLIENTE");
	$nr = funDevuelveArregloRecordset ($recordset,$results);
	if ($nr>0) 
	{
		// imprime los regsitros
		for ($varI=0;$varI<$nr;$varI++)
		{
			// guardo los datos en variables
			$varCodiClie = trim($results["COD_CLIENTE"][$varI]);
			$varCiudClie = trim($results["COD_KFCCIUDAD"][$varI]);
			$varTipoClie = trim($results["TIP_CLIENTE"][$varI]);
			$varTipoIdenClie = trim($results["TIP_IDENCLIENTE"][$varI]);
			$varIdenClie = trim($results["IDE_CLIENTE"][$varI]);
			$varNombClie = trim($results["NOM_CLIENTE"][$varI]);
			$varApelClie = trim($results["APE_CLIENTE"][$varI]);
			$varTeleClie = trim($results["TEL_CLIENTE"][$varI]);
			$varEmaiClie = trim($results["EMA_CLIENTE"][$varI]);
			$varEstaClie = trim($results["EST_CLIENTE"][$varI]);
			$varCodiTeleKFC = substr($varTeleClie, 1, strlen($varTeleClie));
			$varMesaAcci = "";

			// valido con los registros de MSSQL
			$recordMS = funEjecutaQuerySelectMS ("select * from Telefono_Cliente where Cod_Telefono=$varCodiTeleKFC and Ruc_Cedula=$varIdenClie");
			$nrMS = funDevuelveArregloRecordsetMS ($recordMS,$resultsMS);
			if ($nrMS>0) 
			{
				// si existe en MSSQL, actualiza el e-mail
				$varMesaAcci = "UPDATE";
				$varFechAcci = date("Y/m/d H:i:s");
				$recordsetMSUpdate = funEjecutaQueryEditMS ("update Clientes set Email='$varEmaiClie' where Ruc_Cedula=$varIdenClie");
				$recordsetMSInsert = funEjecutaQueryEditMS ("insert into Auditoria values ('$varFechAcci','SITIO WEB','$varMesaAcci')");
				// actualizo estado en MySQL
				$recordsetMyUpdate = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_cliente set EST_CLIENTE='V' where COD_CLIENTE=$varCodiClie");
			}
			else
			{
				// no existe en MSSQL, ingresa el registro nuevo
				$varMesaAcci = "INSERT";
				$varFechAcci = date("Y/m/d H:i:s");
				$recordMS_1 = funEjecutaQuerySelectMS ("select * from Clientes where Ruc_Cedula=$varIdenClie");
				$nrMS_1 = funDevuelveArregloRecordsetMS ($recordMS_1,$resultsMS_1);
				if ($nrMS_1==0) 
				{
					$recordsetMSInsert = funEjecutaQueryEditMS ("insert into Clientes values ($varIdenClie,'$varNombClie','$varApelClie','$varEmaiClie','$varFechAcci')");
				}
				funLiberaRecordsetMS ($recordMS_1);
				$recordMS_1 = funEjecutaQuerySelectMS ("select * from Telefono where Cod_Telefono=$varCodiTeleKFC");
				$nrMS_1 = funDevuelveArregloRecordsetMS ($recordMS_1,$resultsMS_1);
				if ($nrMS_1==0) 
				{
					$recordsetMSInsert = funEjecutaQueryEditMS ("insert into Telefono values ($varCodiTeleKFC,$varCiudClie,'$varTeleClie')");
				}
				funLiberaRecordsetMS ($recordMS_1);
				$recordsetMSInsert = funEjecutaQueryEditMS ("insert into Telefono_Cliente values ($varCodiTeleKFC,$varIdenClie)");
				$recordsetMSInsert = funEjecutaQueryEditMS ("insert into Auditoria values ('$varFechAcci','SITIO WEB','$varMesaAcci')");
				// actualizo estado en MySQL
				$recordsetMyUpdate = funEjecutaQueryEdit ("update " . $aplPrefClie . "_dat_cliente set EST_CLIENTE='V' where COD_CLIENTE=$varCodiClie");
			}
			funLiberaRecordsetMS ($recordMS);

			print "<br>" . $varCodiTeleKFC . " - " . $varMesaAcci . " - Ruc_Cliente=" . $varIdenClie;
		}
	}
	else
	{
		print "<br>No exiten clientes nuevos...!!!";
	}
	funLiberaRecordset ($recordset);
    
	// Cierro las conexiones
	funCloseConectionToDataBase();
	funCloseConectionToDataBaseMS();

?>

</body>
</html>