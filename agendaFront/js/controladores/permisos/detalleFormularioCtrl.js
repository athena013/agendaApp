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
                        
                        $scope.datosUsuario = {};
                        
                        $scope.obtenerFormularioCompleto = function (){
                           
                            
                        };
                        $scope.obtenerFormularioCompleto();

                    }]);

