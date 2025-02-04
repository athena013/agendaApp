'use strict';
var urlParametrosModule = urlBackEnd;

angular.module('AgendaApp.PermisoSrv')
        .factory("serveData", function () {
            return {
                data: {}
            };
        })
        .factory('usuarioAgendaSrv', [ '$resource', '$rootScope',
                function($resource, $rootScope) {
                    return $resource(urlParametrosModule
                                    + 'buscarUsuario/:idUsuario', {
                            idUsuario: '@idUsuario'
                    }, {
                            update : {
                                    method : 'PUT'
                            },
                            query : {
                                    method : 'GET',
                                    isArray : false
                            },
                            consultarDatos:{
                                url : urlParametrosModule + 'usuario/buscarUsuario/:numDoc/nombre/:usuario',
                                method : "GET",
                                isArray : false
                            },
                            cargarDias:{
                                url : urlParametrosModule + 'formulario/buscarDias/idSol/:idSol',
                                method : "GET",
                                isArray : false
                            },
                            guardarDias:{
                                url : urlParametrosModule + 'formulario/guardarDias',
                                method : "POST",
                                isArray : false
                            },
                            validarFechas:{
                                url : urlParametrosModule + 'formulario/validarFechas',
                                method : "POST",
                                isArray : false
                            },
                            guardarFormulario:{
                                url : urlParametrosModule + 'formulario/guardarFormulario',
                                headers: {  "Content-type": undefined },
                                method : "POST",
                                isArray : false,
                                transformRequest: angular.identity
                            },
                            fileUpload:{
                                url : urlParametrosModule + 'formulario/adjuntar',
                                headers: {  "Content-type": undefined },
                                method : "POST",
                                isArray : false,
                                transformRequest: angular.identity
                            }
                    });
	} ])
        .factory('cargoSrv', [ '$resource', '$rootScope',
                function($resource, $rootScope) {
                    return $resource(urlParametrosModule
                                    + 'obtenerCargos/:idUsuario', {
                            idUsuario: '@idUsuario'
                    }, {
                            update : {
                                    method : 'PUT'
                            },
                            query : {
                                    method : 'GET',
                                    isArray : false
                            }
                    });
	} ])
        .factory('MotivoSrv', [ '$resource', '$rootScope',
                function($resource, $rootScope) {
                    return $resource(urlParametrosModule
                                    + 'obtenerMotivos/:idUsuario', {
                            idUsuario: '@idUsuario'
                    }, {
                            update : {
                                    method : 'PUT'
                            },
                            query : {
                                    method : 'GET',
                                    isArray : false
                            }
                    });
	} ])
        .factory('solicitudSrv', [ '$resource', '$rootScope',
                function($resource, $rootScope) {
                    return $resource(urlParametrosModule
                                    + 'obtenerSolicitudes/idUsuario/:numDoc', {
                            numDoc: '@numDoc'
                    }, {
                            update : {
                                    method : 'PUT'
                            },
                            query : {
                                    method : 'GET',
                                    isArray : false
                            },
                            obtenerDetalle : {
                                    url : urlParametrosModule + 'obtenerDetalle/formulario/:idForm/tipoSol/:idTipoForm',
                                    method : 'GET',
                                    isArray : false
                            },
                            eliminar : {
                                    url : urlParametrosModule + 'eliminar/formulario',
                                    method : 'POST',
                                    isArray : false
                            },
                            imprimir : {
                                    url : urlParametrosModule + 'imprimir/formulario',
                                    method : 'POST',
                                    isArray : false
                            }
                    });
	} ])
        
;
