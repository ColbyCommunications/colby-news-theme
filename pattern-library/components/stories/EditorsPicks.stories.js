import React from 'react';
import RawHTML from '../utilities/RawHTML';
import faker from 'faker';
import Image from '../components/Image';
import TeaserPairWithSlidingTeasersTemplate from '../twig/teaser-pair-with-sliding-teasers.twig';
import TeaserPairTemplate from '../twig/teaser-pair.twig';
import TeaserTemplate from '../twig/teaser.twig';
import SlidingTeasersTemplate from '../twig/sliding-teasers.twig';
import { SlidingTeasers } from './SlidingTeasers.stories';

export default {
  title: 'Components/Editors Picks',
};

export const EditorsPicks = (args) => (
  <RawHTML componentFunction={TeaserPairWithSlidingTeasersTemplate} {...args} />
);

EditorsPicks.args = {
  headline: `Editor's Picks`,
  teaserPair: TeaserPairTemplate({
    teasers: [
      {
        image: Image({ src: faker.image.image(1000, 600) }),
        withVideoLogo: false,
        url: '#',
        superhead: { title: 'Alumni', url: '#' },
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
      },
      {
        image: Image({ src: faker.image.image(1000, 600) }),
        withVideoLogo: true,
        url: '#',
        superhead: { title: 'Campus and Community', url: '#' },
        title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
      }
    ].map(TeaserTemplate)
  }),
  slidingTeasers: SlidingTeasersTemplate({ ...SlidingTeasers.args, headline: null })
};

EditorsPicks.decorators = [Story => <div className="container"><Story /></div>];