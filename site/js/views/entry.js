import Masonry from 'masonry-layout';

$(document).ready( function() {

	var checkExist = setInterval(function() {

		if( $('.grid .grid-item').length ) {
			
			var grid = new Masonry( '.grid', {
				itemSelector: '.grid-item'
			});

			clearInterval(checkExist);
		}

	}, 100); // check every 100ms

});