
// Compile our scss
// This 'includes' the SCSS index file which webpack then reads and 
// compiles into the necessary css files
require('../scss/index.scss');

// include our components and site elements
require('./views/entry.js');

// set our API baseURL
global.baseURL = '/home/api/';

// import react
import React, { PropTypes } from 'react';
import ReactDOM from 'react-dom';


// import components

// import views
import Entries from './components/Entries';


if ($(document).find('#entries').length > 0){
	var element = $(document).find('#entries');
	ReactDOM.render(
		<Entries entryid={element.data('entryid')}/>,
		document.getElementById('entries')
	);
}