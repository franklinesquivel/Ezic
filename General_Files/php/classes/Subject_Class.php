<?php 

	class Subject{
		
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

		function getSubjectsOnly(){
			$query = "SELECT DISTINCT subject.idSubject, subject.nameSubject AS name, subject.idSubject AS id,level.level, subject.idTeacher AS teacher, subject.acronym FROM `subject` INNER JOIN teacher On teacher.idTeacher = subject.idTeacher INNER JOIN register_subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON section.idLevel = level.idLevel WHERE teacher.state = 1 ORDER BY level.level ";

			$result = $this->connection->connection->query($query);

			$array = array();
			$i = 0;
			while($fila = $result->fetch_assoc()){
				$array[$i][0] = $fila['id'];
				$array[$i][1] = $fila['level'];
				$array[$i][2] = $fila['name'];
				$array[$i][3] = $fila['teacher'];
				$array[$i][4] = $fila['acronym'];
				$i++;
			}

			return $array;
		}

		function newSubject($name, $teacher, $acronym, $description){
			$query = "INSERT INTO subject(nameSubject, idTeacher, acronym, description) VALUES('$name', '$teacher', '$acronym', '$description')";
			$result = $this->connection->connection->query($query);

			return ($this->getIdSubject($name, $teacher, $acronym, $description));
		}

		function getIdSubject($name, $teacher, $acronym, $description){
			$query = "SELECT MAX(idSubject) AS idSubject FROM subject";
			$result = $this->connection->connection->query($query);
			while ($fila = $result->fetch_assoc()) {
				return $fila['idSubject'];
			}
		}

		function register_subject($idSubject, $sections){
			//for ($i=0; $i < count($sections) ; $i++) { 
				$query = "INSERT INTO register_subject(idSubject, idSection) VALUES($idSubject, $sections)";
				return($this->connection->connection->query($query));
			//}
			//return true;
		}

		function verifySubject($name, $teacher, $idLevel){
			$query = "SELECT * FROM `register_subject`INNER JOIN subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON register_subject.idSection = section.idSection WHERE subject.nameSubject = '$name' AND subject.idTeacher = '$teacher' AND section.idLevel = $idLevel";
			$result = $this->connection->connection->query($query);
			$row_cont = $result->num_rows;

			return $res = ($row_cont > 0) ? false : true;
		}

		function replaceTeacher($idSubject, $idTeacher){
			$query = "UPDATE subject SET idTeacher = '$idTeacher' WHERE idSubject = $idSubject";
			return ($this->connection->connection->query($query));
		}

		function getForDelete(){
			//Se obtienen las materias que si existen en las tablas
			$query_1 = "SELECT idSubject FROM subject WHERE idSubject NOT IN (SELECT DISTINCT idSubject FROM evaluation_profile)";  
			$query_2 = "SELECT idSubject FROM subject WHERE idSubject NOT IN (SELECT DISTINCT idSubject FROM averages)";
			$query_3 = "SELECT idSubject FROM subject WHERE idSubject NOT IN (SELECT DISTINCT idSubject FROM schedule_register)";
			$result_1 = $this->connection->connection->query($query_1);
			$result_2 = $this->connection->connection->query($query_2);
			$result_3 = $this->connection->connection->query($query_3);
			$subject = array();
			$subject_1 = array();
			$subject_2 = array();
			$subject_3 = array();

			$i = 0;
			while ($fila_1 = $result_1->fetch_assoc()) {			
				$subject_1[$i] = $fila_1['idSubject'];
				$i++;
			}
			$i = 0;
			while ($fila_2 = $result_2->fetch_assoc()) {
				$subject_2[$i] = $fila_2['idSubject'];
				$i++;			
			}	
			$i = 0;
			while($fila_3 = $result_3->fetch_assoc()){
				$subject_3[$i] = $fila_3['idSubject'];
				$i++;
			}
			//$subject = array_merge($subject_1, $subject_2, $subject_3);
			$new_subject = array();
			$i = 0;
			$valid = true;

			for($x = 0; $x < count($subject_1); $x++){
				for($y = 0; $y < count($subject_2); $y++){
					for($z = 0; $z < count($subject_3); $z++){
						if($subject_1[$x] == $subject_2[$y] && $subject_2[$y] == $subject_3[$z]){
							for($j = 0; $j < count($new_subject); $j++){
								if($new_subject[$j] == $subject_3[$z]){
									$valid = false;
									break;
								}
							}
							if($valid){
								$new_subject[$i] = $subject_3[$z];
								$i++;
								$valid = true;
							}
						}
					}
				}
			}
			//Se obtienen las materias que no cuentan con regsitros, solo en las tablas subject y register_subject
			$i = 0;
			$info = array();
			if (count($new_subject) > 0){
				for ($x=0; $x < count($new_subject) ; $x++) { 
					$query = "SELECT subject.idSubject, subject.nameSubject, subject.acronym, subject.idTeacher, level.level FROM subject INNER JOIN register_subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON level.idLevel = section.idLevel WHERE subject.idSubject = '".$new_subject[$x]."' GROUP BY subject.idSubject LIMIT 1";
					$result = $this->connection->connection->query($query);

					while ($fila = $result->fetch_assoc()) {
						$info[$i] = [
							"id"=>$fila['idSubject'],
							"name"=>$fila['nameSubject'],
							"acronym"=>$fila['acronym'],
							"teacher"=>$fila['idTeacher'],
							"level"=>$fila['level']
						];
						$i++;
					}
				}
			}
			return (json_encode($info));			
		}

		function v_deleteSubject(){//Vista de delete_subject.php - Coordinador
    		$list_Subjects = json_decode($this->getForDelete());//Obtención de materias
    		if (count($list_Subjects) > 0) {
    			$table = "<div class='row table_subject'>
    			<table class='col l10 m10 s12 offset-l1 offset-m1 offset-s0 responsive-table centered'>
    				<thead>
           				<tr>
                			<th>Nombre</th>
                  			<th>Acrónimo</th>
                  			<th>Nivel</th>
                  			<th>Profesor</th>
                  			<th>Opción</th>
              			</tr>
            		</thead>
            		<tbody>";
            				for ($i=0; $i <count($list_Subjects) ; $i++) {
            					$table .= "<tr>
    								<td>".$list_Subjects[$i]->name."</td>
    								<td>".$list_Subjects[$i]->acronym."</td>
    								<td>".$list_Subjects[$i]->level."</td>
    								<td>".$list_Subjects[$i]->teacher."</td>
    								<td>
          								<input type='checkbox' class='btn_checkbox' id=".$list_Subjects[$i]->id." />
          								<label for=".$list_Subjects[$i]->id.">Eliminar</label>
        							</td>
            					</tr>";
            				}
            		$table .= "</tbody>
    			</table>
	    		</div>
	    		<div class='row col s12'>
	    	    	<button class='col l2 m2 s8 offset-l5 offset-m5 offset-s2 btn waves-effect waves-light black btnSave'>Guardar
	    	    		<i class='material-icons right'>save</i>
	    	    	</button>
	    		</div>";	
    		}else{
    			$table = "0";
    		}
    		return $table;
		}

		function delete($idSubject){
			$query = "SELECT idRegisterSubject AS id FROM register_subject WHERE idSubject = $idSubject";
			$result = $this->connection->connection->query($query);
			while($fila = $result->fetch_assoc()){

				$query = "DELETE FROM register_subject WHERE idRegisterSubject = ".(int)$fila['id']."";
				$this->connection->connection->query($query);
			}

			$query = "DELETE FROM subject WHERE idSubject = $idSubject";
			return ($result = $this->connection->connection->query($query));
		}

		function getForTeacher($idTeacher){
			$query = "SELECT level.level, subject.nameSubject, subject.idSubject FROM subject INNER JOIN register_subject ON register_subject.idSubject = subject.idSubject INNER JOIN section ON section.idSection = register_subject.idSection INNER JOIN level ON section.idLevel = level.idLevel WHERE subject.idTeacher = '$idTeacher' GROUP BY subject.idSubject";
			$result = $this->connection->connection->query($query);
			$i = 0;
			$subjects = array();
			while($fila = $result->fetch_assoc()){
				$subjects[$i] = [
					"id"=>$fila['idSubject'],
					"level"=>$fila['level'],
					"name"=>$fila['nameSubject']
				];
				$i++;
			}
			return (json_encode($subjects));
		}
	}
?>