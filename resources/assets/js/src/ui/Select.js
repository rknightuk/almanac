import React from 'react'

type Props = {
	value: any,
	onChange: (value) => any,
	options: {
		value: string,
		label: string,
	}[],
	withBlank?: string,
}

const Select = ({ value, onChange, options, withBlank }: Props) => (
	<select
		className="form-control"
		onChange={e => onChange(e.target.value)}
		value={value}
	>
		{withBlank && <option value={null} />}
		{options.map((o, i) => (
			<option
				key={i}
				value={o.value}
			>
				{o.label}
			</option>
		))}
	</select>
)

export default Select
