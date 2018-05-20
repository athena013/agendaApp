<?php
//Fachada formulario Solicitud de permisos logica del negocio
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PermisoFachada extends CI_Model {

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


    
    
   
}

?>
