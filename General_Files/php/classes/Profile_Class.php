<?php 
 
	class Profile{
		
		private $connection;
		private $aux;
		function __construct(){

			require_once('Page_Constructor.php');
			$const = new Constructor();

			$this->aux = $const->getRoute();
			
			require_once($this->aux);
			$this->connection = new Connection();
			$this->connection->Connect();
		}

		function NewProfile($name, $percentage, $period, $subject){
			$query = "INSERT INTO evaluation_profile(name, percentage, idPeriod, idSubject) VALUES('$name', $percentage, $period, $subject)";
			if ($this->connection->connection->query($query)) {
				return true;
			}else{
				return false;
			}
		}

		function countPercentage($percentage, $nthPeriod, $idSubject){

			$query = "SELECT percentage FROM evaluation_profile WHERE idPeriod = $nthPeriod AND idSubject = $idSubject ";
			$result = $this->connection->connection->query($query);
			if($result->num_rows > 0){
				while ($fila = $result->fetch_assoc()) {
					$percentage += $fila['percentage'];
				}
			}
			
			return $res = ($percentage > 100) ? false : true;
		}

		function getProfiles($idSubject, $idPeriod){
			$query = "SELECT evaluation_profile.name AS nameProfile, evaluation_profile.percentage, evaluation_profile.description, subject.nameSubject, period.nthPeriod AS numPeriod, teacher.name, teacher.idTeacher, evaluation_profile.idProfile, teacher.lastName FROM evaluation_profile INNER JOIN subject ON evaluation_profile.idSubject = subject.idSubject INNER JOIN teacher ON subject.idTeacher = teacher.idTeacher INNER JOIN period ON evaluation_profile.idPeriod = period.idPeriod WHERE evaluation_profile.idSubject = $idSubject AND evaluation_profile.idPeriod = $idPeriod ORDER BY evaluation_profile.percentage";

			$result	= $this->connection->connection->query($query);
			$array = array();
			$i = 0;
			while($fila = $result->fetch_assoc()) {
				$array[$i] = [
					"id" => $fila['idProfile'],
					"name" => $fila['nameProfile'],
					"percentage" => $fila['percentage'],
					"description" => $fila['description'],
					"teacherName" => $fila['name'],
					"idTeacher" => $fila['idTeacher'],
					"subject" => $fila['nameSubject'],
					"period" => $fila['numPeriod'],
					"teacherlastName" =>  $fila['lastName']
				];
				$i++;
			}

			return (json_encode($array));
		}

		function modifyProfile($id, $name, $percentage, $description){
			$query = "UPDATE evaluation_profile SET name = '$name' , percentage = $percentage, description = '$description' WHERE idProfile = $id";

			if ($this->connection->connection->query($query)) {
				return true;
			}
		}

		function delete($idProfile){
			$query = "DELETE FROM evaluation_profile WHERE idProfile = $idProfile";
			$this->connection->connection->query($query);
		}

		function getProfilesForDelete($idSubject, $idPeriod){
			$query = "SELECT evaluation_profile.idProfile FROM evaluation_profile WHERE evaluation_profile.idProfile IN (SELECT evaluation_profile.idProfile FROM evaluation_profile INNER JOIN grade ON grade.idProfile = evaluation_profile.idProfile WHERE evaluation_profile.idPeriod = $idPeriod AND evaluation_profile.idSubject = $idSubject)";

			$result = $this->connection->connection->query($query);
			$profiles = array();
			$info = array();
			$i = 0;
			
			if ($result->num_rows > 0) {
				while ($fila = $result->fetch_assoc()) {
					$profiles[$i] = $fila['idProfile'];
					$i++;
				}
			}else{
				$profiles[0] = 0;
			}

			$i = 0;
			for ($x=0; $x < count($profiles) ; $x++) { 
				$query = "SELECT evaluation_profile.name AS nameProfile, evaluation_profile.percentage, evaluation_profile.description, subject.nameSubject, period.nthPeriod AS numPeriod, teacher.name, teacher.idTeacher, evaluation_profile.idProfile FROM evaluation_profile INNER JOIN subject ON evaluation_profile.idSubject = subject.idSubject INNER JOIN teacher ON subject.idTeacher = teacher.idTeacher INNER JOIN period ON evaluation_profile.idPeriod = period.idPeriod WHERE evaluation_profile.idProfile != '".$profiles[$x]."' GROUP BY evaluation_profile.idProfile ORDER BY evaluation_profile.name ";
				$result = $this->connection->connection->query($query);
				while ($fila = $result->fetch_assoc()) {

					$info[$i] = [
						"id" => $fila['idProfile'],
						"name" => $fila['nameProfile'],
						"percentage" => $fila['percentage'],
						"description" => $fila['description'],
						"teacherName" => $fila['name'],
						"idTeacher" => $fila['idTeacher'],
						"subject" => $fila['nameSubject'],
						"period" => $fila['numPeriod']
					];			
					$i++;
				}
			}
			return (json_encode($info));
		}

		function getProfilesForView($idSubject){
			$query = "SELECT evaluation_profile.name AS nameProfile, evaluation_profile.percentage, evaluation_profile.description, subject.nameSubject, period.nthPeriod AS numPeriod, teacher.name, teacher.idTeacher, evaluation_profile.idProfile FROM evaluation_profile INNER JOIN subject ON evaluation_profile.idSubject = subject.idSubject INNER JOIN teacher ON subject.idTeacher = teacher.idTeacher INNER JOIN period ON evaluation_profile.idPeriod = period.nthPeriod WHERE evaluation_profile.idSubject = $idSubject ORDER BY period.nthPeriod";
			$result	= $this->connection->connection->query($query);
			$array = array();
			$i = 0;
			while($fila = $result->fetch_assoc()) {
				$array[$i] = [
					"id" => $fila['idProfile'],
					"name" => $fila['nameProfile'],
					"percentage" => $fila['percentage'],
					"description" => $fila['description'],
					"teacherName" => $fila['name'],
					"idTeacher" => $fila['idTeacher'],
					"subject" => $fila['nameSubject'],
					"period" => $fila['numPeriod']
				];
				$i++;
			}
			return (json_encode($array));
		}

		function v_tableAdd($period){
			$query = "SELECT subject.nameSubject, teacher.name, teacher.lastName, subject.idSubject, level.level, GROUP_CONCAT('''', section.SectionIdentifier, '''' SEPARATOR ', ') AS section FROM subject INNER JOIN register_subject ON subject.idSubject = register_subject.idSubject INNER JOIN teacher ON subject.idTeacher = teacher.idTeacher INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON level.idLevel = section.idLevel GROUP BY subject.idSubject ";
			$result = $this->connection->connection->query($query);

			if ($result->num_rows > 0) {
				$table = "<br><div class='container'><div class='row'><table class='centered responsive-table col l10 m10 s10 offset-l1 offset-m1 offset-s1'>
					<thead>
						<th>Asignatura</th>
						<th>Profesor</th>
						<th>Porcentaje</th>
						<th>Nivel</th>
						<th>Secciones</th>
						<th>Opción</th>
					</thead>
					<tbody>
				";
				while ($fila = $result->fetch_assoc()) {

					$query_profiles = "SELECT * FROM evaluation_profile WHERE idSubject = '".$fila['idSubject']."' AND evaluation_profile.idPeriod = '".$period."'";
					$result_profile = $this->connection->connection->query($query_profiles);
					$percentage = 0;

					if ($result_profile->num_rows > 0) {
						while ($fila_profile = $result_profile->fetch_assoc()) {
							$percentage += $fila_profile['percentage'];
						}
					}
					
					if ($percentage < 100) {
						$disabled = "";
						$class_tr = "";
						$title = "";
					}else{
						$disabled = "";
						$class_tr = "";
						$title = "";
						$disabled = "disabled = 'disabled'";
						$class_tr = "#9e9e9e grey";
						$title = "Materia con el 100% registrado";
					}

				 	$table .= "<tr class='".$class_tr."' title='".$title."'>
						<td>".$fila['nameSubject']."</td>
						<td>".$fila['lastName'].", ".$fila['name']."</td>
						<td>".$percentage."%</td>
						<td>".$fila['level']."°</td>
						<td>".$fila['section']."</td>
						<td>
							<input type='checkbox' class='btn_checkbox' id=".$fila['idSubject']." $disabled/>
	          				<label for=".$fila['idSubject'].">Seleccionar</label>
						</td>
				 	<tr>
				 	";
				}
				$table .= "</tbody></table></div>
					
						<form class='addProfile'>
							<div class='row'>
								<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
				    				<input id='profile_name' name='profile_name' type='text' class='validate'>
				          			<label for='profile_name'>Nombre</label>
				    			</div>
				    			<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
				    				<input id='percentage' name='percentage' type='number' min='0' max='100' class='validate'>
				          			<label for='percentage'>Porcentaje(%)</label>
				    			</div>
							</div>
							<div class='row'>
								<button class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black btnSave'>Guardar
			    	    		<i class='material-icons right'>save</i>
			    	    		</button>
							</div>
						</form>	
				</div>
				";
			}else{
				$table = "0";
			}
			return $table;
		}

		function v_AddPeriod($periods){
			if (count($periods) > 0) {
				$options_periods = "";
				for ($i=0; $i < count($periods); $i++) { 
					$options_periods .= "<option value='".$periods[$i][0]."'>".$periods[$i][1].": ".$periods[$i][2]." hasta ".$periods[$i][3]."</option>";
				}
				$select_period = "<br><div class='container'>
					<div class='row'>
						
						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
				            <select id='selectPeriod'>
				                <option value='' disabled selected>Seleccionar Período</option>	
				                $options_periods
							</select>
							<label>Elegir Período</label>
			          	</div>
						<div class='container-form'>

						</div>
					</div> 
				</div>"; 
			}else{
				$select_period = 0;
			}
			return $select_period;	
		}

		function table_modifyProfile($subject, $period){
			$query = "SELECT * FROM evaluation_profile WHERE idSubject = $subject AND idPeriod = $period  ORDER BY percentage";
			$result = $this->connection->connection->query($query);
			$i = 0;

			if ($result->num_rows > 0) {
				$form = "<br><br><form  id='modifyProfile'>";
				while ($fila = $result->fetch_assoc()) {
					$clase_txt = ($fila['description'] != '') ? 'active' : '';

					$form .= "<div class='row'>
						<div class='title-profile col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
							<blockquote><h5 class='center-align'>".$fila['name']."</h5></blockquote>
							<div class='percentage'>".$fila['percentage']." %</div>
						</div>
						
						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
							<input type='text' id='name".$i."' name='name".$i."' value='".$fila['name']."'>
							<label for='name".$i."' class='active'>Nombre: </label>
						</div>
						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
							<textarea class='materialize-textarea' name='description".$i."' data-length='500' id='description".$i."'>".$fila['description'] ."</textarea>
							<label for='description".$i."' class='".$clase_txt."'>Descripción</label>
						</div>
					</div>";
					$i++;
				}
				$form .= "
					<div class='row col s12'>
						<button class='btnSaveModify btn waves-effect waves-light black col l2 m2 s4 offset-l5 offset-m5 offset-s4' >
							Guardar
							<i class='material-icons right'>save</i>
						</button>
					</div>
				</form>";
				return $form;
			}else{
				$a = "-2";
				return $a;
			}
		}

		function v_modifyProfile($list_teachers, $list_periods){
			$form = "<form class='v_profiles'><br><br> 
				<div class='row'>
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<select id='selectTeacher' name='selectTeacher'>
							<option value='' disabled selected>Elegir Profesor</option>
							";
							for ($i=0; $i < count($list_teachers ); $i++) {
                                $form .= "<option value='".$list_teachers [$i][0]."' class='circle' data-icon='../../files/profile_photos/".$list_teachers [$i][3]."'>  <p class='teacher_code'>".$list_teachers [$i][0]."</p> - ".$list_teachers [$i][2].", ".$list_teachers [$i][1]."</option>";
                            }
			$form .="	</select>
						<label>Profesor</label>
					</div>
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
                        <select id='selectSubject' name='selectSubject'>
                            <option value='' disabled selected>Elegir Materia</option>
                        </select>
                        <label>Materia</label>
                    </div>
                    <div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
                    	<select id='selectPeriod' name='selectPeriod'>
                        	<option value='' disabled selected>Elegir Período</option>";
                        	for ($i=0; $i < count($list_periods); $i++) { 
                        		$form .= "<option value=".$list_periods[$i][0].">".$list_periods[$i][1].": ".$list_periods[$i][2]." hasta ".$list_periods[$i][3]."</option>";
                        	}
			$form .="	</select>
                        <label>Período</label>
					</div>
					<div class='row col s12'>
						<div class='btnModifyProfile btn waves-effect waves-light black col l2 m2 s4 offset-l5 offset-m5 offset-s4'>Ver
							<i class='material-icons right'>send</i>
						</div>
					</div>
			</form>";

			return $form;
		}

		function v_Justification(){ /* Vista se carga cuando el profesor quiere agregar justificación */
			$query = "SELECT * FROM period";
			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$form = "<div class='row'>
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<select id='selectPeriod' name='selectPeriod'>
							<option value='' disabled selected>Elegir Período</option>";
				while ($fila = $result->fetch_assoc()) {
					$form .= "<option value='".$fila['idPeriod']."' >Período N° ".$fila['nthPeriod']."</option>";
				}
				$form .= "
						</select>
						<label>Período</label>
					</div>
				</div>";
			}else{
				$form = "<div class='.alert_ col s8 offset-s2'><span>No hay períodos ingresados</span></div>";
			}
			return $form;
		}

		function tableSubject_Justification($period){
			session_start();
			$query = "SELECT subject.acronym, subject.nameSubject, GROUP_CONCAT(DISTINCT section.SectionIdentifier  ORDER BY section.SectionIdentifier ASC  SEPARATOR ', ') AS section, GROUP_CONCAT(DISTINCT section.idSection  ORDER BY section.idSection ASC  SEPARATOR ', ') AS IdSection,  level.level AS level, COUNT(DISTINCT evaluation_profile.idProfile) AS num_profile, subject.idSubject FROM `subject` INNER JOIN register_subject ON subject.idSubject = register_subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN evaluation_profile ON evaluation_profile.idSubject = subject.idSubject INNER JOIN level ON level.idLevel = section.idLevel WHERE evaluation_profile.idPeriod = '".$period."' AND subject.idTeacher = '".$_SESSION['id']."' AND evaluation_profile.description = '' GROUP BY subject.idSubject ORDER BY level.level";

			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$form ="<div class='row'>
					<ul class='collection subject with-header col l10 m10 s12 offset-l1 offset-m1'>
					<li class='collection-header container-subject'><h4 class='center-align'>Asignaturas</h4></li>";
				while ($fila = $result->fetch_assoc()) {
					$form .= "
					<li class='collection-item collection-subject'>
						<div class='name-subject' title='".$fila['nameSubject']."'>
							<h4>".$fila['acronym']."</h4>
						</div>
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
						    	<div class=''>
									<div class='n-perfiles'>
						        		<span class='title'>Por ingresar: </span><span class='result n-perfiles'>".$fila['num_profile']."</span>
						        	</div>
						    	</div>
						    	<div>
						    		<button class='btn waves-effect waves-light green btnProfiles' id='".$fila['idSubject']."'>Ver Perfiles
    									<i class='material-icons right'>send</i>
  									</button>
						    	</div>
						    </div>
						</div>
					</li>";
				}
				$form .= "</ul></div>";
			}else{
				$form = "<div class='alert_ col s8 offset-s2'><span>No hay perfiles de evaluación con descriciones por ingresar en este período</span></div>";
			}

			return $form;
		}

		function getForJustification($subject){
			$query = "SELECT evaluation_profile.name, evaluation_profile.percentage, evaluation_profile.idProfile FROM evaluation_profile WHERE evaluation_profile.idSubject = '$subject' AND evaluation_profile.description = ''";
			$result = $this->connection->connection->query($query);
			$form = "";
			$i = 0;
			while ($fila = $result->fetch_assoc()) {
				$form .= "
				<div class='row'>
					<div class='title-profile col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<blockquote profile_id='".$fila['idProfile']."'><h5 class='center-align'>".$fila['name']."</h5></blockquote>
						<div class='percentage'>".$fila['percentage']." %</div>
					</div>
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<textarea class='materialize-textarea txtForm' name='description".$i."' data-length='500' id='description".$i."'></textarea>
						<label for='description".$i."'>Descripción</label>
					</div>
				</div>";
				$i++;
			}
			$form .= "
					<div class='row col s12'>
						<button class='SaveJustification btn waves-effect waves-light col l2 m2 s4 offset-l5 offset-m5 offset-s4 green darken-2' >
							Guardar
							<i class='material-icons right'>save</i>
						</button>
					</div>
				</form>";
			return $form;
		}

		function InsertJustification($id, $description){
			$query = "UPDATE evaluation_profile SET description = '$description' WHERE idProfile = $id ";
			return ($this->connection->connection->query($query));
		}
	}
?>
