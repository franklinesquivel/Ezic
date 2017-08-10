<?php
    require_once('../../../../General_Files/php/classes/Page_Constructor.php');
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv=”Expires” content=”0″>
    <meta http-equiv=”Last-Modified” content=”0″>
    <!-- <meta http-equiv=”Cache-Control” content=”no-cache, mustrevalidate”> -->
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv=”Pragma” content=”no-cache”>

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
    <script src='../../files/js/c/search.js' charset='utf-8'></script>
    <!-- <script src='../../files/js/c/administration.js' charset='utf-8'></script> -->
</head>
<body>

    <header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Administración</a></div>
            </div>
        </nav>
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
    </main>


    <div id="applyCode" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 class="center">Aplicar Código</h4>
            <p class="center" style="font-size: 1.2em;"><span class="apply-id"></span>  -  <span class="apply-name"></span></p>
            <br>
            <div class="row">
                
                <select id="cmbCategory" class="col l5 m5 s10 offset-l1 offset-m1 offset-s1">
                    <option selected disabled>Categoría</option>
                </select>

                <select id="cmbType" class="col l5 m5 s10 offset-s1">
                    <option selected disabled>Tipo</option>
                </select>

                <select id="cmbCodes" class="col l10 m10 s10 offset-l1 offset-m1 offset-s1">
                    <option selected disabled>Código</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <div class="waves-effect btn green white-text btnApplyCode" style="margin-left: 2%;">Aplicar <i class="material-icons right">thumb_up</i></div>
            <div class="modal-action modal-close waves-effect btn red white-text">Cancelar <i class="material-icons right">cancel</i></div>
        </div>
    </div>

    <div id="removeCode-modal" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h4 class="center">Remover Código</h4>
            <p class="center" style="font-size: 1.2em;"><span class="apply-id"></span>  -  <span class="apply-name"></span></p>
            <br>
            <div class="row">
                <table class="centered responsive-table" style="display: none;">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Código</th>
                            <th>Selección</th>
                        </tr>
                    </thead>
                    <tbody class="tblRmvCode">
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <div class="waves-effect btn yellow darken-2 white-text btnRemoveCodes" style="margin-left: 2%;">Remover<i class="material-icons right">check</i></div>
            <div class="modal-action modal-close waves-effect btn red white-text">Cancelar <i class="material-icons right">cancel</i></div>
        </div>
    </div>

    <div class="tap-target blue" data-activates="info">
        <div class="tap-target-content">
            <h5>Title</h5>
            <p>A bunch of text</p>
        </div>
    </div>

    <ul id="options_slide" class="side-nav grey darken-4">
        <li class="title">Filtros <i class="material-icons">find_replace</i></li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a disabled class="white-text collapsible-header waves-effect">Atributos<i class="white-text material-icons">description</i></a>
                    <div class="collapsible-body white">
                        <ul>
                            <li>
                                <input id="f_a1" type="radio" name="filter_attr" class="with-gap" checked="true" value="id">
                                <label for="f_a1">Código</label>
                            </li>
                            <li>
                                <input id="f_a2" type="radio" name="filter_attr" class="with-gap" value="name">
                                <label for="f_a2">Nombre</label>
                            </li>
                            <li>
                                <input id="f_a3" type="radio" name="filter_attr" class="with-gap" value="lastName">
                                <label for="f_a3">Apellido</label>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="white-text collapsible-header waves-effect">Tipos<i class="white-text material-icons">person_tip</i></a>
                    <div class="collapsible-body white">
                        <ul>
                            <li>
                                <input id="f_t1" type="radio" name="filter_type" class="with-gap" checked="true" value="all">
                                <label for="f_t1">Todos</label>
                            </li>
                            <li>
                                <input id="f_t2" type="radio" name="filter_type" class="with-gap" value="S">
                                <label for="f_t2">Estudiante</label>
                            </li>
                            <li>
                                <input id="f_t3" type="radio" name="filter_type" class="with-gap" value="T">
                                <label for="f_t3">Docente</label>
                            </li>
                            <li>
                                <input id="f_t4" type="radio" name="filter_type" class="with-gap" value="C">
                                <label for="f_t4">Coordinador</label>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li>
                    <a class="white-text collapsible-header waves-effect">Buscar sección en específico<i class="white-text material-icons">group</i></a>
                    <div class="collapsible-body white">
                        <ul>
                            <li>
                                <center>
                                    <input type="checkbox" id="search_section" class="filled-in" />
                                    <label for="search_section">Habilitar búsqueda</label>
                                </center>
                            </li>
                            <li>
                                <select name="cmbLevel" id="cmbLevel" class='section-search-i' disabled>
                                    <option selected disabled>Nivel</option>
                                </select>
                            </li>
                            <li>
                                <select name="cmbSpecialty" id="cmbSpecialty" class='section-search-i' disabled>
                                    <option selected disabled>Especialidad</option>
                                </select>
                            </li>
                            <li>
                                <select name="cmbSection" id="cmbSection" class='section-search-i' disabled>
                                    <option selected disabled>Sección</option>
                                </select><br>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
    <div class="fixed-action-btn vertical">
        <a class="btn-floating btn-large black" id="info">
            <i class="material-icons">menu</i>
        </a>
        <ul>
            <li title="Imprimir"><a class="btn-floating blue lighten-2 btnPrint"><i class="material-icons">file_download</i></a></li>
            <li title="Filtros"><a class="btn-floating blue darken-2 options_btn" data-activates="options_slide"><i class="material-icons">filter_list</i></a></li>
            <li title="Regresar"><a disabled class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>
            <li title="Información"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>
    </div>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printRecord"> 
        <input type="hidden" name="printRecord" value="1">
        <input type="hidden" name="id" value="">
    </form>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printSchedule"> 
        <input type="hidden" name="printSchedule" value="1">
        <input type="hidden" name="type" value="">
        <input type="hidden" name="id" value="">
    </form>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printUser"> 
        <input type="hidden" name="printUser" value="1">
        <input type="hidden" name="id" value="">
    </form>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printGrades"> 
        <input type="hidden" name="printGrades" value="1">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="period" value="">
    </form>
</body>
</html>
