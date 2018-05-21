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
        
        log_message('info', 'Salida Solicitud - obtenerSolicitudDetalle_get', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "No se encontraron registros"), 408);
        }
    }
    
    //elimina el formulario diligenciado
    public function eliminarFormulario_post() {
        log_message('info', 'Ingreso - eliminarFormulario_post', false);
        
        $idForm=$this->post("idForm");
        $idTipoForm=$this->post("idTipoForm");
        $idSol=$this->post("idSol");
        
        var_dump($this->post("idForm"));
        var_dump($this->post("idTipoForm"));
        var_dump($this->post("idSol"));
        var_dump("tiene post?");
        
        if (!$idForm || !$idTipoForm || !$idSol) { 
            $this->response(NULL, 210);
        }
        
        $resultado = $this->SolicitudesFachada->deleteFormulario($idForm,$idTipoForm,$idSol);
        
        var_dump("antes responder");
//        var_dump($resultado);
        
        log_message('info', 'Salida Solicitud - eliminarFormulario_post', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "Error en la eliminación"), 408);
        }
    }
    
}
