<?php 

	require_once('Level_Class.php');
	class Section extends Level{
		
		function __construct(){
			parent::__construct();
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
			$query = "SELECT section.idSection, level.level FROM section INNER JOIN level ON section.idLevel = level.idLevel WHERE section.idSection IN (SELECT section.idSection FROM section INNER JOIN register_subject ON register_subject.idSection = section.idSection INNER JOIN level ON section.idLevel = level.idLevel WHERE register_subject.idSubject = $idSubject)";
			$result = $this->connection->connection->query($query);
			$sections = array();//Aqui Se guardaran las secciones en las cuales ya esta esa materia
			$info = array();
			$i = 0;

			while ($fila = $result->fetch_assoc()) {
				$sections[$i][0] = $fila['idSection'];
				$sections[$i][1] = $fila['level'];
				$i++;
			}

			$i = 0;
			for ($x=0; $x <count($sections) ; $x++) { 
				$query = "SELECT section.idSection, specialty.sName, section.sectionIdentifier, level.level FROM `section` INNER JOIN level ON level.idLevel = section.idLevel INNER JOIN specialty ON section.idSection = specialty.idSpecialty WHERE section.idSection != ".$sections[$x][0]." AND level.level  = ".$sections[$x][1]."";
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

		function filterSections($lvl, $spcty, $sctn)
		{
			$aux = "";
			$query = "SELECT * FROM section sn INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty " . ($lvl != '' ? "WHERE ll.idLevel = $lvl " . ($spcty != '' ? "AND sy.idSpecialty = $spcty " . ($sctn != '' ? "AND sn.idSection = $sctn" : '') : '') : ';');

			$res = $this->connection->connection->query($query);

			if($res->num_rows == 0) return -1;

			while ($row = $res->fetch_assoc()) {
				$aux .= "
					<a class='collection-item waves-effect waves-black ' idSn='" . $row['idSection'] . "'>
	                    <span class='title black-text'> " . ($row['level'] == 1 ? '1er' : ($row['level'] == 2 ? '2do' : '3er')) . " Año, &nbsp</span>
	                    <span class='title black-text'><i>" . $row['sName'] . "</i>: &nbsp </span>
	                    <span class='title black-text'><b>Sección <i>\"". $row['sectionIdentifier'] ."\"</i></b></span>
	                </a>
				";
			}

			return $aux;
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
			// return $file['tmp_name'];
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
											$info['matches']++;
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
	}
?>