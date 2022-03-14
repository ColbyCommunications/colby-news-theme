import React from 'react';
import { renderToString } from 'react-dom/server';
import mediaRowTemplate from '../twig/media-row.twig';
import Image from './Image';
import BillboardText from './BillboardText';
import RawHTML from '../utilities/RawHTML';

const MediaRow = (args) => {
  const wrapperClasses = args.className ? args.className : '';

  const backgroundImage = Image({
    src: args.backgroundSrc,
    alt: '',
    classes: [
      'z-0',
      'object-cover',
      'w-full',
      'h-full',
      'absolute',
      'inset-0',
      'opacity-30',
    ],
  });

  const mediaArgs = args.media ? args.media : {};
  if (!mediaArgs.fit) {
    mediaArgs.fit = 'object-cover';
  }

  const textContent = (
    <RawHTML
      componentFunction={BillboardText}
      align="left"
      className={args.textClasses}
      textColorScheme={args.textColorScheme}
      title={args.title}
      headingElement={args.headingElement}
      headingColor={args.headingColor ? args.headingColor : ''}
      headingFont={args.headingFont ? args.headingFont : ''}
      headingFontSize={args.headingFontSize ? args.headingFontSize : ''}
      headingClasses={args.headingClasses ? args.headingClasses : ''}
      gridClasses={args.gridClasses}
      showHR={args.showHR}
      hrColor={args.hrColor}
      button={args.button}
      links={args.links}
      body={args.body}
      force_vertical_padding={args.force_vertical_padding}
    />
  );

  let media = args.children;
  if (typeof media === 'object') {
    media = renderToString(media);
  }

  return mediaRowTemplate({
    ...args,
    media,
    wrapperClasses,
    backgroundImage,
    textContent: renderToString(textContent),
  });
};

export default MediaRow;
