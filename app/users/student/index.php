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
                        <h2 class="header black-text">Hola</h2>
                        <p class="caption">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>

                    <div id="test2" class="section scrollspy">
                        <h2 class="header black-text">Hola</h2>
                        <p class="caption">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>

                    <div id="test3" class="section scrollspy">
                        <h2 class="header black-text">Hola</h2>
                        <p class="caption">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>

                <div class="col hide-on-small-only m3 l2">
                    <div class="toc-wrapper">
                        <div style="height: 1px;">
                            <ul class="section table-of-contents s">
                                <li class="active"><a href="#test1">Introducción</a></li>
                                <li><a href="#test2">Monitoreo</a></li>
                                <li><a href="#test3">Registros</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <footer class="page-footer blue">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">Footer Content</h5>
                    <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                        <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2017 Ezic, Todos los derechos reservados
                <a class="grey-text text-lighten-4 right hide-on-small-only" href="materializecss.com">Hecho con Materialize</a>
            </div>
        </div>
    </footer>
</body>
</html>
