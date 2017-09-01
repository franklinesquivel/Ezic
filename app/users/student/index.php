<?php
    require_once("../../../General_Files/php/classes/Page_Constructor.php");
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

    <link rel="shortcut icon" type="image/png" href="../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../General_Files/materialize/css/materialize.css">
    <link rel="stylesheet" href="../files/css/view_style.css">
    <link rel="stylesheet" href="../files/css/s/style.css">

    <meta http-equiv=”Expires” content=”0″>
    <meta http-equiv=”Last-Modified” content=”0″>
    <meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”>
    <meta http-equiv=”Pragma” content=”no-cache”>

    <meta name="theme-color" content="#005ab4">
    <meta name="msapplication-navbutton-color" content="#005ab4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#005ab4">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>
    <script src="../files/js/init.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?> 
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main class="show">
        <div class="section blue darken-2" id="index-banner">
            <div class="container">
                <div class="row">
                    <div class="col s12 m9">
                        <h1 class="header center-on-small-only"> <?php echo ( $userRow['sex'] == 'F' ? 'Bienvenida' : 'Bienvenido' ) ?></h1>
                        <h4 class="light blue-text text-lighten-4 center-on-small-only">Aprende a utilizar las funciones básicas de Ezic<small>&copy;</small> Estudiante.</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section col l10 m9 s12">
                    <div id="test1" class="section scrollspy">
                        <h2 class="header black-text">Introducción <i class="material-icons grey-text text-lighten-1
" title="información">info_outline</i></h2>
                        <p class="caption elementText">
                             El apartado de estudiantes permitira a sus usuarios estar informados de sus notas, conductas y horario. Esto facilitara que cada estudiante organize su tiempo de estudio tanto en el hogar como en la institución.
                        </p>
                    </div>

                    <div id="test2" class="section scrollspy">
                        <h2 class="header black-text">Ver Notas <i class="material-icons grey-text text-lighten-1
" title="Vista">view_module</i> <i class="material-icons grey-text text-lighten-1
" title="Descargable">file_download</i> </h2>
                        <p class="caption">
                           El estudainte cuenta con una sección en la que podrá observar todas las notas de sus respectivas materias y si lo desea podrá descargar las mismas como un archivo PDF.
                        </p>
                    </div>

                     <div id="test3" class="section scrollspy">
                        <h2 class="header black-text">Record Conductual <i class="material-icons grey-text text-lighten-1
" title="Vista">view_module</i> <i class="material-icons grey-text text-lighten-1
" title="Descargable">file_download</i> </h2>
                        <p class="caption">
                           El estudainte cuenta con una sección en la que podrá observar su record conductual a lo largo del año también podrá que tipo,grado y por quién fue impuesto el código, si lo desea podrá descargar un archivo PDF con todos estos datos.
                        </p>
                    </div>

                     <div id="test4" class="section scrollspy">
                        <h2 class="header black-text">Horario <i class="material-icons grey-text text-lighten-1
" title="Vista">view_module</i> <i class="material-icons grey-text text-lighten-1
" title="Descargable">file_download</i> </h2>
                        <p class="caption">
                            El estudainte cuenta con una sección en la que podrá observar su horario académico a lo largo de la semana, en él se encontrara la materia a impartir según la hora del día.
                        </p>
                    </div>
                </div>

                <div class="col hide-on-small-only m3 l2">
                    <div class="toc-wrapper">
                        <div style="height: 1px;">
                            <ul class="section table-of-contents s">
                                <li class="active"><a href="#test1">Introducción</a></li>
                                <li><a href="#test2">Ver Notas</a></li>
                                <li><a href="#test3">Record Conductual</a></li>
                                <li><a href="#test4">Horario</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <footer class="page-footer blue">
        <div class="footer-copyright">
            <div class="container">
                © 2017 Ezic, Todos los derechos reservados
                <a class="grey-text text-lighten-4 right hide-on-small-only" href="materializecss.com">Hecho con Materialize</a>
            </div>
        </div>
    </footer>
</body>
</html>
