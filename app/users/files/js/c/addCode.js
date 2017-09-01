(()=>{
    $(document).ready(function(){
    	load_page();

        $(".refresh").click(function(){
            load_page();
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
    			view_addCode: 'Si'
    		}
    	}).done(function(r){
    		if (r != 0) {
    			$("main .container").html(r);
    			$('select').material_select();
    			$('input#input_text, textarea').characterCounter();
    		}
    		loader.out();
    		$("main").fadeIn("slow");
    	});
    }

    $(document).on("click", ".btnSave", function(){
    	var loader = new Loader();
    	$("form.addCode").validate({
    		rules:{
               	description:{
    				required: true,
    			}
            },
            messages:{
                description:{
    				required:'Ingrese una descripción'
    			}
            },
    		errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
            	if (errorSelect($("select"))) {
            		loader.in();
            		$.ajax({
            			type: 'POST',
    					url: '../../files/php/C_Controller.php',
    					data:{
    						add_code: 'Si',
    						description: $("#description").val(),
    						category: $("#selectCategory").val(),
    						type: $("#selectType").val()
    					}
            		}).done(function(r){
                        // alert(r);
            			if (r != 0) {
            				$("#description").val('');
            				$("#selectCategory").val('');
            				$("#selectCategory").material_select();
            				$("#selectType").val('');
            				$("#selectType").material_select();
            				Materialize.toast('Código registrado con exito', 3000);
            			}else{
            				Materialize.toast('ERROR, este código ya existe', 3000, 'red');
            			}
            			loader.out();
            		});
            	}else{
            		Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000, 'red');
            	}
            }
    	});
    });
})()