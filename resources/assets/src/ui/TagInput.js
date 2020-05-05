// @flow

import React from 'react'
import Autosuggest from 'react-autosuggest'
import TagsInput from 'react-tagsinput'

import 'style-loader!css-loader!react-tagsinput/react-tagsinput.css'

type Props = {
	tags?: string[],
	onChange: (tags: string[]) => any,
}

type State = {
	tags: string[],
}

class TagInput extends React.Component<Props, State> {
	props: Props

	state: State = {
		tags: this.props.tags ? this.props.tags : [],
	}

	render() {
		function autocompleteRenderInput({ addTag, ...props }) {
			const handleOnChange = (e, { newValue, method }) => {
				if (method === 'enter') {
					e.preventDefault()
				} else {
					props.onChange(e)
				}
			}

			const inputValue = (props.value && props.value.trim().toLowerCase()) || ''
			const inputLength = inputValue.length

			let suggestions = window.AlmanacTags.filter((t) => {
				return t.toLowerCase().slice(0, inputLength) === inputValue
			})

			return (
				<Autosuggest
					ref={props.ref}
					suggestions={suggestions}
					shouldRenderSuggestions={(value) => value && value.trim().length > 0}
					getSuggestionValue={(suggestion) => suggestion}
					renderSuggestion={(suggestion) => <span>{suggestion}</span>}
					inputProps={{ ...props, onChange: handleOnChange }}
					onSuggestionSelected={(e, { suggestion }) => {
						addTag(suggestion)
					}}
					onSuggestionsClearRequested={() => {}}
					onSuggestionsFetchRequested={() => {}}
				/>
			)
		}

		return (
			<TagsInput
				renderInput={autocompleteRenderInput}
				value={this.state.tags}
				onChange={this.handleChange}
			/>
		)
	}

	handleChange = (tags: string[]) => {
		this.setState({ tags })
		this.props.onChange(tags)
	}
}

export default TagInput
