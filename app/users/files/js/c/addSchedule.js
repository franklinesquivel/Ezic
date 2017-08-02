$(document).ready(function(){

    class Schedule_Info {
        constructor(idT, st, et, d, nh, idSn, idSt){
            this.idTeacher = idT,
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

    var loader = new Loader();

    var days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

    if (!($('.userCollection').length) && !($('table.schedule').length) ) {
        // console.log('1er');
        var msg = "No se encontraron registros de docentes sin horarios asignados...";
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {fillTeachers_Add: 1},
            success: function(r){
                if (r != -1) {
                    $('#teacher_cont').html(r);
                    $.getScript('../../files/js/c/addSchedule.js');
                }else{
                    $('#teacher_cont').html("<div class='alert_ red-text text-darken-4'>" + msg + "</div>");
                }
                $('body main').fadeIn('slow');
                loader.out();
            }
        })
    }else if(($('.userCollection').length) && (!($('table.schedule').length))){
        // console.log('2do');
        $('.userCollection .collection-item').click(function(){
            var id = $(this).attr('id');
            loader.in();
            $('main').fadeOut('slow');
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {newTSchedule: 1, id: id},
                success: function(r){
                    // console.log(r)
                    $('main').html("<table id='" + id + "' class='striped bordered responsive-table centered schedule'><thead><tr><th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr></thead><tbody></tbody></table><br><br><center><div class='btn waves-effect waves-light btnSave black'>Guardar<i class='material-icons right'>save</i></div></center></div><br><br>")
                    $('table.schedule tbody').html(r);
                    $.getScript('../../files/js/init.js');
                    $.getScript('../../files/js/c/addSchedule.js');
                    $('main').fadeIn('slow');
                    loader.out();
                }
            })
        })
    }

    if (($('table.schedule').length) && !($('.userCollection').length)) {

        for (var i = 0; i < hours.length; i++) {
            for (var j = 0; j < days.length; j++) {
                $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option').each(function(){
                    if ($(this).attr('unavailable') !== undefined) {
                        $(this).parent().parent().children('ul').children('li').eq($(this).index()).children('span').addClass('red red-text text-darken-4');
                        $(this).parent().parent().children('ul').children('li').eq($(this).index()).children('span').attr('title', 'No es posible seleccionar la sección porque ya posee una materia asignada a esta hora...');
                    }
                })
            }
        }

        $('.btnSave').click(function(){
            var dataArray = [];

            for (var i = 0; i < hours.length; i++) {
                for (var j = 0; j < days.length; j++) {
                    var idT = $('table.schedule').attr('id'),
                        st = hours[i][0],
                        et = hours[i][1],
                        day = days[j],
                        nth_Hour = i + 1,
                        idSn = $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('section'),
                        idSt = $('tr[hour=' + (i + 1) + '] > td[day=' + (j) + '] select > option:selected').attr('subject');

                    // console.log( st + ' <> ' + et + ' <> ' + day + ' <> ' + nth_Hour + ' <> ' + idSn + ' <> ' + idSt );
                    if (idSn !== undefined) {
                        dataArray.push(new Schedule_Info(idT, st, et, day, nth_Hour, idSn, idSt));
                    }
                }
            }

            if (dataArray.length <= 0) {
                Materialize.toast('Debe ingresar por lo menos un registro!', 2000);
            }else {
                $(this).attr('disabled', 1);
                loader.in();
                $.ajax({
                    url: '../../files/php/C_Controller.php',
                    data: {saveData: 1, scheduleInfo: JSON.stringify(dataArray)},
                    success: function(r){
                        loader.out();
                        if ( parseInt(r) != 0 ) {
                            Materialize.toast('El horario ha sido asignado éxitosamente al docente!', 2000, '', function(){
                                location.reload();
                            })
                        }else{
                            Materialize.toast('Ha ocurrido un error!', 2000, '', function(){
                                console.log(r);
                                $(this).attr('disabled', 0);
                            })
                        }
                    }
                })
            }
        })

    }
})
