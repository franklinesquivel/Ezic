<?php
    require_once("../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('H');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv=”Expires” content=”0″>
    <meta http-equiv=”Last-Modified” content=”0″>
    <meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”>
    <meta http-equiv=”Pragma” content=”no-cache”>

    <meta name="theme-color" content="#005ab4">
    <meta name="msapplication-navbutton-color" content="#005ab4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#005ab4">

    <title>Ezic: Plataforma de Administración Educativa.</title>

    <link rel="shortcut icon" type="image/png" href="../../General_Files/img/ezic.png"/>
    <link rel="stylesheet" href="../../General_Files/materialize/css/materialize.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>
    <script src="js/functions.js" charset="utf-8"></script>
</head>
<body>

    <div class="navbar-fixed">
        <nav class="white" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="#" class="brand-logo blue-text text-darken-2"> <i class="material-icons">polymer</i> Ezic</a>
                <a href="#" data-activates="nav-mobile" class="button-collapse btnHome"><i class="material-icons blue-text text-darken-2">menu</i></a>

                <ul class="right hide-on-med-and-down">
                    <li class="active"><a class="blue-text text-darken-2" href="#">Inicio</a></li>
                    <li><a class="blue-text text-darken-2" href="#">Acerca de Nosotros</a></li>
                    <li><a href="#logModal" class="modal-trigger waves-effect waves-light btn blue darken-2"><i class="material-icons right">person</i> Iniciar Sesión</a></li>
                </ul>

            </div>
        </nav>

    </div>

    <ul id="nav-mobile" class="side-nav blue darken-2">
        <li class="active"><a class="white-text" href="#">Inicio</a></li>
        <li><a class="white-text" href="#">Aula Virtual</a></li>
        <li><a class="white-text" href="#">Acerca de Nosotros</a></li>
        <li><a href="#logModal" class="modal-trigger waves-effect waves-blue btn white blue-text text-darken-2"><i class="material-icons right blue-text text-darken-2">person</i> Iniciar Sesión</a></li>
    </ul>

    <div class="slider homeSlider">
        <ul class="slides">
            <li>
                <img src="img/img_1.jpg">
                <div class="caption center-align">
                    <h3>Innovación</h3>
<!--                    <h5 class="light grey-text text-lighten-3">Wuoooooooooooo.</h5>-->
                </div>
            </li>
            <li>
                <img src="img/img_2.jpg">
                <div class="caption left-align">
                    <h3>Desarrollo Tecnológico</h3>
<!--                    <h5 class="light grey-text text-lighten-3">wiuiuwiuwiwuwi.</h5>-->
                </div>
            </li>
            <li>
                <img src="img/img_3.jpg">
                <div class="caption right-align">
                    <h3>Implementación Estudiantil</h3>
<!--                    <h5 class="light grey-text text-lighten-3">gg.</h5>-->
                </div>
            </li>
            <li>
                <img src="img/img_4.jpg">
                <div class="caption center-align">
                    <h3>Nuevas Tecnologías</h3>
<!--                    <h5 class="light grey-text text-lighten-3">anuma.</h5>-->
                </div>
            </li>
        </ul>
    </div>

    <span class="space-helper"></span>

    <div class="section white container">
        <div class="row">
            <h2 class="header blue-text text-darken-2 center">La revolución de la educación</h2>
            <p style="text-align: justify;">
                En la actualidad, como consecuencia de la globalización que se ha manifestado en la mayor parte del mundo, que ha traído consigo grandes avances en la tecnología y en la comunicación, diversos campos de actividad se han acogido de la nueva tecnología para proyectarse y expandirse, debido a la facilidad y rapidez con que se puede manejar gran cantidad de información.<br> <br> Uno de los campos que han aprovechado y están aprovechando esta nueva tecnología es el de la educación, ya que el Internet es un medio eficaz para garantizar la comunicación, la interacción, el transporte de información y, consecuentemente, el aprendizaje, en lo que se denomina enseñanza virtual, enseñanza a través de Internet o teleformación.<br>

                Esto es de gran ayuda para integrar a los jovenes al mundo de la informatica y crear una curiosidad por querer explorar el grandioso mundo de la tecnología.
            </p>
        </div>
    </div>

    <div class="parallax-container">
        <div class="parallax"><img class="" src="img/img_5.jpg"></div>
    </div>

    <div class="container">
        <div class="section">

            <div class="row">
                <div class="col s12 m4">
                    <div class="icon-block">
                        <h2 class="center blue-text"><i class="large material-icons">supervisor_account</i></h2>
                        <h5 class="center" >Desarrollo</h5>
                        <p class="light" style="text-align: center;" >
                            Brinda las herramientas tecnológicas de ayuda y apoyo al estudiante y alternativas deseguimiento y control al docente, quién tiene en sus manos una potente y complementaria estrategia para apoyar estratégicamente los cursos que desarrolla.
                         </p>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="icon-block">
                        <h2 class="center blue-text"><i class="large material-icons">business</i></h2>
                        <h5 class="center">Innovador</h5>
                        <p class="light" style="text-align: center;">
                           Genera una cultura en uso de TIC en torno a la utilización de las Tecnologías de la Información y Comunicación, para desarrollar modelos innovadores de enseñanza-aprendizaje que se ajusten a las exigencias de la sociedad en cuanto a calidad educativa.
                         </p>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="icon-block">
                        <h2 class="center blue-text"><i class="large material-icons">work</i></h2>
                        <h5 class="center">Cooperativo</h5>
                        <p class="light" style="text-align: center;">
                            Estimula el desarrollo de competencias en el uso de Tecnologías de la Información y las Comunicaciones tanto en los docentes como en los estudiantes. Estas prácticas permiten sistematizar y hacer visible las experiencias significativas de los docentes durante el desarrollo de sus asignaturas en el aula virtual.
                         </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="page-footer blue darken-2">
        <div class="container">
            <div class="row">

            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2017 Ezic, Inc.
            </div>
        </div>
    </footer>

    <div id="logModal" class="modal bottom-sheet white">
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs" id="tabs_">
                            <li class="tab col s6"><a class="blue-text text-darken-2" href="#frm_1">Estudiante</a></li>
                            <li class="tab col s6"><a class="blue-text text-darken-2" href="#frm_2">Docente / Coordinador</a></li>
                        </ul>
                    </div>
                    <br><br><br><br>
                    <div id="frm_1" class="col s12">
                        <form class="studentLog">
                            <div class="row">
                                <div class="input-field col s12 m4 l4 offset-m4 offset-l4">
                                    <input id="txtSCode" name="txtSCode" placeholder="AA0000" type="text">
                                    <label for="txtSCode">Código</label>
                                </div>
                                <div class="input-field col s12 m4 l4 offset-m4 offset-l4">
                                    <input id="txtSPass" name="txtSPass" type="password">
                                    <label for="txtSPass">Contraseña</label>
                                </div>
                                <div class="col s12 m12 l12">
                                    <center>
                                        <button class="student btnSend btn blue darken-2 waves-effect waves-light submit" id="submit-button"><i class="material-icons right">send</i> Enviar</button>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="frm_2" class="col s12">
                        <form class="workerLog">
                            <div class="row">
                                <div class="input-field col s12 m4 l4 offset-m4 offset-l4">
                                    <input id="txtWorkerCode" name="txtWorkerCode" placeholder="(D/C)0000" type="text">
                                    <label for="txtWorkerCode">Código</label>
                                </div>
                                <div class="input-field col s12 m4 l4 offset-m4 offset-l4">
                                    <input id="txtWorkerPass" name="txtWorkerPass" type="password">
                                    <label for="txtWorkerPass">Contraseña</label>
                                </div>
                                <div class="col s12 m12 l12">
                                    <center>
                                        <button class="worker btnSend btn blue darken-2 waves-effect waves-light submit" id="submit-button"><i class="material-icons right">send</i> Enviar</button>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer white">
            <a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat blue-text text-darken-2"><i class="material-icons left blue-text text-darken-2">close</i> Cerrar</a>
        </div>
    </div>

    <div class='loader_cont'>
        <div class='preloader-wrapper big active'>
            <div class='spinner-layer spinner-blue-only'>
                <div class='circle-clipper left'>
                    <div class='circle'></div>
                </div>
                <div class='gap-patch'>
                    <div class='circle'></div>
                </div>
                <div class='circle-clipper right'>
                    <div class='circle'></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
