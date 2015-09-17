<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
        <title>Documento sin título</title>
    </head>


    <body>

        <?php
        session_start();

        require "./../../_funciones/parametros.php";
        require "./../../_funciones/funciones.php";
        require "./../../_funciones/database_$aplDataBaseLibrary.php";
        $categoria = $_POST["categoria"]
        ?>


        <?php
// Se conecta al Servidor y la Base de Datos
        funConnectToDataBase($aplServer, $aplUser, $aplPassword, $aplDataBase);



// obtengo el codigo ingresado
        $recordset = funEjecutaQuerySelect("SELECT * FROM arcimed_dat_categoria");
        $nr = funDevuelveArregloRecordset($recordset, $results);


        for ($varI = 0; $varI < $nr; $varI++) {

            echo "<div name='".$results["COD_CATEGORIA"][$varI]."'>" . $results["NOM_CATEGORIA"][$varI] . "</div>";
            
        }
        ?>
    </body>
</html>

