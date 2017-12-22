<?php 
	
	/**
	* 
	*/
	class Justification
	{
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

		function v_justificationP($periods, $student){
			$options_periods = "";
			for ($i=0; $i < count($periods); $i++) { 
				$options_periods .= "<option value='".$periods[$i][0]."'>".$periods[$i][1].": ".$periods[$i][2]." hasta ".$periods[$i][3]."</option>";
			}
			$row = "<br> <h3 class='center'>Justificante</h3><div class='container'> 
				<div class='row'>
					<form class='justification'>
						<div class='input-field col l10 m6 s10 offset-l1 offset-m3 offset-s1'>
		            		<textarea id='justification' name='justification' class='materialize-textarea' data-length='300'></textarea>
		            		<label for='justification'>Justificación</label>
		                </div>
						<div class='input-field col l10 m6 s10 offset-l1 offset-m3 offset-s1'>
			                <select id='selectPeriodJustification'>
			                    <option value='' disabled selected>Seleccionar Período</option>	
			                    $options_periods
							</select>
							<label>Elegir Período</label>
		          		</div>
		          		<div class='row col l10 m10 s10 offset-l1 offset-m1 offset-s1 container-justification'>

						</div>
					</form>
				</div> 
			";

			return $row;
		}

		function getTableAssistance($period, $student){
			$period = json_decode($period);
			$query = "SELECT assistance.date, assistance.idAssistance, subject.acronym FROM `assistance` INNER JOIN schedule_register ON schedule_register.idS_Register = assistance.idSchedule INNER JOIN subject ON subject.idSubject = schedule_register.idSubject WHERE assistance.attended = 'N' AND assistance.idStudent = '$student' AND assistance.date BETWEEN '".$period[0]->startDate."' AND '".$period[0]->endDate."'";
			$result = $this->connection->connection->query($query);
			$verify = true;

			if ($result->num_rows > 0) {
				$table = "<div class='row'><table class='justification centered'>
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Materia</th>
							<th>Opción</th>
						</tr>
					</thead>
					<tbody>";
				while ($fila = $result->fetch_assoc()) {
					if ($this->verify_justification($fila['idAssistance'])) {
						$disabled = '';
						$tr_class = '';
						$title = '';
					}else{
						$disabled = "disabled = 'disabled'";
						$tr_class = "green";
						$title = 'Justificada';
					}
					$table .= "<tr class='".$tr_class."' title='".$title."'>
						<td>".$fila['date']."</td>
						<td>".$fila['acronym']."</td>
						<td>
							<input type='checkbox' class='btn_checkbox_J' id=".$fila['idAssistance']." $disabled />
		          			<label for=".$fila['idAssistance'].">Seleccionar</label>
						</td>
					</tr>";
				}
				$table .= "</tbody></table>
				</div>
				<div class='row'>
					<button class='col l4 m4 s6 offset-l4 offset-m4 offset-s3 btn waves-effect waves-light black btnSaveJustification'>Guardar
			    	 	<i class='material-icons right'>save</i>
			    	</button>
				</div>
				";
			}else{
				$table = "<div class='alert_'><h4>No se han encontrado faltas en el período seleccionado</h4></div>";
			}

			return $table;
		}

		function newJustification($idAssistance, $justification){
			$query = "INSERT INTO justification(idAssistance, justification) VALUES('$idAssistance', '$justification')";
			return $this->connection->connection->query($query);
		}

		function verify_justification($idAssistance){
			$query = "SELECT * FROM justification WHERE idAssistance = '$idAssistance'";
			$result = $this->connection->connection->query($query);
			return ($z = ($result->num_rows > 0) ? 0 : 1);
		}
	}
?>