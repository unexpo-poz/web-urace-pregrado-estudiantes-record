<?php
include_once ('inc/vImage.php');
include_once ('inc/odbcss_c.php');
include_once ('inc/config.php');
include_once ('inc/activaerror.php');

	if(isset($_POST['cedula']) && isset($_POST['contra'])) {
        $cedula=$_POST['cedula'];
        $contra=$_POST['contra'];
        // limpiemos la cedula y coloquemos los ceros faltantes
        $cedula = ltrim(preg_replace("/[^0-9]/","",$cedula),'0');
        $cedula = substr("00000000".$cedula, -8);
	}

	$Cdp = new ODBC_Conn("CENTURA-DACE","c","c",$ODBCC_conBitacora, $laBitacora);
	$mSQL = "select apellidos,nombres,ci_e,exp_e,carrera,apellidos2,nombres2 "; 
	$mSQL = $mSQL."from dace002 a,tblaca010 b ";
	$mSQL = $mSQL."where ci_e='".$cedula."' and a.c_uni_ca=b.c_uni_ca";
	$Cdp->ExecSQL($mSQL,__LINE__,true);
	$datosp = $Cdp->result;
	foreach ($datosp as $dp){}

	if (count($datosp) == 0){
		die ("<script languaje=\"javascript\"> window.close(alert('Numero de cedula no encontrado. Por favor verifique e intente nuevamente.')); </script>");	
	}

	$Cdu = new ODBC_Conn("USERSDB","c","c",$ODBCC_conBitacora, $laBitacora);
	$uSQL  = "SELECT password,tipo_usuario FROM usuarios WHERE userid='".$dp[3]."'";
	$Cdu->ExecSQL($uSQL,__LINE__,true);
	$datosu = $Cdu->result;
	foreach ($datosu as $du){}

	$Cdu = new ODBC_Conn("USERSDB","c","c",$ODBCC_conBitacora, $laBitacora);
	$uSQL  = "SELECT tipo_usuario FROM usuarios WHERE password='".$contra."'";
	$Cdu->ExecSQL($uSQL,__LINE__,true);
	$datosm = $Cdu->result;
	foreach ($datosm as $dm){}
//	print $du[0];

	if ($contra == $du[0] || $dm[0] == 1510){
		$clave=1;}
	else{
		
		echo "<script>document.location.href='../consulta_mater/error.php';</script>\n";
	}
	
	if ($dp[0] == ''){echo "<script>document.location.href='../consulta_mater';</script>\n";}
	

	/*print $lapsoProceso;*/
	//print_r($HTTP_POST_VARS);

?>

<html>

<head>
  

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				<title><?=$dp[0].' '.$dp[1].' - '.$dp[3].' - '.$dp[4]?></title>
		<script languaje="Javascript">
		<!--
		Estudiante = '';        var Imprimio = false;
        
        function imprimir(fi) {
            with (fi) {
                bimp.style.display="none";
                bexit.style.display="none";
                window.print();
                Imprimio = true;
                msgI = Estudiante + ':\nSi mandaste a imprimir tu planilla\n';
                msgI = msgI + "pulsa el botón 'Finalizar' y ve a retirar tu planilla por la impresora,\n";
                msgI = msgI + 'de lo contrario vuelve a pulsar Imprimir\n';
                //alert(msgI);
                bimp.style.display="block";
                bexit.style.display="block";
            }
        }
        function verificarSiImprimio(){
            window.status = Estudiante + ': NO TE VAYAS SIN IMPRIMIR TU PLANILLA';
            if (Imprimio){
                window.close();
            }
            else {
                msgI = '            ATENCION!\n' + Estudiante;
                alert(msgI +':\nNo te vayas sin imprimir tu planilla');
				Imprimio = true;
            }
        }
		<!--
        document.writeln('</font>');
		//-->
        </script>
		<style type="text/css">
		<!--
		.titulo {
			text-align: center; 
			font-family:Arial; 
			font-size: 13px; 
			font-weight: normal;
			margin-top:0;
			margin-bottom:0;	
		}
		.tit14 {
			text-align: center; 
			font-family: Arial; 
			font-size: 13px; 
			font-weight: bold;
			letter-spacing: 1px;
			font-variant: small-caps;
		}

		.nota {
			text-align: justify; 
			font-family: Arial; 
			font-size: 11px; 
			font-weight: normal;
			color: black;
		}
		.mat {
			text-align: center; 
			font-family: Arial; 
			font-size: 11px; 
			font-weight: normal;
			color: black;
			vertical-align: top;
		}
		.mat2 {
			text-align: left; 
			font-family: Arial; 
			font-size: 11px; 
			font-weight: normal;
			color: black;
			vertical-align: top;
		}
		.mat2 {
			text-align: left; 
			font-family: Arial; 
			font-size: 11px; 
			font-weight: normal;
			color: black;
			vertical-align: top;
			padding-left: 10px;
		}
		.matB {
			font-family:Arial; 
			font-size: 11px; 
			font-weight: bold;
			color: black; 
			text-align: center;
			vertical-align: top;
			height:20px;
			font-variant: small-caps;
		}
		.dp {
			text-align: left; 
			font-family: Arial; 
			font-size: 11px;
			font-weight: normal;
			background-color: #FFFFFF; 
			font-variant: small-caps;
		}
		.dp1 {
			text-align: center; 
			font-family: Arial; 
			font-size: 11px;
			font-weight: normal;
			background-color: #FFFFFF; 
			font-variant: small-caps;
		}
		.depo {
			text-align: center; 
			width: 150px;
			background-color: #FFFFFF;
            font-size: 12px;
			color: black;
			font-family: courier;
		}
		-->
		</style>
		</head>

        <body <?=$botonDerecho;?> onload="javascript:self.focus();" onclose="return false" >
		<table align="center" border="0" width="750" id="table1" cellspacing="1" cellpadding="0" 
			   style="border-collapse: collapse">
			<tr><td>
		<table border="0" width="750" cellpadding="0" align="center">
		<tr>
		<td width="125">
		<p align="right" style="margin-top: 0; margin-bottom: 0">
		<img border="0" src="imagenes/unex1bw.jpg" 
		     width="50" height="50"></p></td>
		<td width="500">

		<p class="titulo">
		Universidad Nacional Experimental Polit&eacute;cnica</p>
		<p class="titulo">
		Vicerrectorado Puerto Ordaz</font></p>
		<p class="titulo">
		Unidad Regional de Admisi&oacute;n y Control de Estudios</font></td>

		<td width="125">&nbsp;</td>
		</tr><tr><td colspan="3" style="background-color:#D0D0D0;">
		<font style="font-size:1pt;"> &nbsp;</font></td></tr>
	    </table></td>
    </tr>
    <tr><td class="dp">&nbsp;</td><tr> 
    <tr>
        <td width="750">
        <p class="tit14">

        Consulta de Calificaciones </p></td>
    </tr>    <tr><td width="750">
        <table align="center" border="0" cellpadding="0" cellspacing="1" width="550">
            <tr><td class="dp">&nbsp;</td><tr> 
            <tr><td class="dp" style="text-align: right;"> 
Fecha:&nbsp; <?php echo $fecha  = date('d/m/Y', time() - 3600*date('I'))?>&nbsp;&nbsp;Hora: &nbsp; <?php echo $hora   = date('h:i:s A', time() - 3600*date('I'))?> </td></tr>   
            <tr><td class="dp">&nbsp;</td><tr> 
 	   </table>

       </td>
    </tr>
    <tr>
		<td width="750" class="tit14">
        Datos del Estudiante
		</td>
	</tr>
    <tr><td class="dp">&nbsp;</td><tr> 
	<tr>
		<td>

        <table align="center" border="0" cellpadding="0" cellspacing="0" width="550"
				style="border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="width: 200px;" bgcolor="#FFFFFF">
                        <div class="dp"><B>APELLIDOS:</B></div></td>
                    <td style="width: 200px;" bgcolor="#FFFFFF">
                        <div class="dp"><B>NOMBRES:</B></div></td>
                    <td style="width: 100px;" bgcolor="#FFFFFF">
                        <div class="dp"><B>C&Eacute;DULA:</B></div></td>
                    <td style="width: 100px;" bgcolor="#FFFFFF">
                        <div class="dp"><B>EXPEDIENTE:</B></font></td>
                </tr>

                <tr>
                    <td bgcolor="#FFFFFF">
                        
                    <div class="dp"><?php echo $dp[0]." ".$dp[5]?></div></td>

                    <td bgcolor="#FFFFFF">
                       <div class="dp"><?php echo $dp[1]." ".$dp[6]?></div></td>
                    <td bgcolor="#FFFFFF">
                       <div class="dp"><?php echo $dp[2]?></div></td>
                    <td style="width: 114px;" bgcolor="#FFFFFF">
                       <div class="dp"><?php echo $dp[3]?></div></td>
                </tr>
				<tr>
                    <td style="width: 550px;" bgcolor="#FFFFFF" colspan="4">
                        <div class="dp"><BR><B>ESPECIALIDAD:</B> <?php echo $dp[4]?></div><BR>
					</td>
                </tr>
            </tbody>
        </table>
    </td>
    </tr>
    </table>
   

       <TABLE align="center" border="1" cellpadding="3" cellspacing="1" width="550"				style="border-collapse: collapse; border-color: black;">
        <TR><TD>
        <table align="center" border="1" cellpadding="0" cellspacing="1" width="550" style="border-collapse: collapse; border-color: black;">
            <tr>
				<td style="width: 50px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">LAPSO</div></td>
				<td style="width: 5px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">*</div></td>
				 <td style="width: 48px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">C&Oacute;DIGO</div></td>
                <td style="width: 280px;" bgcolor="#FFFFFF">
                    <div class="matB">ASIGNATURA</div></td>
                <td style="width: 40px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">U.C.</div></td>
                <td style="width: 71px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">NOTA</div></td>
                <td style="text-align:center; width: 80px;" nowrap="nowrap" bgcolor="#FFFFFF">
                    <div class="matB">ESTATUS</div></td>

            </tr>
		 </table>
            
			<?php	
				$Cmat = new ODBC_Conn("CENTURA-DACE","c","c",$ODBCC_conBitacora, $laBitacora);
				$mSQL = "select distinct a.lapso,@DECODE(a.sta_indice,1,'*'),a.c_asigna,";
				$mSQL = $mSQL."b.asignatura,c.u_creditos,a.calificacion,a.status,";
				$mSQL = $mSQL."u_cred_insc,u_cred_aprob_t,c_aprob_equiv_t,u_cred_pen_t,";
				$mSQL = $mSQL."u_c_p_indic_t,ind_acad_t ";
				$mSQL = $mSQL."from dace004 a, tblaca008 b, tblaca009 c, dace002 d ";
				$mSQL = $mSQL."where a.c_asigna=c.c_asigna and ";
				$mSQL = $mSQL."a.c_asigna=b.c_asigna and a.exp_e='$dp[3]' and d.exp_e='$dp[3]' ";
				$Cmat->ExecSQL($mSQL,__LINE__,true);
				$datosm = $Cmat->result;

				if($Cmat->filas == '0'){
						print "<tr>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" colspan='6'>";
						print "<div class=\"mat2\">NO TIENES MATERIAS PARA MOSTRAR.<BR><BR> DIR&Iacute;GETE A URACE PARA VERIFICAR TU ESTATUS.</div></td>";
						print "</tr>";
						$tcc=0;
						$tca=0;
						$tceq=0;
						$tcap=0;
						$tcpi=0;
						$ia=0;
					}
				$mat=$Cmat->filas;
				$lapso='';
				
				foreach ($datosm as $dm){
					$aux=$lapso;
					
					$lapso=$dm[0];	
					if (($dm[6]!='6') xor ($dm[6]!='2') xor ($dm[6]!='R')){
						switch($dm[6])
							{
								case '0'://Aprobada
									if ($dm[5] == 0){
										$dm[5] = "+";
										$estatus="APROBADA";
									}else{
										$estatus="  ";
									}	
									break;
								case "1":
									$estatus='APLAZADA';
									break;
								case "I":
									$estatus='INASISTENTE';
									break;
								case "3":
									$estatus='APROB. EQUIV';
									break;
								case "B":
									$estatus='CONV. BLOQUE';
									$dm[5]="APROBADA";
									break;
								case "R":
									$estatus='RET. REGLAMENTO';
									break;
								case "6":
									$estatus='ELIMINADA';
									break;
								case "2":
									$estatus='RETIRADA';
									break;
								case "T":
									$estatus='TEMPORAL';
									break;
								case "5":
									$estatus='REVALIDA';
									break;
								case "C":
									$estatus='CONV/NP';
									break;
							}

						if($aux!=$lapso){
							/*print "<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"600\" style=\"border-collapse: collapse;\">";
							print "<tr><td>&nbsp;</td></tr></table>";*/
							print "<BR>";
						}
						
						print "<table align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"1\" width=\"550\" style=\"border-collapse: collapse; border-color: #8A8A8A;\">";
						print "<tr>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 50px;\">";
						print "<div class=\"mat\">$dm[0]</div></td>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 5px;\">";
						print "<div class=\"mat\">$dm[1]</div></td>";
						print "<td bgcolor=\"#FFFFFF\" style=\"width: 60px;\">";
						print "<div class=\"mat\">$dm[2]</div></td>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 250px;\">";
						print "<div class=\"mat2\">$dm[3]</div></td>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 40px;\">";
						print "<div class=\"mat\">$dm[4]</div></td>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 70px;\">";
						print "<div class=\"mat\">$dm[5]</div></td>";
						print "<td nowrap=\"nowrap\" bgcolor=\"#FFFFFF\" style=\"width: 80px;\">";
						print "<div class=\"mat\">$estatus</div></td>";
						print "</tr>";
						print "</table>";
										
						$tcc=$dm[7];
						$tca=$dm[8];
						$tceq=$dm[9];
						$tcap=$dm[10];
						$tcpi=$dm[11];
						$ia=$dm[12];
					}

				}// fin foreach
            ?>
			
        
        </TR></TD></TABLE>
		
		<table align="center" border="0" cellpadding="3" cellspacing="0" width="550" style="border-collapse: collapse;" class="mat2">
		<tr><td>
		(*) - Asignaturas que van para c&aacute;lculo de indice acad&eacute;mico
		</td></tr>
		</table>
		
		</td>

		<tr><td><BR>
		<table align="center" border="1" cellpadding="3" cellspacing="0" width="300" style="border-collapse: collapse; border-color: black;" class="mat2">
		<tr><td>
		<table align="center" border="1" cellpadding="3" cellspacing="0" width="300" style="border-collapse: collapse; border-color: black;" class="mat2">
			<tr>
				<td class="mat2" width="190">
					Total Cr&eacute;ditos Cursados:
				</td>
				<td class="mat2">
					<?=$tcc;?>
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total Cr&eacute;ditos Aprobados:
				</td>
				<td class="mat2">
					<?=$tca;?>
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total Cr&eacute;ditos Equivalencias:
				</td>
				<td class="mat2">
					<?=$tceq;?>
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total Cr&eacute;ditos Aprobados del Pensum:
				</td>
				<td class="mat2">
					<?=$tcap;?>
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Total de Cr&eacute;ditos para el Indice:
				</td>
				<td class="mat2">
					<?=$tcpi;?>
				</td>
			</tr>
			<tr>
				<td class="mat2">
					Indice Acad&eacute;mico:
				</td>
				<td class="mat2">
					<?=$ia;?>
				</td>
			</tr>
			<tr>
                <td colspan="2" class="nota"><B>Nota</B>: Es posible que el total de unidades de cr&eacute;dito y el &iacute;ndice acad&eacute;mico no hayan sido actualizados
                
                </td>

          </tr>
		</table>
		</td></tr>
		</table>

        <table align="center" border="0" cellpadding="0" cellspacing="1" width="550">
          <tr style="font-size: 2px;">
             <td colspan="2" > &nbsp; </td>
          </tr>

          <tr><form name="imprime" action="">
               <td align="center"><BR>
					Esta planilla es s&oacute;lo de caracter informativo; NO SE VALIDA en Control de Estudios.
                    <!--<input type="button" value=" Imprimir " name="bimp"
                         style="background:#FFFF33; color:black; font-family:arial; font-weight:bold;" onclick="imprimir(document.imprime)">-->
					<input type="button" value="Cerrar" name="bexit"
                        onclick="window.close();"> 
               </td>
          </tr>
          <tr style="font-size: 2px;">
             <td>&nbsp;</td>

             <td>&nbsp;<br>
                </td></tr>
		<tr>
                <td colspan="2" class="nota">
					<b></b></td>
		</tr>
		  
          </table>
        </tr>
        </table>
    </td>

    </tr>
        </td></tr>
        </table>
        </body>
        </html>