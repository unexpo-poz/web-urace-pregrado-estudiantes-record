function prepdata() {
	with(document.datos_p) {
		// nacionalidad
		switch(nac_eS.selectedIndex){
			case 1 : nac_e.value = "V"; break;
			case 2 : nac_e.value = "E"; break;
		}
		
		//carrera
		switch(c_uni_ca.selectedIndex){
			case 1 : carrera.value = "2"; break;//ING. MECANIVA
			case 2 : carrera.value = "3"; break;//ING. ELECTRICA
			case 3 : carrera.value = "4"; break;//ING. METALURGIA
			case 4 : carrera.value = "5"; break;//ING. ELECTRONICA
			case 5 : carrera.value = "6"; break;//ING. INDUSTRIAL
		}
		
		//fecha de nacimiento	
		laFechaS =	1900 + parseInt(anioN.value,10); 
		laFechaS += '-';
		laFechaS +=	mesN.selectedIndex;
		laFechaS += '-';
		laFechaS +=	diaN.selectedIndex; 
		f_nac_e.value = laFechaS;
		edad.disabled =false;
		
		//estado civil
		edo_c_e.value = edo_c_eS.value;
		var edo = edo_c_eS.value;
		switch(edo){
			case 'SOLTERO' : edo_c_e.value = '1'; break;
			case 'CASADO' : edo_c_e.value = '2'; break;
			case 'CONCUBINO' : edo_c_e.value = '3'; break;
			case 'VIUDO' : edo_c_e.value = '4'; break;
			case 'DIVORCIADO' : edo_c_e.value = '5'; break;
		}

		// sexo
		sexo.value = sexoS.value;
		var sex = sexoS.value;
		switch(sex){
			case 'FEMENINO' : sexo.value = '0'; break;
			case 'MASCULINO' : sexo.value = '1'; break;
		}

		//opcion CNU
		opcion_cnu.value = opcion_cnuS.value;
		var lopcion = opcion_cnuS.value;
		switch(lopcion){
			case 'PRIMERA' : opcion_cnu.value = '1'; break;
			case 'SEGUNDA' : opcion_cnu.value = '2'; break;
			case 'TERCERA' : opcion_cnu.value = '3'; break;
			case 'CUARTA' : opcion_cnu.value = '4'; break;
			case 'QUINTA' : opcion_cnu.value = '5'; break;
			case 'SEXTA' : opcion_cnu.value = '6'; break;
			case 'NINGUNA' : opcion_cnu.value = '0'; break;
		}
		
		// becario
		becario.value = becarioS.value;
		var lbeca = becarioS.value;
		switch(lbeca) {
			case 'SI'	: becario.value = 'SI'; break;
			case 'NO'	: becario.value = 'NO'; break;
		}

		// Tipo Extranjero
		res_extraj.value = res_extrajS.value;
		var lres = res_extrajS.value;
		switch(lres) {
			case 'RESIDENTE'	: res_extraj.value = 'RESIDENTE'; break;
			case 'TRANSEUNTE'	: res_extraj.value = 'TRANSEUNTE'; break;
		}

		// Documento de Identidad
		doc_ident.value = doc_identS.value;
		var lres = doc_identS.value;
		switch(lres) {
			case 'RESIDENTE'	: doc_ident.value = 'RESIDENTE'; break;
			case 'TRANSEUNTE'	: doc_ident.value = 'TRANSEUNTE'; break;
		}
		
		//////////Actualizaciones/////////////////////
		
		//Discapacidad
		var disca = discaS.value;
		switch(disca) {
			case 'SI'	: discaS.value = 'SI'; break;
			case 'NO'	: discaS.value = 'NO'; break;
		}

		// hidden			select
		tipo_disca.value = tipo_discaS.value;
		//alert (tipo_disca.value);
		if(tipo_disca.value != ''){//si tipo de discapacidad tiene un valor
			discaS.value = 'SI';//Discapacidad muestra SI
			//al select del tipo de discapacidad se le asigna el hidden
			tipo_discaS.value = tipo_disca.value;
		}
		
		//Pais de Nacimiento
		// hidden			select
		p_nac_e.value = p_nac_eS.value;
		if (p_nac_e.value == '232'){//VENEZUELA PAIS DE NACIMIENTO
			ent_fed.value = ent_fedS.value;//Estado de Nacimiento
			//NAME DE HIDDNEN//ID DEL SELECT
			//alert(document.getElementById('lnace_S_1').value);
			//if (lnace_S_1.value != ''){
			l_nac_e.value = document.getElementById('lnace_S_1').value;
			//alert(l_nac_e.value);
			//lnace_S_1.value;//Ciudad de Nacimiento
			//}
		} 
		else if (p_nac_e.value != '232') {//EXTRANJERO
			ent_fed.value = ent_fed2.value;
			l_nac_e.value = l_nac_e2.value;
		}
			
		//Pais del plantel
		//NAME DE HIDDNEN   //ID DEL SELECT
		codigo_p.value = codigo_pS.value;
		
		if (codigo_p.value == '232'){//VENEZUELA PAIS DEL PLANTEL
		codigo_e.value = codigo_eS.value;//Edo Plantel
		codigo_c.value = document.getElementById('codigoc_S_1').value;//Ciudad del plantel
		codigo_m.value = document.getElementById('codigom_S_1').value;//Municipio del plantel
		}
		else if (codigo_p.value != '232'){//EXTRANJERO
		codigo_e.value = codigo_e2.value;//Edo Plantel
		codigo_c.value = codigo_c2.value;//Ciudad del plnatel		
		codigo_m.value = codigo_m2.value;//Municipio del plantel			
		}
		//a�o de egreso
		ano_egre_cole.value = ano_egre_coleS.value;
		
		
		// tipo discapacidad
		//tipo_disca.value = tipo_discaS.value;
		var disca = discaS.value;
		switch(disca) {
			case 'SI'	: discaS.value = 'SI'; break;
			case 'NO'	: discaS.value = 'NO'; break;
		}

		// afrodescendiente
		var afro = afroS.value;
		switch(afro){
					 //Hidden
			case 1 : afroS.value = "1"; break;
			case 0 : afroS.value = "0"; break;
		}
		// hidden			select
		//alert (afroS.value);
		if (afroS.value == '1'){// Seleccion� SI
			if (afrodescenS.value == 'OTRO'){//Si seleccion� OTRO
				afrodescen.value = 'OTRO'+especifique.value;
			}
			else
				afrodescen.value = afrodescenS.value;
		}
		else {// Seleccion� NO
			afrodescen.value = '';// queda en blanco al seleccionar NO
			//afrodescen.value = afroS.value;
		}
		/////////////////////////////////////////////////////////////
		//telefono 1
		telefono1.value = codT.value+'-'+telefono.value;
		
		//telefono 2
		telefono2.value = celcod.value+'-'+celnro.value;
		
		//telefono 3
		telefono3.value = codfax.value+'-'+nrofax.value;
		
		// direccion de residencia
		dirr_e.value = avCalleR.value+';'+barrioR.value+';'+casaR.value+';'+ciudadR.value+';'+estadoR.value;
		
		//telefono de residencia
		telfr_e.value = codTR.value+'-'+telefonoR.value;
		
		//datos academicos:
		tipo_plantel.value = tipo_plantelS.value;

		if(sistema_estudioS.selectedIndex == (sistema_estudioS.length - 1)){
			sistema_estudio.value = 'OTRO:'+otroSistemaE.value;
		}
		else sistema_estudio.value = sistema_estudioS.value;

		if(turno_estudioS.selectedIndex == (turno_estudioS.length - 1)){
			turno_estudio.value = 'OTRO:'+otroTurnoE.value;
		}
		else turno_estudio.value = turno_estudioS.value;
		if(titulo_bS.selectedIndex == (titulo_bS.length - 1)){
			titulo_b.value = 'OTRO:'+otroTitulo.value;
		}
		else titulo_b.value = titulo_bS.value;
		promedio.value = promedio.value;
		
		//datos socioeconomicos
		trabaja.value = trabajaS.selectedIndex;
		turno_trabajo.value = turnoTrabaja.value;

		instr_padre.value = instr_padreS.value;
		if(ocup_padreS.selectedIndex == (ocup_padreS.length - 1)){
			ocup_padre.value = 'OTRO:'+ otroOcupPadre.value;
		}
		else ocup_padre.value = ocup_padreS.value;
		instr_madre.value = instr_madreS.value;
		if(ocup_madreS.selectedIndex == (ocup_madreS.length - 1)){
			ocup_madre.value = 'OTRO:'+ otroOcupMadre.value;
		}
		else ocup_madre.value = ocup_madreS.value;
		tipo_vivienda.value = tipo_viviendaS.value;
		ingreso_f.value =ingreso_fS.value;
		ingreso_fBs.value =ingreso_fS.options[ingreso_fS.selectedIndex].text;

		//estrato social
		estrato_social.value = estratoS.value;
		var estrato = becarioS.value;
		switch(estrato) {
			case 'BAJO'	 : estrato_social.value = 'BAJO'; break;
			case 'MEDIO' : estrato_social.value = 'MEDIO'; break;
			case 'ALTO'	 : estrato_social.value = 'ALTO'; break;
		}
	}
}
function reiniciarTodo() {
	with (document.datos_p) {
		var opcion = 0;
		var opcioni = 0;
		var nomb_afro = afrodescen.value;
		//alert (nomb_afro.length);
		// Mostramos si es Afrodescendiente y el origen
		//if (nomb_afro == ""){
		if (nomb_afro == ""){
			afroS.selectedIndex = 2; //NO en Afrodescendiente
			afrodescenS.style.display='none';
		} else {
			afroS.selectedIndex = 1;//Muestra SI en Afrodescendiente:
			afrodescenS.style.display='block';
			document.getElementById('origenEtq').style.color='#000000';
			var aux = afrodescen.value.substring(0, 4);//sustrae OTRO, si lo tiene
			if (aux == 'OTRO'){
				afrodescenS.value = 'OTRO';
				especifique.style.display='block';
				especifique.value = afrodescen.value.substring(4);
			} else afrodescenS.value = nomb_afro;
		}
		
		// Mostramos si es discapacitado, el tipo de discapacidad y el carnet
		if (tipo_disca.value != ''){
			discaS.selectedIndex = 1;//Muestra SI en Discapacidad:
			tipo_discaS.style.display='block';
			document.getElementById('discaEtq').style.color='#000000';
						
			tipo_discaS.value = tipo_disca.value;
			
			carnet_disca.style.display='block';
			document.getElementById('carnetEtq').style.color='#000000';
			//el carnet discapacitado debe tener el valor de la bd
			
			}			
		else if (tipo_disca.value == '')	{
			discaS.selectedIndex = 2;//NO en Discapacidad
			tipo_disca.style.display='none';
			carnet_disca.style.display='none'
			carnet_disca.value='';
		}

		//pais de Nacimiento
		p_nac_eS.value= p_nac_e.value;
		//alert(p_nac_e.value);
		//estado Y ciudades de nacimiento		
		if (p_nac_eS.value == '232'){//si pais de nacimiento es venezuela
			document.getElementById("span_edo_nac").style.display = "block";
			document.getElementById("span_ciudad_nac").style.display = "block";
			document.getElementById("lnace_S_1").style.display = "block";
			document.getElementById("entfed_S_1").style.display = "block";
			ent_fedS.value = ent_fed.value;
			lnace_S_1.value = l_nac_e.value;
			
		//MUESTRA ESTADO Y CIUDAD DE NACIMIENTO EXTRANJERAS	
		} else if (p_nac_eS.value != '232' && p_nac_eS.value != ''){
			document.getElementById("entfedEtiqueta").style.display = "block";
			document.getElementById("span_edo_Ext").style.display = "block";
			document.getElementById("lnaceEtiqueta").style.display = "block";
			document.getElementById("span_cd_Ext").style.display = "block";
			ent_fed2.style.display = "block";
			l_nac_e2.style.display = "block";
			ent_fed2.value = ent_fed.value;
			l_nac_e2.value = l_nac_e.value;
		}
		
		//pais de Ubicacion del plantel
		codigo_pS.value= codigo_p.value;
		
		//estado Ubicacion del plantel
		if (codigo_pS.value == '232'){
			document.getElementById("span_edo_liceo").style.display = "block";
			document.getElementById("edoEtiqueta").style.display = "block";
			document.getElementById("span_ciudad_liceo").style.display = "block";
			document.getElementById("cdEtiqueta").style.display = "block";
			document.getElementById("span_municipio_plantel").style.display = "block";
			document.getElementById("mpioEtiqueta").style.display = "block";
			document.getElementById("codigoe_S_1").style.display = "block";
			codigo_eS.value = codigo_e.value;
			codigo_cS.value = codigo_c.value;
			codigo_mS.value = codigo_m.value;
		} else if (codigo_pS.value != '232' && codigo_pS.value != ''){
			document.getElementById("span_otroPaisEdoLiceo").style.display = "block";
			document.getElementById("codigoeEtiqueta").style.display = "block";
			codigo_e2.style.display = "block";
			codigo_e2.value = codigo_e.value;
			
			document.getElementById("span_otroPaisCdLiceo").style.display = "block";
			document.getElementById("codigocEtiqueta").style.display = "block";
			codigo_c2.style.display = "block";
			codigo_c2.value = codigo_c.value;
			
			document.getElementById("span_otroPaisMLiceo").style.display = "block";
			document.getElementById("codigomEtiqueta").style.display = "block";
			codigo_m2.style.display = "block";
			codigo_m2.value = codigo_m.value;
		}
		
		//a�o de egreso
		ano_egre_coleS.value = ano_egre_cole.value;
		
		//nacionalidad
		switch(nac_e.value) {
			case "V"	: opcion = 1; break;
			case "E"	: opcion = 2; break;
		}
		nac_eS.selectedIndex = opcion;
		
		//Actualizamos fecha de nacimiento:
		laFechaS = f_nac_e.value+"---"; //por si la fecha esta en blanco
		laFecha  = new Array();
		laFecha = laFechaS.split('-'); //anio,mes,dia
		//	alert('['+laFecha+']'+laFecha[2]+laFecha[1]+laFecha[0]);
		if (laFechaS != ""){
			diaN.selectedIndex = laFecha[2]; 
			mesN.selectedIndex = laFecha[1];
			anioN.value = laFecha[0].substr(2,4); 
		}
		calcularEdad();
		// seleccionamos edo civil
		
		edo_c_eS.selectedIndex = edo_c_e.value;

		//seleccionamos sexo
		switch(sexo.value) {
			case "0"	: opcion = 1; break;
			case "1"	: opcion = 2; break;
		}
		sexoS.selectedIndex = opcion;
		
		// Si trabaja, mostramos su turno de trabajo
		if(trabaja.value == "1") {
			switch (turno_trabajo.value){
				case "DIURNO"	: opcion = 1; break;
				case "NOCTURNO"	: opcion = 2; break;
				case "MIXTO"	: opcion = 3; break;
				default			: opcion = 0; 
			}
			trabajaS.selectedIndex = 1;
			turnoTrabaja.selectedIndex = opcion;
			turnoTrabaja.style.display = 'block';
		}
		else if (trabaja.value == "2")	{
			trabajaS.selectedIndex = 2;
		}
		
		// Si es extranjero, mostramos los datos adicionales
		// Residencia de Extranjeria
		if(nac_e.value == "E") {
			switch (res_extraj.value){
				case "RESIDENTE"	: opcion = 1; break;
				case "TRANSEUNTE"	: opcion = 2; break;				
				default			    : opcion = 0; 
			}
		
		// Tipo de Documento
			switch(doc_ident.value){
				case "CEDULA"	    : opcioni = 1; break;
				case "PASAPORTE"	: opcioni = 2; break;				
				default			    : opcioni = 0; 
			}
			nac_eS.selectedIndex = 2;
			res_extrajS.selectedIndex = opcion;
			res_extrajS.style.display = 'block';
			document.getElementById('tipoEtq').style.color='#000000';
			doc_identS.selectedIndex = opcioni;
			doc_identS.style.display = 'block';
			document.getElementById('docEtq').style.color='#000000';
			if (doc_ident.value == "PASAPORTE"){
			pasaporte_nro.style.display='block';
			document.getElementById('pasaporteEtq').style.color='#000000';
			}
		}
		else if (nac_e.value == "V")	{
			nac_eS.selectedIndex = 1;
			pasaporte_nro.style.display='none';
			document.getElementById('pasaporteEtq').style.color='#D2DEF0';
		}

		// Mostramos la opcion CNU
			switch (opcion_cnu.value){
				case "1"	: opcion = 1; break;
				case "2"	: opcion = 2; break;
				case "3"	: opcion = 3; break;
				case "4"	: opcion = 4; break;
				case "5"	: opcion = 5; break;
				case "6"	: opcion = 6; break;
				case "0"	: opcion = 7; break;
				default			: opcion = 0; 
			}
			opcion_cnuS.selectedIndex = opcion;
		
		// Mostramos si es becario y por quien
		if (becario.value == "SI"){			
			organismo.style.display='block';
			document.getElementById('orgEtq').style.color='#000000';
			becarioS.selectedIndex = 1;				
			}			
		else if (becario.value == "NO")	{
			organismo.style.display='none';
			becarioS.selectedIndex = 2;	
		}

		// Mostramos si pertenece a etnia indigena
		if (etnia_indigena.value != ""){			
			etnia_indigena.style.display='block';
			document.getElementById('etniaEtq').style.color='#000000';
			etnia_indigenaS.selectedIndex = 1;				
			}			
		else if (etnia_indigena.value == "")	{
			etnia_indigena.style.display='none';
			etnia_indigenaS.selectedIndex = 2;	
		}
		
		// Mostramos estrato
		switch (estrato_social.value){ 
			case "BAJO"	: opcion = 1; break;
			case "MEDIO": opcion = 2; break;
			case "ALTO"	: opcion = 3; break;
			default	: opcion = 0; 
		}
		estratoS.selectedIndex = opcion;
				
		// mostramos la direccion
		var direc = new Array();
		//telefono1
		if (telefono1.value !="") {
			direc			= telefono1.value.split("-");
			codT.value		= direc[0];
			telefono.value	= direc[1];
		}
		//telefono2
		if (telefono2.value !="") {
			direc			= telefono2.value.split("-");
			celcod.value	= direc[0];
			celnro.value	= direc[1];
		}
		//telefono3
		if (telefono3.value !="") {
			direc			= telefono3.value.split("-");
			codfax.value	= direc[0];
			nrofax.value	= direc[1];
		}
		if(dirr_e.value != "") {
			direc			= dirr_e.value.split(";");
			avCalleR.value	= direc[0];
			barrioR.value	= direc[1];
			casaR.value		= direc[2];
			ciudadR.value	= direc[3];
			estadoR.value	= direc[4];
		}
		if (telfr_e.value !="") {
			direc			= telfr_e.value.split("-");
			codTR.value		= direc[0];
			telefonoR.value	= direc[1];
		}
		// tipo plantel:
		if (tipo_plantel.value == "PRIVADO") {
			tipo_plantelS.selectedIndex = 2;
			costo_mensual.style.display='block'; 
			document.getElementById('montoEtq').style.color='#000000'; 
		}
		else if (tipo_plantel.value == "PUBLICO") {
			tipo_plantelS.selectedIndex = 1;
		}
		// sistema de estudio
		switch(sistema_estudio.value.substring(0,2)) {
			case "RE"	: opcion = 1; break;
			case "PA"	: opcion = 2; break;
			case "OT"	: opcion = 3; break;
			default		: opcion = 0;
		}
		sistema_estudioS.selectedIndex = opcion;
		if (opcion == 3) {
			direc = sistema_estudio.value.split(':');
			otroSistemaE.value = direc[1];
			otroSistemaE.style.display='block'; 
		}
		// turno de estudio
		switch(turno_estudio.value.substring(0,2)) {
			case "DI"	: opcion = 1; break;
			case "NO"	: opcion = 2; break;
			case "ES"	: opcion = 3; break;
			case "OT"	: opcion = 4; break;
			default		: opcion = 0;
		}
		turno_estudioS.selectedIndex = opcion;
		if (opcion == 4) {
			direc = turno_estudio.value.split(':');
			otroTurnoE.value = direc[1];
			otroTurnoE.style.display='block'; 
		}
		// titulo
		switch(titulo_b.value.substring(0,2)) {
			case "CI"	: opcion = 1; break;
			case "IN"	: opcion = 2; break;
			case "TE"	: opcion = 3; break;
			case "OT"	: opcion = 4; break;
			default		: opcion = 0;
		}
		titulo_bS.selectedIndex = opcion;
		if (opcion == 4) {
			direc = titulo_b.value.split(':');
			otroTitulo.value = direc[1];
			otroTitulo.style.display='block'; 
		}
		// promedio
		/*switch(promedio.value.substring(0,5)) {
			case "menor"	: opcion = 1; break;
			case "de 13"	: opcion = 2; break;
			case "de 16"	: opcion = 3; break;
			case "de 18"	: opcion = 4; break;
			default			: opcion = 0;
		}
		promedioS.selectedIndex = opcion;*/
		// instruccion del padre
		switch(instr_padre.value) {
			case "PRIMARIA INCOMPLETA"			: opcion = 1; break;
			case "PRIMARIA COMPLETA"			: opcion = 2; break;
			case "SECUNDARIA INCOMPLETA"		: opcion = 3; break;
			case "SECUNDARIA COMPLETA"			: opcion = 4; break;
			case "TECNICO SUP. UNIVERSITARIO"	: opcion = 5; break;
			case "UNIVERSITARIO"				: opcion = 6; break;
			default			: opcion = 0;
		}
		instr_padreS.selectedIndex = opcion;
		// ocupacion del padre
		direc = ocup_padre.value.split(':');
		switch(direc[0]) {
			case "HOGAR"						:	opcion = 1;	break;
			case "OBRERO"						:	opcion = 2;	break;
			case "COMERCIANTE INFORMAL"			:	opcion = 3;	break;
			case "COMERCIANTE FORMAL"			:	opcion = 4;	break;
			case "EMPLEADO"						:	opcion = 5;	break;
			case "TECNICO"						:	opcion = 6;	break;
			case "PROFESIONAL UNIVERISTARIO"	:	opcion = 7;	break;
			case "OTRO"							:	opcion = 8;	break;
			default								:	opcion = 0;
		}
		ocup_padreS.selectedIndex = opcion;
		if (opcion == 8) {
			otroOcupPadre.value = direc[1];
			otroOcupPadre.style.display='block'; 
		}
		// instruccion de la madre
		switch(instr_madre.value) {
			case "PRIMARIA INCOMPLETA"			: opcion = 1; break;
			case "PRIMARIA COMPLETA"			: opcion = 2; break;
			case "SECUNDARIA INCOMPLETA"		: opcion = 3; break;
			case "SECUNDARIA COMPLETA"			: opcion = 4; break;
			case "TECNICO SUP. UNIVERSITARIO"	: opcion = 5; break;
			case "UNIVERSITARIO"				: opcion = 6; break;
			default								: opcion = 0;
		}
		instr_madreS.selectedIndex = opcion;
		// ocupacion de la madre
		direc = ocup_madre.value.split(':');
		//alert(direc[0]);
		switch(direc[0]) {
			case "HOGAR"						:	opcion = 1;	break;
			case "OBRERA"						:	opcion = 2;	break;
			case "COMERCIANTE INFORMAL"			:	opcion = 3;	break;
			case "COMERCIANTE FORMAL"			:	opcion = 4;	break;
			case "EMPLEADA"						:	opcion = 5;	break;
			case "TECNICO"						:	opcion = 6;	break;
			case "PROFESIONAL UNIVERSITARIO"	:	opcion = 7;	break;
			case "OTRO"							:	opcion = 8;	break;
			default								:	opcion = 0;
		}
		ocup_madreS.selectedIndex = opcion;
		if (opcion == 8) {
			otroOcupMadre.value = direc[1];
			otroOcupMadre.style.display='block'; 
		}
		// tipo de vivienda
		switch(tipo_vivienda.value) {
			case "PROPIA"		:	opcion = 1;	break;
			case "HIPOTECADA"	:	opcion = 2;	break;
			case "ALQUILADA"	:	opcion = 3;	break;
			default				:	opcion = 0;
		}
		tipo_viviendaS.selectedIndex = opcion;
		if (opcion == 3) {
			monto_alq.style.display='block'; 
		}
		// ingreso familiar
		direc = ingreso_f.value.split(':');
		opcion = parseInt(direc[0],10);
		ingreso_fS.selectedIndex = opcion;
		
		// Mostramos la especialidad
		//alert(carrera.value);
		switch (carrera.value){ 
			case "2"	: opcion = 1; break;
			case "3"	: opcion = 2; break;
			case "4"	: opcion = 3; break;
			case "5"	: opcion = 4; break;
			case "6"	: opcion = 5; break;
			default		: opcion = 0; 
		}
		c_uni_ca.selectedIndex = opcion;
		
		// Mostramos la especialidad
		switch (carrera.value){ 
			case "INGENIERIA MECANICA"		: opcion = 1; break;
			case "INGENIERIA ELECTRICA"		: opcion = 2; break;
			case "INGENIERIA METALURGICA"	: opcion = 3; break;
			case "INGENIERIA ELECTRONICA"	: opcion = 4; break;
			case "INGENIERIA INDUSTRIAL"	: opcion = 5; break;
			//default							: opcion = 0; 
		}
		c_uni_ca.selectedIndex = opcion;
	}
}

function calcularEdad() {
	var hoy = new Date();
	with(document) {
		dia  = parseInt('0'+getElementById('diaN_S_1').selectedIndex,10);
		if (dia < 1){
			dia=1;
		}
		mes  = parseInt('0'+getElementById('mesN_S_1').value,10);
		anio = 1900 + parseInt('0'+getElementById('anioN_N_2').value,10);
	}
	var fnac= new Date(anio,mes,dia);
	var edad = new Date();
	if (fnac.getTime() < 0) {
		edad.setTime(hoy.getTime() - fnac.getTime());
		aniosEdad = edad.getYear();
		if (aniosEdad < 200) {
		aniosEdad = 1900 + aniosEdad;
		}
		aniosEdad = aniosEdad/1.0 + (edad.getMonth()+1)/12 + (edad.getDate())/365.25;
		aniosEdad = aniosEdad - 1970.0;
	}
	else {
		edad.setTime(hoy.getTime() - fnac.getTime());
		aniosEdad = edad.getYear()/1.0 + (edad.getMonth()+1)/12 + (edad.getDate())/365.25;
		if (aniosEdad < 200){
			aniosEdad = aniosEdad - 70.0;
		}
		else aniosEdad = aniosEdad - 1970.0;
	}
//	alert(aniosEdad);
	document.getElementById('edad').value = Math.floor(aniosEdad);
}

function soloBlancos (campo) {
	var i = 0;
	var c = 0;
	if(campo.value.length == 1) {
		return false;
	}
	for (i = 0; i < campo.value.length - 1; i++) {
		if (campo.value.charAt(i) != campo.value.charAt(i + 1)) {
			return false;
		}
   }
  campo.value = "";
  return true ;
 }

function validarN(campo) {

	var cadena = campo.value;
    var nums="1234567890.";
    var i=0;
    var cl=cadena.length;
    while(i < cl)  {
		cTemp= cadena.substring (i, i+1);
        if (nums.indexOf (cTemp, 0)==-1) {
            cadT = cadena.split(cTemp);
            var cadena = cadT.join("");
            campo.value=cadena;
            i=-1;
            cl=cadena.length;
		}
        i++;
    }
}

function validarL(campo) {

	var cadena = campo.value;
    var nums="ABCDEFGHIJKLMN�OPQRSTUVWXYZ�����" + "abcdefghijklmn�opqrstuvwxyz����� " + "��";
	if (campo.alt == 'Apellidos' || campo.alt == 'Nombres') {
		nums = nums + "'";
	}
    var i=0;
    var cl=cadena.length;
    while(i < cl)  {
		cTemp= cadena.substring (i, i+1);
        if (nums.indexOf (cTemp, 0)==-1) {
            cadT = cadena.split(cTemp);
            var cadena = cadT.join("");
            campo.value=cadena;
            i=-1;
            cl=cadena.length;
		}
        i++;
    }
	campo.value = campo.value.toUpperCase();
}

function validarA(campo) {

	var cadena = campo.value;
	var nums ="ABCDEFGHIJKLMN�OPQRSTUVWXYZ�����" + "abcdefghijklmn�opqrstuvwxyz����� " + "��" + "0123456789" + ".-()#��/,";
    var i=0;
    var cl=cadena.length;
    while(i < cl)  {
		cTemp= cadena.substring (i, i+1);
        if (nums.indexOf (cTemp, 0)==-1) {
            cadT = cadena.split(cTemp);
            var cadena = cadT.join("");
            campo.value=cadena;
            i=-1;
            cl=cadena.length;
		}
        i++;
    }
	campo.value = campo.value.toUpperCase();
}


function validarLetras(campo, longitud, nValido, conMsg) {
	
	var valido = "ABCDEFGHIJKLMN�OPQRSTUVWXYZ�����" + "abcdefghijklmn�opqrstuvwxyz����� " + "��";
	if (nValido.length>0) {
		valido = nValido;
	}
	if (campo.alt == 'Apellidos' || campo.alt == 'Nombres') {
		valido = valido + "'";
	}
	var invalido = false;
	var temp;
	var msg ="";
	for (var i=0; i<campo.value.length; i++) {
		temp = "" + campo.value.substring(i, i+1);
		if (valido.indexOf(temp) == "-1") {
			invalido = true;
			msg = "- No se permite el caracter \""+temp+"\" en este campo.\n";
			break;
		}
	}
	var longInvalida = (campo.value.length < longitud);
	if (longInvalida || soloBlancos(campo) && (longitud > 0)) {
		msg = msg+"- No ha escrito un valor correcto para este campo.\n";
		invalido = true;
	}
	if (invalido) {
		msg = "Han ocurrido los siguientes errores:\n" + msg;
		if(conMsg){
			msg = msg + "Por favor corrija el campo " + campo.alt.toUpperCase();
			alert(msg);
		}
		campo.style.backgroundColor = "#FFFF99";
	}
	else {
		campo.style.backgroundColor = "#FFFFFF";
	}

	return !invalido;
}

function validarAlfaN(campo,longitud, conMsg) {

	var alfaC ="ABCDEFGHIJKLMN�OPQRSTUVWXYZ�����" + "abcdefghijklmn�opqrstuvwxyz����� " + "��" + "0123456789" + ".-()#��/,";

	return validarLetras(campo,longitud, alfaC, conMsg);
}

function validarNum(campo, longitud, conMsg) {

	var cadena = campo.value;
    var nums="1234567890";
    var i=0;
    var cl=cadena.length;
    var checkc = false;
	var msg ="";
    while(i < cl)  {
		cTemp= cadena.substring (i, i+1);
        if (nums.indexOf (cTemp, 0)==-1) {
			if (!checkc){
				msg =" - Ha introducido caracteres no num�ricos y se eliminar�n\n";
                checkc = true;
            }
            cadT = cadena.split(cTemp);
            var cadena = cadT.join("");
            campo.value=cadena;
            i=-1;
            cl=cadena.length;
		}
        i++;
    }
	var longInvalida = (campo.value.length < longitud);
	if (longInvalida) {
		msg = msg+"- No ha escrito un valor correcto para este campo.\n";
		invalido = true;
	}
	if (checkc || longInvalida) {
		msg = "Han ocurrido los siguientes errores:\n" + msg;
		if(conMsg){
			msg = msg + "Por favor corrija el campo " + campo.alt.toUpperCase();
			alert(msg);
		}
		campo.style.backgroundColor = "#FFFF99";
	}
	else {
		campo.style.backgroundColor = "#FFFFFF";
	}
	return !(checkc || longInvalida);
}

function validarSelect(campo, conMsg) {
	if (campo.selectedIndex == 0) {
		campo.style.backgroundColor = "#FFFF99";
		if(conMsg) alert('Por favor, seleccione un valor de la lista');
		return false;
	}
	else {
		campo.style.backgroundColor = "#FFFFFF";
	}
	return true;
}

function validar(campo){
	with (campo){
		tempID = id.split('_');
		switch (tempID[1]) {
			case 'L' :	return validarLetras(campo,tempID[2],'',true);
						break;
			case 'A' :	return validarAlfaN(campo,tempID[2],true);
						break;
			case 'N' :	return validarNum(campo,tempID[2],true);
						break;
			case 'S' :	return validarSelect(campo,true);
						break;
		}
	}
}

function anyoBisiesto(anyo){
	var fin = anyo;
	if (fin % 4 != 0)
    return false;
    else {
		if (fin % 100 == 0) {
			if (fin % 400 == 0){
				return true;
			}
			else {
				return false;
			}
		}
		else {
		   return true;
		}
	}
}

function fechaValida(dia,mes,anyo, conMsg){
  var anyohoy = new Date();
  var Mensaje = "";
  var yearhoy = anyohoy.getYear();
  if (yearhoy < 1999)
    yearhoy = yearhoy + 1900;
  if(anyoBisiesto(anyo))
    febrero = 29;
  else
      febrero = 28;
  if ((mes == 2) && (dia > febrero) || (dia == 0)){
		Mensaje += "- D�a de nacimiento inv�lido\r\n";
  }
  if (((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)) && (dia > 30)){
		Mensaje += "- D�a de nacimiento inv�lido\r\n";
  }
  if (mes == 0){
		Mensaje += "- Mes de nacimiento inv�lido\r\n";
  }
  if ((anyo<1950) || (yearhoy - anyo < 15)){
		Mensaje += "- A�o de nacimiento inv�lido\r\n";
  } 
  if (Mensaje != "") {
	   alert(Mensaje);
	   return false;
  }
  else {
	  return true;
  }
}


function mostrar_ayuda(ayudaURL) {
		window.open(ayudaURL,"instruciones","left=0,top=0,width=700,height=250,scrollbars=0,resizable=0,status=0");
}

function verificarFecha(f, conMsg){
	with(f){
		var dia = parseInt (diaN.selectedIndex);
		var mes = parseInt (mesN.selectedIndex);
		var anyo = parseInt ('0'+anioN.value,10) + 1900;

		if (!fechaValida(dia,mes,anyo, conMsg)) {
			diaN.style.backgroundColor = "#FFFF99";
			mesN.style.backgroundColor = "#FFFF99";
			anioN.style.backgroundColor = "#FFFF99";
			return false;
		}
		else {
			diaN.style.backgroundColor = "#FFFFFF";
			mesN.style.backgroundColor = "#FFFFFF";
			anioN.style.backgroundColor = "#FFFFFF";
			return true;
		}
	}
}

function validarF(f){

	var hayError = false;
	totalE = 0;
	with (f){
		for (i =0;i<elements.length ;i++ ){
			temp = elements[i].id.split('_');
			if (temp.length == 3 && elements[i].style.display !='none') {
				switch (temp[1]) {
					case 'L' :	hayError = !validarLetras(elements[i],temp[2],'',false);
								break;
					case 'A' :	hayError = !validarAlfaN(elements[i],temp[2],false);
								break;
					case 'N' :	hayError = !validarNum(elements[i],temp[2],false);
								break;
					case 'S' :  hayError = !validarSelect(elements[i],false);
								break;
				}
				if(hayError){
					totalE++;
				}
			}
		}
	}
	if (!verificarFecha(f,false)) totalE++;
	if(totalE>0){
		document.getElementById('msgError').style.display='block';
		alert('Verifique: \nExisten errores en los campos marcados en amarillo.');
		document.getElementById('Procesar').style.display='block';
		//return false;
	}
	else {
		prepdata();
		if (f.apellidos.value.indexOf(f.contra.value) >= 0) {
			f.submit();
			return true;
		}
		else {
			alert('Disculpe, El apellido introducido no esta registrado.\n Por favor corrija e intente de nuevo.');
			f.apellidos.style.backgroundColor='#FFFF99';
			f.apellidos.focus();
			document.getElementById('Procesar').style.display='block';
			return false;
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////
//////////////////PAIS, ESTADO, CIUDAD, MUNICIPIO DE UBICACION DEL PLANTEL///////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
			function mostrar_ciudades(ciudad,edoPlantel,paisPlantel)
			{
				//alert(ciudad);
				
				fajax('estados_ciudadesPlantel.php','capa','ciudad='+ciudad+'&estado='+edoPlantel+'&pais='+paisPlantel,'post','0');
			}
			
			function AJAXCrearObjeto(){
			 var obj; 
			 
			 if(window.XMLHttpRequest) 
				{ // no es IE 
				obj = new XMLHttpRequest(); 
				} 
				else 
				{ // Es IE o no tiene el objeto 
					try { 
						 obj = new ActiveXObject("Microsoft.XMLHTTP"); 
						} 
					catch (e) { 
								alert('El navegador utilizado no est soportado'); 
							  } 
				} 
			 //alert ("objeto creado");
			 return obj; 
			} 
			
			function fajax(url,capa,valores,metodo,xml) //xml=1 (SI) xml=0 (NO)
			{
				//alert(capa);
				var ajax=AJAXCrearObjeto();
				var capaContenedora=document.getElementById(capa);
				//alert('capa '+capaContenedora);
				if (capaContenedora.type == "text"){
					texto = true;
				}else{
					texto = false;
				}
				//texto = true;
				var contXML;
				/* Creamos y ejecutamos la instancia si el metodo elegido es POST */
				if (metodo.toUpperCase()=='POST')
				{
			
					ajax.open ('POST', url, true);
					ajax.onreadystatechange = function() 
					{
						if (ajax.readyState==1) 
						{
							capaContenedora.innerHTML="<img src='loader.gif'>";
						}
						else if (ajax.readyState==4)
						{
							if (ajax.status==200)
							{
								if (xml==0)
								{	
									if (texto){
										document.getElementById(capa).value=ajax.responseText;
									}
									document.getElementById(capa).innerHTML=ajax.responseText;
								}
								if (xml==1)
								{
			
									var Contxml  = ajax.responseXML.documentElement;
									var items = Contxml.getElementsByTagName('nota')[0];
									var txt = items.getElementsByTagName('destinatario')[0].firstChild.data; 
									document.getElementById(capa).innerHTML=txt;
									
									
								}
							}
							else if (ajax.readyState=404)
							{
								capaContenedora.innerHTML = "La direccion no existe";
							}
							else
							{
								capaContenedora.innerHTML="Error: "+ajax.status;
							}
						}
					}
				
					ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					ajax.send(valores);
					return;
				}
				/* Creamos y ejecutamos la instancia si el metodo elegido es GET */
				if (metodo.toUpperCase()=='GET')
				{
					ajax.open ('GET', url, true);
					ajax.onreadystatechange = function() 
					{
						if (ajax.readyState==1) 
						{
							capaContenedora.innerHTML="<img src='loading.gif'>";
						}
						else if (ajax.readyState==4)
						{
							if (ajax.status==200)
							{
								if (xml==0)
								{
									document.getElementById(capa).innerHTML=ajax.responseText;
								}
								if (xml==1)
								{
									alert(ajax.responseXML.getElementsByTagName("nota")[0].childNodes[1].nodeValue); 
								}
							}
							else if (ajax.readyState=404)
							{
								capaContenedora.innerHTML = "La direccion no existe";
							}
							else
							{
								capaContenedora.innerHTML="Error: "+ajax.status;
							}
						}
					}
				
					ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					ajax.send(null);
					return;
				}
	}//fin function fajax(url,capa,valores,metodo,xml)

	function mostrar_municipios(municipio,estado,pais)
	{
		//alert(pais);
		fajax('estados_municipios.php','capa2','municipio='+municipio+'&estado='+estado+'&pais='+pais,'post','0');
	}
	
	function AJAXCrearObjeto(){
	 var obj; 
	 
	 if(window.XMLHttpRequest) 
		{ // no es IE 
		obj = new XMLHttpRequest(); 
		} 
		else 
		{ // Es IE o no tiene el objeto 
			try { 
				 obj = new ActiveXObject("Microsoft.XMLHTTP"); 
				} 
			catch (e) { 
						alert('El navegador utilizado no est soportado'); 
					  } 
		} 
	 //alert ("objeto creado");
	 return obj; 
	} 
	
	function fajax(url,capa2,valores,metodo,xml) //xml=1 (SI) xml=0 (NO)
	{
		//alert(capa2);
		var ajax=AJAXCrearObjeto();
		var capaContenedora=document.getElementById(capa2);
		//alert('capa2 '+capaContenedora);
		if (capaContenedora.type == "text"){
			texto = true;
		}else{
			texto = false;
		}
		//texto = true;
		var contXML;
		/* Creamos y ejecutamos la instancia si el metodo elegido es POST */
		if (metodo.toUpperCase()=='POST')
		{
	
			ajax.open ('POST', url, true);
			ajax.onreadystatechange = function() 
			{
				if (ajax.readyState==1) 
				{
					capaContenedora.innerHTML="<img src='loader.gif'>";
				}
				else if (ajax.readyState==4)
				{
					if (ajax.status==200)
					{
						if (xml==0)
						{	
							if (texto){
								document.getElementById(capa2).value=ajax.responseText;
							}
							document.getElementById(capa2).innerHTML=ajax.responseText;
						}
						if (xml==1)
						{
	
							var Contxml  = ajax.responseXML.documentElement;
							var items = Contxml.getElementsByTagName('nota')[0];
							var txt = items.getElementsByTagName('destinatario')[0].firstChild.data; 
							document.getElementById(capa2).innerHTML=txt;
							
							
						}
					}
					else if (ajax.readyState=404)
					{
						capaContenedora.innerHTML = "La direccion no existe";
					}
					else
					{
						capaContenedora.innerHTML="Error: "+ajax.status;
					}
				}
			}
		
			ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			ajax.send(valores);
			return;
		}
		/* Creamos y ejecutamos la instancia si el metodo elegido es GET */
		if (metodo.toUpperCase()=='GET')
		{
			ajax.open ('GET', url, true);
			ajax.onreadystatechange = function() 
			{
				if (ajax.readyState==1) 
				{
					capaContenedora.innerHTML="<img src='loading.gif'>";
				}
				else if (ajax.readyState==4)
				{
					if (ajax.status==200)
					{
						if (xml==0)
						{
							document.getElementById(capa2).innerHTML=ajax.responseText;
						}
						if (xml==1)
						{
							alert(ajax.responseXML.getElementsByTagName("nota")[0].childNodes[1].nodeValue); 
						}
					}
					else if (ajax.readyState=404)
					{
						capaContenedora.innerHTML = "La direccion no existe";
					}
					else
					{
						capaContenedora.innerHTML="Error: "+ajax.status;
					}
				}
			}
		
			ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			ajax.send(null);
			return;
		}
	}//FIN DEL SCRIPT--><!--SCRIPT QUE GENERAR EL LISTADO DE LOS MUNICIPIOS CORRESPONDIENTE AL ESTADO SELECCIONADO-->	


		//PARA EL PAIS, ESTADO Y CIUDAD DE NACIMIENTO-->
			function mostrar_ciudadesNac(ciudad,edoPlantel,paisPlantel)
			{
				//alert(ciudad);
				fajax('estados_ciudades.php','capaN','ciudad='+ciudad+'&estado='+edoPlantel+'&pais='+paisPlantel,'post','0');
			}
			
			function AJAXCrearObjeto(){
			 var obj; 
			 
			 if(window.XMLHttpRequest) 
				{ // no es IE 
				obj = new XMLHttpRequest(); 
				} 
				else 
				{ // Es IE o no tiene el objeto 
					try { 
						 obj = new ActiveXObject("Microsoft.XMLHTTP"); 
						} 
					catch (e) { 
								alert('El navegador utilizado no est soportado'); 
							  } 
				} 
			 //alert ("objeto creado");
			 return obj; 
			} 
			
			function fajax(url,capaN,valores,metodo,xml) //xml=1 (SI) xml=0 (NO)
			{
				//alert(capa);
				var ajax=AJAXCrearObjeto();
				var capaContenedora=document.getElementById(capaN);
				//alert('capa '+capaContenedora);
				if (capaContenedora.type == "text"){
					texto = true;
				}else{
					texto = false;
				}
				//texto = true;
				var contXML;
				/* Creamos y ejecutamos la instancia si el metodo elegido es POST */
				if (metodo.toUpperCase()=='POST')
				{
			
					ajax.open ('POST', url, true);
					ajax.onreadystatechange = function() 
					{
						if (ajax.readyState==1) 
						{
							capaContenedora.innerHTML="<img src='loader.gif'>";
						}
						else if (ajax.readyState==4)
						{
							if (ajax.status==200)
							{
								if (xml==0)
								{	
									if (texto){
										document.getElementById(capaN).value=ajax.responseText;
									}
									document.getElementById(capaN).innerHTML=ajax.responseText;
								}
								if (xml==1)
								{
			
									var Contxml  = ajax.responseXML.documentElement;
									var items = Contxml.getElementsByTagName('nota')[0];
									var txt = items.getElementsByTagName('destinatario')[0].firstChild.data; 
									document.getElementById(capaN).innerHTML=txt;
									
									
								}
							}
							else if (ajax.readyState=404)
							{
								capaContenedora.innerHTML = "La direccion no existe";
							}
							else
							{
								capaContenedora.innerHTML="Error: "+ajax.status;
							}
						}
					}
				
					ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					ajax.send(valores);
					return;
				}
				/* Creamos y ejecutamos la instancia si el metodo elegido es GET */
				if (metodo.toUpperCase()=='GET')
				{
					ajax.open ('GET', url, true);
					ajax.onreadystatechange = function() 
					{
						if (ajax.readyState==1) 
						{
							capaContenedora.innerHTML="<img src='loading.gif'>";
						}
						else if (ajax.readyState==4)
						{
							if (ajax.status==200)
							{
								if (xml==0)
								{
									document.getElementById(capaN).innerHTML=ajax.responseText;
								}
								if (xml==1)
								{
									alert(ajax.responseXML.getElementsByTagName("nota")[0].childNodes[1].nodeValue); 
								}
							}
							else if (ajax.readyState=404)
							{
								capaContenedora.innerHTML = "La direccion no existe";
							}
							else
							{
								capaContenedora.innerHTML="Error: "+ajax.status;
							}
						}
					}
				
					ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					ajax.send(null);
					return;
				}
	}//fin function mostrar_ciudadesNac(ciudad,edoPlantel,paisPlantel)
	
	function conf_inicial_DACE(){
		with(document.datos_p) {
			//alert(ent_fed.value);
			if (codigo_p.value != '' && ent_fed.value != ''){//SI VIENEN CON VALORES
				var cdNac = l_nac_e.value;//CIUDAD DE NACIMIENTO
				var estadoNac = ent_fed.value;//ESTADO DE NACIMIENTO
				var paisNac = p_nac_e.value;//PAIS DE NACIMIENTO
				var cdPlantel = codigo_c.value;//CIUDAD DEL PLANTEL
				var estadoPlantel = codigo_e.value;//ESTADO DEL PLANTEL
				var paisPlantel = codigo_p.value;//PAIS DEL PLANTEL
				var mpioPlantel = codigo_m.value;//MPIO DEL PLANTEL

			//Llamar los asincrono y enviarle los valores de 
			//pais, estado, la ciudad y el municipio respectivamente
			mostrar_ciudadesNac(cdNac, estadoNac, paisNac);
			mostrar_ciudades(cdPlantel, estadoPlantel, paisPlantel);
			mostrar_municipios(mpioPlantel, estadoPlantel, paisPlantel);
			}
		}
	}//FIN function conf_inicial_DACE()
	
		//PARA EL PAIS, ESTADO Y CIUDAD DE NACIMIENTO-->
		//PARA OCULTAR DEPENDIENDO DEL PAIS SELECCIONADO-->
		function paisnacimiento1() //CUANDO CAMBIA EL SELECT DE LOS PAISES DE NACIMIENTO
		{
			var paisN = document.getElementById("pnac_S_1").value;//EL id SELECT
			
			if (paisN == 232){//VENEZUELA
				//alert(paisN);
				document.getElementById("span_edo_Ext").style.display = "none";
				document.getElementById("span_cd_Ext").style.display = "none";
				document.getElementById("span_edo_nac").style.display = "block";
				document.getElementById("entfed_S_1").value = "";//EDO DE NACIMIENTO
				document.getElementById("span_ciudad_nac").style.display = "block";
			}
			else{
				document.getElementById("span_edo_Ext").style.display = "block";
				document.getElementById("span_cd_Ext").style.display = "block";
				document.getElementById("span_edo_nac").style.display = "none";
				document.getElementById("span_ciudad_nac").style.display = "none";				
			}
			
		}//FIN function paisnacimiento1()
		
		function paisnacimiento() //Pais del Liceo
		{
			var pais = document.getElementById("codigop_S_1").value;
			
			//alert(pais);
			if (pais == 232){//VENEZUELA
				document.getElementById("span_otroPaisEdoLiceo").style.display = "none";
				document.getElementById("span_otroPaisCdLiceo").style.display = "none";
				document.getElementById("span_otroPaisMLiceo").style.display = "none";
				document.getElementById("span_edo_liceo").style.display = "block";
				document.getElementById("span_ciudad_liceo").style.display = "block";
				document.getElementById("span_municipio_plantel").style.display = "block";
				
			}
			else{
				document.getElementById("span_otroPaisEdoLiceo").style.display = "block";
				document.getElementById("span_otroPaisCdLiceo").style.display = "block";
				document.getElementById("span_otroPaisMLiceo").style.display = "block";
				document.getElementById("span_edo_liceo").style.display = "none";
				document.getElementById("span_ciudad_liceo").style.display = "none";
				document.getElementById("span_municipio_plantel").style.display = "none";
			}
			
		}//FIN function paisnacimiento()