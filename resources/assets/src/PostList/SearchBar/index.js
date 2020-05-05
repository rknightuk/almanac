// @flow

import React from 'react'

import TextInput from 'src/ui/Form/TextInput'
import Select from 'src/ui/Form/Select'

import css from './style.css'

type Props = {
	search: ?string,
	type: ?string,
	onChangeQuery: (search: ?string) => any,
	onChangeType: (type: ?string) => any,
}

const SearchBar = ({ search, type, onChangeQuery, onChangeType }: Props) => (
	<div className={css.search}>
		<TextInput
			value={search}
			onChange={(s) => onChangeQuery(s === '' ? null : s)}
			placeholder="Search for posts"
			className={css.searchInput}
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
				{ value: 'video', label: 'Video' },
				{ value: 'text', label: 'Text' },
			]}
			onChange={(t) => onChangeType(t === '' ? null : t)}
			withBlank
		/>
	</div>
)

export default SearchBar
