// @flow

import React from 'react'
import { withRouter } from 'react-router-dom'

import FormRow from 'src/ui/Form/Row'
import TextInput from 'src/ui/Form/TextInput'
import Checkbox from 'src/ui/Form/Checkbox'
import Select from 'src/ui/Form/Select'
import TagInput from 'src/ui/TagInput'
import Rating from 'src/ui/Rating'
import Icon from 'src/ui/Icon'
import SearchModal from 'src/SearchModal'
import ReactMarkdown from 'react-markdown'

import DatePicker from 'react-day-picker/DayPickerInput'
import { formatDate, parseDate } from 'react-day-picker/moment'
import 'style-loader!css-loader!react-day-picker/lib/style.css'
import css from './style.css'

import { PLATFORMS } from 'src/constants'

import moment from 'moment'
import type { Post, PostTypes, SearchResult } from '../types'
import { toast } from 'react-toastify'
import axios from 'axios'
import slugify from 'slug'


type Props = {
	type?: PostTypes,
	onSave: (post: Post) => any,
	post?: Post,
	saving: boolean,
	history: any,
	isNew?: boolean,
	showSearch?: () => any,
}

type State = {
	post: Post,
	deleting: boolean,
	pathManuallyChanged: boolean,
	showPreview: boolean,
	showSearch: boolean,
    cachedDate: ?moment,
    searchAvailable: boolean,
}

class Editor extends React.Component<Props, State> {

	props: Props

	state: State = {
		post: this.props.post || {
			id: null,
			type: this.props.type || 'movie',
			path: '',
			title: '',
			subtitle: '',
			content: '',
			link: '',
			rating: null,
			year: '',
			spoilers: false,
			date_completed: moment(),
			creator: '',
			season: '',
			platform: '',
			published: true,
			tags: [],
			poster: null,
			backdrop: null,
		},
        cachedDate: this.props.post ? this.props.post.date_completed : null,
		deleting: false,
		pathManuallyChanged: false,
		showPreview: false,
		showSearch: false,
	}

	render() {

		const { post, showPreview, showSearch, searchAvailable } = this.state

		return (
			<div>
				{showSearch && (
					<SearchModal
						type={this.props.type}
						onClose={this.hideSearch}
						onSelected={this.handleSelected}
					/>
				)}

				<h1>
					<Icon
						type={this.props.post ? this.props.post.type : this.props.type}
					/> {this.props.isNew ? `Add new ${post.type}` : 'Edit Post'}
				</h1>

				<form>
					<FormRow
                        inline
						label="Title"
						inputKey="post-title"
						input={(
							<div className={!this.props.post ? css.grouped : ''}>
								<TextInput
									value={post.title}
									onChange={v => this.handleTitleChange(v)}
                                    className={searchAvailable ? css.inputAddonInputRight : ''}
								/>
								{searchAvailable && (
									<div
										className={css.inputAddonRight}
										onClick={!this.props.post ? this.showSearch : () => false}
									>
										<i className={'fas fa-search'} />
									</div>
								)}
							</div>
						)}
					/>

					<FormRow
						label="Subtitle"
						inputKey="post-subtitle"
						input={(
							<TextInput
								value={post.subtitle}
								onChange={v => this.updatePost('subtitle', v)}
							/>
						)}
					/>

                    {post.type !== 'quote' && (
                        <FormRow
                            label="Rating"
                            inputKey="post-rating"
                            input={(
                                <Rating
                                    value={post.rating}
                                    onChange={this.updateRating}
                                />
                            )}
                        />
                    )}

                    <div className={css.contentWrapper}>
                        <div className={css.previewBar} onClick={this.togglePreview}>
                            {showPreview ? 'Hide' : 'Show'} Preview
                        </div>
                        <textarea
                            className={css.contentEditor}
                            value={post.content}
                            onChange={v => this.updatePost('content', v.target.value)}
                        />
                        {showPreview && (
                            <div className={css.preview}>
                                <ReactMarkdown source={post.content === '' ? '_nothing yet_' : post.content} />
                            </div>
                        )}
                    </div>

					<FormRow
						label="Slug"
						inputKey="post-path"
						input={(
							<div className={css.grouped}>
								<div className={css.inputAddonLeft}>
									{this.generateStaticPath()}
								</div>
                                <TextInput
                                    value={post.path}
                                    onChange={v => this.updatePost('path', v)}
                                    className={css.inputAddonInputLeft}
                                />
							</div>
						)}
					/>

					<FormRow
						label={(
							<span>
								Link
								{this.linkIncludes('youtube') && (
									<span className="almn-linkicon almn-linkicon--youtube">
										<i className="fab fa-youtube" />
									</span>
								)}
								{this.linkIncludes('spotify') && (
									<span className="almn-linkicon almn-linkicon--spotify">
										<i className="fab fa-spotify" />
									</span>
								)}
								{this.linkIncludes('vimeo') && (
									<span className="almn-linkicon almn-linkicon--vimeo">
										<i className="fab fa-vimeo" />
									</span>
								)}
							</span>
						)}
						inputKey="post-link"
						input={(
							<TextInput
								value={post.link}
								onChange={v => this.updatePost('link', v)}
							/>
						)}
					/>

					<FormRow
						label="Year"
						inputKey="post-year"
						input={(
							<TextInput
								type="number"
								min={1900}
								max={9999}
								value={post.year}
								onChange={v => this.updatePost('year', v)}
							/>
						)}
					/>

					<FormRow
						label="Spoilers?"
						inputKey="post-spoilers"
						input={(
							<Checkbox
								value={post.spoilers}
								onChange={v => this.updatePost('spoilers', v)}
							/>
						)}
					/>

					<FormRow
						label="Post Date"
						inputKey="post-date"
						input={(
							<DatePicker
								format="DD-MM-YYYY"
								value={moment(post.date_completed).format('DD-MM-YYYY')}
								onDayChange={this.updateDate}
								formatDate={formatDate}
								parseDate={parseDate}
							/>
						)}
					/>

					{this.showPlatform() && (
						<FormRow
							label="Platform"
							inputKey="post-platform"
							input={(
								<Select
									value={post.platform}
									onChange={v => this.updatePost('platform', v)}
									options={PLATFORMS}
									withBlank
								/>
							)}
						/>
					)}

					{this.showCreator() && (
						<FormRow
							label={post.type === 'book' ? 'Author' : 'Artist'}
							inputKey="post-author"
							input={(
								<TextInput
									value={post.creator}
									onChange={v => this.updatePost('creator', v)}
								/>
							)}
						/>
					)}

					{this.showSeason() && (
						<FormRow
							label={post.type === 'book' ? 'Series' : 'Season'}
							inputKey="post-season"
							input={(
								<TextInput
									value={post.season}
									onChange={v => this.updatePost('season', v)}
								/>
							)}
						/>
					)}

					<FormRow
						label="Tags"
						inputKey="post-tags"
						input={(
							<TagInput
								onChange={tags => this.updatePost('tags', tags)}
								tags={post.tags}
							/>
						)}
					/>

					<FormRow
						label="Published?"
						inputKey="post-published"
						input={(
							<Checkbox
								value={post.published}
								onChange={v => this.updatePost('published', v)}
							/>
						)}
					/>

					{this.state.post.id && (
						<button
							type="button"
							className="btn btn-danger"
							style={{ marginRight: '10px' }}
							onClick={this.handleDelete}
							disabled={this.state.deleting || this.props.saving}
						>
							{this.state.deleting ? (
								<span>
								<i className="fas fa-spinner fa-spin" data-fa-transform="grow-6" /> Deleting
							</span>
							) : 'Delete'}
						</button>
					)}

					<button
						type="button"
						className="btn btn-success"
						onClick={this.handleSave}
						disabled={this.props.saving || !this.isValid() || this.state.deleting}
					>
						{this.props.saving ? (
							<span>
								<i className="fas fa-spinner fa-spin" data-fa-transform="grow-6" /> Saving
							</span>
						) : 'Save'}
					</button>
				</form>
			</div>
		)
	}

	componentDidMount() {
		this.showSearch()
	}

    togglePreview = () => {
	    this.setState((state: State) => ({
            showPreview: !state.showPreview,
        }))
    }

	showSearch = () => {
	    const hasSearch = !this.props.post && window.AlmanacSearch[this.props.type]
	    this.setState({
            showSearch: hasSearch,
            searchAvailable: hasSearch,
        })
	}

	hideSearch = () => {
		this.setState({
			showSearch: false,
		})
	}

	handleSelected = (result: SearchResult) => {
		this.setState(state => ({
			post: {
				...state.post,
				title: result.title,
				year: result.year,
				poster: result.poster,
				backdrop: result.backdrop,
				path: this.slugifyTitle(result.title),
			},
			showSearch: false,
		}))
	}

	handleSave = () => {
		this.props.onSave({
			...this.state.post,
			date_completed: this.state.post.date_completed.toDate(),
		})
	}

	showPlatform = () => ['game', 'quote'].includes(this.state.post.type)
	showCreator = () => ['book', 'music', 'quote'].includes(this.state.post.type)
	showSeason = () => ['tv', 'book', 'quote'].includes(this.state.post.type)

	isValid = () => Object.keys(this.getErrors()).length === 0

	getErrors = () => {
		const { post } = this.state

		let errors = {}

		if (!post.title || post.title === '') {
			errors.title = 'Title is required'
		}

		if (!post.path || post.path === '') {
			errors.path = 'Slug is required'
		}

		return errors
	}

	updateRating = (value: number) => {
	    this.updatePost('rating', value === this.state.post.rating ? null : value)
    }

	updatePost = (key: string, value: any) => {
		const pathManuallyChanged = key === 'path' ? true : this.state.pathManuallyChanged

		this.setState((s: State) => ({
			post: {
				...s.post,
				[key]: value,
			},
			pathManuallyChanged,
		}))
	}

    updateDate = (date: moment) => {
        const formattedDate = moment(date).format('YYYY/MM/DD')
        const time = this.state.cachedDate ? this.state.cachedDate : moment.utc()
        const datetime = formattedDate + ' ' + time.get('hour') + ':' + time.get('minute')
        const format = 'YYYY/MM/DD HH:mm'
	    this.updatePost('date_completed', moment.utc(datetime, format))
    }

	shouldGeneratePath = () => {
		return !this.props.post && !this.state.pathManuallyChanged
	}

	generateStaticPath = () => {
		const year = this.state.post.date_completed.format('YYYY')
		const month = this.state.post.date_completed.format('MM')
		const day = this.state.post.date_completed.format('DD')

		return `/${year}/${month}/${day}/`
	}

	linkIncludes = (search: string) => {
		if (!this.state.post.link) return false

		return this.state.post.link.includes(search)
	}

	handleTitleChange = (title: string) => {
		const path = this.shouldGeneratePath() ? this.slugifyTitle(title) : this.state.post.path

		this.setState((s: State) => ({
			post: {
				...s.post,
				title,
				path,
			}
		}))
	}

	slugifyTitle = (title: string) => {
		return slugify(title).toLowerCase()
	}

	handleDelete = async () => {
		this.setState((s: State) => ({
			deleting: true,
		}))

		await axios.delete(`/api/posts/${this.state.post.id}`)

		this.setState((s: State) => ({
			deleting: false,
		}))

		toast.success('Post Deleted')

		this.props.history.push(`/app`)
	}
}

export default withRouter(Editor)
