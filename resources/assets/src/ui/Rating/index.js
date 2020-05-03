// @flow

import React from 'react'
import css from './style.css'
import Star from 'src/ui/Star'

type Props = {
    value: any,
    onChange: (value: number) => any,
}

const Rating = ({ value, onChange }: Props) => (
    <div className={css.ratings}>
        <div
            onClick={() => onChange(1)}
        >
            <Star selected={value >= 1} />
        </div>
        <div
            onClick={() => onChange(2)}
        >
            <Star selected={value >= 2} />
        </div>
        <div
            onClick={() => onChange(3)}
        >
            <Star selected={value >= 3} />
        </div>
    </div>
)

export default Rating
