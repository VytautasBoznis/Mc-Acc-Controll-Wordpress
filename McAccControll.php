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
add_action('wp_enqueue_scripts', 'mcacc_register_scripts');

include 'log.php';

//Activation
function mcacc_install() {
   
    global $wpdb;
    
    $mcacc_default = array(
        'db_user' => 'mcgame',
        'db_pass' => 'Srr3ZaEq8PYyBhqh',
        'db_name' => 'mcgame',
        'db_host' => 'localhost',   
        'rcon_server' => '**********',
        'rcon_server_port' => 0,
        'rcon_server_pass' => '****',
        'log_level' => '3',
        'log_file' => 'orderLog.txt',
        'allow_login' => true,
        );
    
    update_option('mcacc_options',$mcacc_default);
    
    $table_name = $wpdb->prefix.'mcaccmng';
	
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql =   "CREATE TABLE ".$table_name." (
                    `id` bigint(20) NOT NULL AUTO_INCREMENT,
                    `webaccid` int(11) NOT NULL DEFAULT '0',
                    `mcacc` varchar(200) NOT NULL DEFAULT '',
                    `create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `modify_date` TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                    )".$charset_collate.";";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
    register_uninstall_hook(__FILE__, 'mcacc_uninstall');
}

//JavaScript register
function mcacc_register_scripts() {
    wp_register_script('user_panel_js', plugins_url('/user_panel.js',__FILE__));
}

include 'AdminPanel.php';
include 'user_widget.php';

add_shortcode('user_panel','show_user_panel');

function show_user_panel(){
    
    wp_enqueue_script('user_panel_js');
            
    echo('<button onclick="myFunction()">Try it</button>');
    echo("TEST!");
}

add_action( 'widgets_init', 'mcacc_register_user_widget' );

function mcacc_register_user_widget() {
    register_widget( 'user_widget' );
}
//Diactivation
function mcacc_uninstall(){
    
    delete_option('mcacc_options');
}
