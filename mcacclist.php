<?php

require_once 'dbConnect.php';

function mcacc_get_acc_list(){
    $mc_db = dbConnect::getInstance();
    
    if(!is_user_logged_in()){
        log("Neprisijunges vartotojas bando pasitikrinti savo acc ip: " . $_SERVER['REMOTE_ADDR']);
        return;
    }   
}

function mcacc_generate_acc_list_table(){
    echo "k";
}