(() => {


	$(document).ready(function(){
		$(window).scroll(function(){
			let titleCont = $('.content .title-cont .title'),
			titleHeight = titleCont.height(),
			titleMargin = parseFloat(titleCont.css("margin-top")),
			stopPoint = parseInt($(document).height() - $('footer').height() - ($('.titleHelp').height() / 2) - ($(this).height() / 2));

			if ($(this).scrollTop() < stopPoint) {
				titleCont.css("margin-top", `${$(this).scrollTop() * 1}px`);
			}
		})

	})

})()