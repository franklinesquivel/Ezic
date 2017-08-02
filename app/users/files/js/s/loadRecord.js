(() => {

	var loader = new Loader();

	$(document).ready(() => {
		loader.in();
		$.ajax({
			url: '../../files/php/S_Controller.php',
			data: {getRecord: 1},
			success: r => {
				$('main').html(r);
	            $('thead tr th').each(function() {
	                $(this).css('border', '1px solid ' + $(this).parent().css('background-color'));
	            });

	            $('tbody tr').each(function() {
	                $(this).css({
	                    'border-left': '1px solid ' + $(this).parent().parent().children().children().css('background-color'),
	                    'border-right': '1px solid ' + $(this).parent().parent().children().children().css('background-color'),
	                    'border-bottom': '1px solid ' + $(this).parent().parent().children().children().css('background-color')
	                })
	            });
				$('main').fadeIn('slow', loader.out());
			}
		})
		
		$('.btnPrint').click(function() {
			$("#print").submit();
		})
	})
})()