/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
/* eslint-disable react/no-danger */
/* eslint-disable jsx-a11y/no-static-element-interactions */
/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable no-return-assign */
/* eslint-disable quotes */
/* eslint-disable jsx-a11y/anchor-is-valid */
import React from 'react';
import MasonryTabs from '@colbycommunications/colby-masonry-tabs';
import Axios from '@colbycommunications/colby-axios';
import Loader from '@colbycommunications/colby-loader';

import style from './style.css';

export default class InTheNews extends React.Component {
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

    renderTopStory = () => {
        // eslint-disable-next-line camelcase
        const { featured_story } = this.state.data;

        let jumbotronStyles = {};
        if (featured_story.image) {
            jumbotronStyles = {
                backgroundImage: `url("${this.state.data.featured_story.image[0]}")`,
                backgroundSize: 'cover',
                position: 'relative',
                backgroundPosition: 'top center',
                cursor: 'pointer',
            };
        } else {
            jumbotronStyles = {
                backgroundImage: `url("${window.ColbyNews.defaultImagePath}")`,
                backgroundSize: 'cover',
                position: 'relative',
                backgroundPosition: 'center center',
                cursor: 'pointer',
            };
        }

        return (
            <div
                className={style.featuredStory}
                style={jumbotronStyles}
                onClick={() => (window.location = featured_story.meta.in_the_news_external_link)}
            >
                <div className={style.postHeader}>
                    <h2
                        dangerouslySetInnerHTML={{
                            __html: this.state.data.featured_story.post_title,
                        }}
                    />
                    <div className={style.postDate}>
                        <span className="post_info_date">
                            {this.state.data.featured_story.meta.source_name}
                        </span>
                    </div>
                </div>
            </div>
        );
    };

    render() {
        let content = '';

        if (this.state.loading) {
            content = <Loader loading type="inline" />;
        } else {
            content = (
                <>
                    <div className="row">
                        <div className="col">{this.renderTopStory()}</div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="card mb-4 colby-spotlight-card">
                                {this.state.data.spotlight_stories[0].image && (
                                    <img
                                        className="card-img-top"
                                        src={this.state.data.spotlight_stories[0].image[0]}
                                        alt={this.state.data.spotlight_stories[0].post_title}
                                        onClick={() =>
                                            (window.location = this.state.data.spotlight_stories[0].meta.in_the_news_external_link)
                                        }
                                        style={{ cursor: 'pointer' }}
                                    />
                                )}

                                {!this.state.data.spotlight_stories[0].image && (
                                    <img
                                        className="card-img-top"
                                        src={window.ColbyNews.defaultImagePath}
                                        alt="Colby In the News"
                                        onClick={() =>
                                            (window.location = this.state.data.spotlight_stories[0].meta.in_the_news_external_link)
                                        }
                                        style={{ cursor: 'pointer' }}
                                    />
                                )}

                                <div className="card-body">
                                    <h5 className="card-title">
                                        <span
                                            dangerouslySetInnerHTML={{
                                                __html: this.state.data.spotlight_stories[0]
                                                    .post_title,
                                            }}
                                        />
                                    </h5>
                                    <p className="card-text">
                                        <span
                                            style={{
                                                fontFamily: 'franklin-gothic-urw, sans-serif',
                                            }}
                                            dangerouslySetInnerHTML={{
                                                __html: `${this.state.data.spotlight_stories[0].post_content.substring(
                                                    0,
                                                    240
                                                )}...`,
                                            }}
                                        />
                                    </p>
                                    <p className="card-text">
                                        <medium className="text-muted">
                                            {this.state.data.spotlight_stories[0].meta.source_name}
                                        </medium>
                                    </p>
                                    <p className="card-text text-right">
                                        <a
                                            href={
                                                this.state.data.spotlight_stories[0].meta
                                                    .in_the_news_external_link
                                            }
                                        >
                                            Read More{' '}
                                            <span>
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    strokeWidth="2"
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    className="feather feather-chevrons-right"
                                                >
                                                    <polyline points="13 17 18 12 13 7" />
                                                    <polyline points="6 17 11 12 6 7" />
                                                </svg>
                                            </span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div className="card mb-4 colby-spotlight-card">
                                {this.state.data.spotlight_stories[1].image && (
                                    <img
                                        className="card-img-top"
                                        src={this.state.data.spotlight_stories[1].image[0]}
                                        alt={this.state.data.spotlight_stories[1].post_title}
                                        onClick={() =>
                                            (window.location = this.state.data.spotlight_stories[1].meta.in_the_news_external_link)
                                        }
                                        style={{ cursor: 'pointer' }}
                                    />
                                )}

                                {!this.state.data.spotlight_stories[1].image && (
                                    <img
                                        className="card-img-top"
                                        src={window.ColbyNews.defaultImagePath}
                                        alt="Colby In the News"
                                        onClick={() =>
                                            (window.location = this.state.data.spotlight_stories[1].meta.in_the_news_external_link)
                                        }
                                        style={{ cursor: 'pointer' }}
                                    />
                                )}

                                <div className="card-body">
                                    <h5 className="card-title">
                                        <span
                                            dangerouslySetInnerHTML={{
                                                __html: this.state.data.spotlight_stories[1]
                                                    .post_title,
                                            }}
                                        />
                                    </h5>
                                    <p className="card-text">
                                        <span
                                            style={{
                                                fontFamily: 'franklin-gothic-urw, sans-serif',
                                            }}
                                            dangerouslySetInnerHTML={{
                                                __html: `${this.state.data.spotlight_stories[1].post_content.substring(
                                                    0,
                                                    240
                                                )}...`,
                                            }}
                                        />
                                    </p>
                                    <p className="card-text">
                                        <medium className="text-muted">
                                            {this.state.data.spotlight_stories[1].meta.source_name}
                                        </medium>
                                    </p>
                                    <p className="card-text text-right">
                                        <a
                                            href={
                                                this.state.data.spotlight_stories[1].meta
                                                    .in_the_news_external_link
                                            }
                                        >
                                            Read More{' '}
                                            <span>
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="15"
                                                    height="15"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    strokeWidth="2"
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    className="feather feather-chevrons-right"
                                                >
                                                    <polyline points="13 17 18 12 13 7" />
                                                    <polyline points="6 17 11 12 6 7" />
                                                </svg>
                                            </span>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col">
                            <h2>More From In the News</h2>
                            <MasonryTabs
                                tabList={[
                                    {
                                        name: 'one',
                                        title: 'The College',
                                        endpoint:
                                            'https://www.colby.edu/news/wp-json/wp/v2/posts/?per_page=100&categories=271',
                                        fields: {
                                            id: 'id',
                                            title: 'title.rendered',
                                            excerpt: 'excerpt.rendered',
                                            image: 'thumbnail[0]',
                                            source: 'meta.source_name[0]',
                                            link: 'meta.in_the_news_external_link',
                                        },
                                        type: 'card',
                                    },
                                    {
                                        name: 'two',
                                        title: 'Our Alumni',
                                        endpoint:
                                            'https://www.colby.edu/news/wp-json/wp/v2/posts/?per_page=100&categories=272',
                                        fields: {
                                            id: 'id',
                                            title: 'title.rendered',
                                            excerpt: 'excerpt.rendered',
                                            image: 'thumbnail[0]',
                                            source: 'meta.source_name[0]',
                                            link: 'meta.in_the_news_external_link',
                                        },
                                        type: 'card',
                                    },
                                ]}
                            />
                        </div>
                    </div>
                </>
            );
        }
        return (
            <div>
                <div className="row">
                    <div className="col" style={{ margin: '2rem 0' }}>
                        <h1 className="display-4">In the News</h1>
                    </div>
                </div>
                {content}
            </div>
        );
    }
}
