<?php

/*
 * Author: Andrius Božnis
 * Company www.skilas.lt
 * Date: 2013.07.20 
 */

/**
 * Description of dbConnect
 *
 * @author andriusb
 * 
 * Klase skirta sukurti vieną vienintelį konektiona visam pluginui
 */

require_once 'log.php';
require_once 'config_infusion.php';
require_once('../../../wp-load.php');

define('WP_USE_THEMES', false);
 
class dbConnect {
    
    protected static $instance = null;
    public $DB = null;
    protected $loging = null;
 
    protected function __construct()
    {
        $settings = get_option('votesys_options');

        
        $this->loging=log::getInstance();
        $this->DB = new mysqli($settings['db_host'],$settings['db_user'],$settings['db_pass'],$settings['db_name']);
                
        if ($this->DB->connect_error)
        {
            $this->loging->log("dbConnect:constructor nepavyko prisijungti prie DB, ".$this->DB->connect_error,1);
            die($this->DB->connect_error);
        }         
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function select($query){
        $Result = $this->DB->query($query);
        return $Result;
    }
}

?>
