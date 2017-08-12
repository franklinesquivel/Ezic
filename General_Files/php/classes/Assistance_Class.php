<?php 

	class Assistance{
		
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


		#-----------Este metodo devuelve el salon al que debe pasar asistencia- vista
		function getSecheduleAssistance($horaLocal, $date){
			session_start();
			$query = "SHOW TABLES FROM ezic WHERE TABLES_IN_ezic LIKE 'teacher_schedule_".$_SESSION['id']."'";
			$result = $this->connection->connection->query($query);
			if ($result->num_rows > 0) {
				$query = "SELECT schedule_register.idS_Register, student.idStudent, student.name, student.lastName, student.stateAcademic FROM `teacher_schedule_" . $_SESSION['id'] . "` INNER JOIN schedule_register ON schedule_register.idS_Register = teacher_schedule_" . $_SESSION['id'] . ".idScheduleInfo INNER JOIN section ON section.idSection = schedule_register.idSection INNER JOIN level ON section.idLevel = level.idLevel INNER JOIN student ON student.idSection = section.idSection  WHERE student.stateAcademic = 'A' AND student.verified = 1 AND schedule_register.startTime BETWEEN schedule_register.startTime AND '$horaLocal' AND schedule_register.endTime BETWEEN '$horaLocal' AND schedule_register.endTime ORDER BY student.lastName ASC";
				$result = $this->connection->connection->query($query);
				$column = $this->connection->connection->query($query);
				$idSchedule = $column->fetch_assoc();
				if ($result->num_rows > 0) {
					if ($this->verifyAssistance($idSchedule['idS_Register'], $date)) {

						$table = "<div class='row col l8 m8 s12 offset-l2 offset-m2'><table class='centered responsive-table assistance' register='".$idSchedule['idS_Register']."'> 
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
			          				<input name='student_".$i."' type='radio' class='btn_radio' value='S' id='".$fila['idStudent']."_0' ".$disabled."/>
			          				<label for='".$fila['idStudent']."_0'></label>
			        			</td>
			        			<td>
			          				<input name='student_".$i."' type='radio' value='T' class='btn_radio' id='".$fila['idStudent']."_1' ".$disabled."/>
			          				<label for='".$fila['idStudent']."_1'></label>
			        			</td>
			        			<td>
			          				<input name='student_".$i."' type='radio' value='N' class='btn_radio' id='".$fila['idStudent']."_2' ".$disabled."/>
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
			    	    	<button class='col l4 m4 s4 offset-l4 offset-m4 offset-s4 btn waves-effect waves-light green darken-2 btnSave'>Guardar
			    	    		<i class='material-icons right'>save</i>
			    	    	</button>
			    		</div>";
					}else{
						$table = "0";
					}
				}else{
					$table = "0";
				}
			}else{
				$table = "n";
			}
			
			return $table;
		}

		function verifyAssistance($idS_Register, $date){
			$query = "SELECT * FROM assistance WHERE idSchedule = $idS_Register AND date = '$date'";
			$result = $this->connection->connection->query($query);
			return ($r = ($result->num_rows > 0) ? false : true);
		}

		function insertAssistance($idStudent, $state, $date, $idSchedule){
			$query = "INSERT INTO assistance(idStudent, date, attended, idSchedule) VALUES('$idStudent', '$date', '$state', '$idSchedule')";

			return ($this->connection->connection->query($query));
		}
	}
?>