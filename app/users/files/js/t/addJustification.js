(()=>{

	var info_profiles = new Array();
	$(document).ready(function() {
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
			type:'POST',
			url:'../../files/php/T_Controller.php',
			data:{
				v_justification: 1
			}
		}).done(function(r){
			$("main .container.form").html(r);
			$("select").material_select();
			$("main").fadeIn("slow");
			$(".btnBack").attr("disabled", true);
			info_profiles.length = 0;
			loader.out();
		});
	}

	$(document).on("change", "#selectPeriod", function(){
		if ($(this).val() !=  null) {
			var loader = new Loader();
			loader.in();
			$.ajax({
				type:'POST',
				url:'../../files/php/T_Controller.php',
				data:{
					table_Justification: 1,
					period: $(this).val()
				}
			}).done(function(r){
				$("main .result.container").html(r);
				loader.out();
			});
		}
	});

	$(document).on("click", ".btnProfiles", function(){
		var loader = new Loader();
		loader.in();
		$("main .result.container").empty();
		$.ajax({
			type:'POST',
			url:'../../files/php/T_Controller.php',
			data:{
				getProfiles_Justification: 1,
				subject: $(this).attr("id")
			}
		}).done(function(r){
			$(".btnBack").attr("disabled", false);
			$("main .container.form").html(r);
			loader.out();
		});
	});

	$(document).on("click", ".SaveJustification", function(){
		if (validate_inputs()) {
			save_info();
			if (verify_info()) {
				$.ajax({
					type:'POST',
					url:'../../files/php/T_Controller.php',
					data:{
						InsertJustification: 1,
						object: JSON.stringify(info_profiles)
					}
				}).done(function(r){
					if (r == 1) {
						Materialize.toast('Descripciones ingresada exitosamente', 3000);
						load_page();
					}else{
						Materialize.toast('Ha ocurrido un problema, favor intentarlo más tarde', 3000);
					}
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
				"description": $("#description"+i).val()
			};
		}
	};

	const verify_info = () =>{ /*  Verifica que la información no se repita */
		let z = 0;
		for (var i = 0; i < info_profiles.length; i++) {
			for (var x = 0; x < info_profiles.length; x++) {
				if (info_profiles[i].id != info_profiles[x].id) {
					if (info_profiles[i].description == info_profiles[x].description) {
						z++;
					}
				}
			}
		}
		return (z = (z > 0) ? false : true);
	};
})()