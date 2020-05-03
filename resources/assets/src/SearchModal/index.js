// @flow

import React from 'react'
import Modal from 'react-modal'
import type { PostTypes, SearchResult } from '../types'
import TextInput from 'src/ui/Form/TextInput'
import { debounce } from 'lodash'
import axios from 'axios'
import Button from 'src/ui/Form/Button'
import css from './style.css'
import inputAddons from 'src/ui/Form/inputAddons.css'

type Props = {
	type: PostTypes,
	onClose: () => void,
	onSelected: (result: SearchResult) => void,
}

type State = {
	query: ?string,
	results: {
		backdrop: string,
		poster: string,
		title: string,
		year: number,
        meta?: string,
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

class SearchModal extends React.Component<Props, State> {

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
                <div className={inputAddons.grouped}>
                    <TextInput
                        value={this.state.query}
                        onChange={this.handleQueryChange}
                        className={inputAddons.inputAddonInputRight}
                    />
                    <div
                        className={inputAddons.inputAddonRight}
                    >
                        <i className={'fas fa-search'} />
                    </div>
                </div>

				{this.state.results.map((r: SearchResult, i) => (
					<div
						key={i}
						style={{
							backgroundImage: r.backdrop || r.poster ? `url("${r.backdrop || r.poster}")` : '',
						}}
						className={css.result}
						onClick={() => this.props.onSelected(r)}
					>
						<div className={css.title}>{r.title} - {r.year}{r.meta ? ` - (${r.meta})` : ''}</div>
					</div>
				))}

				<div>
                    <Button type="success" onClick={this.props.onClose} className={css.cancelButton}>
                        Cancel
                    </Button>
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
