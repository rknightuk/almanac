import React from 'react'

type Props = {
	value: any,
	onChange: (value) => any,
	type?: string,
}

const TextInput = ({ value, onChange, type, ...props }: Props) => (
	<input
		className="form-control"
		type={type ? type : 'text'}
		value={value}
		onChange={e => onChange(e.target.value)}
		{...props}
	/>
)

export default TextInput
