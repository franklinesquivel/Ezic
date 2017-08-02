(()=>{
    $(document).ready(function(){
        //Funcion que verifica fechas - Obtener mayor y menor
        var validateDates = (startDate, endDate) =>{
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
        }

        var loader = new Loader();

        //Formulario para registro de periodo
        $.validator.addMethod('porcentaje', function(value, element) {
            return this.optional(element) || /^\d{1,3}$/.test(value);
        }, 'Ingrese un valor válido.');

        $("form.registerPeriod").validate({
            rules:{
                startDate:{
                    required: true
                },
                endDate:{
                    required: true
                },
                percentage:{
                    required: true,
                    porcentaje: true
                }
            },
            messages:{
                startDate:{
                    required: 'Ingrese una fecha'
                },
                endDate:{
                    required: 'Ingrese una fecha'
                },
                percentage:{
                    required: 'Ingrese un valor',
                    porcentaje: 'Ingrese un valor válido'
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
                let Datestart = $('#startDate').val();
                   DateEnd = $('#endDate').val();

                if(validateDates(Datestart, DateEnd)){
                    loader.in();
                    $.ajax({
                        method: "POST",
                        url: "../../files/php/C_Controller.php",
                        data:{
                            periodNew: 'Si',
                            startDate: Datestart,
                            endDate: DateEnd,
                            percentage: $('#percentage').val()
                        }
                    }).done(function(r){
                        loader.out();                     
                        if (r == -2) {
                            $('#startDate').val('');
                            $('#endDate').val('');
                            $('#percentage').val('');
                            Materialize.updateTextFields();
                            Materialize.toast('Período ingresado con exito', 3000);
                        }else{
                           if(r == -1){
                                Materialize.toast("Favor, no poner fechas que abarcan otros periodos",3000);
                            }
                            if(r != -1 && r != -2){
                            $("#percentage").focus();
                            Materialize.toast("ERROR, el valor ingresado en porcentaje supera el 100% ("+r+"% es lo máximo que puedes asignar)",3000);
                            } 
                        }
                    });
                }else{
                    $('#startDate').val('');
                    $('#endDate').val('');
                    $('#startDate').focus();
                    Materialize.toast('Oh, oh! Algo va mal en las fechas', 3000);
                }
            }
        });

        $(".refresh").click(function(){
            loader.in();
            $('#startDate').val('');
            $('#endDate').val('');
            $('#percentage').val('');
            loader.out();
        });

        $('.info_btn').click(function(){
            $('.tap-target').tapTarget('open');
        });
    });
})()