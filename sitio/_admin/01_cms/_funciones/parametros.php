<?
	// ==============================================
	// Parametros para el Sistema - Generales
	// ==============================================

	// Variables de Conexión
	$aplServer		= "bddkfcwebsite.db.8612737.hostedresource.com";
	$aplUser		= "bddkfcwebsite";
	$aplDataBase	= "bddkfcwebsite";
	$aplPassword	= "KfcEcu@dor753";

	// Variables de Libreria de Base de Datos
	$aplAplicationURL = "http://kfcbuenisimo.com/";
	$aplUploadPathArch = "/home/content/37/8612737/html/_upload/";
	$aplBannerPathArch = "/home/content/37/8612737/html/banners/images/";

	// Variables de Conexión MSSQL
	$aplServerMS	= "192.168.100.214";
	$aplUserMS		= "batchclientes";
	$aplDataBaseMS	= "Clientes_Consolidado";
	$aplPasswordMS	= "clientes*88";

	// Variables de base de datos
	$aplDataBaseLibrary = "mysql";
	$aplDataBaseLibraryMS = "mssql";

	// Variable para identificacion del cliente
	$aplPrefClie = "kfc";
	$aplPosfGraf = "ocre";

	// Variable para configurar el nombre de la aplicacion
	$aplNombApli = ".: KFC :.";
	
	// Variables de ayuda de programacion
	$aplDiviChar = "€";
	$aplMaxiNumeCara = 255;
	$aplNumeRegiPagi = 20;
	$aplMaxiFileSize = 2097152; // 2MB
	$aplTipVent = "self"; // popup

	// Variables de control de comportamiento del sistema
	$aplUsuaAdmi = "S";
	$aplBackCont = "N";
	$aplLogeCont = "N";

	// Variable para los envios de correos
	$aplMailServ = "";
	$aplMailTrab = "";

	// =========================================================
	// Parametros para el Sistema - Presentacion
	// =========================================================

	// Variables de Presentacion de Objetos
	$aplBackGroundColor = "#f2f2f2";	
	$aplBackColorEnabled = "#f9f9f9";
	$aplTextColorEnabled = "#3f3f3f";
	$aplBackColorDisabled = "#d7d7d7";
	$aplTextColorDisabled = "#f0f0f0";

	// Variables de Presentacion de Tablas
	$aplTigraBackColorUno = "#f9f9f9";
	$aplTigraBackColorDos = "#f9f9f9";
	$aplTigraBackColorOver = "#f3f2de";
	$aplTigraBackColorSelect = "#dfe1e2";
	$aplFormTableBorderColor = "160,160,128";
	$aplFormTableBackTituColor = "#f0f0f0";
	$aplFormTableBackColor = "#fbfbfb";	
	$aplCommandTableBackColor = "#f3f3f3";
	$aplBackGroundListColor = "#f1f1f1";

	// Colores de la plantilla de Klink
	// blue
	//$aplTituTableBorderColor = "#003a75";
	//$aplTituTableBackColor = "#0173A9";
	// ocre
	$aplTituTableBorderColor = "#a44a06";
	$aplTituTableBackColor = "#cf6e1c";
	// black
	//$aplTituTableBorderColor = "#3e5276";
	//$aplTituTableBackColor = "#5c5c5c";

	// Mensajes de Parametros Obligatorios
	$aplUsuaMens = "The USERNAME does not exist.";
	$aplPassMens = "The PASSWORD is incorrect.";
	$aplLogeMens = "The USER is already loged.";
?>