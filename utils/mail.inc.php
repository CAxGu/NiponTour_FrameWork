<?php
  function send_mailgun($email){//name,email,subject,message

   $config = array();
   $config['api_key'] = "key-7627d6ac6cc9ac85ede68822acd6ee28"; //API Key
   $config['api_url'] = "https://api.mailgun.net/v2/sandboxc43dabcf6b5143449d65956b31081985.mailgun.org/messages"; //API Base URL

   $message = array();
   $message['from'] = $email["inputEmail"];
   $message['to'] =  $email["inputEmail"];
   $message['h:Reply-To'] = "nipontourpruebas@gmail.com";
   $message['subject'] = $email["inputSubject"];
   $message['html'] = 'Hello ' .  $email["inputName"] . ', This is your message: <br><br>' .  $email["inputMessage"];


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
?>