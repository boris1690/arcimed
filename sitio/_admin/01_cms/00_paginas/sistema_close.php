<?
	// Creo/mantengo la sesi�n abierta (Es indispensable que sea la primera l�nea de c�digo)
	session_start();
	// Destruyo la sesi�n
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