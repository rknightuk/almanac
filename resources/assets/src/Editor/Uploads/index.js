// @flow

import React from 'react'
import Dropzone from 'react-dropzone'
import FormRow from 'src/ui/Form/Row'
import css from './style.css'
import type { Attachment, Post } from 'src/types'
import Upload from 'src/Editor/Uploads/Upload'

type Props = {
    attachments: Attachment[],
    newUploads: File[],
    handleDelete: (uuid: string) => any,
    handleDeleteNew: (uuid: string) => any,
    addUploads: (uploads: File[]) => any,
}

class Uploads extends React.Component<Props> {
    render() {
        const { attachments, newUploads } = this.props
        return (
            <FormRow
                label="Uploads"
                inputKey="uploads"
                input={(
                    <React.Fragment>
                        {this.renderDropzone()}
                        <ul>
                            {newUploads.map(this.renderUpload)}
                        </ul>
                        <ul>
                            {attachments.filter((a: Attachment) => a.deleted_at === null).map(this.renderUpload)}
                        </ul>
                    </React.Fragment>
                )}
            />
        )
    }

    renderDropzone = () => (
        <Dropzone onDrop={acceptedFiles => this.props.addUploads(acceptedFiles)}>
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

    renderUpload = (attachment: any) => (
        <Upload
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

export default Uploads
