<?php
    require_once("../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');
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
    <link rel="stylesheet" href="../files/css/c/style.css">

    <meta name="theme-color" content="#343434">
    <meta name="msapplication-navbutton-color" content="#343434">
    <meta name="apple-mobile-web-app-status-bar-style" content="#343434">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="../../../General_Files/js/jquery.js" charset="utf-8"></script>
    <script src="../../../General_Files/js/validate.js" charset="utf-8"></script>
    <script src="../../../General_Files/materialize/js/materialize.js" charset="utf-8"></script>
    <script src="../files/js/init.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <ul id="user_nav" class="side-nav fixed">
            <li>
                <div class="userView">
                    <div class="background">
                        <img src="../files/img/coor.jpg" width="100%">
                    </div>
                    <img class="circle" src="../files/profile_photos/<?php echo $userRow['photo']; ?>">
                    <span class="white-text name"><?php echo explode(' ', $userRow['name'])[0] . " " . explode(' ', $userRow['lastName'])[0]; ?></span>
                    <span class="white-text email"><?php echo ( $userRow['sex'] == 'F' ? 'Coordinadora' : 'Coordinador' ) ?></span>
                </div>
            </li>
            <!-- <li><a class="subheader"></a></li> -->
            <li class="active"><a href="#!" class="waves-effect">Inicio<i class="material-icons">home</i></a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Registrar<i class="material-icons">group_add</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="views/register_student.php" class="waves-effect">Estudiantes<i class="material-icons">child_care</i></a></li>
                                <li><a href="#!" class="waves-effect">Docentes<i class="material-icons">face</i></a></li>
                                <li><a href="#!" class="waves-effect">Coordinador<i class="material-icons">person</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Horarios<i class="material-icons">schedule</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="views/add_schedule.php" class="waves-effect">Asignar horario<i class="material-icons">assignment</i></a></li>
                                <li><a href="views/modify_schedule.php" class="waves-effect">Modificar horario<i class="material-icons">assignment_ind</i></a></li>
                                <li><a href="views/delete_schedule.php" class="waves-effect">Elminar horario<i class="material-icons">assignment_returned</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Período<i class="material-icons">timeline</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="views/add_period.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/modify_period.php" class="waves-effect">Modificar<i class="material-icons">edit</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/v_period.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Perfiles de Evaluación<i class="material-icons">starts</i></a>
                        <div class="collapsible-body">
                            <!-- <ul>
                                <li><a href="views/add_profile.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/modify_profile.php" class="waves-effect">Modificar<i class="material-icons">edit</i></a></li>
                            </ul> -->
                            <ul>
                                <li><a href="views/delete_profile.php" class="waves-effect">Eliminar<i class="material-icons">delete</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/v_profile.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Asignaturas<i class="material-icons">description</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="views/add_subject.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/assign_subjectSection.php" class="waves-effect">Asignar seccionnes<i class="material-icons">format_list_numbered</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/switch_teacherSubject.php" class="waves-effect">Cambiar profesor<i class="material-icons">repeat</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/delete_subject.php" class="waves-effect">Eliminar<i class="material-icons">delete</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/v_subjects.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Códigos<i class="material-icons">warning</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="views/add_code.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/modify_code.php" class="waves-effect">Modificar<i class="material-icons">edit</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/delete_code.php" class="waves-effect">Eliminar<i class="material-icons">delete</i></a></li>
                            </ul>
                            <ul>
                                <li><a href="views/v_code.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>

            <li><a href="views/administration.php" class="waves-effect">Administración<i class="material-icons">folder</i></a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect">Modificar<i class="material-icons">mode_edit</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="views/modify_data.php" class="waves-effect">Datos<i class="material-icons">info</i></a></li>
                                <li><a href="views/.php" class="waves-effect">Dar de Baja<i class="material-icons">thumb_down</i></a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li><a class="subheader">Cuenta</a></li>
            <li><a href="#!" class="waves-effect">Configuración<i class="material-icons">settings</i></a></li>
            <li><div class="divider"></div></li>
            <li><a class="waves-effect btnUnlog"><i class="material-icons">cancel</i>Cerrar Sesión</a></li>
        </ul>
    </header>

    <main class="show">
        <div class="section black" id="index-banner">
            <div class="container">
                <div class="row">
                    <div class="col s12 m9">
                        <h1 class="header center-on-small-only"> <?php echo ( $userRow['sex'] == 'F' ? 'Bienvenida' : 'Bienvenido' ) ?></h1>
                        <h4 class="light grey-text text-darken-1 center-on-small-only">Aprende a utilizar las funciones básicas de Ezic<small>&copy;</small> Coodinador.</h4>
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
                            <ul class="section table-of-contents c">
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

    <footer class="page-footer grey">
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
