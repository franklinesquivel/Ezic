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
	}

?>