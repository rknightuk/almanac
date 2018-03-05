// @flow

import React, { Component } from 'react'
import axios from 'axios'
import type { Post } from '../types'
import Loader from '../ui/Loader'
import Item from './Item'
import Pagination from './Pagination'

type State = {
	page: number,
	posts: Post[],
	loading: boolean,
	totalPages: number,
	total: number,
}

class PostList extends Component<*, State> {

	state: State = {
		page: 1,
		posts: [],
		loading: true,
		totalPages: 0,
		total: 0,
	}

	componentDidMount() {
		this.fetchPosts()
	}

	fetchPosts = async () => {
		const data = (await axios.get(`/api/posts?page=${this.state.page}`)).data

		this.setState({
			posts: data.data,
			totalPages: data.last_page,
			total: data.total,
			loading: false,
		})
	}

	handleChange = (page: number) => {
		this.setState((s: State) => ({
			page,
		}), () => this.fetchPosts())
	}

	render() {

		if (this.state.loading) return <Loader text="Loading Posts" />

		return (
			<div>
				<ul className="list-group">
					{this.state.posts.map((p: Post, i: number) => (
						<Item key={i} post={p} />
					))}
				</ul>
				<Pagination
					currentPage={this.state.page}
					totalPages={this.state.totalPages}
					changePage={this.handleChange}
				/>
			</div>
		)
	}
}

export default PostList
