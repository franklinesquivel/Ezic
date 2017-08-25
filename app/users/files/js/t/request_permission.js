(()=>{
	var student =  new Array(), y = 0, z = 0, k = 0, rowID = new Array(), idS = new Array(), 
	createContainer = true, id_subject = 0;

	$(document).ready(function() {
		$('.modal').modal();
		load_page();
		$('.info_btn').click(()=>{
			$('.tap-target').tapTarget('open');
		});
		$(".btnBack").click(()=>{
			load_page();
		});
		$('.btnFilters').sideNav({
			menuWidth: 250, // Default is 300
			edge: 'right', // Choose the horizontal origin
			closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
			onOpen: function(el) {  }, // A function to be called when sideNav is opened
			onClose: function(el) {  }, // A function to be called when sideNav is closed
		});
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
			y = 0;
			k = 0;
			z = 0;
			$(".btnBack").attr("disabled", true);
			$(".btnFilters").attr("disabled", true);
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

	$(document).on("change", "#selectSubject", function(){ /* Carga la lista de usuarios */
		if($(this).val() != null){
			id_subject =  $(this).val();
			let loader = new Loader();
			loader.in();
			showUsers(0);/* Ajax */
			loadSectionInSelect();/* Se cargan las secciones en el select de filtro */
			$(".btnFilters").attr("disabled", false);
			loader.out();
		}
	});

	function loadSectionInSelect(){
		$.ajax({
			type: 'POST',
			url:'../../files/php/T_Controller.php',
			data:{
				getSection: 1,
				subject: id_subject
			}
		}).done(function(r){
			$("#selectFilter").append("<option value=''disabled selected>Elegir Sección</option>");	
			$("#selectFilter").append(r);
			$("select#selectFilter").material_select();
		});
	}

	function showUsers(section){/* Función que trae todos los alumnos */	
		student.length = 0;
		y = 0;
		$.ajax({
			type: 'POST',
			url:'../../files/php/T_Controller.php',
			data:{
				getStudents_Permission: 1,
				subject: id_subject,
				section: section
			}
		}).done(function(r){
			$("main .container.list").empty();
			$("main .container.list").append(r);
		});
	}

	$(document).on('click', '#SaveStudents', function(){ /* Guarda los estudinates para ir al formulario */
		if(student.length > 0){ /* Posee Datos  */
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data:{
					getFormEmail: 1
				}
			}).done(function(r){
				$(".btnBack").attr("disabled", false);
				$(".btnFilters").attr("disabled", true);
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
				let object = JSON.parse(r);
				if(object.length > 0){
					$("#selectProfiles").empty();
					$("#selectProfiles").append("<option value='' disabled selected> Seleccionar Perfiles </option>");
					for(var i in object){
						$("#selectProfiles").append("<option value='"+ object[i].id +"'> "+ object[i].name +" ("+ object[i].percentage +"%)  </option>");
					}
					$("select#selectProfiles").material_select();
				}else{
					Materialize.toast("No se han encontrado perfiles para modificar", 3000, "red");
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
				if(errorSelect($("form.SendEmail select"))){
					let loader = new Loader();
					loader.in();
					let object = JSON.stringify(student);
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
						if(r == 0){
							loader.out();
							Materialize.toast("ERROR, algunos de los datos ya estan en un permiso aún no procesado", 3000);
						}else{
							load_page();
							Materialize.toast("Solicitud exitosa!", 3000);
						}	
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

		for (var i = 0; i < $('.list-add .modal-content .container .row .student-row .id-student').length; i++) {
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
			z = 0;
			createContainer = true;
		}
		if (createContainer) {
			rowID[k] = $('<div>',{'class': 'student-row'});
			createContainer = false;
		}
	}

	$(document).on("change", "#selectFilter", function(){
		if($(this).val() != null){
			showUsers($(this).val());/* Ajax */
		}
	});
})()