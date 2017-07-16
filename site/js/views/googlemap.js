
// This example requires the Drawing library. Include the libraries=drawing
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">

// https://developers.google.com/maps/documentation/javascript/drawinglayer
// https://developers.google.com/maps/documentation/javascript/examples/drawing-tools

function initMap() {

	var map = new google.maps.Map(document.getElementById('map'), {
	  center: {lat: -28.539241, lng: 150.298253},
	  zoom: 13
	});

	var drawingManager = new google.maps.drawing.DrawingManager({
	  drawingMode: google.maps.drawing.OverlayType.MARKER,
	  drawingControl: true,
	  drawingControlOptions: {
	    position: google.maps.ControlPosition.TOP_CENTER,
	    drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
	  },
	  markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
	  circleOptions: {
	    fillColor: '#ffff00',
	    fillOpacity: 1,
	    strokeWeight: 5,
	    clickable: false,
	    editable: true,
	    zIndex: 1
	  }
	});
	drawingManager.setMap(map);

	/*google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
		if (event.type == 'polygon') {
			var radius = event.overlay.getRadius();
		}
	});*/

}

$(document).ready( function() {
	initMap();

});