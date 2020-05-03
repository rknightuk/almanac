// @flow

import React from 'react'
import css from './style.css'

class Navigation extends React.Component<{}> {
    logout = (e) => {
        e.preventDefault()
        document.getElementById('logout-form').submit()
    }

    render() {
        return (
            <nav className={css.nav}>
                <div>
                    <a href="/" target="_blank">View Site</a>
                </div>
                <div>
                    <a href="/app">Almanac</a>
                </div>
                <div>
                    <a href="#" onClick={this.logout}><i className="far fa-sign-out"></i> Logout</a>
                </div>
            </nav>
        )
    }
}

export default Navigation
