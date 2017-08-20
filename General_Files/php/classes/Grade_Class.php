<?php 

	require_once 'Period.php';
	class Grade extends Period{
		
		private $connection;
		private $aux;
		private $admin;
		function __construct(){
			parent::__construct();
			require_once 'Administration.php';
			$this->admin = new Administration();

			require_once('Page_Constructor.php');
			$const = new Constructor();

			$this->aux = $const->getRoute();
			
			require_once($this->aux);
			$this->connection = new Connection();
			$this->connection->Connect();
			//session_start();
		}

		function deleteAsProfile($idProfile){
			$query = "DELETE FROM grade WHERE idProfile = $idProfile";
			$this->connection->connection->query($query);
		}

		function v_addGrade(){/* Vista para que el profesor ingrese notas */
			$period =  $this->getPeriod();
			$public = false;
			if(!isset($_SESSION)){
				session_start();
			}
			
			if ($period) {	
				$query = "SELECT subject.acronym, subject.nameSubject, GROUP_CONCAT(DISTINCT section.SectionIdentifier  ORDER BY section.SectionIdentifier ASC  SEPARATOR ', ') AS section, GROUP_CONCAT(DISTINCT section.idSection  ORDER BY section.idSection ASC  SEPARATOR ', ') AS IdSection,  level.level AS level, COUNT(DISTINCT evaluation_profile.idProfile) AS num_profile, subject.idSubject FROM `subject` INNER JOIN register_subject ON subject.idSubject = register_subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN evaluation_profile ON evaluation_profile.idSubject = subject.idSubject INNER JOIN level ON level.idLevel = section.idLevel WHERE evaluation_profile.idPeriod = '".$period[0][0]."' AND subject.idTeacher = '".$_SESSION['id']."' GROUP BY subject.idSubject";	
				$result = $this->connection->connection->query($query);

				if ($result->num_rows > 0) {
					$form = "<div class='row'> 
						<h3 class='center-align'>Período ".$period[0][4]."</h3>
					<ul class='collection subject with-header col l10 m10 s12 offset-l1 offset-m1'>
					<li class='collection-header container-subject'><h4 class='center-align'>Asignaturas</h4></li>";
					$x = 0;
					while ($fila = $result->fetch_assoc()) {
						if ($fila['nameSubject'] != NULL) {
							$form .= "
					        <li class='collection-item collection-subject'>
						        <div class='name-subject' title='".$fila['nameSubject']."'><h4>".$fila['acronym']."</h4></div>
						        <div class='info-subject'>
						        	<div class='r-divider'>
						        		<div class='level'>
						        			<span class='title'>Nivel: </span><span class='result'> ".$fila['level']."°</span>
							        	</div>
							        	<div class='n-sections'>
							        		<span class='title'>Secciones: </span><span class='result'>".$fila['section']."</span>
							        	</div>
						        	</div>
						        	<div class='r-divider'>
						        		<div class='n-perfiles'>
						        			<span class='title'>Perfiles de evaluación: </span><span class='result n-perfiles'>".$fila['num_profile']."</span>
						        		</div>
						        		<div class='select-sections'>
										  <ul id='dropdown_".$x."' class='dropdown-content'>";
										  		$sections = explode(",", $fila['section']);
										  		$idSections = explode(",", $fila['IdSection']);
											    for ($i=0; $i < count($sections) ; $i++) { 
											    	$form .= "<li id='".$idSections[$i]."' class='select-section'><a>".$sections[$i]."</a></li>";
											    }
									$form.="</ul>
										  <a class='btn dropdown-button green db-section' href='#!' data-activates='dropdown_".$x."' id='".$fila['idSubject']."'>
										  		Sección
										  		<i class='material-icons right'>arrow_drop_down</i>
										  </a>
						        		</div>
						        	</div>
						        </div>
					        </li>
							";
							$x++;
						}else{
							$public = true;
						}
					}
					$form .= "</ul></div>";
				}else{
					$form = "<div class='alert_ red-text text-darken-4'>Este proceso no se puede llevar a cabo sin perfiles de evaluación o asignaturas registrados</div>";
				}
			}else{
				$form = "<div class='alert_ red-text text-darken-4'>Aún no es epoca de ingresar notas</div>";
			}
			return $form = ($public) ? "0" : $form;
		}

		function getProfiles($profiles, $students){
			$profiles = json_decode($profiles);
			$students = json_decode($students);
			$z = 0;
			$profiles_return = array();

			for ($i=0; $i < count($profiles); $i++) { 
				for ($j=0; $j < count($students) ; $j++) { 

					$query = "SELECT * FROM grade WHERE idProfile = '". $profiles[$i]->id ."' AND idStudent = '". $students[$j]->id ."' ";
					$result = $this->connection->connection->query($query);

					if ($result->num_rows > 0) {

						while ($result->fetch_assoc()) {
							$profiles_return[$z] = [
								"id" => $profiles[$i]->id
							];	
							$z++;
						}	
					}
				}
			}

			$form = "<h4 class='center-align'>Perfiles de Evaluación</h4>";
			$form .= "<div class='row'><ul class='collection container-profiles'>";
			$valid = true;
			for ($y=0; $y < count($profiles); $y++) { 

				if (count($profiles_return) > 0) {
					for ($x=0; $x < count($profiles_return) ; $x++) { 
						if ($profiles_return[$x]['id'] == $profiles[$y]->id) {
							$valid = false;
						}
					}
				}
					
				$disabled = ($valid) ? "" : "disabled='disabled'";
				$title = ($valid) ? 'Ingresar Nota' : 'Ya ha ingresado esta nota';
				$form .= "<li class='collection-item'> 
					<h5>". $profiles[$y]->name ." - ".$profiles[$y]->percentage."%</h5>
					<div class='description'>".$profiles[$y]->description."</div>

					<center><button id='".$profiles[$y]->id."' class='waves-effect green btn select-profile' ".$disabled .">".$title."<i class='material-icons right'>send</i></button></center>
					</li>";
				$valid = true;
			}
			$form .= "</ul></div>";
			return $form;
		}

		function getPeriod(){/* Traera el periodo en el que nos encontramos segun fecha actual */
			ini_set("date.timezone", 'America/El_Salvador');
            $date = date("Y-m-d");
			$query = "SELECT * FROM period WHERE startDate BETWEEN startDate AND '$date' AND endDate BETWEEN '$date' AND endDate";

			$result = $this->connection->connection->query($query);
			$valid = false;

			if ($result->num_rows > 0 ) {
				$fila = $result->fetch_assoc();
				$period = array();
				$period[0][0] = $fila['idPeriod'];
				$period[0][1] = $fila['startDate'];
				$period[0][2] = $fila['endDate'];
				$period[0][3] = $fila['percentage'];	
				$period[0][4] = $fila['nthPeriod'];

				$day_start = date("Y-m-d", strtotime("-7 day", strtotime($period[0][2])));

				if ((strtotime($date) >= strtotime($day_start)) && (strtotime($date) <= strtotime($period[0][2]))) {
					$valid = true;
				}
			}
			return ($r = ($valid) ? $period : false);
		}

		function list_students($section){/* Función encaragada de llevar la ista de alumnos para ingresar la nota */
			$query = "SELECT idStudent, name, lastName FROM student WHERE idSection = $section";
			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$form = "<div class='row '><table class='centered responsive-table assistance col l10 m8 s12 offset-l1 offset-m2'> 
						<thead>
							<tr>
								<th># Lista</th>
			                    <th>Carnet</th>
			                    <th>Nombre</th>
			                    <th>Nota</th>
		                    </tr>
	                	</thead>
	                	</tbody>";
	            $x = 0;
				while ($fila = $result->fetch_assoc()) {
					$x++;
					$form .= "<tr class='".$fila['idStudent']."'>
						<td>".$x."</td>
						<td>".$fila['idStudent']."</td>
						<td>".$fila['lastName'].", ".$fila['name']."</td>
						<td>
							<div class='input-field'>
								<input id='".$fila['idStudent']."' type='number' step='0.01'>
          						<label for='".$fila['idStudent']."'>Nota</label>
							</div>
						</td>
					</tr>";
				}
				$form .= "<tbody></table></div><div class='row'>
					<button id='btnSaveGrades' class='col l4 m4 s4 offset-l4 offset-m4 offset-s4 btn waves-effect waves-light green darken-2 btnSave'>Guardar Notas
			    	    <i class='material-icons right'>save</i>
			    	</button>
				</div>";
			}else{
				$form = "<div class='alert_ red-text text-darken-4'>No hay alumnos registrados en dicha sección</div>";
			}
			return $form;
		}

		function InsertGrades($student, $grade, $profile, $subject){

			$query = "INSERT INTO grade(grade, idProfile, idStudent) VALUES('$grade', '$profile', '$student')";
			
			if (($this->connection->connection->query($query)) &&
				($this->InsertAverages($student, $this->getPeriod(), $subject, $grade, $profile)) && 
				($this->InsertACC($student, $subject, $this->getPeriod()))) {
				return true;
			}else{
				return false;
			}
		}

		function InsertAverages($student, $period, $subject, $grade, $profile){
			$query = "SELECT * FROM evaluation_profile WHERE idProfile = '$profile'";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			$grade = $grade * ($fila['percentage'] / 100);

			$query = "SELECT * FROM averages WHERE idStudent = '$student' AND idSubject = '$subject' AND idPeriod = ".$period[0][0]."";
			$result = $this->connection->connection->query($query);

			if ($result->num_rows > 0) {
				$fila = $result->fetch_assoc();
				$average = $fila['average'] + $grade;

				$approved = ($average >= 7) ? 1 : 0; /* Aqui se haria con la nota menor ingresada en inf_gnrl */

				$query  = "UPDATE averages SET average = '$average', approved = '$approved' WHERE idStudent = '$student' AND idSubject = '$subject' AND idPeriod = ".$period[0][0]."";
			}else{
				$average = $grade;
				$approved = ($average >= 7) ? 1 : 0; /* Aqui se haria con la nota menor ingresada en inf_gnrl */

				$query = "INSERT INTO averages(idSubject, idStudent, idPeriod, average, approved) VALUES('$subject', '$student', '".$period[0][0]."', '$average', '$approved')";
			}

			return ($this->connection->connection->query($query));
		}

		function InsertACC($student, $subject, $period){
			$query = "SELECT * FROM averages WHERE idStudent = '$student' AND idSubject = '$subject' AND idPeriod = ".$period[0][0]."";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			$acc = $fila['average'] * ($period[0][3] / 100);

			$query = "SELECT * FROM accumulated_note WHERE idSubject = '$subject' AND idStudent = '$student'";

			$result = $this->connection->connection->query($query);

			if ($result->num_rows > 0) {
				$fila = $result->fetch_assoc();
				$acc = ($fila['acc'] + $acc);
				$approved = ($acc >= 7) ? 1 : 0;

				$query  = "UPDATE accumulated_note SET acc = '$acc' WHERE idSubject = '$subject', approved = '$approved' AND idStudent = '$student'";
			}else{
				$approved = ($acc >= 7) ? 1 : 0;
				$query = "INSERT INTO accumulated_note(idSubject, idStudent, acc, approved) VALUES('$subject', '$student', '$acc', '$approved')";
			}

			return ($this->connection->connection->query($query));
		}

		function getGrades($id)
		{
			if(!isset($_SESSION)){
				session_start();
			}
			$styleHelper = ($_SESSION['type'] == 'S' ? 'blue' : ($_SESSION['type'] == 'T' ? 'green' : 'black'));
			$obj['pInfo'] = $this->getPeriods();
			for ($i=0; $i < count($obj['pInfo']); $i++) { 
				$obj['subject'][$i] = "";
			}

			$accAux = 0;
			$percentageAux = 0;
			$approvedFlag = 0;

			$subjectQuery = "SELECT st.nameSubject, t.name as tName, t.lastName, st.nameSubject, st.acronym, st.idSubject FROM section sn INNER JOIN student s ON s.idSection = sn.idSection INNER JOIN register_subject rs ON sn.idSection = rs.idSection INNER JOIN subject st ON st.idSubject = rs.idSubject INNER JOIN teacher t ON t.idTeacher = st.idTeacher WHERE s.idStudent = '$id' ORDER BY st.nameSubject;";

			$accQuery = "SELECT DISTINCT a.idPeriod
			FROM accumulated_note acc
			INNER JOIN averages a ON a.idStudent = acc.idStudent
			WHERE acc.idStudent = '$id'
			GROUP BY a.idPeriod
			ORDER BY a.idPeriod ASC;";

			$accRes = $this->connection->connection->query($accQuery);

			$subjectRes = $this->connection->connection->query($subjectQuery);

			if ($subjectRes->num_rows == 0) {
				return -1;
			}else{
				while ($subjectRow = $subjectRes->fetch_assoc()) {
					for ($i=0; $i < count($obj['pInfo']); $i++) {
						$percentageAux = 0;
						$accAux = 0;
						$obj['subject'][$i] .= "
								<div class='grade-wrapper'>
					                <div class='grade-header $styleHelper darken-2 white-text'>
					                    <div class='subject'>Materia: <span class='content'>" . $subjectRow['nameSubject'] . " (" . $subjectRow['acronym'] . ")</span></div>
					                    <div class='teacher'>Profesor: <span class='content'>" . $subjectRow['tName'] . " " . $subjectRow['lastName'] ."</span></div>
					                </div>
					                <table class='centered " . $_SESSION['type'] . "'>
				                    <thead class='$styleHelper lighten-4 " . ($_SESSION['type'] == 'C' ? 'white-text' : '') . "'>
					                    <tr>
					                        <th>N°</th>
					                        <th>Perfil de Evaluación</th>
					                        <th><b>%</b></th>
					                        <th>Nota</th>               
					                    </tr>
				                    </thead>
				                    <tbody>";

		                $epQuery = "SELECT * FROM evaluation_profile WHERE idSubject = " . $subjectRow['idSubject'] ." AND idPeriod = " . $obj['pInfo'][$i][0] . " ORDER BY percentage ASC";

		                $epRes = $this->connection->connection->query($epQuery);

		                if ($epRes->num_rows == 0) {
		                	$obj['subject'][$i] .= "
										<tr><td colspan='4' class='red-text'>No se encontraron perfiles de evaluación</td></tr>";
		                }else{
		                	$z = 0;
			                while ($epRow = $epRes->fetch_assoc()) {
			                	$gQuery = "SELECT * FROM grade WHERE idProfile = " . $epRow['idProfile'] . " AND idStudent = '$id';";
			                	$gRes = $this->connection->connection->query($gQuery);

			                	$avQuery = "SELECT * FROM averages WHERE idSubject = " . $subjectRow['idSubject'] ." AND idPeriod = " . $obj['pInfo'][$i][0] . " AND idStudent = '$id';";
			                	$avRes = $this->connection->connection->query($avQuery);

			                	if ($avRes->num_rows == 0) {
			                		$accAux = 0;
			                	}else{
			                		$avRow = $avRes->fetch_assoc();
			                		$accAux = $avRow['average'];
			                		$approvedFlag = $avRow['approved'];
			                	}
			                	$obj['subject'][$i] .= "
		                				<tr>
				                            <td>" . ++$z . "</td>
				                            <td>" . $epRow['name'] . "</td>
				                            <td>" . $epRow['percentage'] . "</td>";
	                            if ($gRes->num_rows == 0) {
	                            	$obj['subject'][$i] .= "<td title='Nota por ingresar!'>NPI</td>";
	                            }else{
				                	$percentageAux += $epRow['percentage'];
	                            	$obj['subject'][$i] .= "<td><b>" . $gRes->fetch_assoc()['grade'] . "</b></td>";
	                            }
				                $obj['subject'][$i] .= "</tr>";
			                }
		                }
		                $obj['subject'][$i] .= "
		                    	</tbody>
			                </table>
			                <div class='grade-footer $styleHelper darken-2'>
								<div class='indicator'>Nota acumulada (Total Procesado: $percentageAux%)</div>
								<div class='grade white-text " . ($approvedFlag ? 'green' : 'red') . " darken-1' title='" . ($approvedFlag ? 'Aprobada' : 'Reprobada') . "'>$accAux</div>
			                </div>
			            </div>";
					}
				}
			}

			if ($accRes->num_rows > 0) {
				$m = 0;
				$obj['acc'] = "<div class='grade-wrapper'>
					<table class='centered responsive-table " . $_SESSION['type'] . "'>
						<thead class='$styleHelper darken-2 white-text'>
							<th>N°</th>
							<th>Materia</th>";
				$pQuery = "SELECT * FROM period p;";

				$pRes = $this->connection->connection->query($pQuery);
				while ($pRow = $pRes->fetch_assoc()) {
					$obj['acc'] .= "
						<th>P" . $pRow['nthPeriod'] . "</th>
						<th>" . $pRow['percentage'] . "%</th>";
				}

				$obj['acc'] .= "<th>ACC</th><th>Estado</th></thead><tbody>";

				$accDataQuery = "SELECT DISTINCT
				acc.acc, acc.approved, s.nameSubject, s.idSubject
				FROM accumulated_note acc
				INNER JOIN subject s ON s.idSubject = acc.idSubject
				WHERE acc.idStudent = '$id'
				ORDER BY s.nameSubject ASC";
				$obj['accBody'] = "";
				$accDataRes = $this->connection->connection->query($accDataQuery);

				while ($accDataRow = $accDataRes->fetch_assoc()) {
					$obj['acc'] .= "
						<tr>
							<td>" . ++$m . "</td>
							<td>" . $accDataRow['nameSubject'] . "</td>";
					$pRes = $this->connection->connection->query($pQuery);
					while ($pRow = $pRes->fetch_assoc()) {
						$accGradesQuery = "SELECT 
						av.average, ROUND(av.average * (p.percentage / 100), 2) as r
						FROM averages av
						INNER JOIN period p ON p.idPeriod = av.idPeriod
						WHERE av.idStudent = '$id' AND p.idPeriod = " . $pRow['idPeriod'] . " AND av.idSubject = " . $accDataRow['idSubject'] . " ORDER BY p.nthPeriod";

						$accGradesRes = $this->connection->connection->query($accGradesQuery);
						if ($accGradesRes->num_rows > 0) {
							while ($accGradesRow = $accGradesRes->fetch_assoc()) {
								$obj['acc'] .= "
									<td>" . $accGradesRow['average'] . "</td>
									<td>" . $accGradesRow['r'] . "</td>
								";
							}
						}else{
							$obj['acc'] .= "
									<td>-</td>
									<td>-</td>";
						}
					}
					$obj['acc'] .= "
							<td>" . $accDataRow['acc'] . "</td>
							<td class='" . ($accDataRow['approved'] ? "green" : "red") . " lighten-4'>" . ($accDataRow['approved'] ? "Aprobada" : "Reprobada") . "</td>
						</tr>
					";
				}

				$obj['acc'] .= "</tbody></table></div>";
			}else{
				$obj['acc'] = null;
			}

			return $obj;
		}

		function printGrades($id, $period)
		{
			$user_info = [];
			$user_info = $this->admin->get_user_data($id);
			$periodQuery = "SELECT * FROM period WHERE idPeriod = $period";
			$periodRes = $this->connection->connection->query($periodQuery);
			$periodRow = $periodRes->fetch_assoc();
			$aux = "
				<table class='infoTable'>
					<tr>
						<td class='photoCell'>
							<img class='profile' src='../../../app/users/files/profile_photos/" . $user_info['photo'] . "'>
						</td>
						<td class='data'>
							<p><span style='font-weight: bold;'>Nombre: </span>" . $user_info['name'] . " ". $user_info['lastName'] . "</p>
							<p><span style='font-weight: bold;'>Código: </span>" . $user_info['id'] . "</p>
							<p><span style='font-weight: bold;'>Grado: </span>" . $user_info['level'] . "°</p>
							<p><span style='font-weight: bold;'>Sección: </span>\"" . $user_info['sectionIdentifier'] . "\"</p>
							<p><span style='font-weight: bold;'>Especialidad: </span>" . $user_info['sName'] . "</p>
						</td>
					</tr>
	            </table>
	            <div class='periodCont'>
				<h2 style='text-align: center;'>Período N° " . $periodRow['nthPeriod'] . "</h2>
				<h3>Fecha de inicio: <span>" . $periodRow['startDate'] . "</span></h3>
				<h3>Fecha de fin: <span>" . $periodRow['endDate'] . "</span></h3>
			</div>";



			$c = 0;
			$subjectQuery = "SELECT st.nameSubject, t.name as tName, t.lastName, st.nameSubject, st.acronym, st.idSubject FROM section sn INNER JOIN student s ON s.idSection = sn.idSection INNER JOIN register_subject rs ON sn.idSection = rs.idSection INNER JOIN subject st ON st.idSubject = rs.idSubject INNER JOIN teacher t ON t.idTeacher = st.idTeacher WHERE s.idStudent = '$id' ORDER BY st.nameSubject;";

			$subjectRes = $this->connection->connection->query($subjectQuery);
			if ($subjectRes->num_rows == 0) {
				$aux = "";
			}else{
				while ($subjectRow = $subjectRes->fetch_assoc()) {
					$percentageAux = 0;
					$accAux = 0;
					$aux .= "
							<div class='grade-wrapper " . ($c == 0 ? 'first' : '') . "'>
				                <div class='grade-header blue darken-2 white-text'>
				                    <div class='subject'>Materia: <span class='content'>" . $subjectRow['nameSubject'] . " (" . $subjectRow['acronym'] . ")</span></div>
				                    <div class='teacher'>Profesor: <span class='content'>" . $subjectRow['tName'] . " " . $subjectRow['lastName'] ."</span></div>
				                </div>
				                <table>
				                    <tr style='background: #BBDEFB;'>
				                        <th>N°</th>
				                        <th>Perfil de Evaluación</th>
				                        <th><b>%</b></th>
				                        <th>Nota</th>
				                    </tr>";
			        $c++;

	                $epQuery = "SELECT * FROM evaluation_profile WHERE idSubject = " . $subjectRow['idSubject'] ." AND idPeriod = " . $period . " ORDER BY percentage ASC";

	                $epRes = $this->connection->connection->query($epQuery);

	                if ($epRes->num_rows == 0) {
	                	$aux .= "<tr><td colspan='4' class='red-text'>No se encontraron perfiles de evaluación</td></tr>";
	                }else{
	                	$z = 0;
		                while ($epRow = $epRes->fetch_assoc()) {
		                	$gQuery = "SELECT * FROM grade WHERE idProfile = " . $epRow['idProfile'];
		                	$gRes = $this->connection->connection->query($gQuery);

		                	$avQuery = "SELECT * FROM averages WHERE idSubject = " . $subjectRow['idSubject'] ." AND idPeriod = " . $period;
		                	$avRes = $this->connection->connection->query($avQuery);

		                	if ($avRes->num_rows == 0) {
		                		$accAux = 0;
		                	}else{
		                		$avRow = $avRes->fetch_assoc();
		                		$accAux = $avRow['average'];
		                		$approvedFlag = $avRow['approved'];
		                	}
		                	$aux .= "<tr>
			                            <td>" . ++$z . "</td>
			                            <td>" . $epRow['name'] . "</td>
			                            <td>" . $epRow['percentage'] . "</td>";
                            if ($gRes->num_rows == 0) {
                            	$aux .= "<td title='Nota por ingresar!'>NPI</td>";
                            }else{
			                	$percentageAux += $epRow['percentage'];
                            	$aux .= "<td><b>" . $gRes->fetch_assoc()['grade'] . "</b></td>";
                            }
			                $aux .= "</tr>";
		                }
	                }
	                $aux .= "
				                <tr>
									<td colspan='3' class='indicator blue'>Nota acumulada (Total Procesado: $percentageAux%)</td>
									<td class='grade white-text " . ($approvedFlag ? 'green' : 'red') . "'>$accAux</td>
				                </tr>
			                </table>
			            </div>
					";
				}
			}

			return $aux;
		}

		function v_modifyGrade(){/* Vista Inicial cuando el profesor quiere modificar notas */
			if(!isset($_SESSION)){
				session_start();
			}
			$query = "SELECT pg.idPermission_Grade, pg.startDate, pg.description, pg.startDate, level.level, COUNT(DISTINCT rp.idStudent) AS numStudent, COUNT(DISTINCT pp.idProfile) AS numProfiles, subject.nameSubject, subject.acronym, teacher.name, teacher.lastName, teacher.idTeacher FROM `pg_students` rp INNER JOIN permission_grade pg ON pg.idPermission_Grade = rp.idPermission INNER JOIN pg_profiles pp ON pp.idPermission = pg.idPermission_Grade INNER JOIN evaluation_profile evp ON evp.idProfile = pp.idProfile INNER JOIN subject ON subject.idSubject = evp.idSubject INNER JOIN teacher ON teacher.idTeacher = subject.idTeacher INNER JOIN register_subject rg ON rg.idSubject = subject.idSubject INNER JOIN section ON section.idSection = rg.idSection INNER JOIN level ON level.idLevel = section.idLevel WHERE pg.approved = 1 AND pp.modified = 0 AND subject.idTeacher = '".$_SESSION['id']."' GROUP BY pg.idPermission_Grade";
			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$form = "<div class='row'> 
					<ul class='collection subject with-header col l10 m10 s12 offset-l1 offset-m1'>
					<li class='collection-header container-subject'><h4 class='center-align'>Prestamos con notas por modificar</h4></li>";
				$x = 0;
				while ($fila = $result->fetch_assoc()) {
					if ($fila['nameSubject'] != NULL) {
						$form .= "
					    <li class='collection-item collection-permission'>
						    <div class='name-subject' title='".$fila['nameSubject']."'><h4>".$fila['acronym']."</h4></div>
						    <div class='info-subject'>
						        <div class='r-divider'>
									<div>
										<span class='title'>Fecha de solicitud: </span><span class='result'> ".$fila['startDate']."</span>
									</div>
						        	<div class='level'>
						        		<span class='title'>Nivel: </span><span class='result'> ".$fila['level']."°</span>
							        </div>
						        </div>
						        <div class='r-divider'>
						        	<div class='n-perfiles'>
						        		<span class='title'>Perfiles por ingresar: </span><span class='result n-perfiles'>".$fila['numProfiles']."</span>
						        	</div>
						        	<div class='select-sections'>
										<span class='title'>Estudiantes: </span><span class='result n-perfiles'>".$fila['numStudent']."</span>
						        	</div>
						        </div>
								<div class='r-divider'>
						        	<div id='".$fila['idPermission_Grade']."' class='btnModalOpen btn waves-effect waves-light green'>
										Ver Información
										<i class='material-icons right'>send</i>
									</div>
						        </div>
						    </div>
					    </li>
						";
						$x++;
					}
				}
				$form .= "</ul></div>";
			}else{
				$form = "<div class='alert_ red-text text-darken-4'>No se ha encontrado prestamos pendientes por modificar</div>";
			}

			return ($form);
		}

		function getGradesModification($idPermission){
			$query = "SELECT pg.idRP, evp.name, evp.percentage, evp.description, evp.idProfile, pg.modified, period.nthPeriod FROM `pg_profiles` pg INNER JOIN evaluation_profile evp ON evp.idProfile = pg.idProfile INNER JOIN subject ON subject.idSubject = evp.idSubject INNER JOIN period ON period.idPeriod = evp.idPeriod WHERE idPermission =  $idPermission";
			$result = $this->connection->connection->query($query);
			$form = "<h4 class='center-align'>Perfiles de Evaluación</h4>";
			while($fila = $result->fetch_assoc()){
				
				$form .= "<div class='row'><ul class='collection container-profiles'>";
				$valid = ($fila['modified'] == 1 ) ? false : true;
				$disabled = ($valid) ? "" : "disabled='disabled'";
				$title = ($valid) ? 'Ingresar Nota' : 'Ya ha ingresado esta nota';
				$form .= "<li class='collection-item'> 
					<h5>". $fila['name'] ." - ".$fila['percentage']."%</h5>
					<div class='description'>".$fila['description']."</div>

					<center><button id='".$fila['idProfile']."' class='waves-effect green btn select_profile' ".$disabled .">".$title."<i class='material-icons right'>send</i></button></center>
					</li>";
				$valid = true;
			}
			$form .= "</ul></div>";
			return $form;
		}

		function Students_Modification($idPermission, $idProfile){
			$query = "SELECT pg.idPermission_Grade, student.idStudent, student.name, student.lastName, lvl.level, section.sectionIdentifier FROM permission_grade pg INNER JOIN pg_profiles pp ON pp.idPermission = pg.idPermission_Grade INNER JOIN pg_students ps ON ps.idPermission = pg.idPermission_Grade INNER JOIN student ON student.idStudent = ps.idStudent INNER JOIN section ON section.idSection = student.idSection INNER JOIN level lvl ON lvl.idLevel = section.idLevel WHERE pg.idPermission_Grade = $idPermission AND pp.idProfile =  $idProfile";
			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$form = "<div class='row '><table class='centered responsive-table assistance col l10 m8 s12 offset-l1 offset-m2'> 
						<thead>
							<tr>
			                    <th>Carnet</th>
			                    <th>Nombre</th>
								<th>Sección</th>
			                    <th>Nota</th>
		                    </tr>
	                	</thead>
	                	</tbody>";
	            $x = 0;
				while ($fila = $result->fetch_assoc()) {
					$x++;
					$form .= "<tr>
						<td>".$fila['idStudent']."</td>
						<td>".$fila['lastName'].", ".$fila['name']."</td>
						<td>".$fila['level']."° '".$fila['sectionIdentifier']."'</td>
						<td>
							<div class='input-field'>
								<input id='".$fila['idStudent']."' type='number' step='0.01'>
          						<label for='".$fila['idStudent']."'>Nota</label>
							</div>
						</td>
					</tr>";
				}
				$form .= "<tbody></table></div><div class='row'>
					<button id='btnSaveGrades' class='col l4 m4 s4 offset-l4 offset-m4 offset-s4 btn waves-effect waves-light green darken-2 btnSave'>Guardar Notas
			    	    <i class='material-icons right'>save</i>
			    	</button>
				</div>";
			}else{
				$form = "<div class='alert_ red-text text-darken-4'>No hay alumnos registrados en dicha sección</div>";
			}
			return $form;
		}

		function UpdateGrade($idProfile, $idPermission, $idStudent, $grade){
			$value = 0;
			$grade_previus = $this->getInfoGrade($idProfile, $idStudent);
			$query = "UPDATE grade SET grade = $grade WHERE grade.idProfile = $idProfile AND grade.idStudent = '".$idStudent."'";
			if($this->connection->connection->query($query)){
				$previus_average = $this->getInfoAverage($grade_previus[0][2], $grade_previus[0][3], $idStudent);
				if($this->UpdateAverages($grade_previus[0][2], $grade_previus[0][3], $grade_previus[0][0], $idStudent, ($grade_previus[0][1] * $grade))){
					$current_average = $this->getInfoAverage($grade_previus[0][2], $grade_previus[0][3], $idStudent);
					if($this->UpdateACC($idStudent, $grade_previus[0][2], $previus_average, $current_average)){
						if($this->changeStatePermission($idProfile, $idPermission)){
							$value = 1;
						}
					}
				}
			}

			return $value;
		}

		function getInfoGrade($idProfile, $idStudent){ /* Se obtiene el resultado anterios - previo a modificar*/
			$query = "SELECT ((evp.percentage / 100) * grade.grade) AS multiplication, evp.percentage, subject.idSubject, period.idPeriod FROM grade INNER JOIN evaluation_profile evp ON evp.idProfile = grade.idProfile INNER JOIN subject ON subject.idSubject = evp.idSubject INNER JOIN period ON period.idPeriod = evp.idPeriod WHERE grade.idProfile = $idProfile AND grade.idStudent = '".$idStudent."'";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			$grade_previus[0][0] = $fila['multiplication'];
			$grade_previus[0][1] = ($fila['percentage'] / 100);
			$grade_previus[0][2] = $fila['idSubject'];
			$grade_previus[0][3] = $fila['idPeriod'];
			return ($grade_previus);
		}
		
		function UpdateAverages($idSubject, $idPeriod, $subtract, $idStudent, $newGrade){
			$query = "UPDATE averages SET average = ((average - $subtract) + $newGrade) WHERE idSubject = $idSubject AND idPeriod = $idPeriod AND idStudent = '".$idStudent."' ";
			$result = $this->connection->connection->query($query);

			$query = "SELECT averages.average FROM averages WHERE idSubject = $idSubject AND idPeriod = $idPeriod AND idStudent = '".$idStudent."'";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			$approved = ($fila['average']  >= 7) ? 1 : 0;

			if($approved == 1){
				$query = "UPDATE averages SET approved = $approved WHERE idSubject = $idSubject AND idPeriod = $idPeriod AND idStudent = '".$idStudent."' ";
				if($this->connection->connection->query($query)){return true;}
			}else{
				return true;
			}
		}

		function getInfoAverage($idSubject, $idPeriod, $idStudent){
			$query = "SELECT (averages.average * (period.percentage / 100)) AS multiplication, period.percentage FROM averages INNER JOIN period ON period.idPeriod = averages.idPeriod WHERE averages.idPeriod = $idPeriod AND averages.idSubject = $idSubject AND averages.idStudent = '".$idStudent."'  ";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			
			return $fila['multiplication'];
		}

		function UpdateACC($idStudent, $idSubject, $substract, $newAcc){
			$query = "UPDATE accumulated_note SET acc = ((acc - $substract) + ($newAcc)) WHERE idSubject = $idSubject AND idStudent = '".$idStudent."'";
			if($this->connection->connection->query($query)){
				$query = "SELECT acc FROM accumulated_note WHERE idSubject = $idSubject AND idStudent = '".$idStudent."'";
				$result = $this->connection->connection->query($query);
				$fila = $result->fetch_assoc();
				$approved = ($fila['acc'] >= 7 ) ? 1 : 0;
				if($approved == 1){
					$query = "UPDATE accumulated_note SET approved = $approved WHERE idSubject = $idSubject AND idStudent = '".$idStudent."'";
					if($this->connection->connection->query($query)){return true;}
				}else{
					return true;
				}
			}
		}

		function changeStatePermission($idProfile, $idPermission){
			$query = "UPDATE pg_profiles SET modified = '1' WHERE idProfile = $idProfile AND idPermission = $idPermission";
			if($this->connection->connection->query($query)){
				return true;
			}
		}
	}
?>