<?php

	class Router
	{
		private $options = [];
		private $element = "";
		function __construct($type = 'C')
		{
			$this->options[count($this->options)] = ["Inicio", "home", "index"];
			if ($type == 'C') {
				$this->options[count($this->options)] = ["Registrar", "group_add", [
					["Estudiantes", "child_care", "register_student"],
					["Docentes", "face", "#!"],
					["Coordinadores", "person", "#!"]
				]];
				$this->options[count($this->options)] = ["Secciones", "tab", [
					["Añadir", "library_add", ""],
					["Eliminar", "delete", ""],
					["Ver", "visibility", ""]
				]];
				$this->options[count($this->options)] = ["Especialidades", "stars", [
					["Añadir", "library_add", ""],
					["Eliminar", "delete", ""],
					["Ver", "visibility", ""]
				]];
				$this->options[count($this->options)] = ["Horarios", "schedule", [
					["Asignar horario", "assignment", "add_schedule"],
					["Modificar horario", "assignment_ind", "modify_schedule"],
					["Eliminar horario", "assignment_returned", "delete_schedule"]
				]];
				$this->options[count($this->options)] = ["Períodos", "timeline", [
					["Añadir", "library_add", "add_period"],
					["Modificar", "edit", "modify_period"],
					["Ver", "visibility", "v_period"]
				]];
				$this->options[count($this->options)] = ["Perfiles de evaluación", "starts", [
					["Eliminar", "delete", "delete_profile"],
					['Modificar', "edit", "modify_profile"],
					["Ver", "visibility", "v_profile"]
				]];
				$this->options[count($this->options)] = ["Asignaturas", "description", [
					["Añadir", "library_add", "add_subject"],
					["Asignar secciones", "format_list_numbered", "assign_subjectSection"],
					["Cambiar profesor", "repeat", "switch_teacherSubject"],
					["Eliminar", "delete", "delete_subject"],
					["Ver", "visibility", "v_subjects"]
				]];
				$this->options[count($this->options)] = ['Códigos', "warning", [
					["Añadir", "library_add", "add_code"],
					["Modificar", "edit", "modify_code"],
					["Eliminar", "delete", "delete_code"],
					["Ver", "visibility", "v_code"],
				]];
				$this->options[count($this->options)] = ['Administración', "folder", "administration"];
				$this->options[count($this->options)] = ['Estadísticas', "insert_chart", "stadistics"];
			}elseif($type == 'T'){
				$this->options[count($this->options)] = ["Ver horario", "schedule", "schedule"];
				$this->options[count($this->options)] = ["Asistencia", "date_range", "assistance"];
				$this->options[count($this->options)] = ["Agregar notas", "grade", "addGrade"];
			}else{
				$this->options[count($this->options)] = ['Ver notas', "grades", "grades"];
				$this->options[count($this->options)] = ['Récord conductual', "favorite", "record"];
				$this->options[count($this->options)] = ['Ver horario', "schedule", "schedule"];
			}

			$this->options[count($this->options)] = ['Configuración', "settings", "config"];
		}

		function createElement()
		{
			require_once("Page_Constructor.php");
		    $const = new Constructor();
		    $const->verify_Log($_SESSION['type']);
		    $userRow = $const->getData($_SESSION['type']);
		    $aux = explode('/', $_SERVER['PHP_SELF']);
			$folder = $aux[count($aux) - 2];
			$file = explode('.', $aux[count($aux) - 1])[0];
			$pathAux = ($folder == 'views' ? '../../' : '../');
			$filesAux = ($folder != 'views' ? 'views/' : '');
			$this->element .= "<ul id='user_nav' class='side-nav fixed'>

			<li>
                <div class='userView'>
                    <div class='background'>
                        <img src='" . $pathAux . "files/img/" . ($_SESSION['type'] == 'C' ? 'coor.jpg' : ($_SESSION['type'] == 'T' ? 'teacher.jpg' : 'student.jpg')) . "' width='100%'>
                    </div>
                    <img class='circle' src='" . $pathAux . "files/profile_photos/" . $userRow['photo'] . "'>
                    <span class='white-text name'>" . explode(' ', $userRow['name'])[0] . ' ' . explode(' ', $userRow['lastName'])[0] . "</span>
                    <span class='white-text email'>" . ($_SESSION['type'] == 'T' ? 'Docente' : ($_SESSION['type'] == 'C' ? ( $userRow['sex'] == 'F' ? 'Coordinadora' : 'Coordinador' ) : 'Estudiante')) . "</span>
                </div>
            </li>";

			for ($i=0; $i < count($this->options); $i++) {
				if (is_array($this->options[$i][2])) {
					$auxiliar = "";
					$auxC = null;
					// $activeFlag = 0;
		            for ($j=0; $j < count($this->options[$i][2]); $j++) { 
						$activeFlag = ($file ==  $this->options[$i][2][$j][2] ? 1 : 0);
		            	$auxiliar .= "
		            		<li " . ($activeFlag ? "class='active'" : '') . "><a href='" . $filesAux . $this->options[$i][2][$j][2] . ".php' class='waves-effect'>" . $this->options[$i][2][$j][0] . "<i class='material-icons'>" . $this->options[$i][2][$j][1] . "</i></a></li>
		            	";
		            	if($activeFlag) $auxC = $j;
		            }
		            if (is_null($auxC)) {
		            	$activeFlag = 0;
		            }else{
			            $activeFlag = ($file == $this->options[$i][2][$auxC][2] ? 1 : 0);
		            }
					$this->element .= "
						<li class='no-padding'>
		                <ul class='collapsible collapsible-accordion'>
		                    <li>
		                        <a class='collapsible-header waves-effect " . ($activeFlag ? 'active' : '') . "'>" . $this->options[$i][0] . "<i class='material-icons'>" . $this->options[$i][1] . "</i></a>
		                        <div class='collapsible-body'>
		                            <ul>$auxiliar</ul>
		                        </div>
		                    </li>
		                </ul>
		            </li>
					";
				}else{
					$activeFlag = ($file == $this->options[$i][2] ? 1 : 0);
					if ($this->options[$i][0] == 'Inicio') {
						$this->element.= "
							<li " . ($activeFlag ? "class='active'" : '') . "><a href='/Ezic/app/home/index.php' class='waves-effect'>" . $this->options[$i][0] . "<i class='material-icons'>" . $this->options[$i][1] . "</i></a></li>
						";
					}else{
						if($this->options[$i][0] == 'Configuración') $this->element .= "<li><a class='subheader'>Cuenta</a></li>";
						$this->element.= "
							<li " . ($activeFlag ? "class='active'" : '') . "><a href='" . $filesAux . $this->options[$i][2] . ".php' class='waves-effect'>" . $this->options[$i][0] . "<i class='material-icons'>" . $this->options[$i][1] . "</i></a></li>
						";
						if($this->options[$i][0] == 'Configuración') $this->element .= "<li><div class='divider'></div></li>";
					}
				}
			}
			$this->element .= "<li><a class='waves-effect btnUnlog'><i class='material-icons'>cancel</i>Cerrar Sesión</a></li></ul>";

            return $this->element;
		}
	}
?>