// @flow

import * as React from 'react'
import { hot } from 'react-hot-loader'
import { BrowserRouter, Route } from 'react-router-dom'
import { ToastContainer, toast } from 'react-toastify'
import 'style-loader!css-loader!react-toastify/dist/ReactToastify.css'
import css from './style.css'

const Dashbaord = () => (
    <div>Dashboard</div>
)

const Create = () => (
    <div>Create</div>
)

const Update = () => (
    <div>Update</div>
)

class App extends React.Component<{}> {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <div style={{ maxWidth: '1000px', margin: '0 auto', padding: '0 20px' }}>
                        <Route exact path="/app" component={Dashbaord}/>
                        <Route exact path="/app/new" component={Create}/>
                        <Route exact path="/app/new/:type/:id?" component={Create}/>
                        <Route exact path="/app/posts/:id" component={Update}/>
                    </div>

                    <div onClick={() => toast.success('Post Created')}>CLICK ME</div>

                    <ToastContainer
                        position={toast.POSITION.BOTTOM_LEFT}
                    />
                </div>
            </BrowserRouter>
        )
    }
}

export default hot(module)(App)
