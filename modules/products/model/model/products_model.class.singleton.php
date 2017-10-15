<?php
class products_model {
    private $bll;
    static $_instance;
    
    private function __construct() {
        $this->bll = products_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }
    
    public function list_products() {
        return $this->bll->list_products_BLL();
    }

    public function count_products() {
        return $this->bll->count_products_BLL();
    }
 
    public function limit_products($values) {
        return $this->bll->limit_products_BLL($values);
    }
    
    public function details_product($id) {
        return $this->bll->details_product_BLL($id);
    }

}
