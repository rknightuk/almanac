import React from 'react'

type Props = {
	value: any,
	onChange: (value) => any,
}

const Checkbox = ({ value, onChange }: Props) => (
	<input
		className="form-check-input"
		type="checkbox"
		value={value}
		onChange={e => onChange(e.target.checked)}
	/>
)

export default Checkbox
