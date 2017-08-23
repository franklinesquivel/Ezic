<?php
	require_once '../DB_Connection.php';
	require_once 'Schedule.php';
	require_once 'Administration.php';
	require_once 'Grade_Class.php';
	require_once 'Section_Class.php';


	class Print_Class
	{
		private $mpdf;
		private $schedule;
		private $administration;
		private $section;
		private $connection;
		private $_print;
		private $stylesheet;

		function __construct()
		{
			require_once '../../mpdf/mpdf.php';
			$this->connection = new Connection();
			$this->connection->Connect();

			$this->schedule = new Schedule();
			$this->administration = new Administration();
			$this->grade = new Grade();
			$this->section = new Section();
		}

		function getSchedule($type, $id)
		{
			if ($type == 'S') {
				$query = "
				SELECT * FROM student s 
				INNER JOIN section sn ON s.idSection = sn.idSection 
				INNER JOIN level l ON sn.idLevel = l.idLevel
				INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty
				WHERE idStudent = '$id'";
			}else{
				$query = "SELECT * FROM  teacher WHERE idTeacher  = '$id'";
			}

			$res = $this->connection->connection->query($query);
			$row = $res->fetch_assoc();

			$title = ($type == 'S' ? $row['level'] . ($row['level'] == 1 ? 'er' : ($row['level'] == 2 ? 'do' : 'er')) . ' Año de Bachillerato, Sección <i>"' . $row['sectionIdentifier'] . '"</i>.<br>Opción: ' . $row['sName']  : $row['idTeacher'] . "<br>" . $row['name'] . " " . $row['lastName'] . "<br>" . $row['profession']) . ".";

			$name = ($type == 'S' ? $row['level'] . ($row['level'] == 1 || $row['level'] == 3 ? 'ro' : 'do') . "_" . $row['sectionIdentifier'] : $row['idTeacher']) . "(Horario)";

			$this->stylesheet = file_get_contents('../../mpdf/resources/schedule.css');
			$this->_print = $this->schedule->printSchedule($type, $id, $title);

			$this->mpdf = new mPDF('utf-8', 'A4-L', 0, '', 10, 10, 10, 0, 0, 0, 'L');
			$this->mpdf->setTitle('Ezic: Horarios.');
			$this->mpdf->setAuthor('Ezic ©');
			$this->openPDF($title, $name);
		}

		function getRecord($id, $f = 1, $dir = 0)
		{
			$this->stylesheet = file_get_contents('../../mpdf/resources/record.css');
			$auxCSS = file_get_contents('../../mpdf/resources/colors.css');

			$this->_print = $this->administration->printRecord($id);

			// $this->mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 0, 0, 0, 'P');
			$this->mpdf = new mPDF();
			$this->mpdf->WriteHTML($auxCSS, 1);
			$this->mpdf->setTitle('Ezic: Records.');
			$this->mpdf->setAuthor('Ezic ©');
			$this->openPDF("Récord Conductual", ($id . "_record"), $f, $dir);
		}

		function genHeader($title)
		{
			ini_set("date.timezone", 'America/El_Salvador');
            $date = date("d/m/Y");
			$aux .= "
			<div class='PDF_header'>
				<div class='logo'>
		            <img src='../../img/ezic.png'>
				</div>
				<div class='info'>
					<p class='date'>$date</p>
		            <h4 class='title'>$title</h4><br>
				</div>
			</div>
            ";

            $this->mpdf->WriteHTML($aux, 2);
		}

		function getUser($id, $f = 1, $dir = 0)
		{
			$this->stylesheet = file_get_contents('../../mpdf/resources/user.css');
			$auxCSS = file_get_contents('../../mpdf/resources/colors.css');

			$this->_print = $this->administration->printUser($this->administration->get_user_data($id));

			$this->mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 0, 0, 0, 'P');
			$this->mpdf->WriteHTML($auxCSS, 1);
			$this->mpdf->setTitle('Ezic: Usuarios.');
			$this->mpdf->setAuthor('Ezic ©');
			$this->openPDF("Perfil de usuario", $id, $f, $dir);
		}

		function getGrades($id, $period, $f = 1, $dir = 0)
		{
			$this->stylesheet = file_get_contents('../../mpdf/resources/grades.css');
			$auxCSS = file_get_contents('../../mpdf/resources/colors.css');
			if ($period == "acc") {
				$this->_print = $this->grade->printAcc($id);
			}else{
				$this->_print = $this->grade->printGrades($id, $period);
			}
			$this->mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 0, 0, 0, 'P');
			$this->mpdf->WriteHTML($auxCSS, 1);
			$this->mpdf->setTitle('Ezic: Notas.');
			$this->mpdf->setAuthor('Ezic ©');
			$this->openPDF("Notas de estudiante", "Notas_" . $id . "_Periodo_$period", $f, $dir);
		}

		function getSection($id, $c)
		{
			$this->stylesheet = file_get_contents('../../mpdf/resources/sections.css');
			$auxCSS = file_get_contents('../../mpdf/resources/colors.css');
			$this->_print = $this->section->printSection($id, $c);
			$this->mpdf = new mPDF('utf-8', 'A4', 0, '', 10, 10, 10, 0, 0, 0, 'P');
			$this->mpdf->WriteHTML($auxCSS, 1);
			$this->mpdf->setTitle('Ezic: Secciones.');
			$this->mpdf->setAuthor('Ezic ©');
			$query = "SELECT * FROM section sn INNER JOIN level ll ON sn.idLevel = ll.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty WHERE sn.idSection = $id";
			$res = $this->connection->connection->query($query);
			$row = $res->fetch_assoc();
			$this->openPDF("Listado de sección", "Lista_" . $row['level'] . $row['sectionIdentifier']);
		}

		function multiGrades($id, $period)
		{
			$query = "SELECT * FROM student st INNER JOIN section sn on st.idSection = sn.idSection INNER JOIN level lvl ON lvl.idLevel = sn.idLevel WHERE sn.idSection = $id;";
			$res = $this->connection->connection->query($query);
			$resAux = $this->connection->connection->query($query);

			$rowAux = $resAux->fetch_assoc();
			$dirName = "Notas_" . $rowAux['level'] . $rowAux['sectionIdentifier'] . "_Periodo-" . $period;

			mkdir("../../../app/users/files/tmp/$dirName", 0700);

			while ($row = $res->fetch_assoc()) {
				$this->getGrades($row['idStudent'], $period, 0, $dirName);
			}

			$this->createRar($dirName);
		}

		function multiRecords($id)
		{
			$query = "SELECT * FROM student st INNER JOIN section sn on st.idSection = sn.idSection INNER JOIN level lvl ON lvl.idLevel = sn.idLevel WHERE sn.idSection = $id;";
			$res = $this->connection->connection->query($query);
			$resAux = $this->connection->connection->query($query);

			$rowAux = $resAux->fetch_assoc();
			$dirName = "Records_" . $rowAux['level'] . $rowAux['sectionIdentifier'];

			mkdir("../../../app/users/files/tmp/$dirName", 0700);

			while ($row = $res->fetch_assoc()) {
				$this->getRecord($row['idStudent'], 0, $dirName);
			}

			$this->createRar($dirName);
		}

		function multiUsers($id)
		{
			$query = "SELECT * FROM student st INNER JOIN section sn on st.idSection = sn.idSection INNER JOIN level lvl ON lvl.idLevel = sn.idLevel WHERE sn.idSection = $id;";
			$res = $this->connection->connection->query($query);
			$resAux = $this->connection->connection->query($query);

			$rowAux = $resAux->fetch_assoc();
			$dirName = "Estudiantes_" . $rowAux['level'] . $rowAux['sectionIdentifier'];

			mkdir("../../../app/users/files/tmp/$dirName", 0700);

			while ($row = $res->fetch_assoc()) {
				$this->getUser($row['idStudent'], 0, $dirName);
			}

			$this->createRar($dirName);
		}


		function openPDF($title, $name, $f = 1, $dir = 0)
		{
			if ($f) {
				header('Content-Disposition: attachment; filename="' . $name . '.pdf"');
			}
			$this->mpdf->WriteHTML($this->stylesheet, 1);
			$this->genHeader($title);
			$this->mpdf->WriteHTML($this->_print, 2);
			// $this->mpdf->Output($name.".pdf", "I");
			$this->mpdf->Output( ($f ? '' : "../../../app/users/files/tmp/$dir/") . $name.".pdf", ($f ? "D" : "F"));
		}

		function createRar($name)
		{
			$zip = new ZipArchive();
			$filename = "../../../app/users/files/tmp/$name.zip";
			$tmp_file = tempnam("../../../app/users/files/tmp/$name.zip", "");

			$zip->open($tmp_file, ZipArchive::CREATE);

			foreach (glob("../../../app/users/files/tmp/$name/*.*") as $file) {
				$zip->addFile($file, explode('/', $file)[count(explode('/', $file)) - 1]);
			}

		    $zip->close();

		    header("Content-disposition: attachment; filename=$name.zip");
		    header("Content-Type: application/zip");
		    readfile($tmp_file);

		    foreach (glob("../../../app/users/files/tmp/$name/*.*") as $file) {
				unlink($file);
			}
		    rmdir("../../../app/users/files/tmp/$name");
		    // header("Content-Transfer-Encoding: Binary");
		    // header("Content-Length: ".filesize($tmp_file));
		    // header("Content-Disposition: attachment; filename=\"".basename($tmp_file)."\"");
		}
	}

	$print = new Print_Class();

	if (isset($_POST['printSchedule'])) {
		$print->getSchedule($_POST['type'], $_POST['id']);
	}

	if (isset($_POST['printRecord'])) {
		$print->getRecord($_POST['id']);
	}

	if (isset($_POST['printUser'])) {
		$print->getUser($_POST['id']);
	}

	if (isset($_POST['printGrades'])) {
		$print->getGrades($_POST['id'], $_POST['period']);
	}

	if (isset($_POST['printSection'])) {
		$print->getSection($_POST['id'], $_POST['rows']);
	}

	if (isset($_POST['printSectionGrades'])) {
		$print->multiGrades($_POST['id'], $_POST['idPeriod']);
	}

	if (isset($_POST['printSectionRecords'])) {
		$print->multiRecords($_POST['id']);
	}

	if (isset($_POST['printSectionUsers'])) {
		$print->multiUsers($_POST['id']);
	}
?>