<?php

require (MODEL_PATH . "db.class.singleton.php");

class travels_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = travels_dao::getInstance();
        $this->db = Db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_travels_BLL($arrArgument) {
        return $this->dao->create_travels_DAO($this->db, $arrArgument);
    }

    public function obtain_countries_BLL($url){
        return $this->dao->obtain_countries_DAO($url);
    }
  
    public function obtain_provinces_BLL(){
        return $this->dao->obtain_provinces_DAO();
    }
  
    public function obtain_cities_BLL($arrArgument){
        return $this->dao->obtain_cities_DAO($arrArgument);
    }
}
