(() => {

	var loader, sctnObj, registerCant = 0, 
        selectedSection, studentsData = [], studentsArray = [];
	$(document).ready(function(){
		loader = new Loader();

        init();

        $('#studentCant-modal').modal();
	})

    $(document).on('change', '#cmbLevel', function() {
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {getSpecialties: 1, lvl: $("#cmbLevel").val()},
                success: function(r){
                    if (r != -1) {
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").empty();
                        $("#cmbSpecialty").html("<option disabled selected>Especialidad</option>");
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('#cmbSpecialty').append(r);
                        $('select').material_select();
                        search_section($("#cmbLevel").val());
                    }else{
                        Materialize.toast('No se encontraron registros de especialidades para mostrar', 1000); 
                        $("#cmbSpecialty").empty();
                        $("#cmbSection").empty();
                        $("#cmbSpecialty").html("<option disabled selected>Especialidad</option>");
                        $("#cmbSection").html("<option disabled selected>Sección</option>");
                        $('select').material_select();
                        search_section($("#cmbLevel").val());
                    }
                }
            })
        })

    $(document).on('change', '#cmbSpecialty', function() {
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {returSections: 1, specialty: $("#cmbSpecialty").val()},
            success: function(r){
                if (r != -1) {
                    $("#cmbSection").html("<option disabled selected>Sección</option>");
                    $('#cmbSection').append(r);
                    $('select').material_select();
                    search_section($("#cmbLevel").val(), $("#cmbSpecialty").val());
                }else{
                    Materialize.toast('No se encontraron registros de especialidades para mostrar', 3000); 
                }
            }
        })
    })

    $(document).on('change', '#cmbSection', function() {
        search_section($("#cmbLevel").val(), $("#cmbSpecialty").val(), $("#cmbSection").val());
    })

	$(document).on('click', '.sctnItem', function(){
        $('#studentCant-modal').modal('open');
        selectedSection = $.grep(sctnObj.sctns, (n, i) => (n.idSection == $(this).attr("idSn")));

        $('#studentCant-modal #lvlHelper').html(selectedSection[0].level == 1 ? "1ro" : (selectedSection[0].level == 2 ? "2do" : "3ro"));
		$('#studentCant-modal #identifierHelper').html(selectedSection[0].identifier);
		$("#studentCant-modal #sctnCant").html("Cantidad de estudiantes: " + selectedSection[0].studentCant);
		$("#studentCant-modal #sctnLimit").html(`${sctnObj.max - selectedSection[0].studentCant} vacantes disponibles`);
        $(" #txtCant").attr("placeholder", `Max. ${sctnObj.max - selectedSection[0].studentCant}`);
        Materialize.updateTextFields();
	})

    $(document).on('submit', "#studentCant-frm", function(){
        return false;
    })

    $(document).on('click', '.btnSaveCant', function(){
        $("#studentCant-frm").validate({
            rules: {
                txtCant: {
                    required: 1,
                    max: sctnObj.max - selectedSection[0].studentCant,
                    min: 1
                }
            },
            messages: {
                txtCant: {
                    required: 'Este dato es requerido!',
                    max: 'Ingrese un valor que no sobrepase al máximo!',
                    min: 'Debe ingresar por lo menos un estudiante!'
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
                $('#studentCant-modal').modal('close');
                registerCant = $("#txtCant").val();
                loader.in();
                $('main').fadeOut('slow', function(){
                    $(".btnRmvFrm").removeAttr("disabled");
                    $(".btnAddFrm").removeAttr("disabled");
                    $('main').html(`<div class='container section'></div><center><div class='btn waves-effect waves-light black btnSaveStudents'><i class='material-icons left'>save</i> Registrar Estudiantes</div></center>`);
                    for (var i = 0; i < registerCant; i++) {
                        $('main .container').append(createForm(i));
                        $('main .container .form_cont:last').fadeIn(200)
                        $('main .container').append("<div class='divider'></div><br><br>");
                    }
                    $.getScript('../../files/js/init.js');
                    $('main').fadeIn('slow', loader.out());
                })
            }
        })

        $("#studentCant-frm").submit();
    })

    $(document).on('click', '.btnAddFrm', function(){
        if ((registerCant + 1) == (sctnObj.max - selectedSection[0].studentCant)) {
            Materialize.toast("Ya has llegado al límite de registros de esta sección!", 2000);
        }else{
            $('main .container').append(createForm(registerCant));
            registerCant++;
            $('main .container').append("<div class='divider'></div><br><br>");
            $('main .container .form_cont:last').fadeIn(500);
            $.getScript('../../files/js/init.js');
        }
    })

    $(document).on('click', '.btnRmvFrm', function(){
        if (registerCant == 1) {
            Materialize.toast("No puedes borrar todos los formularios!", 2000);
        }else{
            $('main .container .form_cont:last').fadeOut(300);
            registerCant--;
            setTimeout(function(){
                $('main .container .form_cont:last').remove();
                $('main .container .divider:last').remove();
                $('main .container br:last').remove();
                $('main .container br:last').remove();
            }, 100);
        }
    })

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    $.validator.addMethod('email', function(value, element) {
        return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
    }, 'Ingrese un valor válido.');

    $.validator.addMethod('validName', function(value, element) {
        return this.optional(element) || /^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð']+\s{1}[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð']+$/u.test(value);
    }, 'Ingrese un valor válido.');

    $(document).on('click', ".btnSaveStudents", function(){
        studentsData.length = 0;
        let f = 1;
        for (let i = 0; i < registerCant; i++) {
            $(`.frmRegister_${i}`).validate({
                ignore: '.select-dropdown',
                rules: {
                    txtName: {
                        required: 1,
                        validName: 1
                    },
                    txtLast: {
                        required: 1,
                        validName: 1
                    },
                    txtEmail: {
                        required: 1,
                        email: 1
                    },
                    txtRes: 'required',
                    txtDate: 'required'
                },
                messages: {
                    txtName: {
                        required: 'Este dato es necesario!',
                        validName: 'Ingrese un nombre válido!'
                    },
                    txtLast: {
                        required: 'Este dato es necesario!',
                        validName: 'Ingrese un apellido válido!'
                    },
                    txtEmail: {
                        required: 'Este dato es necesario!',
                        email: 'Ingrese un valor válido!'
                    },
                    txtRes: 'Este dato es necesario!',
                    txtDate: 'Este dato es necesario!'
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
                    if (errorSelect($("[name=cmbSex]"))) {
                        $(this).attr('disabled', 1);
                        let lastAux = $("#txtLast_" + i).val().split(' '),
                            nH = lastAux[0][0], 
                            lH = lastAux[1][0];

                        studentsData.push({
                            "type": "S",
                            "idStudent": genId(nH, lH),
                            "name": $("#txtName_" + i).val(),
                            "lastName": $("#txtLast_" + i).val(),
                            "password": genPass(),
                            "email": $("#txtEmail_" + i).val(),
                            "birthdate": $("#txtDate_" + i).val(),
                            "sex": $("#cmbSex_" + i).val(),
                            "residence": $("#txtRes_" + i).val()
                        });
                    }else{
                        if (f) {
                            Materialize.toast("Ingrese todos los campos!", 2000);
                            f = 0;
                        }
                    }
                }, 
                invalidHandler: function(event, validator) {
                    errorSelect($("[name=cmbSex]"));
                    if (f) {
                        Materialize.toast("Ingrese todos los campos!", 2000);
                        f = 0;
                    }
                }
            })

            $(`.frmRegister_${i}`).submit();
        }

        if (studentsData.length == registerCant) {
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data: {
                    registerUser: 1, 
                    data: JSON.stringify(studentsData), 
                    type: 'S', 
                    idSection: selectedSection[0].idSection
                },
                success: r => {
                    if (r) {
                        Materialize.toast(studentsData.length > 1 ? "Los estudiantes han sido registrados exitosamente!" : "El estudiante fue registrado exitosamente!", 2000, '', init());
                    }else{
                        Materialize.toast("Ha ocurrido un error :$", 2000, '', ini());
                    }
                }
            })
        }
    })

    $(document).on('click', '.btnRefresh', function(){
        init();
    })

	const search_section = (lvl = '', spcty = '', sctn = '') => {
        loader.in()
    	$.ajax({
    		type: "POST",
    		url: '../../files/php/C_Controller.php',
    		data: {filterSectionsForRegister: 1, lvl, spcty, sctn},
    		success: r => {
    			if (r != -1) {
	    			sctnObj = JSON.parse(r);
	    			$(".sectionCollection").html(sctnObj.el);
                }else{
                    $(".sectionCollection").html(`<div class="alert_">No se encontraron secciones con los requisitos especificados!</div>`);
                }
                loader.out();
    		}
    	})
    }

    const init_search = (callback) => {
        $("#cmbLevel").empty();
        $("#cmbSpecialty").empty();
        $("#cmbSection").empty();

        $("#cmbLevel").html("<option selected disabled>Nivel</option>");
        $("#cmbSpecialty").html("<option selected disabled>Especialidad</option>");
        $("#cmbSection").html("<option selected disabled>Sección</option>");

        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getLvls: 1},
            success: (r) => {
                if (r != -1) {
                    $('#cmbLevel').append(r);
                    $('select').material_select();
                    search_section();
                }
                callback();
            }
        })
    }

    const init = function(){
        loader.in();
        $('main').fadeOut('slow', function(){
            $('main').html(`
                <div class='container'><br><br>
                    <h5 class="center">Selecciona la sección a la cual deseas registrar estudiantes</h5>
                    <div class="listCont">
                        <br>
                        <div class='row'>
                            <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                                <select id="cmbLevel">
                                    <option selected disabled>Nivel</option>
                                </select>
                                <label>Selecciona un nivel</label>
                            </div>

                            <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                                <select id="cmbSpecialty">
                                    <option selected disabled>Especialidad</option>
                                </select>
                                <label>Selecciona una especialidad</label>
                            </div>

                            <div class='input-field col l6 m6 s10 offset-s1 offset-l3 offset-m3'>
                                <select id="cmbSection">
                                    <option selected disabled>Sección</option>
                                </select>
                                <label>Selecciona una sección</label>
                            </div>

                            <div class="col l8 m8 s12 offset-l2 offset-m2">
                                <br>
                                <h5 class="center">Lista de Secciones</h5>
                                <ul class='collection sectionCollection'></ul>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            $("select").material_select();

            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data: {getId: 1, type: 'S'},
                success: r => {
                    studentsArray = JSON.parse(r);
                }
            })

            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {getLvls: 1},
                success: (r) => {
                    if (r != -1) {
                        $('#cmbLevel').append(r);
                        $('select').material_select();
                        search_section();
                    }
                    $('main').fadeIn('slow', loader.out());
                }
            })
        })

        $(".btnRmvFrm").attr("disabled", 1);
        $(".btnAddFrm").attr("disabled", 1);
    }

    const genId = function(n, l){
        let id = "", f = 1;
        do{
            id = `${n}${l}${Math.floor((Math.random() * 9) + 1)}${Math.floor((Math.random() * 9) + 1)}${Math.floor((Math.random() * 9) + 1)}${Math.floor((Math.random() * 9) + 1)}`;
            f = !$.inArray(id, studentsArray);
        }while(f);

        return id.toUpperCase();
    }

    const genPass = function(){
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