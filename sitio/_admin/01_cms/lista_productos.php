<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
        <title>Documento sin título</title>
    </head>


    <body>
        <?php
        require "./../../_funciones/parametros.php";
        require "./../../_funciones/funciones.php";
        require "./../../_funciones/database_$aplDataBaseLibrary.php";
        funConnectToDataBase($aplServer, $aplUser, $aplPassword, $aplDataBase);
        session_start();
        ?>

        <div id="menu_productos">
            <?php
            $recordset1 = funEjecutaQuerySelect("SELECT
arcimed_dat_categoria.NOM_CATEGORIA,
arcimed_ref_producto.COD_CATEGORIA,
arcimed_ref_producto.COD_PRODUCTO,
arcimed_ref_producto.NOM_PRODUCTO,
arcimed_ref_producto.PRE_PRODUCTO,
arcimed_ref_producto.IMG_PRODUCTO,
arcimed_ref_producto.DES_PRODUCTO
FROM
arcimed_dat_categoria
INNER JOIN arcimed_ref_producto ON arcimed_dat_categoria.COD_CATEGORIA = arcimed_ref_producto.COD_CATEGORIA");
            $nr = funDevuelveArregloRecordset($recordset1, $results);

            echo '<h1>CAtegorias</h1>';
            for ($varI = 0; $varI < $nr; $varI++) {
                echo "<h1><div name='" . $results["COD_CATEGORIA"][$varI] . "'>" . $results["NOM_CATEGORIA"][$varI] . "</div></h1>";
                echo "<h3><div>" . $results["NOM_PRODUCTO"][$varI] . "</div></h3>";
                echo "<div> VALOR: $" . $results["PRE_PRODUCTO"][$varI] . "</div>";
                echo "<div> <img src= ../../_upload/".$results["IMG_PRODUCTO"][$varI]." width='250' height='250'></div>";
                echo $results["DES_PRODUCTO"][$varI];
            }
            ?>


            <script>
                function myFunction() {

                    var dato = $(this).getAttribute('userID');
                    alert(dato);//document.getElementById("demo")
                }
            </script>


    </body>
</html>

