import React from 'react'

type Props = {
    label: string,
    inputKey: string,
    input: any,
}

const FormRow = ({ label, inputKey, input }: Props) => (
    <div className="form-group row">
        <label htmlFor={inputKey} className="col-sm-2 col-form-label">
            {label}
        </label>
        <div className="col-sm-10">
            {input}
        </div>
    </div>
)

export default FormRow
