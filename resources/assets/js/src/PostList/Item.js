// flow

import React from 'react'
import type { Post } from '../types'
import moment from 'moment'
import { Link } from 'react-router-dom'

type Props = {
	post: Post,
}

const Item = ({ post }: Props) => (
	<Link
		className="list-group-item"
		to={`app/posts/${post.id}`}
	>
		{post.title} - {moment(post.date_completed).format('DD-MM-YYYY')}
	</Link>
)

export default Item
