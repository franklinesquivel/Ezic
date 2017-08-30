<?php 

	require_once('Administration.php');

	class Stadistics
	{
		private $connection;
        private $aux;
        private $admin;
		function __construct()
		{
			require_once('Page_Constructor.php');
            $const = new Constructor();
            $this->aux = $const->getRoute();

            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();

            $this->admin = new Administration();
		}

		function countUsers()
		{
			$c = 0;
			$obj = [];
			$obj['S'] = [];
			$obj['T'] = [];
			$obj['C'] = [];

			$query[0]['q'] = "SELECT COUNT(*) AS total FROM student st WHERE st.state = 1;";
			$query[0]['t'] = "S";
			$query[1]['q'] = "SELECT COUNT(*) AS total FROM teacher WHERE state = 1;";
			$query[1]['t'] = "T";
			$query[2]['q'] = "SELECT DISTINCT COUNT(*) AS total FROM coordinator WHERE state = 1;";
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
						$obj[$query[$i]['t']] = $aux;
					}
				}
			}
			$obj['Total'] = $obj['S']['total'] + $obj['T']['total'] + $obj['C']['total'];

			return $obj;
		}

		function gradeAvgBySection()
		{
			$obj = [];
			$sectionQuery = "SELECT sn.idSection FROM section sn INNER JOIN student s ON s.idSection = sn.idSection INNER JOIN student_average sa ON sa.idStudent = s.idStudent;";
			$sectionRes = $this->connection->connection->query($sectionQuery);
			if ($sectionRes->num_rows > 0) {
				while ($snRow = $sectionRes->fetch_assoc()) {
					$avSnQuery = "SELECT ROUND(AVG(sa.average), 2) AS snAvg FROM student_average sa INNER JOIN student st ON st.idStudent = sa.idStudent INNER JOIN section sn ON sn.idSection = st.idSection WHERE sn.idSection = " . $snRow['idSection'] . ";";
					$avSnRes = $this->connection->connection->query($avSnQuery);
					if ($avSnRes->num_rows > 0) {
						$obj[$snRow['idSection']] = $avSnRes->fetch_assoc()['snAvg'];
					}
				}

				return $obj;
			}else{

			}
		}

		function gradesInTime()
		{
			$obj = [];
			$periodQuery = "SELECT idPeriod FROM period;";
			$periodRes = $this->connection->connection->query($periodQuery);
			if ($periodRes->num_rows > 0) {
				while ($periodRow = $periodRes->fetch_assoc()) {
					$avgQuery = "SELECT p.nthPeriod, ROUND(AVG(sa.average), 2) AS average FROM period p INNER JOIN student_average sa ON sa.idPeriod = p.idPeriod WHERE p.idPeriod = " . $periodRow['idPeriod'];
					$avgRes = $this->connection->connection->query($avgQuery);
					if ($avgRes->num_rows > 0) {
						$aux = [];
						$avRow = $avgRes->fetch_assoc();
						$aux['nthPeriod'] =  $avRow['nthPeriod'];
						$aux['average'] =  $avRow['average'];
						array_push($obj, $aux);
					}
				}
				return $obj;
			}
		}

		function specialtyStats()
		{
			$obj = [];
			$lvlQuery = "SELECT * FROM level;";
			$lvlRes = $this->connection->connection->query($lvlQuery);
			while ($lvlRow = $lvlRes->fetch_assoc()) {
				$specialtyQuery = "SELECT * FROM specialty;";
				$specialtyRes = $this->connection->connection->query($specialtyQuery);
				if ($specialtyRes->num_rows > 0) {
					while ($specialtyRow = $specialtyRes->fetch_assoc()) {
						$syCant = "SELECT COUNT(*) AS cant, sy.sName, l.level FROM student st INNER JOIN section sn ON sn.idSection = st.idSection INNER JOIN specialty sy ON sy.idSpecialty = sn.idSpecialty INNER JOIN level l ON l.idLevel = sn.idLevel WHERE sy.idSpecialty = " . $specialtyRow['idSpecialty'] . " AND l.idLevel = " . $lvlRow['idLevel'] . ";";
						$syRes = $this->connection->connection->query($syCant);
						if ($syRes->num_rows > 0) {
							while ($syRow = $syRes->fetch_assoc()) {
								$aux = [];
								$aux['lvl'] = $syRow['level'];
								$aux['sName'] = $syRow['sName'];
								$aux['cant'] = $syRow['cant'];
								array_push($obj, $aux);
							}
							
						}
					}
				}
			}
			return $obj;
		}

		function topStudents()
		{
			$obj = [];
			$obj['students'] = [];
			$lvlQuery = "SELECT * FROM level;";
			$lvlRes = $this->connection->connection->query($lvlQuery);
			while ($lvlRow = $lvlRes->fetch_assoc()) {
				$aux = [];
				$studentQuery = "SELECT st.idStudent, sa.acc FROM student st INNER JOIN student_acc sa ON sa.idStudent = st.idStudent INNER JOIN section sn ON sn.idSection = st.idSection WHERE sn.idLevel = " . $lvlRow['idLevel'] . " ORDER BY sa.acc DESC;";
				$studentRes = $this->connection->connection->query($studentQuery);
				if ($studentRes->num_rows > 0) {
					$studentRow = $studentRes->fetch_assoc();
					$topStudent = $this->admin->get_user_data($studentRow['idStudent']);
				}else{
					$topStudent = null;
				}

				$aux['level'] = $lvlRow['level'];
				$aux['student']['info'] = $topStudent;
				$aux['student']['acc'] = ($topStudent !== null ? $studentRow['acc'] : "");
				array_push($obj['students'], $aux);
			}

			$gnrlAvg = $this->connection->connection->query("SELECT ROUND(AVG(sa.acc), 2) AS gnrlAvg FROM student_acc sa")->fetch_assoc()['gnrlAvg'];
			$obj['avg'] = $gnrlAvg;
			return $obj;
		}
	}

?>