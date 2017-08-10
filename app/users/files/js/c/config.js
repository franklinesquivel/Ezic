(() => {
	var loader;
	$(document).ready(function(){
		$('main').fadeOut('slow');
		loader = new Loader();
		loader.in();
		$.ajax({
			url: '../../files/php/C_Controller.php',
			data: {newForm: 1},
			success: r => {
				$('main').html(r);
				$.getScript('../../files/js/c/modify_user_data.js');
				$.getScript('../../files/js/init.js');
				$('main').fadeIn('slow', loader.out());
			}
		})
	})
})()