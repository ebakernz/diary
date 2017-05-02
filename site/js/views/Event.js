import React, { PropTypes } from 'react'
import FontAwesome from 'react-fontawesome'

import Categories from '../components/Categories';

export default class Event extends React.Component {

	constructor(props) {
		super(props)
		this.state = {
			records: []
		}
	}

	render(){
		
		var self = this;
		var records = this.props.records;

		if (records.length < 1 ) return <div className="no-results">No entries</div>;

		return(
			<div>
				{
					records.map(record => {
						const toggle = record.ID % 2 === 0;
						let oddEvent = null;
						if(toggle) {
							oddEvent = 'even';
						} else {
							oddEvent = 'odd';
						}

						return (							
							<a className={'event ' + oddEvent} href={record.Link} key={record.ID}>
								<div className="dot"></div>								
								<div className="content">
									{record.Image ? <img className="thumbnail" src={record.Image} /> : <span></span>}
									<div className="categories">
										<Categories records={record.Categories} />
									</div>						
									<p><strong>{record.Title}</strong></p>
									<div className="triangle"></div>
								</div>
							</a>
						)
					})
				}
			</div>
		);
	}
}