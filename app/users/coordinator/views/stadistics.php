<?php 
	require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');
?>

<!DOCTYPE html>
<html lang="en">
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
    <script src="../../../../General_Files/js/chart.bundle.min.js" charset="utf-8"></script>

    <link rel="stylesheet" href="../../files/css/view_style.css">
    <link rel="stylesheet" href="../../files/css/c/style.css">

    <script src="../../files/js/init.js" charset="utf-8"></script>
    <script src="../../files/js/Loader.js" charset="utf-8"></script>
    <script src='../../files/js/c/stadistics.js'></script>
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Estadísticas</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
        <div class="section">
            <div class="row">
                <div id="top">
                    <div class='col s12 m6 l6'>
                        <div class='col-content z-depth-3' style="padding: 10px;">
                            <h4 class="center">Top de Estudiantes por nivel según ACC</h4><br>
                        </div>
                    </div>
                </div>
                <div class='col s12 m6 l6'>
                    <div class='col-content z-depth-3' style="padding: 10px;">
                        <h4 class="center">Promedio de Notas Acumuladas de la plataforma</h4>
                        <div id="gnrlACC"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="white chart col s12">
                    <div class="col-content z-depth-2" style="padding: 0px 20px 20px 20px">
                        <h5 class="grey-text">Promedio de notas por cada período</h5>
                        <div class="divider"></div><br>
                        <div id="usertChart-cont">
                            <canvas id="gradesTN"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="white chart col l6 m6 s12">
                    <div class="col-content z-depth-2">
                        <h5 class="grey-text">Tipos de Usuarios</h5>
                        <div class="divider"></div><br>
                        <div id="usertChart-cont">
                            <canvas id="users"></canvas>
                        </div>
                    </div>
                </div>
                <div class="white chart col l6 m6 s12">
                    <div class="col-content z-depth-2">
                        <h5 class="grey-text">Estudiantes por especialidad y nivel</h5>
                        <div class="divider"></div><br>
                        <div id="specialtyChart-cont">
                            <canvas id="specialty"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large black" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Refrescar"><a class="btn-floating green refresh"><i class="material-icons">cached</i></a></li>
            <li title="Regresar"><a disabled class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>
            <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>

    <div class="tap-target black" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>Fill.</p>
        </div>
    </div>
</body>
</html>