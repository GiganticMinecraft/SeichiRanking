import React, {Component} from 'react';

/**
 * 最初と最後のにあるページボタンの定数
 *
 * 例えばこれが2, currentPage=10, titakPages=20の時、
 * | << | 1 | 2 | ... | 10 | ... | 19 | 20 | >> |
 * といったような表示になる
 */
const terminal_button_num = 2;

/**
 * 現ページの周辺にあるページボタンの定数
 *
 * 例えばこれが2, currentPage=10, titakPages=20, terminal_button_num = 1 の時、
 * | << | 1 | ... | 8 | 9 | 10 | 11 | 12 | ... | 20 | >> |
 * といったような表示になる
 */
const middle_button_num = 3;

export default class Pagination extends Component {
    static _getDisabledButton(text, key=text) {
        return (
            <li className="disabled" key={`disabled-${key}`}>
                <span>{text}</span>
            </li>
        )
    }

    /**
     * ページを前に戻すボタンを取得する
     * @returns {*}
     * @private
     */
    _getPrevButton() {
        const current_page = this.props.currentPage;

        if (current_page === 1) {
            return Pagination._getDisabledButton("«");
        }

        return (
            <li className="clickable" key={`prev-${current_page}`}>
                <a onClick={ () => this.props.onPageChange(current_page - 1) }>«</a>
            </li>
        );
    }

    /**
     * ページを次に進めるボタンを取得する
     * @returns {*}
     * @private
     */
    _getNextButton() {
        const current_page = this.props.currentPage;
        const total_pages = this.props.totalPages;

        if (current_page === total_pages) {
            return Pagination._getDisabledButton("»");
        }

        return (
            <li className="clickable" key={`next-${current_page}`}>
                <a onClick={ () => this.props.onPageChange(current_page + 1) }>»</a>
            </li>
        );
    }

    /**
     * ページを指定のページに移すボタンを取得する
     * @returns {*}
     * @private
     */
    _getPageButton(page) {
        if (page === this.props.currentPage) {
            return (
                <li className="active" key={page}>
                    <span>{page}</span>
                </li>
            )
        }

        return (
            <li className="clickable" key={page}>
                <a onClick={ () => this.props.onPageChange(page) }>{page}</a>
            </li>
        )
    }

    /**
     * totalPages, currentPageなどから指定のページのボタンが表示されるべきかを判定する
     * @param page ページ番号
     * @returns boolean 指定ページのボタンが表示されるべき場合のみtrue
     * @private
     */
    _isPageButtonDisplayed(page) {
        // ページが先端又は終端の場合
        if (page <= terminal_button_num || (this.props.totalPages - page) < terminal_button_num) {
            return true;
        }

        // ページが現在ページの周辺にある場合
        if (Math.abs(this.props.currentPage - page) <= middle_button_num) {
            return true;
        }

        return false;
    }

    render() {
        const displayPageButtonArray = [];
        let disabledButtonAtEnd = false;
        for (let page = 1; page <= this.props.totalPages; page++) {
            if (this._isPageButtonDisplayed(page)) {
                displayPageButtonArray.push(this._getPageButton(page));
                disabledButtonAtEnd = false;
            } else if (!disabledButtonAtEnd) {
                displayPageButtonArray.push(Pagination._getDisabledButton("...", page));
                disabledButtonAtEnd = true;
            }
        }

        return (
            <ul className="pagination">
                {this._getPrevButton()}
                {displayPageButtonArray}
                {this._getNextButton()}
            </ul>
        );
    }
}