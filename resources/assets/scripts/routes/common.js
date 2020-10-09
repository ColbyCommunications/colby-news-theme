import React from 'react';
import ReactDOM from 'react-dom';
import InTheNews from '../components/InTheNews';
import HeaderSearch from '../components/HeaderSearch';
import Section from '../components/Section';

export default {
    init() {
        // JavaScript to be fired on all pages
        ReactDOM.render(<InTheNews />, document.getElementById('in-the-news'));
        ReactDOM.render(<HeaderSearch />, document.getElementById('search-container'));
        ReactDOM.render(<Section />, document.getElementById('in-the-news-section'));
    },
    finalize() {
        // JavaScript to be fired on all pages, after page specific JS is fired
    },
};
