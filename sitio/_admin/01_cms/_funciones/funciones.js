
// Funcion que Levanta una Ventana PopUp
function funLevantaPopUp (parENombVent, parEDireUrl, parEScrollBars, parEResizable, parEWidth, parEHeight, parELeft, parETop)
{
	// Declaracion de Variables
	var varFlyout;

	// Setea el ancho máximo de la ventana y la centro si no se paso un valor 
	// de parametro o si el valor es mayor al máximo permitido
	if ((parEWidth>=screen.width-12)||(parEWidth==""))
	{
		parEWidth = screen.width - 12;
		parELeft = 0;
	}

	// Setea el alto máximo de la ventana y la centro si no se paso un valor
	// de parametro o si el valor es mayor al máximo permitido
	if ((parEHeight>=screen.height-58)||(parEHeight==""))
	{
		parEHeight = screen.height - 58;
		parETop = 0;
	}

	// Centra la ventana a lo ancho si no se paso un valor de parametro
	if ((parELeft=="")&&(parELeft!="0"))
	{
		parELeft = (screen.width - 12 - parEWidth) / 2;
	}

	// Centra la ventana a lo alto si no se paso un valor de parametro
	if ((parETop=="")&&(parETop!="0"))
	{
		parETop = (screen.height - 58 - parEHeight) / 2;
	}

	// Crea la nueva ventana
	varFlyout = window.open(parEDireUrl,parENombVent,"resizable=" + parEResizable + ",scrollbars=" + parEScrollBars + ",width=" + parEWidth + ",height=" + parEHeight + ",top=" + parETop + ",left=" + parELeft)

	// Devuelve el Objeto de la ventana creada
	return varFlyout;
}

// Funcion que cuenta el numero de caracteres ingresado en un textarea
function funCuentaCaracteres(parENumeMaxi,parETextArea,parETextMaxi)
{
	// Variables
	varLargo = parENumeMaxi;
	varLargTextArea = parETextArea.value.length;
	varValoTextArea = parETextArea.value;

	// Actualizo el texto de ayuda
	if (parETextMaxi != null) parETextMaxi.value = varLargo - varLargTextArea;

	// Verifico si debo bloquear el campo
	if (varLargTextArea >= varLargo)
	{
		parETextArea.value = varValoTextArea.substring(0,varLargo)
		if (parETextMaxi != null) parETextMaxi.value = 0;
	}
}

// Funcion que valida si un e-mail esta bien ingresado
function funValidaMail (parEMail)
{
	varPasa=0;
	varCuenta=0;

	// Verifica que exista la cadena del e-mail
	if (parEMail.value.length==0) return false;

	// Verifica el que exista el (@)
	for (varI=0;varI<parEMail.value.length;varI++)
	{
		EsteCaracter=parEMail.value.substring(varI,varI+1);
		if (EsteCaracter == "@")
		{
			varCuenta++;
			varPosi=varI;
		}
	}

	// Verifica que exista solo 1 (@)
	if (varCuenta == 1)
		varPasa=1;
	else
		varPasa=0;

	// Verifica que haya por lo menos un (.) despues del (@)
	if (varPasa==1)
	{
		varPasa = 0;
		for (varI=varPosi+1;varI<parEMail.value.length-1;varI++)
		{
			EsteCaracter=parEMail.value.substring(varI,varI+1);
			if (EsteCaracter == ".") varPasa=1;
		}
	}

	// Devuelve el exito o fracaso de la validacion
	if (varPasa == 1)
		return true;
	else
		return false;
}

function funLlenaComboFiltrado (parECombo,arrEListFilt,arrEListCodi,arrEListText,parEFilt,parECodiSele,parEOpciInic,parECodiOpciInic,parETextOpciInic)
{
	varLen = arrEListCodi.length;
	parECombo.length = 0;
	varPosiSele = -1;

	if (parEOpciInic=="S")
	{
		parECombo.length = parECombo.length + 1;			
		parECombo.options[parECombo.length-1].value = parECodiOpciInic;
		parECombo.options[parECombo.length-1].text = parETextOpciInic;
	}

	for (varI=0;varI<varLen;varI++)
	{
		if (arrEListFilt[varI]==parEFilt)
		{
			parECombo.length = parECombo.length + 1;			
			parECombo.options[parECombo.length-1].value = arrEListCodi[varI];
			parECombo.options[parECombo.length-1].text = arrEListText[varI];
			if ((parECodiSele!="")&&(parECodiSele==arrEListCodi[varI]))
			{
				varPosiSele = parECombo.length-1;
			}
		}
	}
	if (varPosiSele!=-1) parECombo.options.selectedIndex = varPosiSele;
}

// verifica que una fecha sea valida
function get_validacion_fecha (input_dia, input_mes, input_anio)
{
	// declaracion de variables
	var var_ultimo_dia;

	// realiza la validacion solo si todos los datos estan completos
	if ((input_dia != '')&&(input_mes != '')&&(input_anio != ''))
	{
		var_ultimo_dia = get_month_lastday (parseFloat(input_mes), parseFloat(input_anio));
		if ((parseFloat(input_dia)<1)||(parseFloat(input_dia)>var_ultimo_dia)) return false
	}

	// devuelve el resultado de la validacion
	return true;
}

// recupera el ultimo dia del mes en un anio
function get_month_lastday (input_mes, input_anio)
{
	// declaracion de variables
	var var_ultimo_dia, var_division_decimal, var_division_entera

	// enero / marzo / mayo / julio / agosto / octubre / diciembre
	if ((input_mes == 1)||(input_mes == 3)||(input_mes == 5)||(input_mes == 7)||(input_mes == 8)||(input_mes == 10)||(input_mes == 12))
	{
		var_ultimo_dia = 31;
	}

	// abril / junio / septiembre / noviembre
	else if ((input_mes == 4)||(input_mes == 6)||(input_mes == 9)||(input_mes == 11))
	{
		var_ultimo_dia = 30;
	}

	// febrero (valida anio bisiciesto)
	else if (input_mes == 2)
	{
		var_division_decimal = input_anio / 4;
		var_division_entera = parseInt(var_division_decimal);
		if (var_division_decimal == var_division_entera) var_ultimo_dia = 29; else var_ultimo_dia = 28;
	}

	// devuelve el ultimo dia del mes
	return var_ultimo_dia;
}

// controla el ingreso del punto decimal y el numero de decimales permitidos en un objeto
function controla_digitacion_decimal (input_event, input_object, input_decimales)
{
	// declaracion de variables
	var var_deci_posi, var_nume_leng, var_nume_deci, var_keycode;

	// recupero el codigo de la tecla pulsada (FF)
	var_keycode = input_event.charCode || input_event.keyCode;

	// permite el ingreso de caracteres de navegacion (FF)
	// delete / suprimir (se confunde con .) / tab / enter / F5 / <- / -> (se confunde con ') (FF)
	//if ((!window.event)&&((var_keycode == 8)||(var_keycode == 46)||(var_keycode == 9)||(var_keycode == 13)||(var_keycode == 116)||(var_keycode == 37)||(var_keycode == 39))) return true;
	if ((!window.event)&&((var_keycode == 8)||(var_keycode == 9)||(var_keycode == 13)||(var_keycode == 116)||(var_keycode == 37))) return true;

	// si no permite decimales entonces solo puede digitar numeros
	if (input_decimales != 0)
	{
		// valida que la tecla digitada este en el rango de los numeros + el punto decimal (FF)
		if (((var_keycode<48)||(var_keycode>57))&&(var_keycode!=46)) 
			if (window.event) input_event.returnValue = false; else input_event.preventDefault();

		// valida si ya existe un punto decimal
		if ((input_object.value.indexOf('.') != -1)&&(var_keycode == 46))
			if (window.event) input_event.returnValue = false; else input_event.preventDefault();

		// valida el numero de decimales
		var_deci_posi = input_object.value.indexOf('.')
		if (var_deci_posi != -1)
		{
			var_nume_leng = input_object.value.length
			var_nume_deci = var_nume_leng - var_deci_posi;
			if (var_nume_deci > input_decimales)
				if (window.event) input_event.returnValue = false; else input_event.preventDefault();
		}
	}
	else 
	{
		// valida que la tecla digitada este en el rango de los numeros
		if ((var_keycode<48)||(var_keycode>57))
			if (window.event) input_event.returnValue = false; else input_event.preventDefault();
	}
}

// Funcion que valida el ingreso de decimales y punto decimal al digitar una tecla
function funValidaValorNumericoDigito(parECajaNume,parENumeDeci)
{
	// declaracion de variables
	var varPosi, varLen, varNumeDeciActu;

	// Valido si puede ingresar el punto decimal
	if (parENumeDeci == '0') 
	{
		// solo numeros
		if (((event.keyCode<48)||(event.keyCode>57))&&(event.keyCode!=45)) event.returnValue = false;
		// valido si ya existe un signo menos
		varPosi = parECajaNume.value.indexOf('-')
		if ((varPosi != -1)&&(event.keyCode == 45)) event.returnValue = false;
	} 
	else 
	{
		// solo numeros y punto
		if (((event.keyCode<48)||(event.keyCode>57))&&(event.keyCode!=46)&&(event.keyCode!=45)) event.returnValue = false;
		// valido si ya existe un punto decimal
		varPosi = parECajaNume.value.indexOf('.')
		if ((varPosi != -1)&&(event.keyCode == 46)) event.returnValue = false;
		// valido si ya existe un signo menos
		varPosi = parECajaNume.value.indexOf('-')
		if ((varPosi != -1)&&(event.keyCode == 45)) event.returnValue = false;
	}
}

// redondea un numero
function redondea_valor_numerico (input_numero, input_decimales, input_decimal_char)
{
	// declaracion de variables
	var var_rounder;
	var var_decimales;
	var var_ceros;
	var var_i;

	if (input_decimales > 0) 
	{
		if ((input_numero.toString().length - input_numero.toString().lastIndexOf(input_decimal_char)) > (input_decimales + 1))
		{
			var_rounder = Math.pow(10, input_decimales);
			input_numero = Math.round(input_numero * var_rounder) / var_rounder;

			var_ceros = "";
			var_decimales = input_numero.toString().length - input_numero.toString().lastIndexOf(input_decimal_char) - 1;

			if (input_numero.toString().lastIndexOf(input_decimal_char)>0)
			{
				for (var_i=var_decimales;var_i<input_decimales;var_i++)
				{
					var_ceros = var_ceros + "0";
				}
				input_numero = input_numero + var_ceros;
			}
			else 
			{
				for (var_i=0;var_i<input_decimales;var_i++)
				{
					var_ceros = var_ceros + "0";
				}
				input_numero = input_numero + "." + var_ceros;
			}

			return input_numero;
		}
		else
		{
			var_ceros = "";
			var_decimales = input_numero.toString().length - input_numero.toString().lastIndexOf(input_decimal_char) - 1;

			if (input_numero.toString().lastIndexOf(input_decimal_char)>0)
			{
				for (var_i=var_decimales;var_i<input_decimales;var_i++)
				{
					var_ceros = var_ceros + "0";
				}
				input_numero = input_numero + var_ceros;
			}
			else 
			{
				for (var_i=0;var_i<input_decimales;var_i++)
				{
					var_ceros = var_ceros + "0";
				}
				input_numero = input_numero + "." + var_ceros;
			}

			return input_numero;
		}
	}
	else 
		return Math.round(input_numero);
}

// cambia el texto de un TD
function cambia_innerText (input_object_TD, input_texto)
{
	if (document.all)
		input_object_TD.innerText = input_texto;
	else
		input_object_TD.textContent = input_texto;
}