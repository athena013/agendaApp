<?php
//Controlador Rest para el formulario de solicitud de permisos
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
require APPPATH . "/libraries/REST_Controller.php";    

class SolicitudesRest extends REST_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("/SolicitudesFachada");
    }
    
    //obtiener solicitudes por usuario ciom
    public function index_get($numDoc) {
        log_message('info', 'Ingreso - index_get', false);
        if (!$numDoc) { 
            $this->response(NULL, 210);
        }
        $resultado = $this->SolicitudesFachada->getSolicitudesbyUsuario($numDoc);
        
        log_message('info', 'Salida Solicitud - index_get', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "No se encontraron registros"), 401);
        }
    }
    
    //obtiener el detalle por id de solicitud y tipo de solicitud
    public function obtenerSolicitudDetalle_get($idForm,$idTipoForm) {
        log_message('info', 'Ingreso - index_get', false);
        if (!$idForm || !$idTipoForm) { 
            $this->response(NULL, 210);
        }
        $resultado = $this->SolicitudesFachada->getDetalleFormulario($idForm,$idTipoForm);
        
        log_message('info', 'Salida Solicitud - index_get', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "No se encontraron registros"), 408);
        }
    }
    
}
