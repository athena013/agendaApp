
angular.module('AgendaApp').config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/', {
                controller: 'formPermisosCtrl',
                templateUrl: 'pages/formPermisos/formularioPermisos.html'
            })
            .when('/formularioPermisos', {
                controller: 'formPermisosCtrl',
                templateUrl: 'pages/formPermisos/formularioPermisos.html'
            })
            .when('/AdminPermisos', {
                controller: 'adminPermisosCtrl',
                templateUrl: 'pages/formPermisos/formularioAdminPermisos.html'
            })
            .when('/adicionarDias', {
                controller: 'reposicionCtrl',
                templateUrl: 'pages/formPermisos/diasReposicionPermisos.html'
            })
            .when('/solicitudesXusuario', {
                controller: 'solicitudesXusuarioCtrl',
                templateUrl: 'pages/formPermisos/solicitudesDiligenciadas.html'
            })
            .when('/administracion', {
                controller: 'adminPermisosCtrl',
                templateUrl: 'pages/formPermisos/solicitudesPorAdministrador.html'
            })
            .when('/ingresarPermisosAdmin', {
                controller: 'ingresarPermisoAdministradorCtrl',
                templateUrl: 'pages/formPermisos/ingresarPermisosAdministrador.html'
            })
            
            .otherwise({redirectTo: '/'});
     }]);
