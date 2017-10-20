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

    
    function loadDetailproducts(){

        require_once(VIEW_PATH_INC ."header.php");
        require_once(VIEW_PATH_INC ."menu.php");

        loadView('modules/products/view/','detail_product.php');
        
        require_once(VIEW_PATH_INC ."footer.html");
    }


    function id_details_products(){

        if (isset($_POST["loadproduct"]) && ($_POST["loadproduct"]==true)) {
            
            $idtravel = $_POST['id'];
            $travelData = loadModel(MODEL_PRODUCTS, "products_model", "details_product",$idtravel);
           // unset($_SESSION['product']);  
            $_SESSION['product']=$travelData ; 
            
                            if(! $travelData){
                                header('view/inc/404.php');
                            }
                    }

   }


    function details_products(){

         if (isset($_POST["idproduct"]) && ($_POST["idproduct"]==true)) {
    
            $travelValue = $_SESSION['product'];        

                if($travelValue){
                    echo json_encode ($travelValue);  
                }else{
                    header('view/inc/404.php');
                }
            }

   }


}
