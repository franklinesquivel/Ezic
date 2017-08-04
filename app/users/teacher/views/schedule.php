<?php
    require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('T');
    $userRow = $const->getData('T');
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ezic: Docente.</title>

    <link rel="shortcut icon" type="image/png" href="../../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../../General_Files/materialize/css/materialize.css">
    <link rel="stylesheet" href="../../files/css/view_style.css">
    <link rel="stylesheet" href="../../files/css/t/style.css">

    <meta name="theme-color" content="#167e1a">
    <meta name="msapplication-navbutton-color" content="#167e1a">
    <meta name="apple-mobile-web-app-status-bar-style" content="#167e1a">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>
    <script src="../../files/js/init.js" charset="utf-8"></script>
    <script src="../../files/js/Loader.js" charset="utf-8"></script>
    <script src="../../files/js/t/loadSchedule.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?>
        <nav class="top-nav green darken-2">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Ver horario</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <ul id="user_nav" class="side-nav fixed">
            <li>
                <div class="userView">
                    <div class="background">
                        <img src="../../files/img/teacher.jpg" width="100%">
                    </div>
                    <img class="circle" src="../../files/profile_photos/<?php echo $userRow['photo']; ?>">
                    <span class="white-text name"><?php echo explode(' ', $userRow['name'])[0] . " " . explode(' ', $userRow['lastName'])[0]; ?></span>
                    <span class="white-text email">Docente</span>
                </div>
            </li>
            <li><a href="../" class="waves-effect">Inicio<i class="material-icons">home</i></a></li>
            <li class="active"><a href="../views/schedule.php" class="waves-effect">Ver horario<i class="material-icons">schedule</i></a></li>
            <li><a href="../views/assistance.php" class="waves-effect">Asistencia<i class="material-icons">date_range</i></a></li>
            <li><a href="../views/addGrade.php" class="waves-effect">Agregar Notas<i class="material-icons">grade</i></a></li>
            <li><a class="subheader">Cuenta</a></li>
            <li><a href="#!" class="waves-effect">Configuración<i class="material-icons">settings</i></a></li>
            <li><div class="divider"></div></li>
            <li><a class="waves-effect btnUnlog"><i class="material-icons">cancel</i>Cerrar Sesión</a></li>
        </ul>
    </header>
    
    <main></main>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" target="_blank" id="print"> 
        <input type="hidden" name="printSchedule" value="1">
        <input type="hidden" name="type" value="T">
        <input type="hidden" name="id" value="<?php echo $userRow['idTeacher'] ?>">
    </form>
    
    <div class="fixed-action-btn vertical">
        <a class="btn-floating btn-large green darken-2" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Descargar"><a class="btn-floating green lighten-2 btnPrint"><i class="material-icons">file_download</i></a></li>
            <li title="Información"><a class="btn-floating amber btnInfo"><i class="material-icons">info_outline</i></a></li>
        </ul>
    </div>
    
    <div class="tap-target green darken-2" data-activates="info">
        <div class="tap-target-content white-text">
            <h5>Acerca de este apartado:</h5>
            <p class="white-text">Visualiza el horario que se te ha asignado! Puedes descargarlo sí lo necesitas. 😝</p>
        </div>
    </div>
</body>
</html>
