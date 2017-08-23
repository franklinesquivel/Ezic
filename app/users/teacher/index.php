<?php
    require_once("../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('T');
    $userRow = $const->getData('T');
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ezic: Coodinador.</title>

    <link rel="shortcut icon" type="image/png" href="../../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../../General_Files/materialize/css/materialize.css">
    <link rel="stylesheet" href="../files/css/view_style.css">
    <link rel="stylesheet" href="../files/css/t/style.css">

    <meta name="theme-color" content="#167e1a">
    <meta name="msapplication-navbutton-color" content="#167e1a">
    <meta name="apple-mobile-web-app-status-bar-style" content="#167e1a">

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
        <div class="section green darken-2" id="index-banner">
            <div class="container">
                <div class="row">
                    <div class="col s12 m9">
                        <h1 class="header center-on-small-only"> <?php echo ( $userRow['sex'] == 'F' ? 'Bienvenida' : 'Bienvenido' ) ?></h1>
                        <h4 class="light green-text text-lighten-4 center-on-small-only">Aprende a utilizar las funciones básicas de Ezic<small>&copy;</small> Docente.</h4>
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
                             La división de docentes sera la encargada de manejar los datos académicos de los estudiantes como lo son sus notas, perfiles de evaluacion y la asistencia.
                        </p>
                    </div>


                    <div id="test2" class="section scrollspy">
                        <h2 class="header black-text">Horario 
                            <i class="material-icons grey-text text-lighten-1
" title="Descargable">file_download</i>
                        </h2>
                        
                        <p class="caption elementText">
                           Este simple apartado consta del horario de la semana para el profesor indicando que materia va impartir en cada grado y en que día de la semana.
                        </p>
                       
                    </div>

                     <div id="test3" class="section scrollspy">
                        <h2 class="header black-text">Asistencia <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           Se muestra la sección correspondiente al horario para que se pase lista. Así mismo el apartado tiene en cuenta los permisos previos y el estado conductual de los alumnos. También sera capaz de agregar una llegada tardía para aplicar un código sobre el estudiante y para facilitar la toma de asistencia podra marcar a todos de una sola vez como  que han asistido.
                        </p>
                    </div>

                     <div id="test4" class="section scrollspy">
                        <h2 class="header black-text">Agregar Notas <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           Se mostrar la sección de agregar notas cuando sea su tiempo especifico el docenten no podra agregar notas sino es en el tiempo reglamentario.
                        </p>
                    </div>

                     <div id="test5" class="section scrollspy">
                        <h2 class="header black-text">Descripcción de perfiles <i class="material-icons grey-text text-lighten-1
" title="Vista">view_module</i></h2>
                        <p class="caption elementText">
                           El profesor puede ingresar la descripción de los perfiles de evaluación según su materia 
                        </p>
                            <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/1.jpg"><br>
                            <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/2.jpg">
                            <p>y puede modificar la descripción de está.</p>
                             <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/3.jpg">
                    </div>

                     <div id="test6" class="section scrollspy">
                        <h2 class="header black-text">Solicitar Permiso <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           El profesor puede seleccionar los alumnos segun la materia que les imparte 
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/5.jpg">
                        <br>
                        <p class="caption elementText">
                          ya sean estos de diferentes secciones.
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/6.jpg">
                    </div>

                     <div id="test7" class="section scrollspy">
                        <h2 class="header black-text">Configuración <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText`">
                           El profesor tiene la autorización de poder cambiar su password y corre electrónico.
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/4.jpg">
                    </div>

              

                </div>

                <div class="col hide-on-small-only m3 l2">
                    <div class="toc-wrapper">
                        <div style="height: 1px;">
                            <ul class="section table-of-contents t">
                                <li class="active"><a href="#test1">Introducción</a></li>
                                <li><a href="#test2">Horario</a></li>
                                <li><a href="#test3">Asistencia</a></li>
                                <li><a href="#test4">Agregar Notas</a></li>
                                <li><a href="#test5">Descripcción de perfiles</a></li>
                                <li><a href="#test6">Solicitar Permiso</a></li>
                                <li><a href="#test7">Configuración</a></li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <footer class="page-footer green">
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
