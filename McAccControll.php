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
        'rcon_server' => '62.80.237.198',
        'rcon_server_port' => 25575,
        'rcon_server_pass' => 'kemmpinukas',
        'log_level' => '3',
        'log_file' => 'orderLog.txt',
        );
    
    update_option('mcacc_options',$mcacc_default);
    
    register_uninstall_hook(__FILE__, 'mcacc_uninstall');
}

//Adding rewrite for virtual page (direct redirect to php file)
add_action( 'init', 'mcacc_init_internal' );

function mcacc_init_internal(){
    add_rewrite_rule('UserPanel.php$',plugin_dir_path( __FILE__ ).'UserPanel.php','top');
    
}

add_filter( 'query_vars', 'mcacc_query_vars' );
function mcacc_query_vars( $query_vars )
{
    $query_vars[] = 'mcacc_vars';
    return $query_vars;
}

add_action( 'parse_request', 'mcacc_parse_request' );
function mcacc_parse_request( &$wp )
{
    if ( array_key_exists( 'mcacc_vars', $wp->query_vars ) ) {
        include 'UserPanel.php$';
        exit();
    }
    return;
}
//rewrite done

include 'AdminPanel.php';

//Diactivation
function mcacc_uninstall(){
    
    delete_option('mcacc_options');
}
