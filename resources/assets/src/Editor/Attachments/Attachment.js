// @flow

import React from 'react'
import css from './style.css'

type Props = {
	uuid: string,
	title: string,
	onDelete?: (uuid: string) => any,
}

export const DeleteButton = ({
	onDelete,
}: {
	onDelete: (uuid: string) => void,
}) => (
	<div onClick={onDelete} className={css.delete}>
		<i className="fas fa-trash"></i>
	</div>
)

class Attachment extends React.Component<Props> {
	handleDelete = () => {
	    if (this.props.onDelete) this.props.onDelete(this.props.uuid)
	}

	render() {
		const { title } = this.props

		return (
			<div className={css.attachment}>
				{this.props.onDelete && <DeleteButton onDelete={this.handleDelete} />}{' '}
				<div>{title}</div>
			</div>
		)
	}
}

export default Attachment
