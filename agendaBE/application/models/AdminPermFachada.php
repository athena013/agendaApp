<?php

//Fachada formulario Solicitud de permisos logica del negocio
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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

}

?>
