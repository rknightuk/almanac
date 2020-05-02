import * as React from 'react'
import { hot } from 'react-hot-loader'
import css from './style.css'

class App extends React.Component {
    render() {
        return (
            <div>
                This is <span className={css.red}> the main app!</span>
            </div>
        )
    }
}

export default hot(module)(App)
