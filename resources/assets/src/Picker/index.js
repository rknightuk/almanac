// @flow

import React from 'react'
import { Link } from 'react-router-dom'
import Icon from 'src/ui/Icon'

import { PostTypes } from 'src/types'

import css from './style.css'

type BlockProps = {
    name: PostTypes,
}

const Block = ({ name }: BlockProps) => (
    <Link
        to={`app/new/${name}`}
        className={css.block}
    >
        <div>
            <Icon
                type={name}
                grow="20"
            />
        </div>
    </Link>
)

const Picker = () => (
    <div className={css.picker}>
        <Block
            name="movie"
        />
        <Block
            name="tv"
        />
        <Block
            name="game"
        />
        <Block
            name="music"
        />
        <Block
            name="podcast"
        />
        <Block
            name="book"
        />
        <Block
            name="video"
        />
        <Block
            name="quote"
        />
    </div>
)

export default Picker
