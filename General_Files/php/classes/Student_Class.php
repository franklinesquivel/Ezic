<?php 


	class Student{
		
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

		function getStudents($section){/* Obtiene los estudiante segun la seccion*/
			$query = "SELECT idStudent FROM student WHERE idSection = $section";
			$result = $this->connection->connection->query($query);
			$students = array();
			$i = 0;

			while ($fila = $result->fetch_assoc()) {
				$students[$i] = [
					"id" => $fila['idStudent']
				];
				$i++;
			}

			return (json_encode($students));
		}

		function  v_permission($subject, $section){ /*Se ejecuta del lado del maestro cuando quiere solicitar permiso*/
			session_start();
			if($section == 0){
				$query = "SELECT student.idStudent, subject.idSubject, student.name, student.lastName, specialty.sName as speciality, section.sectionIdentifier, level.level, student.photo FROM `student` INNER JOIN section ON section.idSection = student.idSection INNER JOIN specialty ON specialty.idSpecialty = section.idSpecialty INNER JOIN register_subject ON register_subject.idSection = section.idSection INNER JOIN subject ON subject.idSubject = register_subject.idSubject INNER JOIN level ON level.idLevel = section.idLevel WHERE subject.idSubject = '$subject' AND subject.idTeacher = '". $_SESSION['id'] ."' GROUP BY student.idStudent";
			}else{
				$query = "SELECT student.idStudent, subject.idSubject, student.name, student.lastName, specialty.sName as speciality, section.sectionIdentifier, level.level, student.photo FROM `student` INNER JOIN section ON section.idSection = student.idSection INNER JOIN specialty ON specialty.idSpecialty = section.idSpecialty INNER JOIN register_subject ON register_subject.idSection = section.idSection INNER JOIN subject ON subject.idSubject = register_subject.idSubject INNER JOIN level ON level.idLevel = section.idLevel WHERE subject.idSubject = '$subject' AND student.idSection = '$section' AND subject.idTeacher = '". $_SESSION['id'] ."' GROUP BY student.idStudent";
			}
			$result = $this->connection->connection->query($query);
			$student = array();
			$i = 0;
			$form = "";
			$row_student = array();
			$student_Item = "";

			if ($result->num_rows > 0) {
				$form .= "
					<div class='row students-targets'>
                        <div class='student-list'>   
				";
				while ($fila = $result->fetch_assoc()) {
					$student[$i] = "
						<div class='student-item'>
							<div class='student-info'>
								<div class='photo'>
									<img src='../../files/profile_photos/".$fila['photo']."'/>
								</div>
								<div class='info-gnrl'>
									<div class='id-student'>".$fila['idStudent']."</div>
									<div class='name-student'>".$fila['lastName'].", ".$fila['name']."</div>
									<div class='section-student'>".$fila['level']."° '".$fila['sectionIdentifier']."', ".$fila['speciality']."</div>
								</div>
								<div class='option-add'>
									<input type='checkbox' student_name='".$fila['lastName'].", ".$fila['name']."' class='btn_checkbox checkbox-list' id='".utf8_encode($fila['idStudent'])."'  />
									<label for='".$fila['idStudent']."'></label>
								</div>
							</div>
						</div>
					";
					$i++;
				}
				$i = 0;
				$y = 0;
				for($x = 0; $x < count($student); $x++){
					if($y == 2){
						$i++;
						$student_Item = "";
						$y = 0;
					}
					$student_Item .= "". $student[$x] ."";
					$row_student[$i] = $student_Item;
					$y++;
				}
				for($z = 0; $z < count($row_student); $z++){
					$form .= "
						<div class='row-student'>
							".$row_student[$z]."
						</div>
					";
				}
				$form .= "
						</div> 
					</div>
					<div class='btn-container row'>
                        <div id='SaveStudents' class='btn waves-effect waves-light col l3 m3 s6 offset-l2 offset-m2 offset-s3 green darken-2' >
                                Seguir
                            <i class='material-icons right'>save</i>
                        </div>
						<div id='ViewStudents' class='btn waves-effect waves-light col l3 m3 s6 offset-l2 offset-m2 offset-s3 green darken-2' >
                                Ver Seleccionados
                            <i class='material-icons right'>visibility</i>
                        </div>
                    </div>
				";
			}else{
				$form = "<div class='row .alert_ col l8 m8 s10 offset-l2 offset-m8 offset-s1'>No hay usuarios registrados en dicha materia</div>";
			}
		
			return ($form);
		}
	}
?>