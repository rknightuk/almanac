// @flow

import React, { Component } from 'react'
import { withRouter } from 'react-router-dom'
import axios from 'axios'

import { toast } from 'react-toastify'

import Editor from './Editor'
import Loader from '../ui/Loader'
import type { Post } from '../types'

import moment from 'moment'

type Props = {
	match: {
		params: {
			id: number,
		},
	},
	history: any,
}

type State = {
	loading: boolean,
	post: Post,
	saving: boolean,
	notFound: boolean,
}

class Update extends Component<Props, State> {

	props: Props

	state: State = {
		loading: true,
		post: {},
		saving: false,
		notFound: false,
	}

	componentDidMount() {
		this.fetchPost()
	}

	fetchPost = async () => {
		const response = await axios.get(`/api/posts/${this.props.match.params.id}`)

		if (response.data === '') {
			this.setState({
				notFound: true,
				loading: false,
			})
			return
		}

		this.setState({
			post: {
				...response.data,
				content: {
					text: response.data.content,
				},
				date_completed: moment.utc(response.data.date_completed),
				tags: response.data.tags.map(t => t.name.en),
			},
			loading: false,
		})
	}

	render() {

		if (this.state.loading) {
			return (
				<Loader
					text="Loading Post"
				/>
			)
		}

		if (this.state.notFound) {
			return (
				<div>Post not found</div>
			)
		}

		return (
			<Editor
				onSave={this.handleSave}
				post={this.state.post}
				saving={this.state.saving}
			/>
		)
	}

	handleSave = async (post: Post) => {
		this.setState((s: State) => ({
			saving: true,
		}))

		await axios.put(`/api/posts/${this.props.match.params.id}`, post)

		this.setState((s: State) => ({
			saving: false,
		}))

		toast.success('Post Updated')

		this.props.history.push('/app')
	}
}

export default withRouter(Update)
