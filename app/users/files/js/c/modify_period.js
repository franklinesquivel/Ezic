(()=>{
	$(document).ready(function(){
		const validateDates = (startDate, endDate) =>{
            startDate = startDate.split('-');
            endDate = endDate.split('-');
            let fecha = new Date();

            let dateStart = new Date(startDate[0], startDate[1], startDate[2]),
                dateEnd = new Date(endDate[0], endDate[1], endDate[2]);

            if (dateStart > dateEnd) {
                return 0;
            }else if((startDate[0] < fecha.getFullYear()) || (endDate[0] < fecha.getFullYear())){
                return 0;
            }

            return 1;
        };
		var loader = new Loader();
		$(".btnModifyPeriod").click(function(){

			if (errorSelect($("select"))) {
				let period = $("#selectPeriod").val();
				loader.in();
				$.ajax({
					method: 'POST',
					url: './../../files/php/C_Controller.php',
					data:{
						choose_modifyPeriod: 'Si',
						period: period
					}
				}).done(function(r){
					loader.out();
					let objeto = JSON.parse(r)[0];
					console.log(objeto);
					let startDate = (objeto.startDate).split("-"), 
						endDate = (objeto.endDate).split("-");

					//Le asignamos valores a los inputs en el form.modify_period
					$('#startDate').pickadate().pickadate('picker').set('select', new Date(startDate[0], (startDate[1] - 1), startDate[2]));
					$('#endDate').pickadate().pickadate('picker').set('select', new Date(endDate[0], (endDate[1] - 1), endDate[2]));
					$("#percentage").val(objeto.percentage);
					$("#percentage").next().addClass("active");

					setTimeout(function(){
						$(".result_cont .modify_period").css("display", "flex");
					}, 500);
				});
			}else{
				Materialize.toast('Favor, seleccionar un periodo', 3000);
			}
		});

		$("form.modify_period").validate({
			rules:{
				percentage:{required: true}
			},
			message:{
				percentage:{required: 'Ingrese un valor'}
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
	        	if (validateDates($('#startDate').val(), $('#endDate').val())) {
					loader.in();
	        		$.ajax({
		        		method: 'POST',
		        		url: './../../files/php/C_Controller.php',
		        		data:{
		        			modifyPeriod: 'Si',
		        			idPeriod: $("#selectPeriod").val(),
		        			startDate: $('#startDate').val(),
		        			endDate: $('#endDate').val(),
		        			percentage: $('#percentage').val(),
		        		}
		        	}).done(function(x){
						//alert(x);
		        		if (x == -1) {
		        			Materialize.updateTextFields();

		        			setTimeout(function(){
								$(".result_cont .modify_period").css("display", "none");
							}, 500);
		        			$("#selectPeriod").val('');
		        			$("#selectPeriod").material_select();
	                        Materialize.toast('Periodo modificado con exito', 3000);
		        		}else if(x== -2){
		        			Materialize.toast('Error, algunas fechas ya estan asignadas en otros periodos', 3000);
		        		}else{
		        			$('#percentage').focus();
		        			Materialize.toast('Error, el valor máximo a agregar en porcentaje es de '+x+'%', 3000);
		        		}
		        		loader.out();
		        	});
	        	}else{
	        		$('#startDate').val('');
	                $('#endDate').val('');
	                Materialize.toast('Oh, oh! Algo va mal en las fechas', 3000);
	        	}
	        }
		});

		$(".refresh").click(function(){
			loader.in();
			$(".result_cont .modify_period").fadeOut("slow");
	        $("#selectPeriod").val('');
		    $("#selectPeriod").material_select();
	        loader.out();
	    });

	    $('.info_btn').click(function(){
	        $('.tap-target').tapTarget('open');
	    });
	});
})()
