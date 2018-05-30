'use strict';

var urlParametrosModule = urlBackEnd;

angular.module('AgendaApp.AdminPermisos')
        .factory("serveData", function () {
            return {
                data: {}
            };
        })
        .factory('funcionariaSrv', [ '$resource', '$rootScope',
                function($resource, $rootScope) {
                    return $resource(urlParametrosModule
                                    + 'funcionaria/:idUsuario', {
                            idUsuario: '@idUsuario'
                    }, {
                            query : {
                                    url : urlParametrosModule + 'obtenerFuncionaria/numDoc/:numDoc',
                                    method : 'GET',
                                    isArray : false
                            },
                            update : {
                                    method : 'POST'
                            }
                    });
	} ])
        .factory('ciomSrv', [ '$resource', '$rootScope',
                function($resource, $rootScope) {
                    return $resource(urlParametrosModule
                                    + 'obtenerCiom/:idUsuario', {
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
        .factory('solicitudPerSrv', [ '$resource', '$rootScope',
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
                            buscar : {
                                    url : urlParametrosModule + 'obtenerSolbyFilter',
                                    method : 'POST',
                                    isArray : false
                            },
                            aprobar : {
                                    url : urlParametrosModule + 'aprobarSolicitud',
                                    method : 'POST',
                                    isArray : false
                            },
                            desaprobar : {
                                    url : urlParametrosModule + 'desaprobarSolicitud',
                                    method : 'POST',
                                    isArray : false
                            },
                            administracion : {
                                    url : urlParametrosModule + 'obtenerAutorizador/:idUsuario',
                                    method : 'GET',
                                    isArray : false
                            }
                          
                    });
	} ])
        ;
