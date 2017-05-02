import React, { PropTypes } from 'react'
import FontAwesome from 'react-fontawesome'

import Categories from '../components/Categories'; 

export default class Entries extends React.Component {

	constructor(props) {
		super(props)

		this.state = {
			records: [],
			editing_record: false,
			working: false,
			sort_value: 'Title',
			sort_reverse: false
		}
	}

	render(){

		var self = this;
		var records = this.props.records;

		if (records.length < 1 ) return <div className="no-results">No entries</div>;

		return(
			<div>
				<div className="grid entries-grid">				
					{
						records.map(record => {
							return (
								<a href={record.Link} className="entry-summary grid-item" key={record.ID}>

									<div className="categories">
										<Categories records={record.Categories} />
									</div>

									<div className="entry-image">
										{record.Image ? <img src={record.Image} /> : <span></span>}
									</div>

									<div className="liner">
										<h3>{record.Title}</h3>
										<p>{record.SummaryText}</p>
									</div>
								</a>
							)
						})
					}
				</div>

				{this.state.editing_record ? <Modal record={this.state.editing_record} close={e => this.handleClose(e)} save={(e,record) => this.handleSave(e, record)} delete={(e,record) => this.handleDelete(e, record)} /> : null}

			</div>
		);

	}
}