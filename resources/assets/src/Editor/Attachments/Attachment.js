// @flow

import React from 'react'
import css from './style.css'

type Props = {
	uuid: string,
	title: string,
	onDelete: (uuid: string) => any,
}

class Attachment extends React.Component<Props> {
	handleDelete = () => {
		this.props.onDelete(this.props.uuid)
	}

	render() {
		const { title } = this.props

		return (
			<li className={css.attachment}>
				<div onClick={this.handleDelete} className={css.delete}>
					<i className="fas fa-trash"></i>
				</div>{' '}
				<div>{title}</div>
			</li>
		)
	}
}

export default Attachment
