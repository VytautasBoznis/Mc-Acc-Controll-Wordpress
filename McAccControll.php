<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name: Mc Acc Controll
Plugin URI: http://mc.skilas.lt
Description: Vartotojo sasaja Mc serverio acc valdimui
Version: 0.0.1
Author: Vytautas
Author URI: http://skilas.lt
License: Private
Text Domain: Mc Acc Controll
*/

register_activation_hook( __FILE__, 'mcacc_install' );

include 'log.php';

//Activation
function mcacc_install() {
   
    $mcacc_default = array(
        'db_user' => 'mcgame',
        'db_pass' => 'Srr3ZaEq8PYyBhqh',
        'db_name' => 'mcgame',
        'db_host' => 'localhost',   
        'rcon_server' => '**.**.**.***',
        'rcon_server_port' => 25575,
        'rcon_server_pass' => '*****',
        'log_level' => '3',
        'log_file' => 'orderLog.txt',
        );
    
    update_option('mcacc_options',$mcacc_default);
    
    register_uninstall_hook(__FILE__, 'mcacc_uninstall');
}

include 'AdminPanel.php';

//Diactivation
function mcacc_uninstall(){
    
    
    delete_option('mcacc_options');
}
