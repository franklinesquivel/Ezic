(()=>{

	var id_subject = 0, id_section = 0, id_profile = 0, json_grades = new Array();

	$(document).ready(function () {
		load_page();
		$('.modal').modal();
	});

	function load_page(){
		var loader = new Loader();
		id_subject = 0;
		id_section = 0;
		id_profile = 0;
		json_grades.length = 0;
		loader.in();
		$.ajax({
			type:'POST',
			url:'../../files/php/T_Controller.php',
			data:{
				getViewAddGrade: 1
			}
		}).done(function(r){
			$("main .container").html(r);
			$('.dropdown-button').dropdown();
			$("main").fadeIn("slow");
			loader.out();
		});
	}

	$(document).on("click", ".db-section", function(){
		id_subject = $(this).attr("id");
	});

	$(document).on("click", ".select-section", function(){
		
		id_section = $(this).attr("id");

		if (id_section !=0 && id_subject != 0) {
			$.ajax({
				type:'POST',
				url:'../../files/php/T_Controller.php',
				data:{
					getProfiles: 1,
					subject: id_subject,
					section: id_section
				}
			}).done(function(r){
				$("#modal1 .modal-content").html(r);
				$('#modal1').modal('open');
			});
		}
	});

	$(document).on("click", ".select-profile", function(){
		id_profile = $(this).attr("id");

		if (id_section !=0 && id_subject != 0 && id_section != 0) {
			$.ajax({
				type: 'POST',
				url: '../../files/php/T_Controller.php',
				data:{
					getListStudents: 1,
					section: id_section,
					subject: id_subject,
					profile: id_profile
				}
			}).done(function(r){

				$("main .container").html(r);
				$('#modal1').modal('close');
			});
		}
	});

	$(document).on("click", "#btnSaveGrades", function(){
		let loader  = new Loader();
		if(validate_inputs()){
			loader.in();
			let object = SaveGrade();
			$.ajax({
				type:'POST',
				url:'../../files/php/T_Controller.php',
				data:{
					SaveGrades: 1,
					grades: object,
					profile: id_profile,
					subject: id_subject
				}
			}).done(function(r){
				if (r == 1) {
					Materialize.toast("Notas ingresadas con exito!", 3000);
					load_page();
				}else{
					Materialize.toast("MAL", 3000);
					loder.out();
				}
			});
		}else{
			Materialize.toast("Favor, ingresar datos validos", 3000);
		}
	});

	const validate_inputs = () =>{
		let z = 0;
		for (var i = 0; i < $("tbody tr").length; i++) {
			if ($("tbody input[type=number]").eq(i).val() == "" || 
				(parseFloat($("tbody input[type=number]").eq(i).val()) > 10 )|| 
				(parseFloat($("tbody input[type=number]").eq(i).val()) < 0 )) {
				console.log("error");
				$("tbody input[type=number]").eq(i).addClass("error");
				z++;
			}else{
				$("tbody input[type=number]").eq(i).removeClass("error");
			}
		}
		return (z = (z > 0) ? false : true);
	};

	const SaveGrade = () =>{
		for (var i = 0; i < $("tbody input[type=number]").length; i++) {
			json_grades[i] = {
				"idStudent": $("tbody input[type=number]").eq(i).attr("id"),
				"Grade": parseFloat($("tbody input[type=number]").eq(i).val())
			};
		}
		return JSON.stringify(json_grades);
	};
})()