import React from 'react';
import RawHTML from '../utilities/RawHTML';
import faker from 'faker';
import Image from '../components/Image';
import TeaserPairWithSlidingTeasersTemplate from '../twig/teaser-pair-with-sliding-teasers.twig';
import TeaserPairTemplate from '../twig/teaser-pair.twig';
import TeaserTemplate from '../twig/teaser.twig';
import SlidingTeasersTemplate from '../twig/sliding-teasers.twig';

export default {
  title: 'Components/Video List',
};

export const VideoList = (args) => (
  <RawHTML componentFunction={TeaserPairWithSlidingTeasersTemplate} {...args} />
);

VideoList.args = {
  headline: `Videos`,
  teaserPair: TeaserPairTemplate({
    teasers: [
      {
        image: Image({ src: faker.image.image(1000, 600) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Short title',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
      },
      {
        image: Image({ src: faker.image.image(1000, 600) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'This title is quite long, definitely longer than any of the others, and this is important so that we can see what happens with all the line-wrapping',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
      }
    ].map(TeaserTemplate)
  }),
  slidingTeasers: SlidingTeasersTemplate({
    large: true,
    headline: null,
    teasers: [
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Short title',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'This title is quite long, definitely longer than any of the others, and this is important so that we can see what happens with all the line-wrapping',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: null,
      },
      {
        image: Image({ src: faker.image.image(494, 298) }),
        withVideoLogo: true,
        url: '#',
        superhead: null,
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: null,
      },
    ].map(TeaserTemplate)
  })
};

VideoList.decorators = [Story => <div className="container"><Story /></div>];