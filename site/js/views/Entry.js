import React, { PropTypes } from 'react'

import Categories from '../components/Categories'; 

export default class Entry extends React.Component {

	constructor(props) {
		super(props)
		this.state = {
			entry: [],
			loading_entry: false,
			categories: [],
			loading_categories: false
		}
	}

	componentDidMount(){
		this.getEntry()
		this.getCategories()
	}

	getEntry(){		
		var self = this;
		this.setState({loading_entry: true})

        $.ajax({
			type: 'GET',
			url: global.baseURL+'entries/get/'+this.props.entryid
		}).then( 
            response => {
                self.setState({entry: response, loading_entry: false})
            }
        )
	}

	getCategories(){
		var self = this
		this.setState({loading_categories: true})

		console.log(this.props)

        $.ajax({
			type: 'GET',
			url: global.baseURL+'/categories/get_by_entry/'+this.props.entryid
		}).then( 
            response => {
                self.setState({categories: response, loading_categories: false})
            }
        )
	}

	isLoading(){
		return (this.state.loading_entries)
	}

	render() {
		console.log(this.state);

		if( !this.state.entry ) return null
		var entry = this.state.entry

		return(
			<div className="entry-view single-entry">

				<div className="content">
					
					{entry.Image ? <img src={entry.Image} /> : <span></span>}

					<h1>{entry.Title}</h1>
					<p>{entry.Content}</p>

				</div>

				<aside>
					<p>{entry.Date}</p>
					<a className="button productive" href={'/entries/edit/'+entry.ID}>Edit entry</a>
					<Categories 
						records={this.state.categories} 
						loading={this.isLoading()} />
				</aside>

			</div>
		);
	}

/*
{<Categories i={i} categories={this.state.categories} />}
 */

/*
	handleEdit(e){
		this.setState({editing_record: this.state.website})
	}

	handleClose(e){
		this.setState({editing_record: null});
	}

	handleSave(e, record){
		var self = this
		this.setState({working: true})

        $.ajax({
			type: 'POST',
			url: global.baseURL+'websites/save/'+record.ID,
            data: JSON.stringify(record),
		}).then(
			response => {
				self.setState({editing_record: null, working: false, website: response})
	        }
        )
	}

	handleSync(e){
		var self = this
        self.setState({syncing: true})

        $.ajax({
			type: 'GET',
			url: global.baseURL+'websites/sync/'+this.props.id
		}).then( 
            response => {
                self.setState({website: response, syncing: false})
            }
        )
	}

	handleDelete(e){
		var self = this
		this.setState({working: true})

        $.ajax({
			type: 'GET',
			url: global.baseURL+'websites/delete/'+this.props.id
		}).then( 
            response => {
            	website = self.state.website
            	website.IsDeleted = 1
                self.setState({website: website, working: false})
            }
        )
	}*/


}