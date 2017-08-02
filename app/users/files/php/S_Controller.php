<?php
    require_once("../../../../General_Files/php/classes/Schedule.php");
    require_once '../../../../General_Files/php/classes/administration.php';

    $schedule = new Schedule();
    $administration = new administration();

    if (isset($_REQUEST['loadSchedule'])) {
    	session_start();
        echo $schedule->loadSchedule('S', $_SESSION['id']);
    }

    if (isset($_REQUEST['getRecord'])) {
    	session_start();
    	echo $administration->conductRecord($_SESSION['id']);
    }
?>
