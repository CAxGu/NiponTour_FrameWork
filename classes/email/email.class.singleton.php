<?php
    //require(LIBS . 'PHPMailer_v5.1/class.phpmailer.php');
    //require(LIBS . 'PHPMailer_v5.1/class.smtp.php');
    
    class email {
        private $body;
        private $address;
        private $subject;
        private $mail;
        private $name;
        static $_instance;
    
        private function __construct() {
            try {
                //$this->mail = new PHPMailer();
                $this->mail = new phpmailer();
                $this->mail->IsSMTP();
    
                $cnfg = parse_ini_file("email.ini");
    
                $this->mail->SMTPAuth = $cnfg['auth'];
                $this->mail->SMTPSecure = $cnfg['secure'];
                $this->mail->Host = $cnfg['host'];
                $this->mail->Port = $cnfg['port'];
                $this->mail->Username = $cnfg['email'];
                $this->mail->Password = $cnfg['pass'];
                $this->mail->AddReplyTo($cnfg['email'], $cnfg['defaultsubject']);
                $this->mail->SetFrom($cnfg['email'], $cnfg['defaultsubject']);
                
                $this->subject="NIPON_TOUR";
    
            } catch (phpmailerException $e) {
                //echo $e->errorMessage();
                //$log = log::getInstance();
			   // $log->add_log_general("error construct email.class.singleton.php", $_GET['module'], "response ".http_response_code()); 
			   // $log->add_log_user("error construct email.class.singleton.php", "", $_GET['module'], "response ".http_response_code()); 
	
                throw new Exception();
            } catch (Exception $e) {
                //echo $e->getMessage();
               // $log = log::getInstance();
			   // $log->add_log_general("error construct email.class.singleton.php", $_GET['module'], "response ".http_response_code()); 
			   // $log->add_log_user("error construct email.class.singleton.php", "", $_GET['module'], "response ".http_response_code());
	
                throw new Exception();
            }
        }
    
        public static function getInstance() {
            if (!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;
        }
    
        public function __set($name, $value) {
            $this->$name = $value;
        }
    
        public function __get($name) {
            return $this->$name;
        }
    
        public function enviar() {
            try {
                $this->mail->Subject = $this->subject;
                $this->mail->MsgHTML($this->body);
                $this->mail->AddAddress($this->address, $this->name);
                $this->mail->IsHTML(true);
                
                $result = $this->send_mailgun($this->address);
                return $result;
                /*
                if($this->mail->Send()){
                    return 1;
                }else{
                    return 0;
                }
                */
            } catch (phpmailerException $e) {
               // $log = log::getInstance();
			   // $log->add_log_general("error enviar email.class.singleton.php", $_GET['module'], "response ".http_response_code()); 
			   // $log->add_log_user("error enviar email.class.singleton.php", "", $_GET['module'], "response ".http_response_code());
			    
                return 0;
            } catch (Exception $e) {
              //  $log = log::getInstance();
			   // $log->add_log_general("error enviar email.class.singleton.php", $_GET['module'], "response ".http_response_code()); 
			  //  $log->add_log_user("error enviar email.class.singleton.php", "", $_GET['module'], "response ".http_response_code());
			    
                return 0;
            }
        }
        
        public function send_mailgun($email){
        	$config = array();
        	$config['api_key'] = "key-cbfcf951300cced42894b02e9e447fc8"; //API Key
        	$config['api_url'] = "https://api.mailgun.net/v2/sandboxc43dabcf6b5143449d65956b31081985.mailgun.org/messages"; //API Base URL
    
        	$message = array();
        	$message['from'] = "nipontourpruebas@gmail.com";
        	$message['to'] = $email;
        	$message['h:Reply-To'] = "nipontourpruebas@gmail.com";
        	$message['subject'] = "Hello, this is a test";
        	$message['html'] = 'Hello ' . $email . ',</br></br> This is a test';
         
        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $config['api_url']);
        	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        	curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        	curl_setopt($ch, CURLOPT_POST, true); 
        	curl_setopt($ch, CURLOPT_POSTFIELDS,$message);
        	$result = curl_exec($ch);
        	curl_close($ch);
        	return $result;
        }
    }
