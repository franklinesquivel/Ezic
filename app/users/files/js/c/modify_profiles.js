(()=>{

	var info_profiles = new Array();
	$(document).ready(function(){
		load_page();

		$('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	    $(".btnBack").click(function(){
	        load_page();
	    });
	});

	function load_page(){
		var loader = new Loader();
		loader.in();
		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data:{
				v_modifyProfile: 1
			}
		}).done(function(r){
			$("main .container").html(r);
			$('select').material_select();
    		$('input#input_text, textarea').characterCounter();
			loader.out();
    		$("main").fadeIn("slow");
    		$("main .result_cont").html("");
    		info_profiles.length = 0;
    		$(".btnBack").attr("disabled", true);
		});
	}

	$(document).on("change", "#selectTeacher", function(){
		if ($(this).val() != null) {
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

	$(document).on("click", ".btnModifyProfile", function(){
		if (errorSelect($("select"))) {
			$.ajax({
				type:'POST',
				url:'../../files/php/C_Controller.php',
				data:{
					chose_modifyProfile: 1,
					subject: $("#selectSubject").val(),
					period: $("#selectPeriod").val()
				}
			}).done(function(r){
				$("main .result_cont").html("");
				if (r != 0) {
					$(".btnBack").attr("disabled", false);
					$("main .container").html(r);
				}else{
					$("main .result_cont").html("<div class='search_error col s8 offset-s2'><span>No hay perfiles de evaluación registrados según datos seleccionados</span></div>");
				}
			});
		}else{
			Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000, "red darken-1");
		}
	});

	$(document).on("click", ".btnSaveModify", function(event){
		event.preventDefault();
		if (validate_inputs()) {
			save_info();
			if(verify_info()){
				var loader = new Loader();
				loader.in();
				$.ajax({
					type:'POST',
					url:'../../files/php/C_Controller.php',
					data:{
						modifyProfile: 1,
						object: JSON.stringify(info_profiles)
					}
				}).done(function(r){
					console.log(r);
					if (r == 1) {
						load_page();
						Materialize.toast('Modificación exitosa', 3000);
					}else{
						Materialize.toast('Algo va mal, intentalo más tarde', 3000);
					}
					loader.out();
				});
			}else{
				Materialize.toast('Favor no repetir información', 3000);
			}
		}else{
			Materialize.toast("Favor no dejar campos vacíos", 3000, "red darken-1");
		}
	});

	const validate_inputs = () =>{ /* Verifica que no hayan campos vacíos */
		let z = 0;
		for(var i = 0; i< $(".txtForm").length; i++){
			if ($(".txtForm").eq(i).val() == "" || $(".txtForm").eq(i).val().length < 1) {
				$(".txtForm").eq(i).addClass("error");
				z++;
			}else{
				$(".txtForm").eq(i).removeClass("error");
			}
		}
		return (z = (z > 0) ? false : true);
	};

	const save_info = () =>{ /* Guarda la información */
		for (var i = 0; i < $("blockquote").length; i++) {
			info_profiles[i] = {
				"id": $("blockquote").eq(i).attr("profile_id"),
				"name": $("#name"+i).val(),
				"description": $("#description"+i).val()
			};
		}
	};

	const verify_info = () =>{ /*  Verifica que la información no se repita */
		let z = 0;
		for (var i = 0; i < info_profiles.length; i++) {
			for (var x = 0; x < info_profiles.length; x++) {
				if (info_profiles[i].id != info_profiles[x].id) {
					if (info_profiles[i].name == info_profiles[x].name &&
						info_profiles[i].description == info_profiles[x].description) {
						z++;
					}
				}
			}
		}
		return (z = (z > 0) ? false : true);
	};
})()
