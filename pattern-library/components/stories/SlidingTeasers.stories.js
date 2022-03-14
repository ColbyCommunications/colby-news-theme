import React from 'react';
import RawHTML from '../utilities/RawHTML';
import faker from 'faker';
import Image from '../components/Image';
import SlidingTeasersTemplate from '../twig/sliding-teasers.twig';
import TeaserTemplate from '../twig/teaser.twig';

export default {
  title: 'Components/Sliding Teasers',
};

export const SlidingTeasers = (args) => (
  <RawHTML componentFunction={SlidingTeasersTemplate} {...args} />
);

SlidingTeasers.args = {
  large: false,
  headline: 'Sliding Teasers',
  teasers: [
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: false,
      url: '#',
      superhead: { title: 'Artificial Intelligence', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: false,
      url: '#',
      superhead: { title: 'Natural Sciences', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: true,
      url: '#',
      superhead: { title: 'Social Sciences', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: false,
      url: '#',
      superhead: { title: 'Campus and Community', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: true,
      url: '#',
      superhead: { title: 'Artificial Intelligence', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: false,
      url: '#',
      superhead: { title: 'Natural Sciences', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: false,
      url: '#',
      superhead: { title: 'Social Sciences', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
    {
      image: Image({ src: faker.image.image(494, 298) }),
      withVideoLogo: false,
      url: '#',
      superhead: { title: 'Campus and Community', url: '#' },
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      description: null,
    },
  ].map(TeaserTemplate),
};

SlidingTeasers.decorators = [
  (Story) => (
    <div className="container">
      <Story />
    </div>
  ),
];
