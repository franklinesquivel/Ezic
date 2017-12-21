<?php 
	
	require_once 'Administration.php';
	require_once('Level_Class.php');
	class Section extends Level{
		private $alphabet;
		private $admin;
		function __construct(){
			parent::__construct();
			$this->alphabet = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$this->admin = new Administration();
		}

		function getSections($idLevel){
			$query = "SELECT * FROM section sn INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty Where idLevel = $idLevel ORDER BY sectionIdentifier";
			$result = $this->connection->connection->query($query);
			$sections = array();
			$i = 0;

			while ($fila = $result->fetch_assoc()) {

				$sections[$i] = [
					'id' => $fila['idSection'],
					'nombre' => $fila['sName'],
					'seccion' => $fila['sectionIdentifier']
				];

				$i++;
			}

		   	return (json_encode($sections));
		}

		function getForSubject($idSubject){//Función realizada para: assign_subjectSection.php

			$query_infoS = "SELECT level.idLevel FROM subject INNER JOIN register_subject rs ON rs.idSubject = subject.idSubject INNER JOIN section ON section.idSection = rs.idSection INNER JOIN level ON level.idLevel = section.idLevel WHERE subject.idSubject = $idSubject LIMIT 1";
			$result_infoS = $this->connection->connection->query($query_infoS);
			$fila_infoS = $result_infoS->fetch_assoc();


			$query = "SELECT section.idSection, level.idLevel AS level FROM section INNER JOIN level ON section.idLevel = level.idLevel WHERE section.idSection NOT IN (SELECT section.idSection FROM section INNER JOIN register_subject ON register_subject.idSection = section.idSection INNER JOIN level ON section.idLevel = level.idLevel WHERE register_subject.idSubject = $idSubject)";
			$result = $this->connection->connection->query($query);
			$sections = array();//Aqui Se guardaran las secciones en las cuales ya esta esa materia
			$info = array();
			$i = 0;

			while ($fila = $result->fetch_assoc()) {
				$sections[$i][0] = $fila['idSection'];
				$sections[$i][1] = $fila_infoS['idLevel'];
				$i++;
			}

			$i = 0;
			for ($x=0; $x <count($sections) ; $x++) { 
				$query = "SELECT section.idSection, specialty.sName, section.sectionIdentifier, level.level FROM `section` INNER JOIN level ON level.idLevel = section.idLevel INNER JOIN specialty ON section.idSection = specialty.idSpecialty WHERE section.idSection = ".$sections[$x][0]." AND level.idLevel  = ".$sections[$x][1]."";
				$result = $this->connection->connection->query($query);
				while ($fila = $result->fetch_assoc()) {
					$info[$i] = [
						'id' => $fila['idSection'],
						'nombre' => $fila['sName'],
						'seccion' => $fila['sectionIdentifier'],
						'level' => $fila['level']
					];			
					$i++;
				}
			}

		   	return (json_encode($info));
		}

		function filterSectionsForMandated($lvl, $spcty, $sctn)
		{
			$aux = "";
			$query = "SELECT * FROM section sn INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty WHERE sn.sState = 0" . ($lvl != '' ? " AND ll.idLevel = $lvl " . ($spcty != '' ? "AND sy.idSpecialty = $spcty " . ($sctn != '' ? "AND sn.idSection = $sctn" : '') : '') : ';');

			// return $query;

			$res = $this->connection->connection->query($query);

			if($res->num_rows == 0) return -1;
			while ($row = $res->fetch_assoc()) {
				$cantNONQuery = "SELECT COUNT(*) as nonV FROM student WHERE verified = 0 AND idSection = " . $row['idSection'];
				$cantQuery = "SELECT COUNT(*) as total FROM student WHERE idSection = " . $row['idSection'];
				$cantNON = $this->connection->connection->query($cantNONQuery)->fetch_assoc()['nonV'];
				$cant = $this->connection->connection->query($cantQuery)->fetch_assoc()['total'];
				$aux .= "
					<a class='collection-item waves-effect sctnItem waves-black ' idSn='" . $row['idSection'] . "'>
	                    <span class='title black-text'> " . $row['level'] . "° Grado, &nbsp</span>
	                    <span class='title black-text'><i>" . $row['sName'] . ":</i> &nbsp </span>
	                    <span class='title black-text'><b>Sección <i>\"". $row['sectionIdentifier'] ."\"</i></b></span><br>
	                    <span title='Cantidad de Estudiantes' class='grey-text text-darken-1'>" . $cantNON . " estudiantes sin verificar /$cant</span>
	                </a>
				";
			}

			return $aux;
		}

		function filterSections($lvl, $spcty, $sctn)
		{
			$aux = "";
			$query = "SELECT * FROM section sn INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty " . ($lvl != '' ? "WHERE ll.idLevel = $lvl " . ($spcty != '' ? "AND sy.idSpecialty = $spcty " . ($sctn != '' ? "AND sn.idSection = $sctn" : '') : '') : ';');

			$res = $this->connection->connection->query($query);

			if($res->num_rows == 0) return -1;

			while ($row = $res->fetch_assoc()) {
				$aux .= "
					<a class='collection-item waves-effect waves-black ' idSn='" . $row['idSection'] . "'>
	                    <span class='title black-text'> " . $row['level'] . "° Grado, &nbsp</span>
	                    <span class='title black-text'><i>" . $row['sName'] . ":</i> &nbsp </span>
	                    <span class='title black-text'><b>Sección <i>\"". $row['sectionIdentifier'] ."\"</i></b></span>
	                </a>
				";
			}

			return $aux;
		}

		function filterSectionsForRegister($lvl, $spcty, $sctn)
		{	
			$obj = [];
			$aux = "";
			$query = "SELECT sy.sName AS name, sn.sectionIdentifier AS identifier, (SELECT COUNT(*) FROM student s WHERE s.idSection = sn.idSection) AS studentCant, ll.level, sn.idSection FROM section sn INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty " . ($lvl != '' ? "WHERE ll.idLevel = $lvl " . ($spcty != '' ? "AND sy.idSpecialty = $spcty " . ($sctn != '' ? "AND sn.idSection = $sctn" : '') : '') : ';');

			$maxQuery = "SELECT max_student AS max FROM gnrl_info;";
			$maxStudents = $this->connection->connection->query($maxQuery)->fetch_assoc()['max'];

			$res = $this->connection->connection->query($query);

			if($res->num_rows == 0) return -1;

			$obj['sctns'] = [];
			while ($row = $res->fetch_assoc()) {
				$auxObj = [];
				foreach ($row as $key => $value) {
					$auxObj[$key] = $value;
				}

				$aux .= "
					<a class='collection-item waves-effect waves-black sctnItem' idSn='" . $row['idSection'] . "'>
	                    <span class='title black-text'> " . ($row['level'] == 1 ? '1er' : ($row['level'] == 2 ? '2do' : '3er')) . " Año, &nbsp</span><br class='hide-on-med-and-up'>
	                    <span class='title black-text'><i>" . $row['name'] . ":</i> &nbsp </span><br class='hide-on-med-and-up'>
	                    <span class='title black-text'><b>Sección <i>\"". $row['identifier'] ."\"</i></b></span><br class='hide-on-med-and-up'>
	                    <span title='Cantidad de Estudiantes' class='right badge black white-text'>" . $row['studentCant'] . "/$maxStudents</span>
	                </a>";
	            array_push($obj['sctns'], $auxObj);
			}
			$obj['max'] = $maxStudents;
			$obj['el'] = $aux;
			return json_encode($obj);
		}

		function showSection($id)
		{
			$aux = "";
			$f = 1;
			$z = 0;
			$query = "SELECT * FROM student st INNER JOIN section sn ON st.idSection = sn.idSection INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty WHERE st.idSection = $id ORDER BY st.lastName ASC;";
			$res = $this->connection->connection->query($query);
			if ($res->num_rows == 0) return -1;

			while ($row = $res->fetch_assoc()) {
				if ($f) {
					$aux .= "
					<div class='section-header'>
		                 <p>" . $row['level'] . ($row['level'] == 1 ? 'er' : ($row['level'] == 2 ? 'do' : 'er')) . " Año de Bachillerato</p>
		                 <p>" . $row['sName'] . "</p>
		                 <p>Sección: \"" . $row['sectionIdentifier'] . "\"</p>
		            </div>
		            <table class='centered responsive-table striped'>
		                <thead>
		                    <th>N°</th>
		                    <th>Código</th>
		                    <th>Apellidos</th>
		                    <th>Nombres</th>
		                    <th>Email</th>
		                </thead>
		                <tbody>";
	                $f = 0;
				}
			 	$aux .= "
		                    <tr>
		                        <td>" . ++$z . "</td>
		                        <td>" . $row['idStudent'] . "</td>
		                        <td>" . $row['lastName'] . "</td>
		                        <td>" . $row['name'] . "</td>
		                        <td>" . $row['email'] . "</td>
		                    </tr>
			 	";
			}

			$aux .= "</tbody></table></div>";

			return $aux;
		}

		function printSection($id, $c = 5)
		{
			$aux = "";
			$f = 1;
			$z = 0;
			$query = "SELECT * FROM student st INNER JOIN section sn ON st.idSection = sn.idSection INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty WHERE st.idSection = $id ORDER BY st.lastName ASC;";
			$res = $this->connection->connection->query($query);
			if ($res->num_rows == 0) return -1;

			while ($row = $res->fetch_assoc()) {
				if ($f) {
					$aux .= "
					<div class='section-header'>
		                 <div><b>Grado: </b>" . $row['level'] . ($row['level'] == 1 ? 'er' : ($row['level'] == 2 ? 'do' : 'er')) . " Año de Bachillerato</div>
		                 <div><b>Especialidad: </b>" . $row['sName'] . "</div>
		                 <div><b>Sección:</b> \"" . $row['sectionIdentifier'] . "\"</div>
		            </div>
		            <table class='centered responsive-table striped'>
			            <tr><th colspan='3' class='hideTh'></th>";
					for ($i=0; $i < $c; $i++) { 
	                	$aux .= "<th rowspan='1' class='optionCellTop'></th>";
	                } 
		            $aux .= "</tr>
		                <tr>
		                    <th>N°</th>
		                    <th>Código</th>
		                    <th>Nombre Completo</th>";
                for ($i=0; $i < $c; $i++) { 
                	$aux .= "<th rowspan='1' class='optionCell'></th>";
                }  
	                $aux .= "</tr>";
	                $f = 0;
				}
			 	$aux .= "
	                    <tr>
	                        <td>" . ++$z . "</td>
	                        <td>" . $row['idStudent'] . "</td>
	                        <td>" . $row['lastName'] . ", " . $row['name'] . "</td>";
                for ($i=0; $i < $c; $i++) { 
                	$aux .= "<td class='optionCell'></td>";
                } 
                    $aux .= "</tr>
			 	";
			}

			$aux .= "</table></div>";

			return $aux;
		}

		function uploadPhotos($file)
		{
			if (isset($file["tmp_name"])) {
				$fileRoute = "../../files/tmp/sectionPhotos.zip";
				if(move_uploaded_file($file['tmp_name'], $fileRoute)){
					$info = [];
					$zip = new ZipArchive;
					$res = $zip->open($fileRoute);

					if ($res === TRUE) {
						$info['cant'] = $zip->numFiles;
						$info['matches'] = 0;
						$info['img'] = 0;
						$info['students'] = [];
						$zip->extractTo("../../files/tmp/sectionPhotos");
						$zip->close();
						$newPhotos = [];
						$oldPhotos = [];
						$preUp = "";

						if ($info['cant'] > 0) {
							foreach (glob("../../files/tmp/sectionPhotos/[a-zA-Z][a-zA-Z][0-9][0-9][0-9][0-9].{jpg,png,jpeg}", GLOB_BRACE) as $img){
								$aux = [];
								$img = explode('/', $img)[count(explode('/', $img)) - 1];
								$aux['name'] = strtoupper(explode('.', $img)[0]);
								$aux['type'] = explode('.', $img)[1];
								array_push($newPhotos, $aux);
								$info['img']++;
							}

							foreach (glob("../../files/profile_photos/[a-zA-Z][a-zA-Z][0-9][0-9][0-9][0-9].{jpg,png,jpeg}", GLOB_BRACE) as $img) {
								$aux = [];
								$img = explode('/', $img)[count(explode('/', $img)) - 1];
								$aux['name'] = explode('.', $img)[0];
								$aux['type'] = explode('.', $img)[1];
								array_push($oldPhotos, $aux);
							}

							// return $newPhotos;

							if (count($oldPhotos) > 0) {
								for ($i=0; $i < count($oldPhotos); $i++) {
									for ($j=0; $j < count($newPhotos); $j++) { 
										if ($oldPhotos[$i]['name'] == $newPhotos[$j]['name']) {
											// $info['matches']++;
											$oldName = $oldPhotos[$i]['name'] . "." . $oldPhotos[$i]['type'];
											$u = unlink("../../files/profile_photos/$oldName");

											if (!$u)return -5;
										}

									}
								}
							}

							for ($j=0; $j < count($newPhotos); $j++) {
								$query = "UPDATE student SET photo = '" . $newPhotos[$j]['name'] . "." . $newPhotos[$j]['type'] . "' WHERE idStudent = '" . $newPhotos[$j]['name'] . "';";

								$qRes = $this->connection->connection->query($query);
								if (!$qRes) return -4;

								$query = "SELECT name, lastName, idStudent, photo FROM student WHERE idStudent = '" . $newPhotos[$j]['name'] . "';";

								$qRes = $this->connection->connection->query($query);
								if (!$qRes) return -4;

								while ($row = $qRes->fetch_assoc()) {
									$aux = [];
									foreach ($row as $key => $value) {
										$aux[$key] = $value;
									}
									if ($row['idStudent'] == $newPhotos[$j]['name']) {
										$info['matches']++;
										array_push($info['students'], $aux);
										$newName = $newPhotos[$j]['name'] . "." . $newPhotos[$j]['type'];
										if (file_exists("../../files/tmp/sectionPhotos/$newName")) {
											$p = "../../files/tmp/sectionPhotos/$newName";
											$d = "../../files/profile_photos/$newName";
											rename($p, $d);
										}
									}
								}
							}

							foreach(glob("../../files/tmp/sectionPhotos/*", GLOB_BRACE) as $dirFile){
								if (is_file($dirFile)) {
									unlink($dirFile);
								}
							}
							unlink("../../files/tmp/sectionPhotos.zip");
							return $info;
						}else{
							return -3;	
						}
					}else{
						return -2;
					}
				}else{
					return -1;
				}
			}else{
				return 0;
			}
		}

		function getAllForSubject($subject){
			$query = "SELECT section.idSection, level.level, section.sectionIdentifier FROM section INNER JOIN level ON level.idLevel = section.idLevel  INNER JOIN register_subject ON register_subject.idSection = section.idSection WHERE register_subject.idSubject = $subject";
			$result = $this->connection->connection->query($query);
			$option = "<option value='0'>Todos</option>";

			if($result->num_rows > 0){
				while($fila = $result->fetch_assoc()){
					$option .= "<option value='". $fila['idSection'] ."'>". $fila['level'] ."° '". $fila['sectionIdentifier'] ."'</option>";
				}
			}
			return ($option);
		}

		function getSectionStudents($id)
		{
			$aux = "";
			$z = 1;
			$query = "SELECT * FROM student WHERE idSection = $id AND verified = 1 AND state = 1;";
			$res = $this->connection->connection->query($query);
			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$aux .= "
	<div class='col s12 frmMandatedContainer _$z'>
		<div class='mandated-header " . ($z == 1 ? "active" : "") . ($_SESSION['type'] == 'C' ? ' black' : ' green darken-2') . "'>
			<span class=''><div frmIndex='$z' class='btn btn-flat white-text " . ($_SESSION['type'] == 'C' ? "waves-light" : "") . " waves-effect btnDeleteForm'><i class='material-icons'>close</i></div> " . $row['lastName'] . ", " . $row['name'] . "</span>
		</div>
		<div class='mandated-body " . $_SESSION['type'] . "'>
			<form class='frmMandated _" . $z . "' autocomplete='off'>
			<input type='hidden' name='idStudent' value='" . $row['idStudent'] . "'>
				<div class='row'>
					<div class='input-field col l3 m3 s12'>
						<input type='text' name='txtName' id='txtName_" . $z . "'>
						<label for='txtName_" . $z . "'>Nombres</label>
					</div>
					<div class='input-field col l3 m3 s12'>
						<input type='text' name='txtLastName' id='txtLastName_" . $z . "'>
						<label for='txtLastName_" . $z . "'>Apellidos</label>
					</div>
					<div class='input-field col l3 m3 s12'>
						<input type='text' name='txtDui' id='txtDui_" . $z . "'>
						<label for='txtDui_" . $z . "'>DUI</label>
					</div>
					<div class='input-field col l3 m3 s12'>
						<input type='text' name='txtEmail' id='txtEmail_" . $z . "'>
						<label for='txtEmail_" . $z . "'>Email</label>
					</div>
				</div>
				<div class='row'>
					<div class='input-field col l3 m3 s12'>
						<input type='text' name='txtPhone' id='txtPhone_" . $z . "'>
						<label for='txtPhone_" . $z . "'>Teléfono</label>
					</div>
					<div class='input-field col l3 m3 s12'>
						<span>Sexo</span>
						<p style=''>
							<input value='F' class='with-gap' type='radio' name='txtSex' id='txtSex_F" . $z . "'>
							<label for='txtSex_F" . $z . "'>Femenino</label>
							<input value='M' class='with-gap' type='radio' name='txtSex' id='txtSex_M" . $z . "'>
							<label for='txtSex_M" . $z . "'>Masculino</label>
						</p>
					</div>
					<div class='input-field col l3 m3 s12'>
						<input type='text' name='txtRelation' id='txtRelation_" . $z . "'>
						<label for='txtRelation_" . $z . "'>Relación</label>
					</div>
					<div class='input-field col l3 m3 s12'>
						<input type='date' class='datepicker' name='txtBirthdate' id='txtBirthdate_" . $z . "'>
						<label for='txtBirthdate_" . $z . "'>Fecha de nacimiento</label>
					</div>
				</div>
			</form>
		</div>
	</div>
					";
					$z++;
				}
				return $aux;
			}else{
				return -1;
			}
		}

		function addMandated($data, $idSn)
		{
			$mandatedQuery = "";
			$verifiedQuery = "";
			for ($i=0; $i < count($data); $i++) {
				$mandatedQuery = "INSERT INTO mandated VALUES (NULL, \"" . $data[$i]['name'] . "\", \"" . $data[$i]['lastName'] . "\", \"" . $data[$i]['relation'] . "\", \"" . $data[$i]['dui'] . "\", \"" . $data[$i]['email'] . "\", \"" . $data[$i]['phone'] . "\", \"" . $data[$i]['sex'] . "\", \"" . $data[$i]['birthdate'] . "\", \"" . $data[$i]['idStudent'] . "\");";
				$verifiedQuery = "UPDATE student SET verified = 1 WHERE idStudent = \"" . $data[$i]['idStudent'] . "\"; ";

				if ($stmt = $this->connection->connection->prepare($mandatedQuery)) {
				    $stmt->execute();
				    $stmt->store_result();
				    $stmt->free_result();
				    $stmt->close();
				}else{
					echo $this->connection->connection->error;
					return 0;
				}

				if ($stmt = $this->connection->connection->query($verifiedQuery)) {
				    
				}else{
					echo $this->connection->connection->error;
					return 0;
				}
			}
			
			$sectionQuery = "UPDATE section sn SET sn.sState = (SELECT MIN(verified) FROM student s WHERE s.idSection = $idSn) WHERE sn.idSection = $idSn;";

			if ($stmt = $this->connection->connection->query($sectionQuery)) {
				
			}else{
				echo $this->connection->connection->error;
				return 0;
			}

			return 1;
		}
		
		function addSection($specialty, $teacher){
			$query = "SELECT * FROM section";
			$result = $this->connection->connection->query($query);
			$teacher_section = array();
			$i = 0;
			while($fila = $result->fetch_assoc()){
				$teacher_section[$i] = $fila['idTeacher'];
				$i++;
			}

			$level = parent::getLevels();
			$form = "<form class='addCode'>
				<div class='row'>
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<select name='selectLevel' id='selectLevel'>
						<option value='' disabled selected>Elegir Nivel</option>";
						foreach ($level as $key => $value) { 
							$form .= "<option class='' value='".$key."'>".$value."°</option>";
						}
						$form .= "</select>
						<label>Nivel</label>
					</div> 
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<select name='selectSpecialty' id='selectSpecialty'>
						<option value='' disabled selected>Elegir Especialidad</option>";
						for ($i = 0; $i < count($specialty); $i++) { 
							$form .= "<option class='' value='".$specialty[$i][0]."'>".$specialty[$i][1]."</option>";
						}
						$form .= "</select>
						<label>Especialidad</label>
					</div>
					<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
						<select name='selectTeacher' id='selectTeacher'>
						<option value='' disabled selected>Elegir Profesor Guía</option>";
						$valid = true;
						for ($i=0; $i < count($teacher); $i++) {
							for($x = 0; $x < count($teacher_section); $x++){
								if($teacher[$i][0] == $teacher_section[$x]){
									$form .= "<option value='".$teacher[$i][0]."' class='circle' disabled='disabled' data-icon='../../files/profile_photos/".$teacher[$i][3]."'>  <p class='teacher_code'>".$teacher[$i][0]."</p> - ".$teacher[$i][2].", ".$teacher[$i][1]."</option>";
									$valid = false;
									break;
								}
							}
							if($valid){
								$form .= "<option value='".$teacher[$i][0]."' class='circle' data-icon='../../files/profile_photos/".$teacher[$i][3]."'>  <p class='teacher_code'>".$teacher[$i][0]."</p> - ".$teacher[$i][2].", ".$teacher[$i][1]."</option>";
							}
							$valid = true;
						}
						$form .= "</select>
						<label>Guía</label>
					</div>       
				</div>
				<div class='row'>
					<div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Guardar
						<i class='material-icons right'>save</i>
					</div>
				</div>
				<div class='row next-section'>
					<div class=''>
						
					</div>
				</div>
			</form>";

			return $form;
		}

		function getSectionIdentifier($level){
			$query = "SELECT * FROM section WHERE idLevel = '$level'";
			$result = $this->connection->connection->query($query);
			$i = 0;
			if($result->num_rows > 0){
				while($fila = $result->fetch_assoc()){
					$i++;
				}
			}
			$form = "
				<div class='section-identifier'>
					Sección a Agregar
				</div>
				<h1>".$this->alphabet[$i]."</h1>
			";
			return ($form);
		}

		function NewSection($level, $specialty, $teacher, $identifier){
			$query = "INSERT INTO section(idLevel, idSpecialty, sectionIdentifier, sState, idTeacher) VALUES($level, $specialty, '$identifier', 0, '$teacher')";
			if($this->connection->connection->query($query)){
				#Obtenemos el id de la sección recienmente agregada
				$query = "SELECT MAX(idSection) AS id FROM section";
				$result = $this->connection->connection->query($query);
				$fila = $result->fetch_assoc();

				if($this->createTable($fila['id'])){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}

		function createTable($id){
			$tableName = "section_schedule_$id";
			$query = "CREATE TABLE $tableName (
    			idRegister INT(15) NOT NULL AUTO_INCREMENT, 
    			idScheduleRegister INT(15) NOT NULL,
     			PRIMARY KEY(idRegister),
    			INDEX(idScheduleRegister),
    			FOREIGN KEY (idScheduleRegister) REFERENCES schedule_register(idS_Register)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;";

			return($this->connection->connection->query($query));
		}

		/*-------------------------------------------------------------------------*/
		/*-------------------------------------------------------------------------*/
		function getStudensSection($id)
		{
			$obj = [];
			$obj['students'] = [];
			$obj['snInfo'] = [];
			$studentsQuery = "SELECT s.idStudent, s.name, s.lastName, s.email, s.verified, s.photo, sa.color, sa.description FROM student s INNER JOIN state_academic sa ON sa.idState = s.stateAcademic WHERE s.idSection = (SELECT sn.idSection FROM section sn WHERE sn.idTeacher = '$id') AND s.state = 1 ORDER BY s.lastName;";
			$sectionQuery = "SELECT sn.sectionIdentifier, sn.sState, sy.sName, l.level, sn.idSection FROM section sn INNER JOIN level l ON l.idLevel = sn.idLevel INNER JOIN specialty sy ON sy.idSpecialty = sn.idSpecialty WHERE sn.idTeacher = '$id'";

			$studentsRes = $this->connection->connection->query($studentsQuery);
			$sectionRes = $this->connection->connection->query($sectionQuery);

			if ($studentsRes->num_rows > 0){
				while ($studentsRow = $studentsRes->fetch_assoc()) {
					$aux = [];
					foreach ($studentsRow as $key => $value) {
						$aux[$key] = $value;
					}
					array_push($obj['students'], $aux);
				}
			}else{
				$obj['students'] = null;
			}

			if ($sectionRes->num_rows > 0){
				while ($sectionRow = $sectionRes->fetch_assoc()) {
					foreach ($sectionRow as $key => $value) {
						$obj['snInfo'][$key] = $value;
					}
				}
			}else{
				$obj['snInfo'] = null;
			}

			return json_encode($obj);
		}

		function v_delete(){
			$sections = $this->getForDelete();

			if(count($sections) > 0){
				$sections_tr = "";
				$x = 0;
				for($i = 0; $i < count($sections); $i++){
					$query = "SELECT section.idSection, section.sectionIdentifier, level.level, specialty.sName FROM `section` INNER JOIN level ON level.idLevel = section.idLevel INNER JOIN specialty ON specialty.idSpecialty = section.idSpecialty WHERE section.idSection = '".$sections[$i]."'";
					$result = $this->connection->connection->query($query);
					$fila = $result->fetch_assoc();
					$x++;
					$sections_tr .= "
					<tr>
						<td>".$x++."</td>
						<td>".$fila['level']."° </td>
						<td>".$fila['sectionIdentifier']."</td>
						<td>".$fila['sName']."</td>
						<td>
							<input type='checkbox' class='btn_checkbox' id='".$fila['idSection']."' />
							<label for='".$fila['idSection']."' ></label>
						</td>
					</tr>
					";
				}
				
				$form = "<form class='deleteSection'>
					<div class='row'>
						<table class='centered bordered responsive-table delete-section col l10 offset-l1'>
							<thead>
								<th>N°</th>
								<th>Nivel</th>
								<th>Sección</th>
								<th>Especialidad</th>
								<th>Opción</th>
							</thead>
							<tbody>
								$sections_tr
							</tbdoy>
						</table>
					</div>
					<div class='row'>
						<div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Guardar
							<i class='material-icons right'>save</i>
						</div>
					</div>
				</form>"; 	
			}else{
				$form = "<div class='alert_ red-text text-darken-4'>No se encontraron secciones para eliminar...<div>";
			}
			return ($form);
		}
		
		function getForDelete(){
			$sections = array();
			$i = 0;
			#Obtiene las secciones que no estan en los alumnos
			$query_student = "SELECT section.idSection FROM `section` WHERE section.idSection NOT IN (SELECT student.idSection FROM student)";
			#Obtiene las secciones que no estan en schedule
			$query_schedule = "SELECT section.idSection FROM `section` WHERE section.idSection NOT IN (SELECT schedule_register.idSection FROM schedule_register) ";
			#Obtiene las secciones que no estan en register subject
			$query_RS = "SELECT section.idSection FROM `section` WHERE section.idSection NOT IN (SELECT register_subject.idSection FROM register_subject) ";

			$result_student = $this->connection->connection->query($query_student);
			if($result_student->num_rows > 0){
				while($fila = $result_student->fetch_assoc()){
					$sections[$i] = $fila['idSection'];
					$i++;
				}
			}
			
			$result_schedule = $this->connection->connection->query($query_schedule);
			if($result_schedule->num_rows > 0){
				$valid  = false;
				while($fila = $result_schedule->fetch_assoc()){
					for($x = 0; $x < count($sections); $x++ ){
						if($sections[$x] == $fila['idSection']){
							$valid = true;
							break;
						}
					}
					if($valid){
						$sections[$i] = $fila['idSection'];
						$i++;
					}
					$valid = false;
				}
			}
			$result_RS = $this->connection->connection->query($query_RS);
			if($result_RS->num_rows > 0){
				$valid  = false;
				while($fila = $result_RS->fetch_assoc()){
					for($x = 0; $x < count($sections); $x++ ){
						if($sections[$x] == $fila['idSection']){
							$valid = true;
							break;
						}
					}
					if($valid){
						$sections[$i] = $fila['idSection'];
						$i++;
					}
					$valid = false;
				}
			}

			return (array_unique($sections));
		}

		function deleteSection($id){
			$query = "DELETE FROM section WHERE idSection = $id";
			return($this->connection->connection->query($query));
		}
	}
?>