<?php

if (!function_exists('obtener_configuracion')) {
    function obtener_configuracion()
    {
        static $configuracion = null;

        if ($configuracion === null) {
            $configModel = new \App\Models\ConfiguracionModel();
            $configuracion = $configModel
                ->select('configuracion.*, formatos_moneda.formato as formato_moneda, formatos_fecha.formato as formato_fecha, idiomas.codigo as idioma')
                ->join('formatos_moneda', 'configuracion.formato_moneda_id = formatos_moneda.id')
                ->join('formatos_fecha', 'configuracion.formato_fecha_id = formatos_fecha.id')
                ->join('idiomas', 'configuracion.idioma_id = idiomas.id')
                ->first();
        }
        
        return $configuracion;
    }
}

if (!function_exists('formatear_moneda')) {
    function formatear_moneda($cantidad)
    {
        $config = obtener_configuracion();
        
        if ($config && isset($config['formato_moneda'])) {
            $simbolo = $config['formato_moneda'];
        } else {
            $simbolo = '$';
        }
        
        return $simbolo . number_format($cantidad, 2, '.', ',');
    }
}

if (!function_exists('formatear_fecha')) {
    function formatear_fecha($fecha)
    {
        $config = obtener_configuracion();
        
        if ($config && isset($config['formato_fecha'])) {
            $formato = $config['formato_fecha'];
        } else {
            $formato = 'd/m/Y';
        }
        
        return date($formato, strtotime($fecha));
    }
}

if (!function_exists('nombre_empresa')) {
    function nombre_empresa()
    {
        $config = obtener_configuracion();
        
        return $config['nombre_empresa'] ?? 'Nombre de la Empresa No Definido';
    }
}

// Puedes crear más funciones de acceso rápido si lo deseas
if (!function_exists('direccion_empresa')) {
    function direccion_empresa()
    {
        $config = obtener_configuracion();
        
        return $config['direccion'] ?? 'Dirección No Definida';
    }
}

if (!function_exists('telefono_empresa')) {
    function telefono_empresa()
    {
        $config = obtener_configuracion();
        
        return $config['telefono'] ?? 'Teléfono No Definido';
    }
}

if (!function_exists('empresa_rnc')) {
    function empresa_rnc()
    {
        $config = obtener_configuracion();
        
        return $config['rnc'] ?? 'RNC No Definido';
    }
}


if (!function_exists('establecer_idioma')) {
    function establecer_idioma()
    {
        $config = obtener_configuracion();
        
        if ($config && isset($config['idioma'])) {
            $idioma = $config['idioma'];
        } else {
            $idioma = 'es'; // Valor predeterminado
        }
        
        // Establecer el idioma en CodeIgniter
        \Config\Services::language()->setLocale($idioma);
    }
}
