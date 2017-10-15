<?php

require (MODEL_PATH . "db.class.singleton.php");

class products_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = products_dao::getInstance();
        $this->db = Db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function list_products_BLL() {
        return $this->dao->list_products_DAO($this->db);
    }

    public function count_products_BLL() {
        return $this->dao->count_products_DAO($this->db);
    }

    public function limit_products_BLL($values) {
        return $this->dao->limit_products_DAO($this->db,$values);
    }

    public function details_product_BLL($id) {
        return $this->dao->details_product_DAO($this->db,$id);
    }
    
}

