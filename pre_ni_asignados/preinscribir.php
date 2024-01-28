<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php
include_once('inc/odbcss_c.php');
include_once ('inc/config.php');
//include_once ('inc/activaerror.php');

$_d = $_REQUEST;

//foreach($_POST as $nombre_campo => $valor){
//	echo $nombre_campo ."==>". $valor;
//	echo "<br>";
//}

$conex = new ODBC_Conn($dsnPregrado,$IdUsuario,$ClaveUsuario,true,$laBitacora);
//$conex = new ODBC_Conn("NINGRESO","usuario2","usuario2",$ODBCC_conBitacora,$laBitacora);
$preinscrito = false;

function envioValido() {
	global $raizDelSitio;
	$formOK = false;
	if (isset($_SERVER['HTTP_REFERER'])) {
		$formOK = ($_SERVER['HTTP_REFERER'] == $raizDelSitio .'planilla_r.php');
	}
    $formOK = $formOK && isset($_REQUEST['ci_e']) && isset($_REQUEST['conducta']);

	return $formOK;
}

function generarSQL($tabla, $nCampo, $aValores) {

	// OJO OJO OJO OJO:
	// traducimos las comillas simples (') a dos comillas ('') 
	// para poder insertarla en los campos apellidos y nombres
	// con la funcion addslashes(), pero para ello
	// la opcion 'magic_quotes_sybase' debe ser '1' de lo
	// contrario, las traduce a (\')
	ini_set('magic_quotes_sybase','1'); //para Centura SQLBase Server


    $campos = "";
    foreach ($nCampo as $campo) {
		$campos .= "".trim($campo).",";
    }
    
    $campos = trim(substr($campos,0,-1));    //Metto tutti i campi in un'unica variabile
    $valores = "";
	foreach ($nCampo as $campo) {
		$val=trim($aValores[$campo]);
		if (eregi("NULL",$val) == 0) $valores .= "'".addslashes($val)."',";
       else
          $valores .= "NULL,";
      }
      $valores = trim(substr($valores,0,-1));    //Inserisco tutti i valori in un'unica variabili distinguentoli dai
                                                //dai valori nulli e non nulli
      $query = "INSERT INTO ".$tabla."(".$campos.") VALUES (".trim($valores).")";    //creo la query
	  return $query;
}
	

function crearEjecutarSQL($exped) {
	global $_d, $conex, $preinscrito;
	
	$exped = date("y")."-".$_d['ci_e'];
	$_d['exp_e'] = $exped;
	/*$ind=explode(',',$_d['ind_cnu']);
	$ind_cnu = "$ind[0]"."."."$ind[1]";
	$_d['ind_cnu'] = substr($ind_cnu, 0, strlen($ind_cnu) - 1);*/

	/*$ind1= substr($_d['ind_cnu'], 0, strlen($_d['ind_cnu']) - 3);
	$ind2= substr($_d['ind_cnu'], 3, strlen($_d['ind_cnu']));
	$_d['ind_cnu'] = $ind1.".".$ind2;*/

	$_d['ind_cnu'] = str_replace(",", ".", $_d['ind_cnu']);
	

	$varDace002 = array('nac_e','ci_e','res_extraj','doc_ident','pasaporte_nro',
				'apellidos','apellidos2','nombres','nombres2','f_nac_e','exp_e',
				'p_nac_e','l_nac_e','edo_c_e','sexo','correo1','correo2','avenida',
				'urbanizacion','manzana','nrocasa','ciudad','estado','telefono1',
				'telefono2','telefono3','c_uni_ca','conducta','becario','c_ingreso', 'opcion_cnu','ind_cnu','organismo','sit_e','estrato_social','ent_fed');
	
	$delDace002 = "DELETE FROM DACE002 WHERE EXP_E='$exped'";

	$varDobeAcad = array('exp_e','plantel','tipo_plantel',
		'sistema_estudio','turno_estudio','titulo_b','promedio','codigo_c','codigo_e','codigo_p','codigo_m','ano_egre_cole');
	$delDobeAcad = "DELETE FROM DOBE_ACADEMICO WHERE EXP_E='$exped'";
		
	$varDobeSocE = array('exp_e','trabaja','turno_trabajo','instr_padre',
		'ocup_padre','instr_madre','ocup_madre','tipo_vivienda',
		'monto_alq','ingreso_f','tipo_disca','carnet_disca','afrodescen');
	$delDobeSocE = "DELETE FROM DOBE_SOCIOECONOMIC WHERE EXP_E='$exped'";
	
	if($preinscrito) {
		@$conex->ExecSQL($delDace002,__LINE__, true);
	}
	@$conex->ExecSQL(generarSQL('DACE002', $varDace002, $_d),__LINE__, true);
	if ($conex->fmodif == 0) return false;
	
	if($preinscrito) {
		@$conex->ExecSQL($delDobeAcad,__LINE__, true);
	}
	@$conex->ExecSQL(generarSQL('DOBE_ACADEMICO', $varDobeAcad, $_d),__LINE__, true);
	if ($conex->fmodif == 0) return false;
	
	if($preinscrito) {
		@$conex->ExecSQL($delDobeSocE,__LINE__, true);
	}
	@$conex->ExecSQL(generarSQL('DOBE_SOCIOECONOMIC', $varDobeSocE, $_d),__LINE__, true);
	if ($conex->fmodif == 0) return false;
	return true;
}

function obtenerExpediente($cedula) {
	global $conex, $sedeActiva, $preinscrito;
	$dSQL = "SELECT exp_e from DACE002 where ci_e='$cedula'";
	@$conex->ExecSQL($dSQL);
	if ($conex->filas == 1) {
		$preinscrito = true;
		return $conex->result[0][0];
	}
	else {//obtener un nuevo expediente:
		if ($sedeActiva == 'BQTO'){
			$dSQL = "SELECT LAPSO,BQTO,CARORA from EXPLIBRE";
			@$conex->ExecSQL($dSQL);
			if ($conex->status == 'OK') {
				$LapsoAct = $conex->result[0][0];
				$PExpBqto = $conex->result[0][1];
				$PExpCaro = $conex->result[0][2];
				if (intval($_REQUEST['c_uni_ca'],10) < 100) {
					$nEXP=$PExpBqto;
					$PExpBqto++;
					$cEXP = substr("000".$nEXP,-4);
				}
				else {
					$nEXP=$PExpCaro;
					$PExpCaro++;
					$cEXP = "C".substr("00".$nEXP,-3);
				}
 				$dSQL = "UPDATE EXPLIBRE SET BQTO=$PExpBqto, CARORA=$PExpCaro WHERE LAPSO='$LapsoAct'";
				@$conex->ExecSQL($dSQL,__LINE__,true);
				if ($conex->fmodif == 0) {
					$cEXP = '0';
				}
			}
			else {
				$cEXP = '0';
			}
		}
		else if ($sedeActiva == 'CCS'){
			$dSQL = "SELECT LAPSO,CCS from EXPLIBRE";
			@$conex->ExecSQL($dSQL);
			if ($conex->status == 'OK') {
				$LapsoAct = $conex->result[0][0];
				$PExpCCS = $conex->result[0][1];
				$nEXP=$PExpCCS;
				$PExpCCS++;
				$cEXP = substr("000".$nEXP,-4);
 				$dSQL = "UPDATE EXPLIBRE SET CCS=$PExpCCS WHERE LAPSO='$LapsoAct'";
				@$conex->ExecSQL($dSQL,__LINE__,true);
				if ($conex->fmodif == 0) {
					$cEXP = '0';
				}
			}
			else {
				$cEXP = '0';
			}
		}
		else if ($sedeActiva == 'POZ'){
			$dSQL = "SELECT LAPSO,POZ from EXPLIBRE";
			@$conex->ExecSQL($dSQL);
			if ($conex->status == 'OK') {
				$LapsoAct = $conex->result[0][0];
				$PExpCCS = $conex->result[0][1];
				$nEXP=$PExpCCS;
				$PExpCCS++;
				$cEXP = substr("000".$nEXP,-4);
 				$dSQL = "UPDATE EXPLIBRE SET POZ=$PExpCCS WHERE LAPSO='$LapsoAct'";
				@$conex->ExecSQL($dSQL,__LINE__,true);
				if ($conex->fmodif == 0) {
					$cEXP = '0';
				}
			}
			else {
				$cEXP = '0';
			}
		}



		return $cEXP;
	}
}

function guardarDatos() {
	global $conex;

	$conex->iniciarTransaccion("\nInicio Transaccion");
	$exped = obtenerExpediente($_REQUEST['ci_e']);
	if($exped !='0') {
		if(crearEjecutarSQL($exped)) {
			if ($conex->finalizarTransaccion("Fin Transaccion")) {
				return true;
			}
			else {
				$conex->deshacerTransaccion("Rollback Transaccion");
				return false;
			}
		}
		else {
			$conex->deshacerTransaccion("Rollback Transaccion");
			return false;
		}
	}
	else if($exped =='0') {
		$conex->deshacerTransaccion("Rollback Transaccion");
        return false;
	}
}

function reportar($exped) {
	global $noCache, $noJavaScript, $lapsoProceso, $_d;
?>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<?php
			print $noCache; 
			print $noJavaScript;

			

		?>
		<title>Planilla de Preinscripci&oacute;n Lapso <?php print $lapsoProceso; ?></title>
		<script languaje="Javascript">
		<!--
        function imprimir(fi) {
            with (fi) {
                bimp.style.display="none";
                bexit.style.display="none";
                window.print();
                //alert(msgI);
                bimp.style.display="block";
                bexit.style.display="block";
            }
        }
		//-->
        </script>
		<link href="inc/estilo.css" rel="stylesheet" type="text/css">
		</head>
        <body  <?php global $botonDerecho; echo $botonDerecho; ?> onLoad="javascript:self.focus();" 
		      onclose="return false"> 
				<?php include_once('inc/reporte_e.php'); ?>
		<form name="datos_p" method="POST" action="planilla_r.php">
				<?php generarFormDatos(); ?>
		</form>
		</body>
	</html>
<?php
}

function generarFormDatos() {
	global $_d;

	print <<<C000
	<input type="hidden" name="cedula" value="{$_d['ci_e']}">
	<input type="hidden" name="contra" value="{$_d['apellidos']}">

C000
;
	reset($_d);
	while (list($nombre, $valor) = each($_d)) {
		print <<<C001
	<input type="hidden" name="$nombre" value="$valor">

C001
;
	}
}

function regresar() {
	global $raizDelSitio;
?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script language='javascript'>
	<!--
	function irAtras() {
		msg = 'En este momento el servidor esta ocupado \n';
		msg = msg + 'y no se pudo realizar la operacion.\n';
		msg = msg + 'Por favor, pulse \'Aceptar\' para \n';
		msg = msg + 'regresar a la planilla y volver a intentar.\n';
		alert(msg);
		document.datos_p.submit();
	}
	//-->
	</script>
    </head>
    <body onLoad="irAtras();">
	<form name="datos_p" method="POST" action="planilla_r.php">
	<?php generarFormDatos(); ?>
	</form>
    </body>
    </html>
<?php

}

function volveraIndice() {
	global $raizDelSitio;
?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <META HTTP-EQUIV="Refresh"
        CONTENT="500;URL=<?php echo $raizDelSitio; ?>">
    </head>
    <body>
    </body>
    </html>
<?php
}

// programa principal;
if(envioValido()) {
	if(guardarDatos()) {
		reportar($_d['exp_e']);
	}
	else {
		regresar();
	}
}
else volveraIndice();
?>