<?php
    session_start();
    require_once __DIR__ .'/config/configdb.php';

    if(!isset($_GET["c"])) $_GET["c"] = constant("CONTROLADOR_DEFECTO");
    if(!isset($_GET["m"])) $_GET["m"] = constant("METODO_DEFECTO");

    // Ruta del Controlador
    $rutaControlador = __DIR__ .'/controllers/'.$_GET['c'].'.php';
    require_once $rutaControlador;
    $controladorNombre = $_GET['c'];
    $controlador = new $controladorNombre();

    $metodo = $_GET['m'];

    $datos = $controlador->$metodo();

    // NOS DARÁ EL MENSAJE QUE LE LLEGUE DESDE EL CONTROLADOR
    $mensajeError = isset($controlador->mensaje) ? $controlador->mensaje : '';

    //ESTO NOS PERMITE QUE LAS VISTAS EJECTADAS PUEDAN SER PHP Y HTML
    $cuerpoPHP = __DIR__ . '/views/' . $controlador->view . '.php';
    $cuerpoHTML = __DIR__ . '/views/' . $controlador->view . '.html';

    //SOLICITA LA CABECERA POR DEFECTO
    require_once __DIR__ .'/views/template/header.php';

    //COMPRUEBA LOS TIPOS DE VISTAS
    if (file_exists($cuerpoPHP)) {
        require_once $cuerpoPHP;
    } elseif (file_exists($cuerpoHTML)) {
        require_once $cuerpoHTML;
    } else {
        require_once __DIR__ . '/views/vError404.php';
    }

    //SOLICITA EL PIE DE PAGINA POR DEFECTO
    require_once __DIR__ .'/views/template/footer.html';
?>
