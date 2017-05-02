import React, { PropTypes } from 'react'
import FontAwesome from 'react-fontawesome'

import Event from './Event';

export default class Timeline extends React.Component {

	constructor(props) {
		super(props)
		this.state = {
			entries: [],
			loading_entries: false
		}
	}

	componentDidMount(){
		this.getEntries()
	}

	getEntries(){		
		var self = this
		this.setState({loading_entries: true})

        $.ajax({
			type: 'GET',
			url: global.baseURL+'entries/get_categorised'
		})
		.then(response => {
            self.setState({entries: response, loading_entries: false})
        })
		.fail(response => {
            self.setState({loading_entries: null})
			helpers.createNotification(response.responseJSON.message,'bad')
        })

	}

	isLoading(){
		return (this.state.loading_entries)
	}

	render(){
		console.log(this.state.entries);
		return(
			<div>
				<div className="events cf">
					<div className="line"></div>

					<Event
						records={this.state.entries}
						loading={this.isLoading()} />

				</div>

			</div>
		);
	}
}