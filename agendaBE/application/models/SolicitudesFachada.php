<?php
//Fachada formulario Solicitud de permisos logica del negocio
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SolicitudesFachada extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->model("/solicitud/UsuarioModel");
        $this->load->model("/solicitud/PermisoTblModel");
        
    }

    
    //llamado getSolicitudesbyUsuario
    public function getSolicitudesbyUsuario($numDoc) {
        log_message('info', 'getSolicitudesbyUsuario', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            
            $resultado = $this->PermisoTblModel->getSolicitudesbyUsuario($numDoc);
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error getSolicitudesbyUsuario' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'getSolicitudesbyUsuario list', false);
        return $resultado;
    }
    
    
    
    //obtener el detalle de las solicitudes por tipo de usuario y tipo de solicitud
    public function getDetalleFormulario($idForm,$idTipoForm) {
        log_message('info', 'getDetalleFormulario', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            
            
            
            if(intval($idTipoForm) == 1 || intval($idTipoForm) == 3 || intval($idTipoForm) == 5){
                //solicitud de permiso
                $resultado=$this->PermisoTblModel->getDetallePermiso($idForm);
                
                //si el permiso es por estudio
                if($resultado["ID_MOTIVOFK"]=="3"){
                    $resultado["reposicion"]=$this->PermisoTblModel->getDetalleDiasReposicion($resultado["ID_SOL_PERM"]);
                }
                
                $fecha = new DateTime();
                $fecha->modify('last day of this month');
    //            echo $fecha->format('d');
                $fechaFin=$fecha->format('d/m/Y');

                $fecha->modify('first day of this month');
                $fechaInicio=$fecha->format('d/m/Y');

                $tiempoDias=$this->PermisoTblModel->countTiempo($resultado["ID_USUARIOS"],$fechaInicio, $fechaFin, "dias");
                $tiempoHoras=$this->PermisoTblModel->countTiempo($resultado["ID_USUARIOS"],$fechaInicio, $fechaFin , "horas");
                
                if($tiempoDias["CANTIDAD"]){
                    if($tiempoHoras["CANTIDAD"]){
                        if($tiempoHoras["CANTIDAD"] >= 8){
                            $total= (integer)$tiempoHoras["CANTIDAD"]/8;
                            $dias=(integer)$tiempoDias["CANTIDAD"]+(integer)$total;
                            $horas=(integer)$tiempoHoras["CANTIDAD"]-((integer)$total*8);
                        }else{
                            $dias=$tiempoDias["CANTIDAD"];
                            $horas=(integer)$tiempoHoras["CANTIDAD"];
                        }
                    }else{
                        $horas=0;
                        $dias=$tiempoDias["CANTIDAD"];
                    }
                }else{
                    $tiempoDias["CANTIDAD"]=0;
                    if($tiempoHoras["CANTIDAD"]){
                        if($tiempoHoras["CANTIDAD"] >= 8){
                            $total= (integer)$tiempoHoras["CANTIDAD"]/8;
                            $dias=(integer)$tiempoDias["CANTIDAD"]+(integer)$total;
                            $horas=(integer)$tiempoHoras["CANTIDAD"]-((integer)$total*8);
                        }else{
                            $dias=$tiempoDias["CANTIDAD"];
                            $horas=$tiempoHoras["CANTIDAD"];
                        }
                    }else{
                        $horas=0;
                        $dias=$tiempoDias["CANTIDAD"];
                    }
                }
                
                $resultado["totalDias"]=$dias;
                $resultado["totalHoras"]=$horas;
                
                        
            }else if(intval($idTipoForm) == 2){
                //traslado seguridad social    
                $resultado=$this->PermisoTblModel->getDetalleSSG($idForm);
                
            }else if(intval($idTipoForm) == 4){
                //prima tecnica
                $resultado=$this->PermisoTblModel->getDetallePrimaTecnica($idForm);
            }
//            $date = getdate();
//            $fechaInicio =  "01"."/".$date["month"]."/".$date["year"];
            
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error getDetalleFormulario' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'getDetalleFormulario list', false);
        return $resultado;
    }
    
    //eliminar solicitudes por tipo de usuario y tipo de solicitud
    public function deleteFormulario($idForm) {
        log_message('info', 'deleteFormulario', false);
        $resultado = NULL;
        $mensaje = NULL;
        $ruta = NULL;
            
        try {
            $this->db->trans_start();
            
            $ruta = $this->PermisoTblModel->obtenerRuta($idForm);
            
            if($ruta){
//                var_dump($ruta["RUTA_DOC"].$ruta["NOMB_DOC"]);
                unlink( $ruta["RUTA_DOC"].$ruta["NOMB_DOC"] );
            }
            
            $resultado = $this->PermisoTblModel->deleteFormulario($idForm);
             
                
            $this->db->trans_complete();
            
            if($resultado){
                $mensaje="Solicitud eliminada correctamente";
            }else{
                $mensaje=null;
            }
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error deleteFormulario' . $error[message], false);
            $this->db->trans_rollback();
            throw new Exception($error[message]);
        }
        log_message('info', 'getSolicitudesbyUsuario list', false);
        
        return $resultado;
    }
    
    //eliminar tabla reposicion
    public function deleteReposicion($idSol) {
        log_message('info', 'deleteReposicion', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_start();
            $resReposicion=$this->PermisoTblModel->deleteReposicion($idSol);
            $this->db->trans_complete();
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error deleteReposicion' . $error[message], false);
            $this->db->trans_rollback();
            throw new Exception($error[message]);
        }
        log_message('info', 'getSolicitudesbyUsuario list', false);
        return $resReposicion;
    }
    
     function header_footer(){
        $this->load->library('mydompdf');
              $data["numero"] = 250;
              $html= $this->load->view('pdf/header_footer', $data, true);
        $this->mydompdf->load_html($html);
        $this->mydompdf->render();
              $this->mydompdf->set_base_path('./assets/css/dompdf.css'); //agregar de nuevo el css
        $this->mydompdf->stream("welcome.pdf", array("Attachment" => false));
    }
    
    function header_footer_get($idForm, $tipo){
         
        $data=$this->PermisoTblModel->getDetallePermiso($idForm);
        
        if(intval($tipo) == 1 || intval($tipo) == 3 || intval($tipo) == 5){
                //solicitud de permiso
            $data=$this->PermisoTblModel->getDetallePermiso($idForm);
            
            if(intval($tipo) == 1){//permiso
                //si el permiso es por estudio
                if($data["HOR_INI_PERM"]){
                    $data["HORAS"]=$data["CANTIDAD"];
                    $data["HORAS_VALOR"]=$data["HOR_INI_PERM"].":".$data["MIN_INI_PERM"]." A ".$data["HOR_FIN_PERM"].":".$data["MIN_FIN_PERM"];
                    $data["DIAS"]="";
                }else{
                    $data["DIAS"]=$data["CANTIDAD"];
                    $data["HORAS"]="";
                    $data["HORAS_VALOR"]="";
                }
                $data["INI"]=$data["FEC_INI_PERM"];
                $data["FIN"]=$data["FEC_FIN_PERM"];
                $data["MOTIVO"]=$data["DESC_MOTIVO"];
                
                $data["L_INI"]="";
                $data["L_FIN"]="";
                $data["L_MOTIVO"]="";
                
                $data["V_INI"]="";
                $data["V_FIN"]="";
                $data["DIAS_DISFRUTE"]="";
                $data["DIAS_PEND"]="";
                
                $data["REPROGRAMACION"]="";
                $data["APLAZAMIENTO"]="";
                $data["INTERRUPCION"]="";
                
            }
            
            if(intval($tipo) == 5){//licencia no remunerada o por luto
                $data["L_INI"]=$data["FEC_INI_PERM"];
                $data["L_FIN"]=$data["FEC_FIN_PERM"];
                $data["L_MOTIVO"]=$data["DESC_MOTIVO"];
                
                $data["HORAS"]="";
                $data["DIAS"]="";
                $data["INI"]="";
                $data["FIN"]="";
                $data["MOTIVO"]="";
                $data["HORAS_VALOR"]="";
                
                $data["V_INI"]="";
                $data["V_FIN"]="";
                $data["DIAS_DISFRUTE"]="";
                $data["DIAS_PEND"]="";
                
                $data["REPROGRAMACION"]="";
                $data["APLAZAMIENTO"]="";
                $data["INTERRUPCION"]="";
            }
            
            if(intval($tipo) == 3){//vacaciones
                if($data["TIPO_VACACIONES"]== "1"){
                    $data["REPROGRAMACION"]="X";
                }else{
                    $data["REPROGRAMACION"]="";
                }
                if($data["TIPO_VACACIONES"]== "2"){
                    $data["APLAZAMIENTO"]="X";
                }else{
                    $data["APLAZAMIENTO"]="";
                }
                if($data["TIPO_VACACIONES"]== "3"){
                    $data["INTERRUPCION"]="X";
                }else{
                    $data["INTERRUPCION"]="";
                }
                $data["V_INI"]=$data["FEC_INI_PERM"];
                $data["V_FIN"]=$data["FEC_FIN_PERM"];
                
                $data["HORAS"]="";
                $data["DIAS"]="";
                $data["INI"]="";
                $data["FIN"]="";
                $data["MOTIVO"]="";
                $data["HORAS_VALOR"]="";
                
                $data["L_INI"]="";
                $data["L_FIN"]="";
                $data["L_MOTIVO"]="";
            }
            
            $data["EPS_DESTINO"]="";
            $data["FEC_AFL_EPS"]="";
            $data["PEN_ORIGEN"]="";
            $data["PEN_DESTINO"]="";
            $data["FEC_AFL_PEN"]="";
            $data["CES_ORIGEN"]="";
            $data["CES_DESTINO"]="";
            $data["FEC_AFL_CES"]="";
            $data["EPS_ORIGEN"]="";

            $data["RECONOCIMIENTO"]="";
            $data["REAJUSTE"]="";
            $data["ESTUDIOS"]="";
            $data["EXPERIENCIA"]="";
            
        }else if(intval($tipo) == 2){//seguridad Social
            //traslado seguridad social    
            $data=$this->PermisoTblModel->getDetalleSSG($idForm);
                $data["HORAS"]="";
                $data["DIAS"]="";
                $data["INI"]="";
                $data["FIN"]="";
                $data["MOTIVO"]="";
                $data["OTRO_MOTIVO"]="";
                $data["DESC_MOTIVO"]="";
                 $data["HORAS_VALOR"]="";
                
                $data["L_INI"]="";
                $data["L_FIN"]="";
                $data["L_MOTIVO"]="";
                
                $data["RECONOCIMIENTO"]="";
                $data["REAJUSTE"]="";
                $data["ESTUDIOS"]="";
                $data["EXPERIENCIA"]="";
                
                $data["V_INI"]="";
                $data["V_FIN"]="";
                $data["TIPO_VACACIONES"]="";
                $data["NUM_RESOLUCION"]="";
                $data["FEC_RESOLUCION"]="";
                $data["DIAS_DISFRUTE"]="";
                $data["DIAS_PEND"]="";
                $data["REPROGRAMACION"]="";
                $data["APLAZAMIENTO"]="";
                $data["INTERRUPCION"]="";
                
        }else if(intval($tipo) == 4){//prima tecnica
            //prima tecnica
            $data=$this->PermisoTblModel->getDetallePrimaTecnica($idForm);
            
            if($data["RECONOCIMIENTO"]== "1"){
                $data["RECONOCIMIENTO"]="X";
            }else{
                $data["RECONOCIMIENTO"]="";
            }
            if($data["REAJUSTE"]== "1"){
                $data["REAJUSTE"]="X";
            }else{
                $data["REAJUSTE"]="";
            }
            if($data["ESTUDIOS"]== "1"){
                $data["ESTUDIOS"]="X";
            }else{
                $data["ESTUDIOS"]="";
            }
            if($data["EXPERIENCIA"]== "1"){
                $data["EXPERIENCIA"]="X";
            }else{
                $data["EXPERIENCIA"]="";
            }
            
            $data["HORAS"]="";
            $data["DIAS"]="";
            $data["INI"]="";
            $data["FIN"]="";
            $data["MOTIVO"]="";
            $data["OTRO_MOTIVO"]="";
            $data["DESC_MOTIVO"]="";
            $data["HORAS_VALOR"]="";
            
            $data["V_INI"]="";
            $data["V_FIN"]="";
            $data["TIPO_VACACIONES"]="";
            $data["NUM_RESOLUCION"]="";
            $data["FEC_RESOLUCION"]="";
            $data["DIAS_DISFRUTE"]="";
            $data["DIAS_PEND"]="";
            $data["REPROGRAMACION"]="";
            $data["APLAZAMIENTO"]="";
            $data["INTERRUPCION"]="";
            
            $data["EPS_DESTINO"]="";
            $data["FEC_AFL_EPS"]="";
            $data["PEN_ORIGEN"]="";
            $data["PEN_DESTINO"]="";
            $data["FEC_AFL_PEN"]="";
            $data["CES_ORIGEN"]="";
            $data["CES_DESTINO"]="";
            $data["FEC_AFL_CES"]="";
            $data["EPS_ORIGEN"]="";
                
            $data["L_INI"]="";
            $data["L_FIN"]="";
            $data["L_MOTIVO"]="";
        }
        
//        var_dump($data);
//        
        $this->load->library('mydompdf');
         
              $html= $this->load->view('pdf/header_footer', $data, true);
        $this->mydompdf->load_html($html);
        $this->mydompdf->render();
              $this->mydompdf->set_base_path('./assets/css/dompdf.css'); //agregar de nuevo el css
        $this->mydompdf->stream("formulario.pdf", array("Attachment" => false));
    }
   
}

?>
