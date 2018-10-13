// @flow

import React, { Component } from 'react'
import Modal from 'react-modal'
import type { PostTypes } from '../types'

type Props = {
	type: PostTypes,
	onClose: () => void,
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

	render() {
		return (
			<Modal
				isOpen
				style={MODAL_STYLES}
				onRequestClose={this.props.onClose}
			>
				SEARCH: {this.props.type}

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

}

export default SearchModal
