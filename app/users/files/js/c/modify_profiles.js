(()=>{
	var inputs = new Array();//Array que guardará la info de los inputs - bidimensional
	var info_JSON = new Array();//Array que guardara la info del json

	var loader;

	$(document).ready(function(){

		loader = new Loader();

		class Element {
	        constructor(type) {
	            this.element = document.createElement(type);
	        }

	        setClass(c){
	            this.element.setAttribute('class', c);
	        }

	        setId(c){
	            this.element.setAttribute('id', c);
	        }

	        setAttr(attr, value){
	            this.element.setAttribute(attr, value);
	        }

	        add_el(element){
	            this.element.append(element);
	        }

	        content(content){
	            this.element.innerHTML = content;
	        }

	        clearContent(){
	            this.element.innerHTML = "";
	        }
	    }

		var createInfoSubject = (nameSubject, nthPeriod, nameTeacher, CarneTeacher, lastNameTeacher) =>{
			let row, div = new Array(8), p;

			div[0] = new Element('div');
			div[0].setClass('teacher');
			div[1] = new Element('div');
			div[1].setClass('subject');

			row = new Element('div');
			row.setClass('infoSubject z-depth-1 grey lighten-5');

			div[2]= new Element('div');
			div[2].setClass('name'); 
			div[3]= new Element('div'); 
			div[3].setClass('carnet');

			div[4]= new Element('div'); 
			div[4].setClass("acronym");
			div[5]  = new Element('div');
			div[5].setClass('period');

			div[6] = new Element('div');
			div[6].content(nthPeriod+"°");
			div[6].setClass('number');
			
			
			div[2].content(nameTeacher+" "+lastNameTeacher);
			div[3].content(CarneTeacher);
			div[4].content(nameSubject);

			div[7] = new Element('div');
			div[7].setClass('letter');
			div[7].content('Período');
			div[5].add_el(div[6].element);
			div[5].add_el(div[7].element);

			div[0].add_el(div[2].element);
			div[0].add_el(div[3].element);

			div[1].add_el(div[4].element);
			div[1].add_el(div[5].element);

			row.add_el(div[0].element);
			row.add_el(div[1].element);
			return (row);
		};

		var  createFormModifyProfile = (object) =>{

			let numsProfile = 0, input_name = new Array(), txtName = new Array(), txtName_label = new Array(), input_percentage = new Array(),
			txtPercentage = new Array(), txtPercentage_label = new Array(), input_description = new Array(), description = new Array(),
			description_label = new Array(), row = new Array(), containerName = new Array(), title = new Array(), subject;

			let divInfo = createInfoSubject(object[0].subject, object[0].period, object[0].teacherName, object[0].idTeacher, object[0].teacherlastName);

			for (var i in object) {

				//Se guarda la info en un array
				info_JSON[i] = {
					"id": object[i].id,
					"name": object[i].name,
					"percentage": object[i].percentage,
					"description": object[i].description
				};

				containerName[i] = new Element('blockquote');
				containerName[i].setClass('col l6 m6 s10 offset-l3 offset-m3 offset-s1');
				title[i] = new Element('h5');
				title[i].setClass('center-align');
				title[i].content(object[i].name);
				containerName[i].add_el(title[i].element);

				//Proceso para los campos nombres
				input_name[i] = new Element('div');
				input_name[i].setClass('input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1');
				txtName[i] = new Element('input');
				txtName[i].setAttr('type', 'text');
				txtName[i].setAttr('name', 'txt_'+i);
				txtName[i].setClass('txtForm');
				txtName[i].setAttr('value', object[i].name);
				txtName[i].setId('txtName_'+i);
				txtName_label[i] = new Element('label');
				txtName_label[i].setClass('active');
	        	txtName_label[i].setAttr('for', 'txtName_' + i);
	        	txtName_label[i].content('Nombre');
	        	input_name[i].add_el(txtName[i].element);
	        	input_name[i].add_el(txtName_label[i].element);

	        	//Proceso para los campos porcenataje
	        	input_percentage[i] = new Element('div');
				input_percentage[i].setClass('input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1');
				txtPercentage[i] = new Element('input');
				txtPercentage[i].setAttr('type', 'number');
				txtPercentage[i].setAttr('min', '0');
				txtPercentage[i].setAttr('max', '100');
				txtPercentage[i].setClass('txtForm');
				txtPercentage[i].setAttr('value', object[i].percentage);
				txtPercentage[i].setId('txtPercentage_'+i);
				txtPercentage_label[i] = new Element('label');
				txtPercentage_label[i].setClass('active');
	        	txtPercentage_label[i].setAttr('for', 'txtPercentage_' + i);
	        	txtPercentage_label[i].content('Porcentaje (%)');
	        	input_percentage[i].add_el(txtPercentage[i].element);
	        	input_percentage[i].add_el(txtPercentage_label[i].element);
	        	//Proceso para los campos de descrición
	        	input_description[i] = new Element('div');
				input_description[i].setClass('input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1');
				description[i] = new Element('textarea');
				description[i].setClass('materialize-textarea txtForm');
				description[i].setAttr('data-length', 500);
				description[i].setAttr('value', object[i].description);
				description[i].setId('description_'+i);
				description[i].content(object[i].description);
				description_label[i] = new Element('label');
				description_label[i].setClass('active');
	        	description_label[i].setAttr('for', 'description_' + i);
	        	description_label[i].content('Descripción');
	        	input_description[i].add_el(description[i].element);
	        	input_description[i].add_el(description_label[i].element);

	        	//Creación y se agrega contenido a las filas
	        	row[i] = new Element('div');
				row[i].setClass('row');
				row[i].add_el(containerName[i].element);
				row[i].add_el(input_name[i].element);
				row[i].add_el(input_percentage[i].element);
				row[i].add_el(input_description[i].element);

	        	numsProfile++;
			}

			//Se crea los botanes (Cancelar y guardar) y su contenedor
			let containerButtons = new Element('div');
			containerButtons.setClass('col s12 row btn_cont');
			let BtnCancel = new Element('div');
			BtnCancel.setClass('col l2 m2 s8 offset-l3 offset-m3 offset-s2 btn waves-effect waves-light red btnCancelar');
			BtnCancel.setId("btnCancelar");
			BtnCancel.content('Cancelar');
			BtnCancel.setAttr("onclick", "Reload()");
			let iconBtnCancel = new Element('i');
			iconBtnCancel.setClass('material-icons right');
			iconBtnCancel.content('cancel');

			BtnCancel.add_el(iconBtnCancel.element);

			let BtnSave = new Element('div');
			BtnSave.setClass('col l2 m2 s8 offset-l2 offset-m2 offset-s2 btn waves-effect waves-light black btnSave');
			BtnSave.setId("btnSave");
			BtnSave.content('Guardar');
			BtnSave.setAttr("onclick", "Save()");
			let iconBtnSave = new Element('i');
			iconBtnSave.setClass('material-icons right');
			iconBtnSave.content('save');

			BtnSave.add_el(iconBtnSave.element);
			containerButtons.add_el(BtnCancel.element);
			containerButtons.add_el(BtnSave.element);

			//Creación de form, además se agrega su contenido
			let form = new Element('form');
			form.add_el(divInfo.element);
			form.setClass(".modifiedProfile");
			for (var j = 0; j < numsProfile; j++) {
				form.add_el(row[j].element);
				form.add_el(row[j].element);
				form.add_el(row[j].element);
			}
			form.add_el(containerButtons.element);
			return (form.element);//Se retorna el formulario
		};

		$(".btnModifyProfile").click(function(event){
			event.preventDefault();
			let period = $("#selectPeriod").val(), subject = $("#selectSubject").val();

			if (errorSelect($("select"))) {
				$(".result_cont .row").empty();
				loader.in();
				$.ajax({
					method: 'POST',
					url: './../../files/php/C_Controller.php',
					data:{
						chose_modifyProfile: 'Si',
						subject: subject,
						period: period
					}
				}).done(function(r){
					let object = JSON.parse(r);
					loader.out();
					if(object.length != 0){
						let form = createFormModifyProfile(object);
						$(".modifyProfile").fadeOut(600, "linear");
						setTimeout(function(){
							$(".result_cont .row").append(form);
						}, 700);
					}else{
						setTimeout(function(){
							$(".result_cont .row").html("<div class='search_error col s8 offset-s2'><span>No se han encontrado perfiles de evaluación en dicha materia y período</span</div>");
						}, 500);
					}
				});
			}else{
				Materialize.toast('Oh, oh! Favor seleccionar opciones', 3000);
			}
		});

		$("#selectTeacher").change("value", function(){
			if(validateSelect($(this).val())){
				$.ajax({
					type: 'POST',
					url: './../../files/php/C_Controller.php',
					data:{
						choose_subjectForTeacher: 1,
						teacher: $(this).val()
					}
				}).done(function(r){
					let object = JSON.parse(r);
					$("#selectSubject").empty();
					$("#selectSubject").append("<option value='' disabled selected>Elegir Materia</option>");
					if (object.length > 0) {
						for (var i in object) {
							$("#selectSubject").append("<option value='"+object[i].id+"'>"+object[i].level+"° "+object[i].name+"</option>");
							$("#selectSubject").material_select();
						}
					}
					$("#selectSubject").material_select();
				});
			}
		});
	});

	function Reload(){
		loader.in();
		$('main').fadeOut('slow');
		setTimeout(function(){
			$(".result_cont .row").empty();
		}, 300);
		$(".modifyProfile").fadeIn(400, "linear");
		$('main').fadeIn('slow');
		loader.out();
	}

	function Save(){
		let z = 0, objeto;
		for (var i = 0; i < $(".result_cont .row form .row .txtForm").length; i++) {

			inputs[z] = {
				"id": info_JSON[z].id,
				"name": $(".result_cont .row form .row .txtForm").eq(i).val(),
				"percentage": $(".result_cont .row form .row .txtForm").eq(i+1).val(),
				"description": $(".result_cont .row form .row .txtForm").eq(i+2).val()
			};

			i += 2;
			z++;
		}

		if(countPercentage(inputs)){
			if(objeto = createObject()){
				if (verifyInputs($(".txtForm"))) {
					loader.in();
					$('main').fadeOut('slow');
					$.ajax({
						method: 'POST',
						url: '../../files/php/C_Controller.php',
						data: {
							modifyProfile: 'Si',
							objectProfiles: objeto
						}
					}).done(function(r){
						if (r) {
							$("#selectPeriod").val('');
							$("#selectSubject").val('');
							$("#selectTeacher").val('');
							$("#selectPeriod").material_select();
							$("#selectSubject").material_select();
							$("#selectTeacher").material_select();
							Materialize.updateTextFields();
				            Materialize.toast('Perfil de evaluación modificado con éxito', 3000);
				            Reload();
						}else{
				            Materialize.toast('Algo ha salido mal :(', 3000);
						}
						$('main').fadeIn('slow');
						loader.out();
					});
				}else{
					Materialize.toast('Favor, no dejar campos vacíos', 3000);
				}
			}else{
				Reload();
			}
		}else{
			Materialize.toast('Oh, oh! Algunos porcentajes pueden no ser los adecuados', 3000);
		}
	}

	function createObject(){
		let z = 0, change = false, profile = new Array();

		for (var i = 0; i < inputs.length; i++) {
			if ((inputs[i].name != info_JSON[i].name) || (inputs[i].percentage != info_JSON[i].percentage) || (inputs[i].description != info_JSON[i].description)) {
				change = true;
			}

			if (change) {
				profile[z] = {"id": inputs[i].id ,"name":  inputs[i].name, "percentage": inputs[i].percentage, "description": inputs[i].description};
				change = false;
				z++;
			}
		}

		return (r = (z > 0) ? JSON.stringify(profile) : false);
	}

	function countPercentage(arrayInputs){
		let percentage = 0;
		for (var i = 0; i < arrayInputs.length; i++) {
			percentage += parseFloat(arrayInputs[i][2]);
		}
		return (r = (percentage > 100) ? false : true);
	}

	function verifyInputs(selector){
		let z = 0;
		for (var i = 0; i < $(selector).length; i++) {
			if (($(selector).eq(i).val() == '') || ($(selector).eq(i).length = 0)) {
				$(selector).eq(i).addClass("error");
				z++;
			}
		}
		return (r = (z > 0) ? false : true);
	}

})()
