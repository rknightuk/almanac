// @flow

import React from 'react'
import Dropzone from 'react-dropzone'
import FormRow from 'src/ui/Form/Row'
import css from './style.css'
import type { Attachment } from 'src/types'
import AttachmentItem, { DeleteButton } from './Attachment'
import type { AttachmentWithId } from 'src/Editor/Editor'
import { SortableContainer, SortableElement } from 'react-sortable-hoc'
import arrayMove from 'array-move'

type Props = {
	attachments: Attachment[],
	newAttachments: AttachmentWithId[],
	handleDelete: (uuid: string) => any,
	handleDeleteNew: (uuid: string) => any,
	addAttachments: (attachments: File[]) => any,
	reorderAttachments: (attachments: Attachment[]) => void,
}

const SortableItem = SortableElement(({ value, uuid }) => (
    <AttachmentItem
        uuid={uuid}
        title={value}
    />
))

const SortableList = SortableContainer(({ attachments, onDelete }) => {
	return (
		<ul>
			{attachments.map((attachment, index) => (
			    <div className={css.sortableItem}>
                    <DeleteButton onDelete={() => onDelete(attachment.uuid)} />
                    <SortableItem
                        key={`item-${attachment.id}`}
                        index={index}
                        value={attachment.filename}
                        uuid={attachment.uuid}
                    />
                </div>
			))}
		</ul>
	)
})

class Attachments extends React.Component<Props> {
	render() {
		const { attachments, newAttachments } = this.props
		return (
			<FormRow
				label="Uploads"
				inputKey="uploads"
				input={
					<React.Fragment>
						{this.renderDropzone()}
						<ul>{newAttachments.map(this.renderAttachment)}</ul>
						<SortableList
							attachments={attachments.filter(
								(a: Attachment) => a.deleted_at === null,
							)}
							onSortEnd={this.onSortEnd}
							onDelete={this.handleDelete}
						/>
					</React.Fragment>
				}
			/>
		)
	}

	renderDropzone = () => (
		<Dropzone
			onDrop={(acceptedFiles) => this.props.addAttachments(acceptedFiles)}
		>
			{({ getRootProps, getInputProps }) => (
				<div className={css.dropzone}>
					<div {...getRootProps()}>
						<input {...getInputProps()} />
						<p>Add some photos</p>
					</div>
				</div>
			)}
		</Dropzone>
	)

	renderAttachment = (attachment: any) => (
		<AttachmentItem
			uuid={attachment.uuid}
			title={attachment.filename || attachment.file.name}
			onDelete={attachment.filename ? this.handleDelete : this.handleDeleteNew}
		/>
	)

	handleDelete = (uuid: string) => {
		this.props.handleDelete(uuid)
	}

	handleDeleteNew = (uuid: string) => {
		this.props.handleDeleteNew(uuid)
	}

	onSortEnd = ({
		oldIndex,
		newIndex,
	}: {
		oldIndex: number,
		newIndex: number,
	}) => {
		this.props.reorderAttachments(
			arrayMove(this.props.attachments, oldIndex, newIndex),
		)
	}
}

export default Attachments
