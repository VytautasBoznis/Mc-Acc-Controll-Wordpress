<?php

/*
 * Author: Andrius Božnis
 * Company www.skilas.lt
 * Date: 2013.07.20 
 * 
 */

/**
 *  Klase skirta rinkti informaciaj apie plugine, turi logininmmo lygiu
 * nustatcius mezesni visi kuriu lygis didesnis nebebus rasomi i faila
 * 
 */

class log{
    
    protected static $instance = null;
    protected $config=null;    
    protected $loglevel=null;
    protected $logFile="";
    protected function __construct()
    {           
         $this->config=new config();         
         $this->loglevel=$this->config->logLevel;
         $this->logFile=$this->config->logFile;         
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function log($message,$level){
        if ($this->loglevel >= $level){
            $this->writeLog($message);
        }
    }
    
    private function writeLog($message){
        $logMessage=date('Y-m-d H:i:s').": ".$message."\r\n";
        file_put_contents ($this->logFile,$logMessage,FILE_APPEND);        
    }
}

