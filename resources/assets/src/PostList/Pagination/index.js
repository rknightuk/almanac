// flow

import React from 'react'
import css from './style.css'

type Props = {
    currentPage: number,
    totalPages: number,
    changePage: (page: number) => any,
}

class Pagination extends React.Component<Props> {
    renderLink = (page: number) => (
        <div
            className={this.props.currentPage === page ? 'page-item active' : 'page-item'}
            key={page}
        >
            <a
                href="#"
                className="page-link"
                onClick={() => this.props.changePage(page)}
            >
                {page}
            </a>
        </div>
    )
    render() {
        const { currentPage, totalPages, changePage } = this.props
        const hasMoreThanSixPages = totalPages > 6

        return (
            <nav aria-label="Post navigation" className={css.wrapper}>
                <div className={currentPage === 1 ? 'page-item disabled' : 'page-item'}>
                    <a
                        href="#"
                        className="page-link"
                        onClick={() => changePage(currentPage - 1)}
                    >
                        Older
                    </a>
                </div>
                {Array.from((new Array(hasMoreThanSixPages ? 3 : totalPages))).map((p, i) => (
                    this.renderLink(i+1)
                ))}
                {hasMoreThanSixPages && (<div>...</div>)}
                {hasMoreThanSixPages && [totalPages - 2, totalPages - 1, totalPages].map((p) => (
                    this.renderLink(p)
                ))}
                <div className={currentPage === totalPages ? 'page-item disabled' : 'page-item'}>
                    <a
                        href="#"
                        className="page-link"
                        onClick={() => changePage(currentPage + 1)}
                    >
                        Newer
                    </a>
                </div>
            </nav>
        )
    }
}

export default Pagination
