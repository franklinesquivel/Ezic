<?php
    require_once("../../../../General_Files/php/classes/Schedule.php");
    require_once '../../../../General_Files/php/classes/Administration.php';
     require_once '../../../../General_Files/php/classes/Grade_Class.php';

    $schedule = new Schedule();
    $administration = new administration();
    $grade = new Grade();

    if (isset($_REQUEST['loadSchedule'])) {
    	session_start();
        echo $schedule->loadSchedule('S', $_SESSION['id']);
    }

    if (isset($_REQUEST['getRecord'])) {
    	session_start();
    	echo $administration->conductRecord($_SESSION['id']);
    }

    if (isset($_REQUEST['getGrades'])) {
        session_start();
        echo json_encode($grade->getGrades($_SESSION['id']));
    }
?>
