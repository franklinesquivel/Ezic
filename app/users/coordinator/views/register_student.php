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
    <script src="../../files/js/c/studentForm_Generator.js" charset="utf-8"></script>
    <script src="../../files/js/c/registerStudent.js" charset="utf-8"></script>
</head>
<body>

    <header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Agregar Estudiantes</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
        
    </main>

    <div id="studentCant-modal" class="modal">
        <div class="modal-content">
            <div class="container section">
                <p class="">
                    <span id="lvlHelper"></span>,
                    <i>"<span id="identifierHelper"></span>"</i><br>
                    <span id="sctnCant"></span><br>
                    <span id="sctnLimit"></span>
                </p>
                <div class="row">
                    <form id="studentCant-frm" autocomplete="off">
                        <div class="input-field col s12 m6 l6 offset-l3 offset-m3">
                            <input type="number" name="txtCant" id="txtCant">
                            <label for="txtCant">Cantidad de estudiantes a registrar</label>
                        </div>
                        <center>
                            <div class="btn black waves-effect waves-light btnSaveCant"><i class="material-icons left">arrow_forward</i> Siguiente</div>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large black waves-effect waves-light">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li><a title="Refrescar" class="btn-floating green waves-effect waves-light btnRefresh"><i class="material-icons">refresh</i></a></li>
            <li><a title="Añadir formulario" disabled class="btn-floating black waves-effect waves-light btnAddFrm"><i class="material-icons">note_add</i></a></li>
            <li><a title="Remover formulario" disabled class="btn-floating red waves-effect waves-light btnRmvFrm"><i class="material-icons">delete</i></a></li>
        </ul>
    </div>
</body>
</html>
