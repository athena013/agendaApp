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
        ;
