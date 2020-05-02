// @flow

import React from 'react'

type Props = {
    value: any,
    onChange: (value: number) => any,
}

const Star = ({ selected }: { selected: boolean }) => (
    <div className={`almanac-rating--star almanac-rating--star--${selected ? 'selected' : 'unselected'}`}>
        <i className="fas fa-star" data-fa-transform="grow-10"/>
    </div>
)

const Rating = ({ value, onChange }: Props) => (
    <div className="almanac-rating">
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
