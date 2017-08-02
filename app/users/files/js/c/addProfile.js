(()=>{
    $(document).ready(function(){

    	$.validator.addMethod('porcentaje', function(value, element) {
            return this.optional(element) || /^\d{1,3}$/.test(value);
        }, 'Ingrese un valor válido.');

        var loader = new Loader();

    	$("form.registerProfile").validate({
            rules:{
                profile_name: {
                	required: true
                },
                percentage: {
                	required: true,
                	porcentaje: true
                },
                description: {
                	required: true
                }
            },
            messages:{
            	profile_name:{ required: 'Ingrese un nombre para el pérfil' },
            	percentage:{
            		required: 'Ingre un valor',
            		porcentaje: 'Ingrese un valor válido'
            	},
            	description:{ required: 'Ingrese una descripción' }
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
                let nameProfile = $("#profile_name").val(), percentageProfile = $("#percentage").val(),
                	periodSelect = $("#selectPeriod").val(), subjectSelect = $("#selectSubject").val(),
                	descriptionProfile = $("#description").val();

                if (errorSelect($("select"))) {
                    loader.in();
                    $.ajax({
                        method: "POST",
                        url: "../../files/php/C_Controller.php",
                        data: {
                            profileNew: 'Si',
                            name: nameProfile,
                            percentage: percentageProfile,
                            period: periodSelect,
                            subject: subjectSelect,
                            description: descriptionProfile
                        }
                    }).done(function(r){
                        loader.out();
                        if (r == "-1") {
                            $("#percentage").val('');
                            $("#profile_name").val('');
                            $("#description").val('');
                            $("#selectPeriod").val('');
                            $("#selectPeriod").material_select();
                            $("#selectSubject").val('');
                            $("#selectSubject").material_select();
                            Materialize.updateTextFields();
                            Materialize.toast('Perfil de evaluación ingresado con éxito', 3000);
                        }else{
                            Materialize.toast("Error, usted solo puede asignar "+r+"% más a esta materia", 3000);
                        }
                    });
                }else{
                    Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
                }
            }
        });
    });
})()
