<?php 

	class Specialty{
		
		public $connection;
		public $aux;

		function __construct(){

			require_once('Page_Constructor.php');
			$const = new Constructor();

			$this->aux = $const->getRoute();
			
			require_once($this->aux);
			$this->connection = new Connection();
			$this->connection->Connect();
		}

		public function getSpecialty(){
			$query = "SELECT * FROM specialty";
			$result = $this->connection->connection->query($query);
			$specialty = array();
            $i = 0;
			while ($fila = $result->fetch_assoc()) {
                $specialty[$i][0] = $fila['idSpecialty'];
                $specialty[$i][1] = $fila['sName'];
                $i++;
			}

			return $specialty;
		}
	}


?>