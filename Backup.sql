-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.5.21 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla arcimed.arcimed_dat_categoria
CREATE TABLE IF NOT EXISTS `arcimed_dat_categoria` (
  `COD_CATEGORIA` smallint(3) NOT NULL DEFAULT '0',
  `NOM_CATEGORIA` varchar(60) NOT NULL DEFAULT '',
  `EST_CATEGORIA` char(1) NOT NULL DEFAULT '',
  `ORD_CATEGORIA` smallint(3) DEFAULT NULL,
  PRIMARY KEY (`COD_CATEGORIA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla arcimed.arcimed_dat_categoria: ~6 rows (aproximadamente)
DELETE FROM `arcimed_dat_categoria`;
/*!40000 ALTER TABLE `arcimed_dat_categoria` DISABLE KEYS */;
INSERT INTO `arcimed_dat_categoria` (`COD_CATEGORIA`, `NOM_CATEGORIA`, `EST_CATEGORIA`, `ORD_CATEGORIA`) VALUES
	(1, 'Indumentaria Hospitalaria', 'A', 1),
	(2, 'Diagnostico', 'A', 2),
	(3, 'Laboratorio', 'A', 3),
	(4, 'Instrumental', 'A', 4),
	(5, 'Ortopedia', 'A', 5),
	(6, 'Insumos Medicos', 'A', 6);
/*!40000 ALTER TABLE `arcimed_dat_categoria` ENABLE KEYS */;


-- Volcando estructura para tabla arcimed.arcimed_dat_cliente
CREATE TABLE IF NOT EXISTS `arcimed_dat_cliente` (
  `cod_cliente` int(11) NOT NULL,
  `ced_cliente` varchar(50) DEFAULT NULL,
  `nom_cliente` varchar(50) DEFAULT NULL,
  `ape_cliente` varchar(50) DEFAULT NULL,
  `mai_cliente` varchar(50) DEFAULT NULL,
  `dir_cliente` varchar(50) DEFAULT NULL,
  `tel_cliente` varchar(50) DEFAULT NULL,
  `pas_cliente` varchar(50) DEFAULT NULL,
  `est_cliente` char(1) DEFAULT NULL,
  PRIMARY KEY (`cod_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla arcimed.arcimed_dat_cliente: ~1 rows (aproximadamente)
DELETE FROM `arcimed_dat_cliente`;
/*!40000 ALTER TABLE `arcimed_dat_cliente` DISABLE KEYS */;
INSERT INTO `arcimed_dat_cliente` (`cod_cliente`, `ced_cliente`, `nom_cliente`, `ape_cliente`, `mai_cliente`, `dir_cliente`, `tel_cliente`, `pas_cliente`, `est_cliente`) VALUES
	(1, '1723485882', 'boris', 'benalcazar', 'boris_90@hotmail.es', 'iofdbsiof', 'knvdxkds', '1234', 'A');
/*!40000 ALTER TABLE `arcimed_dat_cliente` ENABLE KEYS */;


-- Volcando estructura para tabla arcimed.arcimed_ref_ciudad
CREATE TABLE IF NOT EXISTS `arcimed_ref_ciudad` (
  `COD_PROVINCIA` smallint(3) NOT NULL DEFAULT '0',
  `COD_CIUDAD` smallint(3) NOT NULL DEFAULT '0',
  `NOM_CIUDAD` char(60) NOT NULL DEFAULT '',
  `EST_CIUDAD` char(1) DEFAULT NULL,
  `COD_KFCCIUDAD` int(11) DEFAULT NULL,
  PRIMARY KEY (`COD_CIUDAD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla arcimed.arcimed_ref_ciudad: ~0 rows (aproximadamente)
DELETE FROM `arcimed_ref_ciudad`;
/*!40000 ALTER TABLE `arcimed_ref_ciudad` DISABLE KEYS */;
/*!40000 ALTER TABLE `arcimed_ref_ciudad` ENABLE KEYS */;


-- Volcando estructura para tabla arcimed.arcimed_ref_inventario
CREATE TABLE IF NOT EXISTS `arcimed_ref_inventario` (
  `cod_inventario` int(11) NOT NULL,
  `cod_producto` int(11) DEFAULT NULL,
  `cod_cliente` int(11) DEFAULT NULL,
  `num_inventario` int(11) DEFAULT NULL,
  `mov_inventario` char(1) DEFAULT NULL,
  `fec_inventario` datetime DEFAULT NULL,
  `fac_estado` char(1) DEFAULT 'N',
  PRIMARY KEY (`cod_inventario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla arcimed.arcimed_ref_inventario: ~44 rows (aproximadamente)
DELETE FROM `arcimed_ref_inventario`;
/*!40000 ALTER TABLE `arcimed_ref_inventario` DISABLE KEYS */;
INSERT INTO `arcimed_ref_inventario` (`cod_inventario`, `cod_producto`, `cod_cliente`, `num_inventario`, `mov_inventario`, `fec_inventario`, `fac_estado`) VALUES
	(1, 11, -1, 1, 'I', '2015-02-26 23:20:21', 'S'),
	(2, 4, -1, 1, 'I', '2015-02-26 23:21:22', 'N'),
	(3, 4, -1, 1, 'I', '2015-02-26 23:21:57', 'N'),
	(4, 4, -1, 1, 'I', '2015-02-26 23:22:05', 'N'),
	(5, 4, -1, 1, 'I', '2015-02-26 23:22:06', 'N'),
	(6, 17, -1, 5, 'I', '2015-02-26 23:29:14', 'N'),
	(7, 6, -1, 8, 'I', '2015-02-26 23:34:45', 'S'),
	(8, 11, 1, -1, 'E', '2015-02-27 10:34:42', 'N'),
	(9, 4, 1, -4, 'E', '2015-02-27 10:38:29', 'N'),
	(10, 6, 1, -8, 'E', '2015-03-08 23:20:36', 'S'),
	(11, 6, -1, 5, 'I', '2015-03-08 23:21:30', 'S'),
	(12, 6, 1, -5, 'E', '2015-03-08 23:21:54', 'S'),
	(13, 6, -1, 3, 'I', '2015-03-08 23:28:27', 'N'),
	(14, 6, 1, -3, 'E', '2015-03-08 23:28:38', 'N'),
	(15, 6, -1, 3, 'I', '2015-03-08 23:29:46', 'N'),
	(16, 6, 1, -3, 'E', '2015-03-08 23:29:54', 'N'),
	(17, 6, -1, 3, 'I', '2015-03-08 23:30:13', 'N'),
	(18, 6, -1, 3, 'I', '2015-03-08 23:30:14', 'N'),
	(19, 6, 1, -1, 'E', '2015-03-08 23:35:08', 'N'),
	(20, 6, 1, -1, 'E', '2015-04-09 23:18:20', 'N'),
	(21, 6, 1, -1, 'E', '2015-04-09 23:18:55', 'N'),
	(22, 6, 1, -1, 'E', '2015-04-09 23:20:44', 'N'),
	(23, 6, 1, -1, 'E', '2015-04-09 23:23:42', 'N'),
	(24, 6, 1, -1, 'E', '2015-04-09 23:24:08', 'N'),
	(25, 17, 1, -1, 'E', '2015-04-09 23:27:07', 'N'),
	(26, 17, 1, -1, 'E', '2015-04-09 23:27:39', 'N'),
	(27, 17, 1, -1, 'E', '2015-04-09 23:28:41', 'N'),
	(28, 17, 1, -2, 'E', '2015-04-13 23:50:50', 'N'),
	(29, 6, -1, 23, 'I', '2015-04-13 23:52:32', 'N'),
	(30, 6, 1, -20, 'E', '2015-04-13 23:52:57', 'N'),
	(31, 6, 1, -1, 'E', '2015-04-13 23:54:14', 'N'),
	(32, 6, 1, -2, 'E', '2015-07-09 18:57:29', 'N'),
	(33, 12, -1, 10, 'I', '2015-07-09 19:12:08', 'N'),
	(34, 12, -1, 10, 'I', '2015-07-09 19:12:12', 'N'),
	(35, 12, 1, -1, 'E', '2015-07-09 19:12:45', 'N'),
	(36, 6, -1, 10, 'I', '2015-07-09 19:24:23', 'N'),
	(37, 6, -1, 10, 'I', '2015-07-09 19:24:25', 'N'),
	(38, 6, 1, -1, 'E', '2015-07-09 19:24:45', 'N'),
	(39, 6, 1, -1, 'E', '2015-07-09 19:25:07', 'N'),
	(40, 6, 1, -1, 'E', '2015-07-09 19:31:02', 'N'),
	(41, 6, 1, -2, 'E', '2015-07-09 19:31:21', 'N'),
	(42, 6, 1, -1, 'E', '2015-07-09 19:31:57', 'N'),
	(43, 6, 1, -2, 'E', '2015-07-09 19:35:07', 'N'),
	(44, 6, 1, -3, 'E', '2015-07-09 19:37:24', 'N');
/*!40000 ALTER TABLE `arcimed_ref_inventario` ENABLE KEYS */;


-- Volcando estructura para tabla arcimed.arcimed_ref_producto
CREATE TABLE IF NOT EXISTS `arcimed_ref_producto` (
  `COD_CATEGORIA` smallint(6) NOT NULL,
  `COD_PRODUCTO` smallint(6) NOT NULL,
  `NOM_PRODUCTO` varchar(120) NOT NULL,
  `DES_PRODUCTO` text NOT NULL,
  `PRE_PRODUCTO` float NOT NULL,
  `IMG_PRODUCTO` varchar(50) DEFAULT NULL,
  `EST_PRODUCTO` char(1) NOT NULL,
  PRIMARY KEY (`COD_PRODUCTO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla arcimed.arcimed_ref_producto: ~23 rows (aproximadamente)
DELETE FROM `arcimed_ref_producto`;
/*!40000 ALTER TABLE `arcimed_ref_producto` DISABLE KEYS */;
INSERT INTO `arcimed_ref_producto` (`COD_CATEGORIA`, `COD_PRODUCTO`, `NOM_PRODUCTO`, `DES_PRODUCTO`, `PRE_PRODUCTO`, `IMG_PRODUCTO`, `EST_PRODUCTO`) VALUES
	(3, 1, 'prod', 'desc', 12, '', ''),
	(2, 4, 'Estetoscopio ADC pedi&aacute;trico', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="LQ8433AVQEM58"> <input type="image" src="https://www.paypalobjects.c', 70, 'imagen_4.jpg', 'A'),
	(2, 5, 'Term&oacute;metro Digital', '<form target=', 5.65, 'imagen_5.jpg', 'I'),
	(2, 6, 'Gluc&oacute;metro', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="SJY7SL22Z6GKJ"> <input type="image" src="https://www.paypalobjects.c', 40, 'imagen_6.jpg', 'A'),
	(2, 7, 'Martillo Buck', 'Martillo Buck reflejos', 6, 'imagen_7.jpg', 'I'),
	(3, 9, 'Embudo 60mm', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="SXGX5BXZK2FDL"> <input type="image" src="https://www.paypalobjects.c', 2.5, 'imagen_9.jpg', 'A'),
	(3, 10, 'Gradilla', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="LKCE5RSR99K4N"> <input type="image" src="https://www.paypalobjects.c', 6, 'imagen_10.jpg', 'A'),
	(3, 11, 'Porta objetos', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="KDM87LCMZUAXE"> <input type="image" src="https://www.paypalobjects.c', 5, 'imagen_11.jpg', 'A'),
	(3, 12, 'Porta Placas', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">\r\n<input type="hidden" name="cmd" value="_s-xclick">\r\n<input type="hidden" name="hosted_button_id" value="55LNLW2DPM56A">\r\n<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">\r\n<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">\r\n</form>\r\n', 5.5, 'imagen_12.jpg', 'A'),
	(5, 13, 'Corrector de espalda', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="D9WVSPCG5KN7J"> <table> <tr><td><input type="hidden" name="on0" valu', 16, 'imagen_13.jpg', 'A'),
	(5, 15, 'Muleta Regulable', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="8TUNM9VUWMMJ2"> <input type="image" src="https://www.paypalobjects.c', 29, 'imagen_15.jpg', 'A'),
	(5, 16, 'Mu&ntilde;equera con inmobilizador de dedo', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="UVQWSSH3LME92"> <table> <tr><td><input type="hidden" name="on0" valu', 16, 'imagen_16.jpg', 'A'),
	(5, 17, 'Baston tipo Canadiense', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="KSBMTSUVNLQ7A"> <input type="image" src="https://www.paypalobjects.c', 16.75, 'imagen_17.jpg', 'A'),
	(6, 18, 'Mascarilla desechable caja x 50', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="NLCMJ47VELVJ6"> <input type="image" src="https://www.paypalobjects.c', 4, 'imagen_18.jpg', 'A'),
	(6, 19, 'Algodon Hidrofilo Sana 500g', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="5BJE4J7YW62JG"> <input type="image" src="https://www.paypalobjects.c', 10.3, 'imagen_19.jpg', 'A'),
	(4, 20, 'Jeringa Carpule articulada', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="ZULBY5Z2HC746"> <input type="image" src="https://www.paypalobjects.c', 10, 'imagen_20.jpg', 'A'),
	(2, 21, 'Term&oacute;metro Digital', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="NY9YLEGCESYCL"> <input type="image" src="https://www.paypalobjects.c', 6, 'imagen_21.jpg', 'A'),
	(2, 22, 'Martillo Buck reflejos', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="TYTBYGKMYKTKE"> <input type="image" src="https://www.paypalobjects.c', 8, 'imagen_22.jpg', 'A'),
	(2, 23, 'Martillo Taylor', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="RWCMDZ5JVCYUU"> <input type="image" src="https://www.paypalobjects.c', 7.5, 'imagen_23.jpg', 'A'),
	(1, 24, 'Bata para paciente', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="UDVPGW8RGZ994"> <table> <tr><td><input type="hidden" name="on0" valu', 12, 'imagen_24.jpg', 'A'),
	(1, 25, 'Mascarilla Tela Antifluidos, anti bacrerial, res H2o Clorada', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="B7YFVR22PJN68"> <input type="image" src="https://www.paypalobjects.c', 5, 'imagen_25.jpg', 'A'),
	(1, 26, 'Mandil para mujer', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="Z2XLNN8E7VGXC"> <table> <tr><td><input type="hidden" name="on0" valu', 25, 'imagen_26.jpg', 'A'),
	(4, 27, 'Explorador Pediatrico', '<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post"> <input type="hidden" name="cmd" value="_s-xclick"> <input type="hidden" name="hosted_button_id" value="2NYS2Y6KYPA7L"> <input type="image" src="https://www.paypalobjects.c', 2.5, 'imagen_27.jpg', 'A');
/*!40000 ALTER TABLE `arcimed_ref_producto` ENABLE KEYS */;


-- Volcando estructura para tabla arcimed.forregistro
CREATE TABLE IF NOT EXISTS `forregistro` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `APELLIDO` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `CI/RUC` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `DIRECCION` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `CIUDAD` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `PROVINCIA` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `TELEFONO` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `COMENTARIO` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Volcando datos para la tabla arcimed.forregistro: ~0 rows (aproximadamente)
DELETE FROM `forregistro`;
/*!40000 ALTER TABLE `forregistro` DISABLE KEYS */;
/*!40000 ALTER TABLE `forregistro` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
