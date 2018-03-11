// @flow

import React from 'react'

import TextInput from '../ui/TextInput'
import Select from '../ui/Select'

type Props = {
	search: ?string,
	type: ?string,
	onChangeQuery: (search: ?string) => any,
	onChangeType: (type: ?string) => any,
}

const SearchBar = ({ search, type, onChangeQuery, onChangeType }: Props) => (
	<div className="almn-search-bar">
		<TextInput
			value={search}
			onChange={(s) => onChangeQuery(s === '' ? null : s)}
			placeholder="Search for posts"
		/>

		<Select
			value={type}
			options={[
				{ value: 'movie', label: 'Movie' },
				{ value: 'tv', label: 'TV' },
				{ value: 'game', label: 'Game' },
				{ value: 'music', label: 'Music' },
				{ value: 'podcast', label: 'Podcast' },
				{ value: 'book', label: 'Book' },
				{ value: 'comic', label: 'Comic' },
				{ value: 'video', label: 'Video' },
				{ value: 'text', label: 'Text' },
			]}
			onChange={(t) => onChangeType(t === '' ? null : t)}
			withBlank
		/>
	</div>
)

export default SearchBar
