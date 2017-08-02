(()=>{
	var subject = new Array();
	var x = 0;
	$(document).ready(function(){
		loadTable();
		$(".refresh").click(function(){
	        loadTable();
	    });

	    $('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	});

	function loadTable(){
		var loader = new Loader();
		loader.in();
		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data:{
				view_deleteSubject: 'Si'
			}
		}).done(function(r){
			if (r != 0) {
				$("main .container").html(r);
			}else{//Error
				$("main .container").html("<div class='result_cont'><div class='search_error col s8 offset-s2'><span>No hay asignaturas registradas</span</div></div>");
			}
			loader.out();
			$("main").fadeIn("slow");
		});
	}

	$(document).on("click", ".btnSave", function(){
		if (subject.length > 0) {
			objeto = JSON.stringify(subject);
			$.ajax({
				type: 'POST',
				url: '../../files/php/C_Controller.php',
				data:{
					delete_subject: 'Si',
					subjects: objeto
				}
			}).done(function(r){
				
				if (r != "0") {
					// $("main").fadeOut("slow");
					// $("main .container").empty();
					loadTable();
					Materialize.toast('Materia eliminada con exito', 3000);
				}else{
					Materialize.toast('Error, favor intentar más tarde', 3000);
				}
			});
		}
	});

	$(document).on("change", ".btn_checkbox", function(){
		if($(this).prop("checked")){
			subject[x] = {"id": $(this).attr("id")};
			x++;
		}else{
			removeIndex($(this).attr("id"));
			x--;
		}
	});

	function removeIndex(id){
		for (var i = 0; i < subject.length; i++) {
			if (subject[i].id == id) {
				subject.splice(i,1);
			}
		}
	}
})()