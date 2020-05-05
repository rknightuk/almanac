// flow

import React from 'react'
import css from './style.css'

type Props = {
	text?: string,
}

const Loader = ({ text }: Props) => (
	<div className={css.loader}>
		<div className={css.spinner}>
			<i className="fas fa-spinner fa-spin" data-fa-transform="grow-6" />
		</div>
		<div>{text ? text : 'Loading'}...</div>
	</div>
)

export default Loader
