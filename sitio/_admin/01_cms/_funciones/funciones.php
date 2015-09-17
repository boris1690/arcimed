<?

// Función que crea controles textarea con control de caracteres
function funImprimeCampoArea ($parEName, $parECols, $parERows, $parEValue, $parEObligated, $parEReadOnly, $parEClass, $parEStyle, $parENumeChar, $parEClassInvi, $parETipoCont)
{
	// Verifica valores iniciales
	if ($parEReadOnly == "S") $varReadOnly = " readonly"; else $varReadOnly = "";
	if ($parEStyle != "") $varStyle = " style=\"$parEStyle\""; else $varStyle = "";
	if ($parENumeChar == "") $varNumeChar = 0; else $varNumeChar = $parENumeChar - strlen($parEValue);
	if ($varNumeChar > 0) $varFunc = " onKeyPress=\"if ((event.keyCode==34)||(event.keyCode==39)) event.returnValue=false;\" onKeyDown=\"funCuentaCaracteres($parENumeChar,this,document.forms[0]." . $parEName . "MaxiCara);\" onKeyUp=\"funCuentaCaracteres($parENumeChar,this,document.forms[0]." . $parEName . "MaxiCara);\""; else $varFunc = "";

	// Crea el campo
	$varCampo = "<textarea name=\"$parEName\" cols=\"$parECols\" rows=\"$parERows\" obligated=\"$parEObligated\" $varReadOnly class=\"$parEClass\" $varStyle $varFunc tipocont=\"$parETipoCont\">" . trim($parEValue) . "</textarea>";

	// Verifica si debe crear el control de caracteres
	if ($varNumeChar > 0)
	{
		$varCampo = $varCampo . " <input type=\"text\" name=\"" . $parEName . "MaxiCara\" size=\"4\" value=\"" . $varNumeChar . "\" class=\"$parEClassInvi\" readonly>";
	}

	// Devuelve el campo creado
	return $varCampo;
}

// Imprime una Campo Fecha en Formatos de Text Box
function funImprimeCampoFecha ($parEName, $parEValue, $parEObligated, $parEReadOnly, $parEClass, $parEFormat, $parETipoCont)
{
	// Separa los valores del value
	if ($parEValue!="")
	{
		$varAnio = substr($parEValue,0,4);
		$varMes = substr($parEValue,5,2);
		$varDia = substr($parEValue,8,2);
	}
	else
	{
		$varAnio = "";
		$varMes = "";
		$varDia = "";
	}

 	// dia - mes - año (dma)
	if ($parEFormat == "dma")
	{
		// crea la varible con el campo
		if ($parEReadOnly == "N")
		{
			$varCampo = "";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Dia\" size=\"2\" maxlength=\"2\" value=\"$varDia\" obligated=\"$parEObligated\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Mes.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>31)) { alert ('día incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Mes\" size=\"2\" maxlength=\"2\" value=\"$varMes\" obligated=\"$parEObligated\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Anio.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>12)) { alert ('mes incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Anio\" size=\"4\" maxlength=\"4\" value=\"$varAnio\" obligated=\"$parEObligated\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onBlur=\"if (this.value!='') { if (this.value<1900) { alert ('error en el año'); this.value=''; this.focus(); } if (!get_validacion_fecha(" . $parEName . "Dia.value," . $parEName . "Mes.value,this.value)) { alert ('error en el día'); " . $parEName . "Dia.value=''; " . $parEName . "Dia.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;&nbsp;";
		}
		else
		{
			$varCampo = "";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Dia\" size=\"2\" maxlength=\"2\" value=\"$varDia\" obligated=\"$parEObligated\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Mes.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>31)) { alert ('día incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Mes\" size=\"2\" maxlength=\"2\" value=\"$varMes\" obligated=\"$parEObligated\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Anio.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>12)) { alert ('mes incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Anio\" size=\"4\" maxlength=\"4\" value=\"$varAnio\" obligated=\"$parEObligated\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onBlur=\"if (this.value!='') { if (this.value<1900) { alert ('error en el año'); this.value=''; this.focus(); } if (!get_validacion_fecha(" . $parEName . "Dia.value," . $parEName . "Mes.value,this.value)) { alert ('error en el día'); " . $parEName . "Dia.value=''; " . $parEName . "Dia.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;&nbsp;";
		}
	}
	else
	{
		// crea la varible con el campo
		if ($parEReadOnly == "N")
		{
			$varCampo = "";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Mes\" size=\"2\" maxlength=\"2\" value=\"$varMes\" obligated=\"$parEObligated\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Dia.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>12)) { alert ('mes incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Dia\" size=\"2\" maxlength=\"2\" value=\"$varDia\" obligated=\"$parEObligated\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Anio.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>31)) { alert ('dia incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Anio\" size=\"4\" maxlength=\"4\" value=\"$varAnio\" obligated=\"$parEObligated\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onBlur=\"if (this.value!='') { if (this.value<1900) { alert ('error en el año'); this.value=''; this.focus(); } if (!get_validacion_fecha(" . $parEName . "Dia.value," . $parEName . "Mes.value,this.value)) { alert ('error en el día'); " . $parEName . "Dia.value=''; " . $parEName . "Dia.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;&nbsp;";
		}
		else
		{
			$varCampo = "";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Dia\" size=\"2\" maxlength=\"2\" value=\"$varDia\" obligated=\"$parEObligated\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Mes.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>12)) { alert ('mes incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Mes\" size=\"2\" maxlength=\"2\" value=\"$varMes\" obligated=\"$parEObligated\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Anio.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<1)||(this.value>31)) { alert ('dia incorrecto'); this.value=''; this.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;";
			$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Anio\" size=\"4\" maxlength=\"4\" value=\"$varAnio\" obligated=\"$parEObligated\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onBlur=\"if (this.value!='') { if (this.value<1900) { alert ('error en el año'); this.value=''; this.focus(); } if (!get_validacion_fecha(" . $parEName . "Dia.value," . $parEName . "Mes.value,this.value)) { alert ('error en el día'); " . $parEName . "Dia.value=''; " . $parEName . "Dia.focus(); } }\" tipocont=\"$parETipoCont\">&nbsp;&nbsp;";
		}
	}

	// Devuelve el campo creado
	return $varCampo;
}

// Imprime una Campo Hora en Formatos de Text Box
function funImprimeCampoHora ($parEName, $parEValue, $parEReadOnly, $parEClass)
{
	// Separa los valores del value
	if ($parEValue!="")
	{
		$varHora = substr($parEValue,0,2);
		$varMinu = substr($parEValue,3,2);
	}
	else
	{
		$varHora = "";
		$varMinu = "";
	}

	// crea la varible con el campo
	if ($parEReadOnly == "N")
	{
		$varCampo = "";
		$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Hora\" size=\"2\" maxlength=\"2\" value=\"$varHora\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Minu.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<0)||(this.value>23)) { alert ('hora incorrecta'); this.value=''; this.focus(); } }\">&nbsp;";
		$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Minu\" size=\"2\" maxlength=\"2\" value=\"$varMinu\" class=\"$parEClass\" onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onBlur=\"if (this.value!='') { if ((this.value<0)||(this.value>59)) { alert ('minutos incorrectos'); this.value=''; this.focus(); } }\">&nbsp;&nbsp;";
	}
	else
	{
		$varCampo = "";
		$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Hora\" size=\"2\" maxlength=\"2\" value=\"$varHora\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onKeyUp=\"if ((event.keyCode!=9)&&(event.keyCode!=16)) { if (this.value.length==2) " . $parEName . "Minu.focus(); }\" onBlur=\"if (this.value!='') { if ((this.value<0)||(this.value>23)) { alert ('hora incorrecta'); this.value=''; this.focus(); } }\">&nbsp;";
		$varCampo = $varCampo . "<input type=\"text\" name=\"". $parEName . "Minu\" size=\"2\" maxlength=\"2\" value=\"$varMinu\" class=\"$parEClass\" readonly onKeyPress=\"if ((event.keyCode<48)||(event.keyCode>57)) event.returnValue=false;\" onBlur=\"if (this.value!='') { if ((this.value<0)||(this.value>59)) { alert ('minutos incorrectos'); this.value=''; this.focus(); } }\">&nbsp;&nbsp;";
	}

	// Devuelve el campo creado
	return $varCampo;
}

// Función para completar textos con caracters a los lados
function funGPad ($parString, $parLongitud, $parRelleno, $parTendencia)
{
	//Si la longitud del string es mayor a parLongitud, se lo trunca.
	If (strlen($parString) >= $parLongitud)
		$varResultado = substr($parString,0,$parLongitud);
	Else
	{
		//Se rellena el string
		$varResultado = $parString;
		For ($varI=strlen($parString);$varI<=$parLongitud-1;$varI++)
		{
			If ($parTendencia == "D")
				$varResultado = $parRelleno . $varResultado;
			Else // "I"
				$varResultado = $varResultado . $parRelleno;
		}
	}

	return $varResultado;
}

// Función para obtener el nombre del mes
function funObtieneNombreMes ($parEMes,$parELargo)
{
	if ($parEMes == 1)
	{
		if ($parELargo > strlen("Enero"))
			$parELargo = strlen("Enero");
		$varNombMes = substr("Enero",0,$parELargo);
	}
	elseif ($parEMes ==2)
	{
		if ($parELargo > strlen("Febrero"))
			$parELargo = strlen("Febrero");
		$varNombMes = substr("Febrero",0,$parELargo);
	}
	elseif ($parEMes ==3)
	{
		if ($parELargo > strlen("Marzo"))
			$parELargo = strlen("Marzo");
		$varNombMes = substr("Marzo",0,$parELargo);
	}
	elseif ($parEMes == 4)
	{
		if ($parELargo > strlen("Abril"))
			$parELargo = strlen("Abril");
		$varNombMes = substr("Abril",0,$parELargo);
	}
	elseif ($parEMes == 5)
	{
		if ($parELargo > strlen("Mayo"))
			$parELargo = strlen("Mayo");
		$varNombMes = substr("Mayo",0,$parELargo);
	}
	elseif ($parEMes == 6)
	{
		if ($parELargo > strlen("Junio"))
			$parELargo = strlen("Junio");
		$varNombMes = substr("Junio",0,$parELargo);
	}
	elseif ($parEMes == 7)
	{
		if ($parELargo > strlen("Julio"))
			$parELargo = strlen("Julio");
		$varNombMes = substr("Julio",0,$parELargo);
	}
	elseif ($parEMes == 8)
	{
		if ($parELargo > strlen("Agosto"))
			$parELargo = strlen("Agosto");
		$varNombMes = substr("Agosto",0,$parELargo);
	}
	elseif ($parEMes == 9)
	{
		if ($parELargo > strlen("Septiembre"))
			$parELargo = strlen("Septiembre");
		$varNombMes = substr("Septiembre",0,$parELargo);
	}
	elseif ($parEMes == 10)
	{
		if ($parELargo > strlen("Octubre"))
			$parELargo = strlen("Octubre");
		$varNombMes = substr("Octubre",0,$parELargo);
	}
	elseif ($parEMes == 11)
	{
		if ($parELargo > strlen("Noviembre"))
			$parELargo = strlen("Noviembre");
		$varNombMes = substr("Noviembre",0,$parELargo);
	}
	elseif ($parEMes == 12)
	{
		if ($parELargo > strlen("Diciembre"))
			$parELargo = strlen("Diciembre");
		$varNombMes = substr("Diciembre",0,$parELargo);
	}

	return $varNombMes;
}

// Funcion que levanta un mensaje de alerta en Java
function funLevantaAlert ($parEMensaje)
{
	print "\n<script language=\"JavaScript\">";
	print "\n<!--";
	print "\n	alert('$parEMensaje');";
	print "\n-->";
	print "\n</script>";
}

function funObtieneUltimoDiaMes ($parEMes,$parEAnio)
{ 
    $varUltimoDia = 28; 
    while (checkdate($parEMes,$varUltimoDia+1,$parEAnio))
	{ 
       $varUltimoDia++; 
    } 
    return $varUltimoDia; 
}

function funCreaArreglosComboDinamico ($parEIdenArray,$parEArregloDatos,$parENumeRegi,$parECampoFilt,$parECampoCodi,$parECampoText)
{
	print "\n		<script language=\"JavaScript\">";
	print "\n		<!--\n";
	print "\n			var arrFilt$parEIdenArray= new Array($parENumeRegi)";
	print "\n			var arrCodi$parEIdenArray= new Array($parENumeRegi)";
	print "\n			var arrText$parEIdenArray= new Array($parENumeRegi)\n";

	for ($varI=0;$varI<$parENumeRegi;$varI++)
	{
		print "\n			arrFilt$parEIdenArray [$varI]=\"" . trim($parEArregloDatos[$parECampoFilt][$varI]) . "\"";
		print "\n			arrCodi$parEIdenArray [$varI]=\"" . trim($parEArregloDatos[$parECampoCodi][$varI]) . "\"";
		print "\n			arrText$parEIdenArray [$varI]=\"" . trim($parEArregloDatos[$parECampoText][$varI]) . "\"";
	}

	print "\n\n		-->";
	print "\n		</script>\n";
}

// caracteres especiales
function convertir_especiales_html($str){
   if (!isset($GLOBALS["carateres_latinos"])){
      $todas = get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES);
      $etiquetas = get_html_translation_table(HTML_SPECIALCHARS, ENT_NOQUOTES);
      $GLOBALS["carateres_latinos"] = array_diff($todas, $etiquetas);
   }
   $str = strtr($str, $GLOBALS["carateres_latinos"]);
   return $str;
} 
?>