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
import Attachments from './Attachments'
import { v4 as uuidv4 } from 'uuid'

import DatePicker from 'react-day-picker/DayPickerInput'
import { formatDate, parseDate } from 'react-day-picker/moment'
import 'style-loader!css-loader!react-day-picker/lib/style.css'
import css from './style.css'
import inputAddons from 'src/ui/Form/inputAddons.css'

import { PLATFORMS } from 'src/constants'

import moment from 'moment'
import type { Attachment, Post, PostTypes, SearchResult } from '../types'
import { toast } from 'react-toastify'
import axios from 'axios'
import slugify from 'slug'
import Button from 'src/ui/Form/Button'


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
    newAttachments: {
	    file: File,
        uuid: string,
    }[],
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
            attachments: [],
		},
        cachedDate: this.props.post ? this.props.post.date_completed : null,
		deleting: false,
		pathManuallyChanged: false,
		showPreview: false,
		showSearch: false,
        newAttachments: [],
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

				<div className={css.heading}>
					<Icon
						type={this.props.post ? this.props.post.type : this.props.type}
					/> {this.props.isNew ? `Add new ${post.type}` : `Editing "${this.state.post.title}"`}
				</div>

				<form>
					<FormRow
                        inline
						label="Title"
						inputKey="post-title"
						input={(
							<div className={!this.props.post ? inputAddons.grouped : ''}>
								<TextInput
									value={post.title}
									onChange={v => this.handleTitleChange(v)}
                                    className={searchAvailable ? inputAddons.inputAddonInputRight : ''}
								/>
								{searchAvailable && (
									<div
										className={inputAddons.inputAddonRight}
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

                    <Attachments
                        attachments={post.attachments}
                        newAttachments={this.state.newAttachments}
                        handleDelete={this.deleteAttachment}
                        handleDeleteNew={this.deleteNewAttachment}
                        addAttachments={this.addAttachments}
                    />

					<FormRow
						label="Slug"
						inputKey="post-path"
						input={(
							<div className={inputAddons.grouped}>
								<div className={inputAddons.inputAddonLeft}>
									{this.generateStaticPath()}
								</div>
                                <TextInput
                                    value={post.path}
                                    onChange={v => this.updatePost('path', v)}
                                    className={inputAddons.inputAddonInputLeft}
                                />
							</div>
						)}
					/>

					<FormRow
						label={(
							<span>
								Link
								{this.linkIncludes('youtube') && (
									<span className={css.youtube}>
										<i className="fab fa-youtube" />
									</span>
								)}
								{this.linkIncludes('spotify') && (
									<span className={css.spotify}>
										<i className="fab fa-spotify" />
									</span>
								)}
								{this.linkIncludes('vimeo') && (
									<span className={css.vimeo}>
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
						<Button
                            type="danger"
							onClick={this.handleDelete}
							disabled={this.state.deleting || this.props.saving}
                            saving={this.state.deleting}
                            savingText="Deleting"
                            className={css.deleteButton}
						>
							Delete
						</Button>
					)}

					<Button
                        type="success"
						onClick={this.handleSave}
						disabled={this.props.saving || !this.isValid() || this.state.deleting}
                        saving={this.props.saving}
                        savingText="Saving"
					>
						Save
					</Button>
				</form>
			</div>
		)
	}

	componentDidMount() {
		this.showSearch()
	}

	addAttachments = (attachments: File[]) => {
        this.setState((state: State) => ({
            newAttachments: state.newAttachments.concat(attachments.map((a: File) => {
                return {
                    file: a,
                    uuid: uuidv4(),
                }
            })),
        }))
    }

    deleteNewAttachment = (uuid: string) => {
	    this.setState((state: State) => ({
            newAttachments: state.newAttachments.filter((u) => u.uuid !== uuid)
        }))
    }

    deleteAttachment = (uuid: string) => {
	    this.setState((state: State) => ({
            post: {
                ...state.post,
                attachments: state.post.attachments.map((a: Attachment) => {
                    if (uuid !== a.uuid) return a

                    return {
                        ...a,
                        deleted_at: moment().toDate().toISOString(),
                    }
                })
            }
        }))
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
		}, this.state.newAttachments)
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
