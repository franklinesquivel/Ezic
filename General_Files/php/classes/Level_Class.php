<?php 

	class Level{
		
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

		public function getLevels(){
			$query = "SELECT * FROM level";
			$result = $this->connection->connection->query($query);
			$levels = array();

			while ($fila = $result->fetch_assoc()) {
				$levels[$fila['idLevel']] = $fila['level'];
			}

			return $levels;
		}
	}


?>