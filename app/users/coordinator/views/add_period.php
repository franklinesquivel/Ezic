<?php
    require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');
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
    <script src="../../files/js/c/addPeriod.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Agregar Período</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main class="show">
        <!-- Formulario para añadir periodo -->
        <div class="row">
            <span class=""><br><br></span>
            <form class="registerPeriod col s12">
                <div class="row">
                    <div class="input-field col l4 m4 s10 offset-l4 offset-m4 offset-s1">
                        <input type="date" id="startDate" name="startDate" class="datepicker">
                        <label for="startDate">Inicio de Período</label>
                    </div>
                    <div class="input-field col l4 m4 s10 offset-l4 offset-m4 offset-s1">
                        <input type="date" id="endDate" name="endDate" class="datepicker">
                        <label for="endDate">Fin de Período</label>
                    </div>
                    <div class="input-field col l4 m4 s10 offset-l4 offset-m4 offset-s1">
                        <input id="percentage" type="number" min="0" max="100" name="percentage">
                        <label for="percentage">Porcentaje(%)</label>
                    </div>
                </div>
                <div class="row">
                    <center>
                        <button class="btnPeriod btn waves-effect waves-light" name="action">Registrar
                            <i class="material-icons right">send</i>
                        </button>
                    </center>
                </div>
            </form>
        </div>

        <div class="fixed-action-btn vertical btn_options">
            <a class="btn-floating btn-large black" id="info">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li title="Refrescar"><a class="btn-floating green refresh"><i class="material-icons">cached</i></a></li>
                <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
            </ul>  
        </div>

        <div class="tap-target black" data-activates="info">
            <div class="tap-target-content">
                <h5>Acerca de este apartado:</h5>
                <p>El coordinador podrá asignar los períodos en los cuales se evaluarán a los alumnos. Registrando así el período de tiempo en el cual comprende el período y su porcentage en el año escolar.</p>
            </div>
        </div>
    </main>
</body>
</html>
