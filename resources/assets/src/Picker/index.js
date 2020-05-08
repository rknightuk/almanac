// @flow

import React from 'react'
import { Link } from 'react-router-dom'
import Icon from 'src/ui/Icon'

import type { PostTypes, PostTypeConfig } from 'src/types'

import css from './style.css'

type BlockProps = {
	name: PostTypes,
}

const Block = ({ name }: BlockProps) => (
	<Link to={`app/new/${name}`} className={css.block}>
		<div>
			<Icon type={name} grow="20" />
		</div>
	</Link>
)

const Picker = () => (
	<div className={css.picker}>
		{window.AlmanacConfig.postTypes.map((type: PostTypeConfig) => (
			<Block key={type.key} name={type.key} />
		))}
	</div>
)

export default Picker
