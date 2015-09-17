<?PHP include('_funciones/parametros.php');?> 
<?PHP include('_funciones/database_mysql.php');?>
<html>
<head>
<style type="text/css">
#apDivmv {
	position: absolute;
	left: 801px;
	top: 446px;
	width: 1516px;
	height: 826px;
	z-index: 0;
}
</style>
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
</head>
<title> Inicio </title>
<body>
<div id="apDivmv"> 
    <p>&nbsp;</p>
    <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="1024" height="650">
      <param name="movie" value="banerinicio.swf">
      <param name="quality" value="high">
      <param name="wmode" value="opaque">
      <param name="swfversion" value="15.0.0.0">
      <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
      <param name="expressinstall" value="Scripts/expressInstall.swf">
      <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. -->
      <!--[if !IE]>-->
      <object type="application/x-shockwave-flash" data="banerinicio.swf" width="1024" height="650">
        <!--<![endif]-->
        <param name="quality" value="high">
        <param name="wmode" value="opaque">
        <param name="swfversion" value="15.0.0.0">
        <param name="expressinstall" value="Scripts/expressInstall.swf">
        <!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
        <div>
          <h4>El contenido de esta página requiere una versión más reciente de Adobe Flash Player.</h4>
          <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
        </div>
        <!--[if !IE]>-->
      </object>
      <!--<![endif]-->
    </object>
</div>
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
</body>
<?PHP include('header.php'); ?>
<?PHP include('productos.php'); ?>
<?PHP include('foot.php'); ?>

</html>