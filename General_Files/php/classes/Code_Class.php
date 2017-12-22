<?php 

	class Code{
		
		private $connection;
		private $aux;
		
		private $grnl_code; //Conexión a la clase de Info general de código
		private $info_gnrl; //Conexión a la clase de información general de nuestro proyecto
		private $days_letter;
		function __construct(){

			require_once('Page_Constructor.php');
			$const = new Constructor();

			$this->aux = $const->getRoute();
			
			require_once($this->aux);
			$this->connection = new Connection();
			$this->connection->Connect();

			require_once('Info_Code.php');
			$this->gnrl_code = new Info_Code();
			$this->gnrl_code->setQuery(); 

			require_once('Info_Gnrl.php');
			$this->info_gnrl = new Info_Gnrl();
			$this->info_gnrl->setQuery();
			$this->days_letter = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado");
		}

		function v_addCode(){
			$form = "<form class='addCode'>
					<div class='row'>
	                    <div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
            				<textarea id='description' class='materialize-textarea' data-length='500' name='description'></textarea>
            				<label for='description'>Descripción</label>
          				</div>
	                    <div class='input-field col l3 m6 s10 offset-l3 offset-m3 offset-s1'>
	                        <select name='selectType' id='selectType'>
						      <option value='' disabled selected>Elegir tipo</option>";
						    $type = json_decode($this->getType());
						    for ($i=0; $i < count($type); $i++) { 
						    	$form .= "<option class='".$type[$i]->color."' value='".$type[$i]->id."'>".$type[$i]->name."</option>";
						    }
    						$form .= "</select>
    						<label>Tipo de Código</label>
	                    </div>
	                    <div class='input-field col l3 m6 s10 offset-m3 offset-s1'>
	                        <select name='selectCategory' id='selectCategory'>
						      <option value='' disabled selected>Elegir categoría</option>";
						    $category = json_decode($this->getCategory());
						    for ($i=0; $i < count($category); $i++) { 
						    	$form .= "<option class='".$category[$i]->color."' value='".$category[$i]->id."'>".$category[$i]->name."</option>";
						    }
    						$form .= "</select>
    						<label>Categoría de Código</label>
	                    </div>
	                </div>
	                <div class='row'>
	                	<button class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Guardar
		    	    		<i class='material-icons right'>save</i>
		    	    	</button>
	                </div>
				</form>";
			return $form;
		}

		function verifyCode($description, $type, $category){
			$query = "SELECT * FROM code WHERE description = '$description' AND type = '$type' AND category = '$category'";
			$result = $this->connection->connection->query($query);
			return ($r = ($result->num_rows > 0) ? false : true);
		}

		function newCode($description, $type, $category){
			$query = "INSERT INTO code(description, type, category) VALUES('$description', '$type', '$category')";
			return ($this->connection->connection->query($query));
		}

		function getCategory(){
			$query = "SELECT * FROM code_category";
			$result = $this->connection->connection->query($query);
			$i = 0;
			$category = array();
			while ($fila = $result->fetch_assoc()) {
				$category[$i] = [
					"name" => $fila['category'],
					"id" => $fila['idCategory'],
					"color" => $fila['color']
				];
				$i++;
			}

			return (json_encode($category));
		}

		function getType(){
			$query = "SELECT * FROM code_type";
			$result = $this->connection->connection->query($query);
			$i = 0;
			$type = array();
			while ($fila = $result->fetch_assoc()) {
				$type[$i] = [
					"name" => $fila['type'],
					"id" => $fila['idType'],
					"color" => $fila['color']
				];
				$i++;
			}

			return (json_encode($type));
		}

		function v_modifyCode(){
			$query = "SELECT * FROM code";
			$result = $this->connection->connection->query($query);

			if ($result->num_rows > 0) {
				$form = "<form class='addCode'>
					<div class='row'>
						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
	                        <select name='selectCategory' id='selectCategory'>
						      <option value='' disabled selected>Elegir categoría</option>";
						    $category = json_decode($this->getCategory());
						    for ($i=0; $i < count($category); $i++) { 
						    	$form .= "<option class='".$category[$i]->color."' value='".$category[$i]->id."'>".$category[$i]->name."</option>";
						    }
    						$form .= "</select>
    						<label>Categoría de Código</label>
	                    </div>
	                    <div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
	                        <select name='selectType' id='selectType'>
						      <option value='' disabled selected>Elegir tipo</option>";
						    $type = json_decode($this->getType());
						    for ($i=0; $i < count($type); $i++) { 
						    	$form .= "<option class='".$type[$i]->color."' value='".$type[$i]->id."'>".$type[$i]->name."</option>";
						    }
    						$form .= "</select>
    						<label>Tipo de Código</label>
	                    </div>     
	                </div>
	                <div class='row'>
	                	<div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Ver
		    	    		<i class='material-icons right'>send</i>
		    	    	</div>
	                </div>
				</form>";
			}else{
				$form = "0";
			}
			
			return $form;
		}

		function getForModify($category, $type){
			$query = "SELECT code.idCode, code.description, code.type, code.category FROM code INNER JOIN code_category ON code.category = code_category.idCategory INNER JOIN code_type ON code.type = code_type.idType WHERE code.category = '$category' AND code.type = '$type' ORDER BY code.idCode";
			$result = $this->connection->connection->query($query);
			$i = 0;
			$x = 0;
			$codes = array();

			if ($result->num_rows > 0) {
				$form = "<div class='container'>";
				while ($fila = $result->fetch_assoc()) {
					$form .= "<div class='row'>
						<blockquote class='col l6 m6 s10 offset-l3 offset-m3 offset-s1' id='".$fila['idCode']."'><h5 class='center-align'>Código N° ".($x+1)."</h5></blockquote>

						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
	          				<textarea id='description' class='materialize-textarea txtForm' data-length='500' name='description' value=''>".$fila['description']."</textarea>
            				<label for='description'  class='active'>Descripción</label>
						</div>
						<div class='input-field col l3 m6 s10 offset-l3 offset-m3 offset-s1'>
	                        <select class='txtForm' name='selectType_".$x."' id='selectType_".$x."'>";
						    $type = json_decode($this->getType());
						    for ($i=0; $i < count($type); $i++) { 
						    	if ($type[$i]->id == $fila['type']) {
						    		$form .= "<option selected value='".$type[$i]->id."'>".$type[$i]->name."</option>";
						    	}else{
						    		$form .= "<option value='".$type[$i]->id."'>".$type[$i]->name."</option>";
						    	}
						    }
    						$form .= "</select>
    						<label>Tipo de Código</label>
	                    </div>
	                    <div class='input-field col l3 m6 s10 offset-m3 offset-s1'>
	                        <select class='txtForm' name='selectCategory_".$x."'  id='selectCategory_".$x."'>";
						    $category = json_decode($this->getCategory());
						    for ($i=0; $i < count($category); $i++) { 
						    	if ($category[$i]->id == $fila['category']) {
						    		$form .= "<option selected value='".$category[$i]->id."'>".$category[$i]->name."</option>";
						    	}else{
						    		$form .= "<option value='".$category[$i]->id."'>".$category[$i]->name."</option>";
						    	}
						    }
    						$form .= "</select>
    						<label>Categoría de Código</label>
	                    </div>
					</div>";
					$i++;
					$x++;
				}
				$form .= "<div class='row'>
					<div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnModify'>Guardar
		    	    	<i class='material-icons right'>save</i>
		    	    </div>
				</div></div>";
			}else{
				$form = "0";
			}

			return $form;
		}

		function verifyCode_ForModify($description, $type, $category, $idCode){
			$query = "SELECT * FROM code WHERE description = '$description' AND type = '$type' AND category = '$category' AND idCode != '$idCode'";

			$result = $this->connection->connection->query($query);
			return ($r = ($result->num_rows > 0) ? true : false);
		}

		function modifyCode($id, $description, $type, $category){
			$query = "UPDATE code SET description = '$description', type = '$type', category = '$category' WHERE idCode = $id";
			return ($this->connection->connection->query($query));
		}

		function v_delete(){
			$query = "SELECT * FROM code";
			$result = $this->connection->connection->query($query);

			if ($result->num_rows > 0) {
				$form = "<form class='addCode'>
					<div class='row'>
						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
	                        <select name='selectCategory' id='selectCategory'>
						      <option value='' disabled selected>Elegir categoría</option>";
						    $category = json_decode($this->getCategory());
						    for ($i=0; $i < count($category); $i++) { 
						    	$form .= "<option class='".$category[$i]->color."' value='".$category[$i]->id."'>".$category[$i]->name."</option>";
						    }
    						$form .= "</select>
    						<label>Categoría de Código</label>
	                    </div>
				</form>";
			}else{
				$form = "0";
			}
			
			return $form;
		}

		function getForDelete($category){
			$query_1 = "SELECT code.idCode, code.description, code_type.type, code_type.color, code_type.idType FROM `code` INNER JOIN code_type ON code_type.idtype = code.type WHERE code.category = '$category' AND code.idCode NOT IN (SELECT idCode FROM applied_code) ORDER BY code.idCode;";
			$query_2 = "SELECT code.idCode FROM code WHERE code.category = '$category' AND code.idCode IN (SELECT gnrl_code.code_result FROM gnrl_code) ORDER BY code.idCode; ";
			$result_1 = $this->connection->connection->query($query_1);
			$result_2 = $this->connection->connection->query($query_2);
			$codes_array = array();
			$i = 0;
			$valid = true;

			while($fila_1 = $result_1->fetch_assoc()){
				while($fila_2 = $result_2->fetch_assoc()){if($fila_1['idCode'] == $fila_2['idCode']){$valid = false; break;}}

				if($valid){
					$codes_array[$i] = [
						"id" => $fila_1['idCode'],
						"description" => $fila_1['description'],
						"type" => $fila_1['type'],
						"color" => $fila_1['color'],
						"idType" => $fila_1['idType']
					];
					$i++;
				}
				$valid = true;	
			}
			
			$x = 0;
			if (count($codes_array) > 0) {
				$table = "<div class='row'><table class='col l12 m10 s12  offset-m1 offset-s0 responsive-table centered'>
				<thead>
           			<tr>
                		<th>N° de Código</th>
                		<th>Descripción</th>
                		<th>Tipo</th>
                		<th>Opción</th>
              		</tr>
            	</thead>
            	<tbody>";
				foreach($codes_array AS $key){
					$x++;
					$table .= "<tr id='".$key['idType']."'>
    					<td>".$x."</td>
    					<td>".$key['description']."</td>
    					<td class='" . $key['color'] . "' style='color: #fff;'><b>".$key['type']."</b></td>
    					<td>
          					<input type='checkbox' class='btn_checkbox' id=".$key['id']." />
          					<label for=".$key['id'].">Eliminar</label>
        				</td>
            		</tr>";
				}
				$table .= "</tbody></table></div>
				<div class='row'>
					<div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Guardar
		    	    	<i class='material-icons right'>save</i>
		    	    </div>
				</div>";
			}else{
				$table = "0";
			}
			return $table;
		}

		function delete($idCode){
			$query = "DELETE FROM code WHERE idCode = '$idCode'";
			return($this->connection->connection->query($query));
		}

		function v_tableCodes($category){
			$query = "SELECT code.description, code_type.type, code_type.color FROM `code` INNER JOIN code_type ON code.type = code_type.idType WHERE category = '$category' ORDER BY code_type.idType";
			$result = $this->connection->connection->query($query);
			$i = 0;
			$x = 0;

			$idCode = array();
			if ($result->num_rows > 0) {
				$table = "<div class='row'><table class='col l12 m10 s12  offset-m1 offset-s0 responsive-table centered'>
				<thead>
           			<tr>
                		<th>N° de Código</th>
                		<th>Descripción</th>
                		<th>Tipo</th>
              		</tr>
            	</thead>
            	<tbody>";
				while ($fila = $result->fetch_assoc()) {
					$x++;
					$table .= "<tr>
    					<td>".$x."</td>
    					<td>".$fila['description']."</td>
    					<td class='" . $fila['color'] . "' style='color: #fff;'><b>".$fila['type']."</b></td>
            		</tr>";
				}
				$table .= "</tbody></table></div>";
			}else{
				$table = "0";
			}
			return $table;
		}

		function  v_code(){
			$query = "SELECT * FROM code";
			$result = $this->connection->connection->query($query);

			if ($result->num_rows > 0) {
				$form = "<form class='addCode'>
					<div class='row'>
						<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
	                        <select name='selectCategory' id='selectCategory'>
						      <option value='' disabled selected>Elegir categoría</option>";
						    $category = json_decode($this->getCategory());
						    for ($i=0; $i < count($category); $i++) { 
						    	$form .= "<option class='".$category[$i]->color."' value='".$category[$i]->id."'>".$category[$i]->name."</option>";
						    }
    						$form .= "</select>
    						<label>Categoría de Código</label>
	                    </div>     
	                </div>
				</form>";
			}else{
				$form = "0";
			}
			
			return $form;
		}

		function getCodeCategories()
		{
			$aux = "";
			$query = "SELECT * FROM code_category";
			$res = $this->connection->connection->query($query);

			while ($row = $res->fetch_object()) {
				$aux .= "<option idCat='" . $row->idCategory . "'>" . $row->category . "</option>";
			}

			return $aux;
		}

		function getCodeTypes()
		{
			$aux = "";
			$query = "SELECT * FROM code_type";
			$res = $this->connection->connection->query($query);

			while ($row = $res->fetch_object()) {
				$aux .= "<option idType='" . $row->idType . "'>" . $row->type . "</option>";
			}

			return $aux;
		}

		function getCodes($cat, $type)
		{
			$aux = "";
			$query = "SELECT * FROM code WHERE category LIKE '" . $cat . "%' AND type LIKE '" . $type . "%' ORDER BY idCode";

			$res = $this->connection->connection->query($query);

			if ($res->num_rows > 0) {
				while ($row = $res->fetch_object()) {
					$aux .= "<option idCode='" . $row->idCode . "'>" . $row->idCode . "° - " . $row->description . "</option>";
				}

				return $aux;
			}else{
				return -1;
			}

		}

		function applyCode($code, $student, $idApplier, $type)
		{
			ini_set("date.timezone", 'America/El_Salvador');
			$hour = date("H:i");
            $date = date("Y-m-d");
			$Date1 = new DateTime($date);

            $periodQuery = "SELECT * FROM period;";
            $periodRes = $this->connection->connection->query($periodQuery);

            if ($periodRes->num_rows == 0) {
            	return -1;
            }else{
				$result = "";
				$idPeriod = -1;

	            while ($rowPeriod = $periodRes->fetch_assoc()) {
					
					$Date2 = new DateTime($rowPeriod['startDate']);
					$Date3 = new DateTime($rowPeriod['endDate']);
	            	if ((($Date2) <= ($Date1)) && (($Date3) >= ($Date1))) {
	            		$idPeriod = $rowPeriod['idPeriod'];
	            		break;
					}
				}

				if($idPeriod != -1){
					$queryApply = "INSERT INTO applied_code VALUES (NULL, '$hour', '$date', '$idApplier', '$type', $code, $idPeriod);";
					$valInsertApply = $this->connection->connection->query($queryApply);
	
					$idApplyCode = $this->connection->connection->insert_id;
					$queryRecord = "INSERT INTO record VALUES (NULL, $idApplyCode, '$student', 0)";
					$valInsertRecord = $this->connection->connection->query($queryRecord);
	
					#Acumulación de Códigos
					#$infoCode = $this->getInfoCode($student, $idPeriod);
					#$equivalence = $this->EquivalenceInfoCode($infoCode['type']);
	
					/*if(($equivalence != false) && ($infoCode['type'] != 'MG')){
						$initial = $infoCode['type'];
						$code = $this->AccumulationCodes($infoCode['idRecord'], $equivalence['c_code'], $equivalence['c_ref'], $equivalence['t_result'],  $equivalence['c_result'], $student, $idPeriod);
						if($code != false){
							$queryApply = "INSERT INTO applied_code VALUES (NULL, '$hour', '$date', '$idApplier', '$type', $code, $idPeriod);";
							$valInsertApply = $this->connection->connection->query($queryApply);
			
							$idApplyCode = $this->connection->connection->insert_id;
							$queryRecord = "INSERT INTO record VALUES (NULL, $idApplyCode, '$student', 1)";
							$valInsertRecord = $this->connection->connection->query($queryRecord);	
						
							if($initial == 'G'){
								$endDate = $this->EndSuspended($date);
								$query_suspended = "INSERT INTO suspended(idStudent, startDate, endDate, idApplied_Code, state) VALUES('$student', '$date', '$endDate' , '$idApplyCode', 1)";
								$result_suspended = $this->connection->connection->query($query_suspended);
							}
						}
						
					}else{
						if($infoCode['type'] == 'MG'){
							// $queryApply = "INSERT INTO applied_code VALUES (NULL, '$hour', '$date', '$idApplier', '$type', $code, $idPeriod);";
							// $valInsertApply = $this->connection->connection->query($queryApply);
			
							// $idApplyCode = $this->connection->connection->insert_id;
							// $queryRecord = "INSERT INTO record VALUES (NULL, $idApplyCode, '$student', 0)";
	
							$endDate = $this->EndSuspended($date);
							$query_suspended = "INSERT INTO suspended(idStudent, startDate, endDate, idApplied_Code, state) VALUES('$student', '$date', '$endDate' , '$idApplyCode', 1)";
							$result_suspended = $this->connection->connection->query($query_suspended);
						}
					}
					$this->state_expulsion($student, $idPeriod, $date, $hour, $idApplier, $type);
					$this->verifyStateAcademic($student);*/
	
					return (($valInsertApply && $valInsertRecord) ? 1 : 0);
				}
				return $idPeriod;
            }
		}

		function getInfoCode($student, $idPeriod){#Se obtiene la información de un código cualquiera
			$query_id = "SELECT MAX(idRecord) AS id FROM record r INNER JOIN applied_code ac ON ac.idApplied_code = r.idApplied_code WHERE r.idStudent = '$student' AND ac.idPeriod = $idPeriod";
			$result_id =  $this->connection->connection->query($query_id);
			$fila = $result_id->fetch_assoc();
			$id = $fila['id'];


			$query = "SELECT r.idRecord, r.idStudent, ac.idApplied_Code, ac.date, ac.idPeriod, c.idCode, c.type, c.category FROM `record` r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idRecord = $id";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();

			return (array("idRecord" => $fila['idRecord'],"idStudent" => $fila['idStudent'], "Applied_Code" => $fila['idApplied_Code'], "date" => $fila['date'], "period" => $fila['idPeriod'], "idCode" => $fila['idCode'], "type" => $fila['type'], "category" => $fila['category']));
		}

		function EquivalenceInfoCode($type){return ($this->gnrl_code->getForReference($type));}

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

		function state_expulsion($student, $idPeriod, $date, $hour, $idApplier, $type){
			$query = "SELECT c.type, r.idApplied_Code FROM record r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idStudent = '$student' AND ac.idPeriod = $idPeriod ORDER BY r.idRecord";
			$result = $this->connection->connection->query($query);
			$z = 0;
			$id_MG = 0;
			if($result->num_rows > 0){
				while($fila = $result->fetch_assoc()){
					if($fila['type'] == 'G'){
						// if($z == 2){
						// 	$z = 0;
						// }else{
							$z++;
						// }
					}
					if($fila['type'] == 'MG'){
						// $valid = true;
						$z = 0;
					}
				}
			}

			

			if($z == 2){

				for($i =0; $i < count($this->gnrl_code->c_reference); $i++){
					if($this->gnrl_code->c_reference[$i] == 'G'){
						$code = $this->gnrl_code->c_result[$i];
					}
				}

				// $valid = true;
				// $query_verifyS = "SELECT * FROM suspended WHERE idApplied_Code = $id_MG";
				// $result_verifyS = $this->connection->connection->query($query_verifyS);
				
				// if($result_verifyS->num_rows > 0){
				// 	$valid = false;
				// }else{
				// 	$valid = true;
				// }

				//if($valid){
					$queryApply = "INSERT INTO applied_code VALUES (NULL, '$hour', '$date', '$idApplier', '$type', $code, $idPeriod);";
					$valInsertApply = $this->connection->connection->query($queryApply);

					$idApplyCode = $this->connection->connection->insert_id;
					$queryRecord = "INSERT INTO record VALUES (NULL, $idApplyCode, '$student', 1)";
					$valInsertRecord = $this->connection->connection->query($queryRecord);

					$endDate = $this->EndSuspended($date);
					$query_suspended = "INSERT INTO suspended(idStudent, startDate, endDate, idApplied_Code, state) VALUES('$student', '$date', '$endDate' , '$idApplyCode', 1)";
					$result_suspended = $this->connection->connection->query($query_suspended);
				//}
			}
		}

		function AccumulationCodes($idCode, $num_rows, $c_reference, $t_result, $code_result, $idStudent, $idPeriod){
			$query = "SELECT r.accumulation_code, r.idRecord, r.idStudent, ac.idApplied_Code, ac.date, ac.idPeriod, c.idCode, c.type, c.category FROM `record` r INNER JOIN applied_code ac ON ac.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ac.idCode WHERE r.idRecord <= $idCode AND ac.idPeriod = $idPeriod AND r.idStudent ='$idStudent' ORDER BY r.idRecord";
			$result = $this->connection->connection->query($query);
			$z = 0;
			$valid = true;
			if($result->num_rows > 1){
				while($fila = $result->fetch_assoc()){
					if($fila['type'] == $c_reference){$z++;}
					if(($fila['type'] == $t_result)) {
						if($fila['type'] == 'MG'){$valid = false;}
						if($fila['type'] != 'MG' && $fila['accumulation_code'] == 1){
							$valid = false;
							if($z == $num_rows){
								$z = 0;
								$valid = true;
							}
						}
					}
					// if($z == $num_rows){break;}
				}

				if(($valid) && ($z == $num_rows)){return ($code_result);}
			}
			return false;
		}

		function EndSuspended($date){
			$endDate = strtotime("+ ".$this->info_gnrl->days_expulsion." days", strtotime($date));
			$endDate = date("Y-m-d", $endDate);

			$day = $this->days_letter[date("w", strtotime($endDate))];
			
			if($day == "Sábado"){
				$endDate = strtotime("+ ".($this->info_gnrl->days_expulsion + 2)." days", strtotime($date));
				$endDate = date("Y-m-d", $endDate);
			}elseif($day == "Domingo"){
				$endDate = strtotime("+ ".($this->info_gnrl->days_expulsion + 1)." days", strtotime($date));
				$endDate = date("Y-m-d", $endDate);
			}

			return ($endDate);
		}

		function v_gnrlCode(){
			$query =  "SELECT * FROM gnrl_code";
			$result = $this->connection->connection->query($query);
			$form = "<div class='row'><table class='centered col s10 offset-s1 responsive-table'>
				<thead>
					<tr>
					<th>Código de Referencia</th>
					<th>N° de Códigos</th>
					<th>Código Resultante</th>
					<th>Código Resultante</th>
					</tr>
				</thead>
				<tbody>
			";
			$i = 0;

			while($fila = $result->fetch_assoc()){
				$form .= "
					<tr>
						<td>".$this->getInfoType($fila['code_reference'])."</td>
						<td>".$fila['cant_code']."</td>
						<td>
							<div class='input-field s12'> 
								<select name='selectCode".$i."' id='selectCode".$i."' gnrl_id='".$fila['id_GnrlCode']."'>
									".$this->getCodesGnrl($fila['type_result'], $fila['code_result'])."
								</select>
							</div>
						</td>
						<td>".$this->getInfoType($fila['type_result'])."</td>						
					</tr>
				";
				$i++;
			}

			$form .= "</tbody></table></div>
				<div class='row'>
					<div class='col l2 m2 s4 offset-l5 offset-m5 offset-s4 btn waves-effect waves-light black darken-2 btnSave'>Guardar
						<i class='material-icons right'>save</i>
					</div>
				</div>
			";
			
			return $form;
		}

		function getInfoType($type){
			$query = "SELECT * FROM code_type WHERE idType  = '$type'";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			return ($fila['type']);
		}

		function getCodesGnrl($type, $idCodeResult){
			$query = "SELECT * FROM code WHERE type = '$type' ORDER BY idCode";
			$result = $this->connection->connection->query($query);
			$options = "";
			$valid = false;
			$i = 0;
			while($fila = $result->fetch_assoc()){
				$i++;
				if($fila['idCode'] == $idCodeResult){
					$selected = 'selected';
					$valid = true;
				}else{
					$selected = '';
				}
				$options .= "<option value='".$fila['idCode']."' $selected>".$i."° - ".$fila['description']."</option>";
			}
			if($valid){
				$option = "<option value='' disabled>Elegir Código</option> $options";
			}else{
				$option = "<option value='' selected disabled>Elegir Código</option> $options";
			}
			return $option;
		}

		function UpdateGnrl($id, $value){
			$query = "UPDATE gnrl_code SET code_result = '$value' WHERE id_GnrlCode = $id";
			return ($this->connection->connection->query($query));
		}
	}
?>