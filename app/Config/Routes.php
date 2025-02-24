<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/prueba', 'Home::prueba');

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/admin', 'Admin::index', ['filter' => 'auth:admin']);


$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->post('/loginSubmit', 'Auth::loginSubmit');
$routes->post('/registerSubmit', 'Auth::registerSubmit');
$routes->get('/logout', 'Auth::logout');




// Rutas para el controlador de items
$routes->get('/items', 'ItemController::index', ['filter' => 'auth:2']); // Leer
$routes->get('/items/create', 'ItemController::create', ['filter' => 'auth:1']); // Crear
$routes->post('/items/store', 'ItemController::store', ['filter' => 'auth:1']); // Crear
$routes->get('/items/edit/(:num)', 'ItemController::edit/$1', ['filter' => 'auth:3']); // Actualizar
$routes->post('/items/update/(:num)', 'ItemController::update/$1', ['filter' => 'auth:3']); // Actualizar
$routes->get('/items/delete/(:num)', 'ItemController::delete/$1', ['filter' => 'auth:4']); // Eliminar

$routes->group('otro', function($routes) {
   
});

// Rutas para el controlador de usuarios
$routes->get('/users', 'UserController::index', ['filter' => 'auth:6']); // Leer
$routes->get('/users/create', 'UserController::create', ['filter' => 'auth:5']); // Crear
$routes->post('/users/store', 'UserController::store', ['filter' => 'auth:5']); // Crear
$routes->get('/users/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth:7']); // Actualizar
$routes->post('/users/update/(:num)', 'UserController::update/$1', ['filter' => 'auth:7']); // Actualizar
$routes->get('/users/delete/(:num)', 'UserController::delete/$1', ['filter' => 'auth:8']); // Eliminar


$routes->get('/user/permissions', 'UserController::viewPermissions', ['filter' => 'auth']);

$routes->get('/admin/role_permissions', 'RolePermissionController::index', ['filter' => 'auth']);
$routes->post('/admin/assignPermission', 'RolePermissionController::assignPermission', ['filter' => 'auth']);
$routes->post('/admin/removePermission', 'RolePermissionController::removePermission', ['filter' => 'auth']);

$routes->get('/almacenes', 'AlmacenesController::index');
$routes->get('/almacenes/crear', 'AlmacenesController::crear');
$routes->post('/almacenes/guardar', 'AlmacenesController::guardar');
$routes->get('/almacenes/editar/(:num)', 'AlmacenesController::editar/$1');
$routes->post('/almacenes/actualizar/(:num)', 'AlmacenesController::actualizar/$1');

$routes->get('/inventario', 'InventarioController::index');
$routes->get('/inventario/crear', 'InventarioController::crear');
$routes->post('/inventario/guardar', 'InventarioController::guardar');
$routes->get('/inventario/editar/(:num)', 'InventarioController::editar/$1');
$routes->post('/inventario/actualizar/(:num)', 'InventarioController::actualizar/$1');

$routes->get('/materiaprimas', 'MateriaPrimaController::index');
$routes->get('/materiaprimas/crear', 'MateriaPrimaController::crear');
$routes->post('/materiaprimas/guardar', 'MateriaPrimaController::guardar');
$routes->get('/materiaprimas/editar/(:num)', 'MateriaPrimaController::editar/$1');
$routes->post('/materiaprimas/actualizar/(:num)', 'MateriaPrimaController::actualizar/$1');

// $routes->get('/bom', 'BillOfMaterialsController::index');
// $routes->get('/bom/crear', 'BillOfMaterialsController::crear');
// $routes->post('/bom/guardar', 'BillOfMaterialsController::guardar');
// $routes->get('/bom/editar/(:num)', 'BillOfMaterialsController::editar/$1');
// $routes->post('/bom/actualizar/(:num)', 'BillOfMaterialsController::actualizar/$1');


// $routes->get('/cotizaciones', 'CotizacionController::index');
// $routes->get('/cotizaciones/crear', 'CotizacionController::crear');
// $routes->post('/cotizaciones/guardar', 'CotizacionController::guardar');
// $routes->get('/cotizaciones/enviar/(:num)', 'CotizacionController::enviar/$1');
// $routes->get('/cotizaciones/actualizarEstado/(:num)/(:any)', 'CotizacionController::actualizarEstado/$1/$2');
// $routes->get('/cotizaciones/historial', 'CotizacionController::historial');
// $routes->get('/cotizaciones/reporte', 'CotizacionController::reporte');
// $routes->get('/ordenes_venta', 'OrdenVentaController::index');
// $routes->get('/ordenes_venta/crearDesdeCotizacion/(:num)', 'OrdenVentaController::crearDesdeCotizacion/$1');


// $routes->get('/empleados', 'EmpleadosController::index');
// $routes->get('/empleados/crear', 'EmpleadosController::crear');
// $routes->post('/empleados/guardar', 'EmpleadosController::guardar');
// $routes->get('/empleados/eliminar/(:num)', 'EmpleadosController::eliminar/$1');

// $routes->get('/empleados/editar/(:num)', 'EmpleadosController::editar/$1');
// $routes->post('/empleados/actualizarDatosPersonales/(:num)', 'EmpleadosController::actualizarDatos/$1');
// $routes->post('/empleados/actualizarDireccion/(:num)', 'EmpleadosController::actualizarDireccion/$1');
// $routes->post('/empleados/actualizarContacto/(:num)', 'EmpleadosController::actualizarContacto/$1');


$routes->get('/departamentos', 'DepartamentosController::index');
$routes->get('/departamentos/listar', 'DepartamentosController::listar');
$routes->post('/departamentos/guardar', 'DepartamentosController::guardar');
$routes->get('/departamentos/eliminar/(:num)', 'DepartamentosController::eliminar/$1');
$routes->post('/departamentos/actualizar/(:num)', 'DepartamentosController::actualizar/$1');

// Rutas para el controlador de puestos
$routes->get('/puestos', 'PuestosController::index');
$routes->get('/puestos/listar', 'PuestosController::listar');
$routes->post('/puestos/guardar', 'PuestosController::guardar');
$routes->get('/puestos/eliminar/(:num)', 'PuestosController::eliminar/$1');
$routes->post('/puestos/actualizar/(:num)', 'PuestosController::actualizar/$1');


$routes->get('/salarios', 'SalariosController::index');
$routes->get('/salarios/listar', 'SalariosController::listar');
$routes->get('/salarios/listarEmpleados', 'SalariosController::listarEmpleados');
$routes->post('/salarios/guardar', 'SalariosController::guardar');
$routes->get('/salarios/eliminar/(:num)', 'SalariosController::eliminar/$1');
$routes->get('/salarios/actualizar/(:num)', 'SalariosController::actualizar/$1');



$routes->get('/stock', 'InventarioController::index');



$routes->group('categoria_producto_terminado', function($routes) {
    $routes->get('/', 'CategoriaProductoTerminadoController::index');
    $routes->get('crear', 'CategoriaProductoTerminadoController::crear');
    $routes->post('guardar', 'CategoriaProductoTerminadoController::guardar');
    $routes->get('editar/(:num)', 'CategoriaProductoTerminadoController::editar/$1');
    $routes->post('actualizar/(:num)', 'CategoriaProductoTerminadoController::actualizar/$1');
});

$routes->group('producto_terminado', function($routes) {
    $routes->get('/', 'ProductoTerminadoController::index');
    $routes->get('crear', 'ProductoTerminadoController::crear');
    $routes->post('guardar', 'ProductoTerminadoController::guardar');
    $routes->get('editar/(:num)', 'ProductoTerminadoController::editar/$1');
    $routes->post('actualizar/(:num)', 'ProductoTerminadoController::actualizar/$1');
    $routes->get('detalle/(:num)', 'ProductoTerminadoController::detalle/$1');
    $routes->get('buscar', 'ProductoTerminadoController::buscar'); 
});

$routes->group('inventario_producto_terminado', function($routes) {
    $routes->get('/', 'InventarioProductoTerminadoController::index');
    $routes->get('crear', 'InventarioProductoTerminadoController::crear');
    $routes->post('guardar', 'InventarioProductoTerminadoController::guardar');
    $routes->get('editar/(:num)', 'InventarioProductoTerminadoController::editar/$1');
    $routes->post('actualizar/(:num)', 'InventarioProductoTerminadoController::actualizar/$1');
});

$routes->group('estacion_trabajo', function($routes) {
    $routes->get('/', 'EstacionTrabajoController::index');
    $routes->get('crear', 'EstacionTrabajoController::crear');
    $routes->post('guardar', 'EstacionTrabajoController::guardar');
    $routes->get('editar/(:num)', 'EstacionTrabajoController::editar/$1');
    $routes->post('actualizar/(:num)', 'EstacionTrabajoController::actualizar/$1');
});

$routes->group('tarea', function($routes) {
    $routes->get('/', 'TareaController::index');
    $routes->get('crear', 'TareaController::crear');
    $routes->post('guardar', 'TareaController::guardar');
    $routes->get('editar/(:num)', 'TareaController::editar/$1');
    $routes->post('actualizar/(:num)', 'TareaController::actualizar/$1');
});

$routes->group('empleado_estacion_trabajo', function($routes) {
    $routes->get('/', 'EmpleadoEstacionTrabajoController::index');
    $routes->get('crear', 'EmpleadoEstacionTrabajoController::crear');
    $routes->post('guardar', 'EmpleadoEstacionTrabajoController::guardar');
    $routes->get('editar/(:num)', 'EmpleadoEstacionTrabajoController::editar/$1');
    $routes->post('actualizar/(:num)', 'EmpleadoEstacionTrabajoController::actualizar/$1');
});

$routes->group('producto_estacion', function($routes) {
    $routes->get('/', 'ProductoEstacionController::index');
    $routes->get('asignar/(:num)', 'ProductoEstacionController::asignar/$1');
    $routes->post('guardarAsignacion', 'ProductoEstacionController::guardarAsignacion');
    $routes->get('verEstaciones/(:num)', 'ProductoEstacionController::verEstaciones/$1');
});

$routes->group('tareas_produccion', function($routes) {
    $routes->get('/', 'TareasProduccionController::index');
    $routes->get('cargarEstaciones/(:num)', 'TareasProduccionController::cargarEstaciones/$1');
    $routes->get('verTareas/(:num)/(:num)', 'TareasProduccionController::verTareas/$1/$2');
    $routes->post('nuevaTarea', 'TareasProduccionController::nuevaTarea');
    $routes->get('getEstacionProducto/(:num)/(:num)', 'TareasProduccionController::getEstacionProducto/$1/$2'); 
    $routes->get('cargarMateriasPrimas/(:num)', 'TareasProduccionController::cargarMateriasPrimas/$1');
    $routes->post('agregarMateriaPrima', 'TareasProduccionController::agregarMateriaPrima');
    $routes->delete('eliminarMateriaPrima/(:num)', 'TareasProduccionController::eliminarMateriaPrima/$1');

      
});

$routes->group('tiempos_produccion', function($routes) {
    $routes->get('/', 'TiemposProduccionController::index');
    $routes->get('detalle/(:num)', 'TiemposProduccionController::detalle/$1');
    $routes->post('actualizar/(:num)', 'TiemposProduccionController::actualizar/$1');
});
$routes->group('bom', function($routes) {
    $routes->get('/', 'BomController::index');
    $routes->get('obtenerDetalles/(:num)', 'BomController::obtenerDetalles/$1');
});


$routes->group('formatos_fecha', function($routes) {
    $routes->get('/', 'FormatoFechaController::index');
    $routes->post('guardar', 'FormatoFechaController::guardar');
});

$routes->group('formatos_moneda', function($routes) {
    $routes->get('/', 'FormatoMonedaController::index');
    $routes->post('guardar', 'FormatoMonedaController::guardar');
});

$routes->group('idiomas', function($routes) {
    $routes->get('/', 'IdiomaController::index');
    $routes->post('guardar', 'IdiomaController::guardar');
});

$routes->group('configuracion', function($routes) {
    $routes->get('/', 'ConfiguracionController::index');
    $routes->post('actualizar', 'ConfiguracionController::actualizar');
});

$routes->group('clientes', function($routes) {
    $routes->get('/', 'ClientesController::index');
    $routes->get('agregar', 'ClientesController::agregar');
    $routes->post('guardar', 'ClientesController::guardar');
    $routes->get('editar/(:num)', 'ClientesController::editar/$1');
    $routes->post('actualizar/(:num)', 'ClientesController::actualizar/$1');
    $routes->get('eliminar/(:num)', 'ClientesController::eliminar/$1');
    $routes->get('detalles/(:num)', 'ClientesController::detalles/$1');
    
    // Rutas para contactos
    $routes->post('guardarContacto', 'ClientesController::guardarContacto');
    $routes->get('obtenerContactos/(:num)', 'ClientesController::obtenerContactos/$1');

    // Rutas para direcciones de entrega
    $routes->post('guardarDireccion', 'ClientesController::guardarDireccion');
    $routes->get('obtenerDirecciones/(:num)', 'ClientesController::obtenerDirecciones/$1');

    // Rutas para información bancaria
    $routes->post('guardarBanco', 'ClientesController::guardarBanco');
    $routes->get('obtenerBancos/(:num)', 'ClientesController::obtenerBancos/$1');

    // Rutas para precios personalizados
    $routes->post('guardarPrecio', 'ClientesController::guardarPrecio');
    $routes->get('obtenerPrecios/(:num)', 'ClientesController::obtenerPrecios/$1');
});

$routes->group('suplidores', function($routes) {
    $routes->get('/', 'SuplidoresController::index');
    $routes->get('agregar', 'SuplidoresController::agregar');
    $routes->post('guardar', 'SuplidoresController::guardar');
    $routes->get('editar/(:num)', 'SuplidoresController::editar/$1');
    $routes->post('actualizar/(:num)', 'SuplidoresController::actualizar/$1');
    $routes->get('eliminar/(:num)', 'SuplidoresController::eliminar/$1');
    $routes->get('detalles/(:num)', 'SuplidoresController::detalles/$1');

    // Rutas para contactos
    $routes->post('guardarContacto', 'SuplidoresController::guardarContacto');
    $routes->get('obtenerContactos/(:num)', 'SuplidoresController::obtenerContactos/$1');

    // Rutas para direcciones de entrega
    $routes->post('guardarDireccion', 'SuplidoresController::guardarDireccion');
    $routes->get('obtenerDirecciones/(:num)', 'SuplidoresController::obtenerDirecciones/$1');

    // Rutas para información bancaria
    $routes->post('guardarBanco', 'SuplidoresController::guardarBanco');
    $routes->get('obtenerBancos/(:num)', 'SuplidoresController::obtenerBancos/$1');

    // Rutas para eliminar
    $routes->post('eliminarContacto', 'SuplidoresController::eliminarContacto');
    $routes->post('eliminarDireccion', 'SuplidoresController::eliminarDireccion');
    $routes->post('eliminarBanco', 'SuplidoresController::eliminarBanco');
});

$routes->group('ordenes-compra', function($routes) {
    $routes->get('/', 'OrdenCompraController::index');
    $routes->post('guardar', 'OrdenCompraController::guardarOrdenCompra');
    $routes->post('getMateriaPrimaDetails', 'OrdenCompraController::getMateriaPrimaDetails');
});

$routes->group('cotizaciones', function($routes) {
    $routes->get('/', 'CotizacionesController::index');
    $routes->get('crear', 'CotizacionesController::crear');
    $routes->post('guardar', 'CotizacionesController::guardar');
    $routes->get('detalle/(:num)', 'CotizacionesController::detalle/$1');
});


$routes->group('facturas', function($routes) {
    $routes->get('/', 'FacturasController::index');
    $routes->get('crear', 'FacturasController::crear');
    $routes->post('guardar', 'FacturasController::guardar');
});

$routes->group('ordenes_produccion', function($routes) {
    $routes->get('/', 'OrdenesProduccionController::index');
    $routes->get('crear', 'OrdenesProduccionController::crear');
    $routes->post('guardar', 'OrdenesProduccionController::guardar');
});

$routes->group('inventario', function($routes) {
    $routes->get('/', 'InventarioController::index');
    $routes->get('actualizar', 'InventarioController::actualizar');
    $routes->post('guardarActualizacion', 'InventarioController::guardarActualizacion');
});
$routes->group('empleados', function($routes) {
    $routes->get('/', 'EmpleadosController::index');
    $routes->get('crear', 'EmpleadosController::crear');
    $routes->post('guardar', 'EmpleadosController::guardar');
    $routes->get('editar/(:num)', 'EmpleadosController::editar/$1');
    $routes->get('eliminar/(:num)', 'EmpleadosController::eliminar/$1');

    $routes->post('actualizarDatos/(:num)', 'EmpleadosController::actualizarDatos/$1');

    $routes->post('actualizarDireccion/(:num)', 'EmpleadosController::actualizarDireccion/$1');

    $routes->post('actualizarContacto/(:num)', 'EmpleadosController::actualizarContacto/$1');
    $routes->post('guardarMovimiento/(:num)', 'EmpleadosController::guardarMovimiento/$1');
    // $routes->get('descuentos/(:num)', 'EmpleadosController::descuentos/$1');
    $routes->post('guardarDescuento/(:num)', 'EmpleadosController::guardarDescuento/$1');

    // Rutas para incentivos
    $routes->get('incentivos', 'EmpleadosController::incentivos');
    $routes->post('guardarIncentivo', 'EmpleadosController::guardarIncentivo');
    $routes->post('eliminarIncentivo/(:num)', 'EmpleadosController::eliminarIncentivo/$1');


    // Rutas para préstamos
    $routes->get('prestamos/(:num)', 'EmpleadosController::prestamos/$1');
    $routes->post('guardarPrestamo/(:num)', 'EmpleadosController::guardarPrestamo/$1');

    // Rutas para incentivos recurrentes
    $routes->get('incentivosRecurrentes', 'EmpleadosController::incentivosRecurrentes');
    $routes->post('guardarIncentivoRecurrente', 'EmpleadosController::guardarIncentivoRecurrente');
    $routes->post('eliminarIncentivoRecurrente/(:num)', 'EmpleadosController::eliminarIncentivoRecurrente/$1');

    //Rutas para descuentos
   
    $routes->get('descuentos', 'EmpleadosController::descuentos');
    $routes->post('guardarDescuento', 'EmpleadosController::guardarDescuento');
    $routes->post('eliminarDescuento/(:num)', 'EmpleadosController::eliminarDescuento/$1');
 
    $routes->get('descuentosRecurrentes', 'EmpleadosController::descuentosRecurrentes');
    $routes->post('guardarDescuentoRecurrente', 'EmpleadosController::guardarDescuentoRecurrente');
    $routes->post('eliminarDescuentoRecurrente/(:num)', 'EmpleadosController::eliminarDescuentoRecurrente/$1');
});

$routes->group('nomina', function($routes) {
    $routes->get('/', 'NominaController::index');
    $routes->post('generar', 'NominaController::generar');
    $routes->get('obtenerPeriodosDisponibles', 'NominaController::obtenerPeriodosDisponibles');
    $routes->get('ver/(:num)', 'NominaController::ver/$1');
    $routes->get('calcular/(:num)', 'NominaController::calcular/$1');
    $routes->post('agregarEmpleados', 'NominaController::agregarEmpleados');
    $routes->get('obtenerEmpleados', 'NominaController::obtenerEmpleados');
    $routes->post('agregarDetalleManual', 'NominaController::agregarDetalleManual');
    $routes->post('eliminarEmpleado', 'NominaController::eliminarEmpleado');
    $routes->get('obtenerEmpleadosNominaActual/(:num)', 'NominaController::obtenerEmpleadosNominaActual/$1');
    $routes->get('pruebas', 'NominaController::pruebas');
    $routes->get('reciboPago/(:num)/(:num)', 'NominaController::reciboPago/$1/$2');
    $routes->post('marcarEmpleadoCompletado/(:num)', 'NominaController::marcarEmpleadoCompletado/$1');
    $routes->post('marcarNominaCompletada/(:num)', 'NominaController::marcarNominaCompletada/$1');
    
    $routes->get('reportePagos/(:num)', 'NominaController::reportePagos/$1');
    $routes->get('reportePagos/(:num)(/(:any))', 'NominaController::reportePagos/$1/$2');
});





// $routes->group('descuentos', function($routes) {
//     $routes->get('/', 'DescuentosController::index');
//     $routes->post('guardarDisponible', 'DescuentosController::guardarDisponible');
// });


