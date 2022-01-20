import '/app/dist/css/tailwind.css';
import 'slick-carousel';
import iconSprites from '!!raw-loader!/app/dist/icons/icon-sprites.svg';
import { addDecorator } from '@storybook/react';

const customViewports = {
  xxs: {
    name: 'Tiny (< 392px)',
    styles: {
      width: '330px',
      height: '100%',
    },
  },
  xs: {
    name: 'Extra Small (392px - 511px)',
    styles: {
      width: '400px',
      height: '100%',
    },
  },
  sm: {
    name: 'Small (512px - 639px)',
    styles: {
      width: '520px',
      height: '100%',
    },
  },
  md: {
    name: 'Medium (640px - 831px)',
    styles: {
      width: '670px',
      height: '100%',
    },
  },
  lg: {
    name: 'Large (832px - 1055px)',
    styles: {
      width: '860px',
      height: '100%',
    },
  },
  xl: {
    name: 'Extra Large (1056px- 1231px)',
    styles: {
      width: '1080px',
      height: '100%',
    },
  },
  max: {
    name: 'Extremely Large (1232px +)',
    styles: {
      width: '1240px',
      height: '100%',
    },
  },
};

export const customParameters = {
  options: {
    storySort: {
      order: ['Page Demos', 'Component Demos', 'Components'],
    },
  },
  viewport: {
    viewports: customViewports,
  },
};

export const customDecorators = [
  (Story) => (
    <>
      <div
        className="hidden"
        dangerouslySetInnerHTML={{
          __html: iconSprites,
        }}
      ></div>
      <Story />
    </>
  ),
];
