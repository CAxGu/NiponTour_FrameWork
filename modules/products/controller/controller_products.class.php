<?php

 class controller_products{

    function __construct(){

        include(UTILS_PRODUCTS . "utils.inc.php");
        $_SESSION['module'] = "products";
    }


    function list_products(){

        require_once(VIEW_PATH_INC ."header.php");
        require_once(VIEW_PATH_INC ."menu.php");

        loadView('modules/products/view/','list_products.php');

        require_once(VIEW_PATH_INC ."footer.html");
    }


    function load_products(){
        
        $values=array();
        $items_per_group = 5;    
        $totalResults = loadModel(MODEL_PRODUCTS, "products_model", "count_products");   
        
        if (isset($_POST["load"]) && ($_POST["load"]==true)) { 
            
                $group_number=$_POST['group_no'];
                $position = ($group_number * $items_per_group);
                $values[0]=$position;
                $values[1]=$items_per_group;
                $limitResults = loadModel(MODEL_PRODUCTS, "products_model", "limit_products",$values);
                $result = array('totalresults' => $totalResults, 'limitresults' => $limitResults);
               
                if($limitResults){
                    echo json_encode ($result);    
                }else{
                    header('view/inc/404.php');
                }
            }

    }


    function load_detail_products(){
        require_once(VIEW_PATH_INC ."header.php");
        require_once(VIEW_PATH_INC ."menu.php");

        loadView('modules/products/view/','detail_product.php');
        
        require_once(VIEW_PATH_INC ."footer.html");
    }



    function load_data_products(){

        if (isset($_POST["loadtravel"]) && ($_POST["loadtravel"]==true)) {
            
            $idtravel = $_GET['idtravel'];
            $travelData = loadModel(MODEL_PRODUCTS, "products_model", "details_product",$idtravel);
            $_SESSION['travel']=$travelData ;
            $callback= loadView('modules/products/view/','detail_products.php');
            
            if($travelData){
                echo json_encode($callback);
            }else{
                header('view/inc/404.php');
            }
        }
    }



    function details_product(){

        if (isset($_POST["idtravel"]) && ($_POST["idtravel"]==true)) {
            
                $travelValue = $_SESSION['travel'];
            
                if($travelValue){
                    echo json_encode ($travelValue);  
                }else{
                    header('view/inc/404.php');
                }
            }

    }


}






/* 

session_start();
include ($_SERVER['DOCUMENT_ROOT'] . "/2ndoDAW/NiponTour_FrontEnd/utils/common.inc.php");


$path_model = $_SERVER['DOCUMENT_ROOT'] . "/2ndoDAW/NiponTour_FrontEnd/modules/products/model/model/";
$values=array();
$items_per_group = 5;
$totalResults = loadModel($path_model, "products_model", "count_products");

if (isset($_GET["load"]) && ($_GET["load"]==true)) { 

    $group_number=$_POST['group_no'];
    $position = ($group_number * $items_per_group);
    $values[0]=$position;
    $values[1]=$items_per_group;
    $limitResults = loadModel($path_model, "products_model", "limit_products",$values);
    $result = array('totalresults' => $totalResults, 'limitresults' => $limitResults);
   
    if($limitResults){
        echo json_encode ($result);    
    }else{
        header('view/inc/404.php');
    }
}

if (isset($_GET["loadtravel"]) && ($_GET["loadtravel"]==true)) {
    $idtravel = $_GET['idtravel'];
    $travelData = loadModel($path_model, "products_model", "details_product",$idtravel);
    $_SESSION['travel']=$travelData ;
    $callback='index.php?module=travels&view=detail_product';
    
    if($travelData){
        echo json_encode($callback);
    }else{
        header('view/inc/404.php');
    }
}

if (isset($_GET["idtravel"]) && ($_GET["idtravel"]==true)) {

    $travelValue = $_SESSION['travel'];

    if($travelValue){
        echo json_encode ($travelValue);  
    }else{
        header('view/inc/404.php');
    }
} */