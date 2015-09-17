<?php

	session_start();
 	if(!empty($_POST['cmdComamnd']))
 	{
 		$cmdComand = $_POST['cmdComamnd'];

 		if($cmdComand=="Iniciar")
 		{
 			$usuario = $_POST['usuario'];
	 		$password = $_POST['password'];

	 		// Se conecta al Servidor y la Base de Datos
			funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

			// Selecciona los registros
			$recordset = funEjecutaQuerySelect ("select * from arcimed_dat_cliente where (mai_cliente='$usuario' OR ced_cliente='$usuario') AND pas_cliente='$password'");
			$nr = funDevuelveArregloRecordset ($recordset,$results);
			if ($nr>0) 
			{	
				$_SESSION['conx'] = true;
                $_SESSION['codigo'] = $results['cod_cliente'][0];
				$_SESSION['usuario'] = $results['ced_cliente'][0];
				$_SESSION['nombre'] = $results['nom_cliente'][0] . ' ' . $results['ape_cliente'][0];
			}

			funLiberaRecordset ($recordset);
	    
			// Cierro la conexión
			funCloseConectionToDataBase();
 		}
 		elseif($cmdComand=="Cerrar")
 		{
 			session_unset();
 		}
 		
	}
 	
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="_funciones/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<link href="_funciones/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

			<script src="_funciones/SpryAssets/SpryMenuBar.js" type="text/javascript"></script> 
			<style type="text/css">
			.contacto table tr th #form1 p label {
	font-size: x-large;
}
            .contacto table tr th #form1 label {
	font-size: x-large;
}
            #apDiv5 {
	position: absolute;
	left: 730px;
	top: 300px;
	width: 100%;
	height: 100px;
	z-index: 2;
}

#apDivimg {
	position: absolute;
	left: 1441px;
	top: 4px;
	width: 650px;
	height: 288px;
	z-index: 2;
}
#apDiv1 {
	position: absolute;
	left: 1002px;
	top: 43px;
	width: 292px;
	height: 163px;
	z-index: 3;
}
            #apDiv2 {
	position: absolute;
	left: 618px;
	top: 106px;
	width: 188px;
	height: 191px;
	z-index: 4;
}
            #apDiv3 {
	position: absolute;
	left: 805px;
	top: 75px;
	width: 167px;
	height: 192px;
	z-index: 5;
}
            #apDiv4 {
	position: absolute;
	left: 8px;
	top: 29px;
	width: 572px;
	height: 218px;
	z-index: 6;
}
            #apDiv6 {
	position: absolute;
	left: 1709px;
	top: 9px;
	width: 163px;
	height: 22px;
	z-index: 7;
}
            </style>			     
            
</head>

<body>
<div id="apDiv5" >
  <ul id="MenuBar" class="MenuBarHorizontal" >
      <li><a href="inicio.php">Inicio</a>    </li>
    <li> <a href="mvpag.php">Quienes Somos </a></li>
    <li><a href="detalleproductos.php" class="MenuBarItemSubmenu">Productos </a>
    </li>
    <li><a href="contactos.php">Contactos</a></li>
    <li><a href="ayuda.php">Ayuda</a></li>
    <li><a href="registrocliente.php">Registrarse</a></li>
  </ul>
     
<script type="text/javascript">
var MenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"_funciones/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>


</div>
<div id="apDivimg"><img src="_imagenes/banerdoctores2.jpg" width="556" height="296"></div>
<div id="apDiv1"><img src="_imagenes/modificada.jpg" width="445" height="169"></div>
<div id="apDiv2"><img src="_imagenes/tensiometro_beurer_bc32.jpg" width="174" height="191"></div>
<div id="apDiv3"><img src="_imagenes/aaaaa.jpg" width="184" height="184"></div>
<div id="apDiv4"><a href="inicio.php"><img src="_imagenes/imagen_pie.png" width="605" height="226"></a></div>
<div id="apDiv6">
	<?
		if(!empty($_SESSION['usuario'])){
	?>
	<table>
	<form method="post">
		<tr>
			
			<td nowrap><a href="#" style="font-size: x-large;"><?=$_SESSION['nombre']?></a> | <a href="./compras.php" style="font-size: x-large;">Compras</a> <input type="submit" value="Cerrar" name="cmdComamnd"/></td>
		</tr>
	</form>
	</table>
	<?
		}else{
	?>
	<form method="post">
	<table>
		<tr>
			<td>Usuario</td>
			<td><input type="text" name="usuario"/></td>
			<td>Password</td>
			<td><input type="password" name="password"/></td>
			<td><input type="submit" name="cmdComamnd" value="Iniciar" /></td>
		</tr>
	</table>
	</form>
	<? } ?>
</div>
</body>
</html>

