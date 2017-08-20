(() => {
    loader = new Loader();

    Materialize.updateTextFields();

    var id = $("#userId").html(), photoFlag = false, photoSuccess = true, idLog, table, type;
    $('.frmPhoto_cont .btnModifyPhoto').click(function(){
        $('.photoFile').trigger('click');
    })

    $("#cmbLvl_Mod").change("value", function(){
        if((validateSelect($("#cmbLvl").val()))==true){

            $.ajax({
                method: 'POST',
                url: '../../files/php/C_Controller.php',
                data: {
                    getSections: 'Si',
                    level: $("#cmbLvl").val(),
                }
            }).done(function(sectionObject){
                let object = JSON.parse(sectionObject);
                $("#cmbSection_Mod").empty();
                $("#cmbSection_Mod").append("<option value='' disabled selected>Elegir Sección</option>");
                if (object.length > 0) {
                    
                    for (var i in object) {
                        $("#cmbSection").append("<option value="+object[i].id+">"+object[i].nombre+", "+object[i].seccion+"</option>");
                    }
                }
                $("#cmbSection").material_select();
            });
        }
    });

    $('.photoFile').change(function(){
        loader.in();
        var pattern = /(.*?)\.(png|jpeg|jpg)$/;
        if (pattern.test($(this).val())) {
            var image_file = document.getElementById('photo-file-input');
            var file = image_file.files[0];
            var form_data = new FormData();

            form_data.append('file', file);
            form_data.append('id', id);
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
                }
            })
        }else{
            $(this).val('');
            Materialize.toast('Archivo inválido!', 2000);
        }
        loader.out();
    })

    $.validator.addMethod('email', function(value, element) {
        return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, 'Ingrese un valor válido.');

    $('form.frmData').validate({
        rules: {
            txtName: 'required',
            txtLastName: 'required',
            txtPass: 'required',
            txtEmail: {
                required: true,
                email: true
            },
            txtRes: 'required',
            txtDate: 'required',
            txtProf: 'required',
            txtSex: 'required',
            cmbProf: 'required',
            cmbLvl: 'required',
            cmbSection: 'required'
        },
        messages: {
            txtName: 'Ingrese un nombre',
            txtLastName: 'Ingrese un apellido',
            txtPass: 'Ingrese una contraseña',
            txtEmail: {
                required: 'Ingrese un valor',
                email: 'Ingrese un valor válido'
            },
            txtRes: 'Ingrese un valor',
            txtDate: 'Ingrese un valor',
            txtProf: 'Ingrese un valor',
            txtSex: 'Seleccione un valor',
            cmbProf: 'Seleccione un valor',
            cmbLvl: 'Seleccione un valor',
            cmbSection: 'Seleccione un valor'
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
            $('.frmData').submit(function(e){
                return false;
            })
            if (errorSelect($("select.cmbUpdate"))) {
                if (photoFlag) {
                    $.ajax({
                        url: '../../files/php/C_Controller.php',
                        data: {uploadImg: 1, idUser: id, imgName: $('.frmPhoto').attr('src').split('/')[$('.frmPhoto').attr('src').split('/').length - 1]},
                        success: function(r){
                            photoSuccess = ( r ? 1 : 0 );
                        }
                    })
                }

                if (id[0] == 'C') {
                    type = 'C'; idLog = 'idCoor'; table = 'coordinator';
                }else if (id[0] == 'D') {
                    type = 'T'; idLog = 'idTeacher'; table = 'teacher';
                }else{
                    type = 'S'; idLog = 'idStudent'; table = 'student';
                }

                var data = {
                    id: id,
                    type: type,
                    idLog: idLog,
                    table: table,
                    name: $('#txtName').val(),
                    lastName: $('#txtLastName').val(),
                    password: $('#txtPass').val(),
                    email: $('#txtEmail').val(),
                    residence: $('#txtRed').length > 0 ? $('#txtRes').val() : null,
                    birthdate:  $('#txtDate').length > 0 ? $("#txtDate").val() : null,
                    idSection: $('#cmbSection_Mod').length > 0 ? $('#cmbSection_Mod').val() : null,
                    idLevel: $('cmbLvl_Mod').length > 0 ? $('cmbLvl').val() : null,
                    profession: $('txtProf').length > 0 ? $('txtProf').val() : null,
                    sex: $("input[name='txtSex']").length > 0 ? $("input[name='txtSex']:checked").val() : null
                };

                loader.in();
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {sendModification: 1, user_info: JSON.stringify(data)},
                    success: function(r){
                        loader.out();
                        if (parseInt(r) && photoSuccess) {
                            Materialize.toast("Los cambios se han guardado con éxito!", 2000);
                            if (document.URL.split('/')[document.URL.split('/').length - 1].split('.')[0] == 'config') {
                                setTimeout( () => {
                                    $.getScript(`../../files/js/c/config.js`);
                                    $("html, body").animate({ scrollTop: 0 }, 800);
                                }, 800);
                            }else{
                                setTimeout( () => $.getScript(`../../files/js/c/search.js`), 800);
                            }
                        }else{
                            Materialize.toast("Ha ocurrido un error", 2000);
                        }
                    }
                })
            }else{
                Materialize.toast("Faltan campos por llenar!", 2000);
            }  
        }
    });

    $('.btnSave_User').click(() => {
        $('form.frmData').submit();
    })

    $('.btnCancel_User').click(function(){
        if (document.URL.split('/')[document.URL.split('/').length - 1].split('.')[0] == 'config') {
            $.getScript(`../../files/js/c/config.js`);
            $("html, body").animate({ scrollTop: 0 }, 800);
        }else{
            $.getScript(`../../files/js/c/search.js`);
        }
    });
})()

