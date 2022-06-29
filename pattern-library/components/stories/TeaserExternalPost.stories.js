import React from 'react';
import RawHTML from '../utilities/RawHTML';
import faker from 'faker';
import Image from '../components/Image';
import TeaserExternalPostTemplate from '../twig/teaser-external_post.twig';

export default {
  title: 'Components/Teaser External Post',
};

export const TeaserExternalPost = (args) => {
  const postArgs = {
    post: args,
  };

  return (
    <RawHTML componentFunction={TeaserExternalPostTemplate} {...postArgs} />
  );
};

TeaserExternalPost.args = {
  variant: 'split',
  link: {
    url: '#',
    title: 'Decoding Perceptions of Sexual Harassment Victims',
  },
  source: 'United Press International',
  blurb: `Research on sexual harassment by Jin Goh, assistant professor of psychology, was featured in United Press International and numerous other media outlets. According to the story, the study shows that “women who don’t fit female stereotypes of look or personality are perceived as less credible” in sexual harassment cases.`,
  image: Image({ src: faker.image.image(500, 500) }),
};

TeaserExternalPost.argTypes = {
  variant: {
    options: ['plain', 'featured', 'split'],
    type: 'select',
  },
};

TeaserExternalPost.decorators = [
  (Story, { args: { variant } }) => (
    <div className="container">
      {variant === 'split' ? (
        <div className="lg:w-1/2">
          <Story />
        </div>
      ) : (
        <Story />
      )}
    </div>
  ),
];
