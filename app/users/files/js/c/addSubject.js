(()=>{
	$(document).ready(function(){

		var loader = new Loader();

		$("#selectLevel").change("value", function(){
			if((validateSelect($("#selectLevel").val()))==true){

				$.ajax({
					method: 'POST',
					url: '../../files/php/C_Controller.php',
					data: {
						getSections: 'Si',
						level: $("#selectLevel").val(),
					}
				}).done(function(sectionObject){
					let object = JSON.parse(sectionObject);
					$("#selectSection").empty();
					$("#selectSection").append("<option value='' disabled selected>Elegir Sección</option>");
					if (object.length > 0) {
						
						for (var i in object) {
							$("#selectSection").append("<option value="+object[i].id+">"+object[i].nombre+" - "+object[i].seccion+"</option>");
						}
					}
					$("#selectSection").material_select();
				});
			}
		});

		//Validación del formulario
		$.validator.addMethod('validation', function(value, element) {
	        return this.optional(element) || /^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ-\s]+$/g.test(value);
	    }, 'Ingrese un valor válido.');

		$("form.registerSubject").validate({
			rules:{
				name:{
					required: true,
					validation: true
				},
				acronym:{
					required: true,
					validation: true
				},
				description:{
					required: true
				}
			},
			messages:{
				name:{
					required: 'Ingrese un nombre',
					validation: 'Ingrese un valor válido'
				},
				acronym:{
					required: 'Ingrese un acrónimo para la materia',
					validation: 'Ingrese un valor válido'
				},
				description:{
					required: 'Ingres una descrición'
				}
			},
			errorElement: 'div',
			errorPlacement: function(error, element){
				var placement = $(element).data('error');
	            if (placement) {
	                $(placement).append(error)
	            } else {
	                error.insertAfter(element);
	            }
			},
			submitHandler: function(form){
				if(errorSelect($("select"))){
					loader.in();
					$.ajax({
						method: 'POST',
						url: '../../files/php/C_Controller.php',
						data:{
							newSubject: "Si",
							name: $("#name").val(),
							acronym: $("#acronym").val(),
							teacher: $("#selectTeacher").val(),
							description: $("#description").val(),
							sections: $("#selectSection").val(), //ARRAY
							level: $("#selectLevel").val()
						}
					}).done(function(r){
						loader.out();
						if (r != "0") {
							$("#name").val('');
							$("#acronym").val('');
							$("#description").val('');
							$("#selectLevel").val('');
	                        $("#selectLevel").material_select();
	                        $("#selectTeacher").val('');
	                        $("#selectTeacher").material_select();
	                        $("#selectSection").val('');
	                        $("#selectSection").material_select();
							Materialize.updateTextFields();
	                        Materialize.toast('Materia registrada con exito', 3000);
						}else{
							Materialize.toast('Esta materia ya existe!');//Cambiar
						}
					});
				}else{
					Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
				}
			}
		});

		$(".refresh").click(function(){
	        loader.in();
	        $("#name").val('');
			$("#acronym").val('');
			$("#description").val('');
			$("#selectLevel").val('');
	        $("#selectLevel").material_select();
	        $("#selectTeacher").val('');
	        $("#selectTeacher").material_select();
	        $("#selectSection").empty();
			$("#selectSection").append("<option value='' disabled selected>Elegir Sección</option>");
	        $("#selectSection").val('');
	        $("#selectSection").material_select();
	        loader.out();
	    });

		$('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	});
})()
