import React from 'react'
import cx from 'classnames'
import css from './style.css'

type Props = {
	type: 'danger' | 'success',
	onClick: () => any,
	disabled?: boolean,
	saving?: boolean,
	savingText?: string,
	className?: string,
}

const Button = ({
	type,
	onClick,
	disabled,
	saving,
	savingText,
	className,
	children,
}: Props) => (
	<button
		type="button"
		className={cx(
			type === 'success' ? css.buttonSuccess : css.buttonDanger,
			className,
		)}
		onClick={onClick}
		disabled={disabled}
	>
		{saving && (
			<span>
				<i className="fas fa-spinner fa-spin" data-fa-transform="grow-6" />{' '}
				{savingText || 'Saving'}
			</span>
		)}
		{!saving && <React.Fragment>{children}</React.Fragment>}
	</button>
)

export default Button
