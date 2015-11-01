<?php

add_action('admin_menu', 'mcacc_setup_menu');

function mcacc_setup_menu(){
    add_menu_page( 'Mc Acc Controll plugin', 'Mc Acc Controll', 'manage_options', 'mcacc_system_plugin', 'mcacc_main_manu_init' );
    add_submenu_page('mcacc_system_plugin', 'Funkciju valdymas', 'Funkciju valdymas', 'manage_options', 'edit_functions', 'mcacc_function_page_init');
}

//optionu tvarkimo langas
function mcacc_main_manu_init(){
    
    if(!isset($_POST['save_edit']))
    {
        mcacc_generate_option_form();
    }
    else
    {
        $settings = get_option('mcacc_options');
    
        $settings['db_user'] = $_POST['db_user'];
        $settings['db_pass'] = $_POST['db_pass'];
        $settings['db_name'] = $_POST['db_name'];
        $settings['db_host'] = $_POST['db_host'];
        $settings['rcon_server'] = $_POST['rcon_server'];
        $settings['rcon_server_port'] = $_POST['rcon_server_port'];
        $settings['rcon_server_pass'] = $_POST['rcon_server_pass'];
        $settings['log_level'] = $_POST['log_level'];
        $settings['log_file'] = $_POST['log_file'];
    
        update_option('mcacc_options',$settings);
        
        mcacc_generate_option_form();
    }
    
}

function mcacc_generate_option_form(){
    
    $settings = get_option('mcacc_options');
    echo "<h1>Mc Acc Controll</h1>";
    echo "<form action='".get_admin_url()."admin.php?page=mcacc_system_plugin' method='POST'>";
    echo "<input type='hidden' name='save_edit' value='1'>";
    echo "MC Duomenu bazes uzeris:<br>";
    echo "<input type='text' name='db_user' value='".$settings['db_user']."'><br><br>";
    echo "MC Duomenu bazes slaptazodis:<br>";
    echo "<input type='text' name='db_pass' value='".$settings['db_pass']."'><br><br>";
    echo "MC Duomenu bazes pavadinimas:<br>";
    echo "<input type='text' name='db_name' value='".$settings['db_name']."'><br><br>";
    echo "MC Duomenu bazes host:<br>";
    echo "<input type='text' name='db_host' value='".$settings['db_host']."'><br><br>";
    echo "Rcon Serveris:<br>";
    echo "<input type='text' name='rcon_server' value='".$settings['rcon_server']."'><br><br>";
    echo "Rcon Serveris Port:<br>";
    echo "<input type='text' name='rcon_server_port' value='".$settings['rcon_server_port']."'><br><br>";
    echo "Rcon Serveris slaptazodis:<br>";
    echo "<input type='text' name='rcon_server_pass' value='".$settings['rcon_server_pass']."'><br><br>";
    echo "Log Level:<br>";
    echo "<input type='number' name='log_level' value='".$settings['log_level']."'><br><br>";
    echo "Log File:<br>";
    echo "<input type='text' name='log_file' value='".$settings['log_file']."'><br><br>";
    
    echo "<input type='submit' value='Issaugoti'></form>";
}

function mcacc_function_page_init(){
    
    echo "online";
}