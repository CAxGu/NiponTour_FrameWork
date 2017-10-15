<?php
//SITE_ROOT
$path = $_SERVER['DOCUMENT_ROOT'] . '/2ndoDAW/NiponTour_FrameWork/';
define('SITE_ROOT', $path);

//SITE_PATH
define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . '/2ndoDAW/NiponTour_FrameWork/');

//CSS
define('CSS_PATH', SITE_PATH . 'view/css/');

//JS
define('JS_PATH', SITE_PATH . 'view/js/');

//IMG
define('IMG_PATH', SITE_PATH . 'view/img/');

/*
//log
define('USER_LOG_DIR', SITE_ROOT . 'log/user/Site_User_errors.log');
define('GENERAL_LOG_DIR', SITE_ROOT . 'log/general/Site_General_errors.log');

define('PRODUCTION', true);
*/

//model
define('MODEL_PATH', SITE_ROOT . 'model/');
//view
define('VIEW_PATH_INC', SITE_ROOT . 'view/inc/');
define('VIEW_PATH_INC_ERROR', SITE_ROOT . 'view/inc/templates_error/');
//modules
define('MODULES_PATH', SITE_ROOT . 'modules/');
//resources
define('RESOURCES', SITE_ROOT . 'resources/');
//media
define('MEDIA_PATH', SITE_ROOT . 'media/');
//utils
define('UTILS', SITE_ROOT . 'utils/');

//model travels
define('FUNCTIONS_TRAVELS', SITE_ROOT . 'modules/travels/utils/');
define('MODEL_PATH_TRAVELS', SITE_ROOT . 'modules/travels/model/');
define('DAO_TRAVELS', SITE_ROOT . 'modules/travels/model/DAO/');
define('BLL_TRAVELS', SITE_ROOT . 'modules/travels/model/BLL/');
define('MODEL_TRAVELS', SITE_ROOT . 'modules/travels/model/model/');
define('TRAVELS_JS_PATH', SITE_PATH . 'modules/travels/view/js/');


//model products
define('UTILS_PRODUCTS', SITE_ROOT . 'modules/products/utils/');
define('PRODUCTS_JS_LIB_PATH', SITE_PATH . 'modules/products/view/lib/');
define('PRODUCTS_JS_PATH', SITE_PATH . 'modules/products/view/js/');
define('MODEL_PATH_PRODUCTS', SITE_ROOT . 'modules/products/model/');
define('DAO_PRODUCTS', SITE_ROOT . 'modules/products/model/DAO/');
define('BLL_PRODUCTS', SITE_ROOT . 'modules/products/model/BLL/');
define('MODEL_PRODUCTS', SITE_ROOT . 'modules/products/model/model/');


//amigables
define('URL_AMIGABLES', TRUE);
