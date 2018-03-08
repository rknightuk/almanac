// @flow

import React, { Component } from 'react'
import { withRouter } from 'react-router-dom'

import ReactMde, { ReactMdeCommands } from 'react-mde'
import 'react-mde/lib/styles/css/react-mde-all.css'

import FormRow from '../ui/FormRow'
import TextInput from '../ui/TextInput'
import Checkbox from '../ui/Checkbox'
import Select from '../ui/Select'
import TagInput from '../ui/TagInput'
import Rating from '../ui/Rating'

import DatePicker from 'react-day-picker/DayPickerInput'
import { formatDate, parseDate } from 'react-day-picker/moment'
import 'react-day-picker/lib/style.css'

import { PLATFORMS } from '../constants'

import moment from 'moment'
import type { Post, PostTypes } from '../types'
import { toast } from 'react-toastify'
import axios from 'axios'
import slugify from 'slug'


type Props = {
	type?: PostTypes,
	onSave: (post: Post) => any,
	post?: Post,
	saving: boolean,
	history: any,
}

type State = {
	post: Post,
	deleting: boolean,
	pathManuallyChanged: boolean,
}

class Editor extends Component<Props, State> {

	props: Props

	state: State = {
		post: this.props.post || {
			id: null,
			type: this.props.type || 'movie',
			path: '',
			title: '',
			subtitle: '',
			content: {
				text: '',
			},
			link: '',
			rating: 1,
			year: '',
			spoilers: false,
			date_completed: moment(),
			creator: '',
			season: '',
			platform: '',
			published: true,
			tags: [],
		},
		deleting: false,
		pathManuallyChanged: false,
	}

	render() {

		const { post } = this.state

		console.log(moment())

		return (
			<div>
				<h1>
					{this.props.post ? 'Edit Post' : `Add new ${post.type}`}
				</h1>

				<form>
					<FormRow
						label="Title"
						inputKey="post-title"
						input={(
							<TextInput
								value={post.title}
								onChange={v => this.handleTitleChange(v)}
							/>
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

					<ReactMde
						visibility={{
							previewHelp: false,
						}}
						className="almanac-mde"
						commands={ReactMdeCommands.getDefaultCommands()}
						value={post.content}
						onChange={v => this.updatePost('content', v)}
					/>

					<FormRow
						label="Slug"
						inputKey="post-path"
						input={(
							<div className="input-group">
								<span className="input-group-addon almn-input-addon" id="basic-addon3">
									{this.generateStaticPath()}
								</span>
								<TextInput
									value={post.path}
									onChange={v => this.updatePost('path', v)}
								/>
							</div>
						)}
					/>

					<FormRow
						label="Link"
						inputKey="post-link"
						input={(
							<TextInput
								value={post.link}
								onChange={v => this.updatePost('link', v)}
							/>
						)}
					/>

					<Rating
						value={post.rating}
						onChange={v => this.updatePost('rating', v)}
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
								onDayChange={v => this.updatePost('date_completed', moment(v))}
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
							label={post.type === 'comic' ? 'Series' : 'Season'}
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

					{this.state.post.id && (
						<button
							type="button"
							className="btn btn-danger"
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
				</form>
			</div>
		)
	}

	handleSave = () => {
		this.props.onSave({
			...this.state.post,
			date_completed: this.state.post.date_completed.toDate(),
			content: this.state.post.content.text,
		})
	}

	showPlatform = () => this.state.post.type === 'game'
	showCreator = () => ['book', 'music'].includes(this.state.post.type)
	showSeason = () => ['tv', 'comic'].includes(this.state.post.type)

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

	shouldGeneratePath = () => {
		return !this.props.post && !this.state.pathManuallyChanged
	}

	generateStaticPath = () => {
		const year = this.state.post.date_completed.format('YYYY')
		const month = this.state.post.date_completed.format('MM')
		const day = this.state.post.date_completed.format('DD')

		return `/${year}/${month}/${day}/`
	}

	handleTitleChange = (title: string) => {
		const path = this.shouldGeneratePath() ? slugify(title) : this.state.post.path

		this.setState((s: State) => ({
			post: {
				...s.post,
				title,
				path,
			}
		}))
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
