// @flow

import React from 'react'
import css from './style.css'
import cx from 'classnames'

type Props = {
    value: ?string,
    onChange: (value: string) => any,
    type?: string,
    className?: string,
}

const TextInput = ({ value, onChange, type, className, ...props }: Props) => (
    <input
        {...props}
        className={cx(css.formControl, className)}
        type={type ? type : 'text'}
        value={value}
        onChange={e => onChange(e.target.value)}
    />
)

export default TextInput
