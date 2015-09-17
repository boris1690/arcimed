<?
	// Creo/mantengo la sesión abierta (Es indispensable que sea la primera línea de código)
	session_start();
	// Destruyo la sesión
	$_SESSION = array(); 
	session_destroy();
?>

<html>
<head>
	<title>.: KFC :.</title>

	<script language="javascript">
  	<!-- 
    	function funCierraVentana ()
    	{
			document.location = './../index.php';
		}
	-->	
	</script>

</head>
<body bgcolor="#ffffff" onLoad="funCierraVentana();">
</body>
</html>