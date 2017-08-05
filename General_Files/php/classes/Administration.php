<?php

	require_once('User_Class.php');
	class Administration extends Users
	{
		public $Users_Array = [];
		function __construct()
		{
			parent::__construct();
			require_once('Page_Constructor.php');
            $const = new Constructor();
            $this->aux = $const->getRoute();

            require_once($this->aux);
            $this->connection = new Connection();
            $this->connection->Connect();
		}

		function sendUsers(){
			return $this->getUsers();
		}

		function get_user_data($id){
			$user = [];
			if ($id[0] == 'C') {
				$idLog = 'idCoor'; $table = 'coordinator'; $type = 'C'; $xtra = "";
			}elseif ($id[0] == 'D') {
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
	            		<h3 class='center'>Control de Códigos</h3>
					";

		        for ($i=0; $i < count($code_c); $i++) { //Recorrer categorías
		        	$record_element .= "
		        		<br><br>
						<h5 class='table-title center "  . $code_c[$i]['color'] .  "'>"  . $code_c[$i]['category'] .  "</h5>
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

	            //LLENAR ELEMENTO DEL RECORD
	            $record_element .= "
	            <div class='record'>
	            	<table class='infoTable'>
						<tr>
							<td class='photoCell'>
								<img class='profile' src='../../../app/users/files/profile_photos/" . $user_info['photo'] . "'>
							</td>
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
	            		<h2 style='text-align: center;'>Control de Códigos</h2>
					";

		        for ($i=0; $i < count($code_c); $i++) { //Recorrer categorías
		        	$record_element .= "
						<h5 class='table-title "  . $code_c[$i]['color'] .  "' style='margin-top: 5%; text-align: center; font-size: 1.2em;'>"  . $code_c[$i]['category'] .  "</h5>
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
								<tr class=''>
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
			$query = "SELECT * FROM specialty WHERE idSpecialty = (SELECT idSpecialty FROM section sn WHERE sn.idSection = $lvl)";
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
			$query = "SELECT * FROM section WHERE idSpecialty = (SELECT s.idSpecialty FROM specialty s WHERE s.idSpecialty = $specialty);";
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

		function getStudentCodes($id)
		{
			$aux = "";
			$z = 0;
			$recordQuery = "SELECT * FROM record r INNER JOIN applied_code ac ON r.idApplied_Code = ac.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idStudent = '$id'";

			$recordRes = $this->connection->connection->query($recordQuery);

			if ($recordRes->num_rows == 0) {
				return -1;
			}

			while ($recordRow = $recordRes->fetch_object()) {
				$aux .= "
				<tr>
					<td>".++$z."</td>
					<td>$recordRow->date</td>
					<td>$recordRow->hour</td>
					<td>$recordRow->description</td>
					<td></td>
					<td>
				      <input type='checkbox' class='filled-in checkRmvCode' id='check$recordRow->idRecord' idRecord='$recordRow->idRecord'/>
				      <label for='check$recordRow->idRecord'></label>
					</td>
				</tr>";
			}

			return $aux;
		}

		function removeCode($ids)
		{
			for ($i=0; $i < count($ids); $i++) { 
				$rmvQuery = "DELETE FROM record WHERE idRecord = $ids[$i]";
				if ($this->connection->connection->query($rmvQuery) == 0) return 0;
			}

			return 1;
		}
	}
?>