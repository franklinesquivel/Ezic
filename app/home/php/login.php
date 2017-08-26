<?php
    require_once("../../../General_Files/php/classes/User_Class.php");
    require_once("../../../General_Files/php/classes/Email_Class.php");

    

    $user = new Users();
    $email =  new Email();

    if(isset($_REQUEST['code'])){
        $code = $_REQUEST['code'];
        $pass = $_REQUEST['pass'];
        $type = $_REQUEST['type'];
        echo ($user->Log($code, $pass, $type));
    }
    
    if(isset($_REQUEST['recover_password'])){

        $password = $user->getPassword($_REQUEST['type_user'], $_REQUEST['code_user']);
        
        if($password != false){
            echo($email->SendNewPassword($password[1], $password[0]));
        }else{
            echo "0";
        }
    }
?>
