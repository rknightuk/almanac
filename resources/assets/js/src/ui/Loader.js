// flow

import React from 'react'

type Props = {
	text?: string,
}

const Loader = ({ text }: Props) => (
	<div className="almanac-loader">
		<div>
			<i className="fas fa-spinner fa-spin" data-fa-transform="grow-6" />
		</div>
		<div>
			{text ? text : 'Loading'}...
		</div>
	</div>
)

export default Loader
