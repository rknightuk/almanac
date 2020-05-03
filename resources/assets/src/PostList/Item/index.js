// flow

import React from 'react'
import type { Post } from 'src/types'
import moment from 'moment'
import { Link } from 'react-router-dom'
import css from './style.css'
import Icon from 'src/ui/Icon'
import Star from 'src/ui/Star'

type Props = {
    post: Post,
}

const Item = ({ post }: Props) => (
    <div className={css.item}>
        <Link
            to={`app/posts/${post.id}`}
            className={css.link}
        >
            <div className={css.icon}>
                <Icon
                    type={post.type}
                />
            </div>

            <div>{moment(post.date_completed).format('DD-MM-YYYY')} - {post.title}</div>

            <div className={css.rating}>
                <Star selected={post.rating >= 1} noHover />
                <Star selected={post.rating >= 2} noHover />
                <Star selected={post.rating >= 3} noHover />
            </div>
        </Link>
    </div>
)

export default Item
