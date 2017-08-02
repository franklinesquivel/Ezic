<?php 
	class Permission{
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
			$this->days_letter = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo");
			$this->days_number =  array('Domingo' => 00, 'Lunes' => 01, 'Martes' => 02, 'Miercoles' => 03, 'Jueves' => 04, 'Viernes' =>05, 'Sabado'=>06);
		}

		function v_make_permission($student){
			ini_set("date.timezone", 'America/El_Salvador');
			$query = "SELECT student.idStudent, schedule_register.idS_Register, schedule_register.day, schedule_register.idSubject FROM student INNER JOIN schedule_register ON schedule_register.idSection = student.idSection WHERE student.idStudent = '$student' GROUP BY schedule_register.day";
			$result = $this->connection->connection->query($query);

			$fecha = date("Y-m-d");
			$days = $this->getDay($student);	
			$today = true;

			if ($result->num_rows > 0) {
				$form = "<h3 class='center'>Permiso</h3><div class='container'> 
					<form class='addPermission'>
						<div class='row'>
							<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
		            			<textarea id='justification' name='justification' class='materialize-textarea' data-length='300'></textarea>
		            			<label for='justification'>Justificación</label>
		                    </div>
		                    <div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
		                        <select id='selectPermission'>
		                        	<option value='' disabled selected>Seleccionar Día</option>
	            ";
		                        	for ($i=0; $i < count($days) ; $i++) {

		                        		if (count($days) == 2 && $today) {
		                        			$form .= "<option value='".date("Y-m-d")."'>Hoy</option>";
		                        			$today = false;
		                        		}

		                        		$form .= "<option value='".date("Y-m-d", strtotime ("+".$days[$i][0]." day", strtotime($fecha)))."'>".$this->days_letter[$days[$i][1]]."</option>";
		                        	}
						      	
				$form.="		
								</select>
							    <label>Elegir Día</label>
	          				</div>
						</div>
						
					
					<div class='schedule_permission'>
							
					</div>
					</form>
				</div>";
			}else{
				$form = "0";
			}

			return $form;	
		}

		function getDay($student){
			ini_set("date.timezone", 'America/El_Salvador');
			$query = "SELECT student.idStudent, schedule_register.idS_Register, schedule_register.day, schedule_register.idSubject FROM student INNER JOIN schedule_register ON schedule_register.idSection = student.idSection WHERE student.idStudent = '$student' GROUP BY schedule_register.day";
			$result = $this->connection->connection->query($query);
			$day_table = array();
			$i = 0;
			$third_day = false;
			// if ($result->num_rows > 1) {
				while ($fila = $result->fetch_assoc()) {
					if ($this->days_number[$this->days_letter[date("w")]] != $this->days_number[$fila['day']]) {
						$day_table[$i] = $this->days_number[$fila['day']];
						$i++;
					}else if($this->days_number[$this->days_letter[date("w")]] == $this->days_number[$fila['day']]){
					}

					if ($this->days_letter[date("w")] != $fila['day']) {
						$third_day = true;
					}
				}
		
				$tomorrow_suma = array();
				$x = 0;
				$z = ($third_day) ? 3 : 2;

				for ($i=0; $i < count($day_table); $i++) { 
					if ($x < $z) {
						if ($day_table[$i] > $this->days_number[$this->days_letter[date("w")]]) {
							$tomorrow_suma[$x][0] = $day_table[$i] - $this->days_number[$this->days_letter[date("w")]];
							$tomorrow_suma[$x][1] = $day_table[$i];
						}
						if ($this->days_number[$this->days_letter[date("w")]] > $day_table[$i]) {
							$tomorrow_suma[$x][0] =  7  - ($this->days_number[$this->days_letter[date("w")]] - $day_table[$i]);
							$tomorrow_suma[$x][1] = $day_table[$i];
						}
					}
					$x++;
				}
			// }else{
			// 	$fila = $result->fetch_assoc();
			// 	$tomorrow_suma[0][0] = ;
			// 	$tomorrow_suma[0][1] = ;
			// 	$tomorrow_suma[1][0] = ;
			// 	$tomorrow_suma[1][1] = ;
			// 	$tomorrow_suma[2][0] = ;
			// 	$tomorrow_suma[2][1] = ;
			// }
			
			return $tomorrow_suma;
		}

		function getSchedule($student, $day){
			$fecha = $day;
			ini_set("date.timezone", 'America/El_Salvador');
			$day = $this->days_letter[date("w", strtotime($fecha))];
			$hour = date("G:i:s");

			if ($fecha == date("Y-m-d")) {
				$query = "SELECT student.idStudent, schedule_register.idS_Register, subject.acronym, schedule_register.startTime, schedule_register.endTime FROM student INNER JOIN schedule_register ON schedule_register.idSection = student.idSection INNER JOIN subject ON subject.idSubject = schedule_register.idSubject WHERE student.idStudent = '$student' AND schedule_register.day = '$day' AND schedule_register.startTime >= '$hour' ORDER BY schedule_register.startTime"; 
			}else{
				$query = "SELECT student.idStudent, schedule_register.idS_Register, subject.acronym, schedule_register.startTime, schedule_register.endTime FROM student INNER JOIN schedule_register ON schedule_register.idSection = student.idSection INNER JOIN subject ON subject.idSubject = schedule_register.idSubject WHERE student.idStudent = '$student' AND schedule_register.day = '$day' ORDER BY schedule_register.startTime"; 
			}
			
			$result = $this->connection->connection->query($query);


			if ($result->num_rows > 0) {
				$table = "<div class='row'><table class='permission centered col l8 m10 s10 offset-l2 offset-m1 offset-s1'>
					<thead>
			          <tr>
			              <th>Horas</th>
			              <th>Asignatura</th>
			              <th>Opción</th>
			          </tr>
	        		</thead>
	        		<tbody>
	        	";
				while ($fila = $result->fetch_assoc()) {

					$verify_permission = "SELECT * FROM permission WHERE date = '$fecha' AND idStudent = '$student' AND idSchedule = '".$fila['idS_Register']."'";
					$result_permission = $this->connection->connection->query($verify_permission);

					if ($result_permission->num_rows > 0) {
						$disabled = "disabled = 'disabled'";
						$tr_class = "green";
						$title = 'Bloque con permiso';
					}else{
						$disabled = '';
						$tr_class = '';
						$title = '';
					}

					$table .= "<tr class='".$tr_class."' title='".$title."'>
						<td>".$fila['startTime']." - ".$fila['endTime']."</td>
						<td>".$fila['acronym']."</td>
						<td>
							<input $disabled type='checkbox' class='btn_checkbox' id=".$fila['idS_Register']." />
	          				<label for=".$fila['idS_Register'].">Seleccionar</label>
						</td>
					</tr>";
				}
				$table .= "</tbody></table></div>
				<div class='row'>
						<button class='col l3 m4 s8 offset-l2 offset-m1 offset-s2 btn waves-effect waves-light black btnSavePermission'>Guardar
			    	    		<i class='material-icons right'>save</i>
			    	    </button>
			    	    <div class='hide-on-med-and-up col s12'><i style='opacity: 0'>.</i></div>
			    	    <div class='col l3 m4 s8 offset-l2 offset-m2 offset-s2 btn waves-effect waves-light green btnAllPermission'>Seleccionar Todo
			    	    		<i class='material-icons right'>done_all</i>
			    	    </div>
						</div>
					";
			}else{
				$table = "0";
			}
			return $table;
		}

		function newPermission($student, $justification, $idSchedule, $date){
			$query = "INSERT INTO permission(justification, idStudent, idSchedule, date) VALUES('$justification', '$student', '$idSchedule', '$date')";
			return ($this->connection->connection->query($query));
		}
	}
?>