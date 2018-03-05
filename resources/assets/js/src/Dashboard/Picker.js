// @flow

import React from 'react'
import { Link } from "react-router-dom";

import { PostTypes } from '../types'

// import css from './styles.css'

type BlockProps = {
	name: PostTypes,
	icon: string,
	title: string,
	iconClass?: string,
}

const Block = ({ name, icon, title }: BlockProps) => (
	<Link
		to={`app/new/${name}`}
	>
		ICON HERE
		<span>{title}</span>
	</Link>
)

const Picker = () => (
	<div>
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
			icon="game"
			title="Game"
		/>
		<Block
			name="music"
			icon="music"
			title="Music"
		/>
		<Block
			name="podcast"
			icon="podcast"
			title="Podcast"
		/>
		<Block
			name="book"
			icon="bookmark outline"
			iconClass="book"
			title="Book"
		/>
		<Block
			name="video"
			icon="youtube play"
			iconClass="video"
			title="Video"
		/>
		<Block
			name="text"
			icon="file text outline"
			iconClass="text"
			title="Text"
		/>
	</div>
)

export default Picker
