<?php
	require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    /*Clase Teacher - Para obtener la lista de nombres de profesores*/
    require_once("../../../../General_Files/php/classes/Teacher_Class.php");
    $teacher = new Teacher();
    $list_teachers = $teacher->getTeachers();

    // Instanciamos la clase de period para obtener el listado de los periodos que se pueden seleccionar
    require_once("../../../../General_Files/php/classes/Period.php");
    $period = new Period();
    $list_Periods = $period->getPeriods();
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
    <script src="../../files/js/c/delete_profile.js" charset="utf-8"></script><!-- JS que se alterna -->
</head>
	<body>
		<header>
            <nav class="top-nav black">
                <div class="container">
                    <div class="nav-wrapper"><a class="page-title">Eliminar Perfiles de Evaluación</a></div>
                </div>
            </nav>
            <div class="container">
                <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
            </div>

            <ul id="user_nav" class="side-nav fixed">
                <li>
                    <div class="userView">
                        <div class="background">
                            <img src="../../files/img/coor.jpg" width="100%">
                        </div>
                        <img class="circle" src="../../files/profile_photos/<?php echo $userRow['photo']; ?>">
                        <span class="white-text name"><?php echo explode(' ', $userRow['name'])[0] . " " . explode(' ', $userRow['lastName'])[0]; ?></span>
                        <span class="white-text email"><?php echo ( $userRow['sex'] == 'F' ? 'Coordinadora' : 'Coordinador' ) ?></span>
                    </div>
                </li>
                <!-- <li><a class="subheader"></a></li> -->
                <li class=""><a href="../index.php" class="waves-effect">Inicio<i class="material-icons">home</i></a></li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect">Registrar<i class="material-icons">group_add</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="register_student.php" class="waves-effect">Estudiantes<i class="material-icons">child_care</i></a></li>
                                    <li><a href="#!" class="waves-effect">Docentes<i class="material-icons">face</i></a></li>
                                    <li><a href="#!" class="waves-effect">Coordinador<i class="material-icons">person</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect">Horarios<i class="material-icons">schedule</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="add_schedule.php" class="waves-effect">Asignar horario<i class="material-icons">assignment</i></a></li>
                                    <li><a href="modify_schedule.php" class="waves-effect">Modificar horario<i class="material-icons">assignment_ind</i></a></li>
                                    <li><a href="delete_schedule.php" class="waves-effect">Elminar horario<i class="material-icons">assignment_returned</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect">Período<i class="material-icons">timeline</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="add_period.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="modify_period.php" class="waves-effect">Modificar<i class="material-icons">edit</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="v_period.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect active">Perfiles de Evaluación<i class="material-icons">starts</i></a>
                            <div class="collapsible-body">
                                <!-- <ul>
                                    <li><a href="add_profile.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="modify_profile.php" class="waves-effect">Modificar<i class="material-icons">edit</i></a></li>
                                </ul> -->
                                <ul>
                                    <li class="active"><a href="delete_profile.php" class="waves-effect">Eliminar<i class="material-icons">delete</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="v_profile.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect">Asignaturas<i class="material-icons">description</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="add_subject.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="assign_subjectSection.php" class="waves-effect">Asignar seccionnes<i class="material-icons">format_list_numbered</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="switch_teacherSubject.php" class="waves-effect">Cambiar profesor<i class="material-icons">repeat</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="delete_subject.php" class="waves-effect">Eliminar<i class="material-icons">delete</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="v_subjects.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect">Códigos<i class="material-icons">warning</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="../views/add_code.php" class="waves-effect">Añadir<i class="material-icons">library_add</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="../views/modify_code.php" class="waves-effect">Modificar<i class="material-icons">edit</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="../views/delete_code.php" class="waves-effect">Eliminar<i class="material-icons">delete</i></a></li>
                                </ul>
                                <ul>
                                    <li><a href="../views/v_code.php" class="waves-effect">Ver<i class="material-icons">visibility</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>

                <li><a href="../views/administration.php" class="waves-effect">Administración<i class="material-icons">folder</i></a></li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header waves-effect">Modificar<i class="material-icons">mode_edit</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="modify_data.php" class="waves-effect">Datos<i class="material-icons">info</i></a></li>
                                    <li><a href="" class="waves-effect">Dar de Baja<i class="material-icons">thumb_down</i></a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a class="subheader">Cuenta</a></li>
                <li><a href="#!" class="waves-effect">Configuración<i class="material-icons">settings</i></a></li>
                <li><div class="divider"></div></li>
                <li><a class="waves-effect btnUnlog"><i class="material-icons">cancel</i>Cerrar Sesión</a></li>
            </ul>
        </header>
    	<main class="show">
    		<div class="container">
    			<form class="choseProfiles">
    				<br><br>
                    <div class="row">
                        <!-- <div class=""> -->
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
                                    <?php
                                        // for ($i=0; $i < count($list_Subjects) ; $i++) {
                                        //     echo "<option value=".$list_Subjects[$i][0].">".$list_Subjects[$i][1]."°".$list_Subjects[$i][2].": ".$list_Subjects[$i][3]." - ".$list_Subjects[$i][4]."</option>";
                                        // }
                                    ?>
                                </select>
                                <label>Materia</label>
                            </div>
                            <div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
                                <select id="selectPeriod" name="selectPeriod">
                                  <option value="" disabled selected>Elegir Período</option>
                                    <?php
                                        for ($i=0; $i < count($list_Periods) ; $i++) {
                                            echo "<option value=".$list_Periods[$i][0].">".$list_Periods[$i][1].": ".$list_Periods[$i][2]." hasta ".$list_Periods[$i][3]."</option>";
                                        }
                                    ?>
                                </select>
                                <label>Período</label>
                            </div>
                        <!-- </div> -->
                    </div>
                    <div class="row">
                        <center>
                            <div class="btnChoseSubject btn waves-effect waves-light black">Ver
                                <i class="material-icons right">send</i>
                            </div>
                        </center>
                    </div>
    			</form>
    		</div>

    		<div class="result_cont col l8 m8 s10 offset-l2 offset-m2 offset-s1">
    			<div class="table_profiles">
	    			<div class="row">
		    			<form>
		    			</form>
	    			</div>

	    			<div class="row btn_cont">
	    				<div class="col l2 m2 s8 offset-l3 offset-m3 offset-s2 btn waves-effect waves-light red btnCancelar">Cancelar
	    					<i class="material-icons right">cancel</i>
	    				</div>
	    				<div class="col l2 m2 s8 offset-l2 offset-m2 offset-s2 btn waves-effect waves-light black btnSave">Guardar
	    					<i class="material-icons right">save</i>
	    				</div>
	    			</div>
    			</div>
                <div class="row errorMessage">

                </div>
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
                    <p>El coordinador podrá eliminar los perfiles de evaluación según el profesor, materia y período seleccionados.</p>
                </div>
            </div>
    	</main>
	</body>
</html>
