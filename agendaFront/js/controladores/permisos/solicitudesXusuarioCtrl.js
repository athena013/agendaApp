'use strict';

angular.module('AgendaApp.formularioPermisos')
        .controller('solicitudesXusuarioCtrl',
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
                        
                        $scope.datosUsuario = {};
                                                    
                        $scope.obtenerIdUrl = function (){
                            $scope.datosUsuario.numDoc = getUrlVars()["id"];
                            console.log($scope.datosUsuario.id);
                            var fecha= new Date();
                            $scope.tipo1=false;
                        };
                        $scope.obtenerIdUrl();                            
                                                    
                        /*obtener datos de usuario para el formulario*/
                        $scope.obtenerDatosUsuario = function (){
                             var target = document.getElementById('divLoadingGeneral');
                            var spinner = new Spinner().spin(target);
                            
                            console.log("llega obtenerDatosUsuario");
                            var fecha= new Date();
                            $scope.result={};
                            $scope.datosUsuario.numDoc ="10297434" ;
                            $scope.datosUsuario.nomUsu ="cllanten" ;
                            if($scope.datosUsuario.numDoc != ""){
                                    usuarioAgendaSrv.consultarDatos({numDoc: $scope.datosUsuario.numDoc,usuario: $scope.datosUsuario.nomUsu}).$promise.then(function(data){
                                      console.log(data.response);
                                      $scope.result=data.response;
                                      serveData.data.datosUsuario=$scope.result;
                                      $scope.datosUsuario=data.response;
                                      $scope.datosUsuario.idUser=$scope.result.ID_USUARIOS;
                                      $scope.datosUsuario.nombre=$scope.result.PRIMER_NOMBRE +" "+ $scope.result.PRIMER_APELLIDO;
                                      $scope.datosUsuario.fecha_solicitud = fecha.getFullYear()+"/"+(fecha.getMonth()+1)+"/"+fecha.getDate();
                                      messageCenterService.add(CONSTANTS.TYPE_SUCCESS,"Datos exitoso",{icon : CONSTANTS.TYPE_SUCCES_ICON,messageIcon : CONSTANTS.TYPE_SUCCESS_MESSAGE_ICON,timeout : CONSTANTS.TYPE_SUCCESS_TIME});
                                    }, function(reason){
                                            
                                    });
                            }else{
                                    messageCenterService.add(CONSTANTS.TYPE_DANGER,"Numero documento vacio",{icon : CONSTANTS.TYPE_DANGER_ICON,messageIcon : CONSTANTS.TYPE_DANGER_MESSAGE_ICON,timeout : CONSTANTS.TYPE_DANGER_TIME});
                            } 
                            if (spinner) {
                                spinner.stop();
                            }
                            
                        };
                             
                       /* coloca los datos de usuario en el serverData*/
                        console.log("voy a preguntar si existe serverdata" + serveData.data.datosUsuario);
                        if (serveData.data.datosUsuario) {
                            if (serveData.data.datosUsuario.idUser) {
                                $scope.datosUsuario = serveData.data.datosUsuario;
                                console.log("datos consulta server: " + $scope.datosUsuario.idUser);
                            }
                        }else{
                            $scope.obtenerDatosUsuario();
                        }
                        
                         /* obtiene el numero de identificacion de la url*/
                        function getUrlVars()
                        {
                            var vars = [], hash;
                            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                            for(var i = 0; i < hashes.length; i++)
                            {
                                hash = hashes[i].split('=');
                                vars.push(hash[0]);
                                vars[hash[0]] = hash[1];
                            }
                            return vars;
                        }
                        
                        $scope.obtenerSolicitudes = function (){
                            solicitudSrv.query({numDoc: $scope.datosUsuario.numDoc}).$promise.then(function(data){
                                $scope.solicitudList = data.response;
                                messageCenterService.add(CONSTANTS.TYPE_SUCCESS,"Solicitudes encontradas",{icon : CONSTANTS.TYPE_SUCCES_ICON,messageIcon : CONSTANTS.TYPE_SUCCESS_MESSAGE_ICON,timeout : CONSTANTS.TYPE_SUCCESS_TIME});
                              }, function(reason){
                                messageCenterService.add(CONSTANTS.TYPE_DANGER,"No hay solicitudes Diligenciadas",{icon : CONSTANTS.TYPE_DANGER_ICON,messageIcon : CONSTANTS.TYPE_DANGER_MESSAGE_ICON,timeout : CONSTANTS.TYPE_DANGER_TIME});
                              });
                        };
                        $scope.obtenerSolicitudes();
                        
                        
                        $scope.verDetalle = function (objeto){
                            $confirm({objeto: objeto}, {templateUrl: 'pages/formPermisos/detalleFormulario.html'})
                                        .then(function () {
                                        });
                        };

                    }]);

