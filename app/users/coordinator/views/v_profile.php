<?php
    require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    /*Clase Teacher - Para obtener la lista de nombres de profesores*/
    require_once("../../../../General_Files/php/classes/Teacher_Class.php");
    $teacher = new Teacher();
    $list_teachers = $teacher->getTeachers();

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
    <script src="../../files/js/c/v_profile.js" charset="utf-8"></script>
</head>
	<body>
		<header>
            <nav class="top-nav black">
                <div class="container">
                    <div class="nav-wrapper"><a class="page-title">Ver Perfiles de evaluación</a></div>
                </div>
            </nav>

            <div class="container">
                <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
            </div>

            <?php echo $const->createElement() ?>
        </header>
        <main class="show"><br>
            <div class="container">
                <div class="row"> <!-- Select -->
                    <div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
                        <select id="selectTeacher" name="selectTeacher">
                        <option value="" disabled selected>Elegir Profesor</option>
                        <?php
                             for ($i=0; $i < count($list_teachers ); $i++) {
                                echo "<option value='".$list_teachers [$i][0]."' class='circle' data-icon='../../files/profile_photos/".$list_teachers [$i][3]."'>  <p class='teacher_code'>".$list_teachers [$i][0]."</p> - ".$list_teachers [$i][2].", ".$list_teachers [$i][1]."</option>";
                            }
                        ?>
                        </select>
                        <label>Profesor</label>
                    </div>
                    <div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
                        <select id="selectSubject" name="selectSubject">
                            <option value="" disabled selected>Elegir Materia</option>
                        </select>
                        <label>Materia</label>
                    </div>
                </div>
                <div class="row">
                    <div class="v_table">
                        
                    </div>
                </div>
            </div>
        </main>
        <div class="fixed-action-btn vertical btn_periodContainer">
                <a class="btn-floating btn-large black">
                    <i class="large material-icons">menu</i>
                </a>
                <ul>
                    <li title="Refrescar"><a class="btn-floating green refresh"><i class="material-icons">cached</i></a></li>
                    <li title="Recomendaciones"><a class="btn-floating amber info_btn"><i class="material-icons">info_outline</i></a></li>
                    <!-- <li><a class="btn-floating teal accent-4">3<i class="material-icons">format_quote</i></a></li>
                    <li><a class="btn-floating teal accent-4">2<i class="material-icons">publish</i></a></li>
                    <li><a class="btn-floating teal accent-4">1<i class="material-icons">attach_file</i></a></li> -->
                </ul>
            </div>
            <div class="tap-target black" data-activates="info">
                <div class="tap-target-content">
                    <h5>Acerca de este apartado:</h5>
                    <p>Para poder ver el perfil de evaluación tienes que seleccionar el profesor y la materia deseada.</p>
                </div>
            </div>
	</body>
</html>