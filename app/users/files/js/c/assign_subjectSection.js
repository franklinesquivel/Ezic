(()=>{
	$(document).ready(function(){
		var loader = new Loader();

		$("#selectSubject").change("value", function(){
			if((validateSelect($("#selectSubject").val()))==true){
				$.ajax({
					method: 'POST',
					url: '../../files/php/C_Controller.php',
					data: {
						assignSubject: 'Si',
						subject: $("#selectSubject").val(),
					}
				}).done(function(sectionObject){
					let object = JSON.parse(sectionObject);

					if (object.length > 0) {
						$("#selectSection").empty();
						$("#selectSection").append("<option value='' disabled selected>Elegir Secciones</option>");
						for (var i in object) {
							$("#selectSection").append("<option value="+object[i].id+">"+object[i].level+"° "+object[i].seccion+": "+object[i].nombre+"</option>");
							$("#selectSection").material_select();
						}
					}
				});
			}
		});

		$(".btnAssignSubjectSection").click(function(){
			if (errorSelect($("select"))) {
				loader.in();
				$.ajax({
					type: 'POST',
					url: '../../files/php/C_Controller.php',
					data:{
						assign_SubjectSection: "Si",
						sections: $("#selectSection").val(), //ARRAY
						subject: $("#selectSubject").val()
					}
				}).done(function(r){
					loader.out();
					if (r) {
						Materialize.updateTextFields();
						$("#selectSection").val('');
						$("#selectSection").material_select();
						$("#selectSubject").val('');
						$("#selectSubject").material_select();
						$("#selectTeacher").val('');
						$("#selectTeacher").material_select();
	                    Materialize.toast('Sección agregada con exito', 3000);
					}else{
						Materialize.toast('ERROR, favor intentarlo más tarde!');
					}
				});
			}else{
				Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
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
					$("#selectSection").empty();
					$("#selectSubject").append("<option value='' disabled selected>Elegir Materia</option>");
					$("#selectSection").append("<option value='' disabled selected>Elegir Secciones</option>");
					if (object.length > 0) {
						for (var i in object) {
							$("#selectSubject").append("<option value='"+object[i].id+"'>"+object[i].level+"° "+object[i].name+"</option>");
						}
					}
					$("#selectSubject").material_select();
					$("#selectSection").material_select();
				});
			}
		});

		$(".refresh").click(function(){
	        loader.in();
	        $("#selectSection").val('');
			$("#selectSubject").val('');
			$("#selectTeacher").val('');
			$("#selectSubject").empty();
			$("#selectSection").empty();
			$("#selectSubject").append("<option value='' disabled selected>Elegir Materia</option>");
			$("#selectSection").append("<option value='' disabled selected>Elegir Secciones</option>");
			$("#selectTeacher").material_select();
			$("#selectSubject").material_select();
			$("#selectSection").material_select();
	        loader.out();
	    });

	    $('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	});
})()
