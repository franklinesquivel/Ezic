$(document).ready(function() {
	const loader = new Loader();
    $('.info_btn').click(function(){
        $('.tap-target').tapTarget('open');
    });

    $('a.showTeacher').click(function(){
    	loader.in();
    	$('main').fadeOut('slow');
    	$.ajax({
    		url: '../../files/php/C_Controller.php',
    		data: {showTeacher: 1, id: $(this).html()},
    		success: r => {
    			// console.log(r);
    			$('.btnBack').removeAttr('disabled');
    			$('main').html(r);
    			$('main').fadeIn('slow', loader.out());
    		}
    	})
    })

    $('.btnBack').click(function(){
    	location.reload();
    })
});