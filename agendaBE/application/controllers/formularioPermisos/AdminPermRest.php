<?php
//Controlador Rest para el formulario de solicitud de permisos
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    
require APPPATH . "/libraries/REST_Controller.php";    

class AdminPermRest extends REST_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("/AdminPermFachada");
    }
    
    //obtiener cioms
    public function find_ciom_get() {
        log_message('info', 'Ingreso - find_ciom_get', false);
      
        $resultado = $this->AdminPermFachada->consultarCiom();
        log_message('info', 'Salida find_ciom_get', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "No se encontraron registros"), 401);
        }
    }
    
     //obtiener los motivos de permiso o licencia para las ciom
    public function find_motivo_get() {
        log_message('info', 'Ingreso - find_cargo_get', false);
        $cat = $this->input->get('cat');
       
        $resultado = $this->PermisoFachada->getMotivos($cat);
        log_message('info', 'Salida find_cargo_get', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "No se encontraron registros"), 411);
        }
    }
    
    //obtener solicitudes por los filtros de administracion
    public function obtenerSolbyFilter_post() {
        log_message('info', 'Ingreso - obtenerSolbyFilter_post', false);
        
        if (!$this->post("buscar")) {
    		$this->response(NULL, 401);
    	}
//        var_dump($this->post("buscar"));
        $resultado = $this->AdminPermFachada->getSolicitudesbyFilter($this->post("buscar"));
        
        
        log_message('info', 'Salida Solicitud - obtenerSolbyFilter_post', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "No se encontraron registros"), 401);
        }
    }
    //obtener solicitudes por los filtros de administracion
    public function aprobarSolicitud_post() {
        log_message('info', 'Ingreso - aprobarSolicitud_post', false);
        
        if (!$this->post("formulario")) {
    		$this->response(NULL, 401);
    	}
//        var_dump($this->post("buscar"));
        $resultado = $this->AdminPermFachada->aprobarSolicitud($this->post("formulario"));
        
        
        log_message('info', 'Salida Solicitud - aprobarSolicitud_post', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "Error en la aprobación"), 401);
        }
    }
    
    //obtener solicitudes por los filtros de administracion
    public function desaprobarSolicitud_post() {
        log_message('info', 'Ingreso - desaprobarSolicitud_post', false);
        
        if (!$this->post("formulario")) {
    		$this->response(NULL, 401);
    	}
//        var_dump($this->post("buscar"));
        $resultado = $this->AdminPermFachada->desaprobarSolicitud($this->post("formulario"));
        
        log_message('info', 'Salida Solicitud - desaprobarSolicitud_post', false);
        if (!is_null($resultado)) {
            $this->response(array("response" => $resultado), 200);
        } else {
            log_message('info', $resultado);
            $this->response(array("error" => "Error en la desaprobación"), 410);
        }
    }
    
}
