<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pedido</title>
<style type="text/css">
.formato {
	font-size: 22px;
	font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
}
</style>
</head>
<body>	
<p class="formato">PEDIDO</p>
<table width="702" border="0">
  <tr>
    <td width="190"><div align="right" class="formato">Num. pedido </div></td>
    <td width="502"><form id="form1" name="form1" method="post" action="">
      <label for="numpedido"></label>
      <div align="right">
        <input name="numpedido" size="45" type="text" class="formato" id="numpedido" />
      </div>
    </form></td>
  </tr>
  <tr>
    <td><div align="right" class="formato">Nombre del cliente</div></td>
    <td class="formato"><form id="form2" name="form2" method="post" action="">
      <label for="clientepedio"></label>
      <div align="right">
        <input name="clientepedio" size="45" type="text" class="formato" id="clientepedio" />
      </div>
    </form></td>
  </tr>
  <tr>
    <td><div align="right" class="formato">C.I. / RUC. </div></td>
    <td class="formato"><form id="form3" name="form3" method="post" action="">
      <label for="correocliente"></label>
      <label for="ruccliente"></label>
      <div align="right">
        <input name="ruccliente" type="text"  size="45" class="formato" id="ruccliente" />
      </div>
    </form></td>
  </tr>
  <tr>
    <td><div align="right" class="formato">Correo electronico</div></td>
    <td class="formato"><div align="right">
      <input name="correocliente" type="text" class="formato" id="correocliente" size="45" />
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>