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
                
            }else if(intval($idTipoForm) == 2){
                //traslado seguridad social    
                $resultado=$this->PermisoTblModel->getDetalleSSG($idForm);
                
            }else if(intval($idTipoForm) == 4){
                //prima tecnica
                $resultado=$this->PermisoTblModel->getDetallePrimaTecnica($idForm);
            }
            
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error getSolicitudesbyUsuario' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'getSolicitudesbyUsuario list', false);
        return $resultado;
    }


    
    
   
}

?>
