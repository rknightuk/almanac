// @flow

export type Attachment = {
    id: ?number,
    filename: string,
    uuid: string,
    deleted_at: string,
}

export type Post = {
    id: ?number,
    type: string,
    path: string,
    title: string,
    subtitle: string,
    content: string,
    link: ?string,
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
    poster: ?string,
    backdrop: ?string,
    attachments: Attachment[],
}

export type PostTypes =
    'movie'
    | 'tv'
    | 'game'
    | 'music'
    | 'book'
    | 'podcast'
    | 'video'
    | 'quote'

export type SearchResult = {
    title: string,
    year: number,
    poster: ?string,
    backdrop: ?string,
    meta: ?string,
}
