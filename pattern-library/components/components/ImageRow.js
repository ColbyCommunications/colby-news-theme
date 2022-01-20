import React from 'react';
// import { renderToString } from 'react-dom/server';
import Figure from './media/Figure';
import MediaRow from './MediaRow';

const ImageRow = (args) => {
  const mediaArgs = args.media ? args.media : {};
  if (!mediaArgs.fit) {
    mediaArgs.fit = 'object-cover';
  }

  const media = args.children
    ? args.children
    : Figure({
        mediaType: 'image',
        mediaSrc: args.mediaSrc,
        mediaAlt: args.mediaAlt,
        media: mediaArgs,
        videoLink: args.video,
        caption: args.caption,
        classes: ['h-full', 'object-cover'],
        stretch: true,
      });

  return <MediaRow {...args}>{media}</MediaRow>;
};

export default ImageRow;
