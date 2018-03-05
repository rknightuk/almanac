// @flow

import React, { Component } from 'react'
import { withRouter } from 'react-router-dom'
import axios from 'axios'

import Editor from './Editor'
import type { Post } from '../types'
import type { PostTypes } from '../Dashboard'

type Props = {
	match: {
		params: {
			type: PostTypes,
		},
	},
	history: any,
}

class Create extends Component<Props> {

	render() {
		return (
			<Editor
				onSave={this.handleSave}
				type={this.props.match.params.type}
			/>
		)
	}

	handleSave = async (post: Post) => {
		await axios.post('/api/posts', post)

		this.props.history.push(`/app`)
	}
}

export default withRouter(Create)