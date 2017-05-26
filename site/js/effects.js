
function NavExpand() {
	$('.navToggle').click(function() {
		$('aside.sidebar, main').toggleClass('closed');
	});

	if( $(window).width() < 800 ) {
		$('aside.sidebar, main').addClass('closed');
	}
}


$(document).ready( function() {
	NavExpand();

});