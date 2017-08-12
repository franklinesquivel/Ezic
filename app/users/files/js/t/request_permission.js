(()=>{
	var student =  new Array(), y = 0, z = 0, k = 0, rowID = new Array(), idS = new Array(), 
	createContainer = true, id_subject = 0;

	$(document).ready(function() {
		$('.modal').modal();
		load_page();
	});

	function load_page(){ /* Carga inical */
		var loader = new Loader();
		loader.in();
		$.ajax({
			type: 'POST',
			url:'../../files/php/T_Controller.php',
			data:{
				v_permissionTeacher: 1
			}
		}).done(function(r){
			$("main .container.select").html(r);
			$("select").material_select();
			$("main").fadeIn("slow");
			id_subject = 0;
			student.length = 0;
			loader.out();
		});
	}

	$(document).on("change", ".btn_checkbox", function(){ /* Selección del checkbox */
		if($(this).prop("checked")){
			student[y] = {id: $(this).attr("id"), name: $(this).attr("student_name")};
			addIdContainer(student[y].id, student[y].name);
			y++;
		}else{
			removeIndex($(this).attr("id"));
		}
	});

	$(document).on("click", ".list-add .modal-content .container .row .student-row .id-student .close", function(){ /* Deselección del checkbox */
		let id = $(this).attr("id");
		for (var i = 0; i < $(".student-list .row-student .student-item .student-info .option-add input[type='checkbox']").length; i++) {
			if ($(".student-list .row-student .student-item .student-info .option-add input[type='checkbox']").eq(i).attr("id") == id) {

				$(".student-list .row-student .student-item .student-info .option-add input[type='checkbox']").eq(i).prop("checked", false);
			}
		}
		removeIndex($(this).attr("id"));
	});

	$(document).on("change", "#selectSubject", function(){ /* Caraga la lista de usuarios */
		let loader = new Loader();
		if($(this).val() != null){
			loader.in();
			$.ajax({
				type: 'POST',
				url:'../../files/php/T_Controller.php',
				data:{
					getStudents_Permission: 1,
					subject: $(this).val()
				}
			}).done(function(r){
				//$("main .container.list").fadeIn("slow", function(){
					$("main .container.list").empty();
					$("main .container.list").append(r);
				///});	
				loader.out();
			});
			id_subject =  $(this).val();
		}
	});

	$(document).on('click', '#SaveStudents', function(){ /* Guarda los estudinates para ir al formulario */
		if(student.length > 0){ /* Posee Datos  */
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data:{
					getFormEmail: 1
				}
			}).done(function(r){
				$('main .container.list').empty();
				$('main .container.select').html(r);
				$('select').material_select();
			});
		}else{ /* Esta vacío */
			Materialize.toast('No se ha seleccionado ningún alumno', 3000, 'red');
		}
	});

	$(document).on('change', '#selectPeriod', function(){ /* Carga los perfiles de evaluación seleccionados */
		if($(this).val() != null){
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data:{
					getProfiles_Permission: 1,
					period: $(this).val(),
					subject: id_subject
				}
			}).done(function(r){
				//alert(r);
				let object = JSON.parse(r);
				if(object.length > 0){
					$("#selectProfiles").empty();
					$("#selectProfiles").append("<option value='' disabled selected> Seleccionar Perfiles </option>");
					for(var i in object){
						$("#selectProfiles").append("<option value='"+ object[i].id +"'> "+ object[i].name +" ("+ object[i].percentage +"%)  </option>");
					}
					$("select#selectProfiles").material_select();
				}			
			});
		}
	});

	$(document).on('click', '.btnSendEmail', function(){ /* Envía la solicitu de petición */
		$("form.SendEmail").submit(function(e){e.preventDefault;});
		$("form.SendEmail").validate({
			rules:{
                justification:{
                    required: true
                },
            },
            messages:{
                justification:{
                    required: 'Ingrese un motivo'
                },
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
			},
			submitHandler: function(form) {
				if(errorSelect($("select"))){
					Materialize.toast("Todo bien", 3000);
					let object = JSON.stringify(student);
					console.log(object);
					$.ajax({
						type: 'POST',
						url: '../../files/php/T_Controller.php',
						data:{
							register_permission: 1,
							period: $("#selectPeriod").val(),
							subject: id_subject,
							profiles: $("#selectProfiles").val(),
							students: object,
							justification: $("#justification").val()
						}
					}).done(function(r){
						alert(r);
					});
				}else{
					Materialize.toast("Faltan campos por seleccionar", 3000, "red");
				}
			}
		});
		$("form.SendEmail").submit();
	});

	$(document).on('click', '#ViewStudents', function(){ /* Abre el modal */
		$(".modal").modal("open");
	});

	function removeIndex(id){ /* Fución que remueve a un alumno del array  */
		for (var i = 0; i < student.length; i++) {
			if (student[i].id == id) {
				student.splice(i,1);
			}
		}

		for (var i = 0; i <= $('.list-add .modal-content .container .row .student-row .id-student').length; i++) {
			if ($('.list-add .modal-content .container .row .student-row .id-student').eq(i).attr("id") == id) {
				$('.list-add .modal-content .container .row .student-row .id-student').eq(i).addClass("active");
				$('.list-add .modal-content .container .row .student-row .id-student').eq(i).fadeOut(200, function(){
					$('.list-add .modal-content .container .row .student-row .id-student').eq(i).remove()
				});	
			}
		}
		z--;
		y--;
		if(z == 0){
			$(".list-add .modal-content .container .message-error").addClass("active").fadeIn("slow");
		}
	}

	function addIdContainer(studentId, studentName){ /* Agrega al alumno al modal */
		createContainerId(z);
		$(".list-add .modal-content .container .message-error").removeClass("active");	
		idS[z] = $('<div></div>', {
			"class": "id-student",
			"title": studentName
		}).append("<span class='id'>"+studentId+"</span>");
		idS[z].append("<span class='close' id='"+studentId+"'> <i class='material-icons'>close</i> </span>");

		idS[z].attr("id", studentId);
		rowID[k].append(idS[z]);
		$('.list-add .modal-content .container .row').append(rowID[k]);
		z++;
	}

	function createContainerId(numStudents){ /* Crea un nueva fila para el modal de alumnos seleccionados */
		if (numStudents == 3) {
			k++;
			createContainer = true;
		}
		if (createContainer) {
			rowID[k] = $('<div>',{'class': 'student-row'});
			createContainer = false;
		}
	}
})()