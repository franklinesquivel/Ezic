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
    <script src="../../files/js/t/addJustification.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?>
        <nav class="top-nav green darken-2">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Agregar Justificación</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>
    
    <main>
        <br><br>
        <div class="container form">
        	
        </div>

        <div class="result container">
            
        </div>
    </main>
    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large green darken-2" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Regresar"><a disabled class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>
            <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>

    <div class="tap-target green darken-2" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>El profesor puede ingresar la descripción de los perfiles de evaluación según su materia.</p>
        </div>
    </div>
</body>
</html>