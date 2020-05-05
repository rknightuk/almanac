// @flow

import React from 'react'
import css from './style.css'

type Props = {
	value: any,
	onChange: (value: string) => any,
	options: {
		value: string,
		label: string,
	}[],
	withBlank?: boolean,
}

const Select = ({ value, onChange, options, withBlank }: Props) => (
	<select
		className={css.formControl}
		onChange={(e) => onChange(e.target.value)}
		value={value}
	>
		{withBlank && <option value={null} />}
		{options.map((o, i) => (
			<option key={i} value={o.value}>
				{o.label}
			</option>
		))}
	</select>
)

export default Select
