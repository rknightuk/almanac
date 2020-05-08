// @flow

import React from 'react'

import TextInput from 'src/ui/Form/TextInput'
import Select from 'src/ui/Form/Select'

import css from './style.css'
import type { PostTypeConfig } from 'src/types'

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
			options={window.AlmanacConfig.postTypes.map((type: PostTypeConfig) => (
                { value: type.key, label: type.name }
            ))}
			onChange={(t) => onChangeType(t === '' ? null : t)}
			withBlank
		/>
	</div>
)

export default SearchBar
