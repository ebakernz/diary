import React, { PropTypes } from 'react'
import FontAwesome from 'react-fontawesome'

export default class Entries extends React.Component {

	constructor(props) {
		super(props)
		this.state = {
			entries: []
		}
	}


	componentDidMount(){
		this.getEntries()
	}

	getEntries() {
		var self = this;

		$.ajax({
			type: 'GET',
			url: global.baseURL+'entries'
		}).then(
			response => {
				self.setState({entries: JSON.parse(response)})
			}
		)
	}

	render(){

		if (!this.state.entries) return <div className="no-results">No entries</div>
		
		return(
			<div>
				<div className="grid entries-grid">				
					{
						this.state.entries.map(entry => {
							return (
								<a href={entry.Link} className="entry-summary grid-item" key={entry.ID}>
									<div className="entry-image"><img src={entry.Image} /></div>
									<div className="liner">
										<h3>{entry.Title}</h3>
										<p>{entry.SummaryText}</p>
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