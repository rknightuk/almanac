// @flow

import React from 'react'
import { Link } from 'react-router-dom'

import { PostTypes } from 'src/types'

import css from './style.css'

type BlockProps = {
    name: PostTypes,
    title: string,
}

const Block = ({ name, title }: BlockProps) => (
    <Link
        to={`app/new/${name}`}
        className={css.block}
    >
        <i class={`fas fa-${name}`} />
    </Link>
)

const Picker = () => (
    <div className={css.picker}>
        <Block
            name="movie"
            title="Movie"
        />
        <Block
            name="tv"
            title="TV"
        />
        <Block
            name="game"
            title="Game"
        />
        <Block
            name="music"
            title="Music"
        />
        <Block
            name="podcast"
            title="Podcast"
        />
        <Block
            name="book"
            title="Book"
        />
        <Block
            name="video"
            title="Video"
        />
        <Block
            name="quote"
            title="Quote"
        />
    </div>
)

export default Picker
