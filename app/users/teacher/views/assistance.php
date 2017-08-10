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
    <script src="../../files/js/t/assistance.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?>
        <nav class="top-nav green darken-2">

            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Asistencia</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>
    
    <main class="show">
       
        <br><br>
        <div class="container">

            <div class="list">
            </div>
        </div>

        <div class="fixed-action-btn vertical btn_options">
            <a class="btn-floating btn-large green darken-2" id="info">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li title="Llegada Tardía"><a class="btn-floating red late_all"><i class="material-icons">access_alarm</i></a></li>
                <li title="Refrescar"><a class="btn-floating orange darken-1 refresh"><i class="material-icons">cached</i></a></li>
                <li title="Todos Asistieron"><a class="btn-floating blue check_all"><i class="material-icons">done_all</i></a></li>
                <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
            </ul>  
        </div>

        <div class="tap-target green" data-activates="info">
            <div class="tap-target-content">
                <h5>Acerda de este apartado:</h5>
                <p>Se muestra la sección correspondiente al horario para que se pase lista. Así mismo el apartado tiene en cuenta los permisos previos y el estado conductual de los alumnos</p>
            </div>
        </div>
    </main>

    <div id="applyCode" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 class="center">Aplicar Código</h4>
            <p class="center" style="font-size: 1.2em;"><span class="apply-id"></span>  -  <span class="apply-name"></span></p>
            <br>
            <div class="row">
                
                <select id="cmbCategory" class="col l5 m5 s10 offset-l1 offset-m1 offset-s1">
                    <option selected disabled>Categoría</option>
                </select>

                <select id="cmbType" class="col l5 m5 s10 offset-s1">
                    <option selected disabled>Tipo</option>
                </select>

                <select id="cmbCodes" class="col l10 m10 s10 offset-l1 offset-m1 offset-s1">
                    <option selected disabled>Código</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <div class="waves-effect btn green white-text btnApplyCode" style="margin-left: 2%;">Aplicar <i class="material-icons right">thumb_up</i></div>
            <div class="modal-action modal-close waves-effect btn red white-text">Cancelar <i class="material-icons right">cancel</i></div>
        </div>
    </div>
</body>
</html>