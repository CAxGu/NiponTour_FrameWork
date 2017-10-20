<?php
class controller_travels {
    function __construct() {
       
        include (FUNCTIONS_TRAVELS . "functions_travels.inc.php");
        include (UTILS . "upload.php");
        $_SESSION['module'] = "travels";
    }

    function form_travels() {
        require_once (VIEW_PATH_INC . "header.php");
        require_once (VIEW_PATH_INC . "menu.php");

        loadView('modules/travels/view/', 'create_travels.php');

        require_once (VIEW_PATH_INC . "footer.html");
    }

    function results_travels() {
        require_once (VIEW_PATH_INC . "header.php");
        require_once (VIEW_PATH_INC . "menu.php");

        loadView('modules/travels/view/', 'results_travels.php');

        require_once (VIEW_PATH_INC . "footer.html");
    }


    function upload_travels() {
        if ((isset($_POST["upload"])) && ($_POST["upload"] == true)) {
            $result_avatar = upload_files();
            $_SESSION['result_avatar'] = $result_avatar;
            echo debugPHP($_SESSION['result_avatar']);
        }
    }


    function alta_travels() {

        if ((isset($_POST['alta_travels_json']))){
        $jsondata = array();
        $travelsJSON = json_decode($_POST["alta_travels_json"], true);        
        $result = validate_travels($travelsJSON);
        
            if (empty($_SESSION['result_avatar'])) {
                $_SESSION['result_avatar'] = array('resultado' => true, 'error' => "", 'datos' => '/media/default-avatar.png');
            }
            $result_avatar = $_SESSION["result_avatar"];
        
            if (($result['resultado']) && ($result_avatar['resultado'])) {
                $arrArgument = array(
                    'idviaje' => $result['datos']['idviaje'],
                    'destino' => $result['datos']['destino'],
                    'destino_provincia' => $result['datos']['destino_provincia'],
                    'destino_ciudad' => $result['datos']['destino_ciudad'],
                    'precio' => $result['datos']['precio'],
                    'oferta' => $result['datos']['oferta'],
                    'tipo' => $result['datos']['tipo'],
                    'f_sal' => $result['datos']['f_sal'],
                    'f_lleg' => $result['datos']['f_lleg'],
                    'avatar' => $result_avatar['datos']
                );
        
                //////////////////////// INSER INTO DB
                $arrValue=false;
                try {
                    $arrValue = loadModel(MODEL_TRAVELS, "travels_model", "create_travels", $arrArgument);
                } catch (Exception $e) {
                    showErrorPage(2, "ERROR - 503 BD", 'HTTP/1.0 503 Service Unavailable', 503);
                }

                if ($arrValue)
                    $mensaje = "Su registro se ha efectuado correctamente, para finalizar compruebe que ha recibido un correo de validacion y siga sus instrucciones";
                else
                    $mensaje = "No se ha podido realizar su alta. Intentelo mas tarde";
        
                $_SESSION['travel'] = $arrArgument;
                $_SESSION['msje'] = $mensaje;
                $callback = "../../travels/results_travels/";

                $jsondata["success"] = true;
                $jsondata["redirect"] = $callback;
                echo json_encode($jsondata);
                exit;
            } else {

                $jsondata["success"] = false;
                $jsondata["error"] = $result["error"];
                $jsondata["error_avatar"] = $result_avatar["error"];
        
                $jsondata["success1"] = false;
                if ($result_avatar["resultado"]) {
                    $jsondata["success1"] = true;
                    $jsondata["img_avatar"] = $result_avatar["datos"];
                }
                header('HTTP/1.0 400 Bad error', true, 404);
                echo json_encode($jsondata);
                //exit;
            }
        }
    }


    //////////////////////////////////////////////////////////////// delete
    function delete_travels(){

       if (isset($_POST["delete"]) && $_POST["delete"] == true) {
            $_SESSION['result_avatar'] = array();
            $result = remove_files();
            if ($result === true) {
                echo json_encode(array("res" => true));
            } else {
                echo json_encode(array("res" => false));
            }
        }
    }


    //////////////////////////////////////////////////////////////// load

    function load_travels(){

        if (isset($_POST["load"]) && $_POST["load"] == true) {
            $jsondata = array();
            if (isset($_SESSION['travel'])) {
                //echo debug($_SESSION["user"]);
                $jsondata["travel"] = $_SESSION['travel'];
            }
            if (isset($_SESSION["msje"])) {
                //echo $_SESSION["msje"];
                $jsondata["msje"] = $_SESSION['msje'];
            }
            close_session();
            echo json_encode($jsondata);
            exit;
        }
    }

    /////////////////////////////////////////////////// load_data

    function load_data_travels(){
        
        if ((isset($_POST["load_data"])) && ($_POST["load_data"] == true)) {
            $jsondata = array();
            if (isset($_SESSION['travel'])) {
                $jsondata["travel"] = $_SESSION['travel'];
                echo json_encode($jsondata);
                exit;
            } else {
                $jsondata["travel"] = "";
                echo json_encode($jsondata);
                exit;
            }
        }
    }

    /////////////////////////////////////////////////// load_country
    function load_countries_travels(){

        //if ((isset($_POST["load_country"])) && ($_POST["load_country"] == true)) {
       // if (isset($_POST["load_country"])) {
            $json = array();
            $url = 'http://www.oorsprong.org/websamples.countryinfo/CountryInfoService.wso/ListOfCountryNamesByName/JSON';
        
            try {
                //throw new Exception();
                $json = loadModel(MODEL_TRAVELS, "travels_model", "obtain_countries", $url);
            } catch (Exception $e) {
                $json = array();
            }

            if($json){
                echo $json;
                exit;
            }else{
                $json = "error";
                echo $json;
                exit;
            }
        }
    //}


    /////////////////////////////////////////////////// load_provinces
    function load_provinces_travels(){
        if ((isset($_POST["load_provinces"])) && ($_POST["load_provinces"] == true)) {
            $jsondata = array();
            $json = array();
        
            try {
                $json = loadModel(MODEL_TRAVELS, "travels_model", "obtain_provinces");
            } catch (Exception $e) {
                $json = array();
            }
        
            if($json){
                $jsondata["provinces"] = $json;
                echo json_encode($jsondata);
                exit;
            }else{
                $jsondata["provinces"] = "error";
                echo json_encode($jsondata);
                exit;
            }
        }
    }


    /////////////////////////////////////////////////// load_cities
    function load_towns_travels(){
        if(  isset($_POST['idPoblac']) ){
            $jsondata = array();
            $json = array();
    
            try{
                $json = loadModel(MODEL_TRAVELS, "travels_model", "obtain_cities", $_POST['idPoblac']);
            }catch (Exception $e){
                
            }
        
            if($json){
                $jsondata["cities"] = $json;
                echo json_encode($jsondata);
                exit;
            }else{
                $jsondata["cities"] = "error";
                echo json_encode($jsondata);
                exit;
            }
        }
    }

}
