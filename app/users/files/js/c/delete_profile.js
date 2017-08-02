(()=>{
	var perfil = new Array();
	var x = 0;
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

		$(".btnChoseSubject").click(function(){
			$(".result_cont .errorMessage").empty();
			if (errorSelect($("select"))) {
				$('.result_cont').fadeOut(100);
				loader.in();
				$.ajax({
					method: 'POST',
					url: './../../files/php/C_Controller.php',
					data:{
						choose_deleteProfile: 'Si',
						period: $("#selectPeriod").val(),
						subject: $("#selectSubject").val()
					}
				}).done(function(r){
					let object = JSON.parse(r), table;
					perfil.length = 0;
					$(".result_cont .row form").empty();
					if(object.length != 0){
						table = createTable(object);
						$(".result_cont .row form").prepend(table);
						setTimeout(function(){
							$(".result_cont .table_profiles").show();
						}, 500);
					}else{
						$(".result_cont .table_profiles").hide();
					    $(".result_cont .errorMessage").html("<div class='search_error col s8 offset-s2'><span>Los datos seleccionados no cuentan con perfiles de evaluación para eliminar</span</div>");
					}
					$('.result_cont').fadeIn('slow');
					loader.out();
				});
			}else{
				Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
			}
		});


		var createTable = (object) =>{
			let table, div, thead, tr = new Array(), th = new Array(3), tbody, td = new Array(), z = 0, input = new Array(), label = new Array();
			div = new Element('div');
			div.setClass('row col l8 m10 s10 offset-l2 offset-m1 offset-s1');
			table = new Element('table');
			table.setClass('centered');

			thead = new Element('thead');
			tr[z] = new Element('tr');
			th[0] = new Element('th'); th[1] = new Element('th'); th[2] = new Element('th'); th[3] = new Element('th');
			th[0].content("# Perfil"); th[1].content("Nombre"); th[2].content("Porcentaje (%)"); th[3].content("Opción");
			tr[z].add_el(th[0].element); tr[z].add_el(th[1].element); tr[z].add_el(th[2].element); tr[z].add_el(th[3].element);
			thead.add_el(tr[z].element);

			tbody = new Element('tbody');
			for(var i in object){
				z++;
				tr[z] = new Element('tr');

				td[i] = new Element('td');
				td[i].content(z);
				td[i+1] = new Element('td');
				td[i+1].content(object[i].name);
				td[i+2] = new Element('td');
				td[i+2].content(object[i].percentage);

				input[i] = new Element('input');
				input[i].setClass('btn_checkbox');
				input[i].setAttr('type', 'checkbox');
				input[i].setAttr('id', object[i].id);
				label[i] = new Element('label');
				label[i].content('Eliminar');
				label[i].setAttr("for", object[i].id);
				td[i+3] = new Element('td');
				td[i+3].add_el(input[i].element);
				td[i+3].add_el(label[i].element);


				tr[z].add_el(td[i].element);
				tr[z].add_el(td[i+1].element);
				tr[z].add_el(td[i+2].element);
				tr[z].add_el(td[i+3].element);
				tbody.add_el(tr[z].element);
			}
			table.add_el(thead.element);
			table.add_el(tbody.element);
			div.add_el(table.element);
			return (div.element);
		};

		$(".btnCancelar").click(function(){
			perfil.length = 0;

			$('.result_cont').fadeOut('slow');
			loader.in();

			setTimeout(function(){
				$(".result_cont .table_profiles").css("display", "none");
			}, 300);

			loader.out();
			// $(".result_cont .row form").empty();
		});

		$(".btnSave").click(function(){
			if (perfil.length > 0) {
				let ids = JSON.stringify(perfil);
				loader.in();
				$.ajax({
					method: 'POST',
					url: '../../files/php/C_Controller.php',
					data:{
						delete_profile: 'Si',
						profiles: ids
					}
				}).done(function(r){
					loader.out();
					if (r == "1") {
						Materialize.updateTextFields();

						setTimeout(function(){
							$(".result_cont .table_profiles").css("display", "none");
						}, 300);
						
						$("#selectPeriod").val('');
						$("#selectPeriod").material_select();
						$("#selectSubject").val('');
						$("#selectSubject").material_select();
						$("#selectTeacher").val('');
						$("#selectTeacher").material_select();
						Materialize.updateTextFields();
				        Materialize.toast('Perfil de evaluación eliminados con éxito', 3000);
					}else{
				        Materialize.toast('Algo salio mal, intentaló más tarde', 3000);
					}
				});
			}else{
				Materialize.toast('No hay perfiles seleccionados', 3000);
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

		$(".refresh").click(function(){
	        loader.in();
	        $("#selectPeriod").val('');
			$("#selectPeriod").material_select();
			$("#selectSubject").val('');
			$("#selectSubject").material_select();
			$("#selectTeacher").val('');
			$("#selectTeacher").material_select();
			$(".result_cont .table_profiles").css("display", "none");
	        loader.out();
	    });

	    $('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	});

	$(document).on("change", ".btn_checkbox", function(){
		if($(this).prop("checked")){
			perfil[x] = {"id": $(this).attr("id")};
			x++;
		}else{
			removeIndex($(this).attr("id"));
			x--;
		}
		console.log(JSON.stringify(perfil));
	});

	function removeIndex(id){
		for (var i = 0; i < perfil.length; i++) {
			if (perfil[i].id == id) {
				perfil.splice(i,1);
			}
		}
	}
})()
