$(document).ready(function(){
    $('#modalPermission').modal();
    $('#modalJustification').modal();
});

(function()
{
    var schedules_id = new Array(), x = 0, justification_id = new Array();

    $(document).on('click', '.btnPermission', function () {
        loader.in();
        let id = $("#printRecord input[name='id']").val();
        schedules_id.length = 0;
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: {
                v_permmission: 1,
                student: id
            }
        }).done(function (r) {
            if (r == 0) {
                $('#modalPermission .modal-content').html("<div class='row search_error'><div class='col s8 offset-s2 alert_ red-text text-darken-4'>Usuario seleccionado aún no cuenta con un horario</div></div>");
                $('#modalPermission').modal('open');
            } else {
                $('#modalPermission .modal-content').html(r);
                $('#modalPermission').modal('open');
                $('select').material_select();
            }
            loader.out();
        });
    });

    $(document).on('click', '.btnJustify', function(){
        justification_id.length = 0;
        loader.in();
        let id = $("#printRecord input[name='id']").val();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: {
                v_justification: 1,
                student: id
            }
        }).done(function (r) {
            $('#modalJustification .modal-content').html(r);
            $('#modalJustification').modal('open');
            $('select').material_select();
            loader.out();
        });
    });

    /*            CÓDIGO PARA PERMISOS         */
    $(document).on("change", "form.addPermission #selectPermission", function () {
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: {
                getSchedulePermission: 1,
                student: $("#printRecord input[name='id']").val(),
                day: $("#selectPermission").val()
            }
        }).done(function (r) {
            if (r == 0) {
                $('#modalPermission .modal-content .schedule_permission').html("<div class='row search_error col s8 offset-s2'><div class='alert_ red-text text-darken-4'>Horario de día seleccionado no disponible</div></div>")
            } else {
                $('#modalPermission .modal-content .schedule_permission').html(r);
            }
        });
    });
    $(document).on("change", "form.addPermission .btn_checkbox", function () {
        if ($(this).prop("checked")) {
            schedules_id[x] = { "id": $(this).attr("id") };
            x++;
        } else {
            removeIndex($(this).attr("id"), schedules_id);
            x--;
        }
    });
    function removeIndex(id, array) {
        for (var i = 0; i < array.length; i++) {
            if (array[i].id == id) {
                array.splice(i, 1);
            }
        }
    }
    $(document).on("click", "#modalPermission .btnSavePermission", function () {
        // var loader = new Loader();
        $("form.addPermission").validate({
            rules: {
                justification: {
                    required: true,
                }
            },
            messages: {
                justification: {
                    required: 'Ingrese una justificación'
                }
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                if (errorSelect($("select#selectPermission"))) {
                    if (schedules_id.length > 0) {
                        loader.in();
                        let object = JSON.stringify(schedules_id);
                        $.ajax({
                            type: 'POST',
                            url: '../../files/php/C_Controller.php',
                            data: {
                                newPermission: 1,
                                student: $("#printRecord input[name='id']").val(),
                                date: $("#modalPermission #selectPermission").val(),
                                justification: $("#modalPermission #justification").val(),
                                permission: object
                            }
                        }).done(function (r) {
                            console.log(r);
                            loader.out();
                            Materialize.toast('Permisos registrados con exito', 3000);
                            $('#modalPermission').modal('close');
                        });
                    } else {
                        Materialize.toast('No se han seleccionados horas', 3000);
                    }
                } else {
                    Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
                }
            }
        });
    });
    $(document).on("click", "form.addPermission .btnAllPermission", function () {
        schedules_id.length = 0;
        for (var i = 0; i < $("form.addPermission .btn_checkbox").length; i++) {
            $("form.addPermission .btn_checkbox").eq(i).prop("checked", true);
            schedules_id[i] = $("form.addPermission .btn_checkbox").eq(i).attr("id");
        }
    });
    /*          FIN DE CODIGO PARA PERMISOS         */
    /*            CÓDIGO PARA JUSTIFICACIONES    */

    $(document).on("change", "#modalJustification #selectPeriodJustification", function () {
        loader.in();
        $.ajax({
            type: 'POST',
            url: '../../files/php/C_Controller.php',
            data: {
                get_assistance: 1,//,
                student: $("#printRecord input[name='id']").val(),
                period: $(this).val()
            }
        }).done(function (r) {
            $('#modalJustification form .container-justification').html(r);
            $('select').material_select();
            loader.out();
        });
    });

    $(document).on("change", "#modalJustification .btn_checkbox_J", function () {
        if ($(this).prop("checked")) {
            justification_id[x] = { "id": $(this).attr("id") };
            x++;
        } else {
            removeIndex($(this).attr("id"), justification_id);
            x--;
        }
    });

    $(document).on("click", "#modalJustification .btnSaveJustification", function () {
        $("form.justification").validate({
            rules: {
                justification: {
                    required: true,
                }
            },
            messages: {
                justification: {
                    required: 'Ingrese una justificación'
                }
            },
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form) {
                if (justification_id.length > 0) {
                    loader.in();
                    let object = JSON.stringify(justification_id);
                    $.ajax({
                        type: 'POST',
                        url: '../../files/php/C_Controller.php',
                        data: {
                            newJustification: 1,
                            justification: $("#modalJustification  #justification").val(),
                            id_justification: object
                        }
                    }).done(function (r) {
                        // alert(r);
                        justification_id.length = 0;
                        loader.out();
                        Materialize.toast('Justificaciones registradas', 3000);
                        $('#modalJustification').modal('close');
                        location.reload();
                    });
                } else {
                    Materialize.toast('No se han seleccionados inasistencias', 3000);
                }
            }
        });
    });
    /*          FIN CÓDIGO PARA JUSTIFICACIONES    */
})()