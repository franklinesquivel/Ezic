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

        <?php echo $const->createElement() ?>
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
                        <h2 class="header black-text">Introducción <i class="material-icons grey-text text-lighten-1
" title="información">info_outline</i></h2>
                        <p class="caption elementText">
                           La división de coordinación sera la encargada de manejar el sistema  de administracion de información,entre la cual esta; datos personales, datos académicos, calificaiones, asignaturas, perfiles de evaluación y muchas mas funciones.
                        </p>
                    </div>

                    <div id="test2" class="section scrollspy">
                        <h2 class="header black-text">Registro  <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           En esta seccion el coordinador podrá añadir diversos tipos de usuarios al sistema entre los cuales se encuentrarn; estudiantes, docentes, coordinadores y padres de familia. en los cuales cada uno contara con un tipo de formulario específico que el coordinador tendra que llenar correctamente para que pueda realizar el registro correctamente sin que ninguna alerta aparezca y de este equivorcase en un campo podrar corregir su error en la sección de 'Administración'.
                        </p>
                    </div>

                     <div id="test3" class="section scrollspy">
                        <h2 class="header black-text">Secciones  <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           El coordinador podrá agregar una nueva sección, eliminarla (solo si esta no tiene alumnos inscritos en ella) y podrá ver un listado de todas las secciones registradas y de los alumnos que estan inscritos en ella.
                        </p>
                    </div>

                     <div id="test4" class="section scrollspy">
                        <h2 class="header black-text">Especialidades  <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           El coordinador podrá agregar una nueva especialidad, eliminarla (solo si no hay ningun alumno ni seccion que esten registrados con ella), también podrá ver un listado con las diversas especialidades registradas.
                        </p>
                    </div>

                     <div id="test5" class="section scrollspy">
                        <h2 class="header black-text">Horarios  <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           En la sección de horarios -> Asignar Horario, podrá asignarle un horario a cada docente  
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/1c.jpg">
                        <p class="caption elementText">especificando cada hora y día de la semana en el que se repartira una 'X' materia. </p>
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/2c.jpg">
                         <p class="caption elementText">Si se desea modificar el horario de un docente se mostrara la misma vista que la registro </p>
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/3c.jpg">
                         <p class="caption elementText">y solo tendra que seleccionar las nuevas materias a impartir, dia o si fuera el caso ninguna.</p>
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/4c.jpg">
                          <p class="caption elementText">Si el coordinador lo desea se puede eliminar el horario de cualquier profesor (solo hay un hoario por profesor).</p>
                          <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/5c.jpg">
                    </div>

                     <div id="test6" class="section scrollspy">
                        <h2 class="header black-text">Períodos  <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                           El coordinador podrá agregar períodos seleccionando antes la fecha de inicio y fin de periodo como del valor que este tendra pero estos no se podran registrar si la fecha interfiere con la de otros periodos ya registrados o si el valor de este supera la suma del 100%. 
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/6c.jpg">
                        <p class="caption elementText"> El coordiandor podrá ver un tabla con todos los períodos y los datos de estos. </p>
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/7c.jpg">
                    </div>

                     <div id="test7" class="section scrollspy">
                        <h2 class="header black-text">Perfiles de Evaluación</h2>
                        <p class="caption elementText">
                           El coordinador podrá asignar las evaluaciones de cada materia, el proceso de descripción de cada evaluación la ingresa el profesor. 
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/8c.jpg">
                        <p class="caption elementText"> El coordinador podrá eliminar los perfiles de evaluación según el profesor, materia y período seleccionados.
                          </p>
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/9c.jpg">
                         <p class="caption elementText"> El coordinador podrá modificar los perfiles de evaluación según profesor, materia y periodo seleccionado.</p>   
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/10c.jpg">
                    </div>

                     <div id="test8" class="section scrollspy">
                        <h2 class="header black-text">Asignaturas</h2>
                        <p class="caption elementText">
                           El coordinador podrá agregar una nueva materia llenando los campos de esta como su nombre, acrónimo, el profesor que la va impartir, descripción,nivel y sección.
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/11c.jpg">
                    <p class="caption elementText"> También se podrá asignar la  una una materia a una sección según el profesor. </p>
                         <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/12.jpg">
                         <p class="caption elementText">Al docente se le puede relevar de una materia 'x' para que otro la pueda impartir si es necesario.
                         </p>
                            <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/13c.jpg">
                            <p class="caption elementText">El coordinador podrá eliminar materias, solo tendra que sleccionar que materias y guardar los cambios.</p>
                            <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/14c.jpg">
                    </div>

                     <div id="test9" class="section scrollspy">
                        <h2 class="header black-text">Códigos <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i></h2>
                        <p class="caption elementText">
                          El coordinador podrá registrar códigos a aplicar eligiendo la categoría, tipo y la descripción de este.
                        </p>
                    </div>

                     <div id="test10" class="section scrollspy">
                        <h2 class="header black-text">Administración <i class="material-icons grey-text text-lighten-1
" title="Labor">build</i> <i class="material-icons grey-text text-lighten-1
" title="Descargable">file_download</i> <i class="material-icons grey-text text-lighten-1
" title="Vista">view_module</i></h2>
                        <p class="caption elementText">
                           EL coordinador tendra una vista de todos los usuarios registrados donde podra buscar por el codigo a cada persona,
                        </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/16c.jpg">
                        <p class="caption elementText"> en la parte inferior derecha de esta podra activar los filtro para facilitar está busqueda como los atributos; nombre, apellido y codigo. Tambien puede buscarlos en sus diferentes tipos; estudainte, maestro, coordinador o todos los usuarios. también puede realizar una busqueda por la sección en específico para facilitar aún más la busqueda.
                          </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/17c.jpg">
                        <p> En cada tipo de usuario el coordinador podrá llevar acabo actividades diferentes, en los estudiantes podra ver; notas, perfil, horario, conducta, responsable y obtener un PDF con la información de cada una de estas, otras acciones que se podran realizar sobre los estudiantes en dicha sección son editar su perfil y aplicar codigos.
                           </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/18c.jpg">
                        <p class="caption elementText">En el caso de los usuarios de tipo coordinadores solo podra ver el perfil, obetener un PDF de este y modificar dicho perfil.</p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/19c.jpg">
                        <p class="caption elementText">Para los maestros el coordinador solo podra ver su perfil, horario y obtener un PDF de estos, también podra tener acceso a las materias que este imparte y modificar el perfil del mismo. </p>
                        <img class="materialboxed responsive-img centerImg" width="450" src="../files/img/20c.jpg">
                    </div>

                     <div id="test11" class="section scrollspy">
                        <h2 class="header black-text">Estadísticas <i class="material-icons grey-text text-lighten-1
" title="información">info_outline</i> <i class="material-icons grey-text text-lighten-1
" title="Vista">view_module</i></h2>
                        <p class="caption elementText">
                           El coordinador podra visualizar las estadísticas de las direfentes ramas del sistema.
                        </p>
                    </div>

                   
                </div>

                <div class="col hide-on-small-only m3 l2">
                    <div class="toc-wrapper">
                        <div style="height: 1px;">
                            <ul class="section table-of-contents c">
                                <li class="active"><a href="#test1">Introducción</a></li>
                                <li><a href="#test2">Registro</a></li>
                                <li><a href="#test3">Secciones</a></li>
                                <li><a href="#test4">Especialidades</a></li>
                                <li><a href="#test5">Horarios</a></li>
                                <li><a href="#test6">Períodos</a></li>
                                <li><a href="#test7">Perfiles de Evaluación</a></li>
                                <li><a href="#test8">Asignaturas</a></li>
                                <li><a href="#test9">Códigos</a></li>
                                <li><a href="#test10">Administración</a></li>
                                <li><a href="#test11">Estadísticas</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <footer class="page-footer grey">
        <div class="footer-copyright">
            <div class="container">
                © 2017 Ezic, Todos los derechos reservados
                <a class="grey-text text-lighten-4 right hide-on-small-only" href="materializecss.com">Hecho con Materialize</a>
            </div>
        </div>
    </footer>


</body>
</html>
