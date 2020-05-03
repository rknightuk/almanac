// @flow

import React from 'react'
import css from './style.css'

type Props = {
    uuid: string,
    title: string,
    onDelete: (uuid: string) => any,
}

class Upload extends React.Component<Props> {
    handleDelete = () => {
        this.props.onDelete(this.props.uuid)
    }

    render() {
        const { title } = this.props

        return (
            <li className={css.upload}>
                <div onClick={this.handleDelete} className={css.delete}><i className="fas fa-trash"></i></div> <div>{title}</div>
            </li>
        )
    }
}

export default Upload

