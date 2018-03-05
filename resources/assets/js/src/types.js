export type Post = {
	id: ?number,
	type: string,
	path: string,
	title: string,
	subtitle: string,
	content: {
		text: string,
	},
	link: ?string,
	rating: ?number,
	year: ?string,
	spoilers: boolean,
	date_completed: Moment,
	creator: string,
	season: string,
	platform: string,
}