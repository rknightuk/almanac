// @flow

import Moment from 'moment'

export type Attachment = {
	id: ?number,
	filename: string,
	uuid: string,
	deleted_at: string,
}

export type PostTypes =
	| 'movie'
	| 'tv'
	| 'game'
	| 'music'
	| 'book'
	| 'podcast'
	| 'video'

export type PostTypeConfig = {
	key: PostTypes,
    name: string,
	icon: string,
}

export type Post = {
	id: ?number,
	type: PostTypes,
	path: string,
	title: string,
	subtitle: string,
	content: string,
	link: ?string,
	link_post: boolean,
	rating: ?number,
	year: ?string,
	spoilers: boolean,
	date_completed: Moment,
	creator: string,
	season: string,
	platform: string,
	published: boolean,
	tags: string[],
	icon: string,
	attachments: Attachment[],
    attachment_order: number[],
}

export type SearchResult = {
	title: string,
	year: string,
	poster: ?string,
	backdrop: ?string,
	meta: ?string,
}
