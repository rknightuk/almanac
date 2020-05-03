// @flow

import React from 'react'
import cx from 'classnames'
import css from './style.css'

type Props = {
    value: any,
    onChange: (value: number) => any,
}

const Star = ({ selected }: { selected: boolean }) => (
    <div className={cx(css.star, selected ? css.selected : css.unselected)}>
        <i className="fas fa-star" />
    </div>
)

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
