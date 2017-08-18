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
    <script src="../../files/js/c/photoUpload.js" charset="utf-8"></script>
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Subir fotografías</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main class="show">
    	<div class="row">
            <br>
            <h5 class="center">Selecciona el archivo que deseas subir (.zip)</h5>
            <form action="#" class="col l6 m6 s10 offset-s1 offset-m3 offset-l3">
                <div class="file-field input-field">
                    <div class="btn black" >
                        <span>Explorar <i class="material-icons right">folder</i></span>
                        <input type="file" id="fileInput" >
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" >
                    </div>
                </div>
            </form>
        </div>

        <div class='row' id="reportCont">
            <div class='container'>
                <span class='reportTitle'>Reporte de Resultados</span>
                <div class='divider'></div>
                <br>
                <div class='uploaded_info'>
                    <span class='indicator yellow darken-1'></span>
                    <span class='infoTitle'>Cantidad de archivos <i class='material-icons right yellow-text text-darken-1'>attach_file</i></span>
                    <span id='fileCant' class='infoValue'>5</span>
                </div>
                <div class='uploaded_info'>
                    <span class='indicator orange'></span>
                    <span class='infoTitle'>Archivos válidos (Imágenes) <i class='material-icons right orange-text'>collections</i></span>
                    <span id='fileCant' class='infoValue'>5</span>
                </div>
                <div class='uploaded_info c_users'>
                    <div class='content_'>
                        <span class='indicator blue'></span>
                        <span class='infoTitle'>Coincidencias encontradas <i class='material-icons right blue-text'>offline_pin</i></span>
                        <span id='fileCant' class='infoValue'>5</span>
                    </div>
                    <div class='users'>
                        <ul class='collapsible' id="uploadCollapsible" data-collapsible='accordion' disabled style="display: none;">
                            <li>
                                <div class='collapsible-header'>
                                <div class="collapsible-h">
                                    <i class='material-icons'>child_care</i> Estudiantes
                                </div>
                                </div>
                                <div class='collapsible-body'>
                                    <ul class='collection'>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class='uploaded_info done' style="display: none;">
                    <span class='indicator green'></span>
                    <span class='infoTitle'>Fotografías modificadas <i class='material-icons right green-text'>done_all</i></span>
                </div>
                <div class='uploaded_info error' style="display: none;">
                    <span class='indicator red'></span>
                    <span class='infoTitle'>No hay archivos para modificar <i class='material-icons right red-text'>error</i></span>
                </div>
            </div>
            <br><br>
            <center>
                <div class="btn black btnRefresh waves-effect waves-light">Reestablecer <i class="material-icons right">refresh</i></div> 
            </center>
        </div>
    </main>

    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large black" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Refrescar"><a class="btn-floating green btnRefresh"><i class="material-icons">cached</i></a></li>
            <li title="Información"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>

    <div class="tap-target black" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>Yei.</p>
        </div>
    </div>
</body>
</html>