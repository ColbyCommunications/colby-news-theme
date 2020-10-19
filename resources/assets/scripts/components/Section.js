/* eslint-disable no-console */
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

import { TextBlock, RectShape } from 'react-placeholder/lib/placeholders';

import Style from './style.css';

const Placeholder = () => {
    const items = [];

    for (let i = 0; i < 10; i++) {
        items.push(
            <>
                <div className="col-md-3">
                    <RectShape style={{ width: '100%', height: '200px' }} />
                </div>
                <div className="col-md-9">
                    <TextBlock rows={5} />
                </div>
            </>
        );
    }
    return (
        <>
            {items}
        </>
    )

    };

export default class Section extends React.Component {
    section = document.getElementById('in-the-news-section').getAttribute('data-section');

    constructor(props) {
        super(props);

        this.state = { loading: true, data: [], limit: 10, hasLoaded: false };
    }

    componentDidMount = () => {
        this.getData();
    };

    getData = async () => {
        const response = await Axios.get('https://www.colby.edu/news/wp-json/news/v1/in-the-news');

        this.setState({
            data: response.data.data,
            loading: false,
            hasLoaded: true,
        });
    };

    onLoadMore = () => {
        // eslint-disable-next-line arrow-body-style
        this.setState(prevState => ({ limit: prevState.limit + 10 }));
    };

    render() {
        // let content = '';

        
        // content = (
            
        // );

        return (
            <>
                <Loader loading={this.state.loading} type="skeleton" skeletonTemplate={Placeholder}>
                    <>
                        {this.state.data.sections[this.section]
                            .slice(0, this.state.limit)
                            .map((story, index) => {
                                let formattedSource = '';
                                if (story.meta.source_name) {
                                    formattedSource = story.meta.source_name[0]
                                        .toLowerCase()
                                        .replaceAll(' ', '_');
                                }

                                return (
                                    <div key={index} className="row mb-4">
                                        {story.image && (
                                            <>
                                                <div className="col-md-3">
                                                    <img
                                                        className={`img-fluid ${Style.sectionImg}`}
                                                        src={story.image[0]}
                                                        alt={story.post_title}
                                                        onClick={() =>
                                                            (window.location =
                                                                story.meta.in_the_news_external_link)
                                                        }
                                                        style={{ cursor: 'pointer' }}
                                                    />
                                                </div>
                                                <div className="col-md-9">
                                                    <h3
                                                        className={Style.sectionHeadline}
                                                        dangerouslySetInnerHTML={{
                                                            __html: story.post_title,
                                                        }}
                                                        onClick={() =>
                                                            (window.location =
                                                                story.meta.in_the_news_external_link)
                                                        }
                                                    />
                                                    <p
                                                        style={{
                                                            fontFamily:
                                                                'franklin-gothic-urw, sans-serif',
                                                        }}
                                                        dangerouslySetInnerHTML={{
                                                            __html: `${story.post_content.substring(
                                                                0,
                                                                500
                                                            )}...`,
                                                        }}
                                                    />
                                                    <p>
                                                        <medium className="text-muted">
                                                            {story.meta.source_name}
                                                        </medium>
                                                    </p>
                                                </div>
                                            </>
                                        )}
                                        {!story.image && (
                                            <>
                                                <div className="col-md-3">
                                                    {formattedSource &&
                                                        formattedSource in
                                                            window.ColbyNews.availableLogos && (
                                                            <img
                                                                src={
                                                                    window.ColbyNews.availableLogos[
                                                                        formattedSource
                                                                    ]
                                                                }
                                                                alt={story.post_title}
                                                                onClick={() =>
                                                                    (window.location =
                                                                        story.meta.in_the_news_external_link)
                                                                }
                                                                style={{ cursor: 'pointer' }}
                                                                className={`img-fluid ${Style.sectionImg}`}
                                                            />
                                                        )}
                                                    {!(
                                                        formattedSource in
                                                        window.ColbyNews.availableLogos
                                                    ) && (
                                                        <img
                                                            src={window.ColbyNews.defaultImagePath}
                                                            alt={story.post_title}
                                                            onClick={() =>
                                                                (window.location =
                                                                    story.meta.in_the_news_external_link)
                                                            }
                                                            style={{ cursor: 'pointer' }}
                                                            className={`img-fluid ${Style.sectionImg}`}
                                                        />
                                                    )}
                                                </div>
                                                <div className="col-md-9">
                                                    <h3
                                                        className={Style.sectionHeadline}
                                                        dangerouslySetInnerHTML={{
                                                            __html: story.post_title,
                                                        }}
                                                        onClick={() =>
                                                            (window.location =
                                                                story.meta.in_the_news_external_link)
                                                        }
                                                    />
                                                    <p
                                                        style={{
                                                            fontFamily:
                                                                'franklin-gothic-urw, sans-serif',
                                                        }}
                                                        dangerouslySetInnerHTML={{
                                                            __html: `${story.post_content.substring(
                                                                0,
                                                                500
                                                            )}...`,
                                                        }}
                                                    />
                                                    <p>
                                                        <medium className="text-muted">
                                                            {story.meta.source_name}
                                                        </medium>
                                                    </p>
                                                </div>
                                            </>
                                        )}
                                    </div>
                                );
                            })}
                    </>
                </Loader>
                {this.state.hasLoaded && (
                    <div className="text-center">
                        <button type="button" className="btn btn-primary" onClick={this.onLoadMore}>
                            Load More
                        </button>
                    </div>
                )}
            </>
        );
    }
}
