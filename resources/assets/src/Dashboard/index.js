// @flow

import React from 'react'

import Picker from 'src/Picker'
import PostList from 'src/PostList'

type Props = {}

type State = {}

class Dashboard extends React.Component<Props, State> {
	render() {
		return (
			<div>
				<Picker />

				<PostList />
			</div>
		)
	}
}

export default Dashboard
