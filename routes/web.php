<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/Convenios/{paginaActual}/{sentido}', array(
//     'as' => 'ConvenioPaginate',
//     'uses' => 'ConvenioController@PaginacionConvenio'
// ));

/*
Route::get('/', function () {
    return view('welcome');
});
*/
//Route::resourses('Usuarios'=>'UsuarioController');
//Route::get('/','UsuarioController@index');
// Route::get('/','InicioController@index');
Route::get('/', array(
    'as' => 'Inicio',
    'uses' => 'InicioController@index'
));

Route::get('/InicioClaro', array(
    'as' => 'InicioClaro',
    'uses' => 'InicioController@indexclaro'
));

// Route::post('/seguridad/logout',array(
Route::get('/logout',array(
    'uses' => 'AuthController@logout',
    'as' => 'logout'
));

Route::get('/logoutClaro',array(
    'uses' => 'AuthController@logoutClaro',
    'as' => 'logoutClaro'
));

// Route::group(['middleware' => 'auth', 'namespace' => 'jugueteria'], function(){
    
//     Route::get('/Usuarios', array(
//     'as' => 'Usuarios',
//     'uses' => 'UsuarioController@getIndex'
//     ));

//     Route::get('/Juguete','JugueteController@index');
// });

 Route::get('/Usuarios', array(
    'as' => 'Usuarios',
    'uses' => 'UsuarioController@getIndex'
    ));

Route::get('/Juguete', array(
    'as' => 'Juguete',
    'uses' => 'JugueteController@index'
    ));

Route::post('/Juguete/galeria', array(
// Route::get('/Juguete/galeria', array(
    'as' => 'Juguete',
    'uses' => 'JugueteController@galeria'
    ));

// Route::get('/Convenio/CargarJuguetesConvenio', array(
//     'as' => 'CargarJuguetesConvenio',
//     'uses' => 'ConvenioController@CargarJuguetesConvenio'
//     ));

Route::get('/Convenio/FiltroJuguetes/{Texto}/{IdEmpresa}', array(
    'as' => 'FiltroJuguetes',
    'uses' => 'ConvenioController@FiltroJuguetes'
    ));

//Autenticacion
Route::get('/login','AuthController@login');
// Route::post('/login',[
//     'uses' => 'AuthController@login',
//     'as' => 'login'
// ]);


Route::get('/inicio/menu',[
    'as' => 'indexMenu',
    'uses' => 'InicioController@indexMenu'
]);

Route::get('/inicio/menuClaro',[
    'as' => 'indexMenuClaro',
    'uses' => 'InicioController@indexMenuClaro'
]);


Route::post('/CambiarContrasena',[
    'uses' => 'UsuarioController@CambiarContrasena',
    'as' => 'CambiarContrasena'
]);

Route::get('/Contrasena/FormRecuperar',[
    'uses' => 'UsuarioController@FormRecuperar',
    'as' => 'FormRecuperarContrasena'
]);

//Rutas Usuarios
Route::post('/RegistrarUsuario',[
    'uses' => 'UsuarioController@store',
    'as' => 'CrearUsuario'
]);

Route::post('/EditarUsuario',[
    'uses' => 'UsuarioController@edit',
    'as' => 'EditarUsuario'
]);

Route::get('/Usuario/datatableListUsuario', array(
    'as' => 'datatableListUsuario',
    'uses' => 'UsuarioController@datatableListUsuario'
));

Route::post('/Usuario/CambiaEstadoUsuario',[
    'as' => 'cambiaEstado',
    'uses' => 'UsuarioController@cambiaEstadoUsuario'
]);

Route::post('/usuario/postStore',[
    'as' => 'StoreUsuario',
    'uses' => 'UsuarioController@postStore'
]);

Route::get('/usuario/postFormusuario',[
    'as' => 'postFormusuario',
    'uses' => 'UsuarioController@postFormusuario'
]);

Route::post('/usuario/postFormusuario',[
    'as' => 'postFormusuario',
    'uses' => 'UsuarioController@postFormusuario'
]);

//Rutas Juguetes

//Route::resources(['juguete'=> 'JugueteController']);
//Route::resources(['juguete'=> 'JugueteController']);
//Route::post('/juguete/postFormJuguete','JugueteController@postFormJuguete');
// Route::resource(['juguete'=> 'JugueteController'])
// ->except([
//     'postStore', 'datatableListJuguete'
// ]);

Route::get('/juguete/postFormjuguete', array(
    'as' => 'postFormjuguete',
    'uses' => 'JugueteController@postFormjuguete'
));
Route::post('/juguete/postStore',[
    'as' => 'postStore',
    'uses' => 'JugueteController@postStore'
]);

Route::post('/juguete/postFormjuguete', array(
    'as' => 'postFormjuguete',
    'uses' => 'JugueteController@postFormjuguete'
));

Route::get('/juguete/datatableListJuguete', array(
    'as' => 'datatableListJuguete',
    'uses' => 'JugueteController@datatableListJuguete'
));


Route::post('/juguete/cambiaEstado',[
    'as' => 'cambiaEstado',
    'uses' => 'JugueteController@cambiaEstado'
]);

Route::post('/empleado/cambiaEstado',[
    'as' => 'cambiaEstado',
    'uses' => 'EmpleadoController@cambiaEstado'
]);

// Route::get('/Empleado','EmpleadoController@index');
Route::get('/Empleado/Index/{Id}', array(
    'as' => 'Empleado',
    'uses' => 'EmpleadoController@index'
));

Route::get('/Empleado/IndexEmpleado/{Id}', array(
// Route::get('/Empleado/IndexEmpleado', array(
    'as' => 'IndexEmpleado',
    'uses' => 'EmpleadoController@IndexEmpleado'
));

Route::get('/Empleado/IndexEmpleadoClaro/{Id}', array(
// Route::get('/Empleado/IndexEmpleado', array(
    'as' => 'IndexEmpleadoClaro',
    'uses' => 'EmpleadoController@IndexEmpleadoClaro'
));

Route::get('/empleado/postFormempleado', array(
    'as' => 'postFormempleado',
    'uses' => 'EmpleadoController@postFormempleado'
));
Route::post('/empleado/postStore',[
    'as' => 'postStore',
    'uses' => 'EmpleadoController@postStore'
]);

Route::post('/empleado/eliminarEmpleado',[
    'as' => 'eliminarEmpleado',
    'uses' => 'EmpleadoController@eliminarEmpleado'
]);

Route::post('/empleado/postFormempleado', array(
    'as' => 'postFormempleado',
    'uses' => 'EmpleadoController@postFormempleado'
));

Route::get('/empleado/postFormempleadoAct', array(
    'as' => 'postFormempleadoAct',
    'uses' => 'EmpleadoController@postFormempleadoAct'
));

Route::get('/empleado/datatableListEmpleado', array(
    'as' => 'datatableListEmpleado',
    'uses' => 'EmpleadoController@datatableListEmpleado'
));


Route::post('/empleado/Masivoempleado',[
    'as' => 'Masivoempleado',
    'uses' => 'EmpleadoController@Masivoempleado'
]);

Route::post('/empleado/postStoremasivos',[
    'as' => 'postStoremasivos',
    'uses' => 'EmpleadoController@postStoremasivos'
]);
Route::post('/empleado/GuardarTxt',[
    'as' => 'GuardarTxtEmp',
    'uses' => 'EmpleadoController@GuardarTxt'
]);

Route::post('/empleado/GuardarNovedad',[
    'as' => 'GuardarNovedad',
    'uses' => 'EmpleadoController@GuardarNovedad'
]);

Route::post('/empleado/ConfirmarDatosEmpleado',[
    'as' => 'ConfirmarDatosEmpleado',
    'uses' => 'EmpleadoController@ConfirmarDatosEmpleado'
]);

Route::post('/HijoEmpleado/Index',[
    'as' => 'Index',
    'uses' => 'HijoEmpleadoController@index'
]);

Route::post('/HijoEmpleado/eliminarHijo',[
    'as' => 'eliminarHijo',
    'uses' => 'HijoEmpleadoController@eliminarHijo'
]);

Route::get('/HijoEmpleado/datatableListEmpleadoHijo', array(
    'as' => 'datatableListEmpleadoHijo',
    'uses' => 'HijoEmpleadoController@datatableListEmpleadoHijo'
));


Route::post('/HijoEmpleado/postForm/',[
    'as' => 'postForm',
    'uses' => 'HijoEmpleadoController@postForm'
]);

Route::post('/HijoEmpleado/postStore/',[
    'as' => 'postStore',
    'uses' => 'HijoEmpleadoController@postStore'
]);

Route::post('/HijoEmpleado/cambiaEstado/',[
    'as' => 'cambiaEstado',
    'uses' => 'HijoEmpleadoController@cambiaEstado'
]);

//Rutas correos
Route::get('/registro/verificacion/{CodigoConf}', array(
    'as' => 'verificacion',
    'uses' => 'UsuarioController@VerificarUsuario'
));

Route::post('/Contrasena/EmailRecuperarContrasena', array(
    'as' => 'EmailRecuperar',
    'uses' => 'UsuarioController@EnviarRecuperarContrasena'
));

Route::get('/Contrasena/RecuperarContrasena/{CodigoConf}', array(
    'as' => 'RecuperarContrasena',
    'uses' => 'UsuarioController@RecuperarContrasena'
));

Route::post('/Contrasena/RecuperarCambiarContrasena', array(
    'as' => 'RecuperarCambiarContrasena',
    'uses' => 'UsuarioController@RecuperarCambiarContrasena'
));

Route::post('/pedidoEmpleado/ReenvioCorreos', array(
    'as' => 'ReenvioCorreos',
    'uses' => 'PedidoEmpleadoController@ReenvioCorreos'
));

Route::get('/Galeria/getGaleriaImg', array(
    'as' => 'getGaleriaImg',
    'uses' => 'GaleriaImgController@getGaleriaImg'
));


Route::post('/Galeria/GuardarImg', array(
    'as' => 'GuardarImg',
    'uses' => 'GaleriaImgController@GuardarImg'
));


Route::post('/Galeria/CargarContenedorImg', array(
    'as' => 'CargarContenedorImg',
    'uses' => 'GaleriaImgController@CargarContenedorImg'
));


// Rutas Empresa:
Route::get('/Empresa','EmpresaController@index');
Route::get('/empresa/IndexEmpresa/{Id}', array(
    'as' => 'IndexEmpresa',
    'uses' => 'EmpresaController@IndexEmpresa'
));


Route::get('/empresa/postFormempresa', array(
    'as' => 'postFormempresa',
    'uses' => 'EmpresaController@postFormempresa'
));
Route::post('/empresa/postStore',[
    'as' => 'postStore',
    'uses' => 'EmpresaController@postStore'
]);

Route::post('/empresa/eliminarEmpresa',[
    'as' => 'eliminarEmpresa',
    'uses' => 'EmpresaController@eliminarEmpresa'
]);

Route::post('/empresa/postFormempresa', array(
    'as' => 'postFormempresa',
    'uses' => 'EmpresaController@postFormempresa'
));

Route::get('/empresa/datatableListEmpresa', array(
    'as' => 'datatableListEmpresa',
    'uses' => 'EmpresaController@datatableListEmpresa'
));

Route::post('/empresa/cambiaEstado',[
    'as' => 'cambiaEstado',
    'uses' => 'EmpresaController@cambiaEstado'
]);
Route::post('/empresa/Masivoempresa',[
    'as' => 'Masivoempresa',
    'uses' => 'EmpresaController@Masivoempresa'
]);

Route::post('/empresa/postStoremasivos',[
    'as' => 'postStoremasivos',
    'uses' => 'EmpresaController@postStoremasivos'
]);

Route::post('/empresa/GuardarTxt',[
    'as' => 'GuardarTxt',
    'uses' => 'EmpresaController@GuardarTxt'
]);

Route::post('/Galeria/EliminaRegistro',[
    'as' => 'EliminaRegistro',
    'uses' => 'GaleriaImgController@EliminaRegistro'
]);

Route::post('/empresa/SubirlogoEmpresa',[
    'as' => 'SubirlogoEmpresa',
    'uses' => 'EmpresaController@SubirlogoEmpresa'
]);

Route::post('/empresa/postStoreLogo',[
    'as' => 'postStoreLogo',
    'uses' => 'EmpresaController@postStoreLogo'
]);

// Rutas convenio 

Route::get('/convenio/IndexListConvenio/{Id}', array(
    'as' => 'IndexListConvenio',
    'uses' => 'ConvenioController@IndexListConvenio'
));

Route::post('/convenio/postStore',[
    'as' => 'postStore',
    'uses' => 'ConvenioController@postStore'
]);

Route::post('/convenio/eliminarConvenio',[
    'as' => 'eliminarConvenio',
    'uses' => 'ConvenioController@eliminarConvenio'
]);

Route::post('/convenio/EditarConvenio',[
    'as' => 'EditarConvenio',
    'uses' => 'ConvenioController@EditarConvenio'
]);

Route::post('/convenio/EliminarJugueteConvenio',[
    'as' => 'EliminarJugueteConvenio',
    'uses' => 'ConvenioController@EliminarJugueteConvenio'
]);

Route::get('/Convenios/{ID}', array(
    'as' => 'Convenio',
    'uses' => 'ConvenioController@Index'
));

Route::get('/convenio/getGaleriaImg', array(
    'as' => 'getGaleriaImg',
    'uses' => 'ConvenioController@getGaleriaImg'
));

Route::get('/convenio/datatableListConveniosXEmpresa/{Id}', array(
    'as' => 'datatableListConveniosXEmpresa',
    'uses' => 'ConvenioController@datatableListConveniosXEmpresa'
));

Route::post('/convenio/CargarDtlleConvenio',[
    'as' => 'CargarDtlleConvenio',
    'uses' => 'ConvenioController@CargarDtlleConvenio'
]);

Route::get('/convenio/CargarDtlleConvenio/{Id}',[
    'as' => 'CargarDtlleConvenio',
    'uses' => 'ConvenioController@CargarDtlleConvenio'
]);

Route::get('/convenio/DevolverStockConvenio/{IdConvenio}',[
    'as' => 'DevolverStockConvenio',
    'uses' => 'ConvenioController@DevolverStockConvenio'
]);


// Rutas PedidoEmpleado
Route::post('/pedidoEmpleado/postStorePedidoEmpleado',[
    'as' => 'postStorePedidoEmpleado',
    'uses' => 'PedidoEmpleadoController@postStore'
]);

Route::get('/empleado/validarConvenioVigente/{Id}/{IdHijo}',[
    'as' => 'validarConvenioVigente',
    'uses' => 'EmpleadoController@validarConvenioVigente'
]);

Route::get('/empleado/validarConvenioVigenteClaro/{Id}/{IdHijo}',[
    'as' => 'validarConvenioVigenteClaro',
    'uses' => 'EmpleadoController@validarConvenioVigenteClaro'
]);

// Route::get('/pedidoEmpleado/Index', array(
//     'as' => 'pedidoEmpleado',
//     'uses' => 'PedidoEmpleadoController@Index'
// ));

Route::get('/pedidoEmpleado/Index/{Id}', array(
    'as' => 'pedidoEmpleado',
    'uses' => 'PedidoEmpleadoController@Index'
));

Route::get('/pedidoEmpleado/IndexClaro/{Id}', array(
    'as' => 'pedidoEmpleadoClaro',
    'uses' => 'PedidoEmpleadoController@IndexClaro'
));

Route::get('/pedidoEmpleado/Index/CargarPedidoEmpleado/{Id}', array(
    'as' => 'CargarPedidoEmpleado',
    'uses' => 'PedidoEmpleadoController@CargarPedidoEmpleado'
));

Route::get('/pedidoEmpleado/Index/CargarPedidoEmpleadoClaro/{Id}', array(
    'as' => 'CargarPedidoEmpleado',
    'uses' => 'PedidoEmpleadoController@CargarPedidoEmpleadoClaro'
));

//Reportes
Route::get('Reportes','ReportesController@index');

Route::post('/Reportes/cargaConvenios',[
    'as' => 'cargaConvenios',
    'uses' => 'ReportesController@cargaConvenios'
]);
Route::get('/Reportes/generaDescarga',[
    'as' => 'generaDescarga',
    'uses' => 'ReportesController@generaDescarga'
]);

Route::get('/Reportes/datatableList', array(
    'as' => 'datatableList',
    'uses' => 'ReportesController@datatableList'
));