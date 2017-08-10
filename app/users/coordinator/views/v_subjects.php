<?php
    require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    // Instanciamos la clase de subject para obtener el listado de las materias que se pueden seleccionar
    require_once("../../../../General_Files/php/classes/Subject_Class.php");
    $subject = new Subject();
    $list_Subjects = $subject->getSubjectsOnly();
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
    <script src="../../files/js/c/v_subject.js" charset="utf-8"></script>
</head>
	<body>
		<header>
            <nav class="top-nav black">
                <div class="container">
                    <div class="nav-wrapper"><a class="page-title">Ver Asignaturas</a></div>
                </div>
            </nav>

            <div class="container">
                <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
            </div>

            <?php echo $const->createElement() ?>
        </header>
        <main class="show">
            <br>
            <div class="container table_subject">
                <div class="row">
                    <?php
                        if (count($list_Subjects) > 0) {
                    ?>
                        <table class="col l10 m10 s10 offset-l1 offset-m1 offset-s1 centered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acrónimo</th>
                                    <th>Nivel</th>
                                    <th>Profesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    for ($i=0; $i <count($list_Subjects) ; $i++) {
                                        echo "<tr id''>
                                            <td>".$list_Subjects[$i][2]."</td>
                                            <td>".$list_Subjects[$i][4]."</td>
                                            <td>".$list_Subjects[$i][1]."</td>
                                            <td><a class='showTeacher'>".$list_Subjects[$i][3]."</a></td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    <?php
                        }else{
                            echo "<div class='col l8 m8 s12 offset-l2 offset-m2'><div class='alert_ red-text text-darken-4'>No se han encontrado materias registradas</div></div>";
                        }
                    ?>
                </div>
            </div>

        </main>
        <div class="fixed-action-btn vertical btn_options">
            <a class="btn-floating btn-large black" id="info">
                <i class="large material-icons">menu</i>
            </a>
            <ul>
                <li title="Regresar"><a disabled class="btn-floating grey btnBack"><i class="material-icons">arrow_back</i></a></li>
                <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
            </ul>  
        </div>

        <div class="tap-target black" data-activates="info">
            <div class="tap-target-content">
                <h5>Acerca de este apartado:</h5>
                <p>Acá tienes a tú dispocisión las materias registradas  por ti o por tus compañeros.</p>
            </div>
        </div>
	</body>
</html>
