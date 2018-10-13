// @flow

import React, { Component } from 'react'
import { withRouter } from 'react-router-dom'
import axios from 'axios'

import { toast } from 'react-toastify'

import Editor from './Editor'
import Loader from '../ui/Loader'
import type { Post, PostTypes } from '../types'
import moment from 'moment/moment'
import SearchModal from '../SearchModal'

type Props = {
	match: {
		params: {
			type: PostTypes,
			id?: number | string,
		},
	},
	history: any,
}

type State = {
	saving: boolean,
	post: any,
	loading: boolean,
	showSearch: boolean,
}

class Create extends Component<Props, State> {

	props: Props

	state: State = {
		saving: false,
		post: null,
		loading: true,
		showSearch: false,
	}

	componentDidMount() {
		this.fetchPost()
		this.showSearch()
	}

	showSearch = () => {
		if (!this.props.match.params.id && window.AlmanacSearch[this.props.match.params.type]) {
			this.setState({
				showSearch: true,
			})
		}
	}

	hideSearch = () => {
		this.setState({
			showSearch: false,
		})
	}

	fetchPost = async () => {
		if (!this.props.match.params.id) {
			this.setState({ loading: false })
			return
		}

		const response = await axios.get(`/api/posts/${this.props.match.params.id}`)

		if (response.data === '') {
			this.setState({ loading: false })
			return
		}

		this.setState({
			loading: false,
			post: {
				...response.data,
				id: null,
				content: {
					text: '',
				},
				date_completed: moment(),
				tags: response.data.tags.map(t => t.name.en),
			},
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

		return (
			<React.Fragment>
				{this.state.showSearch && (
					<SearchModal
						type={this.props.match.params.type}
						onClose={this.hideSearch}
					/>
				)}
				<Editor
					onSave={this.handleSave}
					type={this.props.match.params.type}
					saving={this.state.saving}
					post={this.state.post}
					isNew
					showSearch={this.showSearch}
				/>
			</React.Fragment>
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

		toast.success('Post Created')

		this.props.history.push(`/app`)
	}
}

export default withRouter(Create)
