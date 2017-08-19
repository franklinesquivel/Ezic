<?php 
	require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');
?>

<!DOCTYPE html>
<html lang="en">
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
    <script src="../../files/js/c/accept_permission.js" charset="utf-8"></script>
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Aceptar Permisos</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
    	<br>
    	<div class="container">
            <!-- <div class="row">  
                <ul class="collection permission-container col l10 m10 s10 offset-l1 offset-m1 offset-s1">
                    <li class="collection-item dismissable ">
                        <div class="header">
                            <div class="teacher">
                                <span>
                                    Fuentes Lizama, Daniel Alejandor - D1754
                                </span>
                                <i class="material-icons left">account_circle</i>
                            </div>
                            <div class="option">
                                <input type="checkbox" id="test6" class="checkbox_add"/>
                                <label for="test6">Agregar</label>
                            </div>
                        </div>
                        <div class="info-permission">
                            <div class="gnrl-info">
                                <div class="info">
                                    <span class="title">Número de Estudiantes: </span>
                                    <span class="result">2</span>
                                </div>
                                <div class="info">
                                    <span class="title">Número de Perfiles: </span>
                                    <span class="result">2</span>
                                </div>
                            </div>
                            <div class="subject">
                                <div class="info">
                                    <span class="title">Asignatura: </span>
                                    <span class="result">Sociales</span>
                                </div>
                                <div class="info">
                                    <span class="title">Fecha de Solicitud: </span>
                                    <span class="result">2017-8-13</span>
                                </div>
                            </div>
                            <div class="description">
                                <div class="title">Motivo: </div>
                                <div class="result">
                                    aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.
                                    aaaaaaaaaa
                                </div>
                            </div>  
                            <div class="option-view row">
                                <button class="btn waves-effect waves-light black col l4 m4 s6 offset-l4 offset-m4 offset-s3">Ver Información
                                    <i class="material-icons right">send</i>
                                </button> 
                            </div>
                        </div>
                    </li>
                </ul>
            </div> -->
    	</div>
    </main>
    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large black" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>

    <div class="tap-target black" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>Puedes aceptar los permisos para modificar notas, solicitados por los profesores.</p>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="modal_permission" class="modal">
        <div class="modal-content">

        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-black btn-flat">Aceptar</a>
        </div>
    </div>
</body>
</html>