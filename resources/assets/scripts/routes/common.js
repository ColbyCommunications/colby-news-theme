import React from 'react';
import ReactDOM from 'react-dom';
import InTheNews from '../components/InTheNews';
import HeaderSearch from '../components/HeaderSearch';

export default {
    init() {
        // JavaScript to be fired on all pages
        ReactDOM.render(<InTheNews />, document.getElementById('in-the-news'));
        ReactDOM.render(<HeaderSearch />, document.getElementById('search-container'));
    },
    finalize() {
        // JavaScript to be fired on all pages, after page specific JS is fired
    },
};
