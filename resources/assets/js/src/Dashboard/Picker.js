// @flow

import React from 'react'
import { Link } from 'react-router-dom'
import Icon from '../ui/Icon'

import { PostTypes } from '../types'

type BlockProps = {
	name: PostTypes,
	title: string,
}

const Block = ({ name, title }: BlockProps) => (
	<Link
		to={`app/new/${name}`}
		className="block"
	>
		<Icon
			type={name}
			grow="20"
		/>
		<span className="name">{title}</span>
	</Link>
)

const Picker = () => (
	<div className="picker">
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
			name="comic"
			title="Comic"
		/>
		<Block
			name="video"
			title="Video"
		/>
		<Block
			name="text"
			title="Text"
		/>
	</div>
)

export default Picker
