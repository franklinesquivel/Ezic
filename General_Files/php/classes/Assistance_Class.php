<?php 

	class Assistance{
		
		private $connection;
		private $aux;
		private $days_letter;
		private $days_number;

		function __construct(){

			require_once('Page_Constructor.php');
			$const = new Constructor();

			$this->aux = $const->getRoute();
			
			require_once($this->aux);
			$this->connection = new Connection();
			$this->connection->Connect();
			$this->days_letter = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado", "Domingo");
			$this->days_number =  array('Domingo' => 00, 'Lunes' => 01, 'Martes' => 02, 'Miercoles' => 03, 'Jueves' => 04, 'Viernes' =>05, 'Sabado'=>06);
		}


		#-----------Este metodo devuelve el salon al que debe pasar asistencia- vista
		function getSecheduleAssistance($horaLocal, $date){
			if(!isset($_SESSION)){
				session_start();
			}

			ini_set("date.timezone", 'America/El_Salvador');
			$day = $this->days_letter[date('w')];
			
			$query = "SHOW TABLES FROM ezic WHERE TABLES_IN_ezic LIKE 'teacher_schedule_".$_SESSION['id']."'";
			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$query = "SELECT schedule_register.idS_Register, student.idStudent, student.name, student.lastName, student.stateAcademic FROM `teacher_schedule_" . $_SESSION['id'] . "` INNER JOIN schedule_register ON schedule_register.idS_Register = teacher_schedule_".$_SESSION['id'].".idScheduleInfo INNER JOIN section ON section.idSection = schedule_register.idSection INNER JOIN level ON section.idLevel = level.idLevel INNER JOIN student ON student.idSection = section.idSection  WHERE student.stateAcademic != 'E' AND student.verified = 1 AND schedule_register.startTime BETWEEN schedule_register.startTime AND '$horaLocal' AND schedule_register.endTime BETWEEN '$horaLocal' AND schedule_register.endTime AND schedule_register.day ='$day' ORDER BY student.lastName ASC";
				$result = $this->connection->connection->query($query);
				$column = $this->connection->connection->query($query);
				$idSchedule = $column->fetch_assoc();

				if ($result->num_rows > 0) {
					if ($this->verifyAssistance($idSchedule['idS_Register'], $date)) {
						$disabled_All = '';
					}else{	
						$disabled_All = "disabled = 'disabled'";
					}
					$block = $this->verifyBlock($idSchedule['idS_Register']);
					$block =  ($block != false) ? implode(",", $block) : $idSchedule['idS_Register'];

					$table = "<div class='row col l8 m8 s12 offset-l2 offset-m2'><table class='centered responsive-table assistance' register='".$block."'> 
						<thead>
							<tr>
								<th># Lista</th>
			                    <th>Carnet</th>
			                    <th>Nombre</th>
			                    <th>Asistió</th>
			                    <th>Llegada Tardía</th>
			                    <th>No asistió</th>
								<th>Aplicar Código</th>
		                    </tr>
	                	</thead>
					";
					$table .= "<tbody>";
					$i = 0;
					while($fila = $result->fetch_assoc()){
						$verify_query = "SELECT * FROM permission WHERE idStudent = '".$fila['idStudent']."' AND idSchedule = '".$fila['idS_Register']."' AND date = '".$date."'";
						$verify_result = $this->connection->connection->query($verify_query);
						if ($verify_result->num_rows > 0) {
							$tr_class = 'blue darken-2 permission';
							$disabled = "disabled = 'disabled'";
							$title = 'Estudiante con permiso';
						}else{
							if ($fila['stateAcademic'] == "W") {
								$tr_class = 'warned yellow lighten-1';
								$disabled = '';
								$title = '';
							}elseif ($fila['stateAcademic'] == "E") {
								$tr_class = 'expulsed red darken-2';
								$disabled = "disabled = 'disabled'";
								$title = 'Estudiante Expulsado';
							}else{
								$tr_class = '';
								$disabled = '';
								$title = '';
							}
						}
						$table .="<tr id='".$fila['idStudent']."' class='".$tr_class."' title='".$title."'>
							<td>".($i+1)."</td>
							<td>".$fila['idStudent']."</td>
							<td class='info'>".$fila['lastName'].", ".$fila['name']."</td>
							<td>
			          			<input name='student_".$i."' type='radio' class='btn_radio' value='S' id='".$fila['idStudent']."_0' ".$disabled." $disabled_All/>
			          			<label for='".$fila['idStudent']."_0'></label>
			        		</td>
			        		<td>
			          			<input name='student_".$i."' type='radio' value='T' class='btn_radio' id='".$fila['idStudent']."_1' ".$disabled." $disabled_All/>
			         			<label for='".$fila['idStudent']."_1'></label>
			        		</td>
			        		<td>
			        			<input name='student_".$i."' type='radio' value='N' class='btn_radio' id='".$fila['idStudent']."_2' ".$disabled." $disabled_All/>
			        			<label for='".$fila['idStudent']."_2'></label>
			        		</td>
							<td>
			        			<div id='btnStudent_".$i."' class='btn btnCodeModal waves-effect waves-light green darken-2' ".$disabled.">Abrir
			    	   				<i class='material-icons right'>save</i>
			    	   			</div>
			        		</td>
						</tr>";
						$i++;
					}
					$table .= "</tbody></table></div>";
					$table .= "<div class='row col s12'>
			    	    <button class='col l4 m4 s4 offset-l4 offset-m4 offset-s4 btn waves-effect waves-light green darken-2 btnSave' $disabled_All>Guardar
			    	    		<i class='material-icons right'>save</i>
			    	    </button>
			    	</div>";
				}else{
					$table = "0";
				}
			}else{
				$table = "-1";
			}
			
			return $table;
		}

		function verifyAssistance($idS_Register, $date){
			$query = "SELECT * FROM assistance WHERE idSchedule = $idS_Register AND date = '$date'";
			$result = $this->connection->connection->query($query);
			return ($r = ($result->num_rows > 0) ? false : true);
		}

		function insertAssistance($idStudent, $state, $date, $idSchedule){
			$idSchedule = explode(",", $idSchedule);
			$z = 0;
			for($i = 0; $i < count($idSchedule); $i++){
				$query = "INSERT INTO assistance(idStudent, date, attended, idSchedule) VALUES('$idStudent', '$date', '$state', '".$idSchedule[$i]."')";
				if($this->connection->connection->query($query)){
					$z++;
				}
			}
			
			return ($z = ($z > 0) ? true : false);
		}
		
		function verifyBlock($idS_Register){
			$query = "SELECT * FROM schedule_register ORDER BY day";
			$result = $this->connection->connection->query($query);
			$i = 0;
			$block = array();
			if($result->num_rows > 1){
				while($fila = $result->fetch_assoc()){
					$block[$i][0] = $fila['idS_Register'];
					$block[$i][1] = $fila['day'];
					$block[$i][2] = $fila['startTime'];
					$block[$i][3] = $fila['endTime'];
					$block[$i][4] = $fila['idSection'];
					$block[$i][5] = $fila['idSubject'];
					$block[$i][6] = $fila['nthHour'];
					$i++;
				}

				for($x = 0; $x < count($block); $x++){
					for($z = 0; $z < count($block); $z++){
						if(($block[$x][1] == $block[$z][1]) && ($block[$x][4] == $block[$z][4]) &&
							($block[$x][5] == $block[$z][5]) && ($block[$x][3] == $block[$z][2]) &&
							(($block[$x][6] + 1) == $block[$z][6])){
							return array($block[$x][0] , $block[$z][0]);
						}
					}
				}
				return false;
			}else{
				return false;
			}
		}
	}
?>