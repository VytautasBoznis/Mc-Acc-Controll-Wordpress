var xmlhttp=null;

function myFunction() {
    alert("I am an alert box!");
}

function initAjax(){
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
}

function tryAdd(user,pass){
    $.get("add.php",{'mcnick':user,'password':pass},function(data){
        if(data === "1"){
            //initPage();
            alert("MC žaidėjas sėkmingai pridėtas");
        }else{

            alert("Pridėti MC žaidėja nepavyko.\nNeteisingas Žaidėjo vardas arba slaptažodis!");
        }
            
    });
}

// puslapio inicializacija
$(function() {
    loadPage();
    initPage();
});}