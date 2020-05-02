// @flow

import * as React from 'react'
import { hot } from 'react-hot-loader'
import { BrowserRouter, Route } from 'react-router-dom'
import { ToastContainer, toast } from 'react-toastify'
import Navigation from 'src/Navigation'
import Dashboard from 'src/Dashboard'
import Create from 'src/Editor/Create'
import Update from 'src/Editor/Update'

import 'style-loader!css-loader!react-toastify/dist/ReactToastify.css'
import css from './style.css'

class App extends React.Component<{}> {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <div className={css.wrapper}>
                        <Navigation />
                        <Route exact path="/app" component={Dashboard}/>
                        <Route exact path="/app/new" component={Create}/>
                        <Route exact path="/app/new/:type/:id?" component={Create}/>
                        <Route exact path="/app/posts/:id" component={Update}/>
                    </div>

                    <ToastContainer
                        position={toast.POSITION.BOTTOM_LEFT}
                    />
                </div>
            </BrowserRouter>
        )
    }
}

export default hot(module)(App)
