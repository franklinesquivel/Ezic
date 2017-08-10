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

            <?php echo $const->createElement() ?>
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
