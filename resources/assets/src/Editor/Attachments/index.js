// @flow

import React from 'react'
import Dropzone from 'react-dropzone'
import FormRow from 'src/ui/Form/Row'
import css from './style.css'
import type { Attachment } from 'src/types'
import AttachmentItem from 'src/Editor/Attachments/Attachment'

type Props = {
    attachments: Attachment[],
    newAttachments: File[],
    handleDelete: (uuid: string) => any,
    handleDeleteNew: (uuid: string) => any,
    addAttachments: (attachments: File[]) => any,
}

class Attachments extends React.Component<Props> {
    render() {
        const { attachments, newAttachments } = this.props
        return (
            <FormRow
                label="Uploads"
                inputKey="uploads"
                input={(
                    <React.Fragment>
                        {this.renderDropzone()}
                        <ul>
                            {newAttachments.map(this.renderAttachment)}
                        </ul>
                        <ul>
                            {attachments.filter((a: Attachment) => a.deleted_at === null).map(this.renderAttachment)}
                        </ul>
                    </React.Fragment>
                )}
            />
        )
    }

    renderDropzone = () => (
        <Dropzone onDrop={acceptedFiles => this.props.addAttachments(acceptedFiles)}>
            {({getRootProps, getInputProps}) => (
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
}

export default Attachments
