import React from 'react';
import RawHTML from '../utilities/RawHTML';
import faker from 'faker';
import Image from '../components/Image';
import ColumnBlockTemplate from '../twig/column-block.twig';
import MediaCoverageItemTemplate from '../twig/media-coverage-item.twig';
import MediaCoverageAndEventsTemplate from '../twig/media-coverage-and-events.twig';


export default {
  title: 'Components/Media Coverage And Events',
};

export const MediaCoverageAndEvents = (args) => (
  <RawHTML componentFunction={MediaCoverageAndEventsTemplate} {...args} />
);

MediaCoverageAndEvents.args = {
  mediaCoverage: ColumnBlockTemplate({
    headline: 'Media Coverage',
    items: [
      {
        image: Image({ src: faker.image.image(500, 500) }),
        source: 'United Press International',
        link: { url: '#', title: 'Decoding Perceptions of Sexual Harassment Victims' },
        blurb: `Research on sexual harassment by Jin Goh, assistant professor of psychology, was featured in United Press International and numerous other media outlets. According to the story, the study shows that “women who don’t fit female stereotypes of look or personality are perceived as less credible” in sexual harassment cases.`
      },
      {
        image: Image({ src: faker.image.image(500, 500) }),
        source: 'Portland Press Herald',
        link: { url: '#', title: 'Reflections for Martin Luther King Jr. Day' },
        blurb: null
      },
      {
        image: Image({ src: faker.image.image(500, 500) }),
        source: 'Washington Post',
        link: { url: '#', title: '<i>Washington Post</i> Taps Colby’s Football Coach' },
        blurb: null
      },
      {
        image: Image({ src: faker.image.image(500, 500) }),
        source: 'Art Daily',
        link: { url: '#', title: 'Media Cover Tsiaras Photography Gift Announcement' },
        blurb: null
      }
    ].map(MediaCoverageItemTemplate),
    link: { url: '#', title: 'More in the Media' }
  }),
  events: ColumnBlockTemplate({
    headline: 'Events',
    injectedMarkup: Array(4).fill(/* html */ `<div class="border p-8">JUST A PLACEHOLDER. REAL MARKUP WILL BE PROVIDED BY LIVEWHALE WIDGET</div>`).join(''),
    link: { url: '#', title: 'More Events' }
  })
};

MediaCoverageAndEvents.decorators = [Story => <div className="container"><Story /></div>];