
// Compile our scss
// This 'includes' the SCSS index file which webpack then reads and 
// compiles into the necessary css files
require('../scss/index.scss');

// include general effects
require('./effects.js');

require('./views/masonry.js');
require('./views/googlemap.js');

// set our API baseURL
global.baseURL = '/api/';

// import react
import React, { PropTypes } from 'react';
import ReactDOM from 'react-dom';


// import components


// import views
import Entry from './views/Entry';
import Entries from './views/Entries';
import Timeline from './views/Timeline';

/*
	Single record views
 */

if ($(document).find('#entry').length > 0){
	var element = $(document).find('#entry');
	ReactDOM.render(
		<Entry entryid={element.data('id')}/>,
		document.getElementById('entry')
	);
}


/*
	Group record views
 */

if ($(document).find('#entries').length > 0){
	var element = $(document).find('#entries');
	ReactDOM.render(
		<Entries />,
		document.getElementById('entries')
	);
}

if( $(document).find('#timeline').length > 0 ) {
	var element = $(document).find('#timeline');
	ReactDOM.render(
		<Timeline timelineid={element.data('timelineid')}/>,
		document.getElementById('timeline')
	);
}