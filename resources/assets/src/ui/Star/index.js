// @flow

import React from 'react'
import cx from 'classnames'
import css from './style.css'

const Star = ({
	selected,
	noHover,
}: {
	selected: boolean,
	noHover?: boolean,
}) => (
	<div
		className={cx(
			!noHover ? css.star : '',
			selected ? css.selected : css.unselected,
		)}
	>
		<i className="fas fa-star" />
	</div>
)

export default Star
