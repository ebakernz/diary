import React, { PropTypes } from 'react';
import Entries from '../components/Entries';

export default class extends React.Component {
	
	constructor(props) {
		super(props)
		this.state = {
			entries: [],
			loading_entries: false,
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
			url: global.baseURL+'entries/get'
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

		return (
			<div>
				<h1>Entries</h1>

				<Entries 
					records={this.state.entries}
					loading={this.isLoading()}
					update={records => this.setState({entries: records})} />
			
			</div>
		)
	}

}