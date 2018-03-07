// @flow

import React from 'react'
import { Link } from 'react-router-dom'

import { PostTypes } from '../types'

type BlockProps = {
	name: PostTypes,
	icon: string,
	title: string,
}

const Block = ({ name, icon, title }: BlockProps) => (
	<Link
		to={`app/new/${name}`}
		className="block"
	>
		<div className={`icon__${name}`}>
			<i className={`fas fa-${icon}`} data-fa-transform="grow-20" />
		</div>
		<span className="name">{title}</span>
	</Link>
)

const Picker = () => (
	<div className="picker">
		<Block
			name="movie"
			icon="film"
			title="Movie"
		/>
		<Block
			name="tv"
			icon="tv"
			title="TV"
		/>
		<Block
			name="game"
			icon="gamepad"
			title="Game"
		/>
		<Block
			name="music"
			icon="headphones"
			title="Music"
		/>
		<Block
			name="podcast"
			icon="podcast"
			title="Podcast"
		/>
		<Block
			name="book"
			icon="book"
			title="Book"
		/>
		<Block
			name="comic"
			icon="bolt"
			title="Comic"
		/>
		<Block
			name="video"
			icon="video"
			title="Video"
		/>
		<Block
			name="text"
			icon="file-alt"
			title="Text"
		/>
	</div>
)

export default Picker
