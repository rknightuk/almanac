// @flow

import React, { Component } from 'react'
import Modal from 'react-modal'
import type { PostTypes } from '../types'
import TextInput from '../ui/TextInput'
import { debounce } from 'lodash'
import axios from 'axios'

type Props = {
	type: PostTypes,
	onClose: () => void,
	selected: () => void,
}

type State = {
	query: ?string,
	results: {
		backdrop: string,
		poster: string,
		title: string,
		year: number,
	}[],
}

const MODAL_STYLES = {
	content : {
		maxWidth: '800px',
		margin: '0 auto',
		height: '500px',
		top: '200px'
	},
	overlay: {
		zIndex: 10
	},
};

Modal.setAppElement('#admin')

class SearchModal extends Component<Props> {

	props: Props

	state: State = {
		query: null,
		results: [],
	}

	render() {
		return (
			<Modal
				isOpen
				style={MODAL_STYLES}
				onRequestClose={this.props.onClose}
			>

				<div className="input-group">
					<span
						className="input-group-addon almn-input-addon"
						id="basic-addon3"
					>
						<i className={'fas fa-search'} />
					</span>
					<TextInput
						value={this.state.query}
						onChange={this.handleQueryChange}
					/>
				</div>

				{this.state.results.map((r, i) => (
					<div
						key={i}
						style={{
							backgroundImage: r.backdrop || r.poster ? `url("https://image.tmdb.org/t/p/w780${r.backdrop || r.poster}")` : '',
						}}
						className="almn-search--result"
						onClick={() => this.props.selected(r)}
					>
						<div className="almn-search--result--title">{r.title} - {r.year}</div>
					</div>
				))}

				<div className="almn-search--buttons">
					<button
						type="button"
						className="btn btn-default"
						onClick={this.props.onClose}
					>
						Cancel
					</button>
				</div>
			</Modal>
		)
	}

	handleQueryChange = (query: string) => {
		this.debounceSearch(query)
	}

	debounceSearch = debounce(async (query) => {
		const response = await axios.get(`/api/search/${this.props.type}?query=${query}`)

		this.setState({
			results: response.data,
		})
	}, 500)

}

export default SearchModal
