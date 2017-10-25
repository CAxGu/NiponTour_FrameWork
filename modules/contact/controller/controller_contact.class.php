<?php  
    class controller_contact { 
        
        public function __construct() {
		
			$_SESSION['module'] = "contact";	
        }

        public function view_contact() {
            require_once(VIEW_PATH_INC."header.php"); 
			require_once(VIEW_PATH_INC."menu.php");
            
            loadView(CONTACT_VIEW_PATH, 'contact.php');
            
            require_once(VIEW_PATH_INC."footer.html");
        }
        
        public function sendContact() {

            $jsondata = array();
            $email = json_decode($_POST["email_contact"], true);
            if($email){
                $emailJSON=send_mailgun($email);
                $jsondata['success'] = $emailJSON;
            }else{
            $jsondata['success'] = $emailJSON;
            }
            echo json_encode($jsondata);
        }
    }