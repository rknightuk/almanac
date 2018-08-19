// @flow

import React, { Component } from 'react';

import AsyncSelect from 'react-select/lib/Async';
import { colourOptions } from './data';
import axios from 'axios/index'

type State = {
	inputValue: string,
};

const filterColors = (inputValue: string) =>
	colourOptions.filter(i =>
		i.label.toLowerCase().includes(inputValue.toLowerCase())
	);

const search = async (inputValue) => {
	const response = await axios.get(`/api/search/movie${inputValue}`)

	console.log(response)
}

const promiseOptions = async inputValue =>{
	const response = await axios.get(`/api/search/movie?query=${inputValue}`)

	console.log(response)

	return response.data
}

	// new Promise(async resolve => {
	// 	const response = await axios.get(`/api/search/movie${inputValue}`)
	//
	// 	console.log(response)
	// 	resolve(response)
	// });

export default class WithPromises extends Component<*, State> {
	state = { inputValue: 'Back to the Future' };
	handleInputChange = (newValue: string) => {
		const inputValue = newValue.replace(/\W/g, '');
		this.setState({ inputValue });
		return inputValue;
	};
	render() {
		return (
			<AsyncSelect cacheOptions defaultOptions loadOptions={promiseOptions} />
		);
	}
}
