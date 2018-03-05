// flow

import React from 'react'
import type { Post } from '../types'
import moment from 'moment'
import { Link } from 'react-router-dom'

type Props = {
	currentPage: number,
	totalPages: number,
	changePage: (page: number) => any,
}

const Pagination = ({ currentPage, totalPages, changePage }: Props) => (
	<nav aria-label="Post navigation">
		<ul className="pagination">
			<li className={currentPage === 1 ? 'page-item disabled' : 'page-item'}>
				<a
					href="#"
					className="page-link"
					onClick={() => changePage(currentPage - 1)}
				>
					Previous
				</a>
			</li>
			{Array.from((new Array(totalPages))).map((p, i) => (
				<li
					className={currentPage === i+1 ? 'page-item active' : 'page-item'}
					key={i}
				>
					<a
						href="#"
						className="page-link"
						onClick={() => changePage(i+1)}
					>
						{i+1}
					</a>
				</li>
			))}
			<li className={currentPage === totalPages ? 'page-item disabled' : 'page-item'}>
				<a
					href="#"
					className="page-link"
					onClick={() => changePage(currentPage + 1)}
				>
					Next
				</a>
			</li>
		</ul>
	</nav>
)

export default Pagination
