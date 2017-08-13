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
    <script src="../../files/js/c/viewSections.js" charset="utf-8"></script>
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Ver Secciones</a></div>
            </div>
        </nav>

        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>

    <main>
        <div class='container'>
            <div class="listCont">
                <br>
                <div class='row'>
                    <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                        <select id="cmbLevel">
                            <option selected disabled>Nivel</option>
                        </select>
                        <label>Selecciona un nivel</label>
                    </div>

                    <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                        <select id="cmbSpecialty">
                            <option selected disabled>Especialidad</option>
                        </select>
                        <label>Selecciona una especialidad</label>
                    </div>

                    <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                        <select id="cmbSection">
                            <option selected disabled>Sección</option>
                        </select>
                        <label>Selecciona una sección</label>
                    </div>

                    <div class="col l6 m6 s10 offset-s1 offset-l3 offset-m3">
                        <br>
                        <h4 class="center">Lista de Secciones</h4>
                        <ul class='collection sectionCollection'></ul>
                    </div>
                </div>
            </div>
            <div class="sectionCont" style="display: none;"></div>
        </div>
    </main>

    <div class="fixed-action-btn vertical btn_options">
        <a class="btn-floating btn-large black" id="info">
            <i class="large material-icons">menu</i>
        </a>
        <ul>
            <li title="Descargar"><a disabled class="btn-floating blue lighten-2 btnPrint"><i class="material-icons">file_download</i></a></li>
            <li title="Regresar"><a disabled class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>
            <li title="Información"><a class="btn-floating yellow darken-2 info_btn"><i class="material-icons">info_outline</i></a></li>
        </ul>  
    </div>

    <div class="tap-target black" data-activates="info">
        <div class="tap-target-content">
            <h5>Acerca de este apartado:</h5>
            <p>Se muestra la sección correspondiente al horario para que se pase lista. Así mismo el apartado tiene en cuenta los permisos previos y el estado conductual de los alumnos</p>
        </div>
    </div>

    <form action="../../../../General_Files/php/classes/Print.php" method="POST" id="printSection"> 
        <input type="hidden" id="action">
        <input type="hidden" name="rows">
        <input type="hidden" name="id">
        <input type="hidden" name="idPeriod">
    </form>

    <div id="getRowsData" class="modal">
        <div class="modal-content">
            <div class="row">
                <form class="frmPrint">
                    <h5 class="center">Selecciona la opción del o los archivos que deseas descargar</h5>
                    <br>
                    <div class="col m4 l4 s12 input-field rdo">
                        <input type="radio" class="with-gap" id="rdoList" name="file" checked="checked" value="printSection"/>
                        <label for="rdoList">Listado</label>
                    </div>
                    <div class="col m8 l8 s12 input-field">
                        <input placeholder="Max(15) - Min(1)" type="number" name="txtRows" id="txtRows">
                        <label for="txtRows">Ingresa la cantidad de columnas extras que desea en el PDF</label>
                    </div>

                    <div class="col m4 l4 s12 input-field rdo" >
                      <input type="radio" class="with-gap" id="rdoGrades" name="file" value="printSectionGrades"/>
                      <label for="rdoGrades">Notas</label>
                    </div>
                    <div class="col m8 l8 s12 input-field">
                        <select name="cmbPeriod" id="cmbPeriod" disabled>
                            <option disabled selected></option> 
                        </select>
                        <label for="cmbPeriod">Selecciona el período</label>
                    </div>

                    <div class="col m12 l12 s12 input-field rdo" >
                      <input type="radio" class="with-gap" id="rdoRecords" name="file" value="printSectionRecord"/>
                      <label for="rdoRecords">Record's Conductuales</label>
                    </div>
                </form>
            </div>
            <center style='margin-top: 10%;'>
                <a class="btn waves-effect waves-light black btnPrintSectionOption"><i class="material-icons right">file_download</i>Descargar</a>
            </center>
        </div>
        <div class="modal-footer"></div>
    </div>
</body>
</html>