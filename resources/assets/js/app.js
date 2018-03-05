require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';

import App from './src';

if (document.getElementById('admin')) render(<App />, document.getElementById('admin'));
