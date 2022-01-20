import React from 'react';
import RawHTML from '../utilities/RawHTML';
import StoryHeaderComponent from '../components/StoryHeader';

export default {
  title: 'Components/Story Header',
};

export const StoryHeader = (args) => {
  if (args.homepage) {
    args.element = 'div';
  }

  return (
    <RawHTML
      componentFunction={StoryHeaderComponent}
      {...args}
    />
  );
};

StoryHeader.args = {
  // just control
  homepage: false,
  video: false,

  // controlled props (component has some uncontrolled props too)
  orientation: 'portrait',
  shareButtonsLast: false,
  link: { title: 'Read More', url: '#' },
  title: 'Something Doesn’t Compute',
  primaryCategory: { url: '#', title: 'Artificial Intelligence' },
  lengthOfRead: '5 Min. Read',
  summary: 'Using art and computer science, Hannah Wolfe reveals tech’s shortcomings.',
  author: 'Laura Meader',
  caption: 'Assistant Professor of Computer Science Hannah Wolfe, left, and Rayna Hata ’23 wear active 3D glasses while exploring the virtual version of Wolfe’s sound installation Cacophonic Choir, set up in Wolfe’s lab in the Runnals Building.',
  photoCredit: 'Photography by Gabe Souza',
  // videoCredit maybe
  contact: {
    name: 'George Sopko',
    email: 'pr@colby.edu',
    phone: '207-859-4346'
  },
  postedDate: 'Sept. 30, 2020',
  updatedDate: 'Jan. 3, 2021',
};

StoryHeader.argTypes = {
  video: {
    name: 'video (for landscape only, 16/9 aspect-ratio)'
  },

  orientation: {
    options: ['portrait', 'landscape'],
    control: {
      type: 'inline-radio',
    },
  },

  link: {
    name: 'link (for homepage only)'
  }
};

StoryHeader.decorators = [Story => <div className="container"><Story /></div>];