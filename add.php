<?php
/**
 * Created by PhpStorm.
 * User: Andrius
 * Date: 14.1.21
 * Time: 19.22
 */


//require_once THEMES."templates/header.php";

require_once 'log.php';
require_once("dbConnect.php");
require_once('../../../wp-load.php');

define('WP_USE_THEMES', false);

$user=stripinput($_GET['mcnick']);
$pass=stripinput($_GET['password']);

$logging=log::getInstance();
//echo "user";

function checkPassword($password, $databasePassword)
{
    $tmp = explode('$', $databasePassword);
    $same = false;
    if(hash('sha256', hash('sha256', $password) . $tmp[2]) == $tmp[3])
    {
        $same = true;
    }
    return $same;
}

function checkuser($user,$pass){
    
    if (isset($user)){   
        $user=strip_tags($user);
        $connect=dbConnect::getInstance();
        
        if (PEAR::isError($connect->DB)) {
            echo $connect->DB->connect_error;
        }
        
        $query="SELECT `username`,`password` FROM `authme` WHERE `username` like '".$user."'";
        // WHERE nick like %".$user."%
        $res= $connect->DB->query($query);
        
        if (PEAR::isError($res)) {
            echo $res->error;
            return 1; //db error
        }
        
        //echo $connect->DB->getMessage();
        if(isset($res)){
            
            $rowCount=$res->numRows();
            if (PEAR::isError($rowCount)) {
                //echo "rowcount error";
                echo $rowCount->error;
                return 2; // rowcount error
            }
            
            //echo "start chesck row";
            if ($rowCount==0)
                return 3; //0 rows
            if ($rowCount>1 || $rowCount<=0){
                return 4; //there must be only one row
            }
            //echo $rowCount;
            $row=$res->fetchRow();
            if (!checkPassword($pass,$row[1])){            
                return 5; //password dont match
            }
            return 6;//user exist and pass match
        }
        return 0; //incorrect inputs
    }
}

function isAlreadyRgistered($user){
    global $wpdb;
    
    $query="Select * from ".$wpdb->prefix."mcaccmng where `mcacc` like '".$user."'";
    $result=dbquery($query);
    if (!$result) {
        return TRUE;
    }
    if (dbrows($result)!=0){
        return TRUE;
    }
    return FALSE;   
}

$userCheck=checkuser($user, $pass);
switch ($userCheck){
    case 0:
        echo -1;
        break;
    case 1:
        echo -2;
        break;
    case 2:
        echo -3;
        break;
    case 3:

    case 4:
    case 5:
        echo -6;
        break;
    case 6:
        if (!isAlreadyRgistered($user))
            {
            $query= "INSERT INTO ".DB_INFUSION_TABLE." (`webaccid`,`mcacc`) VALUES('".$userdata['user_id']."','".$user."')";
            $result = dbquery($query);
            if (!$result) {
            echo 0; // not added
            break;
            }else{
            echo 1; //added row
                break;
            }
            }
        echo -7;
        break;
    default:
        echo "ivyko klaida";
}
?>