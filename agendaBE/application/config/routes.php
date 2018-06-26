<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'PermisosRest';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Rutas Permisos
//$route['buscarUsuario']['get'] = "formularioPermisos/PermisosRest/index"; 
$route['obtenerCargos']['get'] = "formularioPermisos/PermisosRest/find_cargo";
$route['obtenerCiom']['get'] = "formularioPermisos/AdminPermRest/find_ciom";
$route['obtenerMotivos']['get'] = "formularioPermisos/PermisosRest/find_motivo";
$route['usuario/buscarUsuario/(:any)/nombre/(:any)']['get'] = "formularioPermisos/PermisosRest/index/$1/$2";
$route['formulario/guardarFormulario']['post'] = "formularioPermisos/PermisosRest/index";

$route['obtenerFuncionaria/numDoc/(:num)']['get'] = "formularioPermisos/PermisosRest/consultarFuncionaria/$1";
$route['funcionaria']['post'] = "formularioPermisos/PermisosRest/actualizarFuncionaria";

$route['formulario/adjuntar']['post'] = "formularioPermisos/PermisosRest/adjuntar";
$route['formulario/guardarDias']['post'] = "formularioPermisos/PermisosRest/guardar_dias";
$route['formulario/buscarDias/idSol/(:any)']['get'] = "formularioPermisos/PermisosRest/buscarDiasFormulario/$1";
$route['formulario/validarFechas']['post'] = "formularioPermisos/PermisosRest/validarFechas";

$route['formulario/validarFechas/(:any)/(:any)/(:any)']['get'] = "formularioPermisos/PermisosRest/pendiente";
$route['uploadFilePermisos']['post'] = "formularioPermisos/PermisosRest/cargar";

//SOLICITUDES POR USUARIO ADMINISTRADOR
$route['obtenerSolbyFilter']['post'] = "formularioPermisos/AdminPermRest/obtenerSolbyFilter";
$route['obtenerReporteByFilter']['get'] = "formularioPermisos/AdminPermRest/obtenerReporteByFilter";
$route['desaprobarSolicitud']['post'] = "formularioPermisos/AdminPermRest/desaprobarSolicitud";
$route['aprobarSolicitud']['post'] = "formularioPermisos/AdminPermRest/aprobarSolicitud";
$route['obtenerAutorizador/(:any)']['get'] = "formularioPermisos/AdminPermRest/administracion/$1";

//SOLICITUDES POR USUARIO CIOM
$route['obtenerSolicitudes/idUsuario/(:num)']['get'] = "formularioPermisos/SolicitudesRest/index/$1";
$route['obtenerDetalle/formulario/(:any)/tipoSol/(:any)']['get'] = "formularioPermisos/SolicitudesRest/obtenerSolicitudDetalle/$1/$2";
$route['eliminar/formulario']['post'] = "formularioPermisos/SolicitudesRest/eliminarFormulario";
$route['imprimir/formulario']['post'] = "formularioPermisos/SolicitudesRest/imprimir";
$route['imprimir/formulario/(:any)/tipo/(:any)']['get'] = "formularioPermisos/SolicitudesRest/imprimir/$1/$2";

//Rutas Empresa
$route['empresa']['get'] = "solicitud/EmpresaRest/index";
$route['empresa/(:num)']['get'] = "solicitud/EmpresaRest/find/$1";
$route['empresa']['post'] = "solicitud/EmpresaRest/index";
$route['empresa/(:num)']['put'] = "solicitud/EmpresaRest/index/$1";
$route['empresa/(:num)']['delete'] = "solicitud/EmpresaRest/index/$1";
$route['sucursal']['get'] = "solicitud/EmpresaRest/find_sucursal";
$route['cargarDatos']['get'] = "solicitud/EmpresaRest/findDatos";