<?php
require_once("paths.php");
require 'autoload.php';

include(UTILS . "utils.inc.php");
include(UTILS . "common.inc.php");
include(UTILS . "mail.inc.php");

session_start();
$_SESSION['module'] = "";

function handlerRouter() {

    if (!empty($_GET['module'])) {
        $URI_module = $_GET['module'];
    } else {
        $URI_module = 'main';
    }

    if (!empty($_GET['function'])) {
        $URI_function = $_GET['function'];
    } else {
        $URI_function = 'begin';
    }
    handlerModule($URI_module, $URI_function);
}

function handlerModule($URI_module, $URI_function) {
    $modules = simplexml_load_file('resources/modules.xml');
    $exist = false;

    foreach ($modules->module as $module) {
        if (($URI_module === (String) $module->uri)) {

            $exist = true;

            $path = MODULES_PATH . $URI_module . "/controller/controller_" . $URI_module . ".class.php";
            
            if (file_exists($path)) {
                require_once($path);
                $controllerClass = "controller_" . $URI_module;
                $obj = new $controllerClass;
            } else {
                //die($URI_module . ' - Controlador no encontrado');
                require_once(VIEW_PATH_INC . "header.php");
                require_once(VIEW_PATH_INC . "menu.php");
                showErrorPage(1, "", 'HTTP/1.0 400 Bad Request', 400);
                require_once(VIEW_PATH_INC . "footer.html");
            }
            handlerfunction(((String) $module->name), $obj, $URI_function);
            break;
        }
    }
    if (!$exist) {
        //die($URI_module . ' - Controlador no encontrado');
        require_once(VIEW_PATH_INC . "header.php");
        require_once(VIEW_PATH_INC . "menu.php");
        showErrorPage(1, "", 'HTTP/1.0 400 Bad Request', 400);
        require_once(VIEW_PATH_INC . "footer.html");
    }
}

function handlerFunction($module, $obj, $URI_function) {

    $functions = simplexml_load_file(MODULES_PATH . $module . "/resources/functions.xml");
    $exist = false;

    foreach ($functions->function as $function) {
        if (($URI_function === (String) $function->uri)) {
            $exist = true;
            $event = (String) $function->name;
            break;
        }
    }
    if (!$exist) {
        //die($URI_function . ' - Funci&oacute;n no encontrada');
        require_once(VIEW_PATH_INC . "header.php");
        require_once(VIEW_PATH_INC . "menu.php");
        showErrorPage(1, "", 'HTTP/1.0 400 Bad Request', 400);
        require_once(VIEW_PATH_INC . "footer.html");
    } else {
        //$obj->$event();
        call_user_func(array($obj, $event));
    }
}

handlerRouter();
