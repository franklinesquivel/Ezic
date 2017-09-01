<?php
    /*
        Este Archivo es ejecutado diaramente - Según la configuración del Cron Jobs del servidor
    */
    require_once('Assistance_Class.php');
    require_once('Suspended_Class.php');
    require_once('Email_Class.php');
    $assistance = new Assistance();
    $suspended = new Suspended();
    $email = new Email();

    $schedules = $assistance->getSchedule();#Se obtiene el horario de todas las secciones
    if($schedules != false){
        $email->recordAssistance($assistance->checkAssistance(json_decode($schedules)));
    }

    #Chequea los estudiantes expulsados
    $suspended->ChangeState();
?>