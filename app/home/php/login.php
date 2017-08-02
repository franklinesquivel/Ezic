<?php
    require_once("../../../General_Files/php/classes/User_Class.php");

    $code = $_REQUEST['code'];
    $pass = $_REQUEST['pass'];
    $type = $_REQUEST['type'];

    $user = new Users();
    echo ($user->Log($code, $pass, $type));
?>
