// @flow

import React from 'react'
import { withRouter } from 'react-router-dom'
import axios from 'axios'

import { toast } from 'react-toastify'

import Editor from './Editor'
import Loader from 'src/ui/Loader'
import type { Post, PostTypes } from 'src/types'
import moment from 'moment'

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
}

class Create extends React.Component<Props, State> {
	props: Props

	state: State = {
		saving: false,
		post: null,
		loading: true,
	}

	componentDidMount() {
		this.fetchPost()
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
				content: '',
				date_completed: moment(),
				tags: response.data.tags.map((t) => t.name.en),
			},
		})
	}

	render() {
		if (this.state.loading) {
			return <Loader text="Loading Post" />
		}

		return (
			<Editor
				onSave={this.handleSave}
				type={this.props.match.params.type}
				saving={this.state.saving}
				post={this.state.post}
				isNew
			/>
		)
	}

	handleSave = async (post: Post, newAttachments: any[]) => {
		this.setState((s: State) => ({
			saving: true,
		}))

		const formData = new FormData()

		newAttachments.forEach((nu) => {
			formData.append('file[]', nu.file)
		})
		formData.append('post', JSON.stringify(post))

		await axios.post('/api/posts', formData, {
			headers: {
				'Content-Type': 'multipart/form-data',
			},
		})

		this.setState((s: State) => ({
			saving: false,
		}))

		toast.success('Post Created')

		this.props.history.push(`/app`)
	}
}

export default withRouter(Create)
