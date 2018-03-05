// @flow

import React, { Component } from 'react'

import Picker from './Picker'
import PostList from '../PostList'

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
