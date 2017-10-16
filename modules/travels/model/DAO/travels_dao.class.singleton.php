<?php
class travels_dao {
    static $_instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function create_travels_DAO($db, $arrArgument) {

        $idviaje = $arrArgument['idviaje'];
        $destino = $arrArgument['destino'];
        $provincia = $arrArgument['destino_provincia'];
        $ciudad = $arrArgument['destino_ciudad'];
        $precio = $arrArgument['precio'];
        $oferta = $arrArgument['oferta'];
        $tipo = $arrArgument['tipo'];
        $f_sal = $arrArgument['f_sal'];
        $f_lleg = $arrArgument['f_lleg'];
        $avatar = $arrArgument['avatar'];


        $crucero = 0;
        $tour = 0;
        $visita = 0;

        foreach ($tipo as $indice) {
            if ($indice === 'Crucero')
                $crucero = 1;
            if ($indice === 'Tour')
                $tour = 1;
            if ($indice === 'Visita')
                $visita = 1;
        }
 
        $sql = "INSERT INTO products (referencia, pais, provincia, ciudad, precio, oferta,"
                . " tipo, f_sal, f_lleg, avatar"
                . " ) VALUES ('$idviaje', '$destino', '$provincia', '$ciudad', '$precio',"
                . " '$oferta', '$tipo', '$f_sal', '$f_lleg', '$avatar')";
               

        return $db->ejecutar($sql);
        
    }

    public function obtain_countries_DAO($url){
          $ch = curl_init();
          curl_setopt ($ch, CURLOPT_URL, $url);
          curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
          $file_contents = curl_exec($ch);

          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);
          $accepted_response = array(200, 301, 302);
          if(!in_array($httpcode, $accepted_response)){
            return FALSE;
          }else{
            return ($file_contents) ? $file_contents : FALSE;
          }
    }

    public function obtain_provinces_DAO(){
          $json = array();
          $tmp = array();

          $provincias = simplexml_load_file(RESOURCES.'provinciasypoblaciones.xml');
          $result = $provincias->xpath("/lista/provincia/nombre | /lista/provincia/@id");
          for ($i=0; $i<count($result); $i+=2) {
            $e=$i+1;
            $provincia=$result[$e];

            $tmp = array(
              'id' => (string) $result[$i], 'nombre' => (string) $provincia
            );
            array_push($json, $tmp);
          }
              return $json;

    }

    public function obtain_cities_DAO($arrArgument){
          $json = array();
          $tmp = array();

          $filter = (string)$arrArgument;
          $xml = simplexml_load_file(RESOURCES.'provinciasypoblaciones.xml');
          $result = $xml->xpath("/lista/provincia[@id='$filter']/localidades");

          for ($i=0; $i<count($result[0]); $i++) {
              $tmp = array(
                'poblacion' => (string) $result[0]->localidad[$i]
              );
              array_push($json, $tmp);
          }
          return $json;
    }
}
