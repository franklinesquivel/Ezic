(()=>{
	$(document).ready(function(){
		load_page();
		$(".refresh").click(function(){
	        load_page();
	        $("main .container.table").empty();
	    });

	    $('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	});

	function load_page(){
		var loader = new Loader();
		loader.in();
		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data:{
				v_Code: 'Si'
			}
		}).done(function(r){
			if (r != "0") {
				$("main .container.form").html(r);
				$('select').material_select();
			}else{
				$("main .container.form").html("<div class='col l8 m8 s12 offset-l2 offset-m2'><div class='alert_ red-text text-darken-4'>No se han encontrado códigos para modificar</div></div>");
			}
			loader.out();
			$("main").fadeIn("slow");
		});
	}

	$(document).on("change", "#selectCategory", function(){
		var loader = new Loader();
		loader.in();
		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data:{
				v_Code_select: 'Si',
				category: $("#selectCategory").val()
			}
		}).done(function(r){
			if (r != "0") {
				$("main .container.table").html(r);
			}else{
				$("main .container.table").html("<div class='col l8 m8 s12 offset-l2 offset-m2'><div class='alert_ red-text text-darken-4'>No se han encontrado códigos registrados según datos selecccionados</div></div>");
			}
			loader.out();
		});
	});
})()