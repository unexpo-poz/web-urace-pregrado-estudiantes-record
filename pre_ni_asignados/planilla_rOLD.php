<?php
	include_once('inc/vImage.php');
    include_once('inc/odbcss_c.php');
	include_once ('inc/config.php');
	include_once ('inc/activaerror.php');

	// no revisa la imagen de seguridad si regresa por conflicto en el servidor
	$vImage = new vImage();
	if (!isset($_REQUEST['conducta'])) {
		$vImage->loadCodes();
	}
	$_d = array();
	$nVariables = array('nac_e','ci_e','res_extraj','doc_ident','pasaporte_nro',
		'apellidos','apellidos2','nombres','nombres2','f_nac_e','exp_e','p_nac_e',
		'l_nac_e','edo_c_e','sexo','correo1','correo2','avenida','urbanizacion',
		'manzana','nrocasa','ciudad','estado','telefono1','telefono2','telefono3','dirr_e','telfr_e',
		'c_uni_ca','conducta','becario','carrera','trabaja','turno_trabajo','plantel',
		'tipo_plantel','costo_mensual','sistema_estudio','turno_estudio','titulo_b',
		'promedio','c_ingreso','ingreso','instr_padre','ocup_padre','instr_madre',
		'ocup_madre','tipo_vivienda','monto_alq','ingreso_f','opcion_cnu','ind_cnu',
		'organismo','etnia_indigena','sit_e','estrato_social','codigo_c','codigo_e','codigo_p','codigo_m','ano_egre_cole','ent_fed','tipo_disca','carnet_disca','afrodescen');
	
	$archivoAyuda = $raizDelSitio."instrucciones.php";
    $datos_p   = array();
    $mat_pre   = array();
    $depositos = array();
    $fvacio	   = TRUE;
    $lapso = $lapsoProceso;
    $inscribe = "";
	$cedYclave = array();


	function quitar_blancos($cadena) {
		// Expresiones regulares que representan respectivamente a los
		// blancos del principio, de en medio y del final de una cadena
		static $expresion_blancos = array("/^[ ]+/m", "/[ ]+/m", "/[ ]+\$/m");
		// Cadenas que sustituyen  respectivamente a los blancos del
		// principio, de en medio y del final de una cadena
		static $blancos = array("", " ", "");
		return preg_replace($expresion_blancos, $blancos, $cadena);
	}


	function leerDatosP($ced, $data) {
		global $sede;
		global $nucleos;
		global $vImage;
		global $_d, $nVariables;

		//si regresa de un intento por preinscribirse, leer los datos enviados
		if (isset($_REQUEST['conducta'])) {
			reset($_d);
			while (list($nombre, $valor) = each($_REQUEST)) {
				$_d[$nombre] = $valor;
			}
			return; //terminar, ya tenemos los datos enviados originalmente
		}
       	$Cdatos_p   = new ODBC_Conn("NINGRESO","c","c",true,'log/accesos.log');
		$dSQL     = "SELECT nac_e,ci_e,res_extraj,doc_ident,pasaporte_nro,";
		$dSQL    .= "apellidos,apellidos2,nombres,nombres2,f_nac_e,A.exp_e,";
		$dSQL    .= "p_nac_e,l_nac_e,edo_c_e,sexo,correo1,correo2,avenida,";
		$dSQL    .= "urbanizacion,manzana,nrocasa,ciudad,estado,telefono1,";
		$dSQL	 .= "telefono2,telefono3,dirr_e,telfr_e,";
		$dSQL    .= "A.c_uni_ca,conducta,A.becario,carrera,trabaja,turno_trabajo,plantel,";
		$dSQL    .= "tipo_plantel,costo_mensual,sistema_estudio,turno_estudio,titulo_b,";
		$dSQL    .= "promedio,A.c_ingreso,ingreso,instr_padre,ocup_padre,instr_madre,ocup_madre,";
		$dSQL    .= "tipo_vivienda,monto_alq,ingreso_f,opcion_cnu,ind_cnu,organismo,etnia_indigena,";
		$dSQL	 .= "sit_e,estrato_social, ";
		
		$dSQL    .= "codigo_c,codigo_e,codigo_p,codigo_m, ";
		$dSQL    .= "ano_egre_cole,ent_fed,tipo_disca,carnet_disca,afrodescen ";

		$dSQL    .= "FROM dace002 A, tipo_ingreso B, tblaca010 C, ";
		$dSQL    .= "dobe_academico D, dobe_socioeconomic E ";
		$dSQL    .= "WHERE ci_e='$ced' AND conducta is NULL AND ";
		$dSQL    .= "A.exp_e=D.exp_e AND A.exp_e=E.exp_e AND ";
		$dSQL    .= "A.c_uni_ca=C.c_uni_ca AND A.c_ingreso=B.c_ingreso";
			
		$Cdatos_p->ExecSQL($dSQL,__LINE__,true);
		if ($Cdatos_p->filas == 1){
			$_d = array_combine($nVariables, $Cdatos_p->result[0]);
		}
		else {	//Buscar en CDACE002
		
			//$Cdatos_p   = new ODBC_Conn("NINGRESO","c","c",true,'log/accesos.log');
			$dSQL     = "SELECT nac_e,ci_e,res_extraj,doc_ident,pasaporte_nro,";
			$dSQL    .= "apellidos,apellidos2,nombres,nombres2,f_nac_e,A.exp_e,";
			$dSQL    .= "p_nac_e,l_nac_e,edo_c_e,sexo,correo1,correo2,avenida,";
			$dSQL    .= "urbanizacion,manzana,nrocasa,ciudad,estado,telefono1,";
			$dSQL	 .= "telefono2,telefono3,dirr_e,telfr_e,";
			$dSQL    .= "A.c_uni_ca,conducta,A.becario,carrera,trabaja,turno_trabajo,plantel,";
			$dSQL    .= "tipo_plantel,costo_mensual,sistema_estudio,turno_estudio,titulo_b,";
			$dSQL    .= "promedio,A.c_ingreso,ingreso,instr_padre,ocup_padre,instr_madre,ocup_madre,";
			$dSQL    .= "tipo_vivienda,monto_alq,ingreso_f,opcion_cnu,ind_cnu,organismo,etnia_indigena,";
			$dSQL	 .= "sit_e,estrato_social ";
			$dSQL    .= "FROM cdace002 A, tipo_ingreso B, tblaca010 C, ";
			$dSQL    .= "cdobe_academico D, cdobe_socioeconomi E ";
			$dSQL    .= "WHERE ci_e='$ced' AND conducta is NULL AND ";
			$dSQL    .= "A.exp_e=D.exp_e AND A.exp_e=E.exp_e AND ";
			$dSQL    .= "A.c_uni_ca=C.c_uni_ca AND A.c_ingreso=B.c_ingreso";
			
			$Cdatos_p->ExecSQL($dSQL,__LINE__,true);
			if ($Cdatos_p->filas == 1){
				$_d = array_combine($nVariables, $Cdatos_p->result[0]);
				print_r($_d);
			} else {
				$auxArray = array_fill(0, count($nVariables),'');
				$_d = array_combine($nVariables, $auxArray);
				
				//echo $data[7]."-".$data[8]."-".$data[]."-".$readonly;
	
				$_d['ci_e']	= $data[0];
				$_d['exp_e'] = $data[0];//valor inicial de expediente,para que no quede en blanco
				$_d['apellidos'] = $data[1];
				$_d['c_uni_ca']  = $data[3];
				$_d['carrera']   = $data[4];
				$_d['c_ingreso'] = $data[5];
				$_d['ingreso']   = $data[6];
				$_d['promedio']  = $data[7];
				$_d['ind_cnu']   = $data[8];
				$_d['sit_e']     = $data[9];

			}
			//print $_d['exp_e'];

		}
	}
	function cedula_valida($ced,$apellidos) {
        global $datos_p, $elApellido;
        global $lapso;
        global $lapsoProceso;
        global $sede;
		global $nucleos;
		global $vImage;
		global $masterID,$tablaOrdenInsc;

        $ced_v   = false;
        $clave_v = false;
		$encontrado = false;
        if ($ced != ""){
            $Cdatos_p   = new ODBC_Conn("NINGRESO","c","c");
			// buscar si esta en la lista:
			$dSQL = "SELECT cedula, apellidos,nombres, A.c_uni_ca,carrera, A.c_ingreso,ingreso,";
			$dSQL.= "promedio,ind_cnu,rusnies ";
			$dSQL.= "FROM lista_nuevos A, tblaca010 B, tipo_ingreso C WHERE cedula='$ced'";
			$dSQL.= " AND apellidos LIKE('%$apellidos%') AND A.c_uni_ca=B.c_uni_ca AND A.c_ingreso=C.c_ingreso AND impreso is NULL";
			$Cdatos_p->ExecSQL($dSQL);
			if ($Cdatos_p->filas == 1){ 
				//Si lo encontro en la lista, busca sus datos en dace002
				$ced_v = true;
				$data  = $Cdatos_p->result[0];
				if (strpos($data[1], " ") === false)
					$elApellido = $data[1];
				else
					$elApellido = substr($data[1], 0, strpos($data[1], " "));
$dFija = array($data[0],$elApellido,'',$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9]);
				$datosp = leerDatosP($ced,$dFija);
			}
		}
		// Si falla la autenticacion del usuario, hacemos un retardo
		// para reducir los ataques por fuerza bruta
		if (!($ced_v)) {
			sleep(5); //retardo de 5 segundos
		}			
        return array($ced_v, true, $vImage->checkCode() || isset($_REQUEST['conducta']));      
    }


    function imprime_primera_parte($dp) {
    
	global $archivoAyuda,$raizDelSitio, $tLapso, $tProceso, $vicerrectorado;
	global $botonDerecho, $nombreDependencia;
	global $_d, $elApellido;

	if (($_d['promedio'] == '') or ($_d['ind_cnu']== '') or ($_d['sit_e']== '')){
		$readonly = '';
	}else{
		$readonly = 'readonly';
	}

	$titulo = $tProceso ." " . $tLapso;
	//$instrucciones =$archivoAyuda.'?tp='.$dp[12];
	$instrucciones =$archivoAyuda.'?tp=1';
	
	//CONEXION A LA BD DONDE ESTAN LAS TABLAS DE PAISES, ESTADOS Y CIUDADES
	$conexP = new ODBC_Conn($dsnPregrado, $IdUsuario, $ClaveUsuario);
	$SQLpais = "SELECT codigo, pai_nombre from paises " ;
	$SQLpais.= "ORDER BY PAI_NOMBRE ASC";
	$conexP->ExecSQL($SQLpais);
	$filas1=$conexP->filas;
	$conexPais = $conexP->result;
	
	//select de los estados;
	$sql_estado = "SELECT CODIGO, EDO_NOMBRE ";
	$sql_estado.= "FROM ESTADOS ";
	$sql_estado.= "ORDER BY EDO_NOMBRE ASC";
	$conexP->ExecSQL($sql_estado) or die ("No se ha podido realizar la consulta");
	$filas2 = $conexP->filas;
	$conex_estado = $conexP->result;
	
	//select de los tipos de discapacidades
	$Cdatos_p   = new ODBC_Conn("NINGRESO","c","c");
	$sql_disca = "SELECT NUMERO, DESCRIPCION ";
	$sql_disca.= "FROM DISCAPACIDAD ";
	$sql_disca.= "ORDER BY DESCRIPCION ASC";
	$Cdatos_p->ExecSQL($sql_disca) or die ("No se ha podido realizar la consulta");
	$filas3 = $Cdatos_p->filas;
	$conex_disca = $Cdatos_p->result;
	//print_r($conex_disca);
	
	
	
	
	
    print <<<P001

<link href="inc/estilo.css" rel="stylesheet" type="text/css">
<script LANGUAGE="Javascript" SRC="{$raizDelSitio}/inscni.js">
</script>
</head>

<body $botonDerecho onload="reiniciarTodo(); self.focus(); document.datos_p.nac_eS.focus();">

<table border="0" width="750" id="table1" cellspacing="1" cellpadding="0" 
 style="border-collapse: collapse;border-color:white;">
    <tr><td>
		<table border="0" width="750">
		<tr>
		<td width="125">
		<p align="right" style="margin-top: 0; margin-bottom: 0">
		<img border="0" src="imagenes/unex15.gif" 
		     width="50" height="50"></p></td>
		<td width="500">
		<p class="titulo">
		Universidad Nacional Experimental Polit&eacute;cnica</p>
		<p class="titulo">
		Vicerrectorado $vicerrectorado</font></p>
		<p class="titulo">
		$nombreDependencia</font></td>
		<td width="125">&nbsp;</td>
		</tr><tr><td colspan="3" style="background-color:#99CCFF;">
		<font style="font-size:2px;"> &nbsp;</font></td></tr>
	    </table></td>
    </tr>
    <tr>
        <td width="750" class="tit14"> 
         $titulo </td>
    </tr>
	<tr>
		<td class="titulo" 
		    style="font-size: 11px; color:#FF0033; font-variant:small-caps; cursor:pointer;";
			OnMouseOver='this.style.backgroundColor="#99CCFF";this.style.color="#000000";'
			OnMouseOut='this.style.backgroundColor="#FFFFFF"; this.style.color="#FF0033";'
			OnClick='mostrar_ayuda("{$instrucciones}");'>
			Haz clic aqu&iacute; para leer las Instrucciones</td>
			<form name="datos_p" method="POST" action="preinscribir.php">
		</tr>
    <tr>
		<td width="850">
		<hr size="1">
        <div class="tit14" style="text-align:left;">Datos Personales:
			<span class="titulo" style="color:gray; font-variant:normal;">
			(Coloque sus datos completos, tal y como 
			aparecen en su C&eacute;dula de Identidad)</span>
		</div>
        <table id="datos_personales" align="center" border="0" cellpadding="0" cellspacing="1" 
		 width="840" style="border-collapse:collapse;border-color: black; border-style:solid; background:#D2DEF0;">
			
			<tr class="datosp">
				<td>&nbsp;</td>				
			</tr>

			<tr class="datosp">
				<td style="width: 150px;" >C&eacute;dula:<font style="color: blue;"> (Ej: V-12345678)</font></td>
				<td style="width: 150px; color:#D2DEF0;"><div id="tipoEtq">Tipo:</div></td>
				<td style="width: 150px; color:#D2DEF0;"><div id="docEtq">Documento:</div></td>
				<td style="width: 150px; color:#D2DEF0;"><div id="pasaporteEtq">N&uacute;mero:</div></td>
            </tr>           

			<tr>
				<td style="width: 150px;" >
					<input name="nac_e" type="hidden" value="{$_d['nac_e']}">
					<select name="nac_eS" id="nac_S_1" 
					 class="datospf" style="width: 40px;" onChange="with(document.datos_p){ if (this.value =='E')  {res_extrajS.style.display='block'; res_extrajS.focus(); document.getElementById('tipoEtq').style.color='#000000';} else {res_extrajS.style.display='none'; res_extraj.value =''; document.getElementById('tipoEtq').style.color='#D2DEF0';}} { if (this.value =='E') {doc_identS.style.display='block'; doc_identS.focus(); document.getElementById('docEtq').style.color='#000000';} else {doc_identS.style.display='none'; doc_ident.value =''; document.getElementById('docEtq').style.color='#D2DEF0';}}{ if (this.value =='V') {pasaporte_nro.style.display='none'; pasaporte_nro.value =''; document.getElementById('pasaporteEtq').style.color='#D2DEF0';}}validar(this);">
						<option value="">-s-</option>
						<option value="V">V</option>
						<option value="E">E</option>
					</select>&nbsp;-&nbsp;
					<input name="ci_e" type="hidden" value="{$_d['ci_e']}">
					<input name="ci_eS" maxlength="8" id="ci_N_7" 
					 class="datospf" style="width: 70px;" type="text" alt="Cedula" disabled="disabled"
					 value="{$_d['ci_e']}" onKeyUp="validarN(this);" onChange="validar(this);">
				</td>

				<td>
					<input name="res_extraj" type="hidden" value="{$_d['res_extraj']}">
					<select name="res_extrajS" id="resextraj_S_1" class="datospf" 
					 style="width: 100px; display: none;" onChange="validar(this);"> 
						<option value="">-SELECCIONE-</option>
						<option value="RESIDENTE">RESIDENTE</option>
						<option value="TRANSEUNTE">TRANSEUNTE</option>		
					</select>
				</td>

				<td style="width: 150px;" border="1;" >
					 <input name="doc_ident" type="hidden" value="{$_d['doc_ident']}">
					 <select name="doc_identS" id="docident_S_1" class="datospf" 
						  style="width: 100px; display:none;" onChange=" with(document.datos_p){ if (this.value =='PASAPORTE')  {pasaporte_nro.style.display='block'; pasaporte_nro.focus(); document.getElementById('pasaporteEtq').style.color='#000000';} else {pasaporte_nro.style.display='none'; pasaporte_nro.value =''; document.getElementById('pasaporteEtq').style.color='#D2DEF0';}} validar(this)">
							<option value="">-SELECCIONE-</option>
							<option value="CEDULA">CEDULA</option>
							<option value="PASAPORTE">PASAPORTE</option>
							
					</select>
				</td>

                <td style="width: 150px;" border="1;" >
					 
					<input name="pasaporte_nro" maxlength="10" id="pasaportenro_N_10" 
					 class="datospf" style="width: 70px; display:none;" type="text"
					 value="{$_d['pasaporte_nro']}" onKeyUp="validarN(this);" onChange="validar(this);">
				</td>
            </tr>

			<tr class="datosp">
				<td style="width: 200px;" >Primer Apellido</td>
                <td style="width: 200px;" >Segundo Apellido</td>
        		<td style="width: 200px;" >Primer Nombre</td>
                <td style="width: 200px;" >Segundo Nombre</td>
            </tr>
            <tr>
				<td style="width: 200px;" >
					<input name="apellidos" maxlength="25"  
					 class="datospf" style="width: 180px;" type="text" alt="Primer Apellido" 
					 value="{$_d['apellidos']}" id="ape1_L_1" onKeyUp="validarL(this);" onChange="validar(this);">
				</td>
				<td style="width: 200px;" >
					<input name="apellidos2" maxlength="25"  
					 class="datospf" style="width: 180px;" type="text" alt="Segundo Apellido" 
					 value="{$_d['apellidos2']}" id="ape2_L_0" onKeyUp="validarL(this);" onChange="validar(this);">
				</td>
                <td style="width: 200px;" >
					<input name="nombres" maxlength="25" alt="Primer Nombre" 
					 class="datospf" style="width: 180px;" type="text" 
					 value="{$_d['nombres']}" id="nom1_L_1" onKeyUp="validarL(this);" onChange="validar(this);">
				</td>

				<td style="width: 200px;" >
					<input name="nombres2" maxlength="25" alt="Segundo Nombre" 
					 class="datospf" style="width: 180px;" type="text" 
					 value="{$_d['nombres2']}" id="nom2_L_0" onKeyUp="validarL(this);" onChange="validar(this);">
					<input name="exp_e" maxlength="12" id="exp_e" 
					 class="datospf" style="width: 130px;" type="hidden" 
					 value="{$_d['exp_e']}">
				</td>
				<td style="width: 150px;" >
					<input name="exp_e" maxlength="12" id="exp_e" 
					 class="datospf" style="width: 130px;" type="hidden" 
					 value="{$_d['exp_e']}">
				</td>
                
            </tr>
                
                
            </tr>
		
			<tr class="datosp">
				<td style="width: 220px;" >Fecha de Nacimiento:</td>
                <td style="width: 220px;" >Pa&iacute;s de Nacimiento:</td>
                <td style="width: 150px;" >Lugar de Nacimiento:</td>
                <td style="width: 150px;" >Especialidad a Cursar:</td>
            </tr>
            <tr>
				<td class="datosp" style="width: 300px;" >
					<input type="hidden" name="f_nac_e" value="{$_d['f_nac_e']}"> 
					<select name="diaN" id="diaN_S_1" class="datospf"
					 onChange="if(validar(this)) calcularEdad();">
						<option >-s-</option>
						<option > 01</option>
						<option > 02</option>
						<option > 03</option>
						<option > 04</option>
						<option > 05</option>
						<option > 06</option>
						<option > 07</option>
						<option > 08</option>
						<option > 09</option>
						<option > 10</option>
						<option > 11</option>
						<option > 12</option>
						<option > 13</option>
						<option > 14</option>
						<option > 15</option>
						<option > 16</option>
						<option > 17</option>
						<option > 18</option>
						<option > 19</option>
						<option > 20</option>
						<option > 21</option>
						<option > 22</option>
						<option > 23</option>
						<option > 24</option>
						<option > 25</option>
						<option > 26</option>
						<option > 27</option>
						<option > 28</option>
						<option > 29</option>
						<option > 30</option>
						<option > 31</option>
					</select> de
					<select name="mesN" id="mesN_S_1" class="datospf" 
					 style="width:85px;" onChange="if (validar(this)) calcularEdad();">
						<option value="00" >seleccione</option>
						<option value="01" >ENERO</option>
						<option value="02" >FEBRERO</option>
						<option value="03" >MARZO</option>
						<option value="04" >ABRIL</option>
						<option value="05" >MAYO</option>
						<option value="06" >JUNIO</option>
						<option value="07" >JULIO</option>
						<option value="08" >AGOSTO</option>
						<option value="09" >SEPTIEMBRE</option>
						<option value="10" >OCTUBRE</option>
						<option value="11" >NOVIEMBRE</option>
						<option value="12" >DICIEMBRE</option>
					</select> de 19
					<input name="anioN" type="text" class="datospf" alt="A�o de Nacimiento"
						 id="anioN_N_2" value="" style="width: 15px;" 
						 maxlength="2" onKeyUp="validarN(this);"
						 onChange="if(validar(this)){if(verificarFecha(document.datos_p,true)) calcularEdad();}">
				</td>
                <td style="width: 150px;" >
					<input name="p_nac_e" maxlength="30" id="pnac_L_4" alt="Pais de Nacimiento"
						 class="datospf" style="width: 150px;" type="text" 
						 value="{$_d['p_nac_e']}" onKeyUp="validarL(this);" onChange="validar(this);">
				</td>
                <td style="width: 150px;" >
					<input name="l_nac_e" maxlength="30" id="lnac_L_3" alt="Lugar de Nacimiento"
						 class="datospf" style="width: 150px;" type="text" 
						 value="{$_d['l_nac_e']}" onKeyUp="validarL(this);" onChange="validar(this);">
				</td>
                <td style="width: 150px;" >
					<input name="c_uni_ca" type ="hidden" value="{$_d['c_uni_ca']}" >
					<input name="carrera" type ="hidden" value="{$_d['carrera']}" >
					<input name="c_uni_caS" maxlength="25" id="c_uni_ca" 
						 class="datospf" style="width: 130px;" type="text" disabled="disabled" 
						 value="{$_d['carrera']}" >
					<input type="hidden" name="conducta" value="{$_d['conducta']}" >

				</td>
			</tr>
            <tr class="datosp">
				<td style="width: 220px;" >Edad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Estado Civil:</td>
				<td style="width: 220px;" >Sexo:</td>
                <td style="width: 220px;" >Correo Electr&oacute;nico Principal:</td>
				<td style="width: 220px;" >Correo Electr&oacute;nico Secundario:</td>
                <td style="width: 150px;" >&nbsp;</td>
            </tr>
            <tr>
				<td class="datosp" style="width: 220px;" >
					<input name="edad" type="text" class="datospf" disabled="disabled"; 
						 id="edad" value="" style="width: 20px; font-weight:bold;" maxlength="2">
						 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input name="edo_c_e" type="hidden" value="{$_d['edo_c_e']}">
					<select name="edo_c_eS" id="ecivil_S_1" class="datospf" 
						  style="width: 100px;" onChange="validar(this);">
							<option value="">-SELECCIONE-</option>							
							<option value="SOLTERO">Soltero</option>							
							<option value="CASADO">Casado</option>							
							<option value="CONCUBINO">Concubino</option>						
							<option value="VIUDO">Viudo</option>
							<option value="DIVORCIADO">Divorciado</option>
					</select>
					
				</td>
				
				<td>
					<input name="sexo" type="hidden" value="{$_d['sexo']}">
						<select name="sexoS" id="sexo_S_1" class="datospf" 
						  style="width: 100px;" onChange="validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="FEMENINO">FEMENINO</option>
							<option value="MASCULINO">MASCULINO</option>
						</select>
				</td>
			
				<td style="width: 150px;" >
					<input name="correo1" maxlength="40" id="correo1" alt="Correo Electronico Primario" class="datospf" style="width: 200px;" type="text" value="{$_d['correo1']}">
				</td>
				<td style="width: 150px;" >
					<input name="correo2" maxlength="40" id="correo2" alt="Correo Electronico Secundario" class="datospf" style="width: 200px;" type="text" value="{$_d['correo2']}">
				</td>
				
			</tr>

			
			
			<tr class="datosp">
				<td>&nbsp;</td>				
			</tr>

		</table>
	</td></tr>
	<tr>
	<td width="750">
		<br>
        <div class="tit14" style="text-align:left;">Direcci&oacute;n Permanente
			<span class="titulo" style="color:gray; font-variant:normal;">
			</span>
			</div>
        <table id="dir_1" align="center" border="0" cellpadding="1" cellspacing="2" 
		 width="840" style="border-collapse:collapse;border-color:black; border-style:solid; background:#D2DEF0;">
            <tbody>
                <tr class="datosp">
                    <td colspan="2" style="width: 400px;" >
                        Avenida/Calle:</td>
                    <td style="width: 200px;" >
                        Barrio/Urbanizaci&oacute;n</td>
					<td style="width: 200px;" >
                        Manzana/Edificio</td>
                    <td style="width: 140px;" >
                        Casa/Apto Nro:</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 300px;" >
						<input name="avenida" maxlength="30" id="avCalle_A_1" alt="Avenida/Calle" 
						 class="datospf" style="width: 350px;" type="text" 
						 value="{$_d['avenida']}" onKeyUp="validarA(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 200px;" >
						<input name="urbanizacion" maxlength="30" id="barrio_A_1" alt="Barrio/Urbanizacion" 
						 class="datospf" style="width: 180px;" type="text" 
						 value="{$_d['urbanizacion']}" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
					<td style="width: 200px;" >
						<input name="manzana" maxlength="30" id="manzana_A_1" alt="Manzana/Edificio" 
						 class="datospf" style="width: 120px;" type="text" 
						 value="{$_d['manzana']}" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
                    <td style="width: 140px;" >
						<input name="nrocasa" maxlength="30" id="casa_A_1" alt="Casa/Apto Nro" 
						 class="datospf" style="width: 80px;" type="text" 
						 value="{$_d['nrocasa']}" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
				</tr>
                <tr class="datosp">
                    <td style="width: 200px;" >
                        Ciudad:</td>
                    <td style="width: 200px;" >
                        Estado:</td>
                    <td style="width: 200px;" >
                        Tlf Hab:
						<font style="color:blue;">(Ej: 0286-1234567)</font></td>
					<td style="width: 200px;" >
                        Tlf Celular:
						<font style="color:blue;"></font></td>
					<td style="width: 200px;" >
                        FAX:
						<font style="color:blue;"></font></td>
                   
                </tr>
                <tr>
                    <td style="width: 200px;" >
					<input name="telefono1" type="hidden" value = "{$_d['telefono1']}">
					<input name="telefono2" type="hidden" value = "{$_d['telefono2']}">
					<input name="telefono3" type="hidden" value = "{$_d['telefono3']}">
					
						<input name="ciudad" maxlength="30" id="ciudad_L_3" alt="Ciudad" 
						 class="datospf" style="width: 180px;" type="text" 
						 value="{$_d['ciudad']}" onKeyUp="validarL(this);">
				    </td>
                    <td style="width: 200px;" >
						<input name="estado" maxlength="30" id="estado_L_4" alt="Estado" 
						 class="datospf" style="width: 180px;" type="text" 
						 value="{$_d['estado']}" onKeyUp="validarL(this);">
				    </td>
                    <td style="width: 200px;" >
						<input name="codT" maxlength="4" id="codT_N_4" alt="Telefono Residencial(codigo de area)" class="datospf" style="width: 30px;" type="text" 
						 value="" onKeyUp="validarN(this);" onChange="validar(this);">&nbsp;-&nbsp;
						
						<input name="telefono" maxlength="7" id="telefono_N_7"alt="Telefono Residencial (numero)" 
						 class="datospf" style="width: 60px;" type="text" 
						 value="" onKeyUp="validarN(this);" onChange="validar(this);">
					</td>                    
					<td style="width: 200px;">
						<select name="celcod" id="codc_S_1" alt="Telefono Celular (Codigo)" class="datospf" style="width: 50px;" onChange="validar(this)">
							<option value="">-SEL-</option>
							<option value="0416">0416</option>
							<option value="0426">0426</option>
							<option value="0414">0414</option>
							<option value="0424">0424</option>
							<option value="0412">0412</option>
					</select>&nbsp;-&nbsp;
						<input name="celnro" maxlength="7" id="telefono_N_7" alt="Telefono Celular (numero)" class="datospf" style="width: 60px;" type="text" 
						 value="" onKeyUp="validarN(this);" onChange="validar(this);">
					</td>
					<td style="width: 200px;" >
						<input name="codfax" maxlength="4" alt="FAX (codigo de area)" 
						 class="datospf" style="width: 30px;" type="text" 
						 value="" onKeyUp="validarN(this);">&nbsp;-&nbsp;
						<input name="nrofax" maxlength="7" alt="FAX (numero)"  
						 class="datospf" style="width: 60px;" type="text" 
						 value="" onKeyUp="validarN(this);">
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
    </td>
    </tr>
	<tr>
    <td width="850">
		<br>
        <div class="tit14" style="text-align:left;">Direcci&oacute;n de Residencia:
			<span class="titulo" style="color:gray; font-variant:normal;">
			(completar s&oacute;lo si es diferente a la 
			 Direcci&oacute;n Permanente)</span>
		</div>
        <table id="dir_2" align="center" border="0" cellpadding="1" cellspacing="2" 
		 width="840" style="border-collapse:collapse;border-color:white; border-style:solid; background:#D2DEF0;">
            <tbody>
                <tr class="datosp">
                    <td colspan="2" style="width: 400px;" >
                        Avenida/Calle:</td>
                    <td style="width: 200px;" >
                        Barrio/Urbanizaci&oacute;n/Edificio:</td>
                    <td style="width: 140px;" >
                        Casa/Apto Nro:</td>
                </tr>
                <tr>
                    <td colspan="2" style="width: 400px;" >
						<input name="dirr_e" type="hidden" value = "{$_d['dirr_e']}">
						<input name="telfr_e" type="hidden" value = "{$_d['telfr_e']}">
						<input name="avCalleR" maxlength="100" id="avCalleR_A_0" alt="Avenida/Calle" 
						 class="datospf" style="width: 380px;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 200px;" >
						<input name="barrioR" maxlength="60" id="barrioR_A_0" alt="Barrio/Urbanizacion/Edificio" 
						 class="datospf" style="width: 180px;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
                    <td style="width: 140px;" >
						<input name="casaR" maxlength="25" id="casaR_A_0" alt="Casa/Apto Nro" 
						 class="datospf" style="width: 120px;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
				</tr>
                <tr class="datosp">
                    <td style="width: 200px;" >
                        Ciudad:</td>
                    <td style="width: 200px;" >
                        Estado:</td>
                    <td style="width: 200px;" >
                        Tel&eacute;fono:
						<font style="color:blue;">(Ej: 0286-1234567)</font></td>
                    <td style="width: 140px;" >&nbsp;
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;" >
						<input name="ciudadR" maxlength="30" id="ciudadR_L_0" alt="Ciudad" 
						 class="datospf" style="width: 180px;" type="text" 
						 value="" onKeyUp="validarL(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 200px;" >
						<input name="estadoR" maxlength="30" id="estadoR_L_0" alt="Estado" 
						 class="datospf" style="width: 180px;" type="text" 
						 value="" onKeyUp="validarL(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 200px;" >
						<input name="codTR" maxlength="4" id="codTR_N_0" alt="Telefono (codigo de area)" 
						 class="datospf" style="width: 30px;" type="text" 
						 value="" onKeyUp="validarN(this);" onChange="validar(this);">&nbsp;-&nbsp;
						<input name="telefonoR" maxlength="7" id="telefonoR_N_0" alt="Telefono (numero)" 
						 class="datospf" style="width: 60px;" type="text" 
						 value="" onKeyUp="validarN(this);" onChange="validar(this);">
                    <td style="width: 140px;" >&nbsp;
					</td>
				</tr>
			</tbody>
		</table>
    </td>
    </tr>
	<tr>
    <td width="850">
		<br>
        <div class="tit14" style="text-align:left;">
		Datos Acad&eacute;micos:
		</div>
        <table id="dAcad" align="center" border="0" cellpadding="1" cellspacing="2" 
		 width="840" style="border-collapse:collapse;border-color:white; border-style:solid; background:#D2DEF0;">
            <tbody>
                <tr class="datosp">
                    <td colspan="6" style="width: 450px;" >
                        Nombre del Plantel de Procedencia:</td>
                    <td style="width: 145px;" >
                        Tipo de Plantel:</td>
                    <td id="montoEtq" style="width: 145px; color:#D2DEF0;" >
                        Mensualidad:</td>
                </tr>
                <tr>
                    <td colspan="6" style="width: 450px;" >
						<input name="plantel" maxlength="100" id="plantel_A_10" alt="Nombre del Plantel" 
						 class="datospf" style="width: 430px;" type="text" 
						 value="{$_d['plantel']}" onKeyUp="validarA(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 165px;" >
						<input name="tipo_plantel" type="hidden" value = "{$_d['tipo_plantel']}">
						<select name="tipo_plantelS" id="tipoPlantel_S_1" class="datospf" 
						  style="width: 100px;"
						  onChange="with(document){ if (this.value =='PRIVADO'){datos_p.costo_mensual.style.display='block'; getElementById('montoEtq').style.color='#000000'; datos_p.costo_mensual.focus();} else {datos_p.costo_mensual.style.display='none'; datos_p.costo_mensual.value = ''; getElementById('montoEtq').style.color='#D2DEF0';}} validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="PUBLICO">P&Uacute;BLICO</option>
							<option value="PRIVADO">PRIVADO</option>
					</select>
                    <td style="width: 125px;" >
						<input name="costo_mensual" maxlength="20" id="monto_N_3" alt="Mensualidad" 
						 class="datospf" style="width: 100px; display:none;" type="text" 
						 value="{$_d['costo_mensual']}" onKeyUp="validarN(this);" onChange="validar(this);">
					</td>
				</tr>
                <tr class="datosp">
                    <td colspan="2" style="width: 150px;" >
                        Sistema de Estudio:</td>
                    <td colspan="2" style="width: 150px;" >
                        Turno:</td>
                    <td colspan="2" style="width: 150px;" >
                        T&iacute;tulo Obtenido:
                    <td style="width: 165px;" >
                        Promedio de Bachillerato:</td>
                    <td style="width: 125px;" >
                        Asignado por:</td>
                </tr>
                <tr class="datosp">
                    <td style="width: 140px; vertical-align:top;" >
						<input name="sistema_estudio" type="hidden" value = "{$_d['sistema_estudio']}">
						<select name="sistema_estudioS" id="sistemaE_S_1" class="datospf" 
						 onChange="with(document) {if(this.value=='OTRO') { datos_p.otroSistemaE.style.display ='block'; datos_p.otroSistemaE.focus(); } else { datos_p.otroSistemaE.style.display ='none';}} validar(this);">
							<option value=""> -SELECCIONE-</option>
							<option value="REGULAR">REGULAR</option>
							<option value="PARASISTEMA">PARASISTEMA </option>
							<option value="OTRO">OTRO (indique abajo):</option>
						</select>
						<input name="otroSistemaE" maxlength="15" id="otroSistemaE_A_4" alt="Otro Sistema de Estudio" 
						 class="datospf" style="width: 130px; display:none;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 10px;" >&nbsp;</td>
                    <td style="width: 140px; vertical-align:top;" >
						<input name="turno_estudio" type="hidden" value = "{$_d['turno_estudio']}">
						<select name="turno_estudioS" id="turnoE_S_1" class="datospf" 
						 onChange="with (document){ if(this.value=='OTRO') {datos_p.otroTurnoE.style.display ='block'; datos_p.otroTurnoE.focus();} else {datos_p.otroTurnoE.style.display ='none';}} validar(this);">
							<option value=""> -SELECCIONE-</option>
							<option value="DIURNO">DIURNO</option> 
							<option value="NOCTURNO">NOCTURNO</option> 
							<option value="ESTUDIOS LIBRES">ESTUDIOS LIBRES</option>
							<option value="OTRO">OTRO (indique abajo):</option>
						</select>
						<input name="otroTurnoE" maxlength="20" id="otroTurnoE_A_4" alt="Otro Turno de Estudio" 
						 class="datospf" style="width: 130px; display:none;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
                    <td style="width: 10px;" >&nbsp;</td>
                    <td style="width: 140px; vertical-align:top;" >
						<input name="titulo_b" type="hidden" value = "{$_d['titulo_b']}">
						<select name="titulo_bS" id="titulo_S_1" class="datospf" style="text-transform: none;"
						 onChange="with (document) { if (this.value=='OTRO') { datos_p.otroTitulo.style.display ='block'; datos_p.otroTitulo.focus();}  else { datos_p.otroTitulo.style.display ='none'; }}; validar(this);">
							<option value=""> -SELECCIONE-</option>
							<option value="CIENCIAS">CIENCIAS BASICAS Y TECNOLOGICAS</option>
							<option value="INDUSTRIAL">INDUSTRIAL MENCI&Oacute;N(T&Eacute;CNICO MEDIO)</option>
							<option value="CONSTRUCCION CIVIL">CONSTRUCCI&Oacute;N CIVIL</option>
							<option value="CONSTRUCCION NAVAL">CONTRUCCI&Oacute;N NAVAL</option>
							<option value="ELECTRICIDAD">ELECTRICIDAD</option>
							<option value="INSTRUMENTACION">INSTRUMENTACI&Oacute;N</option>
							<option value="MECANICA-MANTENIMIENTO">M&Eacute;CANICA DE MANTENIMIENTO</option>
							<option value="MAQUINAS Y HERRAMIENTAS">M&Aacute;QUINAS Y HERRAMIENTAS</option>
							<option value="REFRIG Y AIRE ACONDIC.">REFRIGERACION Y AIRE ACONDICIONADO</option>
							<option value="QUIMICA INDUTRIAL">QU&Iacute;MICA INDUSTRIAL</option>
							<option value="ELECTROMECANICO">ELECTROMEC&Aacute;NICO</option>
							
						</select>
						<input name="otroTitulo" maxlength="20" id="otroTitulo_A_4" alt="Otro Titulo de Bachiller" 
						 class="datospf" style="width: 130px; display: none;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
				    </td>
                    <td style="width: 10px;" >&nbsp;</td>
                    <td style="width: 165px;vertical-align:top;" >
						<input type="text" name="promedio" value="{$_d['promedio']}" id="promedio_A_2" style="width: 50px;" maxlength="5" class="datospf" onChange"validarN(this);" $readonly>&nbsp;
                    <td style="width: 125px;vertical-align:top;" >
					<input name="c_ingreso" type ="hidden" value="{$_d['c_ingreso']}" >
					<input name="ingreso" type ="hidden" value="{$_d['ingreso']}" >
						<input name="tipoIngreso" maxlength="20" id="tipoIngreso" 
						 class="datospf" style="width: 150px;" type="text" disabled="disabled" 
						 value="{$_d['ingreso']}">
				</tr>
				<tr>
					<td class="datosp">Opci&oacute;n CNU para UNEXPO
						<input name="opcion_cnu" type="hidden" value = "{$_d['opcion_cnu']}">
						<select name="opcion_cnuS" id="opcionCNU_S_1" class="datospf" 
						  style="width: 150px;"
						  onChange="validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="PRIMERA">PRIMERA OPCI&Oacute;N</option>
							<option value="SEGUNDA">SEGUNDA OPCI&Oacute;N</option>
							<option value="TERCERA">TERCERA OPCI&Oacute;N</option>
		                    <option value="CUARTA">CUARTA OPCI&Oacute;N</option>
							<option value="QUINTA">QUINTA OPCI&Oacute;N</option>
							<option value="SEXTA">SEXTA OPCI&Oacute;N</option>
							<option value="NINGUNA">NINGUNA OPCI&Oacute;N</option>
						</select><td/>
					<td class="datosp">Nro Rusnies:<br>
						<input type="text" name="sit_e" value="{$_d['sit_e']}" id="site_N_10" style="width: 150px;" maxlength="13" class="datospf" onKeyUp="validarN(this);" onChange="validar(this);" $readonly>
					</td>
						
					<td class="datosp" colspan="6"><br>Indice CNU:<br>
						<input type="text" name="ind_cnu" value="{$_d['ind_cnu']}" id="indCNU_A_2" style="width: 50px;" maxlength="5" class="datospf" onChange"validarN(this);" $readonly><span class="titulo" style="color:red; font-variant:normal;">
						(Rellenar tal y como muestra el ejemplo, separar los decimales con punto, si no posees coloca cero ejemplo: 00.00 )</span></font><td/>
				</tr>
				<tr>
						<td>&nbsp;</td>										
				</tr>

			</tbody>
		</table>
    </td>
    </tr>	
	<tr>
    <td width="850"><br>
        <div class="tit14" style="text-align:left;">
		Datos Socioecon&oacute;micos:
		</div>
        <table id="dSocioE" align="center" border="0" cellpadding="1" cellspacing="2" 
		 width="840" style="border-collapse:collapse;border-color:white; border-style:solid; background:#D2DEF0;">
            <tbody>
                <tr class="datosp">
                    <td style="width: 185px;" >
                        Instrucci&oacute;n del Padre:</td>
                    <td style="width: 185px;" >
                        Ocupaci&oacute;n del Padre:</td>
                    <td style="width: 185px;" >
                        Instrucci&oacute;n de la Madre:</td>
                    <td style="width: 185px;" >
                        Ocupaci&oacute;n de la Madre:</td>
                </tr>
                <tr class="datosp">
                    <td style="width: 185px; vertical-align:top;" >
						<input name="instr_padre" type="hidden" value = "{$_d['instr_padre']}">
						<select name="instr_padreS" id="instruccionPadre_S_1" 
						 class="datospf" style="width:175px;" onChange="validar(this)">
						 <option value=""> -SELECCIONE-</option>
							<option value="PRIMARIA INCOMPLETA">Primaria Incompleta</option>
							<option value="PRIMARIA COMPLETA">Primaria Completa</option>
							<option value="SECUNDARIA INCOMPLETA">Secundaria Incompleta</option>
							<option value="SECUNDARIA COMPLETA">Secundaria Completa</option>
							<option value="TECNICO SUP. UNIVERSITARIO">T&eacute;cnico Sup. Universitario</option>
							<option value="UNIVERSITARIO">Universitaria</option>
						</select><br>&nbsp;
				    </td>
                    <td style="width: 185px; vertical-align:top;" >
						<input name="ocup_padre" type="hidden" value = "{$_d['ocup_padre']}">
						<select name="ocup_padreS" id="ocupacionPadre_S_1" 
						 class="datospf" style="width:175px;"
						 onChange="with (document) { if(this.value=='OTRO') { datos_p.otroOcupPadre.style.display ='block'; datos_p.otroOcupPadre.focus();} else { document.datos_p.otroOcupPadre.style.display ='none';}} validar(this);">
							<option value=""> -SELECCIONE-</option>
							<option value="HOGAR">Hogar</option> 
							<option value="OBRERO">Obrero</option> 
							<option value="COMERCIANTE INFORMAL">Comerciante Informal</option> 
							<option value="COMERCIANTE FORMAL">Comerciante Formal</option> 
							<option value="EMPLEADO">Empleado</option> 
							<option value="TECNICO">T&eacute;cnico</option> 
							<option value="PROFESIONAL UNIVERSITARIO">Profesional Universitario</option>
							<option value="OTRO">OTRO (indique abajo):</option>
						</select>
						<input name="otroOcupPadre" maxlength="15" id="otroOcupacionP_A_4" alt="Otro Ocupacion del Padre" 
						 class="datospf" style="width: 175px; display:none;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
                    <td style="width: 185px; vertical-align:top;" >
						<input name="instr_madre" type="hidden" value = "{$_d['instr_madre']}">
						<select name="instr_madreS" id="instruccionMadre_S_1" 
						 class="datospf" style="width:175px;" onChange="validar(this)">
						 <option value=""> -SELECCIONE-</option>
							<option value="PRIMARIA INCOMPLETA">Primaria Incompleta</option>
							<option value="PRIMARIA COMPLETA">Primaria Completa</option>
							<option value="SECUNDARIA INCOMPLETA">Secundaria Incompleta</option>
							<option value="SECUNDARIA COMPLETA">Secundaria Completa</option>
							<option value="TECNICO SUP. UNIVERSITARIO">T&eacute;cnico Sup. Universitario</option>
							<option value="UNIVERSITARIO">Universitaria</option>
						</select>
				    </td>
                    <td style="width: 185px; vertical-align:top;" >
						<input name="ocup_madre" type="hidden" value = "{$_d['ocup_madre']}">
						<select name="ocup_madreS" id="ocupacionMadre_S_1" 
						 class="datospf" style="width:175px;"
						 onChange="with (document) { if(this.value=='OTRO') { datos_p.otroOcupMadre.style.display ='block'; datos_p.otroOcupMadre.focus();} else { document.datos_p.otroOcupMadre.style.display ='none';}} validar(this);">
							<option value=""> -SELECCIONE-</option>
							<option value="HOGAR">Hogar</option> 
							<option value="OBRERA">Obrera</option> 
							<option value="COMERCIANTE INFORMAL">Comerciante Informal</option> 
							<option value="COMERCIANTE FORMAL">Comerciante Formal</option> 
							<option value="EMPLEADA">Empleada</option> 
							<option value="TECNICO">T&eacute;cnico</option> 
							<option value="PROFESIONAL UNIVERSITARIO">Profesional Universitario</option>
							<option value="OTRO">OTRO (indique abajo):</option>
						</select>
						<input name="otroOcupMadre" maxlength="15" id="otroOcupacionM_A_4" alt="Otro Ocupacion de la Madre" 
						 class="datospf" style="width: 175px; display:none;" type="text" 
						 value="" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>
				</tr>
				<tr class="datosp">
                    <td colspan="2" style="width: 370px;" >Tipo de Vivienda que Habita:</td>
                    <td colspan="2" style="width: 370px;" >Ingreso Familiar Mensual:</td>
				</tr>
				<tr>
                    <td colspan="2" style="width: 370px; vertical-align:top;" >
						<input name="tipo_vivienda" type="hidden" value = "{$_d['tipo_vivienda']}">
						<select name="tipo_viviendaS" id="tipoVivienda_S_1" 
						 class="datospf" style="width:175px;"
						 onChange="if(this.value=='ALQUILADA') { document.datos_p.monto_alq.style.display ='block'; document.datos_p.monto_alq.focus();} else document.datos_p.monto_alq.style.display ='none'; if (this.value != 'ALQUILADA') { document.datos_p.monto_alq.value ='';} validar(this);">
							<option value=""> -SELECCIONE-</option>
							<option value="PROPIA">Propia</option> 
							<option value="HIPOTECADA">Hipotecada</option> 
							<option value="ALQUILADA">Alquilada (monto mensual):</option> 
						</select>
						<input name="monto_alq" maxlength="30" id="montoAlq_N_4" alt="Monto Alquiler" 
						 class="datospf" style="width: 175px; display:none;" type="text" 
						 value="{$_d['monto_alq']}" onKeyUp="validarN(this);" onChange="validar(this);">
					</td>
                    <td colspan="2" style="width: 370px; vertical-align:top;" >
						<input name="ingreso_f" type="hidden" value = "{$_d['ingreso_f']}">
						<input name="ingreso_fBs" type="hidden" value = "">
						<select name="ingreso_fS" id="ingresoF_S_1" 
						 class="datospf" style="width:175px;" onChange="validar(this)">
						 <option value=""> -SELECCIONE-</option>
P001;
	global $unidadTributaria, $rangosIngresoFamiliar;
	$vUT = $unidadTributaria;
	$rango = $rangosIngresoFamiliar;
	$unaOpcion  = '<option value="1:MENOS DE '. $rango[0].' UT">';
	$unaOpcion .= 'MENOS DE '. $vUT*$rango[0] .' Bs.F</option>';
//	muestrame($rango);
	
	print $unaOpcion;
	$ik = 1;
	for($k=0; $k< count($rango) - 1;$k++) {
		$ik++;
		$unaOpcion  = '<option value="'.$ik.':DE '. $rango[$k].' A '. $rango[$k+1].' UT">';
		$unaOpcion .= 'DE '. ($rango[$k]*$vUT+1).' A '. $rango[$k+1]*$vUT.' Bs.F</option>';
		print $unaOpcion;
	}
	$unaOpcion  = '<option value="'.++$ik.':MAS DE '. $rango[$k].' UT">';
	$unaOpcion .= 'MAS DE '. $vUT*$rango[$k] .' Bs.F</option>';
	print $unaOpcion;
	
	
	print <<<P002
						</select><br>&nbsp;
				    </td>
				</tr>
				
				<tr>
					<td class="datosp" style="width: 185px;">
						Posee Beca:&nbsp;&nbsp;
						<input name="becario" type="hidden" value="{$_d['becario']}">
						<select name="becarioS" id="becario_S_1" class="datospf" style="width:100px;" onChange="with(document.datos_p){ if (this.value =='SI')  {organismo.style.display='block'; organismo.focus(); document.getElementById('orgEtq').style.color='#000000';} else {organismo.style.display='none'; organismo.value =''; document.getElementById('orgEtq').style.color='#D2DEF0';}} validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="SI">SI</option> 
							<option value="NO">NO</option> 
						</select>
					</td>
					
					<td class="datosp" style="width: 185px;">
						Etnia Indigena:&nbsp;
						<select name="etnia_indigenaS" id="etniaindigena_S_1" class="datospf" style="width:100px;" onChange="with(document.datos_p){ if (this.value =='SI')  {etnia_indigena.style.display='block'; etnia_indigena.focus(); document.getElementById('etniaEtq').style.color='#000000';} else {etnia_indigena.style.display='none'; etnia_indigena.value =''; document.getElementById('etniaEtq').style.color='#D2DEF0';}} validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="SI">SI</option> 
							<option value="NO">NO</option> 
						</select>
					</td>

					<td style="width: 185px;" class="datosp">
						Trabaja:&nbsp;
						<input name="trabaja" type="hidden" value="{$_d['trabaja']}">
						<input name="turno_trabajo" type="hidden" value="{$_d['turno_trabajo']}">
						<select name="trabajaS" id="trabaja_S_1" class="datospf" 
						style="width: 100px;" onChange="with(document.datos_p){ if (this.value =='SI')  {turnoTrabaja.style.display='block'; turnoTrabaja.focus(); document.getElementById('turnoTrabajaEtq').style.color='#000000';} else {turnoTrabaja.style.display='none'; turnoTrabaja.value =''; document.getElementById('turnoTrabajaEtq').style.color='#D2DEF0';}} validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="SI">SI</option>
							<option value="NO">NO</option>
						</select>
					</td>
					<td style="width: 185px;" class="datosp">
						Estrato Social:&nbsp;
						<input name="estrato_social" type="hidden" value="{$_d['estrato_social']}">
						<select name="estratoS" id="estrato_S_1" class="datospf" 
						style="width: 100px;" onChange="validar(this);">
							<option value="">-SELECCIONE-</option>
							<option value="BAJO">BAJO</option>
							<option value="MEDIO">MEDIO</option>
							<option value="ALTO">ALTO</option>
						</select>
					</td>
				</tr>

				<tr>
					<td style="width: 185px; color:#D2DEF0;" class="datosp">
					<div id="orgEtq">Organismo Becario:</div>
					<input name="organismo" maxlength="30" 
					 class="datospf" style="width: 170px; display:none;" type="text"
					 value="{$_d['organismo']}" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>

					<td style="width: 185px; color:#D2DEF0;" class="datosp">
					<div id="etniaEtq">Nombre de la Etnia:</div>
					<input name="etnia_indigena" maxlength="30" type="text"
					class="datospf" style="width: 170px; display:none;" 
					 value="{$_d['etnia_indigena']}" onKeyUp="validarA(this);" onChange="validar(this);">
					</td>

					<td style="width: 185px; color:#D2DEF0;" class="datosp">
					<div id="turnoTrabajaEtq">
					Turno de Trabajo:
					<select name="turnoTrabaja" id="turnoTrabaja_S_1" class="datospf" 
						  style="width: 150px; display:none;" onChange="validar(this)">
							<option value="">-SELECCIONE-</option>
							<option value="DIURNO">DIURNO</option>
							<option value="NOCTURNO">NOCTURNO</option>
							<option value="MIXTO">MIXTO</option>
					</select>
					</div></td>
				
				</tr>
				<tr><td>&nbsp;</td></tr>
			</tbody>
		</table>
	</td></tr>
	<tr  class="datosp" style="background-color:white;">
		<td width="740">&nbsp;
			<hr size="1" width="740">
        <div class="tit14" id="msgError" style="text-align:left;display:none; background-color:#ffff99;">
		Verifique: Existen errores en los campos marcados en amarillo</div></td>
	</tr>
	<tr class="datosp" style="background-color:white;">
		<td>        
		<table id="tBoton" align="center" border="0" cellpadding="1" cellspacing="2"
		 width="740" style="border-collapse:collapse;border-color:white; border-style:solid; background:white;">
			<tr><td style="width: 200px">
				<input type="hidden" name="contra" value="$elApellido">
				<input class="boton" type="reset" value="Borrar Formulario"
					onclick="with (document) {datos_p.turnoTrabaja.style.display='none'; getElementById('turnoTrabajaEtq').style.color='#D2DEF0'; datos_p.costo_mensual.style.display='none'; getElementById('montoEtq').style.color='#D2DEF0'; datos_p.otroSistemaE.style.display ='none'; datos_p.otroTurnoE.style.display ='none'; datos_p.otroTitulo.style.display ='none'; datos_p.otroOcupPadre.style.display ='none'; datos_p.otroOcupMadre.style.display ='none'; datos_p.monto_alq.style.display ='none';} reiniciarTodo(false);"></td>
				<td style="width: 200px">
				<input class="boton" type="button" value="Procesar" id="Procesar" 
					onclick="this.style.display='none'; validarF(document.datos_p);">
				</td>
				<td>
				<input class="boton" type="button" value="Salir" id="Salir" 
					onclick="window.close();">
				</td>
			</tr>
		</table></td>
	</tr>
	</form>
	</table>
P002
; 
    }

    function imprime_ultima_parte($dp) {
    
	print <<<U001
</body>
</html>
U001
;
    }
    
    function volver_a_indice($vacio,$fueraDeRango, $habilitado=true){
	
    //regresa a la pagina principal:
	global $raizDelSitio, $cedYclave;
    if ($vacio) {
?>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <META HTTP-EQUIV="Refresh" 
            CONTENT="0;URL=<?php echo $raizDelSitio; ?>">
        </head>
        <body>
        </body>
        </html>
<?php
    }
    else {
?>          <script languaje="Javascript">
            <!--
            function entrar_error() {
<?php
        if ($fueraDeRango) {
			if($habilitado){
?>             
		mensaje = "Lo siento, no puedes inscribirte en este horario.\n";
        mensaje = mensaje + "Por favor, espera tu turno.";
<?php
			}
			else {
?>
	    mensaje = 'Lo siento, no esta habilitado el sistema.';
<?php
			}
		}
        else {
			if(!$cedYclave[0]){
?>
        mensaje = "La cedula no esta registrada o es incorrecta.\n";
		mensaje = mensaje + "Por favor verifica tus datos en la lista\n";
		mensaje = mensaje + "debes escribir tus datos TAL Y COMO APARECEN EN LA LISTA.";
<?php
			}	
			else if (!$cedYclave[1]) {
?>
        mensaje = "Clave incorrecta. Por favor intente de nuevo";
<?php
			}
			else if (!$cedYclave[2]) {
?>
        mensaje = "Codigo de seguridad incorrecto. Por favor intente de nuevo";
<?php
			}
		}
?>
                alert(mensaje);
                window.close();
                return true; 
        }//fin funcion

            //-->
            </script>
        </head>
        <body onload ="return entrar_error();" >

        </body>
<?php 
	global $noCacheFin;
	print $noCacheFin; 
	
?>
</html>
<?php
    }
}    


    // Programa principal
    //leer las variables enviadas
    if(isset($_REQUEST['cedula']) && isset($_REQUEST['contra'])) {
        $cedula=$_REQUEST['cedula'];
        $contra=$_REQUEST['contra'];
        // limpiemos la cedula y coloquemos los ceros faltantes
        $cedula = ltrim(preg_replace("/[^0-9]/","",$cedula),'0');
		if ($sedeActiva == 'POZ') { 
			// En BQTO a las cedulas menores de 10 millones, 
			// se le agrega un cero adelante.
			$cedula = substr("00000000".$cedula, -8);
		}
        $fvacio = false; 
        $contra = strtoupper(quitar_blancos ($contra));
        if (strpos($contra, " ") === false)
			$elApellido = $contra;
        else
			$elApellido = substr($contra, 0, strpos($contra, " "));

		

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<?php
print $noCache; 
print $noJavaScript; 

?>
<title><?php echo $tProceso.' '. $lapso; ?></title>
<?
        $cedYclave = cedula_valida($cedula,$elApellido);
		if(!$fvacio && $cedYclave[0] && $cedYclave[1] && $cedYclave[2]) {
            // Revisamos si es su turno de inscripcion:
			if(true) {
				if ($inscHabilitada) {
					imprime_primera_parte($datos_p);
					imprime_ultima_parte($datos_p);
					//echo $_d['exp_e'];
				}
				else volver_a_indice(false,true,false);//inscripciones no habilitadas
            }
            else volver_a_indice(false,true); //alumno fuera de rango
        }
        else volver_a_indice(false,false); //cedula o clave incorrecta
    }
    else volver_a_indice(true,false); //formulario vacio
?>
</html>