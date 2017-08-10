<?php
	require_once("../../../../General_Files/php/classes/Page_Constructor.php");
    $const = new Constructor();
    $const->verify_Log('C');
    $userRow = $const->getData('C');

    /*Clase Teacher - Para obtener la lista de nombres de profesores*/
    require_once("../../../../General_Files/php/classes/Teacher_Class.php");
    $teacher = new Teacher();
    $list_teachers = $teacher->getTeachers();

    /*Clase Periodo - Para obtener la lista de periodos  */
    require_once("../../../../General_Files/php/classes/Level_Class.php");
    $period = new Level();
    $levels = $period->getLevels();
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
    <script src="../../files/js/c/addSubject.js" charset="utf-8"></script><!-- JS que se alterna -->
</head>
<body>
	<header>
        <nav class="top-nav black">
            <div class="container">
                <div class="nav-wrapper"><a class="page-title">Agregar Asignatura</a></div>
            </div>
        </nav>
        <div class="container">
            <a href="#" data-activates="user_nav" class="button-collapse top-nav full hide-on-large-only"><i class="material-icons">menu</i></a>
        </div>

        <?php echo $const->createElement() ?>
    </header>
	<main class="show">
		<br><br>
		<div class="row">
			<form class="registerSubject col s12">
	    		<div class="row">
	    			<div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
	    				<input id="name" name="name" type="text" class="validate">
	          			<label for="name">Nombre de la materia</label>
	    			</div>
	    			<div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
	    				<input id="acronym" name="acronym" type="text" class="validate">
	          			<label for="acronym">Acrónimo</label>
	    			</div>
	    			<div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
	    				<select class="icons" id="selectTeacher" name="selectTeacher" >
					      <option value="" disabled selected>Elegir profesor</option>
					      	<?php
					      		for ($i=0; $i < count($list_teachers ); $i++) {
					      			echo "<option value='".$list_teachers [$i][0]."' class='circle' data-icon='../../files/profile_photos/".$list_teachers [$i][3]."'>  <p class='teacher_code'>".$list_teachers [$i][0]."</p> - ".$list_teachers [$i][2].", ".$list_teachers [$i][1]."</option>";
					      		 }
					      	?>
	    				</select>
	    				<label>Profesor</label>
	    			</div>
	    			<div class="input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1">
	    				<textarea id="description" name="description" class="materialize-textarea" data-length="500"></textarea>
	            		<label for="description">Descripción</label>
	    			</div>
	    				<div class="input-field col l3 m6 s10 offset-l3 offset-s1 offset-m3">
		    				<select id="selectLevel" name="selectLevel">
						      <option value="" disabled selected>Elegir Nivel</option>
						      	<?php
						      		foreach ($levels as $key => $value) {
						      			echo "<option value=".$key.">".$value."</option>";
						      		}
						      	?>
						    </select>
		    				<label>Nivel</label>
						</div>
	    				<div class="input-field col l3 m6 s10 offset-s1 offset-m3">
							<select id="selectSection" name="selectSection" multiple>
						      <option value="" disabled selected>Elegir Sección</option>
						    </select>
		    				<label>Sección</label>
	    				</div>
	    		</div>
	    		<div class="row">
	    			<center>
	                    <button class="btnSubject btn waves-effect waves-light black" name="action">Registrar
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
                <p>Se podrá agregar una materia (distinta de las ya registradas).Permitiendo que se pueda elegir las secciones a las cuales se impartirá, el profesor, y nivel (Grado).</p>
            </div>
        </div>
	</main>
</body>
</html>
