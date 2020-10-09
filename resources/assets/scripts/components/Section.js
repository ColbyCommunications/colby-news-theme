/* eslint-disable react/no-array-index-key */
/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
/* eslint-disable react/no-danger */
/* eslint-disable jsx-a11y/no-static-element-interactions */
/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable no-return-assign */
/* eslint-disable quotes */
/* eslint-disable jsx-a11y/anchor-is-valid */
import React from 'react';
import Axios from '@colbycommunications/colby-axios';
import Loader from '@colbycommunications/colby-loader';

export default class Section extends React.Component {
    section = document.getElementById('in-the-news-section').getAttribute('data-section');

    constructor(props) {
        super(props);

        this.state = { loading: true, data: [] };
    }

    componentDidMount = () => {
        this.getData();
    };

    getData = async () => {
        const response = await Axios.get('https://www.colby.edu/news/wp-json/news/v1/in-the-news');

        this.setState({
            data: response.data.data,
            loading: false,
        });
    };

    render() {
        let content = '';

        if (this.state.loading) {
            content = <Loader loading type="inline" />;
        } else {
            content = (
                <>
                    {this.state.data.sections[this.section].map((story, index) => (
                        <div key={index} className="row">
                            {story.image && (
                                <>
                                    <div className="col-md-4">image</div>
                                    <div className="col-md-8">text</div>
                                </>
                            )}
                            {!story.image && <div className="col">text</div>}
                        </div>
                    ))}
                </>
            );
        }
        return <div>{content}</div>;
    }
}
