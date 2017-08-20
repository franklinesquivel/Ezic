(() => {
	var loader, sArray = [];
	$(document).ready(function(){
		loader = new Loader();

		init();

		jQuery.validator.setDefaults({
			debug: true,
			success: "valid"
		});
	})

	$(document).on('click', '.btnSave', function(){
		$(".frmSpecialty").validate({
			rules: {
				txtName: 'required'
			},
			messages: {
				txtName: 'Este dato es requerido!'
			},
			errorElement : 'div',
	        errorPlacement: function(error, element) {
	            var placement = $(element).data('error');
	            if (placement) {
	                $(placement).append(error);
	            } else {
	                error.insertAfter(element);
	            }
	        },
	        submitHandler: function(form) {
	        	let f = (sArray.length > 0 ? ($.inArray($("#txtName").val(), sArray) == -1 ? 0 : 1) : 0);
	        	if (f) {
	        		Materialize.toast("Esa especialidad ya existe!", 2000);
	        	}else{
	        		$.ajax({
	        			type: 'POST',
	        			url: '../../files/php/C_Controller.php',
	        			data: {registerSpecialty: 1, name: $("#txtName").val()},
	        			success: r => {
	        				Materialize.toast(r ? "La especialidad se ha registrado exitosamente!" : "Ha ocurrido un error!", 2000);
	        				init();
	        			}
	        		})
	        	}
	        }
		})

		$(".frmSpecialty").submit();
	})

	$(document).on('submit', "form", function(e){
		e.preventDefault;
		return false;
	})

	$(document).on('click', ".btnRefresh", function(){
		init();
	})

	function init(){
		loader.in();
		$("main").fadeOut(100);
		$.ajax({
			type: 'POST',
			url: '../../files/php/C_Controller.php',
			data: {specialtyArray: 1},
			success: r => {
				if (r != -1) {
					sArray = JSON.parse(r);
					$('main').html(`
						<br>
						<div class='container section'>
							<form class='frmSpecialty' autocomplete='off'>
								<div class='row'>
									<div class='input-field col l6 m6 s10 offset-l3 offset-m3 offset-s1'>
										<input type='text' name='txtName' id='txtName' class='txtName'>
										<label for='txtName'>Nombre de la especialidad</label>
									</div>
								</div>
								<center>
									<div class='btn waves-effect waves-light black btnSave'>
										Registrar Especialidad
										<i class='material-icons left'>save</i>
									</div>
								</center>
							</form>
						</div>`);
				}
				$('main').fadeIn('slow', loader.out());
			}
		})
	}
})()