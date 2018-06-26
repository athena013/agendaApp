<?php

//Fachada formulario Solicitud de permisos logica del negocio
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . "libraries\PHPExcel\IOFactory.php";

class AdminPermFachada extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->model("/solicitud/UsuarioModel");
        $this->load->model("/solicitud/PermisoTblModel");
    }

    //llamado al modelo para obtener datos de usuario, se envia el numero de docuemento
    public function consultarUsuarioId($numDoc, $nomUsu) {
        log_message('info', 'consultarUsuarioId', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $resultado = $this->UsuarioModel->getUsuarioById($numDoc, $nomUsu);


//            $objDocsPendiente= $ $this->UsuarioModel->obtenerDocsPendientes($numDoc);
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarUsuarioId' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $resultado;
    }

    //llamado al modelo para obtener ciom
    public function consultarCiom() {
        log_message('info', 'consultarCiom', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $resultado = $this->UsuarioModel->getCiom();
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarCargoCiom' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $resultado;
    }

       //obtener solicitudes por filtros
    public function getSolicitudesbyFilter($buscar) {
        log_message('info', 'getSolicitudesbyUsuario', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
//            var_dump("llegoa fachada");
//            var_dump($buscar);
//            
            $autorizador = $this->UsuarioModel->getAutorizadorById($buscar["idAutorizador"]);

            if ($autorizador) {

                if ($autorizador["ID_AUT"] == "0") {
                    //filtrar por el usuario autorizador logueado
                    $buscar["AUT0"] = $autorizador["ID_AUT"];
                }
                if ($autorizador["ID_AUT"] == "1") {
                    $buscar["AUT1"] = $autorizador["ID_AUT"];
                }
                if ($autorizador["ID_AUT"] == "2") {
                    $buscar["AUT2"] = $autorizador["ID_AUT"];
                }
            }
            
            $resultado = $this->PermisoTblModel->getSolicitudesbyFilter($buscar);
            
//            $resultado["autorizador"]=$autorizador["ID_AUT"];
            
//            var_dump($resultado);
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error getSolicitudesbyUsuario' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'getSolicitudesbyUsuario list', false);
        return $resultado;
    }

    //llamado al modelo para obtener los motivo de permiso
    public function aprobarSolicitud($formulario) {
        log_message('info', 'consultarCargoCiom', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            
            $date = getdate();
            $fecha =  $date["mday"]."/".$date["month"]."/".$date["year"];
            
            $autorizador = $this->UsuarioModel->getAutorizadorById($formulario["usuarioAprueba"]);

            if ($autorizador) {
                
                if ($autorizador["ID_AUT"] == "0") {
                    //filtrar por el usuario autorizador logueado
                    $formulario["AUT0"] = 1;
                    $formulario["ID_AUT_0"] = $formulario["usuarioAprueba"];
                    $formulario["FEC_AUT_0"] = $fecha;
                }
                if ($autorizador["ID_AUT"] == "1") {
                    $formulario["AUT1"] = 1;
                    $formulario["ID_AUT_1"] = $formulario["usuarioAprueba"];
                    $formulario["FEC_AUT_1"] = $fecha;
                }
                
                if ($autorizador["ID_AUT"] == "2") {
                    $formulario["AUT2"] = 1;
                    $formulario["ID_AUT_2"] = $formulario["usuarioAprueba"];
                    $formulario["FEC_AUT_2"] = $fecha;
                }
                $resultado = $this->PermisoTblModel->updateFormulario($formulario,$formulario["idForm"]);
            }
            
            if($resultado){
                $mensaje="Solicitud Aprobada";
            } else {
                $mensaje=$resultado;
            }
            
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarCargoCiom' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $mensaje;
    }
    
    //llamado al modelo para obtener los motivo de permiso
    public function desaprobarSolicitud($formulario) {
        log_message('info', 'consultarCargoCiom', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            
            $date = getdate();
            $fecha =  $date["mday"]."/".$date["month"]."/".$date["year"];
            
            $autorizador = $this->UsuarioModel->getAutorizadorById($formulario["usuarioAprueba"]);
             
            if ($autorizador) {

                if ($autorizador["ID_AUT"] == "0") {
                    //filtrar por el usuario autorizador logueado
                    $formulario["AUT0"] = 2;
                    $formulario["ID_AUT_0"] = $formulario["usuarioAprueba"];
                    $formulario["FEC_AUT_0"] = $fecha;
                }
                if ($autorizador["ID_AUT"] == "1") {
                    $formulario["AUT1"] = 2;
                    $formulario["ID_AUT_1"] = $formulario["usuarioAprueba"];
                    $formulario["FEC_AUT_1"] = $fecha;
                }
                if ($autorizador["ID_AUT"] == "2") {
                    $formulario["AUT2"] = 2;
                    $formulario["ID_AUT_2"] = $formulario["usuarioAprueba"];
                    $formulario["FEC_AUT_2"] = $fecha;
                }
                $resultado = $this->PermisoTblModel->updateFormulario($formulario,$formulario["idForm"]);
            }
            
            if($resultado){
                $mensaje="Solicitud Desaprobada";
            } else {
                $mensaje=$resultado;
            }
                
            
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarCargoCiom' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $mensaje;
    }
    
    //obtener motivos formulario
    public function getMotivos($cat) {
        log_message('info', 'consultarCargoCiom', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            
            $resultado = $this->UsuarioModel->getMotivo($cat);
        
            
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarCargoCiom' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $resultado;
    }

    public function actualizarFuncionaria($funcionaria) {
        log_message('info', 'actualizarFuncionaria', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $resultado = $this->UsuarioModel->updateFuncionaria($funcionaria);
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error actualizarFuncionaria' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'actualizarFuncionaria list', false);
        return $resultado;
    }

    
    public function consultarFuncionariaId($id) {

        log_message('info', 'consultarFuncionariaId', false);
        $funcionaria = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $funcionaria = $this->UsuarioModel->consultarFuncionariaId($id);
            if($funcionaria["SEGUNDO_NOMBRE"]== null){
                $funcionaria["SEGUNDO_NOMBRE"]=" ";
            }
            if($funcionaria["SEGUNDO_APELLIDO"]== null){
                $funcionaria["SEGUNDO_APELLIDO"]=" ";
            }
                
            
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarFuncionariaId' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarFuncionariaId list', false);
        return $funcionaria;
    }
    
    public function obtenerIdAministracion($id) {

        log_message('info', 'consultarFuncionariaId', false);
        $autorizador = NULL;
        $respuesta = NULL;
        try {
            $this->db->trans_off();
            
            $autorizador = $this->UsuarioModel->getAutorizadorById($id);
            
            $respuesta=$autorizador["ID_AUT"];
            
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarFuncionariaId' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarFuncionariaId list', false);
        return $respuesta;
    }
    
     public function generarReporteSolicitudes($buscar){
       	log_message('info', 'NovedadFachada - GenerarReporteNovedadIes. Parametros de entrada: ');
        $resultado = NULL;
        $respuesta = NULL;
		
            date_default_timezone_set('America/Bogota');
//                var_dump($filtro);
            $this->db->trans_off();
//            var_dump("llegoa fachada");
//            var_dump($buscar);
//            
            $autorizador = $this->UsuarioModel->getAutorizadorById($buscar["idAutorizador"]);

            if ($autorizador) {

                if ($autorizador["ID_AUT"] == "0") {
                    //filtrar por el usuario autorizador logueado
                    $buscar["AUT0"] = $autorizador["ID_AUT"];
                }
                if ($autorizador["ID_AUT"] == "1") {
                    $buscar["AUT1"] = $autorizador["ID_AUT"];
                }
                if ($autorizador["ID_AUT"] == "2") {
                    $buscar["AUT2"] = $autorizador["ID_AUT"];
                }
            }
            
            $resultado = $this->PermisoTblModel->getSolicitudesbyFilter($buscar);
                
//                echo "exvellekajflksdlñfjsdflñahsdflj";
//		if (PHP_SAPI == 'cli')
//			die('Este archivo solo se puede ver desde un navegador web');
                
		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();
		// Se asignan las propiedades del libro
                
		$objPHPExcel->getProperties()->setCreator("Laura Gomez") //Autor
							 ->setLastModifiedBy("Laura Gomez") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte Solicitudes Permisos")
							 ->setSubject("Reporte Solicitudes Permisos")
							 ->setDescription("Reporte Solicitudes permisos")
							 ->setKeywords("reporte Solicitudes permisos")
							 ->setCategory("Reporte Solicitudes permisos");
                
		$tituloReporte = "Reporte solicitudes de permisos";
		$titulosColumnas = array('Fecha Solicitud', 'Fecha desde','Fecha Hasta','CIOM','Tipo Solicitud','Motivo','Documento','Nombre','Vo. Bueno','Apro. DTDyP','Apro. DTH');
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('B1:D1')
        		    ->mergeCells('C3:D3');
                
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('ImgLogo');
                    $objDrawing->setDescription('Logo');
                    $img = $_SERVER['DOCUMENT_ROOT']."./agenda/agendaBE/application/views/escudo.png"; 
                    $objDrawing->setPath($img);
                    $objDrawing->setOffsetX(30);    // setOffsetX works properly
                    $objDrawing->setOffsetY(10);  //setOffsetY has no effect
                    $objDrawing->setCoordinates('A1');                    
//                    $objDrawing->setHeight(50); // logo height
                    $objDrawing->setWidth(70);
                    $objDrawing->setWorksheet($objPHPExcel->setActiveSheetIndex(0));
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('B1',$tituloReporte)               
                                        ->setCellValue('B3',"Fecha")
                                        ->setCellValue('C3',date("Y/m/d h:i:s a"))
        		    ->setCellValue('A6',  $titulosColumnas[0])
		            ->setCellValue('B6',  $titulosColumnas[1])
        		    ->setCellValue('C6',  $titulosColumnas[2])
                        ->setCellValue('D6',  $titulosColumnas[3])
                        ->setCellValue('E6',  $titulosColumnas[4])
                        ->setCellValue('F6',  $titulosColumnas[5])
                        ->setCellValue('G6',  $titulosColumnas[6])
                        ->setCellValue('H6',  $titulosColumnas[7])
                        ->setCellValue('I6',  $titulosColumnas[8])
                        ->setCellValue('J6',  $titulosColumnas[9])
                        ->setCellValue('K6',  $titulosColumnas[10]);
                        
		
		//Se agregan los datos de los alumnos
                
		$i = 7;              
//                echo 'aca se imprime el for';
                for($j = 0; $j < count($resultado); $j++) { 
                        $nombreCompleto = $resultado[$j]["PRIMER_NOMBRE"]." ".$resultado[$j]["SEGUNDO_NOMBRE"]." ".$resultado[$j]["PRIMER_APELLIDO"]." ".$resultado[$j]["SEGUNDO_APELLIDO"];
                        $aut0=$resultado[$j]["AUT0"];
                        $aut1=$resultado[$j]["AUT1"];
                        $aut2=$resultado[$j]["AUT2"];
                        $objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i,  $resultado[$j]["FEC_FORM"])
        		    ->setCellValue('B'.$i,  $resultado[$j]["FEC_INI_PERM"])
        		    ->setCellValue('C'.$i,  $resultado[$j]["FEC_FIN_PERM"])
        		    ->setCellValue('D'.$i,  $resultado[$j]["NOM_CIOM"])
        		    ->setCellValue('E'.$i,  $resultado[$j]["DESC_TIPO_SOLPER"])
        		    ->setCellValue('F'.$i,  $resultado[$j]["DESC_MOTIVO"])
        		    ->setCellValue('G'.$i,  $resultado[$j]["ID_USUARIOS"])
		            ->setCellValue('H'.$i,  $nombreCompleto);
                                
                        if($aut0 == "1"){
                            $apr0 = "Si";
                        }else if($aut0 == "2"){
                            $apr0 = "No";
                        }else{
                            $apr0 = "Espera";
                        }
                        if($aut1 == "1"){
                            $apr1 = "Si";
                        }else if($aut1 == "2"){
                            $apr1 = "No";
                        }else{
                            $apr1 = "Espera";
                        }
                        if($aut2 == "1"){
                            $apr2 = "Si";
                        }else if($aut2 == "2"){
                            $apr2 = "No";
                        }else{
                            $apr2 = "Espera";
                        }
        		 
                            $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('I'.$i,  $apr0)
                            ->setCellValue('J'.$i,  $apr1)
                            ->setCellValue('K'.$i,  $apr2);
                            
                        $i++;
                                        
		}
		
                $estiloTituloReporte = $this->getEstilo("estiloTituloReporte");
                $estiloTituloColumnas = $this->getEstilo("estiloTituloColumnas");
                $estiloInformacion = $this->getEstilo("estiloInformacion");
		 
		$objPHPExcel->getActiveSheet()->getStyle('B1:C1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A6:K6')->applyFromArray($estiloTituloColumnas);
                $objPHPExcel->getActiveSheet()->getStyle('B3:B3')->applyFromArray($estiloTituloColumnas);
		$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A7:K".($i-1));
				
		for($i = 'A'; $i <= 'K'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('SolicitudesPermisos');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
//		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
                // 
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="ReporteSolicitudesPermisos.xlsx"');
		header('Cache-Control: max-age=0');
//                echo '....................................................... aca llega al final del metodo';
                
                
                ////OTRO PASADO
//                header('Content-Type: application/vnd.ms-excel');
//                header('Content-Disposition: attachment;filename="'.utf8_decode('Extracto').'.xls"');
//                header('Cache-Control: max-age=0');
  
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
                exit;
//		
                        
    }
    
    public function getEstilo($estilo){
        if($estilo=="estiloTituloReporte"){
           $estiloTituloReporte = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'italic'    => false,
                'strike'    => false,
                'size'      => 10,
                'color'     => array(
                     'rgb' => '000000'
                    )
               ),
           'fill' => array(
           'type' => PHPExcel_Style_Fill::FILL_SOLID,
           'color' => array('argb' => 'ffffff')
           ),
               'borders' => array(
                   'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE                    
                   )
               ), 
              'alignment'  => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
              'rotation'   => 0,
              'wrap'       => TRUE
           )
           );
           return $estiloTituloReporte;
       }
       
    if($estilo=="estiloTituloColumnas"){
           $estiloTituloColumnas = array(
            'font' => array(
                'name'      => 'Verdana',
                'bold'      => true,
                'size'      => 10,
                'color'     => array(
                    'rgb' => '000000'
                )
            ),
            'fill'  => array(
            'type'  => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
            'rotation'   => 90,
                  'startcolor' => array(
                      'rgb' => 'e5dcdc'
                  ),
                  'endcolor'   => array(
                      'argb' => 'FAFAFA'
                  )
           ),
            'borders' => array(
                'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => 'A9BCF5'
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array(
                        'rgb' => 'A9BCF5'
                    )
                ),
                'allborders'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                        'rgb' => 'A9BCF5'
                    )
                )  
            ),
            'alignment' =>  array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'          => TRUE
               ));
            return $estiloTituloColumnas;
        }
       
        if($estilo=="estiloInformacion"){
            $estiloInformacion = new PHPExcel_Style();
            $estiloInformacion->applyFromArray(
                array(
                    'font' => array(
                        'name'      => 'Verdana',               
                        'color'     => array(
                        'rgb' => '000000'
                        )
                    ),
                    'fill'  => array(
                        'type'  => PHPExcel_Style_Fill::FILL_NONE,
                        'color'  => array('argb' => 'FFFFFF')
                    ),
                    'alignment' =>  array(
                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY,
                        'wrap'          => TRUE
                    ),
                    'borders' => array(
                        'left'     => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array(
                                       'rgb' => 'e5dcdc'
                            )
                        ),
                        'allborders'     => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array(
                                       'rgb' => 'e5dcdc'
                            )
                        ) 
                    )
                ));
                return $estiloInformacion;
        }
    }
    
}

?>
