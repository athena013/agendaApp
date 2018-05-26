<html>
<style type="text/css">
.fuente {
	font-size: 10pt;
}
.datos {
	text-align: left;
        font-size: 10pt;
}
</style>
<!--  <head>
      <link rel="stylesheet" type="text/css" href="./assets/css/dompdf.css">
  </head>-->

<body>
<header>
    <link rel="stylesheet" type="text/css" href="./css/dompdf.css">
      <table border="1" WIDTH="100%">
          <tr>
			<td width="20%">
				<img id="logo" src="./application/views/escudo.png"> 
			</td>
			<td width="55%">
				<table border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" align="center" >
					<tr >
						<td align="center"> 
						SECRETARÍA DISTRITAL DE LA MUJER
						</td>
					</tr>
					<tr>
                                            <td align="center">GESTIÓN DE TALENTO HUMANO</td>
					</tr>
					<tr>
                      <td align="center">NOVEDAD PARA INCLUIR NÓMINA</td>
					</tr>
				</table>
			</td>
			<td width="25%">
			<table border="1"swidth="100%" cellpadding="0" cellspacing="0" bordercolor="#000000" >
				<tr>
                                    <th class="fuente">
					Código: GTH-F0-38
					</th>
				</tr>
				<tr>
					<th class="fuente">
					Versión:03
					</th>
				</tr>
				<tr>
					<th class="fuente">
					Fecha de Emisión:17 Marzo de 2017
					</th>
				</tr>
				<tr>
					<th class="fuente"> Página: 1 de 1 </th>
				</tr>
			</table>
			</td>	
		  </tr>
		 
      </table>
  </header>
    <br>
<table WIDTH="100%" border="1">
  <tr>
        <th width="10%">FECHA</th>
        <td width="30%">&nbsp;<?php echo $FEC_FORM?></td>
        <th width="10%">CÉDULA</th>
        <td width="30%">&nbsp;<?php echo $ID_USUARIOS ?></td>  
  </tr>
  <tr>  <th >SOLICITANTE</th>
        <td >&nbsp;<?php echo $PRIMER_NOMBRE ." ". $PRIMER_APELLIDO?></td>
        <th>CARGO</th> 
        <td>&nbsp;<?php echo $CARGO." ".$CARGO_ESPEC ?></td>
        
  </tr>
  <tr>
        <th>DEPENDENCIA</th>
        <td>&nbsp;<?php echo $DEPENDENCIA ?></td>  
        <th>TELÉFONO</th> 
        <td>&nbsp;<?php echo $TELEFONO?></td>
  </tr>
  <tr>
        <th>FIRMA</th>
        <td colspan="3"></td>
  </tr>
  </table>
    <BR>
    1. SOLICITUD DE PERMISO O AUSENCIA DE SERVIDORAS (ES) PÚBLICAS (OS)
  TIEMPO DEL PERMISO O AUSENCIA (MARQUE X)
  <table border="1" WIDTH="100%">
   <tr>
		<th width="20%">HORAS</th> 
		<td width="10%">&nbsp;<?php echo $HORAS?></td> 
		<th>HORA DE INICIO</th> 
                <td align="center">&nbsp;<?php echo $HORAS_VALOR ?></td>
  </tr>
    <tr>
		<th>DIAS</th>
		<td>&nbsp;<?php echo $DIAS?></td>
		<th>FECHA DESDE</th> 
		<td>&nbsp;<?php echo $INI?></td> 
		<th>FECHA HASTA</th> 
		<td>&nbsp;<?php echo $FIN?></td>
     </tr>
     <tr>
         <th colspan="2">MOTIVOS DEL PERMISO O AUSENCIA</th>
		
     </tr>
     <tr>
        <td colspan="6">&nbsp;<?php echo $MOTIVO."   ".$OTRO_MOTIVO?></td>
		
     </tr>
     <br>
</table>
    <u>2. TRASLADO EN SEGURIDAD SOCIAL Y CESANTÍAS</u>
<table border="1" WIDTH="100%">
    <tr>
		<th width="30%">TRASLADO</th>
                <th width="28%">DE</th>
		<th width="28%">A</th>
		<th width="22%">FECHA DE AFILIACIÓN</th>
   </tr>
    <tr>
		<th>FONDOS DE PENSIONES</th>
                <td>&nbsp;<?php echo $PEN_ORIGEN ?></td>
		<td>&nbsp;<?php echo $PEN_DESTINO ?></td>
		<td>&nbsp;<?php echo $FEC_AFL_PEN ?></td>
   </tr>
   <tr>
		<th>EPS</th>
                <td>&nbsp;<?php echo $EPS_ORIGEN ?></td>
		<td>&nbsp;<?php echo $EPS_DESTINO ?></td>
		<td>&nbsp;<?php echo $FEC_AFL_EPS ?></td>
   </tr>
   <tr>
		<th>FONDO DE CESANTIAS</th>
		<td>&nbsp;<?php echo $CES_ORIGEN ?></td>
		<td>&nbsp;<?php echo $CES_DESTINO ?></td>
		<td>&nbsp;<?php echo $FEC_AFL_CES ?></td>
   </tr>
</table>
    <br>
    3. VACACIONES
    <table border="1" WIDTH="100%">
	<tr>
            <th width="16%">Reprogramación</th> 
            <th width="16%">&nbsp;<?php echo $REPROGRAMACION?> </th>
            <th width="16%">Aplazamiento</th> 
            <th width="16%">&nbsp;<?php echo $APLAZAMIENTO?> </th>
            <th width="16%">Interrupción</th> 
            <th width="16%">&nbsp;<?php echo $INTERRUPCION?> </th>
	</tr>
    </table>
    <br>
<table WIDTH="100%" border="1">
	<tr>
            <th width="15%">Resolución de Aplazamiento o Interrupción Nº</th>
            <th width="15%">Fecha de la Resolución</th>
            <th width="10%">Días a Disfrutar</th>
            <th width="10%">Días Pendientes</th>
            <th COLSPAN="2" width="50%">Fecha de Disfrute</th>
	</tr>
	<tr>
            <td>&nbsp;<?php echo $NUM_RESOLUCION?></td>
            <td>&nbsp;<?php echo $FEC_RESOLUCION?></td>
            <td>&nbsp;<?php echo $DIAS_DISFRUTE?></td>
            <td>&nbsp;<?php echo $DIAS_PEND?></td>
            <td>Desde: &nbsp;<?php echo $V_INI?></td>
            <td>Hasta: &nbsp;<?php echo $V_FIN?></td>
	</tr>
</table>
<br>
4. PRIMA TÉCNICA 
    <table border="1" WIDTH="100%">
    <tr>
        <th COLSPAN="4" >Tipo de Solicitud</th> 
        <th COLSPAN="4">Motivo de Reajuste</th>
    </tr>
<tr>
    <th width="23%" >RECONOCIMIENTO</th>
    <th width="6%"> &nbsp;<?php echo $RECONOCIMIENTO?> </th>
    <th width="20%" >REAJUASTE</th>
    <th width="6%">&nbsp;<?php echo $REAJUSTE?> </th>
    <th width="14%" >ESTUDIOS</th> 
    <th width="8%">&nbsp;<?php echo $ESTUDIOS?> </th>
    <th width="17%" >EXPERIENICA</th> 
    <th width="6%">&nbsp;<?php echo $EXPERIENCIA?> </th>
</tr>
</table>
<br>
5. LICENCIA NO RENUMERADA O POR LUTO
<table border="1" WIDTH="100%">
    <tr>
        <th COLSPAN="2" >Fecha de Licencia</th> 
        <th COLSPAN="2" >Motivo de Licencia</th> 
    </tr>
    <tr>
        <td>Desde: &nbsp;<?php echo $L_INI?></td>
        <td>Hasta: &nbsp;<?php echo $L_FIN?></td>
        <td COLSPAN="2" >&nbsp;<?php echo $L_MOTIVO?></td> 
    </tr>
</table>
<br>
<table border="1" WIDTH="100%">
    <tr>
            <th COLSPAN="2">VoBo JEFA (E) INMEDIATA</th>
        <th COLSPAN="2">AUTORIZA: DIRECCIÓN DE TALENTO HUMANO</th>
    </tr>
    <tr>
        <th width="13%">Firma</th>
        <th width="38%">&nbsp;</th>
        <th width="12%">Firma</th>
        <th width="37%">&nbsp;</th>
    </tr>
    <tr> 
        <th>Nombre&nbsp;</th>
        <th></th>
        <th>Nombre&nbsp;</th>
        <th></th>
    </tr>
    <tr>
        <th>Fecha&nbsp;</th>
        <th></th>
        <th>Fecha&nbsp;</th>
        <th></th>
    </tr>
</table>
<br>
En caso de ausencia de la Servidora Pública de Libre Nombramiento y Remoción se solicite encargo a:

<table border="1" WIDTH="50%">
    <tr>
        <td width="50%">Nombre:</td>
        <td width="50%">&nbsp;</td>
    </tr>
    <tr>
        <td>Cargo:</td>
        <td width="50%">&nbsp;</td>
        
    </tr>
</table>
<br>
ANEXOS QUE SE APORTAN (ORIGINAL O FOTOCOPIA)
<table border="1" WIDTH="100%">
    <tr>
        <td width="50%">&nbsp;<?php echo $NOMB_DOC?></td>
    </tr>
</table>
</body>
</html>
