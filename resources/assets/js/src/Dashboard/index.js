// @flow

import React, { Component } from 'react'

import Picker from './Picker'
import PostList from '../PostList'

export type PostTypes = 'movie' | 'tv' | 'game' | 'music' | 'book' | 'podcast' | 'video' | 'text'

type Props = {

}

type State = {
}

class Dashboard extends Component<Props, State> {

    render() {

        return (
            <div>
                <Picker/>

                <PostList />
            </div>
        )
    }
}

export default Dashboard
