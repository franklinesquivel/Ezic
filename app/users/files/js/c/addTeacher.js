(() => {
	var loader, idsArray = [], photoFlag = 0;
	$(document).ready(function(){
		loader = new Loader();
		loader.in();

		$.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: {registerForm: 1, type: 'T'},
            success: r => {
                $('main').html(r);
                $.getScript("../../files/js/init.js");
            }
        })

		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {getId: 1, type: 'T'},
			success: r => {
				idsArray = JSON.parse(r);
				$("main").fadeIn("slow", loader.out());
			}
		})

		jQuery.validator.setDefaults({
			debug: true,
			success: "valid"
		});

		$.validator.addMethod('email', function(value, element) {
	        return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
	    }, 'Ingrese un valor válido.');

	    $.validator.addMethod('dui', function(value, element) {
	        return this.optional(element) || /^\d{8}-\d$/.test(value);
	    }, 'Ingrese un valor válido.');

	    $.validator.addMethod('phone', function(value, element) {
	        return this.optional(element) || /^\d{4}(-\d{4}|\d{4})$/.test(value);
	    }, 'Ingrese un valor válido.');
	})

	$(document).on('change', '.photoFile', function(){
		let pattern = /(.*?)\.(png|jpeg|jpg)$/;
        if (pattern.test($(this).val())) {
        	loader.in();
            let image_file = document.getElementById('photo-file-input');
            let img = image_file.files[0];
            let form_data = new FormData();
            form_data.append('file', img);
            form_data.append('id', 'tmp_img');
            $.ajax({
                url: '../../files/php/C_Controller.php',
                type:'POST',
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(r){
                    if ( parseInt(r) != 0 ) {
                        $('.frmPhoto').attr('src', r);
                        photoFlag = 1;
                    }else {
                        Materialize.toast('Ocurrió un error!', 2000);
                    }
                    loader.out();
                }
            })
        }else{
            $(this).val('');
            Materialize.toast('Archivo inválido!', 2000);
        }
	})

	$(document).on('click', '.frmPhoto_cont .btnModifyPhoto', function(){
        $('.photoFile').trigger('click');
    })

    $(document).on('click', '.btnSave_User', function(){
    	$('form.frmData').validate({
	        rules: {
	            txtName: 'required',
	            txtLastName: 'required',
	            txtDui: {
	            	required: 1,
	            	dui: 1
	            },
	            txtPhone: {
	            	required: 1,
	            	phone: 1
	            },
	            txtEmail: {
	                required: true,
	                email: true
	            },
	            txtRes: 'required',
	            txtDate: 'required',
	            txtProf: 'required',
	            txtSex: 'required',
	            txtProfession: 'required'
	        },
	        messages: {
	            txtName: 'Ingrese un nombre',
	            txtLastName: 'Ingrese un apellido',
	            txtDui: {
	            	required: 'Ingrese un valor',
	            	dui: 'Ingrese un valor válido'
	            },
	            txtPhone: {
	            	required: 'Ingrese un valor',
	            	phone: 'Ingrese un valor válido'
	            },
	            txtEmail: {
	                required: 'Ingrese un valor',
	                email: 'Ingrese un valor válido'
	            },
	            txtRes: 'Ingrese un valor',
	            txtDate: 'Ingrese un valor',
	            txtProf: 'Ingrese un valor',
	            txtSex: 'Seleccione un valor',
	            txtProfession: 'Ingrese un valor'
	        },
	        errorElement : 'div',
	        errorPlacement: function(error, element) {
	            var placement = $(element).data('error');
	            if (placement) {
		            	if ($(element).attr("type") == 'radio') {
			                $(placement).prepend(error);
		            	}else{
			                $(placement).append(error);
		            	}
		            } else {
		            	if ($(element).attr("type") == 'radio') {
			                error.insertBefore(element);
		            	}else{
			                error.insertAfter(element);
		            	}
		            }
	        },
	        submitHandler: function(form) {
	        	let t = $("img.frmPhoto").attr("src").split('/');
	        	t = t[t.length - 1].split('.');
	        	let data = {
	        		type: 'T',
	        		id: genId('D'),
	        		name: $("#txtName").val(),
	        		lastName: $("#txtLastName").val(),
	        		dui: $("#txtDui").val(),
	        		password: genPass(),
	        		email: $("#txtEmail").val(),
	        		birthdate: $("#txtDate").val(),
	        		sex: $("[type=radio]:checked").val(),
	        		profession: $("#txtProfession").val(),
	        		residence: $("#txtRes").val(),
	        		phone: $("#txtPhone").val(),
	        		state: 1,
	        		photo: (photoFlag ? t[t.length - 1] : 0)
	        	}

	        	loader.in();
	        	$.ajax({
	        		type: 'POST',
	        		url: '../../files/php/C_Controller.php',
	        		data: {registerUser: 1, data: JSON.stringify(data), type: 'T'},
	        		success: r => {
	        			if (r != -1) {
	        				Materialize.toast("El docente se ha registrado exitosamente!", 2000);
	        				$('main').fadeOut('slow', function(){
	        					$('main').html(r);
	        					$("input[name=id]").val(data.id);
	        					$('main').fadeIn('slow', loader.out());

	        					$(".btnPrint").removeAttr("disabled");
	        					$('.btnBack').removeAttr('disabled');
	        				});
	        			}else{
	        				Materialize.toast("Ha ocurrido un error!", 2000);
	        			}
	        		}
	        	})
	        }
	    })

	    $('.frmData').submit();
    })

    $(document).on('click', '.btnRefresh', function(){
    	loader.in();
    	$("main").fadeOut('slow');
    	$.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: {registerForm: 1, type: 'T'},
            success: r => {
                $('main').html(r);
                $.getScript("../../files/js/init.js");
            }
        })

		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {getId: 1, type: 'T'},
			success: r => {
				idsArray = JSON.parse(r);
				$("main").fadeIn("slow", loader.out());
			}
		})

		$('.btnBack').attr('disabled', 1);
		$('.btnPrint').attr('disabled', 1);
    })

    $(document).on('click', '.btnBack', function(){
    	$('.btnRefresh').click();
    })

    $(document).on('click', '.btnPrint', function(){
    	$('#printUser').submit();
    })

    $(document).on('submit', "form", function(e){
		e.preventDefault;
		return false;
	})

    function genId(type){
    	let id = "", f = 1;
    	do{
    		id = `${type}${Math.floor((Math.random() * 9) + 1)}${Math.floor((Math.random() * 9) + 1)}${Math.floor((Math.random() * 9) + 1)}${Math.floor((Math.random() * 9) + 1)}`;
    		f = ($.inArray(id, idsArray) == -1 ? 0 : 1);
    	}while(f);

    	return id.toUpperCase();
    }

    function genPass(){
    	let base = (Math.random().toString(36).slice(-8)),
    		index = base.indexOf(base[3]),
    		id = base.substr(0, index),
    		text = base.substr(index + 1),
    		pass = "";
    	if (Math.floor((Math.random() * 2) + 0)) {
    		for (let i = 0; i < 4; i++) {
    			pass += `${(Math.random().toString(36).slice(-8))[i]}`
    		}
			pass += text.toUpperCase();
    	}else{
    		for (let i = 3; i >= 0; i--) {
    			pass += `${(Math.random().toString(36).slice(-8))[i]}`
    		}
			pass += text.toLowerCase();
    	}
		return pass;
    }
})()