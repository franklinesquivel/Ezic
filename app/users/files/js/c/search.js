(() => {
    var users, loader, type = 'all', attr = 'id', f, state = 1;
    var back_i = 1, back_2_i = 0, g_id, stage_aux = "", gR;
    var schedules_id = new Array(), x = 0, justification_id = new Array();

    var stage = {
        1: () => {
            loader.in();
            $('main').fadeOut('slow');
            let nav = document.createElement('nav');
            nav.innerHTML = "<div class='nav-wrapper black '><form class='search'><div class='input-field'><input placeholder='Buscar usuario por código' id='search' type='search' required><label class='label-icon' for='search'><i class='material-icons'>search</i></label><i class='material-icons'>close</i></div></form></div>";
            let row = document.createElement('row');
            row.classList = 'row';
            row.innerHTML = "<div class='search_container col l12 m12 s12'><ul class='user-cont'></ul></div>";
            $('main').html(nav);
            $('main').append(row);
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {getUsers: 1},
                success: function(r){
                    users = JSON.parse(r);
                    // console.log(users);
                    sort_users();
                    for (let i = 0 ; i < users.length; i++) {
                        show_user(users[i]);
                    }
                    $.getScript('../../files/js/init.js');
                    initSearch();
                    initFunctions();
                    $('main').fadeIn('slow', loader.out());
                }
            })
            $('.btnBack').attr('disabled', 1);
            $('.btnPrint').attr('disabled', 1);
            $('.options_btn').removeAttr('disabled');
            back_i++;
            f = 1;
        },
        2: {
            record: [
                id => {
                    loader.in();
                    $('main').fadeOut('slow');
                    $.ajax({
                        url: '../../files/php/C_Controller.php',
                        data: {record: 1, id: id},
                        success: function(r){
                            $('main').html(r);
                            $('main').append("<br><br><div class='row'><div class='col l4 m4 s10 offset-l1 offset-m1 offset-s1 green btn waves-effect btnPermission'>Permiso de ausencia <i class='material-icons right'>date_range</i></div><div class='hide-on-med-and-up col s12'><i style='opacity: 0'>.</i></div><div class='col l4 m4 s10 offset-l2 offset-m2 offset-s1 orange btn waves-effect btnJustify'>Registrar justificante <i class='material-icons right'>done_all</i></div></div>")
                            $('.recordTables thead tr th').each(function() {
                                $(this).css('border', '1px solid ' + $(this).parent().css('background-color'));
                            });

                            $('.recordTables tbody tr').each(function() {
                                $(this).css({
                                    'border-left': '1px solid ' + $(this).parent().parent().children().children().css('background-color'),
                                    'border-right': '1px solid ' + $(this).parent().parent().children().children().css('background-color'),
                                    'border-bottom': '1px solid ' + $(this).parent().parent().children().children().css('background-color')
                                })
                            });
                            initFunctions();
                            $('main').fadeIn('slow', loader.out());
                        }
                    })
                    $('.btnBack').removeAttr('disabled');
                    $('.btnPrint').removeAttr('disabled');
                    $('.options_btn').attr('disabled', 1);
                    stage_aux = 'record';
                    f = 1;

                    $('.btnPrint').click(() => {
                        $('#printRecord input[name=id]').val(id);
                        $('#printRecord').submit();
                    })
                },
                () => {
                    //$('main').html('<h3 class="center">Permiso</h3>');
                    //TRABAJAR CÓDIGO PARA MOSTRAR FOMULARIO DE LOS PERMISOS
                    schedules_id.length = 0;
                    loader.in();
                    $.ajax({
                        type: 'POST',
                        url: '../../files/php/C_Controller.php',
                        data:{
                            v_permmission: 1,//,
                            student: g_id
                        }
                    }).done(function(r){
                        if (r=="0") {
                            $('main').html("<div class='row search_error col s8 offset-s2'><div class='alert_ red-text text-darken-4'>Usuario seleccionado aún no cuenta con un horario</div></div>");
                        }else{
                            $('main').html(r);
                            $('select').material_select();
                        }
                        loader.out();
                    });
                },
                () => {
                    //$('main').html('<h3 class="center">Justificante</h3>');
                    //lO MISMO DE ARRIBA PERO PARA LA JUSTIFICACIÓN :v
                    justification_id.length = 0;
                    loader.in();
                    $.ajax({
                        type: 'POST',
                        url: '../../files/php/C_Controller.php',
                        data:{
                            v_justification: 1,//,
                            student: g_id
                        }
                    }).done(function(r){
                        $('main').html(r);
                        $('select').material_select();
                        loader.out();
                    });
                }
            ],
            show: id => {
                loader.in();
                $('main').fadeOut('slow');
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {showUser: 1, user_obj: JSON.stringify(get_user('id', g_id))},
                    success: function(r){
                        $('main').html(r);
                        $('main').fadeIn('slow', loader.out());
                        $('.btnBack').removeAttr('disabled');
                        $('.btnPrint').removeAttr('disabled');
                        $('.options_btn').attr('disabled', 1);
                        $('.btnPrint').click(() => {
                            $('#printUser input[name=id]').val(g_id);
                            $('#printUser').submit();
                        })
                    }
                })
            },
            edit: id => {
                loader.in();
                $('main').fadeOut('slow');
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {newForm: '1', id: id},
                    success: (r) => {
                        $('main').html(r);
                        $.getScript("../../files/js/init.js");
                        $.getScript("../../files/js/c/modify_user_data.js");
                        $('.btnBack').removeAttr('disabled');
                        $('.btnPrint').attr('disabled', 1);
                        $('.options_btn').attr('disabled', 1);
                        $('main').fadeIn('slow', loader.out());
                    }
                })
            },
            schedule: id => {
                loader.in();
                $('main').fadeOut('slow');
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {showSchedule: '1', id: id, type: (id[0] == 'D' ? 'T' : (id[0] == 'C' ? 'C' : 'S')) },
                    success: (r) => {
                        if (r == -1) {
                            $('main').html("<br><div class='container alert_ red-text text-darken-4'>No posee un horario asignado</div>");
                        }else{
                            $('main').html("<br><div class='container'><table class='centered'><thead><th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></thead><tbody class='scheduleCont'></tbody></table></div><br>");
                            $('main table tbody').html(r);
                        }
                        $('.btnBack').removeAttr('disabled');
                        $('.btnPrint').removeAttr('disabled', 1);
                        $('.options_btn').attr('disabled', 1);
                        $('main').fadeIn('slow', loader.out());

                        $('.btnPrint').click(() => {
                            $('#printSchedule input[name=id]').val(id);
                            $('#printSchedule input[name=type]').val((id[0] == 'D' ? 'T' : (id[0] == 'C' ? 'C' : 'S')));
                            $('#printSchedule').submit();
                        })
                    }
                })
            },
            subject: id => {
                loader.in();
                $('main').fadeOut('slow');
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {showSubjects: '1', id: id},
                    success: (r) => {
                        if (r == -1) {
                            $('main').html(`
                                <br>
                                <div class='container alert_ red-text text-darken-4'>
                                    No posee materias asignadas...
                                </div>`);
                        }else{
                            $('main').html("<br>" + r);
                        }
                        $('.btnBack').removeAttr('disabled');
                        $('.btnPrint').attr('disabled', 1);
                        $('.options_btn').attr('disabled', 1);
                        $('main').fadeIn('slow', loader.out());
                    }
                })
            },
            grade: id => {
                loader.in();
                $('main').fadeOut('slow');
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {showGrades: '1', id: id},
                    success: (r) => {
                        if (r == -1) {
                            $('main').html(`<div class='container'><div style='margin-top: 5%;' class='alert_'>No se encontraron materias registradas a las sección del estudiante!</div></div>`)
                        }else{
                            r = JSON.parse(r);
                            gR = r
                            $('main').html(`
                                <div class="row cmbCont" style="display: none;">
                                    <div class="input-field col l4 m4 s10 offset-s1 offset-l4 offset-m4">
                                        <select name="" id="cmbPeriod">
                                            <option disabled>Seleciona un período</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="container gradesCont"></div>`);
                            $('#cmbPeriod').change(function(){
                                $('.gradesCont').html(gR.subject[$('#cmbPeriod option:selected').attr('index')]);
                            })
                            for (var i = 0; i < r.pInfo.length; i++) {
                                if(r.subject[i] != -1){
                                    $('#cmbPeriod').append(`<option index="${i}" period="${r.pInfo[i][1]}">Período N°${r.pInfo[i][1]}</option>`);
                                }else{
                                    $('#cmbPeriod').append(`<option disabled>Período N°${r.pInfo[i][1]}</option>`);
                                }
                            }
                            $('#cmbPeriod option[index]:first-child').attr('selected', 1);
                            $('.gradesCont').append(r.subject[$('#cmbPeriod option:selected').attr('index')]);
                            $('.cmbCont').fadeIn('slow');
                            $('select').material_select();
                            $('.btnPrint').removeAttr('disabled');
                        }
                        $('.btnBack').removeAttr('disabled');
                        $('.options_btn').attr('disabled', 1);
                        $('main').fadeIn('slow', loader.out());

                        $('.btnPrint').click(() => {
                            $('#printGrades input[name=id]').val(id);
                            $('#printGrades input[name=period]').val($('#cmbPeriod option:selected').attr('period'));
                            $('#printGrades').submit();
                        })
                    }
                })
            }
        }
    };

    const initFunctions = () => {
        if ($('.user-item').length > 0) {
            //ACCIONES PARA ESTUDIANTE
            $('.btnGrades').click(function() {
                g_id = $(this).parent().parent().parent().attr('id');
                stage[2]['grade'](g_id);
            });

            $('.btnRecord').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                stage[2]['record'][0](g_id);
            })

            $('.btnAppliedCode').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                let name = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.name').html(),
                    lastName = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.lastName').html();
                $('#applyCode').find('.apply-id').html(g_id);
                $('#applyCode').find('.apply-name').html(lastName + ", " + name);
                $('#applyCode').modal('open');
            });

            $('.btnRmvCode').click(function(){
                loader.in();
                g_id = $(this).parent().parent().parent().attr('id');
                let name = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.name').html(),
                    lastName = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.lastName').html();
                $('#removeCode-modal').find('.apply-id').html(g_id);
                $('#removeCode-modal').find('.apply-name').html(lastName + ", " + name);

                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {getStudentCodes: 1, id: g_id},
                    success: r => {
                        if (r != -1) {
                            if ($('#removeCode-modal .modal-content').find('.alert_').length > 0) {
                                $('#removeCode-modal .modal-content .alert_').remove();
                            }
                            $('#removeCode-modal .btnRemoveCodes').removeAttr('disabled');
                            $('#removeCode-modal tbody').html(r);
                            $('#removeCode-modal table').fadeIn('slow');
                        }else{
                            if ($('#removeCode-modal .modal-content').find('.alert_').length == 0) {
                                $('#removeCode-modal .modal-content').append(`<div class='alert_'>El estudiante no posee aplicación de códigos...</div>`);
                            }
                            $('#removeCode-modal .btnRemoveCodes').attr('disabled', 1);
                            $('#removeCode-modal table').fadeOut('slow');
                        }
                    }
                })

                loader.out();
                $('#removeCode-modal').modal('open');
            })

            $('.btnMandated').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');

                let name = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.name').html(),
                    lastName = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.lastName').html();

                $('#mandated-modal').find('.student-id').html(g_id);
                $('#mandated-modal').find('.student-name').html(lastName + ", " + name);

                loader.in();
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {getMandated: 1, id: g_id},
                    success: r => {
                        if (r != -1) {
                            $('#mandated-modal .row').html(r);
                            $('#mandated-modal').modal('open');
                        }else{
                            Materialize.toast("No posee un responsable registrado!", 2000);
                        }
                        loader.out();
                    }
                })
            })

            //ACCIONES PARA DOCENTE Y COORDINADOR
            $('.btnSchedule').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                stage[2]['schedule'](g_id);
            })

            $('.btnSubject').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                stage[2]['subject'](g_id);
            })

            //ACCIONES GENERALES
            $('.btnShow').click(function() {
                g_id = $(this).parent().parent().parent().attr('id');
                stage[2]['show'](g_id);
            });

            $('.btnEdit').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                stage[2]['edit'](g_id);
            })

            $('.btnDown').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                let name = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.name').html(),
                    lastName = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.lastName').html();

                $('#downModal').find('.code').html(g_id);
                $('#downModal').find('.fullName').html(lastName + ", " + name);
                $('#downModal').modal('open');
            })

            $('.btnUp').click(function(){
                g_id = $(this).parent().parent().parent().attr('id');
                let name = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.name').html(),
                    lastName = $(this).parent().parent().parent().children('.info').children('.data').children('.full-name').children('.lastName').html();

                $('#upModal').find('.code').html(g_id);
                $('#upModal').find('.fullName').html(lastName + ", " + name);
                $('#upModal').modal('open');
            })
        }else if($('.user-item').length == 0 && $('.user-row').length == 0){
            $('.btnPermission').click(function() {
                stage[2]['record'][1](g_id);
                back_2_i = 1;
                f = 0;
            });

            $('.btnJustify').click(function() {
                stage[2]['record'][2](g_id);
                back_2_i = 2;
                f = 0;
            });
        }
    }

    const sort_users = () => {
        users.sort((a, b) => {return ((a[attr] < b[attr]) ? -1 : ((a[attr] > b[attr]) ? 1 : 0));})
    }

    const search_user = (t, a, s, value, behaviour = null) => {
        $('.user-cont').html('<li class="user-row"></li>');
        sort_users();
        for (let i = 0; i < users.length; i++) {
            if (users[i][a].toLowerCase().indexOf(value.toLowerCase()) != -1) {
                if (t != 'all') {
                    if (users[i]['type'] == t) {
                        if (users[i].state == state) {
                            if (behaviour !== null) {
                                    if (users[i].stateAcademic == behaviour ) {
                                        show_user(users[i]);
                                    }
                            }else{
                                show_user(users[i]);
                            }
                            // console.log(`${i}: ${users[i].state} => ${state}}`);
                        }
                    }
                }else{
                    if (users[i].state == state) {
                        show_user(users[i]);
                    }
                }
                // bold_coincidence(users[i], value);
            }
        }
        $.getScript('../../files/js/init.js');
        initFunctions();
    }

    const search_section = (lvl, spcty, sctn) => {
        lvl = lvl || '';
        spcty = spcty || '';
        sctn = sctn || '';

        $('.user-cont').html('<li class="user-row"></li>');
        for (let i = 0; i < users.length; i++) {
            if (users[i]['type'] == 'S') {
                if( (lvl == '' || users[i]['level'] == lvl) && (spcty == '' || users[i]['idSpecialty'] == spcty) && (sctn == '' || users[i]['idSection'] == sctn) ){
                    show_user(users[i]);
                }
            }
        }
        $.getScript('../../files/js/init.js');
        initFunctions();
    }

    const get_user = (attr, value) => {
        let aux;
        users.forEach(function(el, i){
            if(el[attr] == value) aux = el;
        })
        return aux;
    }

    const show_user = (user) => {
        if (user.state == state) {
            if ($('.user-row').length == 0) {
                let user_row = document.createElement('li');    
                user_row.classList = 'user-row';
                user_row.innerHTML = (user.element);
                $('.user-cont').append(user_row);
            }else{
                if ($('.user-row' + (($('.user-row').length == 1) ? '' : ':last-child')).children().length > 1) {
                    let user_row = document.createElement('li');    
                    user_row.classList = 'user-row';
                    user_row.innerHTML = (user.element);
                    $('.user-cont').append(user_row);
                }else{
                    $('.user-row' + (($('.user-row').length == 1) ? '' : ':last-child')).append(user.element);
                }
            }
        }
    }

    const bold_coincidence = (user, value) => {
        if (value.length > 0) {
            let attr_element = $(`.user-item#${user.id}.${attr}`),
            // let attr_element = $('.user-item#' + user.id + " ." + attr ),
                oldS = (value).toLowerCase(),
                newS = "<b>" + (value).toUpperCase() + "</b>",
                fullS = toTitleCase(user[attr]);

            attr_element.html(((fullS.split(oldS).join(newS))));
            // console.log((fullS.split(oldS).join(newS)) + " -> " + fullS + " - " + oldS + " - " + newS);
        }
    }

    const updateInput = (t, a) => {
        let tAux, aAux;
        if (t == 'S') {tAux = "estudiante";}
        else if (t == 'T'){tAux = "docente";}
        else if (t == 'C'){tAux = "coodinador";}
        else{tAux = "usuario";}

        if (a == 'id') {aAux = "código";
        }else if (a == 'name'){aAux = "nombre";
        }else if (a == 'lastName'){aAux = "apellido";
        }else if(a == 'sectionIdentifier'){aAux = "sección";
        }else if(a == 'level'){aAux = "nivel";
        }else if(a == 'specialtyName'){aAux = "especialidad";}

        $('input#search').attr('placeholder', "Buscar " + tAux + " por " + aAux);
    }

    const toTitleCase = (str) => {
        return str.replace(/\w\S*/g, function(txt){return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();});
    }

    const initSearch = () => {

        $("#cmbLevel").empty();
        $("#cmbSpecialty").empty();
        $("#cmbSection").empty();
        $('#cmbBehaviourState').empty();

        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getLvls: 1},
            success: (r) => {
                if (r != -1) {
                    $('#cmbLevel').append(r);
                    $('select').material_select();
                }
            }
        })

        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {getAcademicState: 1},
            success: r => {
                if (r != -1) {
                    $('#cmbBehaviourState').append(r);
                    $('select').material_select();
                }
            }
        })

        $("#cmbLevel").html("<option selected disabled>Nivel</option>");
        $("#cmbSpecialty").html("<option selected disabled>Especialidad</option>");
        $("#cmbSection").html("<option selected disabled>Sección</option>");
        $('#cmbBehaviourState').html("<option selected disabled>Estado Conductual</option>");

        $('input[type="checkbox"]#search_section').prop('checked', false);
        $('input[type="checkbox"]#search_behaviour').prop('checked', false);
        $("#search").removeAttr('disabled');

        $('input[type=radio').each((i) => $('input[type=radio').eq(i).removeAttr('disabled'));
        $('select.section-search-i').each( (i) => {
            $('select.section-search-i').eq(i).attr('disabled', 1);
        });
        $('#cmbBehaviourState').attr('disabled', 1);

        $('form.search').submit( e => {
            return false;
        })

        $('input[name=filter_attr]').change(function() {
            attr = $("input[name=filter_attr]:checked").val();
            sort_users();
            updateInput(type, attr);
            search_user(type, attr, state, $('#search').val());
        });

        $('input[name=filter_type]').change(function() {
            type = $("input[name=filter_type]:checked").val();
            $('input[name=filter_attr].student').each((i) => {
                if (type == 'S') {
                    $('input[name=filter_attr].student').eq(i).removeAttr('disabled');
                }else{
                    $('input[name=filter_attr]').eq(0).prop('checked', 1);
                    attr = 'id';
                    $('input[name=filter_attr].student').eq(i).attr('disabled', 1);
                }
            })
            sort_users();
            updateInput(type, attr);
            search_user(type, attr, state, $('#search').val());
        });

        $("input[name=filterState]").change(function() {
            state = $(this).val();
            sort_users();
            updateInput(type, attr);
            search_user(type, attr, state, $('#search').val());
        })

        $('input[type="checkbox"]#search_section').change(() => {
            if($('input[type="checkbox"]#search_section').prop('checked')){
                $('input[type=radio').each((i) => $('input[type=radio').eq(i).attr('disabled', 1));
                $('select.section-search-i').each( (i) => $('select.section-search-i').eq(i).removeAttr('disabled'));
                $("#search").attr('disabled', 1);
                $('select').material_select();
                search_section($("#cmbLevel").val(), $("#cmbSpecialty").val(), $('#cmbSection').val());
            }else{
                $('input[type=radio').each((i) => $('input[type=radio').eq(i).removeAttr('disabled'));
                $('select.section-search-i').each( (i) => {
                    $('select.section-search-i').eq(i).attr('disabled', 1);
                });
                $("#search").removeAttr('disabled');
                search_user(type, attr, state, $('#search').val());
                $('select').material_select();
            }
        })

        $('input[type="checkbox"]#search_behaviour').change(function(){
            if ($(this).prop('checked')) {
                $('input[type=radio').each((i) => $('input[type=radio').eq(i).attr('disabled', 1));
                $('#cmbBehaviourState').removeAttr('disabled');
                $('select').material_select();
                search_user('S', attr, state, $('#search').val());
            }else{
                $('input[type=radio').each((i) => $('input[type=radio').eq(i).removeAttr('disabled'));
                $('#cmbBehaviourState').attr('disabled', 1); 
                search_user(type, attr, state, $('#search').val());
                $('select').material_select();
            }
        })

        $('#cmbLevel').change(() => {
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

        $('#cmbSpecialty').change(() => {
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

        $('#cmbSection').change(() => {
            search_section($("#cmbLevel").val(), $("#cmbSpecialty").val(), $("#cmbSection").val());
        })

        $('#cmbBehaviourState').change(function(){
            console.log($(this).val());
            search_user('S', attr, state, $('#search').val(), $(this).val());
        })

        $('#search').keyup(function() {
            search_user(type, attr, state, $(this).val());
            if ($('.user-item').length == 0) {
                $('.user-cont .user-row').append("<div class='alert_ red-text text-darken-4'>No se encontraron coincidencias</div>");
            }
        });
    }

    const initCodes = () => {
        $('#cmbCategory').html("<option selected disabled>Categoría</option>");
        $('#cmbType').html("<option selected disabled>Tipo</option>");
        $('#cmbCodes').html("<option selected disabled>Código</option>");
        $.ajax({
            url: "../../files/php/C_Controller.php",
            data: {getCodeOptions: 1},
            success: r => {
                let objCodes = JSON.parse(r);
                $('#cmbCategory').append(objCodes[0]);
                $('#cmbType').append(objCodes[1]);
                $('#cmbCodes').append(objCodes[2]);
                $('select').material_select();
            }
        })
    }

    $(document).on('click', '.btnApplyCode', function() {
        if (errorSelect($('#cmbCodes'))) {
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {
                    applyCode: 1, 
                    idCode: $('#cmbCodes option:selected').attr('idCode'), 
                    idStudent: g_id},
                success: r => {
                    if (r != -1) {
                        Materialize.toast((r) ? "El código ha sido aplicado con éxito!" : "Ha ocurrido un error...", 2000);
                        $('#applyCode').modal('close');
                    }else{
                        Materialize.toast("No existe ningún período registrado al cual asignar la aplicación del código!", 2000);
                    }
                }
            })
        }else{
            Materialize.toast('Seleccione un código!', 2000);
        }
    });

    $(document).on('click', '.btnRemoveCodes', function(){
        let ids = [];
        $('.checkRmvCode:checked').each(function(i, el){
            ids.push(el.getAttribute('idrecord'));
        })

        if (ids.length == 0) {
            Materialize.toast('Seleccione el código que desea remover!', 2000);
        }else{
            loader.in();
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {rmvCodes: 1, ids: ids},
                success: r => {
                    if (r) {
                        Materialize.toast((ids.length == 1 ? "El código ha sido removido con éxito!" : "Los códigos han sido removidos con éxito!"), 2000);
                    }else{
                        Materialize.toast('Ha ocurrido un error :(', 2000);
                    }

                    $('#removeCode-modal').modal('close');
                    loader.out();
                }
            })
        }
    })

    $(document).on('click', ".btnDelete", function(){
        if ($("#txtDownJustification").val().trim().length > 0) {
            loader.in()
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {userDown: 1, id: g_id, just: $("#txtDownJustification").val()},
                success: r => {
                    Materialize.toast(r ? "Se ha dado de baja éxitosamente!" : "Ha ocurrido un error!", 2000);
                    $('#downModal').modal('close');
                    loader.out();
                    stage[1]();
                }
            })
        }else{
            Materialize.toast("Ingrese un valor valido!", 2000);
        }
    })

    $(document).on('click', ".btnUpUser", function(){
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {userUp: 1, id: g_id},
            success: r => {
                Materialize.toast(r ? "Se ha dado de alta éxitosamente!" : "Ha ocurrido un error!", 2000);
                $('#upModal').modal('close');
                loader.out();
                stage[1]();
            }
        })
    })

    $(document).on('click', '.btnCloseFilter', function(){
        $('#options_slide').sideNav('hide');
    })

    $(document).ready(() => {
        loader = new Loader();
        stage[1]();

        $('#applyCode').modal({
            dismissible: true, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            inDuration: 300, // Transition in duration
            outDuration: 200, // Transition out duration
            startingTop: '4%', // Starting top style attribute
            endingTop: '10%', // Ending top style attribute
            ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                initCodes();
            },
            complete: function() { initCodes(); } // Callback for Modal close
        });

        $('#removeCode-modal').modal({
            complete: () => {
                $('#removeCode-modal table').fadeOut('slow');
                $('#removeCode-modal .alert_').remove();
            }
        });

        $('#mandated-modal').modal();
        $('#upModal').modal();
        $('#downModal').modal({
            ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
                $("#txtDownJustification").val(""); Materialize.updateTextFields();
            },
            complete: function() { $("#txtDownJustification").val(""); Materialize.updateTextFields();}
        });
        
        $('#cmbCategory').change(function(){
            $('#cmbCodes').html('<option selected disabled>Código</option>');
            let t = ($('#cmbType option:selected').attr('idtype') === undefined ? "" : $('#cmbType option:selected').attr('idtype'));
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {
                    getCodes: 1,
                    cat: $('#cmbCategory option:selected').attr('idcat'),
                    type: t
                },
                success: r => {
                    if (r != -1) {
                        $('#cmbCodes').append(r);
                    }else{
                        $('#cmbCodes').html('<option selected disabled>Código</option>');
                        Materialize.toast('No se encontraron coincidencias!', 2000);
                    }
                    $('select').material_select();
                }
            })
        })

        $('#cmbType').change(function(){
            $('#cmbCodes').html('<option selected disabled>Código</option>');
            let c = ($('#cmbCategory option:selected').attr('idcat') === undefined ? "" : $('#cmbCategory option:selected').attr('idcat'));
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {
                    getCodes: 1,
                    cat: c,
                    type: $('#cmbType option:selected').attr('idtype')
                },
                success: r => {
                    if (r != -1) {
                        $('#cmbCodes').append(r);
                    }else{
                        $('#cmbCodes').html('<option selected disabled>Código</option>');
                        Materialize.toast('No se encontraron coincidencias!', 2000);
                    }
                $('select').material_select();
                }
            })
        })

        $('.options_btn').sideNav({
            menuWidth: 350, // Default is 300
            edge: 'right', // Choose the horizontal origin
            closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
        });

        $('.info_btn').click(() => {
            $('.tap-target').tapTarget('open');
        })

        $('.btnBack').click(() => {
            if (f) {
                stage[--back_i]();
            }else{
                stage[back_i][stage_aux][(back_2_i > 0) ? 0 : back_2_i](g_id);
                f = 1;
            }
        })
    });

     /*            CÓDIGO PARA PERMISOS         */
        $(document).on("change", "#selectPermission", function(){
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    getSchedulePermission: 1,
                    student: g_id,
                    day: $("#selectPermission").val()
                }
            }).done(function(r){
                if (r == 0) {
                    $('main .schedule_permission').html("<div class='row search_error col s8 offset-s2'><div class='alert_ red-text text-darken-4'>Horario de día seleccionado no disponible</div></div>")
                }else{
                    $('main .schedule_permission').html(r);
                } 
                schedules_id.length = 0;
            });
        });
        $(document).on("change", ".btn_checkbox", function(){
            if($(this).prop("checked")){
                schedules_id[x] = {"id": $(this).attr("id")};
                x++;
            }else{
                removeIndex($(this).attr("id"), schedules_id);
                x--;
            }
        });
        function removeIndex(id, array){
            for (var i = 0; i < array.length; i++) {
                if (array[i].id == id) {
                    array.splice(i,1);
                }
            }
        }
        $(document).on("click", ".btnSavePermission", function(){
            var loader = new Loader();
            $("form.addPermission").validate({
                rules:{
                    justification:{
                        required: true,
                    }
                },
                messages:{
                    justification:{
                        required:'Ingrese una justificación'
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
                    if (errorSelect($("select#selectPermission"))) {
                        if (schedules_id.length > 0) {
                            loader.in();
                            let object = JSON.stringify(schedules_id);
                            $.ajax({
                                type: 'POST',
                                url: '../../files/php/C_Controller.php',
                                data:{
                                    newPermission: 1,
                                    student: g_id,
                                    date: $("#selectPermission").val(),
                                    justification: $("#justification").val(),
                                    permission: object
                                }
                            }).done(function(r){
                                // alert(r);
                                schedules_id.length = 0;
                                loader.out();
                                Materialize.toast('Permisos registrados con exito', 3000);
                                stage[1]();
                            });
                        }else{
                            Materialize.toast('No se han seleccionados horas', 3000);
                        }
                    }else{
                        Materialize.toast('Oh oh! Al parecer faltan campos por seleccionar', 3000);
                    }
                }
            });
        });
        $(document).on("click", ".btnAllPermission", function(){
            schedules_id.length = 0;
            for (var i = 0; i < $(".btn_checkbox").length; i++) {
                $(".btn_checkbox").eq(i).prop("checked", true);
                schedules_id[i] = $(".btn_checkbox").eq(i).attr("id");
            }
        });
    /*          FIN DE CODIGO PARA PERMISOS         */
    /*            CÓDIGO PARA JUSTIFICACIONES    */

        $(document).on("change", "#selectPeriodJustification", function(){
            loader.in();
            $.ajax({
                type: 'POST',
                url: '../../files/php/C_Controller.php',
                data:{
                    get_assistance: 1,//,
                    student: g_id,
                    period: $(this).val()
                }
            }).done(function(r){
                $('main .container-justification').html(r);
                $('select').material_select();
                loader.out();
            });
        });

        $(document).on("change", ".btn_checkbox_J", function(){
            if($(this).prop("checked")){
                justification_id[x] = {"id": $(this).attr("id")};
                x++;
            }else{
                removeIndex($(this).attr("id"), justification_id);
                x--;
            }
        });

        $(document).on("click", ".btnSaveJustification", function(){
            $("form.justification").validate({
                rules:{
                    justification:{
                        required: true,
                    }
                },
                messages:{
                    justification:{
                        required:'Ingrese una justificación'
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
                    if (justification_id.length > 0) {
                        loader.in();
                        let object = JSON.stringify(justification_id);
                        $.ajax({
                            type: 'POST',
                            url: '../../files/php/C_Controller.php',
                            data:{
                                newJustification: 1,
                                justification: $("#justification").val(),
                                id_justification: object
                            }
                        }).done(function(r){
                            // alert(r);
                            justification_id.length = 0;
                            loader.out();
                            Materialize.toast('Justificaciones registradas', 3000);
                            stage[1]();
                        });
                    }else{
                        Materialize.toast('No se han seleccionados inasistencias', 3000);
                    }
                }
            });
        });
    /*          FIN CÓDIGO PARA JUSTIFICACIONES    */
})()