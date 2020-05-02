// flow

import React from 'react'
import type { Post } from 'src/types'
import moment from 'moment'
import { Link } from 'react-router-dom'
import css from './style.css'

type Props = {
    post: Post,
}

const Item = ({ post }: Props) => (
    <Link
        className={css.item}
        to={`app/posts/${post.id}`}
    >
        {post.title} - {moment(post.date_completed).format('DD-MM-YYYY')}
    </Link>
)

export default Item
