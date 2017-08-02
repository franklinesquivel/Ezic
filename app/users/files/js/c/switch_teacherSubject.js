$(document).ready(function(){
	var loader = new Loader();

    $("#selectSubject").change("value", function(){
    	if (validateSelect($(this).val())) {
    		$.ajax({
    			type:'POST',
    			url: './../../files/php/C_Controller.php',
    			data:{
    				getTeacherForChangeSubject: 'Si',
    				subject: $(this).val()
    			}
    		}).done(function(r){
    			let objeto = JSON.parse(r);
    			$("#selectTeacherNew").empty();
    			$("#selectTeacherNew").append("<option value=''disabled selected>Elegir profesor</option>");
    			for(var i in objeto){
    				$("#selectTeacherNew").append("<option value="+objeto[i].id+" class='circle' data-icon='../../files/profile_photos/"+objeto[i].photo+"'>  <p class='teacher_code'>"+objeto[i].id+"</p> - "+objeto[i].name+", "+objeto[i].lastName+"</option>");	
    			}
    			$("#selectTeacherNew").material_select();
    		});
    	}
    });

	$(".btnSwitchTeacher").click(function(){
		if (errorSelect($("select"))) {
			loader.in();
			$.ajax({
			method: 'POST',
			url: './../../files/php/C_Controller.php',
			data:{
				replace_teacher: 'Si',
				subject: $("#selectSubject").val(),
				newTeacher: $("#selectTeacherNew").val()
			}
			}).done(function(r){
				loader.out();
				if (r=='1') {
                    $("#selectSubject").val('');
                    $("#selectSubject").material_select();
                    $("#selectTeacher").val('');
                    $("#selectTeacher").material_select();
                    $("#selectTeacherNew").val('');
                    $("#selectTeacherNew").material_select();
					Materialize.updateTextFields();
                	Materialize.toast('Cambio realizado con exito', 3000);
				}else{
                	Materialize.toast('Algo salio mal, intentalo más tarde', 3000);
				}
			});
		}else{
			Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
		}
	});

	$("#selectTeacher").change("value", function(){
		if(validateSelect($(this).val())){
			let value = $(this).val();
			$.ajax({
				type: 'POST',
				url: './../../files/php/C_Controller.php',
				data:{
					choose_subjectForTeacher: 1,
					teacher: value
				}
			}).done(function(r){
				let object = JSON.parse(r);
				$("#selectSubject").empty();
				$("#selectSection").empty();
				$("#selectSubject").append("<option value='' disabled selected>Elegir Materia</option>");
				$("#selectSection").append("<option value='' disabled selected>Elegir Secciones</option>");
				if (object.length > 0) {
					for (var i in object) {
						$("#selectSubject").append("<option value='"+object[i].id+"'>"+object[i].level+"° "+object[i].name+"</option>");
						// $("#selectSubject").material_select();
					}
				}
				//removeTeacher(value);
				$("#selectSubject").material_select();
				$("#selectSection").material_select();
				
			});
		}
	});

	$(".refresh").click(function(){
        loader.in();
        $("#selectSubject").empty();
		$("#selectSection").empty();
		$("#selectSubject").append("<option value='' disabled selected>Elegir Materia</option>");
		$("#selectSection").append("<option value='' disabled selected>Elegir Secciones</option>");
        $("#selectSubject").val('');
        $("#selectSubject").material_select();
        $("#selectTeacher").val('');
        $("#selectTeacher").material_select();
        $("#selectTeacherNew").val('');
        $("#selectTeacherNew").material_select();
        loader.out();
    });

    $('.info_btn').click(function(){
        $('.tap-target').tapTarget('open');
    });
});
