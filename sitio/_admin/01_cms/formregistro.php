
<html>
<title>.: Arcimed :.</title>
	<script language="javascript" src="./../../_funciones/tigra_tables.js"></script>
	<link rel="stylesheet" href="./../../_funciones/style.css" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.Formatoletra {
	font-size: x-large;
	text-align: left;
}
</style>
</head>

<?
	// abre y mantiene la sesion
	session_start();
	header("Cache-control: private");
	// importo las librerias
	require "./../../_funciones/parametros.php";	
	require "./../../_funciones/funciones.php";
	require "./../../_funciones/database_$aplDataBaseLibrary.php";
// Se conecta al Servidor y la Base de Datos
	funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

	// Recupero el Usuario
	$varUserUser = $_SESSION['User_User'];
?>
<script type="text/javascript">
function validar(e) {  
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==44) return true; //Coma ( En este caso para diferenciar los decimales )
    if (tecla==48) return true;
    if (tecla==49) return true;
    if (tecla==50) return true;
    if (tecla==51) return true;
    if (tecla==52) return true;
    if (tecla==53) return true;
    if (tecla==54) return true;
    if (tecla==55) return true;
    if (tecla==56) return true;
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
</script> 
<body>
<p class="Formatoletra">Formulario de Compra </p>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">
  <p><span class="Formatoletra">Nombres   </span>
    <input name="nombreregistro" type="text" id="nombreregistro" size="45" required="required" />
  </p>
  <p class="Formatoletra">Apellidos  
    <label for="apellidoregitro"></label>
    <input name="apellidoregitro" type="text" id="apellidoregitro" size="45" maxlength="70" required="required" />
  </p>
  <p class="Formatoletra">C.I / RUC 
    <label for="cirucregistro"></label>
    <input name="cirucregistro" type="text" required="required" id="cirucregistro" size="20" onKeyPress="return validar(event)" maxlength="13" />  </p>
  <p class="Formatoletra">Email      
    <label for="emailregistro"></label>
    <input name="emailregistro" type="text" id="emailregistro" size="45" requiered="requiered" />
  </p>
  <p class="Formatoletra">Direccion  
    <label for="dirregistro"></label>
    <input name="dirregistro" type="text" id="dirregistro" size="55" required="required" />
  </p>
  <p class="Formatoletra">Cuidad 
    <label for="ciudadregistro"></label>
    <input name="ciudadregistro" type="text" id="ciudadregistro" size="45" required="required" />
  </p>
  <p class="Formatoletra">Provincia
    <label for="ciudadregistro"></label>
    <input name="ciudadregistro2" type="text" id="ciudadregistro" size="45" required="required" />
  </p>
  <p class="Formatoletra">Telefono (s)  
    <label for="telregistro"></label>
    <input name="telregistro" type="text" id="telregistro" size="40" required="required" />
  </p>
  <p class="Formatoletra">&nbsp;</p>
  <p class="Formatoletra">Comentarios / Instrucciones especiales :</p>
  <p class="Formatoletra">
    <label for="comenregistro"></label>
    <textarea name="comenregistro" id="comenregistro" cols="75" rows="12"></textarea>
  </p>
  <p class="Formatoletra">
    <input type="submit" name="botonregistro" id="botonregistro" value="Enviar" />
  </p>
  <p class="Formatoletra">&nbsp;</p>

  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
</body>

</html>