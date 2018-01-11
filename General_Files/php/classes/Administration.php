<?php

	require_once('User_Class.php');
	class Administration extends Users
	{
		public $Users_Array = [];
		private $gnrl_code;
		function __construct()
		{
			parent::__construct();
			require_once('Page_Constructor.php');
            $const = new Constructor();
            $this->aux = $const->getRoute();

            require_once($this->aux);
            $this->connection = new Connection();
			$this->connection->Connect();
			
			require_once('Info_Code.php');
			$this->gnrl_code = new Info_Code();
		}

		function sendUsers(){
			return $this->getUsers();
		}

		function get_user_data($id){
			$user = [];
			if ($id[0] == 'C' && is_numeric($id[1])) {
				$idLog = 'idCoor'; $table = 'coordinator'; $type = 'C'; $xtra = "";
			}elseif ($id[0] == 'D' && is_numeric($id[1])) {
				$idLog = 'idTeacher'; $table = 'teacher'; $type = 'T'; $xtra = "";
			}else{
				$idLog = 'idStudent'; $table = 'student'; $type = 'S';
				$xtra = "s INNER JOIN section sn ON s.idSection = sn.idSection INNER JOIN level l ON sn.idLevel = l.idLevel INNER JOIN specialty sy ON sn.idSpecialty = sy.idSpecialty";
			}

			$user_query = "SELECT * FROM $table $xtra WHERE $idLog = '" . $id . "';";
			$user_res = $this->connection->connection->query($user_query);

			while ($row = $user_res->fetch_assoc()) {
				$user['type'] = $type;
				foreach ($row as $key => $value) {
					$user[($key == $idLog ? "id" : $key)] = $value;
				}
			}

			return $user;
		}

		function findKey($array, $field, $value){
			foreach($array as $key => $element){
				if ( $element[$field] === $value )
				return $key;
			}
			return false;
		}

		function conductRecord($id){
			$code_c = []; $code_t = []; //Tipos y Categorías de Códigos
			$record = []; //Registros de la tabla de Record del estudiante
			$user_info = []; //Información del estudiante que se mostrará el record
			$applier = []; //Información de los Docentes/Coordinadores que han aplicado código al estudiante
			$non_attendance = []; //Información de las inasistencias
			$record_element = "";

			$user_info = $this->get_user_data($id); //Se obtiene la información del estudiante

			//OBTENER CATEGORÍAS Y TIPOS DE CÓDIGOS
			$code_c_query = "SELECT * FROM code_category";
			$code_t_query = "SELECT * FROM code_type";

			$code_c_res = $this->connection->connection->query($code_c_query);
			$code_t_res = $this->connection->connection->query($code_t_query);

			if ($code_c_res->num_rows > 0 && $code_t_res->num_rows > 0) { //Si hay registros de categorías y tipos 
				while ($code_c_row = $code_c_res->fetch_assoc()) {
					$array = [];
					foreach ($code_c_row as $key => $value) {
						$array[$key] = $value;
					}
					array_push($code_c, $array);
				}

				while ($code_t_row = $code_t_res->fetch_assoc()) {
					$array = [];

					foreach ($code_t_row as $key => $value) {
						$array[$key] = $value;
					}
					array_push($code_t, $array);
				}

				//OBTENER REGISTROS DEL RECORD DEL ESTUDIANTE
				$record_query = "
				SELECT * FROM code c
				INNER JOIN applied_code a ON c.idCode = a.idCode 
				INNER JOIN record r ON r.idApplied_Code = a.idApplied_Code 
				INNER JOIN period p ON p.idPeriod = a.idPeriod 
				WHERE r.idStudent = '" . $user_info['id'] . "';";

				$record_res = $this->connection->connection->query($record_query);

				while ($row = $record_res->fetch_assoc()) {
					$array = [];
	                foreach ($row as $key => $value) {
	                    $array[$key] = $value;
	                }
	            	array_push($record, $array);
	            }

	            //OBTENER INFORMACIÓN DE LOS APLICADORES
	            for ($i=0; $i < count($record); $i++) {
	            	array_push($applier, $this->get_user_data($record[$i]['idApplier']));
	            }

	            for ($i=0; $i < count($code_c); $i++) {
	            	$code_c[$i]['cant'] = 0;
	            	for ($j=0; $j < count($record); $j++) { 
	            		if ($code_c[$i]['idCategory'] == $record[$j]['category']) {
	            			$code_c[$i]['cant'] += 1;
	            		}
	            	}
	            }

	            //OBTENER INFORMACIÓN DE LAS INASISTENCIAS
	            $non_attendanceQuery = "SELECT ae.date, rs.day, (SELECT COUNT(*) FROM justification j WHERE j.idAssistance = ae.idAssistance) AS state, s.nameSubject FROM assistance ae INNER JOIN schedule_register rs ON rs.idS_Register = ae.idSchedule INNEr JOIN subject s ON s.idSubject = rs.idSubject WHERE ae.idStudent = '$id' AND ae.attended = 0;";

	            $non_attendanceRes = $this->connection->connection->query($non_attendanceQuery);
	            $naF = ($non_attendanceRes->num_rows > 0 ? 1 : 0);


	            if ($naF) {
	            	while ($naRow = $non_attendanceRes->fetch_assoc()) {
	            		$aux = [];
	            		foreach ($naRow as $key => $value) {
	            			$aux[$key] = $value;
	            		}
	            		array_push($non_attendance, $aux);
	            	}
	            }

	            //LLENAR ELEMENTO DEL RECORD
	            $record_element .= "
	            <div class='record'>
					<div class='gnrl-info'>
						<div class='photo'>
						<img class='circle' src='../../files/profile_photos/" . $user_info['photo'] . "'>
						</div>
						<div class='data'>
						<div><span class='title'>Nombre: </span>" . $user_info['name'] . " ". $user_info['lastName'] . "</div>
						<div><span class='title'>Código: </span>" . $user_info['id'] . "</div>
						<div><span class='title'>Grado: </span>" . $user_info['level']  . ($user_info['level'] == 1 || $user_info['level'] == 3 ? 'er' : 'do' ) . " Año</div>
						<div><span class='title'>Sección: </span>\"" . $user_info['sectionIdentifier'] . "\"</div>
						<div><span class='title'>Especialidad: </span>" . $user_info['sName'] . "</div>
						</div>
					</div>
					<div class='codes'>
							<h3 class='center'>Control de Inasistencias</h3>
							<table class='centered bordered recordTables'>
								<thead>
									<tr class='black'>
										<th>N°</th>
										<th>Fecha</th>
										<th>Materia</th>
										<th>Estado</th>
									</tr>
								</thead>
								<tbody>";
				if($naF){
					for ($i=0; $i < count($non_attendance); $i++) { 
						$record_element .= "
									<tr>
										<td>" . ($i + 1) . "</td>
										<td>" . $non_attendance[$i]['date'] . "</td>
										<td>" . $non_attendance[$i]['nameSubject'] . "</td>
										<td class='" . ($non_attendance[$i]['state'] ? "green" : "red") . " lighten-4'>" . ($non_attendance[$i]['state'] ? "Justificada" : "Sin justificar") . "</td>
									</tr>";
					}
				}else{
					$record_element .= "<tr><td colspan='4'>No posee inasistencias!</td></tr>";
				}
				$record_element .= "</tbody></table><br><br>";
				$record_element .= "<h3 class='center'>Control de Códigos</h3>";

		        for ($i=0; $i < count($code_c); $i++) { //Recorrer categorías
		        	$record_element .= ($i == 0 ? "" : "<br><br>") ."
						<h5 class='table-title center "  . $code_c[$i]['color'] .  "'>"  . $code_c[$i]['category'] .  "</h5>
						<table class='centered bordered recordTables '>
							<thead>
								<tr class='" . $code_c[$i]['color'] . "'>
									<th>N°</th>
									<th>Período</th>
									<th>Fecha</th>
									<th>Hora</th>
									<th>Código</th>
									<th>Aplicado por</th>
									<th>Tipo</th>
								</tr>
							</thead>
							<tbody>";
					if ($code_c[$i]['cant'] > 0) {
						$j = 1;
						for ($x=0; $x < count($record); $x++) { //Recorrer record
			        		if ($record[$x]['category'] == $code_c[$i]['idCategory']	) {
			        			$typeIndex = $this->findKey($code_t, 'idType', $record[$x]['type']);
			        			$applierIndex = $this->findKey($applier, 'id', $record[$x]['idApplier']);
			        			$record_element .= "
								<tr>
									<td>" . $j++ . "</td>
									<td>" . $record[$x]['nthPeriod'] . "</td>
									<td>" . $record[$x]['date'] . "</td>
									<td>" . $record[$x]['hour'] . "</td>
									<td>" . $record[$x]['description'] . "</td>
									<td>" . $applier[$applierIndex]['name'] . " "	 . $applier[$applierIndex]['lastName'] . "</td>
									<td class='" . $code_t[$typeIndex]['color'] . " white-text'>" . $code_t[$typeIndex]['type'] . "</td>
								</tr>";
			        		}
						}
					}else{
						$record_element .= "
								<tr>
									<td colspan='7'>El estudiante no posee códigos en esta categoría...</td>
								</tr>";
					}
					$record_element .= "
							</tbody>
						</table>";
				}

		        return $record_element;
			}
		}

		function showUser($user)
		{
			$user = (object) $user;
			// return var_dump($user);
			$aux = "
			<br>
			<div class='user-show-cont'>
				<div class='gnrl-info'>
					<div class='photo_cont'>
					<img src='../../files/profile_photos/" . $user->photo . "' class='responsive-img circle photo'>
					</div>
					<div class='info'>
					<h3><b id='userId'>" . $user->id . "</b></h3>
					<h5 class='user-type'><i>" . ($user->type == 'S' ? 'Estudiante' : ( $user->type == 'T' ? 'Docente' : 'Coordinador' )) . "</i></h5>
				</div>
				</div>
				<div class='container'>
					<div class='row'>
						<div class='user-data'>
							<div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Nombre: </div>
		                        <div class='data-content col l6 m6 s12'>$user->name</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Apellido: </div>
		                        <div class='data-content col l6 m6 s12'>$user->lastName</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Contraseña: </div>
		                        <div class='data-content col l6 m6 s12'>". $this->DisarmedEncryption($user->password) ."</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Email: </div>
		                        <div class='data-content col l6 m6 s12'>$user->email</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Fecha de nacimiento: </div>
		                        <div class='data-content col l6 m6 s12'>$user->birthdate</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Sexo: </div>
		                        <div class='data-content col l6 m6 s12'>" . ($user->sex == 'F' ? 'Femenino' : 'Masculino') . "</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Residencia: </div>
		                        <div class='data-content col l6 m6 s12'>$user->residence</div>
		                    </div>";
		    if ($user->type == 'S') {
		    	$aux .= "
							<div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Grado: </div>
		                        <div class='data-content col l6 m6 s12'>" . ($user->level == 1 ? 'Primero' : ($user->level == 2 ? 'Segundo' : 'Tercero')) . "</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Sección: </div>
		                        <div class='data-content col l6 m6 s12'>\"$user->sectionIdentifier\"</div>
		                    </div>
							<div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Especialidad: </div>
		                        <div class='data-content col l6 m6 s12'>$user->sName</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Verificado: </div>
		                        <div class='data-content col l6 m6 s12 " . ($user->verified ? 'green' : 'red') . "-text'>" . ($user->verified ? 'El estudiante se encuentra verificado' : 'El estudiante no está verificado') . "</div>
		                    </div>";
		    $record_state = $this->connection->connection->query("SELECT * FROM state_academic WHERE idState = \"$user->stateAcademic\";");
		    $record_state = $record_state->fetch_object();
			$aux .= 		"<div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Conducta: </div>
		                        <div class='data-content col l6 m6 s12 " . $record_state->color . "-text'>$record_state->description</div>
		                    </div>";
		    }else{
		    	$aux .= "
							<div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Profesión: </div>
		                        <div class='data-content col l6 m6 s12'>$user->profession</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Teléfono: </div>
		                        <div class='data-content col l6 m6 s12'>$user->phone</div>
		                    </div>
		                    <div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>DUI: </div>
		                        <div class='data-content col l6 m6 s12'>$user->dui</div>
		                    </div>";
		    }
            $aux .=		"
							<div class='data-block col l10 m10 s12 offset-l1 offset-m1'>
		                        <div class='data-title col l6 m6 s12'>Estado: </div>
		                        <div class='data-content col l6 m6 s12 " . ($user->state ? 'green-text' : 'red-text') . "'>" . ($user->state ? "Activo<i class='material-icons left'>thumb_up</i>" : "De baja<i class='material-icons left'>thumb_down</i>") . "</div>
		                    </div>
            			</div>
					</div>
				</div>
			</div>";

			return $aux;
		}

		function printRecord($id)
		{
			$code_c = []; $code_t = []; //Tipos y Categorías de Códigos
			$record = []; //Registros de la tabla de Record del estudiante
			$user_info = []; //Información del estudiante que se mostrará el record
			$applier = []; //Información de los Docentes/Coordinadores que han aplicado código al estudiante
			$non_attendance = [];
			$record_element = "";

			$user_info = $this->get_user_data($id); //Se obtiene la información del estudiante

			//OBTENER CATEGORÍAS Y TIPOS DE CÓDIGOS
			$code_c_query = "SELECT * FROM code_category";
			$code_t_query = "SELECT * FROM code_type";

			$code_c_res = $this->connection->connection->query($code_c_query);
			$code_t_res = $this->connection->connection->query($code_t_query);

			if ($code_c_res->num_rows > 0 && $code_t_res->num_rows > 0) { //Sí hay registros de categorías y tipos 
				while ($code_c_row = $code_c_res->fetch_assoc()) {
					$array = [];
					foreach ($code_c_row as $key => $value) {
						$array[$key] = $value;
					}
					array_push($code_c, $array);
				}

				while ($code_t_row = $code_t_res->fetch_assoc()) {
					$array = [];

					foreach ($code_t_row as $key => $value) {
						$array[$key] = $value;
					}
					array_push($code_t, $array);
				}

				//OBTENER REGISTROS DEL RECORD DEL ESTUDIANTE
				$record_query = "SELECT * FROM code c INNER JOIN applied_code a ON c.idCode = a.idCode INNER JOIN record r ON r.idApplied_Code = a.idApplied_Code INNER JOIN period p ON p.idPeriod = a.idPeriod WHERE r.idStudent = '" . $user_info['id'] . "';";

				$record_res = $this->connection->connection->query($record_query);

				while ($row = $record_res->fetch_assoc()) {
					$array = [];
	                foreach ($row as $key => $value) {
	                    $array[$key] = $value;
	                }
	            	array_push($record, $array);
	            }

	            //OBTENER INFORMACIÓN DE LOS APLICADORES
	            for ($i=0; $i < count($record); $i++) {
	            	array_push($applier, $this->get_user_data($record[$i]['idApplier']));
	            }

	            for ($i=0; $i < count($code_c); $i++) {
	            	$code_c[$i]['cant'] = 0;
	            	for ($j=0; $j < count($record); $j++) { 
	            		if ($code_c[$i]['idCategory'] == $record[$j]['category']) {
	            			$code_c[$i]['cant'] += 1;
	            		}
	            	}
	            }

	            //OBTENER INFORMACIÓN DE LAS INASISTENCIAS
	            $non_attendanceQuery = "SELECT ae.date, rs.day, (SELECT COUNT(*) FROM justification j WHERE j.idAssistance = ae.idAssistance) AS state, s.nameSubject FROM assistance ae INNER JOIN schedule_register rs ON rs.idS_Register = ae.idSchedule INNEr JOIN subject s ON s.idSubject = rs.idSubject WHERE ae.idStudent = '$id' AND ae.attended = 0;";

	            $non_attendanceRes = $this->connection->connection->query($non_attendanceQuery);
	            $naF = ($non_attendanceRes->num_rows > 0 ? 1 : 0);


	            if ($naF) {
	            	while ($naRow = $non_attendanceRes->fetch_assoc()) {
	            		$aux = [];
	            		foreach ($naRow as $key => $value) {
	            			$aux[$key] = $value;
	            		}
	            		array_push($non_attendance, $aux);
	            	}
	            }

	            //LLENAR ELEMENTO DEL RECORD
	            $record_element .= "
	            <div class='record'>
	            	<table class='infoTable'>
						<tr>
							<td class='data' style='text-align: left;'>
								<p><span style='font-weight: bold;'>Nombre: </span>" . $user_info['name'] . " ". $user_info['lastName'] . "</p>
								<p><span style='font-weight: bold;'>Código: </span>" . $user_info['id'] . "</p>
								<p><span style='font-weight: bold;'>Grado: </span>" . $user_info['level'] . "°</p>
								<p><span style='font-weight: bold;'>Sección: </span>\"" . $user_info['sectionIdentifier'] . "\"</p>
								<p><span style='font-weight: bold;'>Especialidad: </span>" . $user_info['sName'] . "</p>
							</td>
						</tr>
		            </table>
					<div class='codes'>
						<h2 style='text-align: center;'>Control de Inasistencias</h2>
						<table class='centered'>
							<thead>
								<tr class='black'>
									<th>N°</th>
									<th>Fecha</th>
									<th>Materia</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>";
				if($naF){
					for ($i=0; $i < count($non_attendance); $i++) { 
						$record_element .= "
									<tr style='border: 1px solid #000;'>
										<td>" . ($i + 1) . "</td>
										<td>" . $non_attendance[$i]['date'] . "</td>
										<td>" . $non_attendance[$i]['nameSubject'] . "</td>
										<td class='" . ($non_attendance[$i]['state'] ? "green" : "red") . " lighten-4'>" . ($non_attendance[$i]['state'] ? "Justificada" : "Sin justificar") . "</td>
									</tr>";
					}
				}else{
					$record_element .= "<tr style='border: 1px solid #000;'><td colspan='4'>No posee inasistencias!</td></tr>";
				}
				$record_element .= "</tbody></table><br>
				<h2 style='text-align: center;'>Control de Códigos</h2>";

		        for ($i=0; $i < count($code_c); $i++) { //Recorrer categorías
		        	$record_element .= "
						<h5 class='table-title "  . $code_c[$i]['color'] .  "' style='margin-top: 2%; text-align: center; font-size: 1.2em;'>"  . $code_c[$i]['category'] .  "</h5>
						<table class='centered bordered'>
							<thead>
								<tr class='" . $code_c[$i]['color'] . "'>
									<th>N°</th>
									<th>Período</th>
									<th>Fecha</th>
									<th>Hora</th>
									<th>Código</th>
									<th>Aplicado por</th>
									<th>Tipo</th>
								</tr>
							</thead>
							<tbody>";
					if ($code_c[$i]['cant'] > 0) {
						$j = 1;
						for ($x=0; $x < count($record); $x++) { //Recorrer record
			        		if ($record[$x]['category'] == $code_c[$i]['idCategory']	) {
			        			$applierIndex = $this->findKey($applier, 'id', $record[$x]['idApplier']);
			        			$typeIndex = $this->findKey($code_t, 'idType', $record[$x]['type']);
			        			$record_element .= "
								<tr style='border: 1px solid " . $code_c[$i]['hex'] . ";'>
									<td>" . $j++ . "</td>
									<td>" . $record[$x]['nthPeriod'] . "</td>
									<td>" . $record[$x]['date'] . "</td>
									<td>" . $record[$x]['hour'] . "</td>
									<td>" . $record[$x]['description'] . "</td>
									<td>" . $applier[$applierIndex]['name'] . " "	 . $applier[$applierIndex]['lastName'] . "</td>
									<td class='" . $code_t[$typeIndex]['color'] . " white-text'>" . $code_t[$typeIndex]['type'] . "</td>
								</tr>";
			        		}
						}
					}else{
						$record_element .= "
								<tr style='border: 1px solid " . $code_c[$i]['hex'] . ";'>
									<td colspan='7'>El estudiante no posee códigos en esta categoría...</td>
								<tr>";
					}
					$record_element .= "
							</tbody>
						</table>";
				}

		        return $record_element;
			}	
		}

		function printUser($user)
		{
			$aux = "
			<table class='user-show-cont'>
				<thead>
					<tr class='gnrl-info'>
						<th class='photo_cont'>
						<img src='../../../app/users/files/profile_photos/" . $user['photo'] . "' class='photo'>
						</th>
						<th class='info'>
						<h1><b>" . $user['id'] . "</b></h1>
						<h2><i>" . ($user['type'] == 'S' ? 'Estudiante' : ( $user['type'] == 'T' ? 'Docente' : 'Coordinador' )) . "</i></h2>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr class='data-block'>
	                    <td class='data-title'>Nombre: </td>
	                    <td class='data-content'>" . $user['name'] . "</td>
	                </tr>
	                <tr class='data-block'>
	                    <td class='data-title'>Apellido: </td>
	                    <td class='data-content'>" . $user['lastName'] . "</td>
	                </tr>
	                <tr class='data-block'>
	                    <td class='data-title'>Contraseña: </td>
	                    <td class='data-content'>". $this->DisarmedEncryption($user['password']) ."</td>
	                </tr>
	                <tr class='data-block'>
	                    <td class='data-title'>Email: </td>
	                    <td class='data-content'>" . $user['email'] . "</td>
	                </tr>
	                <tr class='data-block'>
	                    <td class='data-title'>Fecha de nacimiento: </td>
	                    <td class='data-content'>" . $user['birthdate'] . "</td>
	                </tr>
	                <tr class='data-block'>
	                    <td class='data-title'>Sexo: </td>
	                    <td class='data-content'>" . ($user['sex'] == 'F' ? 'Femenino' : 'Masculino') . "</td>
	                </tr>
	                <tr class='data-block'>
	                    <td class='data-title'>Residencia: </td>
	                    <td class='data-content'>" . $user['residence'] . "</td>
                    </tr>";
		    if ($user['type'] == 'S') {
		    	$aux .= "
					<tr class='data-block'>
                        <td class='data-title'>Grado: </td>
                        <td class='data-content'>" . ($user['level'] == 1 ? 'Primero' : ($user['level'] == 2 ? 'Segundo' : 'Tercero')) . "</td>
                    </tr>
                    <tr class='data-block'>
                        <td class='data-title'>Sección: </td>
                        <td class='data-content'>\"" . $user['sectionIdentifier'] . "\"</td>
                    </tr>
					<tr class='data-block'>
                        <td class='data-title'>Especialidad: </td>
                        <td class='data-content'>" . $user['sName'] . "</td>
                    </tr>
                    <tr class='data-block'>
                        <td class='data-title'>Verificado: </td>
                        <td class='data-content " . ($user['verified'] ? 'green' : 'red') . "-text'>" . ($user['verified'] ? 'El estudiante se encuentra verificado' : 'El estudiante no está verificado') . "</td>
                    </tr>";
		    $record_state = $this->connection->connection->query("SELECT * FROM state_academic WHERE idState = '" . $user['stateAcademic'] . "';");
		    $record_state = $record_state->fetch_object();
			$aux .= 		
					"<tr class='data-block'>
                        <td class='data-title'>Conducta: </td>
                        <td class='data-content " . $record_state->color . "-text'>$record_state->description</td>
                    </tr>";
		    }else{
		    	$aux .= "
					<tr class='data-block'>
                        <td class='data-title'>Profesión: </td>
                        <td class='data-content'>" . $user['profession'] . "</td>
                    </tr>
                    <tr class='data-block'>
                        <td class='data-title'>Teléfono: </td>
                        <td class='data-content'>" . $user['phone'] . "</td>
                    </tr>
                    <tr class='data-block'>
                        <td class='data-title'>DUI: </td>
                        <td class='data-content'>" . $user['dui'] . "</td>
                    </tr>";
		    }
            $aux .=		"
					<tr class='data-block'>
                        <td class='data-title'>Estado: </td>
                        <td class='data-content " . ( $user['state'] ? 'green-text' : 'red-text') . "'>" . ( $user['state'] ? "Activo" : "De baja") . "</td>
                    </tr>
				</tbody>
			</table>";
			return $aux;
		}

		function getLvls()
		{
			$aux = "";
			$query = "SELECT * FROM level";
			$res = $this->connection->connection->query($query);

			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$aux .= "
						<option value='" . $row['idLevel'] . "'>" . $row['level'] . "° Año</option>
					";
				}
				return $aux;
			}else{
				return -1;
			}


		}

		function getSpecialties($lvl)
		{
			$aux = "";
			$query = "SELECT sy.idSpecialty, sy.sName FROM specialty sy
			INNER JOIN section sn ON sy.idSpecialty = sn.idSpecialty
			WHERE sn.idLevel = $lvl
			GROUP BY sy.sName";
			$res = $this->connection->connection->query($query);

			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$aux .= "
						<option value='" . $row['idSpecialty'] . "'>" . $row['sName'] . "</option>
					";
				}
				return $aux;
			}else{
				return -1;
			}
		}

		function getSections($specialty)
		{
			$aux = "";
			$query = "SELECT sn.idSection, sn.sectionIdentifier FROM specialty sy
			INNER JOIN section sn ON sy.idSpecialty = sn.idSpecialty
			WHERE sn.idSpecialty = $specialty";
			$res = $this->connection->connection->query($query);

			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$aux .= "
						<option value='" . $row['idSection'] . "'>\"" . $row['sectionIdentifier'] . "\"</option>
					";
				}
				return $aux;
			}else{
				return -1;
			}
		}

		function getSubjects($id)
		{
			$aux = "<div class='container'><table class='centered bordered'><thead><tr><th>Nombre</th><th>Acrónimo</th><th>Descripción</th></tr></thead><tbody>";
			$query = "SELECT * FROM teacher t INNER JOIN subject s ON t.idTeacher = s.idTeacher WHERE t.idTeacher = '$id' AND state = 1";

			// return $query;

			$res = $this->connection->connection->query($query);

			if ($res->num_rows == 0) {
				return -1;
			}else{
				while ($row = $res->fetch_assoc()) {
					$aux .= "
					<tr>
						<td>" . $row['nameSubject'] . "</td>
						<td>" . $row['acronym'] . "</td>
						<td>" . $row['description'] . "</td>
					</tr>";
				}

				$aux .= "</tbody></table></div>";

				return $aux;
			}
		}

		function getStudentCodes($id, $periods)
		{
			$aux = "";
			for($p = 0; $p < count($periods); $p++){
				$aux .= "<h4 class='center'>Período ".$periods[$p][1]."</h4>";
				$z = 0;

				$codes = $this->getCodeRules($id, $periods[$p][0]);
				$recordQuery = "SELECT * FROM record r INNER JOIN applied_code ac ON r.idApplied_Code = ac.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode INNER JOIN code_type ct ON ct.idType = c.type WHERE r.idStudent = '$id' AND ac.idPeriod = '".$periods[$p][0]."' ORDER BY r.idRecord";
				$recordRes = $this->connection->connection->query($recordQuery);
	
				if ($recordRes->num_rows == 0) {
					$aux .= "<div class='alert_'>El estudiante no posee aplicación de códigos...</div>";
				}else{
					$aux .= "<table class='centered responsive-table'>
					<thead>
						<tr>
							<th>N°</th>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Código</th>
							<th>Selección</th>
							<th>Tipo</th>
						</tr>
					</thead>
					<tbody class='tblRmvCode'>";
					while ($recordRow = $recordRes->fetch_object()) {
						$disabled = '';
						for($i = 0; $i < count($codes); $i++ ){
							if($codes[$i]['idSec']  == $recordRow->idRecord){
								$disabled = 'disabled';	
								$sk_accumulation = '';
								break;
							}
						}
		
						$aux .= "
						<tr>
							<td>".++$z."</td>
							<td>$recordRow->date</td>
							<td>$recordRow->hour</td>
							<td>$recordRow->description</td>
							<td>
								<input type='checkbox' $disabled  class='filled-in checkRmvCode' id='check$recordRow->idRecord' idRecord='$recordRow->idRecord'/>
								<label for='check$recordRow->idRecord'></label>
							</td>
							<td>$recordRow->type</td>
						</tr>";	
					}
					$aux .= "</tbody></table>";
				}
			}
			return $aux;
		}

		function getCodeRules($id, $idPeriod){
			$codes = array();
			$codes_L = array();
			$codes_G = array();
			$codes_y = array();

			$i = 0; #Códigos GRAVES
			$x = 0;	#Códigos TODOS
			$z = 0; #Códigos LEVES
			$a = 0; #Códigos a devolver
			$recordQuery = "SELECT * FROM record r INNER JOIN applied_code ac ON r.idApplied_Code = ac.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idStudent = '$id' AND ac.idPeriod = '$idPeriod' ORDER BY r.idRecord";
			$recordRes = $this->connection->connection->query($recordQuery);

			if($recordRes->num_rows > 0){
				while($recordRow = $recordRes->fetch_object()){
					if($recordRow->type == 'L'){#Se almacenan los códigos leves
						$codes_L[$z] = $recordRow->idRecord;
						$z++;
					}
	
					if($recordRow->type == 'G'){#2 Graves =  Muy Grave
						$codes_G[$i] = $recordRow->idRecord;
						$i++;

						if(count($codes_L) == 6){ #2 Códigos Graves
							for($y = 0; $y < count($codes_L); $y++){
								$codes[$x] = [
									"idPK" => $recordRow->idRecord,
									"idSec" =>  $codes_L[$y]
								];
								$x++;
							}
							$z = 0;
						}
					}
	
					if($recordRow->type == 'MG'){#Todos antes de él =  disabled
						if(count($codes_G) == 2){
							for($y = 0; $y < count($codes_G); $y++){
								$codes[$x] = [
									"idPK" => $recordRow->idRecord,
									"idSec" =>  $codes_G[$y]
								];
								$x++;
							}
							$i = 0;
						}
					}
				}
			}
			return $codes;
		}

		function removeCode($ids)
		{
			$codes = array();
			$x = 0;
			for ($i=0; $i < count($ids); $i++) {

				/*$infoCode = $this->getInfoCode($ids[$i]);  #Obtenemos Información del código a eliminar
				$equivalence = $this->EquivalenceInfoCode($infoCode['type']);

				if($equivalence != false){#Si se encontraron equivalencias en la tabla General

					if($infoCode['type'] == 'MG'){#Si el Código es Muy Grave
						if($infoCode['accumulation_code'] == '1'){
							$codes[$x] = $this->CodeGrave($ids[$i], $infoCode['period'], $equivalence['c_ref'], $equivalence['c_code'], $equivalence['t_result'], $infoCode['idStudent']);

							$infoCode = $this->getInfoCode($codes[$x]);
							if($codes[$x] != false && $infoCode['accumulation_code'] == '1'){#En busca de códgio Leve
								//if($codes[$x]['accumulation_code'] == '1'){
									$infoCode = $this->getInfoCode($codes[$x]);
									$equivalence = $this->EquivalenceInfoCode($infoCode['type']);
		
									if($equivalence != false){
										$x++;
										$codes[$x] = $this->CodeLevel($codes[$x-1], $infoCode['period'], $equivalence['c_ref'], $equivalence['c_code'], $equivalence['t_result'], $infoCode['idStudent']);
									}
								//}
							}
						}
					}elseif($infoCode['type'] == 'G'){// && $infoCode['accumulation_code'] == '1'
						$codes[$x] = $this->CodeLevel($ids[$i], $infoCode['period'], $equivalence['c_ref'], $equivalence['c_code'], $equivalence['t_result'], $infoCode['idStudent']);
					}

					for($y = 0; $y < count($codes); $y++){
						$rmv_child = "DELETE FROM record WHERE idRecord = $codes[$y]";
						$this->connection->connection->query($rmv_child);
					}
				}
				$suspended = $this->InfoSuspended($ids[$i]);
				$this->stateSuspended($suspended['idSuspended'], $suspended['student'], $suspended['StateSuspended']); */
				
				$rmvQuery = "DELETE FROM record WHERE idRecord = $ids[$i]";
				
				if ($this->connection->connection->query($rmvQuery)){
					$this->verifyStateAcademic($infoCode['idStudent']);
				}else{
					return 0;
				}
			}
			
			return 1;
		}

		function InfoSuspended($id){
			#Obtenemos datos del código aplicado
			$query = "SELECT S.state, S.idSuspended, S.StartDate, S.EndDate, r.idStudent, apc.date, apc.idPeriod, apc.idApplied_Code, c.type  FROM record r INNER JOIN applied_code apc ON apc.idApplied_Code = r.idApplied_Code INNER JOIN suspended S ON S.idApplied_Code = apc.idApplied_Code INNER JOIN code c ON c.idCode = apc.idCode WHERE r.idRecord = $id";
			$result = $this->connection->connection->query($query);
			
			if($result->num_rows > 0){
				$fila = $result->fetch_object();
				// echo "<script>alert('$fila->idSuspended')</script>";
				return (array("idSuspended" => $fila->idSuspended, "StateSuspended" => $fila->state, "student"=>$fila->idStudent));
			}
			return false;
		}

		function stateSuspended($idSuspended, $idStudent, $state){
			// echo "<script>alert('$idSuspended')</script>";
			// if($state == 1){
			// 	$query_update = "UPDATE student SET stateAcademic = 'A' WHERE idStudent = '$idStudent' ";
			// 	$result_update = $this->connection->connection->query($query_update);
				
				$query_delete = "DELETE FROM suspended WHERE idStudent = '$idStudent' AND idSuspended = $idSuspended";
				$result_delete = $this->connection->connection->query($query_delete);

				if($result_delete){return 1;}
			// }else{
			// 	$query = "DELETE FROM suspended WHERE idStudent = '$idStudent' AND idSuspended = $idSuspended";
			// 	return ($this->connection->connection->query($query));
			// }
		}

		function CodeGrave($id, $idPeriod, $reference, $cant, $t_result, $idStudent){ #Se obtiene ID del código Grave a eliminar
			$query_reference = "SELECT r.idRecord, r.accumulation_code, c.type FROM `record` r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idRecord < $id AND r.idStudent = '$idStudent' AND  ac.idPeriod = $idPeriod ORDER BY r.idRecord";
			$result_reference = $this->connection->connection->query($query_reference);
			$id_R = 0;
			$z = 0;

			if($result_reference->num_rows > 0){
				$valid = true;
				#if($result_reference->num_rows > 0){
					while($fila = $result_reference->fetch_assoc()){
						if($fila['type'] == $reference){
							$z++; 
							$valid = true;
						}
						if(($fila['type'] != $reference)) {
							// if($fila['type'] == 'MG'){$valid = false;}
							// if($fila['type'] != 'MG' && $fila['accumulation_code'] == 1){
								$valid = false;
								if($z == $cant){
									$z = 0;
									$valid = true;
								}
							//}
						}
						$id_R = $fila['idRecord'];
					}
					if(($valid) && ($z == $cant)){return ($id_R);}
				#}
			}

			return false;
		}

		function CodeLevel($id, $idPeriod, $reference, $cant, $t_result, $idStudent){#Se obtiene el ID del código Leve a eliminar
			$query_reference = "SELECT r.idRecord, r.accumulation_code, c.type FROM `record` r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idRecord < $id AND r.idStudent = '$idStudent' AND ac.idPeriod = $idPeriod ORDER BY r.idRecord";
			$result_reference = $this->connection->connection->query($query_reference);
			
			//if($result_reference->num_rows > 0){
				$valid = true;
				$z = 0;
				$id_R = 0;
				if($result_reference->num_rows > 0){
					while($fila = $result_reference->fetch_assoc()){
						if($fila['type'] == $reference){$z++;}
						if(($fila['type'] != $reference)) {
							// if($fila['type'] == 'MG'){$valid = false;}
							// if($fila['type'] != 'MG' && $fila['accumulation_code'] == 1){
								$valid = false;
								if($z == $cant){
									$z = 0;
									$valid = true;
								}
							//}
						}
						$id_R = $fila['idRecord'];
					}
					if(($valid) && ($z == $cant)){return ($id_R);}
				}
			//}
			return false;
		}

		function getInfoCode($id){#Se obtiene la información de un código cualquiera
			$query = "SELECT r.accumulation_code, r.idRecord, r.idStudent, ac.idApplied_Code, ac.date, ac.idPeriod, c.idCode, c.type, c.category FROM `record` r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idRecord = $id";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			return (array("idRecord" => $fila['idRecord'],"idStudent" => $fila['idStudent'], "Applied_Code" => $fila['idApplied_Code'], "date" => $fila['date'], "period" => $fila['idPeriod'], "idCode" => $fila['idCode'], "type" => $fila['type'], "category" => $fila['category'], "accumulation_code"=>$fila['accumulation_code']));
		}

		function EquivalenceInfoCode($type){return ($this->gnrl_code->getForResult($type));}

		function verifyStateAcademic($student){
			ini_set("date.timezone", 'America/El_Salvador');
			$periodQuery = "SELECT * FROM period;";
            $periodRes = $this->connection->connection->query($periodQuery);
			
			$date = date("Y-m-d");
			while ($rowPeriod = $periodRes->fetch_assoc()) {
				if ((($rowPeriod['startDate']) <= ($date)) && (($rowPeriod['endDate']) >= ($date))) {
					$idPeriod = $rowPeriod['idPeriod'];
					break;
				}
			}

			$query = "SELECT * FROM record INNER JOIN applied_code ON applied_code.idApplied_Code = record.idApplied_Code INNER JOIN code ON code.idCode = applied_code.idCode  WHERE record.idStudent = '$student' AND applied_code.idPeriod = $idPeriod";
			$result = $this->connection->connection->query($query);
			$e = 0; //Expulsado
			$a = 0;//Excelente
			$r = 0;//Regular
			$w = 0;//Advartido


			if($result->num_rows > 0){
				while($fila = $result->fetch_assoc()){
					if($fila['type'] == 'MG'){
						$query_checkCode = "SELECT * FROM record r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN suspended S ON s.idApplied_Code = ac.idApplied_Code WHERE r.idApplied_Code = '".$fila['idApplied_Code']."'";			
						$result_checkCode = $this->connection->connection->query($query_checkCode);
						if($result_checkCode->num_rows > 0){
							$fila_checkCode = $result_checkCode->fetch_assoc();
							if($fila_checkCode['state'] == '1'){$e++;}
						}
					}elseif($fila['type'] == 'G'){
						$w++;
					}elseif($fila['type'] == 'L'){
						$r++;
					}else{
						$a++;
					}
				}

				if($e > 0){
					$query_update = "UPDATE student SET stateAcademic = 'E' WHERE idStudent = '$student'";
				}elseif($e == 0 && $w > 0){
					$query_update = "UPDATE student SET stateAcademic = 'W' WHERE idStudent = '$student'";
				}elseif($e == 0 && $w == 0 && $r >= 3){
					$query_update = "UPDATE student SET stateAcademic = 'R' WHERE idStudent = '$student'";
				}elseif($e == 0 && $w == 0 && $r == 0 && $a > 0){
					$query_update = "UPDATE student SET stateAcademic = 'A' WHERE idStudent = '$student'";
				}else{
					$query_update = "UPDATE student SET stateAcademic = 'A' WHERE idStudent = '$student'";
				}
				return ($this->connection->connection->query($query_update));
			}
		}

		// function verifySuspended($id){
		// 	$query = "SELECT * FROM record WHERE idApplied_Code = '$id'";
		// 	$result = $this->connection->connection->query($query);
		// 	if($result->num_rows == 0){
		// 		$query_S  = "SELECT * FROM suspended WHERE idApplied_Code = $id";
		// 		$result_S = $this->connection->connection->query($query_S);
		// 		if($result_S > 0){
		// 			$query_d = "DELETE FROM suspended WHERE idApplied_Code = $id";
		// 			return ($this->connection->connection->query($query_d));
		// 		} 
		// 	}
		// }

		function getMandated($id)
		{
			$aux = "";
			$query = "SELECT * FROM mandated WHERE idStudent = '$id'";
			$res = $this->connection->connection->query($query);
			if ($res->num_rows == 0) return -1;

			while ($row = $res->fetch_object()) {
				$aux .= "
					<div class='data-block col l12 m12 s12'>
	                    <div style='text-align: left;' class='data-title col l4 m4 s12'>Nombre: </div>
	                    <div class='data-content col l8 m8 s12'>$row->name $row->lastName</div>
	                </div>
	                <div class='data-block col l12 m12 s12'>
	                    <div style='text-align: left;' class='data-title col l4 m4 s12'>Relación: </div>
	                    <div class='data-content col l8 m8 s12'>$row->relation</div>
	                </div>
	                <div class='data-block col l12 m12 s12'>
	                    <div style='text-align: left;' class='data-title col l4 m4 s12'>DUI: </div>
	                    <div class='data-content col l8 m8 s12'>$row->dui</div>
	                </div>
	                <div class='data-block col l12 m12 s12'>
	                    <div style='text-align: left;' class='data-title col l4 m4 s12'>Email: </div>
	                    <div class='data-content col l8 m8 s12'>$row->email</div>
	                </div>
	                <div class='data-block col l12 m12 s12'>
	                    <div style='text-align: left;' class='data-title col l4 m4 s12'>Teléfono: </div>
	                    <div class='data-content col l8 m8 s12'>$row->phone</div>
	                </div>
				";
			}

			return $aux;
		}

		function userDown($id, $justification)
		{
			$type = ($id[0] == 'C' && is_numeric($id[1]) ? 'C' : ($id[0] == 'D' && is_numeric($id[1]) ? 'T' : 'S'));
			$table = ($type == 'C' ? 'coordinator' : ($type == 'T' ? 'teacher' : 'student'));
			$idLog = ($type == 'C' ? 'idCoor' : ($type == 'T' ? 'idTeacher' : 'idStudent'));
			ini_set("date.timezone", 'America/El_Salvador');
            $date = date("Y/m/d");

			$query = "INSERT INTO justify_down VALUES (NULL, '$id', '$type', '$justification', '$date'); UPDATE $table SET state = 0 WHERE $idLog = '$id';";
			return ($this->connection->connection->multi_query($query) ? 1 : 0);
		}

		function getAcademicStates()
		{
			$aux = "";
			$query = "SELECT * FROM state_academic";
			$res = $this->connection->connection->query($query);
			if ($res->num_rows == 0) return -1;

			while ($row = $res->fetch_object()) {
				$aux .= "<option value='$row->idState'>$row->description</option>";
			}

			return $aux;
		}

		function userUp($id)
		{
			$type = ($id[0] == 'C' && is_numeric($id[1]) ? 'C' : ($id[0] == 'D' && is_numeric($id[1]) ? 'T' : 'S'));
			$table = ($type == 'C' ? 'coordinator' : ($type == 'T' ? 'teacher' : 'student'));
			$idLog = ($type == 'C' ? 'idCoor' : ($type == 'T' ? 'idTeacher' : 'idStudent'));

			$query = "DELETE FROM justify_down WHERE idUser = '$id'; UPDATE $table SET state = 1 WHERE $idLog = '$id';";
			return ($this->connection->connection->multi_query($query) ? 1 : 0);
		}

		function specialtyArray()
		{
			$obj = [];
			$query = "SELECT sName FROM specialty;";
			$res = $this->connection->connection->query($query);

			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					array_push($obj, $row['sName']);
				}

				return json_encode($obj);
			}else{
				return -1;
			}
		}

		function registerSpecialty($name)
		{
			$query = "INSERT INTO specialty VALUES(NULL, '$name');";
			return ($this->connection->connection->query($query) ? 1 : 0);
		}

		function specialtyForDelete()
		{
			$obj = [];
			$query = "SELECT * FROM specialty sy WHERE NOT EXISTS (SELECT * FROM section s WHERE s.idSpecialty = sy.idSpecialty);";
			$res = $this->connection->connection->query($query);
			if ($res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$aux = [];
					foreach ($row as $key => $value) {
						$aux[$key] = $value;
					}
					array_push($obj, $aux);
				}

				return json_encode($obj);
			}else{
				return -1;
			}
		}

		function deleteSpecialty($data)
		{	
			$query = "";
			for ($i=0; $i < count($data); $i++) { 
				$query .= "DELETE FROM specialty WHERE idSpecialty = " . $data[$i] . "; ";
			}

			if (count($data) == 1) {
				return ($this->connection->connection->query($query) ? 1 : 0);
			}else{
				return ($this->connection->connection->multi_query($query) ? 1 : 0);
			}
		}	
	}
?>