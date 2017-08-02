$(document).ready(function(){

    class Schedule_Info {
        constructor(idT, idR, st, et, d, nh, idSn, idSt){
            this.idTeacher = idT;
            this.idS_Register = idR;
            this.start_time = st;
            this.end_time = et;
            this.day = d;
            this.nth_Hour = nh;
            this.idSection = idSn;
            this.idSubject = idSt;
        }
    };

var hours = [
        [['7:00'], ['7:45']],
        [['7:45'], ['8:30']],
        [['8:50'], ['9:35']],
        [['9:35'], ['10:20']],
        [['10:40'], ['11:25']],
        [['11:25'], ['12:10']],
        [['13:05'], ['13:50']],
        [['13:50'], ['14:35']],
        [['14:50'], ['15:35']],
        [['15:35'], ['16:15']],
    ];

    var days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

    var loader = new Loader();

    if (!($('.userCollection').length) && !($('table.schedule').length) ) {
        // console.log('1er');
        var msg = "No se encontraron registros de docentes con horarios asignados";
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {fillTeachers_Edit: 1},
            success: function(r){
                if (r != -1) {
                    $('#teacher_cont').html(r);
                    $.getScript('../../files/js/c/modifySchedule.js');
                }else{
                    $('#teacher_cont').html("<div class='alert_ red-text text-darken-4'>" + msg + "</div>");
                }
                $('main').fadeIn('slow');
                loader.out();
            }
        })
    }else if(($('.userCollection').length) && (!($('table.schedule').length))){
        // console.log('2do');
        $('.userCollection .collection-item').click(function(){
            loader.in();
            $('main').fadeOut('slow');

            var id = $(this).attr('id');
            var table = "<table id='" + id + "' class='striped bordered responsive-table centered schedule'><thead><tr><th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr></thead><tbody></tbody></table><br><br><center><div class='btn waves-effect waves-light btnSave black'>Guardar Cambios<i class='material-icons right'>save</i></div></center></div><br><br>";
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {editTSchedule: 1, id: id},
                success: function(r){
                    // console.log(r);
                    $('main').html(table);
                    $('table.schedule tbody').html(r);
                    $.getScript('../../files/js/init.js');
                    $.getScript('../../files/js/c/modifySchedule.js');
                    $('main').fadeIn('slow');
                    loader.out();
                }
            })
        })
    }else if(($('table.schedule').length) && !($('.userCollection').length)){
        var f = 0,
            c = 0;

        for (var i = 0; i < hours.length; i++) {
            for (var j = 0; j < days.length; j++) {
                $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option').each(function(){
                    if ($(this).attr('unavailable') !== undefined) {
                        $(this).parent().parent().children('ul').children('li').eq($(this).index()).children('span').addClass('red red-text text-darken-4');
                        $(this).parent().parent().children('ul').children('li').eq($(this).index()).children('span').attr('title', 'No es posible seleccionar la sección porque ya posee una materia asignada a esta hora...');
                    }
                })
                if ($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('section') !== undefined) {
                    c++;
                }
            }
        }

        $('select').change(function(){
            f = 1;
        })

        $('.btnSave').click(function(){
            if (f) {
                $(this).attr('disabled', 1);
                var dataUpdateArray = [],
                    dataAddArray = [],
                    dataDeleteArray = [];

                for (var i = 0; i < hours.length; i++) {
                    for (var j = 0; j < days.length; j++) {
                        var idT = $('table.schedule').attr('id'),
                            st = hours[i][0],
                            et = hours[i][1],
                            day = days[j],
                            nth_Hour = i + 1,
                            idSn = $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('section'),
                            idSt = $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('subject');

                        //Añadir registros
                        if($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('subject') !== undefined){
                            if (($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('register') === undefined) && ($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('update') === undefined) && ($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('delete') === undefined)) {
                                // console.log('Añadir -> Hora: ' + (i+1) + ', Día: ' + days[j]);
                                dataAddArray.push(new Schedule_Info(idT, 0, st, et, day, nth_Hour, idSn, idSt));
                            }
                        }

                        //Modificar registros
                        if($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('update') !== undefined){
                            var registerId;
                            $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option').each(function(){
                                if ($(this).attr('register') !== undefined) {
                                    registerId =  $(this).attr('register');
                                    // console.log('Modificar -> Hora: ' + (i+1) + ', Día: ' + days[j] + ', ID: ' + $(this).attr('register'));
                                }
                            })
                            dataUpdateArray.push(new Schedule_Info(idT, registerId, st, et, day, nth_Hour, idSn, idSt));
                        }

                        //Borrar registros
                        if($('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('delete') !== undefined){
                            var registerId, sectionId;
                            $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option').each(function(){
                                if ($(this).attr('register') !== undefined) {
                                    registerId = $(this).attr('register');
                                    sectionId = $(this).attr('section');
                                    // console.log('Borrar -> Hora: ' + (i+1) + ', Día: ' + days[j] + ', ID: ' + $(this).attr('register'));
                                }
                            })
                            dataDeleteArray.push(new Schedule_Info(idT, registerId, st, et, day, nth_Hour, sectionId, idSt));
                        }
                    }
                }

                if (dataAddArray.length <= 0 && dataUpdateArray.length <= 0 && dataDeleteArray.length <= 0) {
                    Materialize.toast('No se ha registrado ningún cambio', 2000);
                }else {
                    if ( dataDeleteArray.length == c ) {
                        Materialize.toast('No puedes eliminar todos los registros!', 2000);
                    }else{
                        var af = 0;
                        // console.log('Añadir -> ' + dataAddArray.length);
                        // console.log('Modificar -> ' + dataUpdateArray.length);
                        // console.log('Borrar -> ' + dataDeleteArray.length);
                        loader.in();
                        $.ajax({
                            url: '../../files/php/C_Controller.php',
                            data: {updateData: 1, scheduleInfo: JSON.stringify(dataUpdateArray)},
                            success: function(r){
                                af = parseInt(r);
                            }
                        })

                        $.ajax({
                            url: '../../files/php/C_Controller.php',
                            data: {deleteData: 1, scheduleInfo: JSON.stringify(dataDeleteArray)},
                            success: function(r){
                                // af = parseInt(r);
                                console.log(r);
                            }
                        })

                        $.ajax({
                            url: '../../files/php/C_Controller.php',
                            data: {addData: 1, scheduleInfo: JSON.stringify(dataAddArray)},
                            success: function(r){
                                af = parseInt(r);

                                loader.out();
                                Materialize.toast((af) ? "Los cambios se han guardado con éxito!" : "Ha ocurrido un error", 1000, '', function(){
                                    location.reload();
                                })
                            }
                        })
                    }
                }

            }else {
                Materialize.toast('No se ha registrado ningún cambio', 2000);
            }
        })
    }

});
