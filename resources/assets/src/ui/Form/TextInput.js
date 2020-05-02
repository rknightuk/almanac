// @flow

import React from 'react'
import css from './style.css'
import cx from 'classnames'

type Props = {
    value: any,
    onChange: (value) => any,
    type?: string,
    className?: string,
}

const TextInput = ({ value, onChange, type, className, ...props }: Props) => (
    <input
        className={cx(css.formControl, className)}
        type={type ? type : 'text'}
        value={value}
        onChange={e => onChange(e.target.value)}
        {...props}
    />
)

export default TextInput
