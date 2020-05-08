// @flow

import React from 'react'
import css from './style.css'
import { Link } from 'react-router-dom'

class Navigation extends React.Component<{}> {
	logout = (e: any) => {
		e.preventDefault()
		const logoutForm = (document.getElementById('logout-form'): any)
		if (logoutForm) {
			logoutForm.submit()
		}
	}

	render() {
		return (
			<nav className={css.nav}>
				<div>
					<a href="/" target="_blank">
						View Site
					</a>
				</div>
				<div>
					<Link to="/app">Almanac</Link>
				</div>
                <div>
                    <Link to="/app/settings">Settings</Link>
                </div>
				<div>
					<a href="#" onClick={this.logout}>
						<i className="far fa-sign-out"></i> Logout
					</a>
				</div>
			</nav>
		)
	}
}

export default Navigation
