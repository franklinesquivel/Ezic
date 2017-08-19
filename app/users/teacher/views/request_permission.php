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
    <script src="../../files/js/t/request_permission.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <?php 
            echo($const->getSchedule());
        ?>
        <nav class="top-nav green darken-2">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Solicitar Permiso</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>
    
    <main>
        <br><br>
        <div class="container select">
           
           
        </div>
        <div class="container list">
                
        </div>
    </main>

   <div id="logModal" class="modal bottom-sheet white list-add">  <!-- Modal donde se pone los usuario agregados -->
        <div class="modal-content">
            <div class="container">
                <div class='title'>
                    <h4 class='center'>Alumnos Seleccionados</h4>
                </div>
                <div class="row">
                    <div class='message-error active'>
                        <h5 class='center'>No ha seleccionado usuarios</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer white">
            <a href="#!" class="modal-action modal-close waves-effect waves-blue btn-flat green-text text-darken-2"><i class="material-icons left green-text text-darken-2">close</i> Cerrar</a>
        </div>
    </div>

    <!-- Inicio SlideNav -->
    <ul id="slide-filter" class="side-nav green darken-1">
        <li>
            <h5 class='center'>Seleccione la sección</h5>
            <div class="input-field col s8 offset-s2 section-select">
                <select id="selectFilter">
                    <option value="" disabled selected>Elegir Sección</option>
                    <!-- 
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option> -->
                </select>
            </div>
        </li>
    </ul>
    <!-- Fin SlideNav -->

    <!-- Boton Flotante -->
    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large green darken-2" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Regresar"><a disabled class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>
            <li title="Filtros"><a class="btn-floating blue btnFilters" data-activates="slide-filter"><i class="material-icons">filter_list</i></a></li>
            <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>
    <div class="tap-target green darken-2" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>Acá puedes pedir según una materia, la solicitud de permiso para modificar notas.</p>
        </div>
    </div> 
    <!--Fin Boton Flotante  -->
</body>
</html>