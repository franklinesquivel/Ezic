<?php 
	
	class Teacher{
		
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

		function getTeachers(){
			$query = "SELECT * FROM teacher WHERE state = 1";
			$result = $this->connection->connection->query($query);
			$teachers = array();
			$i = 0;

			while ($fila = $result->fetch_assoc()) {
				$teachers[$i][0] = $fila['idTeacher'];
				$teachers[$i][1] = $fila['name'];
				$teachers[$i][2] = $fila['lastName'];
				$teachers[$i][3] = $fila['photo'];

				$i++;
			}

			return $teachers;
		}

		function getTeacherForChange($subject){//Por cambiar a una materia de profesor - Coordinador
			$query = "SELECT teacher.idTeacher FROM teacher INNER JOIN subject ON subject.idTeacher = teacher.idTeacher WHERE subject.idSubject = $subject";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			$teacher = $fila['idTeacher'];//Teacher que no aparecera

			$teachers = array();
			$i = 0;
			$query = "SELECT * FROM teacher WHERE idTeacher != '$teacher'";
			$result = $this->connection->connection->query($query);
			while ($fila = $result->fetch_assoc()) {
				$teachers[$i] = [
					"id"=> $fila['idTeacher'],
					"name" => $fila['name'],
					"lastName" => $fila['lastName'],
					"photo" => $fila['photo']
				];
				$i++;
			}
			return (json_encode($teachers));
		}
	}
?>