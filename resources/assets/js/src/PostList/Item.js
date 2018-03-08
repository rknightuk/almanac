// flow

import React from 'react'
import type { Post } from '../types'
import moment from 'moment'
import { Link } from 'react-router-dom'
import Icon from '../ui/Icon'

type Props = {
	post: Post,
}

const Item = ({ post }: Props) => (
	<Link
		className="list-group-item"
		to={`app/posts/${post.id}`}
	>
		<Icon
			type={post.type}
			style={{ marginLeft: '-5px', marginRight: '3px' }}
		/> {post.title} - {moment(post.date_completed).format('DD-MM-YYYY')}
	</Link>
)

export default Item
