import React from 'react';
import faker from 'faker';
import ImageRowComponent from '../components/ImageRow';
import RawHTML from '../utilities/RawHTML';
import { TextUtilities } from '../components/content/FormattedText';
import generate from '../components/content/ContentGenerator';

export default { title: 'Components/50-50 Rows/Image Row' };

export const ImageRow = (args) => {
  let links = false;

  if (args.linkCount > 0) {
    links = Array.from({ length: args.linkCount }, () => {
      return {
        title: TextUtilities.headline(5),
        url: faker.internet.url(),
      };
    });
  }

  const imageRow = <ImageRowComponent {...args} links={links} />;
  return <RawHTML component={imageRow} />;

  // return <RawHTML componentFunction={ImageRowComponent} {...args} links={links}></RawHTML>;
};

const defaultImageRowArgs = {
  mediaSide: 'right',
  buttonCount: 0,
  buttonLength: 'short',
  title: `Solve the problems of tomorrow.`,
  body: `<p>Voluptates necessitatibus est <a href="#">nihil eius sed quas</a> ea nisi nulla ut. Beatae corrupti iusto similique est voluptatibus et.</p>
          <ul>
              <li>56 majors and 35 minors</li>
              <li>Prominent centers of thought, impact, and action, plus some other words to force a line break</li>
              <li>Special programs</li>
              <li>Research, internships, and global experiences</li>
          </ul>
        `,
  textColorScheme: 'default',
  button: {
    title: 'Sample Button',
    url: '#button',
  },
};

ImageRow.args = {
  ...defaultImageRowArgs,
  mediaSrc: generate.placeholderSrc(800, 450),
  caption: '',
  backgroundSrc: '',
  inset: true,
  media: {
    fit: 'object-cover',
  },
  linkCount: 2,
  headingElement: 'h2',
};

ImageRow.argTypes = {
  mediaSide: {
    name: 'Media Side',
    options: ['left', 'right'],
    control: {
      type: 'inline-radio',
    },
  },
  buttonLength: {
    name: 'Button Text Length',
    table: {
      defaultValue: 'short',
    },
    options: ['short', 'long'],
    control: {
      type: 'select',
    },
  },
  linkCount: {
    name: 'Link Count',
    table: {
      defaultValue: 0,
    },
    control: {
      type: 'range',
      min: 0,
      max: 5,
    },
  },
  headingElement: {
    name: 'Heading Level',
    table: {
      defaultValue: 'h2',
    },
    options: ['h1', 'h2', 'h3'],
    control: {
      type: 'select',
    },
  },
};
