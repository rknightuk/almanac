import * as React from 'react'
import ReactDom from 'react-dom'
import App from './App'

if (document.getElementById('admin')) ReactDom.render(<App />, document.getElementById('admin'))
