<?php
	require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    /*Clase Subject - para obtener el nombre de las materias*/
    // require_once("../../../../General_Files/php/classes/Subject_Class.php");
    // $subject = new Subject();
    // $list_Subjects = $subject->getSubjects(); /* Se guarda el arreglo de materia*/

    /*Clase Periodos - para obtener los periodos*/
    // require_once("../../../../General_Files/php/classes/Period.php");
    // $period = new Period();
    // $NamesPeriods = $period->getPeriods();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#343434">
    <meta name="msapplication-navbutton-color" content="#343434">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343434">
    <title>Ezic: Coodinador.</title>

    <link rel="shortcut icon" type="image/png" href="../../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../../General_Files/materialize/css/materialize.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>

    <link rel="stylesheet" href="../../files/css/view_style.css">
    <link rel="stylesheet" href="../../files/css/c/style.css">

	<script src="../../files/js/init.js" charset="utf-8"></script>
    <script src="../../files/js/Loader.js" charset="utf-8"></script>
    <script src="../../files/js/c/addProfile.js" charset="utf-8"></script><!-- JS que se alterna -->
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Agregar Perfil de Evaluación</a></div>
            </div>
        </nav>
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>
    <main class="show"><!-- Formulario para añadir nuevo perfil de evaluacion -->
		
    </main>
    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large black" id="info">
                <i class="large material-icons">menu</i>
        </a>
        <ul>
            <!-- <li title="Refrescar"><a class="btn-floating green btnRefresh"><i class="material-icons">cached</i></a></li> -->
            <li title="Atrás" ><a class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>

            <li title="Seleccionar Todo"><a class="btn-floating blue check_all"><i class="material-icons">done_all</i></a></li>
            <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>

    <div class="tap-target black" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>El coordinador podra asignar las evaluaciones de cada materia, el proceso de descripción de cada evaluación la ingresa el profesor.</p>
        </div>
    </div>
</body>
<script>
	$(document).ready(function() {
        $('select').material_select();
    });

    $('select').material_select('destroy');
</script>
</html>
