<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('WP_USE_THEMES', false);
require_once('../../../wp-load.php');



class mcaccList{
    public $query;    
    
    public function __construct() {
        global $wpdb;

        $this->query="SELECT * FROM ".$wpdb->prefix."mcaccmng";
    }

    function getMcUsersStr($webId) {
        global $wpdb;

        $res = "NO_DATA";
        $result = $wpdb->query($this->query.' where `webaccid` = \''.$webId.'\'');
        if (!$result) {
            return $res;
        }else{
            $res="[";
            while ($data = dbarray($result)) {
                $res.= $data["mcacc"].",";
            }
            $res=rtrim($res, ",");
            $res.="]";
        }
        return $res;
    }

    function getMcUsers($webId){
        global $wpdb;

        $res=array();
        $result = $wpdb->query($this->query.' where `webaccid` = '.$webId);
        if (!$result) {
            return $res;
        }else{
            while ($data = dbarray($result)) {
                $res[]= $data["mcacc"];
            }
        }
        return $res;
    }
    
    function hasWebMc($webId,$mcUser){
        $users = $this->getMcUsers($webId);
        
        if (in_array($mcUser,$users))
            return TRUE;
        else
            return FALSE;
    }
    
    function leaseToOwner($oldId,$newId,$mcUser){
        global $wpdb;
        
        if ($this->hasWebMc($oldId,$mcUser)){
            $q="UPDATE ".$wpdb->prefix."mcaccmng SET `webaccid`='".$newId;
            $q.="' where `webaccid`='".$oldId."' and `mcacc`='".$mcUser."'";
            $result = $wpdb->query($q);
            if (!$result) {
                return FALSE;
            }else{
                return TRUE;
            }
        }
        return FALSE;
    }
    
    function deleteMcUser($webId,$mcUser){
        global $wpdb;
        
        if ($this->hasWebMc($oldId,$mcUser)){
            
            $q="DELETE FROM ".$wpdb->prefix."mcaccmng";
            $q.=" where `webaccid`='".$webId."' and `mcacc`='".$mcUser."'";
            $result = $wpdb->query($q);
            if (!$result) {
                return FALSE;
            }else{
                return TRUE;
            }
        }
        return FALSE;
    }
    
    function transfereVip($webId,$mcUserOld,$mcUserNew){
        global $wpdb;

        if ($this->hasWebMc($oldId,$mcUserOld)&&$this->hasWebMc($oldId,$mcUserNew)){
            
            $q="DELETE FROM ".$wpdb->prefix."mcaccmng";
            $q.=" where `webaccid`='".$webId."' and `mcacc`='".$mcUser."'";
            $result = $wpdb->query($q);
            if (!$result) {
                return FALSE;
            }else{
                return TRUE;
            }
        }
        return FALSE;
    }
}