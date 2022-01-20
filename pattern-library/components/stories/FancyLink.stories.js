import React from 'react';

import FancyLinkComponent from '../components/FancyLink';

export default {
  title: 'Components/Links/Fancy Link',
  decorators: [
    (Story) => {
      return (
        <div className="font-sans">
          <Story />
        </div>
      );
    },
  ],
};

export const FancyLink = (args) => {
  return <FancyLinkComponent {...args}>{args.title}</FancyLinkComponent>;
};

FancyLink.args = {
  title: 'Link Title',
  url: '#',
  arrowColor: 'default',
  element: 'a',
  display: 'inline-block',
};

FancyLink.argTypes = {
  arrowColor: {
    name: 'Arrow Color',
    table: {
      type: { summary: 'Background color (text color is automatic)' },
      defaultValue: { summary: 'inherit' },
    },
    options: ['inherit', 'dark', 'light'],
    control: {
      type: 'select',
    },
  },
};
