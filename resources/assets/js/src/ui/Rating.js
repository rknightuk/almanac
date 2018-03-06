// @flow

import React from 'react'

type Props = {
	value: any,
	onChange: (value: number) => any,
}

const Rating = ({ value, onChange }: Props) => (
	<div className="almanac-rating">
		<div
			className={`almanac-block ${value === 0 ? 'active' : ''} bad`}
			onClick={() => onChange(0)}
		>
			<div>
				<i className="far fa-frown" data-fa-transform="grow-20" />
			</div>
		</div>
		<div
			className={`almanac-block ${value === 1 ? 'active' : ''} fine`}
			onClick={() => onChange(1)}
		>
			<div>
				<i className="far fa-meh" data-fa-transform="grow-20" />
			</div>
		</div>
		<div
			className={`almanac-block ${value === 2 ? 'active' : ''} good`}
			onClick={() => onChange(2)}
		>
			<div>
				<i className="far fa-smile" data-fa-transform="grow-20" />
			</div>
		</div>
	</div>
)

export default Rating
