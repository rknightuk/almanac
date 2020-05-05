import React from 'react'
import css from './style.css'

type Props = {
	label: string,
	inputKey: string,
	input: any,
	inline?: boolean,
}

const FormRow = ({ label, inputKey, input }: Props) => (
	<div className={css.formRow}>
		<label htmlFor={inputKey} className={css.label}>
			{label}
		</label>
		<div className={css.inputWrapper}>{input}</div>
	</div>
)

export default FormRow
