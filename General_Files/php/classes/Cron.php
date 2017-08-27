<?php
    require_once 'Assistance_Class.php';
    require_once 'Suspended.php';
    require_once 'Email_Class.php';

    $email = new Email();
    $suspended = new Suspended();
    $assistance = new Assistance();

    $schedules = $assistance->getSchedule();#Se obtiene el horario de todas las secciones
    
    if($schedules){
        $assistance->checkAssistance(json_decode($schedules)); #Se obtiene las secciones en las cuales se paso lista
    }
?>