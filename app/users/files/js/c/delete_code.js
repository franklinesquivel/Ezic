(()=>{
	var codes = new Array();
	var x = 0;
	$(document).ready(function(){
		load_page();
		$(".refresh").click(function(){
	        load_page();
	        $("main .container.table").empty();
	        remove_li_btnfloating();
	        codes.length = 0;
	        x = 0;
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
				v_deleteCode: 'Si'
			}
		}).done(function(r){
			if (r != 0) {
				$("main .container.form").html(r);
				$('select').material_select();
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
				getCodeForCategory: 1,
				category: $(this).val()
			}
		}).done(function(r){
			if (r != "0") {
				$("main .container.table").html(r);
				remove_li_btnfloating();
				add_li_btnfloating();
			}else{
				remove_li_btnfloating();
				$("main .container.table").html("<div class='col l8 m8 s12 offset-l2 offset-m2'><div class='alert_ red-text text-darken-4'>No se han econtrados códigos para eliminar</div></div>");
			}
			loader.out();
		});
	});

	$(document).on("click", ".btnSave", function(){
		if (codes.length > 0) {
			var loader = new Loader();
			loader.in();
			objeto = JSON.stringify(codes);
			$.ajax({
				type: 'POST',
				url: '../../files/php/C_Controller.php',
				data:{
					delete_code: 'Si',
					code: objeto
				}
			}).done(function(r){
				if (r != "0") {
					load_page();
					Materialize.toast('Código eliminado con exito', 3000);
					$("main .container.table").empty();
				}else{
					Materialize.toast('Error, favor intentar más tarde', 3000);
				}
				loader.out();
			});
		}
	});

	$(document).on("change", ".btn_checkbox", function(){
		if($(this).prop("checked")){
			codes[x] = {"id": $(this).attr("id")};
			x++;
		}else{
			removeIndex($(this).attr("id"));
			x--;
		}
	});

	function removeIndex(id){
		for (var i = 0; i < codes.length; i++) {
			if (codes[i].id == id) {
				codes.splice(i,1);
			}
		}
	}

	function remove_li_btnfloating(){
		$(".btn_typeContainer ul li.btn_options").remove();
	}

	function add_li_btnfloating(){
		let anterior = 0;
		for (var i = 0; i < $("tbody tr").length; i++) {
			if ($("tbody tr").eq(i).attr("id") != anterior) {
				if ($("tbody tr").eq(i).attr("id") == "L") {
					$(".btn_typeContainer ul").append("<li title='Leve' class='btn_options' id='"+$("tbody tr").eq(i).attr("id")+"' ><a class='btn-floating yellow accent-4'>"+$("tbody tr").eq(i).attr("id")+"<i class='material-icons'>publish</i></a></li>");
				}else if($("tbody tr").eq(i).attr("id") == "G"){
					$(".btn_typeContainer ul").append("<li title='Grave' class='btn_options' id='"+$("tbody tr").eq(i).attr("id")+"' ><a class='btn-floating red lighten-2 accent-4'>"+$("tbody tr").eq(i).attr("id")+"<i class='material-icons'>publish</i></a></li>");
				}else if($("tbody tr").eq(i).attr("id") == "MG"){
					$(".btn_typeContainer ul").append("<li title='Muy Grave' class='btn_options' id='"+$("tbody tr").eq(i).attr("id")+"' ><a class='btn-floating red accent-4'>"+$("tbody tr").eq(i).attr("id")+"<i class='material-icons'>publish</i></a></li>");
				}else{
					$(".btn_typeContainer ul").append("<li title='Positivo' class='btn_options' id='"+$("tbody tr").eq(i).attr("id")+"' ><a class='btn-floating green accent-4'>"+$("tbody tr").eq(i).attr("id")+"<i class='material-icons'>publish</i></a></li>");
				}	
			}
			anterior = $("tbody tr").eq(i).attr("id");
		}
	}

	$(document).on("click", ".btn_typeContainer li", function(){
		for (var i = 0; i < $("tbody tr").length; i++) {
			if ($("tbody tr").eq(i).attr("id") == $(this).attr("id")) {
				$("tbody tr").eq(i).show();
			}else{
				$("tbody tr").eq(i).hide();
			}
		}
	});
})()