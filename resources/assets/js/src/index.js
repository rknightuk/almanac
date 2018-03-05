// @flow

import React from 'react';
import { BrowserRouter, Route } from 'react-router-dom'
import { ToastContainer, toast } from 'react-toastify'

import Dashboard from './Dashboard'
import Create from './Editor/Create'
import Update from './Editor/Update'

const App = () => (
	<BrowserRouter>
		<div>
			<div style={{ maxWidth: '1000px', margin: '0 auto', padding: '20px' }}>
				<Route exact path="/app" component={Dashboard}/>
				<Route exact path="/app/new" component={Create}/>
				<Route exact path="/app/new/:type" component={Create}/>
				<Route exact path="/app/posts/:id" component={Update}/>
			</div>

			<ToastContainer
				position={toast.POSITION.BOTTOM_LEFT}
			/>
		</div>
	</BrowserRouter>
)

export default App
