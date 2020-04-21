/* eslint-disable quotes */
import React, { useState } from 'react';

export default function HeaderSearch() {
    const [isOpen, setIsOpen] = useState(false);
    function open() {
        setIsOpen(true);
    }

    function close() {
        setIsOpen(false);
    }
    return (
        <>
            {isOpen && (
                <form action="https://www.colby.edu/" method="get">
                    <input
                        className="search expandright"
                        id="searchright"
                        type="search"
                        name="s"
                        placeholder="Search"
                    />
                </form>
            )}
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                strokeWidth="2"
                strokeLinecap="round"
                strokeLinejoin="round"
                className="feather feather-search"
                onClick={isOpen ? close : open}
            >
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </>
    );
}
