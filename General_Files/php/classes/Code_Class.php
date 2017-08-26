<?php 

	class Code{
		
		private $connection;
		private $aux;
		
		private $grnl_code; //Conexión a la clase de Info general de código
		private $info_gnrl; //Conexión a la clase de información general de nuestro proyecto
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
			$query_1 = "SELECT code.idCode, code.description, code_type.type, code_type.color, code_type.idType FROM `code` INNER JOIN code_type ON code_type.idtype = code.type WHERE code.category = '$category' AND code.idCode NOT IN (SELECT idCode FROM applied_code) ORDER BY code_type.type;";
			$query_2 = "SELECT code.idCode FROM code WHERE code.category = '$category' AND code.idCode IN (SELECT gnrl_code.code_result FROM gnrl_code) ORDER BY code.idCode; ";
			$result_1 = $this->connection->connection->query($query_1);
			$result_2 = $this->connection->connection->query($query_2);
			$codes_array = array();
			$i = 0;
			$valid = true;

			while($fila_1 = $result_1->fetch_assoc()){
				while($fila_2 = $result_2->fetch_assoc()){
					if($fila_1['idCode'] == $fila_2['idCode']){$valid = false;}
				}

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
    					<td>".$key['type']."</td>
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

            $periodQuery = "SELECT * FROM period;";
            $periodRes = $this->connection->connection->query($periodQuery);

            if ($periodRes->num_rows == 0) {
            	return -1;
            }else{
	            while ($rowPeriod = $periodRes->fetch_assoc()) {
	            	if ((($rowPeriod['startDate']) <= ($date)) && (($rowPeriod['endDate']) >= ($date))) {
	            		$idPeriod = $rowPeriod['idPeriod'];
	            		break;
	            	}
				}

				$queryApply = "INSERT INTO applied_code VALUES (NULL, '$hour', '$date', '$idApplier', '$type', $code, $idPeriod);";
				$valInsertApply = $this->connection->connection->query($queryApply);

				$idApplyCode = $this->connection->connection->insert_id;
				$queryRecord = "INSERT INTO record VALUES (NULL, $idApplyCode, '$student')";
				$valInsertRecord = $this->connection->connection->query($queryRecord);

				if($this->checkType($code)){
					$a_codes = $this->AccumulationCodes($student, $idPeriod);				
					if($a_codes != false){
						for($i = 0; $i < count($a_codes); $i++){
							$queryApply = "INSERT INTO applied_code VALUES (NULL, '$hour', '$date', '$idApplier', '$type', '".$a_codes[$i]."', $idPeriod);";
							$valInsertApply = $this->connection->connection->query($queryApply);
			
							$idApplyCode = $this->connection->connection->insert_id;
							$queryRecord = "INSERT INTO record VALUES (NULL, $idApplyCode, '$student')";
							$valInsertRecord = $this->connection->connection->query($queryRecord);
						}
					}
				}
			
				$this->state_expulsion($student, $idPeriod, $date);

				return (($valInsertApply && $valInsertRecord) ? 1 : 0);
            }
		}

		function state_expulsion($student, $idPeriod, $date){
			$endDate = strtotime("+ ".$this->info_gnrl->days_expulsion." days", strtotime($date));
			$endDate = date("Y-m-d", $endDate);

			$query = "SELECT * FROM record r INNER JOIN applied_code ap ON ap.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ap.idCode WHERE c.type = 'MG' AND ap.idPeriod = $idPeriod AND r.idStudent = '".$student."'";
			$result = $this->connection->connection->query($query);
			
			if($result->num_rows > 0){
				$query_suspended = "INSERT INTO suspended(idStudent, StartDate, EndDate) VALUES('$student', '$date', '$endDate')";
				$this->connection->connection->query($query_suspended);
				
				$query_state = "UPDATE student SET stateAcademic = '".$this->info_gnrl->expulsion_state."' WHERE idStudent = '$student'";
				$this->connection->connection->query($query_state);
			}
		}

		function checkType($code){
			$query = "SELECT * FROM code WHERE idCode = $code";
			$result = $this->connection->connection->query($query);
			$fila = $result->fetch_assoc();
			return ($r = ($fila['type'] == 'MG') ? 0 : 1);
		}

		function AccumulationCodes($idStudent, $idPeriod){
			$z = 0;
			$a_codes = array();
			for($i = 0; $i < count($this->gnrl_code->c_reference); $i++){
				$query = "SELECT COUNT(r.idRecord) AS n_code FROM record r INNER JOIN applied_code ap ON ap.idApplied_Code = r.idApplied_Code INNER JOIN code c ON c.idCode = ap.idCode WHERE c.type ='".$this->gnrl_code->c_reference[$i]."' AND  ap.idPeriod = $idPeriod AND r.idStudent = '".$idStudent."' ";
				$result = $this->connection->connection->query($query);
				$fila = $result->fetch_assoc();

				if($fila['n_code'] == $this->gnrl_code->c_code[$i]){
					$code = $this->gnrl_code->c_result[$i];
					$a_codes[$z] = $code;
					$z++;
				}
			}
			return ($z = ($z > 0) ? $a_codes : false);
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