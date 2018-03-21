// @flow

import React, { Component } from 'react'
import axios from 'axios'
import type { Post } from '../types'
import Loader from '../ui/Loader'
import Item from './Item'
import Pagination from './Pagination'
import SearchBar from './SearchBar'

import { debounce } from 'lodash'

type State = {
	page: number,
	posts: Post[],
	loading: boolean,
	totalPages: number,
	total: number,
	search: ?string,
	type: ?string,
}

class PostList extends Component<*, State> {

	state: State = {
		page: 1,
		posts: [],
		loading: true,
		totalPages: 0,
		total: 0,
		search: null,
		type: '',
	}

	componentDidMount() {
		this.fetchPosts()
	}

	fetchPosts = async () => {
		this.setState({ loading: true })

		const params = new URLSearchParams()
		params.append('page', this.state.page.toString())
		if (this.state.search !== null && this.state.search !== undefined) params.append('search', this.state.search)
		if (this.state.type !== null && this.state.type !== undefined) params.append('category', this.state.type)

		const data = (await axios.get(`/api/posts`, { params })).data

		this.setState({
			posts: data.data,
			totalPages: data.last_page,
			total: data.total,
			loading: false,
		})
	}

	debounceFetch = debounce(() => {
		this.fetchPosts()
	}, 200)

	handleChange = (page: number) => {
		this.setState((s: State) => ({
			page,
		}), () => this.fetchPosts())
	}

	handleSearch = (search: ?string) => {
		this.setState((s: State) => ({
			search,
		}), () => this.debounceFetch())
	}

	handleTypeChange = (type: ?string) => {
		this.setState((s: State) => ({
			type,
		}), () => this.fetchPosts())
	}

	render() {

		if (this.state.posts.length === 0 && !(this.state.search || this.state.type)) {
			return (
				<div style={{ textAlign: 'center' }}>
					<p>No posts yet — create one by selecting a type from above.</p>
				</div>
			)
		}

		return (
			<div>
				<SearchBar
					search={this.state.search}
					type={this.state.type}
					onChangeQuery={this.handleSearch}
					onChangeType={this.handleTypeChange}
				/>

				{this.state.loading && <Loader text="Loading Posts" />}

				{this.state.posts.length === 0 && (
					<div style={{ textAlign: 'center', marginTop: '10px' }}>
						<p>No posts found</p>
					</div>
				)}
				{this.state.posts.length > 0 && (
					<div>
						<ul className="list-group">
							{this.state.posts.map((p: Post) => (
								<Item key={p.id} post={p} />
							))}
						</ul>
						<Pagination
							currentPage={this.state.page}
							totalPages={this.state.totalPages}
							changePage={this.handleChange}
						/>
					</div>
				)}
			</div>
		)
	}
}

export default PostList
