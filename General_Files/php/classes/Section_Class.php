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
	                    <span class='title black-text'><b>Sección \"<i>". $row['sectionIdentifier'] ."</i>\"</b></span>
	                </a>
				";
			}

			return $aux;
		}

		function getAllForSubject($subject){
			$query = "SELECT section.idSection, level.level, section.sectionIdentifier FROM section INNER JOIN level ON level.idLevel = section.idSection  INNER JOIN register_subject ON register_subject.idSection = section.idSection WHERE register_subject.idSubject = $subject";
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