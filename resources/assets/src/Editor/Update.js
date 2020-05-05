// @flow

import React from 'react'
import { withRouter } from 'react-router-dom'
import axios from 'axios'

import { toast } from 'react-toastify'

import Editor from './Editor'
import Loader from 'src/ui/Loader'
import type { Post } from 'src/types'
import { v4 as uuidv4 } from 'uuid'

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

class Update extends React.Component<Props, State> {
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
				content: response.data.content,
				date_completed: moment.utc(response.data.date_completed),
				tags: response.data.tags.map((t) => t.name.en),
				attachments: response.data.attachments.map((a) => {
					return {
						...a,
						uuid: uuidv4(),
					}
				}),
			},
			loading: false,
		})
	}

	render() {
		if (this.state.loading) {
			return <Loader text="Loading Post" />
		}

		if (this.state.notFound) {
			return <div>Post not found</div>
		}

		return (
			<Editor
				onSave={this.handleSave}
				post={this.state.post}
				saving={this.state.saving}
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
		formData.append('_method', 'put')

		await axios.post(`/api/posts/${this.props.match.params.id}`, formData, {
			headers: {
				'Content-Type': 'multipart/form-data',
			},
		})

		this.setState((s: State) => ({
			saving: false,
		}))

		toast.success('Post Updated')

		this.props.history.push('/app')
	}
}

export default withRouter(Update)
