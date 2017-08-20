<?php
    require_once("../../../../General_Files/php/classes/Schedule.php");
    require_once '../../../../General_Files/php/classes/Administration.php';
     require_once '../../../../General_Files/php/classes/Grade_Class.php';

    $schedule = new Schedule();
    $administration = new administration();
    $grade = new Grade();

    if (isset($_REQUEST['loadSchedule'])) {
        if (!isset($_SESSION)) {
        	session_start();
        }
        echo $schedule->loadSchedule('S', $_SESSION['id']);
    }

    if (isset($_REQUEST['getRecord'])) {
        if (!isset($_SESSION)) {
        	session_start();
        }
    	echo $administration->conductRecord($_SESSION['id']);
    }

    if (isset($_REQUEST['getGrades'])) {
        if (!isset($_SESSION)) {
            session_start();
        }
        echo json_encode($grade->getGrades($_SESSION['id']));
    }
?>
