import React, { PropTypes } from 'react'

export default class Categories extends React.Component {
	
	constructor(props) {
		super(props)

		this.state = {
			records: []
		}
	}

	render(){
		var self = this;
		var records = this.props.records;

		return (
			<div>
				{
					records.map(record => {
						return (
							<span className={'category ' + record.URLTitle} key={record.ID}></span>
						)
					})
				}
			</div>
		)
	}

}