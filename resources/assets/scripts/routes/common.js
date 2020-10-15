/* eslint-disable no-console */
import React from 'react';
import ReactDOM from 'react-dom';
import InTheNews from '../components/InTheNews';
import HeaderSearch from '../components/HeaderSearch';
import Section from '../components/Section';

console.log(document.getElementById('in-the-news-section'));
export default {
    init() {
        // JavaScript to be fired on all pages
        ReactDOM.render(<HeaderSearch />, document.getElementById('search-container'));

        if (document.querySelector('#in-the-news')) {
            ReactDOM.render(<InTheNews />, document.getElementById('in-the-news'));
        }

        if (document.querySelector('#in-the-news-section')) {
            ReactDOM.render(<Section />, document.getElementById('in-the-news-section'));
        }
    },
    finalize() {
        // JavaScript to be fired on all pages, after page specific JS is fired
    },
};
