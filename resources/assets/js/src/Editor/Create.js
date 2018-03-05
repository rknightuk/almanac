// @flow

import React, { Component } from 'react'
import { withRouter } from 'react-router-dom'
import axios from 'axios'

import Editor from './Editor'
import type { Post, PostTypes } from '../types'

type Props = {
	match: {
		params: {
			type: PostTypes,
		},
	},
	history: any,
}

type State = {
	saving: boolean,
}

class Create extends Component<Props, State> {

	props: Props

	state: State = {
		saving: false,
	}

	render() {
		return (
			<Editor
				onSave={this.handleSave}
				type={this.props.match.params.type}
				saving={this.state.saving}
			/>
		)
	}

	handleSave = async (post: Post) => {
		this.setState((s: State) => ({
			saving: true,
		}))

		await axios.post('/api/posts', post)

		this.setState((s: State) => ({
			saving: false,
		}))

		this.props.history.push(`/app`)
	}
}

export default withRouter(Create)