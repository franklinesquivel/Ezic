$(document).ready(function(){
    $('.btnInfo').click(function(){
        $('.tap-target').tapTarget('open');
    });
    
    var loader = new Loader();
    
    loader.in();
    $.ajax({
        url: '../../files/php/T_Controller.php',
        data: {loadSchedule: 1},
        success: (r) => {
            if (r == -1) {
                $('main').html("<br><div class='container alert_ red-text text-darken-4'>No posees un horario asignado</div>");
            }else{
                $('main').html("<br><div class='container'><table class='centered'><thead><th>Hora</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></thead><tbody class='scheduleCont'></tbody></table></div><br>");
                $('main table tbody').html(r);
            }
            $('main').fadeIn('slow', loader.out());
        }
    })

    $('.btnPrint').click(() => {
        $('#print').submit();
    })
})
