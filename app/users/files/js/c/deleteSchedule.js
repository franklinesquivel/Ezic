$(document).ready(function(){

    var loader = new Loader(),
        id;
    $('.modal').modal();
    // $('.modal').css('max-height', '32%');

    if (!($('.userCollection').length)) {
        // console.log('1er');
        var msg = "No se encontraron registros de docentes con horarios asignados";
        loader.in();
        $.ajax({
            url: '../../files/php/C_Controller.php',
            data: {fillTeachers_Edit: 1},
            success: function(r){
                if (r != -1) {
                    $('#teacher_cont').html(r);
                    $.getScript('../../files/js/c/deleteSchedule.js');
                }else{
                    $('#teacher_cont').html("<div class='alert_ red-text text-darken-4'>" + msg + "</div>");
                }
                loader.out();
                $('main').fadeIn('slow');
            }
        })
    }else if(($('.userCollection').length)){
        // console.log('2do');
        $('.userCollection .collection-item').click(function(){
            id = $(this).attr('id');
            $('#confirmModal').modal('open');
        })

        $('#confirmModal .btnDelete').click(function(){
            $('#confirmModal').modal('close');
            loader.in();
            $.ajax({
                url: '../../files/php/C_Controller.php',
                data: {deleteSchedule: 1, id: id},
                success: function(r){
                    loader.out();
                    Materialize.toast((r) ? "El horario ha sido eliminado con éxito!" : "Ha ocurrido un error...", 2000, '', function(){
                        location.reload();
                    })
                }
            })
        })

        $('#confirmModal .btnCancel').click(function(){
            $('#confirmModal').modal('close');
        })
    }

})
