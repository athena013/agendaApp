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

    //llamado al modelo para obtener datos de usuario, se envia el numero de docuemento
    public function consultarUsuarioId($numDoc, $nomUsu) {
        log_message('info', 'consultarUsuarioId', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $resultado = $this->UsuarioModel->getUsuarioById($numDoc,$nomUsu);
            
            if(isset($resultado["SEGUNDO_NOMBRE"]) && $resultado["SEGUNDO_NOMBRE"] == null){
                $resultado["SEGUNDO_NOMBRE"]=" ";
            }
            if(isset($resultado["SEGUNDO_APELLIDO"]) && $resultado["SEGUNDO_APELLIDO"] == null){
                $resultado["SEGUNDO_APELLIDO"]=" ";
            }
          
//            $objDocsPendiente= $ $this->UsuarioModel->obtenerDocsPendientes($numDoc);
           
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarUsuarioId' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $resultado;
    }
    
     //llamado al modelo para obtener cargos
    public function consultarCargoCiom() {
        log_message('info', 'consultarCargoCiom', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $resultado = $this->UsuarioModel->getCargoCiom();
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarCargoCiom' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarUsuarioId list', false);
        return $resultado;
    }
    
    //llamado al modelo para obtener los motivo de permiso
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
    
    //llamado getDiasReposicion
    public function getDiasReposicion($id) {
        log_message('info', 'consultarCargoCiom', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $resultado = $this->PermisoTblModel->getDiasReposicion($id);
           
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

    public function guardarDiasReposicion($datos) {
        log_message('info', 'guardarDiasReposicion', false);
        $resTransaccion = NULL;
        $respuesta = NULL;
        try {
            $this->db->trans_off();
            
            $respuesta = $this->PermisoTblModel->saveDiasReposicion($datos);
            
            if($respuesta){
                $resTransaccion["estatus"] = "OK";
                $resTransaccion["mensaje"]="Solicitud guardada correctamente";
            }else{
                $resTransaccion["estatus"] = "KO";
                $resTransaccion["mensaje"]="No se guardo la solicitud";
            }
            
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error actualizarFuncionaria' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'actualizarFuncionaria list', false);
        return $resTransaccion;
    }
    
    public function consultarFuncionariaId($id) {

        log_message('info', 'consultarFuncionariaId', false);
        $funcionaria = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            $funcionaria= $this->UsuarioModel->consultarFuncionariaId($id);
          
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error consultarFuncionariaId' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'consultarFuncionariaId list', false);
        return $funcionaria;
    }
    
    public function guardarFormulario($form,$file) {
        log_message('info', 'guardarFormulario', false);
        $resultado = NULL;
        $mensaje = NULL;
        $resTransaccion = array();
        try {
            $this->db->trans_off();
//            var_dump($form);
            $tipoForm=$form["tipoSolicitud"];
            $form["ID_TIPO_SOLPERFK"]=$tipoForm;
            $form["BND1"]=0;//no solicite permiso en fecha extemporanea

            $funcionaria= $this->UsuarioModel->updateFuncionaria($form,$form["numDoc"]);
            
            if($funcionaria == true){
                
                $resultForm=$this->PermisoTblModel->saveFormulario($form);
                
                if($resultForm==1){
                    $idForm= $this->PermisoTblModel->getIdForm();
                    $form["ID_FRM_PERFK"]=$idForm;
                      
                    if(isset($idForm)&& $idForm != ""){
                        
                        if(intval($tipoForm) == 1 || intval($tipoForm) == 3 || intval($tipoForm) == 5){
                            $resultadoSolicitud = $this->PermisoTblModel->saveSolicitudPermiso($form);
                            if($resultadoSolicitud==true){
                                $idSol= $this->PermisoTblModel->getIdSolicitudPermisos(); 
                                // SE GUARDA EL ARCHIVO CARGADO
                                if(isset($file)){
                                    $arcSave = $this->saveFile($file,$idForm["ID_FRM_PER"]);
                                    if(isset($arcSave["nomb_doc"]) && isset($arcSave["ruta_doc"])){
                                        // SE ACTUALIZA LA RUTA
                                        $this->PermisoTblModel->updateFormulario($arcSave,$idForm["ID_FRM_PER"]);
                                    }
                                }
                                $resTransaccion["estatus"] = "OK";
                                $resTransaccion["mensaje"]="Solicitud guardada correctamente";
                                $resTransaccion["formulario"] = $idForm["ID_FRM_PER"];
                                $resTransaccion["solicitud"] = $idSol["ID_SOL_PERM"];
                            }else{
                                $resTransaccion["estatus"] = "KO";
                                $resTransaccion["mensaje"]="No se guardo la solicitud";
                            }
                        }else if(intval($tipoForm) == 2){
                            $resTraSecSoc = $this->PermisoTblModel->saveTraSegSoc($form);
                            if($resTraSecSoc){
                                $resTransaccion["estatus"] = "OK";
                                $resTransaccion["mensaje"]="Solicitud guardada correctamente";
                                $resTransaccion["formulario"] = $idForm["ID_FRM_PER"];
                                $resTransaccion["solicitud"] = "";
                            }else{
                                $resTransaccion["estatus"] = "KO";
                                $resTransaccion["mensaje"]="No se guardo la solicitud";
                            }
                        }else if(intval($tipoForm) == 4){
                            $resPriTec = $this->PermisoTblModel->savePriTec($form);
                            if($resPriTec){
                                $resTransaccion["estatus"] = "OK";
                                $resTransaccion["mensaje"]="Solicitud guardada correctamente";
                                $resTransaccion["formulario"] = $idForm["ID_FRM_PER"];
                                $resTransaccion["solicitud"] = "";
                            }else{
                                $resTransaccion["estatus"] = "KO";
                                $resTransaccion["mensaje"]="No se guardo la solicitud";
                            }
                        }
                    } 
                }else{
                    $resTransaccion["estatus"] = "KO";
                    $resTransaccion["mensaje"]="No se guardo el formulario";
                }
            }
            
           
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error guardarFormulario' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'guardarFormulario list', false);
        return $resTransaccion;
    }
    
    private function saveFile($file,$idSol){
        $retorno = array();
        $nNombre = $idSol."_".$file["name"];
        move_uploaded_file( $file['tmp_name'], RUTA_ARCHIVOS.$nNombre);
        $retorno["nomb_doc"]=$nNombre;
        $retorno["ruta_doc"] = RUTA_ARCHIVOS;
        return $retorno;
    }
    
    /*validar si la fecha solicitada esta disponible para el permiso*/
    public function validarFechas($fechas,$tipo,$idUsu){
        log_message('info', 'validarFechas', false);
        $resultado = NULL;
        $mensaje = NULL;
        try {
            $this->db->trans_off();
            
            $fecha1=$fechas["fecha1"];
            $fecha1=date("d/m/Y", strtotime($fechas["fecha1"]));
            $fecha2= date("d/m/Y", strtotime($fechas["fecha2"]));
            
           
            if(isset($fechas["hora1"])){
                $hora1=$fechas["hora1"];
            }else{
                $hora1=null;
            }
            if(isset($fechas["hora2"])){
                $hora2=$fechas["hora2"];
            }else{
                $hora2=null;
            }
            
            
            
            $ciom = $this->UsuarioModel->obtenerCiom($idUsu);
            $idCiom = $ciom["ID_CIOMFK"];
             
            
            $count = $this->PermisoTblModel->validarFechas($fecha1,$fecha2,$idCiom);
            
            
            $conteo=$count["COUNT"];
            
            if($conteo >=2){
                $resultado=null;
            }else{
                $resultado="Fechas disponibles";
            }
                
        } catch (Exception $e) {
            $error = $this->db->error();
            log_message('error', 'error validarFechas' . $error[message], false);
            throw new Exception($error[message]);
        }
        log_message('info', 'validarFechas list', false);
        return $resultado;
    }
    
}

?>
