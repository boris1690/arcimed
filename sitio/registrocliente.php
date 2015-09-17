
<?PHP include('_funciones/parametros.php');?> 
<?PHP include('_funciones/database_mysql.php');?> 


<?PHP

    if(!empty($_POST['botonregistro']))
    {
          $nombre = $_POST['nombreregistro'];
          $apellido = $_POST['apellidoregitro'];
          $cedula = $_POST['cirucregistro'];
          $mail = $_POST['emailregistro'];
          $direccion = $_POST['dirregistro'];
          $passregistro = $_POST['passregistro'];
          $passregistro2 = $_POST['passregistro2'];
          $telefonoregistro = $_POST['telregistro'];

          // Se conecta al Servidor y la Base de Datos
          funConnectToDataBase ($aplServer,$aplUser,$aplPassword,$aplDataBase);

          $recordset = funEjecutaQuerySelect ("select max(cod_cliente) as cod_cliente from arcimed_dat_cliente");
          $nr = funDevuelveArregloRecordset ($recordset,$results);
          if ($nr>0) $varCodiClie = $results["cod_cliente"][0] + 1; else $varCodiClie = 1;
          funLiberaRecordset ($recordset);

          $recordset = funEjecutaQuerySelect ("select * from arcimed_dat_cliente where ced_cliente='" . trim($cedula) . "'");
          $nr = funDevuelveArregloRecordset ($recordset,$results);
          if ($nr>0)
          {
             print "<script>alert('El usuario ya existe');</script>";
          }
          else
          {
            if($passregistro==$passregistro2)
            {
              funEjecutaQueryEdit ("insert into arcimed_dat_cliente (cod_cliente,ced_cliente,nom_cliente,ape_cliente,mai_cliente,dir_cliente,tel_cliente,pas_cliente,est_cliente)
              values ($varCodiClie,'$cedula','$nombre','$apellido','$mail','$direccion','$telefonoregistro','$passregistro','A')");

              print "<script>alert('Se ha registrado con exito.');</script>";

            }
            else
            {
              print "<script>alert('La contraseña no es la misma');</script>";
            }

          }
          funLiberaRecordset ($recordset);

          // Cierro la conexión
          funCloseConectionToDataBase();



    }

?>

<html>
<head>



<title>Resgistro</title>
<link href="_funciones/styles.css" rel="stylesheet" type="text/css" />
<link href="_funciones/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.Formatoletra {
  font-size: x-large;
  text-align: left;
}
</style>

<?PHP include('header.php'); ?>
<?PHP include('productos.php'); ?>
<?PHP include('foot.php'); ?>
</head>

<body>
<form action="registrocliente.php" method="post" style="padding-left:700px;padding-top:400px;" >
<p class="Formatoletra">Formulario de Registro de Clientes</p>
  <table width="711" border="0">
    <tr>
      <td width="313"><div align="right"><span class="Formatoletra">Nombres </span></div></td>
      <td width="388"><input name="nombreregistro" type="text" required="required" class="Formatoletra" id="nombreregistro" size="45" /></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Formatoletra">Apellidos</span></div></td>
      <td><span class="Formatoletra">
        <input name="apellidoregitro" type="text" required="required" class="Formatoletra" id="apellidoregitro" size="45" maxlength="70" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Formatoletra">C.I / RUC</span></div></td>
      <td><span class="Formatoletra">
        <label for="cirucregistro"></label>
        <input name="cirucregistro" type="text" required="required" class="Formatoletra" id="cirucregistro" onkeypress="return validar(event)" size="45" maxlength="13" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Formatoletra">Correo Electronico</span></div></td>
      <td><span class="Formatoletra">
        <input name="emailregistro" type="text" class="Formatoletra" id="emailregistro" size="45" requiered="requiered" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Formatoletra">Direccion</span></div></td>
      <td><span class="Formatoletra">
        <input name="dirregistro" type="text" required="required" class="Formatoletra" id="dirregistro" size="45" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Formatoletra">Contraseña</span></div></td>
      <td><span class="Formatoletra">
        <input name="passregistro" type="text" required="required" class="Formatoletra" id="ciudadregistro2" size="45" />
      </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Formatoletra">Repetir contraseña</span></div></td>
      <td><span class="Formatoletra">
        <input name="passregistro2" type="text" required="required" class="Formatoletra" id="ciudadregistro" size="45" />
      </span></td>
    </tr>
    <tr>
      <td height="40"><div align="right"><span class="Formatoletra">Telefono</span></div></td>
      <td><span class="Formatoletra">
        <input name="telregistro" type="text" required="required" class="Formatoletra" id="telregistro" onkeypress="return validar(event)" size="45"  maxlength="15"/>
      </span></td>
    </tr>
    <tr>
      <td height="40">&nbsp;</td>
      <td><span class="Formatoletra">
        <input name="botonregistro" type="submit" class="Formatoletra" id="botonregistro" value="Registrar  " />
      </span></td>
    </tr>
  </table>
  <p class="Formatoletra">
    </form>

</body>
</html>