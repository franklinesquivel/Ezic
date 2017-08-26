<?php

	class Period{
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

		function NewPeriod($startDate, $endDate, $percentage){
			$nthPeriod = $this->nth_Period() + 1;
			$query = "INSERT INTO period(startDate, endDate, percentage, nthPeriod) VALUES('$startDate', '$endDate', $percentage, $nthPeriod)";

			if($this->connection->connection->query($query)){
				return true;
			}else{
				return false;
			}
		}

		function nth_Period(){//Obtiene el campo 'nthperiod' de la tabla - el número
			$query = "SELECT COUNT(*) FROM period";
			$result = $this->connection->connection->query($query);
			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				return ($row['COUNT(*)']);
			}
			return 0;
		}

		function getPeriods(){
			$query = "SELECT * FROM period";
			$result = $this->connection->connection->query($query);
			$array = array();
			$i = 0;
			while($fila = $result->fetch_assoc()){
				$array[$i][0] = $fila['idPeriod'];
				$array[$i][1] = $fila['nthPeriod'];
				$array[$i][2] = $fila['startDate'];
				$array[$i][3] = $fila['endDate'];
				$array[$i][4] = $fila['percentage'];
				$i++;
			}
 
			return $array;
		}

		function countPercentage($percentage, &$a){
			$rest_percentage = $percentage;
			$query = "SELECT SUM(percentage) AS percentage FROM period";
			$result = $this->connection->connection->query($query);

			while ($fila = $result->fetch_assoc()) {
				$percentage += floatval($fila['percentage']);
			}
			
			$a = (100 - ($percentage - $rest_percentage));
			return ($res = ($percentage > 100) ? false : true);
		}

		function compareDate($startDate, $endDate){
			$query = "SELECT * FROM period";
			$result = $this->connection->connection->query($query);

			$compare = array();
			$i = 0;
			$z = 0;
			while ($fila = $result->fetch_assoc()) {
				$compare[$i][0] = (strtotime ($startDate)) - (strtotime($fila['startDate']));
				$compare[$i][1] = (strtotime ($endDate)) - (strtotime($fila['endDate']));
				$compare[$i][2] = (strtotime ($startDate)) - (strtotime($fila['endDate']));
				$compare[$i][3] = (strtotime ($endDate)) - (strtotime($fila['startDate']));
				$i++;
			}

			for ($x=0; $x <count($compare) ; $x++) { 
			 	if (($compare[$x][0] < 0) || ($compare[$x][1] < 0) || ($compare[$x][2] < 0) || ($compare[$x][3] < 0)) {
			 		$z++;
			 	}
			 }

			return $res = ($z > 0) ? 0 : 1;
		}

		function selectPeriod($idPeriod){
			$query = "SELECT * FROM period WHERE idPeriod = $idPeriod";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			$array[0] = [
				"startDate" => $fila['startDate'],
				"endDate" => $fila['endDate'],
				"percentage" => $fila['percentage'],
				"numPeriod" => $fila['nthPeriod']
			];

			return json_encode($array);
		}

		function countPercentageOfPeriod($idPeriod, $percentage, &$a){
			$query = "SELECT percentage FROM period WHERE idPeriod != $idPeriod";
			$result = $this->connection->connection->query($query);
			$newPercentage = $percentage;
			
			while ($fila = $result->fetch_assoc()) {
				$percentage += $fila['percentage'];
			}
			
			$a = 100 - ($percentage - $newPercentage);
			return $res = ($percentage > 100) ? false : true;
		}

		function compareDateOfPeriod($idPeriod, $startDate, $endDate){
			$query = "SELECT * FROM period WHERE idPeriod != $idPeriod";
			$result = $this->connection->connection->query($query);
			$z = 0;
			while($fila = $result->fetch_assoc()){
				if (($this->check_in_range($fila['startDate'], $fila['endDate'], $startDate)) ||
					($this->check_in_range($fila['startDate'], $fila['endDate'], $endDate))) {
					$z++;
				}
			}
			return $res = ($z > 0) ? 0 : 1;
		}

		function check_in_range($startDate, $endDate, $newDate) {
	    	$start_ts = strtotime($startDate);
	    	$end_ts = strtotime($endDate);
	    	$user_ts = strtotime($newDate);
	    	return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
		}

		function modifyPeriod($idPeriod, $startDate, $endDate, $percentage){
			$query = "UPDATE period SET startDate = '$startDate', endDate = '$endDate', percentage = $percentage WHERE idPeriod = $idPeriod";

			return ($this->connection->connection->query($query));
		}

		function returnJSONPeriods()
		{
			$obj = [];
			$query = "SELECT * FROM period";
			$res = $this->connection->connection->query($query);

			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$aux = [];
					foreach ($row as $key => $value) {
						$aux[$key] = $value;
					}
					array_push($obj, $aux);
				}
			}

			return $obj;
		}
	}
?>
