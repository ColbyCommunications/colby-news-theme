import React from 'react';
import faker from 'faker';
import Image from '../components/Image';
import RawHTML from '../utilities/RawHTML';
import RelatedStoriesComponent from '../components/RelatedStories';

export default { title: 'Components/Related Stories' };

export const RelatedStories = (args) => (
  <RawHTML
    componentFunction={RelatedStoriesComponent}
    {...args}
  />
);

RelatedStories.args = {
  headline: 'Related',
  items: [
    {
      image: Image({ src: faker.image.image(750, 450) }),
      title: 'The Mystery of Infection',
      url: '#',
      description: `Suegene Noh’s new study seeks to uncover how and why amoebas react differently to the same bacteria`
    },
    {
      image: Image({ src: faker.image.image(750, 450) }),
      title: 'Leaping Into the Forefront of Biochemistry Research',
      url: '#',
      description: `Pay It Northward—and a Colby-prepared scientist— leads Maria Armillei to timely opportunity`
    },
    {
      image: Image({ src: faker.image.image(750, 450) }),
      title: 'Left Brain / Right Brain',
      url: '#',
      description: `Andie Velazquez melds studio art and neurobiology—perfectly`
    },
    {
      image: Image({ src: faker.image.image(750, 450) }),
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      url: '#',
      description: `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.`
    },
    {
      image: Image({ src: faker.image.image(750, 450) }),
      title: 'Lorem ipsum dolor sit amet, consect etur adipiscing',
      url: '#',
      description: `Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt`
    },
  ]
};