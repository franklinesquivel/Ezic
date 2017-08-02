(()=>{
	var info_before = 0;
	var info_after = 0;

	$(document).ready(function(){
		load_page();
		$(".refresh").click(function(){
	        load_page();
	        $("main .codes_modify").empty();
	        info_after = 0;
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
				v_modifyCode: 'Si'
			}
		}).done(function(r){
			if (r != 0) {
				$("main .container.form").html(r);
				$('select').material_select();
			}else{
				$("main .container.form").html("<div class='col l8 m8 s12 offset-l2 offset-m2'><div class='alert_ red-text text-darken-4'>No se han encontrado códigos para modificar</div></div>");
			}
			loader.out();
			$("main").fadeIn("slow");
		});
	}

	function errorSelect_2(selects){
	    let z = 0; //Variable contar; obtendra cuantos select son vacios
	    $.each($(selects), function(i,value){
	        if(($(selects).eq(i).val() ==  null) || ($(selects).eq(i).val().length == 0)){
	            $("main .container.form input.select-dropdown").eq(i).addClass("error");
	            z++;
	        }else{
	            $("main .container.form input.select-dropdown").eq(i).removeClass("error");
	        }
	    });
	    return error = (z > 0) ? false : true;
	}

	function errorSelect_3(selects){
	    let z = 0; //Variable contar; obtendra cuantos select son vacios
	    $.each($(selects), function(i,value){
	        if(($(selects).eq(i).val() ==  null) || ($(selects).eq(i).val().length == 0)){
	            $("main .codes_modify input.select-dropdown").eq(i).addClass("error");
	            z++;
	        }else{
	            $("main .codes_modify input.select-dropdown").eq(i).removeClass("error");
	        }
	    });
	    return error = (z > 0) ? false : true;
	}

	$(document).on("click", ".btnSave", function(){
		if (errorSelect_2($("main .container.form select"))) {
			var loader = new Loader();
			loader.in();
			$.ajax({
				type: 'POST',
				url: '../../files/php/C_Controller.php',
				data:{
					getCodeForModify: 1,
					category: $("#selectCategory").val(),
					type: $("#selectType").val()
				}
			}).done(function(r){
				if (r != "0") {
					$('main .codes_modify').html(r);
				}else{
					$('main .codes_modify').html("<div class='container'><div class='row col l8 m8 s12 offset-l2 offset-m2'><div class='alert_ red-text text-darken-4'>No se han econtrados códigos para modificar</div></div></div>");
				}
				
				$('select').material_select();
				$('input#input_text, textarea').characterCounter();
				loader.out();
			});
		}else{
			Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
		}
	});

	$(document).on("click", ".btnModify", function(){
		if (errorSelect_3($("main .codes_modify select")) && verifyInputs($(".materialize-textarea"))) {
			info_after = Fill_array();
			if (check_info()) {
				var loader = new Loader();
				loader.in();
				$.ajax({
					type: 'POST',
					url: '../../files/php/C_Controller.php',
					data:{
						modifyCode: 1,
						object: info_after
					}
				}).done(function(r){
					if (r == "S") {
						Materialize.toast('Modificación exitosa', 3000);
						$("main .codes_modify").empty();
						load_page();
					}else{
						textarea_Error(JSON.parse(r));
						Materialize.toast('Algunos códigos ya han sido registrados', 3000);
					}
					loader.out();
				});
			}else{
				Materialize.toast('Favor, verificar que códigos modificados no sean iguales', 3000);
			}
		}else{
			Materialize.toast('Favor, no dejar campos vacíos', 3000);
		}
	});

	function Fill_array(){
		let z = 0, array = new Array();
		array.length = 0;

		for (var i = 0; i < $(".txtForm").length; i++) {
			console.log(i);
			array[z] = {
				"id":  $("blockquote").eq(z).attr("id"),
				"description": $(".txtForm").eq(i).val(),
			 	"type": $(".txtForm").eq(i+2).val(),
			 	"category": $(".txtForm").eq(i+4).val() 
			};
			z++;
			i+=4;
		}
		return (JSON.stringify(array));
	}

	function check_info(){
		let z = 0;
		for (var i = 0; i < info_after.length; i++) {
			for (var x = 0; x < info_after.length; x++) {
				if (info_after[i].id != info_after[x].id) {
					if ((info_after[i].description == info_after[x].description) 
						&& (info_after[i].type == info_after[x].type) && 
						(info_after[i].category == info_after[x].category)) {
						z++;
					}
				}
			}
		}
		return (z = (z > 0) ? false : true);
	}

	function verifyInputs(selector){
		let z = 0;
		for (var i = 0; i < $(selector).length; i++) {
			if (($(selector).eq(i).val() == '') || ($(selector).eq(i).length = 0)) {
				$(selector).eq(i).addClass("error");
				z++;
			}
		}
		return (r = (z > 0) ? false : true);
	}

	function textarea_Error(object){
		for (var i = 0; i< $("blockquote").length; i++) {
			for (var x = 0; x < object.length; x++) {
				if ($("blockquote").eq(i).attr("id") == object[x].id) {
					$("blockquote").eq(i).css("border-left", "5px solid #c0392b");
					$("h5").eq(i).css("color", "#c0392b");
				}
			}
		}
	}
})()