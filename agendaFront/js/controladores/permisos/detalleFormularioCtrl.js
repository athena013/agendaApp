'use strict';

angular.module('AgendaApp.formularioPermisos')
        .controller('detalleFormularioCtrl',
                ['$scope',
                    '$route',
                    'messageCenterService',
                    '$location',
                    'constantsFront', '$http', 'serveData', 'usuarioAgendaSrv','solicitudSrv','$confirm',
                    function ($scope,
                            $route, messageCenterService,
                            $location, CONSTANTS, $http, serveData,usuarioAgendaSrv,solicitudSrv,$confirm)
                    {
                        $scope.emailModel = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                        $scope.letrasModel = /^[_a-zA-Z0-9ñÑ_,.-\s]*$/;
                        $scope.direccionModel = /^[_a-zA-Z0-9ñÑ#_,.-\s]*$/;
                        $scope.numModel = /^[0-9]*$/;
                        $scope.telModel = /^[0-9]{7}$/;
                        $scope.celModel = /^[3]{1}[0-3]{1}[0-9]{8}$/;
                        $scope.solicitudList = {};
                        $scope.tipo1=false;
                        $scope.tipo2=false;
                        $scope.tipo3=false;
                        $scope.tipo4=false;
                        $scope.tipo5=false;
                        $scope.horas=false;
//                        $scope.adjunto=false;
                        
                        $scope.datosUsuario = {};
                        
                        
                        $scope.obtenerFormularioCompleto = function (){
//                           $scope.data.objeto;
                           solicitudSrv.obtenerDetalle({idForm: $scope.data.objeto.ID_FRM_PER ,idTipoForm:$scope.data.objeto.ID_TIPO_SOLPERFK}).$promise.then(function(data){
                                $scope.detalle = data.response;
                                switch ($scope.detalle.ID_TIPO_SOLPERFK){
                                    case "1":
                                        $scope.tipo1=true;
                                        $scope.tipo2=false;
                                        $scope.tipo3=false;
                                        $scope.tipo4=false;
                                        $scope.tipo5=false;
                                        $scope.dsTipoSolicitud="1. Solicitud de permiso o ausencia de servidoras(es) públicos";
                                        if($scope.detalle.HOR_INI_PERM){
                                            $scope.detalle.dsTiempo="Horas";
                                            $scope.horas=true;
                                        }else{
                                            $scope.detalle.dsTiempo="Dias";
                                            $scope.horas=false;
                                        }
                                        if($scope.detalle.reposicion){
                                          $scope.diasList=$scope.detalle.reposicion;
                                        }
                                        break;
                                    case "2":
                                        $scope.tipo1=false;
                                        $scope.tipo2=true;
                                        $scope.tipo3=false;
                                        $scope.tipo4=false;
                                        $scope.tipo5=false;
                                        $scope.horas=false;
                                        $scope.dsTipoSolicitud="2. Traslado en seguridad social y cesantías";
                                        break;
                                    case "3":
                                        $scope.tipo1=false;
                                        $scope.tipo2=false;
                                        $scope.tipo3=true;
                                        $scope.tipo4=false;
                                        $scope.tipo5=false;
                                        $scope.horas=false;
                                        $scope.dsTipoSolicitud="3. Vacaciones";
                                        break;
                                    case "4":
                                        $scope.tipo1=false;
                                        $scope.tipo2=false;
                                        $scope.tipo3=false;
                                        $scope.tipo4=true;
                                        $scope.tipo5=false;
                                        $scope.horas=false;
                                         $scope.dsTipoSolicitud="4. Prima técnica";
                                        break;
                                    case "5":
                                        $scope.tipo1=false;
                                        $scope.tipo2=false;
                                        $scope.tipo3=false;
                                        $scope.tipo4=false;
                                        $scope.tipo5=true;
                                        $scope.horas=false;
                                        $scope.dsTipoSolicitud="5. Licencia no remunerada o licencia por luto";
                                        break;
                                }
                                
                                console.log($scope.detalle.NOMB_DOC);
                                
                                if($scope.detalle.NOMB_DOC){
                                    console.log("tiene adjunto");
                                    $scope.adjunto=true;
//                                    $scope.ruta= $scope.detalle.RUTA_DOC.toString()+$scope.detalle.NOMB_DO.toString();
                                }else{
                                    $scope.adjunto=false;
                                }
                                
                                messageCenterService.add(CONSTANTS.TYPE_SUCCESS,"Detalle formulario",{icon : CONSTANTS.TYPE_SUCCES_ICON,messageIcon : CONSTANTS.TYPE_SUCCESS_MESSAGE_ICON,timeout : CONSTANTS.TYPE_SUCCESS_TIME});
                              
                           }, function(reason){
                                messageCenterService.add(CONSTANTS.TYPE_DANGER,"No se encuentra el formulario",{icon : CONSTANTS.TYPE_DANGER_ICON,messageIcon : CONSTANTS.TYPE_DANGER_MESSAGE_ICON,timeout : CONSTANTS.TYPE_DANGER_TIME});
                              });
                            
                        };
                        $scope.obtenerFormularioCompleto();
                            
                        $scope.eliminar = function (objeto){
                            console.log("entra a eliminar");
                            console.log(objeto);
                            var idSol;
                            if(objeto.ID_TIPO_SOLPERFK == "2"){
                                idSol = objeto.ID_SOL_TRASSEGSOC;
                            }else if(objeto.ID_TIPO_SOLPERFK == "4"){
                                idSol = objeto.ID_SOL_PRITEC;
                            }else{
                                idSol = objeto.ID_SOL_PERM;
                            }
                                    
                            solicitudSrv.eliminar({idForm: objeto.ID_FRM_PER, idTipoForm: objeto.ID_TIPO_SOLPERFK, idSol: idSol}).$promise.then(function(data){
                                 
                                 
                             }, function(reason){
                                messageCenterService.add(CONSTANTS.TYPE_DANGER,reason.error,{icon : CONSTANTS.TYPE_DANGER_ICON,messageIcon : CONSTANTS.TYPE_DANGER_MESSAGE_ICON,timeout : CONSTANTS.TYPE_DANGER_TIME});
                            });
                        };
                            

                    }]);

