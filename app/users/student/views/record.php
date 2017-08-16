<?php
    require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('S');
    $userRow = $const->getData('S');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ezic: Estudiante.</title>

    <link rel="shortcut icon" type="image/png" href="../../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../../General_Files/materialize/css/materialize.css">
    <link rel="stylesheet" href="../../files/css/view_style.css">
    <link rel="stylesheet" href="../../files/css/s/style.css">

    <meta name="theme-color" content="#005ab4">
    <meta name="msapplication-navbutton-color" content="#005ab4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#005ab4">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>

    <script src="../../files/js/init.js" charset="utf-8"></script>
    <script src="../../files/js/Loader.js" charset="utf-8"></script>
    <script src="../../files/js/s/loadRecord.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?> 
        <nav class="top-nav blue darken-2">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Récord conductual</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main></main>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="print"> 
        <input type="hidden" name="printRecord" value="1">
        <input type="hidden" name="id" value="<?php echo $userRow['idStudent'] ?>">
    </form>

    <div class="fixed-action-btn vertical">
        <a class="btn-floating btn-large blue darken-2" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Descargar"><a class="btn-floating blue lighten-2 btnPrint"><i class="material-icons">file_download</i></a></li>
            <li title="Información"><a class="btn-floating amber btnInfo"><i class="material-icons">info_outline</i></a></li>
        </ul>
    </div>
    
    <div class="tap-target blue darken-2" data-activates="info">
        <div class="tap-target-content white-text">
            <h5>Acerca de este apartado:</h5>
            <p class="white-text"></p>
        </div>
    </div>
</body>
</html>
