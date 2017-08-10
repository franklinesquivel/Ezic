<?php 

	/**
	* 
	*/
	class Stadistics
	{
		private $connection;
        private $aux;	
		function __construct()
		{
			require_once('Page_Constructor.php');
            $const = new Constructor();
            $this->aux = $const->getRoute();

            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();
		}

		function countUsers()
		{
			$c = 0;
			$obj = [];
			$obj['S'] = [];
			$obj['T'] = [];
			$obj['C'] = [];

			$query[0]['q'] = "SELECT * FROM student st 
            INNER JOIN section s ON st.idSection = s.idSection 
            INNER JOIN level l ON l.idLevel = s.idLevel 
            INNER JOIN specialty sy ON s.idSpecialty = sy.idSpecialty 
            WHERE st.state = 1;";
			$query[0]['t'] = "S";
			$query[1]['q'] = "SELECT * FROM teacher WHERE state = 1;";
			$query[1]['t'] = "T";
			$query[2]['q'] = "SELECT DISTINCT * FROM coordinator WHERE state = 1;";
			$query[2]['t'] = "C";

			for ($i=0; $i < count($query); $i++) {
				$user = [];
				$aux = [];
				$res = $this->connection->connection->query($query[$i]['q']);
				$c = $res->num_rows;
				if ($c > 0) {
					while ($row = $res->fetch_assoc()){
						for ($j=0; $j < $c; $j++) {
							foreach ($row as $key => $value) {
								if ($key != 'password') $aux[$key] = $value;
							}
						}
						array_push($obj[$query[$i]['t']], $aux);
					}
				}
				$obj[$query[$i]['t']]['total'] = $c;
			}
			$obj['Total'] = $obj['S']['total'] + $obj['T']['total'] + $obj['C']['total'];

			for ($i=0; $i < $obj['S']['total']; $i++) {
				$obj['levels'][$obj['S'][$i]['level']][$obj['S'][$i]['sName']] = 0;
				for ($j=0; $j < $obj['S']['total']; $j++) { 
					if ($obj['S'][$j]['sName'] == $obj['levels'][$obj['S'][$i]['level']][$obj['S'][$i]['sName']]) {
						$obj['levels'][$obj['S'][$i]['level']][$obj['S'][$i]['sName']]++;
					}
				}
			}

			return $obj;
		}
	}

?>